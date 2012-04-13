<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Manage extends CI_Controller {
			
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
		}
	
	
		/*
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		/*
		 * Called by a cron job to send email alerts.
		 * 
		 * - this basically finds any coursework objects where the due date
		 *   is less than five days form now, and no alert has been sent
		 * - it then sends an email and changes the status to "alert_sent"
		 */
		public function send_alerts()
		{
			$coursework = Model\Coursework::where(array(
				'status_id <' => Model\Status::HANDED_IN,
				'due_date <=' => addDays(5,time('Y-m-d')),
				'alert_sent' => 0))
				->with('users')
				->all();
				
			$total_cw = 0;
			$email_cw = 0;

			// load the email library
			$this->load->library('PostageApp');
			
			// loop through our coursework and set the alert
			foreach($coursework as $cw)
			{
				if ($this->usr->profile()->emails_allowed)
				{
					// send the email
					$this->postageapp->from('info@williamhart.info');
					$this->postageapp->to($cw->user()->email);
					$this->postageapp->subject('GradeBoss Alert - Upcoming Coursework!');
					$this->postageapp->message('<p>Hi, this is just a friendly alert to let you know that you have some coursework due in the next five days.</p>');
					$this->postageapp->template('sample_parent_layout');
					$this->postageapp->variables(array('name'=>$cw->user()->email));
					$this->postageapp->send();
					
					$email_cw++;
				}
				
				// flag the alert as sent regardless of whether an email was sent
				$cw->alert_sent = 1;
				$cw->save(); 
				
				$total_cw++;
			}
			
			echo "Emailed $email_cw users about coursework and unflagged $total_cw coursework records";
		}

		public function unsubscribe($code = NULL)
		{
			$user_prof = Model\Profile::find_by_unsubscribe_code($code, 1);
			
			if (empty($user_prof))
			{
				// show the user and error screen and call for them to login
				$data['content'] = $this->load->view('profile/unsubscribe_error',NULL,TRUE);
			}
			else
			{
				// perform the unsubscribe
				$user_prof->allow_emails = 0;
				$user_prof->save();
				
				// send a confirmation email
				$this->postageapp->from('info@williamhart.info');
				$this->postageapp->to($user_prof->user()->email);
				$this->postageapp->subject('GradeBoss Alert - Email alerts turned off!');
				$this->postageapp->message('<p>Hi,</p><p>This is just letting you know that you have recently unsubscribed from email alerts through GradeKeep.  These can be turned back on at any time through your profile.</p>');
				$this->postageapp->template('sample_parent_layout');
				$this->postageapp->variables(array('name'=>$user_prof->first_name));
				$this->postageapp->send();
				
				// load the success view
				$data['content'] = $this->load->view('profile/unsubscribe_success', NULL, TRUE);
			}
			
			// load the main view
			$this->load->view('template',$data);	
		}
	}
	

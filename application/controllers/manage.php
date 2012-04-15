<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Manage extends CI_Controller {
			
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// load the email library
			$this->load->library('PostageApp');
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

			
			// loop through our coursework and set the alert
			foreach($coursework as $cw)
			{
				if ($this->usr->profile()->emails_allowed)
				{
					// send the email
					$this->postageapp->from('info@gradekeep.com');
					$this->postageapp->to($cw->user()->email);
					$this->postageapp->subject('GradeBoss Alert - Upcoming Coursework!');
					$this->postageapp->message($this->load->view('emails/coursework_alert',array('coursework'=>$cw),TRUE));
					$this->postageapp->template('sample_parent_layout');
					$this->postageapp->variables(array(
						'name'=>$cw->user()->profile()->first_name,
						'unsub_code'=>$cw->user()->profile()->unsubscribe_code
					));
					$this->postageapp->send();
					
					$email_cw++;
				}
				
				// flag the alert as sent regardless of whether an email was sent
				$cw->alert_sent = 1;
				$cw->save(); 
				
				$total_cw++;
			}
		}

		public function unsubscribe($code = NULL)
		{
			$user_prof = Model\Profile::find_by_unsubscribe_code($code, 1);
			
			if (empty($user_prof) OR is_null($user_prof))
			{
				// show the user and error screen and call for them to login
				$data['content'] = $this->load->view('profile/unsubscribe_error',NULL,TRUE);
			}
			else
			{
				//var_dump($user_prof);die();
				// perform the unsubscribe
				$user_prof[0]->emails_allowed = 0;
				$user_prof[0]->save();
				
				// send a confirmation email
				$this->postageapp->from('info@gradekeep.com');
				$this->postageapp->to($user_prof[0]->user()->email);
				$this->postageapp->subject('GradeBoss Alert - Email alerts turned off!');
				$this->postageapp->message($this->load->view('emails/unsubscribe_confirm',NULL,TRUE));
				$this->postageapp->template('sample_parent_layout');
				$this->postageapp->variables(array(
						'name'=>$user_prof[0]->first_name,
						'unsub_code'=>$user_prof[0]->unsubscribe_code
				));
				$this->postageapp->send();
				
				// load the success view
				$data['content'] = $this->load->view('profile/unsubscribe_success', NULL, TRUE);
			}
			
			// load the main view
			$this->load->view('template',$data);
		}
		
		public function activate_account($code)
		{
			$user = Model\User::find_by_registration_token($code, 1);
			
			// check if we found a user
			if (empty($user) OR is_null($user))
			{
				$data['content'] = $this->load->view('auth/activation_error', NULL, TRUE);
			}
			else
			{
				$user[0]->registration_token = '';
				$user[0]->save();
				$data['content'] = $this->load->view('auth/activation_success', NULL, TRUE);
			}
			
			$this->load->view('splash_template', $data);
		}
	}
	

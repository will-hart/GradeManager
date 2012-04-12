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
					'due_date <=' => addDays(5,date('Y-m-d')),
					'alert_sent', 0
				))->with('user')
				->all();

			// load the email library
			$this->load->library('PostageApp');
			
			// loop through our coursework and set the alert
			foreach($coursework as $cw)
			{
				// send the email
				$this->postageapp->from('info@williamhart.info');
				$this->postageapp->to($cw->user()->email);
				$this->postageapp->subject('GradeBoss Alert - Upcoming Coursework!');
				$this->postageapp->message('<p>Hi, this is just a friendly alert to let you know that you have some coursework due in the next five days.</p>');
				$this->postageapp->template('sample_parent_layout');
				$this->postageapp->variables(array('name'=>$cw->user()->email));
				$this->postageapp->send();
				
				// flag the alert as sent
				$cw->alert_sent = 1;
				$cw->save(); 
			}
		}
	}
	

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Manage extends CI_Controller {
			
		private $usr;
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// load the email library
			$this->load->library('PostageApp');
			$this->load->library('ag_auth');
			
			// get the user record if there is one
			if (! isset($this->session->userdata['user_id']))
			{
				$this->usr = null;
			} 
			else 
			{
				$this->usr = Model\User::find($this->session->userdata['user_id']);
			}
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
			
			// FUTURE:
			// firstly check if this is being called from the command line
			// as this should only be run by CRON or a pagoda background worker
			//if (! $this->input->is_cli_request()) die("No direct access allowed");
			
			// NOW: 
			// check that we are an admin user and send the alerts
			if ($this->usr == null OR $this->usr->group_id != Model\User::ADMINISTRATOR)
			{
				die($this->usr->group_id . " " + Model\User::ADMINISTRATOR);
				$this->session->set_flashdata('error', 'You attempted to access a report that you don\'t have permission to access!');
				redirect('reports');
			}
			
			// get all the coursework needing an alert
			$coursework = Model\Coursework::where(array(
				'status_id <' => Model\Status::HANDED_IN,
				'due_date <=' => strftime("%Y-%m-%d", addDays(Model\Coursework::STANDARD_ALERT_DAYS,time('Y-m-d'))),
				'alert_sent' => 0))
				->with('users')
				->all();
				
			$total_cw = 0;
			$email_cw = 0;
			
			// loop through our coursework and set the alert
			foreach($coursework as $cw)
			{
				if ($cw->user()->profile()->emails_allowed)
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
				// so that we don't have to handle it every time
				$cw->alert_sent = 1;
				$cw->save(); 
				
				$total_cw++;
			}
			
			echo "$total_cw coursework records required alert, sent $email_cw emails";
			return;
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
		
		
		public function resend_activation()
		{
			
			if ($_POST)
			{
				// check if we can find a user in the database
				$user = Model\User::find_by_email($this->input->post('email'), 1);
				
				if (empty($user) OR is_null($user))
				{
					$this->set_flashdata('error','Unable to find a user for that email.  Please check your email and try again!'); 
				}
				else
				{
					
					// check if the user is already activated
					if (strlen($user[0]->registration_token) === 0)
					{
						$this->session->set_flashdata('notice','Your email address is already activated! Please try to login below');
						redirect('login');
					}
					
					// load the library to build the random token
					$this->load->helper('string');
					
					// update the DB token
					$token = random_string('sha1', 64);
					$user[0]->registration_token = $token;
					
					if ($user[0]->save())
					{
						// send a confirmation email
						$this->load->library('PostageApp');
						$this->postageapp->from('info@gradekeep.com');
						$this->postageapp->to($user[0]->email);
						$this->postageapp->subject('GradeKeep - resending activation token at your request');
						$this->postageapp->message($this->load->view('emails/account_activation', array('token'=>$token), TRUE));
						$this->postageapp->template('sample_parent_layout');
						$this->postageapp->variables(array(
							'token'=>$token,
						));
						$this->postageapp->send();
						
						$this->session->set_flashdata('success','Your token was successfully sent.  Please check your inbox for the email!');
						redirect('login');
					}
					else
					{
						$this->set_flashdata('There was an error sending your application link.  Please try again.');
					}
				}
			}
			
			// show the resend form
			$data['message'] = '<p>Enter your email address below and click send.  An email will be sent to this address with a new link to activate your account</p>';
			$data['content'] = $this->load->view('auth/pages/resend_token', NULL, TRUE);
			$this->load->view('splash_template', $data);
		}
		
		public function forgot_password()
		{
			// check if the user has submitted the form
			if ($_POST)
			{
				// check if we can find a user in the database
				$user = Model\User::find_by_email($this->input->post('email'), 1);
				
				if (empty($user) OR is_null($user))
				{
					$this->session->set_flashdata('error', 'Unable to find that email in the database.  Please check it and try again');
					redirect('manage/forgot_password');
				}
				
				// generate a new forgot_pass_token for the database
				$this->load->helper('string');
				$token = random_string('sha1',64);
				$user[0]->forgot_pass_token = $token;
				$user[0]->forgot_pass_token_date = time();
				
				// try to update the database
				if ($user[0]->save())
				{
					// send a confirmation email
					$this->load->library('PostageApp');
					$this->postageapp->from('info@gradekeep.com');
					$this->postageapp->to($user[0]->email);
					$this->postageapp->subject('GradeKeep - Password Reset Request');
					$this->postageapp->message($this->load->view('emails/forgot_password', array('token'=>$token), TRUE));
					$this->postageapp->template('sample_parent_layout');
					$this->postageapp->variables(array(
						'token'=>$token,
					));
					$this->postageapp->send();
					
					// redirect the user
					$this->session->set_flashdata('success','You have been sent an email with a link to reset your password.');
					redirect('login');
				}
				else
				{
					$this->session->set_flashdata('error','There was an error sending your token.  Please try again!');
					redirect('manage/forgot_password');
				}
			}
			
			// show the password reset form
			$data['message'] = '<p>Enter your email address below and click send.  An email will be sent to this address with a link to reset your password</p><br>';
			$data['content'] = $this->load->view('auth/pages/resend_token', $data, TRUE);
			$this->load->view('splash_template', $data);
		}
		
		public function do_password_reset($code)
		{
			$user = Model\User::find_by_forgot_pass_token($code, 1);
			$data['content'] = $this->load->view('auth/pages/password_reset', NULL, TRUE); // LOAD THE FORM BY DEFAULT
			
			// check if we found a user
			if (empty($user) OR is_null($user))
			{
				$data['is_pw_reset'] = 'YES';
				$data['content'] = $this->load->view('auth/activation_error', $data, TRUE);
			}
			else
			{
				if ($_POST)
				{
					$user[0]->password = $this->ag_auth->salt($this->input->post('password'));
					$user[0]->forgot_pass_token = '';
					$user[0]->forgot_pass_token_date = 0;
					
					if ($this->form_validation->run() === FALSE)
					{
						if ($user[0]->save())
						{
							$this->session->set_flashdata('success','Your password reset was successful! Please login to access your dashboard');
							redirect('login');
						}
						else
						{
							$data['content'] = $this->load->view('auth/activation_error', NULL, TRUE);
						}
					}
					else
					{
						$this->set->flashdata('error','There was an error resetting your password.  Please try again.');
					}
				}
			}
			
			$this->load->view('splash_template', $data);
		}
	}
	

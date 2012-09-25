<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Profile extends Application {
		
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) 
			{
				$this->session->set_userdata('attempted_uri', $this->uri->uri_string());
				redirect('login');
			}
		}	
	
		/*
		 * Show the user's profile and allow editing
		 */
		public function index()
		{
			
			// get the default user profile
			$data['profile'] = Model\Profile::where('users_id',$this->usr->id)->limit(1)->all(FALSE);
						
			// check if a form was submitted
			if ($_POST) 
			{
				$data['profile']->first_name = $this->input->post('first_name');
				$data['profile']->last_name = $this->input->post('last_name');
				$data['profile']->default_course = $this->input->post('default_course');
				$data['profile']->emails_allowed = $this->input->post('emails_allowed') == 1 ? 1 : 0;
				
                // fix invalid created dates
                if (! strtotime($data['profile']->created_on))
                {
                    $data['profile']->created_on = time('D-m-y H:i:s');
                }
                
                
				// attempt to save
				if ($data['profile']->save(TRUE))
				{
					// save successful, update the session variable
					$this->session->set_userdata('default_course',$this->input->post('default_course'));
					$this->session->set_flashdata('success','Profile updated!');
					redirect('profile');
				} 
				else
				{
                    // TEMP EMERGENCY DEBUGGING CODE
                    echo 'The raw errors were : ';
                    print_r($data['profile']->errors);
                    die();
					$this->session->set_flashdata('error','Error updating profile, please try again!');
					redirect('profile');
				}
			}

			// load the form
			$data['course_list'] = Model\Course::where('users_id',$this->usr->id)->all();
			$data['action'] = 'view';
			$data['user_id'] = $this->usr->id;
			$data['content'] = $this->load->view('profile/view_one',$data,true);
			$this->load->view('template',$data);
		}

		/**
		 * Shown on the first login to setup a profile
		 */
		public function setup()
		{
			$data['content'] = $this->load->view('profile/ask_about_alerts', NULL, TRUE);
			$this->load->view('template', $data);
		}
		
		/** 
		 * Allow the user to update their password
		 */
		public function change_password()
		{
			// generate a new forgot_pass_token for the database
			$this->load->helper('string');
			$token = random_string('sha1',64);
			$this->usr->forgot_pass_token = $token;
			$this->usr->forgot_pass_token_date = time();
		
			// attempt to save the password forgotten token to the user record
			if ($this->usr->save())
			{
				redirect('manage/do_password_reset/'.$token);
			}
			else
			{
				$this->session->set_flashdata('error','Unable to reset password, please try again');
				redirect('profile');
			}
		}
		
		/**
		 * A function to enable email alerts for the logged in user
		 * and remove the "first_login" flag
		 */
		public function enable_alerts($yes_to_emails = 0)
		{
			// update the user record
			$profile = $this->usr->profile();
			$profile->emails_allowed = $yes_to_emails;
			$profile->first_login = 0;
			
			// try to save
			if ($profile->save()) 
			{
				$this->session->set_flashdata('success','Emails have been activated! Get started by creating or installing a course below.');
				redirect('profile');
			} 
			else 
			{
				$this->session->set_flashdata('error','There was an error updating your profile.  Please try again');
				redirect('profile/setup');
			}
		}

		/*
		 * Delete a profile and all the associated data - do not use
		 * the abstract crud method as we don't want to load by ID 
		 */
		public function delete()
		{
			$profile = Model\User::find($this->usr->id);
						
			// check if the user is trying to delete their own profile
			if (is_null($profile))
			{
				$this->session->set_flashdata('error','Unable to delete that profile.');
				redirect('profile');
			}
			
			// if the user has confirmed deletion, delete away
			if ($this->input->post('delete') == 'Yes')
			{
				// find all the information and delete				
				$this->db->where('users_id',$this->usr->id)->delete('subject');
				$this->db->where('users_id',$this->usr->id)->delete('course');
				$this->db->where('users_id',$this->usr->id)->delete('coursework');
				$this->db->where('users_id',$this->usr->id)->delete('profile');
				$profile->delete();
				
				// destroy the session
				$this->session->sess_destroy();
				
				// notify success
				$this->session->set_flashdata('success','Your profile and all your information has been deleted');
				redirect("");
			}
			else
			{
				$data['type_name'] = "user";
				$data['type_url'] = "profile";
				$data['user_id'] = $this->usr->id;
				$data['content'] = $this->load->view('delete_confirmation',$data,true);
				$this->load->view('template',$data);
			}
		}

		// define abstract methods
		function _before_save() { throw new BadMethodCallException(); }
		function _after_save() { throw new BadMethodCallException(); }
		function _before_create() { throw new BadMethodCallException(); }
		function _after_create() { throw new BadMethodCallException(); }
		function _before_edit() { throw new BadMethodCallException(); }
		function _after_edit() { throw new BadMethodCallException(); }
		function _before_delete() { throw new BadMethodCallException(); }
		function _after_delete() { throw new BadMethodCallException(); }
		function _before_view() { throw new BadMethodCallException(); }
		function _after_view() { throw new BadMethodCallException(); }
		function _before_render() { throw new BadMethodCallException(); }
	}
	

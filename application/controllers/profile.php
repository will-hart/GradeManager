<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Profile extends Application {
		
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
		
			// Set up the validation rules
			$this->validation_rules = array(
				'first_name' => array (
					'field' 		=> 		'first_name',
					'label'			=> 		'First Name',
					'rules'			=>		'trim|xss_clean|max_length[255]'
				),
				'last_name' => array (
					'field' 		=> 		'last_name',
					'label'			=> 		'Last Name',
					'rules'			=>		'trim|xss_clean|max_length[255]'
				),
				'default_course' => array (
					'field' 		=> 		'default_course',
					'label'			=> 		'Default Course',
					'rules'			=>		'trim|xss_clean|integer|required'
				),
			);
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
				$this->form_validation->set_rules($this->validation_rules);
				
				// check if we have passed the validation rules
				if ($this->form_validation->run())
				{
					$data['profile']->first_name = $this->input->post('first_name');
					$data['profile']->last_name = $this->input->post('last_name');
					$data['profile']->default_course = $this->input->post('default_course');
					$data['profile']->first_login = 0;
					
					// attempt to save
					if ($data['profile']->save())
					{
						// save successful, update the session variable
						$this->session->set_userdata('default_course',$this->input->post('default_course'));
						$this->session->set_flashdata('success','Profile updated!');
					} 
					else
					{
						$this->session->set_flashdata('error','Error updating profile, please try again!');
					}
				}
			}

			// load the form
			$data['course_list'] = Model\Course::where('users_id',$this->usr->id)->all();
			$data['action'] = 'view';
			$data['user_id'] = $this->usr->id;
			$data['content'] = $this->load->view('profile/view_one',$data,true);
			$this->load->view('template',$data);
		}



		/*
		 * Delete a profile and all the associated data 
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
	

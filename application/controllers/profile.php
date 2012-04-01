<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Profile extends Application {
		
		// Set up the validation rules
		protected $validation_rules = array(
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
		
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
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
			$data['content'] = $this->load->view('profile/view_one',$data,true);
			$this->load->view('template',$data);
		}
	}
	

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
			

			// load the form
			$data['course_list'] = Model\Course::where('users_id',$this->usr->id)->all();
			$data['action'] = 'view';
			$data['content'] = $this->load->view('profile/view_one',$data,true);
			$this->load->view('template',$data);
		}
	}
	

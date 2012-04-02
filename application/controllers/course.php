<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Course extends Application {
			
				
		// Set up the validation rules
		protected $validation_rules = array(
			'title' => array (
				'field' 		=> 		'title',
				'label'			=> 		'Subject Title',
				'rules'			=>		'trim|xss_clean|max_length[255]|required'
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
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		/*
		 * Creates a new course with default data and redirect to the edit screen
		 */
		public function create()
		{
			$course = new Model\Course();
			$course->users_id = $this->usr->id;
			$course->title="New Course";
			if($course->save())
			{
				$id = Model\Course::last_created()->id;
				$this->session->set_flashdata('success','New course created!');
				redirect('course/edit/'.$id);
			}
			else
			{
				$this->session->set_flashdata('error','Error creating new course, please try again.');
				redirect('profile');
			}
		}		
	}
	

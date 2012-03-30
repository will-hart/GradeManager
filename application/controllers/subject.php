<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Subject extends CI_Controller {
		
		public $usr; // stores the user object
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			// get the user object
			$this->usr = Model\User::find($this->session->userdata("user_id"));
		}
	
	
		/*
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		
		/* 
		 * View a single subject and all the associated coursework
		 */
		public function view($subject_id = 0)
		{
			// check for no subject id and redirect to dashboard
			$subject_id or redirect('dashboard');
			
			// get the relevant subject
			$data['subject'] = Model\Subject::find($subject_id);
			
			// load the single view
			$data['content'] = $this->load->view('subject/view_one',$data,true);
			
			// load the template
			$this->load->view('template',$data);
			
		}
	}

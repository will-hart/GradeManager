<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Subject extends CI_Controller {
		
		protected $usr; // stores the user object
		
		// Set up the validation rules
		protected $validation_rules = array(
			'code' => array (
				'field' 		=> 		'code',
				'label'			=> 		'Subject Code',
				'rules'			=>		'trim|xss_clean|max_length[32]|alpha_numeric|required'
			),
			'title' => array (
				'field' 		=> 		'title',
				'label'			=> 		'Subject Title',
				'rules'			=>		'trim|xss_clean|max_length[255]|alpha_numeric|required'
			),
			'notes' => array(
				'field' 		=> 		'notes',
				'label'			=> 		'Subject Code',
				'rules'			=>		'trim|xss_clean|alpha_numeric'
			),
		);
		
		
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
		
		
		/*
		 * Creates a new subject
		 */
		public function create()
		{
			// set the rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we have post data and build a subject object
			if($this->input->post('submit'))
			{
				// set the data
				$subj = new Model\Subject();
				$subj->code = $this->input->post('code');
				$subj->title = $this->input->post('title');
				$subj->users_id = $this->session->userdata('user_id');
			}
			else 
			{
				$this->session->set_flashdata('notice','Unable to create a new subject, please check your link.');
				redirect('dashboard');
			}
			
			
			// check the rules
			if($this->form_validation->run() === TRUE)
			{
				
				// attempt to save
				if($subj->save())
				{
					$this->session->set_flashdata("success","New Subject Added");
					redirect("subject/view/".Model\Subject::last_created()->id);
				}
				else 
				{
					$this->session->set_flashdata('error','Unable to save the subject! Please try again.');
				}
			}
			
			// if the rules failed then show the form with error notices
			// and the forms populated
			$data['subject'] = $subj;
			$data['content'] = $this->load->view('subject/manage_single',$data,true);
			$this->load->view('template',$data);
			
		}
	}
	

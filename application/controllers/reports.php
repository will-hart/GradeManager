<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Reports extends Application {
			
		
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
		 * If the index is called show a list of available reports
		 */
		public function index()
		{
			$this->data['group_id'] = $this->usr->group_id;
			$this->data['content'] = $this->load->view('reports/index', $this->data, TRUE);
			$this->load->view('template', $this->data);
		}
		
		
		/*
		 * Show a list of all outstanding assessments
		 */
		public function outstanding()
		{
			$this->data['courseworks'] = Model\Coursework::where( array(
				'users_id' => $this->usr->id,
				'status_id <= ' => Model\Status::HANDED_IN,
			))
			->order_by('due_date','ASC')
			->all();
			
			// now load the views
			$this->data['content'] = $this->load->view('reports/outstanding',$this->data,TRUE);
			$this->load->view('template',$this->data);
		}
		
		/*
		 * Show a list of coursework that has been handed in but not returned 
		 */
		public function not_returned()
		{
			$this->data['courseworks'] = Model\Coursework::where( array(
				'users_id' => $this->usr->id,
				'status_id' => Model\Status::HANDED_IN
			))
			->order_by('due_date','ASC')
			->all();
			
			// now load the views
			$this->data['content'] = $this->load->view('reports/marked_not_returned', $this->data, TRUE);
			$this->load->view('template', $this->data);
		}
		
		/*
		 * Shows a list of registered users with some basic information.
		 * This is admin only user group must be == 1
		 */
		public function registered_users()
		{
			// check we are an admin
			if ($this->usr->group_id != Model\User::ADMINISTRATOR)
			{
				$this->session->set_flashdata('error','You do not have permission to view this report!');
				redirect('reports');
			}
				
			// build the user table
			$this->data['users'] = Model\User::all();
			
			// load the views
			$this->data['content'] = $this->load->view('reports/user_listing', $this->data, TRUE);
			$this->load->view('template', $this->data);
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
	

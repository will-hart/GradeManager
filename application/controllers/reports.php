<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Reports extends Application {
			
		
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
		 * Show a list of all outstanding assessments
		 */
		public function outstanding()
		{
			$data['courseworks'] = Model\Coursework::where( array(
				'users_id' => $this->usr->id,
				'status_id <= ' => 4,
			))
			->order_by('due_date','ASC')
			->all();
			
			// now load the views
			$data['content'] = $this->load->view('reports/outstanding',$data,true);
			$this->load->view('template',$data);
		}
	}
	

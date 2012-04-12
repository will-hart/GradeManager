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
		
		
		/*
		 * Called by a cron job to send email alerts
		 */
		public function send_alerts()
		{
			$this->load->library('postageapp');
			$this->postageapp->from('hart.wl@gmail.com');
			$this->postageapp->to('hart.wl@gmail.com');
			$this->postageapp->subject('Test PostageApp Email');
			$this->postageapp->message('This is a sample message for inclusion in your file');
			$this->postageapp->template('sample_parent_layout');
			
			echo $this->postageapp->send();
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
	

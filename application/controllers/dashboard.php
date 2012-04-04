<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Dashboard extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
		}
	
		public function index()
		{
			// build the data used in the dashboard
			$data['username'] = $this->usr->username;
			$data['subjects'] = Model\Subject::where(array(
				'users_id' => $this->usr->id,
				'course_id' => $this->session->userdata('default_course')
			))->all();
			$data['next_5'] = Model\Coursework::limit(5)
					->select('coursework.*')
					->join('subject', 'subject.id=coursework.subject_id')
					->where(array(
						'status_id <' => Model\Status::COMPLETED,
						'coursework.users_id' => $this->usr->id,
						'subject.course_id' => $this->session->userdata('default_course')
					))->all();
			$data['course_id'] = $this->session->userdata('default_course');
			
			// load the dashboard, subject list and new subject form
			$data['action'] = 'dashboard';
			$data['content'] = $this->load->view('dashboard/dashboard_stats',$data,true);
			$data['content'] .= $this->load->view('subject/view_many',$data,true);
			$data['content'] .= $this->load->view('subject/manage_single', $data, true);
			$this->load->view('template',$data);
		}
		
		
		public function migrate()
		{
			$this->load->library('migration');
			if (!$this->migration->current())
			{
				show_error($this->migration->error_string());
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

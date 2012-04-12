<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Subject extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			// set up the linked model
			$this->model = new Model\Subject();
			$this->model_name = 'subject';
			$this->check_user_permission = TRUE;
		}
	
	
		/*
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		
		public function _before_view()
		{
			$this->data['action'] = 'view';
			$this->data['courseworks'] = $this->data[$this->model_name]->coursework();
			$this->data['coursework_list'] = $this->load->view('coursework/view_many', $this->data, TRUE);
			$this->data['subject_dashboard'] = $this->load->view('subject/subject_stats', $this->data, TRUE);
			$this->data['content'] = $this->load->view('subject/view_one', $this->data, TRUE);
			$this->data['content'] .= $this->load->view('coursework/manage_single', $this->data, TRUE);
		}
		
		public function _after_view() { return; }
		public function _before_render() { return; }
		public function _before_save() { return; }
		public function _after_save() { return; }
		
		public function _after_edit() {
			redirect('subject/view/'.$this->model->id);
		}
		
		public function _before_edit() {
			$this->data['course_id'] = $this->session->userdata('default_course');
			$this->data['action'] = 'edit';
			$this->data['content'] = $this->load->view('subject/manage_single', $this->data, TRUE);
		}
		
		public function _before_create()
		{
			$this->model->users_id = $this->usr->id;
		}
		
		public function _after_create()
		{
			redirect('subject/view/'.$this->model->id);
		}
		
		public function _before_delete()
		{
			$this->data['type_url'] = 'subject';
			$this->data['type_name'] = 'Subject';
			$this->data['content'] = $this->load->view('delete_confirmation', $this->data, TRUE);
			$this->coursework = $this->model->coursework();
		}
		
		public function _after_delete()
		{
			// delete all associated coursework
			foreach($this->coursework as $cw)
			{
				$cw->delete();
			}
			
			redirect('dashboard');
		}
	}
	

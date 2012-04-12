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
		
		/*
		 * Delete a subject 
		 */
		public function delete($id=0)
		{	
			// check for no subject id and redirect to dashboard
			$subject = Model\Subject::find($id);			
			if ($subject == NULL) redirect('dashboard');
			
			// check this is our subject
			if ($subject->users_id != $this->usr->id) {
				$this->session->set_flashdata('error','You do not have permission to view this subject!');
				redirect('dashboard');
			}
			
			// if the user has confirmed deletion, delete away
			if ($this->input->post('delete') == 'Yes')
			{				
				// delete all the associated coursework
				foreach($subject->coursework() as $cw)
				{
					$cw->delete();
				}
				
				// delete the subject
				$subject->delete();
				
				// notify success
				$this->session->set_flashdata('success','Successfully deleted subject');
				redirect("dashboard");
			}
			
			// otherwise we are showing the delete confirmation form
			$data['type_url'] = 'subject';
			$data['type_name'] = 'Subject';
			$data['content'] = $this->load->view('delete_confirmation',$data,true);
			$this->load->view('template',$data);
		}

		// define abstract methods
		function _before_delete() { throw new BadMethodCallException(); }
		function _after_delete() { throw new BadMethodCallException(); }
	}
	

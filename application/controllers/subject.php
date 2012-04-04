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
		
		
		/*
		 * Creates a new subject
		 */
		public function create()
		{
			// set the rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we have post data and build a subject object
			if($_POST)
			{
				// set the data
				$subj = new Model\Subject();
				$subj->code = $this->input->post('code');
				$subj->title = $this->input->post('title');
				$subj->course_id = $this->input->post('course_id');
				$subj->users_id = $this->session->userdata('user_id');
			}
			else 
			{
				$this->session->set_flashdata('error','Unable to create a new subject, please check your link.');
				redirect('dashboard');
			}
			
			
			// check the rules
			if($this->form_validation->run() === TRUE)
			{
				
				// attempt to save
				if($subj->save())
				{
					$this->session->set_flashdata("success","New Subject Added");
					$newid = Model\Subject::last_created()->id;
					redirect("subject/view/".$newid);
				}
				else 
				{
					$this->session->set_flashdata('error','Unable to save the subject! Please try again.');
				}
			}
			
			// if the rules failed then show the form with error notices
			// and the forms populated
			$data['subject'] = $subj;
			$data['action'] = 'create';
			$data['content'] = $this->load->view('subject/manage_single',$data,true);
			$this->load->view('template',$data);
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
		function _before_create() { throw new BadMethodCallException(); }
		function _after_create() { throw new BadMethodCallException(); }
		function _before_delete() { throw new BadMethodCallException(); }
		function _after_delete() { throw new BadMethodCallException(); }
	}
	

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Subject extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
		
			// Set up the validation rules
			$this->validation_rules = array(
				'code' => array (
					'field' 		=> 		'code',
					'label'			=> 		'Subject Code',
					'rules'			=>		'trim|xss_clean|max_length[32]|required'
				),
				'title' => array (
					'field' 		=> 		'title',
					'label'			=> 		'Subject Title',
					'rules'			=>		'trim|xss_clean|max_length[255]|required'
				),
				'notes' => array(
					'field' 		=> 		'notes',
					'label'			=> 		'Notes',
					'rules'			=>		'trim|xss_clean'
				),
			);
				
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
		public function view($id = 0)
		{
			// check for no subject id and redirect to dashboard
			$subject = Model\Subject::find($id);			
			if ($subject == NULL) redirect('dashboard');
			
			// check this is our subject
			if ($subject->users_id != $this->usr->id) {
				$this->session->set_flashdata('error','You do not have permission to view this subject!');
				redirect('dashboard');
			}
			
			// get the relevant subject
			$data['subject'] = $subject;
			$data['action'] = 'view';
			$data['courseworks'] = $data['subject']->coursework();
			
			// get the many courseworks table
			$data['coursework_list'] = $this->load->view('coursework/view_many',$data,true);
			
			// get the subject dashboard
			$data['subject_dashboard'] = $this->load->view('subject/subject_stats',$data,true);
						
			// load the single subject view
			$data['content'] = $this->load->view('subject/view_one',$data,true);
			$data['content'] .= $this->load->view('coursework/manage_single',$data,true);
			
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
		 * Edit a subject
		 */
		public function edit ($id = 0)
		{
			// check for no subject id and redirect to dashboard
			$subject = Model\Subject::find($id);			
			if ($subject == NULL) 
			{
				$this->session->set_flashdata('error', 'Unable to find the requested subject');
				redirect('dashboard');
			}
			
			// check this is our subject
			if ($subject->users_id != $this->usr->id) {
				$this->session->set_flashdata('error','You do not have permission to view this subject!');
				redirect('dashboard');
			}
			
			// set and run validation rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we submitted our edits and they are valid
			if($_POST && $this->form_validation->run() === TRUE)
			{
				// update the model
				$subject->code = $this->input->post('code');
				$subject->title = $this->input->post('title');
				$subject->notes = $this->input->post('notes');
				
				// save the model
				if ($subject->save())
				{
					$this->session->set_flashdata('success','Successfully updated subject');
					redirect('subject/view/'.$subject->id);
				}
				else
				{
					$this->session->set_flashdata('error','Error saving subject, please try again');
				}
			}
			
			// show the editing form
			$data['subject'] = $subject;
			$data['course_id'] = $this->session->userdata('default_course');
			$data['action'] = 'edit';
			$data['content'] = $this->load->view('subject/manage_single', $data, true);
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
		function _before_save() { throw new BadMethodCallException(); }
		function _after_save() { throw new BadMethodCallException(); }
		function _before_create() { throw new BadMethodCallException(); }
		function _after_create() { throw new BadMethodCallException(); }
		function _before_edit() { throw new BadMethodCallException(); }
		function _after_edit() { throw new BadMethodCallException(); }
		function _before_delete() { throw new BadMethodCallException(); }
		function _after_delete() { throw new BadMethodCallException(); }
	}
	

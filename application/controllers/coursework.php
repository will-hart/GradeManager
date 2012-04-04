<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Coursework extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			// set up the linked model
			$this->model = new Model\Coursework();
			$this->model_name = 'coursework';
			$this->check_user_permission = TRUE;
		}
	
	
		/*
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		
		public function _before_render() { return; }
		public function _after_view() { return; }
		public function _before_save() { return; }
		
		public function _before_view() { 
			// load the single view
			$this->data['action'] = 'view';
			$this->data['content'] = $this->load->view('coursework/view_one',$this->data,true);
		}
		
		public function _after_save()
		{
			$this->recalculate_weightings($this->model->subject_id);
		}
		
		public function _after_edit()
		{
			redirect('coursework/view/'.$this->model->id);
		}
		
		public function _before_edit()
		{
			$this->data['status_list'] = Model\Status::all();
			$this->data['action'] = 'edit';
			$this->data['content'] = $this->load->view('coursework/manage_single', $this->data, TRUE);
		}
		
		/*
		 * Creates a new coursework
		 */
		public function create($id = 0)
		{
			// check we have find a coursework for this id
			$subject = Model\Subject::find($id);
			if ($subject == NULL) {
				$this->session->set_flashdata('error','Error adding coursework - unknown subject to add it to!');
				redirect('dashboard');
			}
			
			// check this user is allowed to access it
			if ($this->usr->id != $subject->users_id) 
			{
				$this->session->set_flashdata('error','You do not have permission to add coursework to this subject');
				redirect('dashboard');
			}
			
			// set the rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we have post data and build a subject object
			if($_POST)
			{
				// set the data
				$coursework = new Model\Coursework();
				$coursework->title = $this->input->post('title');
				$coursework->users_id = $this->session->userdata('user_id');
				$coursework->subject_id = $id;
				$coursework->status_id = 1; // set the default status id
				$coursework->score = 0;
				$coursework->weighting = 0;
				$coursework->due_date = date('Y-m-d');
			}
			else 
			{
				$this->session->set_flashdata('error','Unable to create a new coursework, please check your link.');
				redirect('dashboard');
			}
			
			
			// check the rules
			if($this->form_validation->run() === TRUE)
			{
				
				// attempt to save
				if($coursework->save())
				{
					$this->recalculate_weightings($coursework->subject_id);
					$this->session->set_flashdata("success","New Coursework Added");
					redirect("subject/view/".$coursework->subject_id);
				}
				else 
				{
					$this->session->set_flashdata('error','Unable to save the coursework! Please try again.');
				}
			}
			
			// if the rules failed then show the form with error notices
			// and the forms populated
			$data['coursework'] = $coursework;
			$data['action'] = 'create';
			$data['content'] = $this->load->view('coursework/manage_single',$data,true);
			$this->load->view('template',$data);
		}
				
		/*
		 * Delete a coursework
		 */
		public function delete($id=0)
		{
			// check we have find a coursework for this id
			$coursework = Model\Coursework::find($id);
			if ($coursework == NULL) {
				$this->session->set_flashdata('error','Error deleting coursework - are you sure that coursework exists?');
				redirect('dashboard');
			}
			
			// check this user is allowed to access it
			if ($this->usr->id != $coursework->users_id) 
			{
				$this->session->set_flashdata('error','You do not have permission to delete this coursework');
				redirect('dashboard');
			}
			
			// if the user has confirmed deletion, delete away
			if ($this->input->post('delete') == 'Yes')
			{
				$subj = Model\Subject::find($coursework->subject_id);
				$coursework->delete();
				$this->recalculate_weightings($subj->id);
				
				$this->session->set_flashdata('success','Successfully deleted coursework');
				redirect("subject/view/".$subj->id);
			}
			
			// otherwise we are showing the delete confirmation form
			$data['type_url'] = 'coursework';
			$data['type_name'] = 'Coursework';
			$data['content'] = $this->load->view('delete_confirmation',$data,true);
			$this->load->view('template',$data);
		}
		
		/* 
		 * Recalculate the score and weighting of a subject based on a 
		 * coursework update.  The variable passed is the subject id
		 */
		private function recalculate_weightings($sid = 0)
		{
			// get the attached subject
			$sub = Model\Subject::with('coursework')->find($sid);
			
			// check if no subject was found
			if($sub == NULL) return FALSE;
						
			// set up some counter variables
			$score = 0;
			$complete = 0;
			$total_complete = 0;
			
			// if an assessment is above status_id 4 (completed) its complete
			// take the score regardless of if it is complete or not - this is a
			// measure of the marks taken so far
			foreach($sub->coursework() as $c)
			{
				$total_complete += $c->weighting;
				$score += ($c->score/100) * $c->weighting;
				if ($c->status_id >= Model\Status::COMPLETED ) $complete += $c->weighting;
			}
			
			// calculate the percentage values
			$sub->score = $score;
			$sub->complete = round(100 * $complete / $total_complete, 0);
			
			return $sub->save();
		}
		
		/*
		 * Mark a bit of coursework as handed in
		 */
		public function hand_in($id = 0)
		{
			// check we have find a coursework for this id
			$coursework = Model\Coursework::find($id);
			if ($coursework == NULL) {
				$this->session->set_flashdata('error','Error finding coursework - are you sure that coursework exists?');
				redirect('dashboard');
			}
			
			// check this user is allowed to access it
			if ($this->usr->id != $coursework->users_id) 
			{
				$this->session->set_flashdata('error','You do not have permission to edit this coursework');
				redirect('dashboard');
			}
			
			// check the subject hasn't already been handed in and 
			// then mark accordingly
			if ($coursework->status_id < 5)
			{
				$coursework->status_id = 5;
				if($coursework->save())
				{
					$this->session->set_flashdata('success','Coursework handed in! Well done');
				} 
				else 
				{
					$this->session->set_flashdata('error','Unable to save coursework, please try again');
				}
			}
			else 
			{
				$this->session->set_flashdata('notice',"You've already handed this coursework in!");
			}
			
			redirect('coursework/view/'.$coursework->id);
		}
		
		
		/*
		 * Enter a score for a given piece of coursework
		 */
		public function enter_score($id=0)
		{
			// check we have find a coursework for this id
			$coursework = Model\Coursework::find($id);
			if ($coursework == NULL) {
				$this->session->set_flashdata('error','Error finding coursework - are you sure that coursework exists?');
				redirect('dashboard');
			}
			
			// check this user is allowed to access it
			if ($this->usr->id != $coursework->users_id) 
			{
				$this->session->set_flashdata('error','You do not have permission to edit this coursework');
				redirect('dashboard');
			}
			
			// check for post
			if($this->input->post('submit'))
			{
				$data['score'] = $this->input->post('score');
				
				// check if we have a number from 0 to 100 for our score
				if (is_numeric($data['score']) && $data['score'] >= 0 && $data['score'] <= 100)
				{
					$coursework->score = $data['score'];
					$coursework->status_id = Model\Status::RETURNED; // update the status
					
					if ($coursework->save())
					{
						$this->session->set_flashdata('success', 'Successfully updated scores');
					} else {
						$this->session->set_flashdata('error','Failed updating score - please try again');
					}
					redirect('coursework/view/'.$id);
				}
			}
			else
			{
				$data['score'] = $coursework->score;
			}
			
			// otherwise show the form
			$data['content'] = $this->load->view('coursework/enter_score_form',$data, true);
			$this->load->view('template',$data);
		}

		/*
		 * Close the coursework
		 */
		public function close($id=0)
		{
			// check we have find a coursework for this id
			$coursework = Model\Coursework::find($id);
			if ($coursework == NULL) {
				$this->session->set_flashdata('error','Error finding coursework - are you sure that coursework exists?');
				redirect('dashboard');
			}
			
			// check this user is allowed to access it
			if ($this->usr->id != $coursework->users_id) 
			{
				$this->session->set_flashdata('error','You do not have permission to edit this coursework');
				redirect('dashboard');
			}
			
			$coursework = Model\Coursework::find($id);
			$coursework->status_id = Model\Status::CLOSED;
			$coursework->save();
			
			redirect('coursework/view/'.$id);
		}		
		
		// define abstract methods
		function _before_create() { throw new BadMethodCallException(); }
		function _after_create() { throw new BadMethodCallException(); }
		function _before_delete() { throw new BadMethodCallException(); }
		function _after_delete() { throw new BadMethodCallException(); }
	}
	

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Coursework extends Application {
		
		private $subject_id; 
		
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
			
			$this->subject_id = 0;
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
		
		public function create($id = 0)
		{
			$this->subject_id = $id;
			parent::create();
		}
		
		public function _before_create()
		{
			// get the parent object
			$this->parent['subject'] = $subject = Model\Subject::find($this->subject_id);
			
			// check we have permission to edit the subject
			if($this->usr->id != $subject->users_id)
			{
				$this->session->set_flashdata('error','Error adding coursework - unknown subject to add it to!');
				redirect('dashboard');
			}
			
			// update the variable to reflect the parent link
			$this->update_parent_links();
			
			// set the default options
			$this->model->users_id = $this->session->userdata('user_id');
			$this->model->status_id = 1; // set the default status id
			$this->model->score = 0;
			$this->model->weighting = 0;
			$this->model->due_date = date('Y-m-d');
		}
		
		public function _after_create()
		{
			redirect('subject/view/'.$this->subject_id);
		}
		
		public function _before_delete()
		{
			$this->data['type_url'] = 'coursework';
			$this->data['type_name'] = 'Coursework';
			$this->data['content'] = $this->load->view('delete_confirmation', $this->data, TRUE);
			$this->data['subject_id'] = $this->model->subject_id;
		}
		
		public function _after_delete()
		{
			$this->recalculate_weightings();
			redirect('subject/view/'.$this->data['subject_id']);
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
				if ($c->status_id >= Model\Status::COMPLETED ) $complete += $c->weighting;
				if ($c->status_id >= Model\Status::HANDED_IN ) $score += ($c->score/100) * $c->weighting;
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
			if ($coursework->status_id < Model\Status::HANDED_IN)
			{
				$coursework->status_id = Model\Status::HANDED_IN;
				if($coursework->save())
				{
					$this->recalculate_weightings($coursework->subject_id);
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
						$this->recalculate_weightings($coursework->subject_id);
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
	}
	

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Coursework extends CI_Controller {
		
		protected $usr; // stores the user object
		
		// Set up the validation rules
		protected $validation_rules = array(
			'title' => array (
				'field' 		=> 		'title',
				'label'			=> 		'Coursework Title',
				'rules'			=>		'trim|xss_clean|max_length[255]|required|strip_tags'
			),
			'score' => array (
				'field'			=> 		'score',
				'label'			=>		'Your Score',
				'rules'			=>		'max_length[3]|greater_than[-1]|less_than[101]',
			),
			'weighting' => array (
				'field'			=> 		'wighting',
				'label'			=>		'Coursework Weighting',
				'rules'			=>		'max_length[3]|greater_than[-1]|less_than[101]',
			),
			'notes' => array(
				'field' 		=> 		'notes',
				'label'			=> 		'Notes',
				'rules'			=>		'trim|xss_clean|strip_tags'
			),
		);
		
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			// get the user object
			$this->usr = Model\User::find($this->session->userdata("user_id"));
		}
	
	
		/*
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		
		/* 
		 * View a single coursework
		 */
		public function view($id = 0)
		{
			// check for no subject id and redirect to dashboard
			$id or redirect('dashboard');
			
			// get the relevant subject
			$data['coursework'] = Model\Coursework::find($id);
			
			// load the single view
			$data['action'] = 'view';
			$data['content'] = $this->load->view('coursework/view_one',$data,true);
			
			// load the template
			$this->load->view('template',$data);
		}
		
		
		/*
		 * Creates a new coursework
		 */
		public function create($id = 0)
		{
			$id OR redirect('dashboard'); // no subject ID provided
			
			// set the rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we have post data and build a subject object
			if($_POST)
			{
				// set the data
				$cw = new Model\Coursework();
				$cw->title = $this->input->post('title');
				$cw->users_id = $this->session->userdata('user_id');
				$cw->subject_id = $id;
				$cw->status_id = 1; // set the default status id
				$cw->score = 0;
				$cw->weighting = 0;
				$cw->due_date = date('Y-m-d');
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
				if($cw->save())
				{
					$this->recalculate_weightings($cw->subject_id);
					$this->session->set_flashdata("success","New Coursework Added");
					redirect("subject/view/".$cw->subject_id);
				}
				else 
				{
					$this->session->set_flashdata('error','Unable to save the coursework! Please try again.');
				}
			}
			
			// if the rules failed then show the form with error notices
			// and the forms populated
			$data['coursework'] = $cw;
			$data['action'] = 'create';
			$data['content'] = $this->load->view('coursework/manage_single',$data,true);
			$this->load->view('template',$data);
		}
		
		
		/*
		 * Edit a coursework
		 */
		public function edit ($id = 0)
		{
			// check an ID was passed
			$id OR redirect('dashboard');
			
			// get the coursework
			$cw = Model\Coursework::find($id);
			
			// set and run validation rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we submitted our edits and they are valid
			if($_POST && $this->form_validation->run() === TRUE)
			{
				// update the model
				$cw->title = $this->input->post('title');
				$cw->due_date = $this->input->post('due_date');
				$cw->status_id = $this->input->post('status_id');
				$cw->notes = $this->input->post('notes');
				$cw->score = $this->input->post('score');
				$cw->weighting = $this->input->post('weighting');
								
				// save the model
				if ($cw->save())
				{
					$this->recalculate_weightings($cw->subject_id);
					$this->session->set_flashdata('success','Successfully updated coursework');
					redirect('coursework/view/'.$cw->id);
				}
				else
				{
					$this->session->set_flashdata('error','Error saving coursework, please try again');
				}
			}
			
			// get the list of statuses we can have
			$data['status_list'] = Model\Status::all();
			
			// show the editing form
			$data['coursework'] = $cw;
			$data['action'] = 'edit';
			$data['content'] = $this->load->view('coursework/manage_single', $data, true);
			$this->load->view('template',$data);
		}
		
		
		/*
		 * Delete a coursework
		 */
		public function delete($id=0)
		{
			$id OR redirect('dashboard');
			
			// if the user has confirmed deletion, delete away
			if ($this->input->post('delete') == 'Yes')
			{
				$cw = Model\Coursework::find($id);
				$subj = Model\Subject::find($cw->subject_id);
				$cw->delete();
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
			if($sid == 0) return false;
			
			// get the attached subject
			$sub = Model\Subject::with('coursework')->find($sid);
			
			
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
				if ($c->status_id >= 4) $complete += $c->weighting;
			}
			
			// calculate the percentage values
			$sub->score = $score;
			$sub->complete = round(100 * $complete / $total_complete, 0);
			return($sub->save());
		}
		
		/*
		 * Mark a bit of coursework as handed in
		 */
		public function hand_in($id = 0)
		{
			$id OR redirect('dashboard');
			
			// get the coursework object
			$cw = Model\Coursework::find($id);
			
			// check the subject hasn't already been handed in and 
			// then mark accordingly
			if ($cw->status_id < 5)
			{
				$cw->status_id = 5;
				if($cw->save())
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
			
			redirect('coursework/view/'.$cw->id);
		}
		
		
		/*
		 * Enter a score for a given piece of coursework
		 */
		public function enter_score($id=0)
		{
			// get the coursework
			$cw = Model\Coursework::find($id);
				
			// check its all good
			if($id==0 OR is_null($cw)) redirect('dashboard');
			
			// check for post
			if($this->input->post('submit'))
			{
				$data['score'] = $this->input->post('score');
				
				// check if we have a number from 0 to 100 for our score
				if (is_numeric($data['score']) && $data['score'] >= 0 && $data['score'] <= 100)
				{
					$cw->score = $data['score'];
					$cw->status_id = Model\Status::RETURNED; // update the status
					
					if ($cw->save())
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
				$data['score'] = $cw->score;
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
			$id OR redirect('dashboard');
			
			$cw = Model\Coursework::find($id);
			$cw->status_id = Model\Status::CLOSED;
			$cw->save();
			
			redirect('coursework/view/'.$id);
		}
	}
	

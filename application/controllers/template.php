<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Template extends CI_Controller {
		
		protected $usr; // stores the user object
		
		// Set up the validation rules
		protected $validation_rules = array(
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
		 * Share an entire course template
		 */
		public function share_course($id=0)
		{
			$id OR redirect('dashboard');
			
			// get the yearlevel
			$course = Model\Yearlevel::find($id);
			
			// check this user owns the course
			if (!$this->usr->id == $course->users_id)
			{
				$this->session->set_flashdata('error','You do not have permission to share this course!');
				redirect('dashboard');
			}
			
			// now build the json string
			$json = '{ "template" : { "type" : "course", "data" : [';
			foreach($course->subject() as $sub) {
				$json .= $this->generate_subject_json($sub);
			}
			
			// remove the final comma and close off the template
			$json = substr($json, 0, -1)."]}}";
			
			// now build and populate the template
			$tmp = new Model\Template();
			$tmp->users_id = $this->usr->id;
			$tmp-> template = $json;
			
			if($tmp->save())
			{
				$this->session->set_flashdata('success','Successfully generated template');
				redirect('template/manage/'.Model\Template::last_created()->id);
			} 
			else 
			{
				$this->session->set_flashdata('error','Error generating template, please try again');
				redirect('dashboard');
			}		
		}
		
		
		/*
		 * Share a subject template
		 */
		public function share_subject($id = 0)
		{
			$id OR redirect('dashboard');

			// get the subject
			$sub = Model\Subject::find($id);

			// check this user owns the subject
			if (!$this->usr->id == $sub->users_id)
			{
				$this->session->set_flashdata('error','You do not have permission to share this subject!');
				redirect('dashboard');
			}

			// build a json string from the subject
			$json = '{ "template" : { "type" : "subject", "data" : [';
			$json .= substr($this->generate_subject_json($sub),0,-1);
			$json .= "]}}";

			$tmp = new Model\Template();
			$tmp->users_id = $this->usr->id;
			$tmp->template = $json;

			if ($tmp->save())
			{
				$this->session->set_flashdata('success','Successfully generated template!');
				redirect('template/manage/'.Model\Template::last_created()->id);
			}
			else 
			{
				$this->session->set_flashdata('error','Error generating template, please try again');
				redirect('dashboard');
			}
		}
				
		/*
		 * Generates JSON format for one subject template
		 * including parsing all the coursework attached
		 */
		private function generate_subject_json($subject = NULL)
		{
			if(is_null($subject)) return "";
			
			// now build the subject header json
			$json = '{ "code" : "' . $subject->code . '",';
			$json .= ' "title" : "' . $subject->title . '",';
			$json .= ' "notes" : "' . $subject->notes . '",';
			$json .= ' "coursework" : [ ';
			foreach ($subject->coursework() as $cw)
			{
				$json .= $this->generate_coursework_json($cw);
			}
			$json = substr($json, 0, -1) . ']},';
			
			return $json;
		}
		
		/*
		 * Generates JSON format for one coursework template
		 */
		private function generate_coursework_json($coursework = NULL)
		{
			if(is_null($coursework)) return "";
			
			// now build the coursework header json
			$json = '{ "title" : "' . $coursework->title . '",';
			$json .= ' "due_date" : "' . $coursework->due_date . '",';
			$json .= ' "notes" : "' . $coursework->notes . '",';
			$json .= ' "weighting" : "' . $coursework->weighting . '"';
			$json .= '},';
			
			return $json;
		}
		
		
		/*
		 * Browse for templates to install
		 */
		public function browse()
		{
			$data['templates'] = Model\Template::limit(20)->all();
			$data['content'] = $this->load->view('template/view_many',$data,true);
			$this->load->view('template',$data);			
		}
	}
	

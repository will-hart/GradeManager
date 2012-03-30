<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Subject extends CI_Controller {
		
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
			$json .= $this->generate_subject_json($id);
			$json .= "]}}";

			$tmp = new Model\Template();
			$tmp->users_id = $this->usr->id;
			$tmp->template = $json;

			if ($tmp->save())
			{
				$this->session->set_flashdata('success','Successfully generated template!');
				redirect('template/manage/'.Model\Template::last_created()->id);
			}
		}
		
		
		/*
		 * Generates JSON format for one subject template
		 * including parsing all the coursework attached
		 */
		private function generate_subject_json($subject = NULL)
		{
			!is_null($id) OR return "";
			
			// now build the subject header json
			$json = '{ "code" : "' . $subject->code . '",';
			$json .= ' "title" : "' . $subject->title . '",';
			$json .= ' "notes" : "' . $subject->notes . '",';
			$json .= ' "coursework" : [ ';
			foreach ($subject->coursework() as $cw)
			{
				$json .= $this->generate_coursework_json($cw);
			}
			$json .= ']}';
			
			return $json;
		}
	}
	

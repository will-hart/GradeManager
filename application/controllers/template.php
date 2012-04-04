<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Template extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
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
		
		
		/* 
		 * install a template into your account
		 */
		public function install($id=0)
		{
			$tmp = Model\Template::find($id);
			$log = "";
			
			if ($id == 0 || is_null($tmp)) 
			{
				$this->session->set_flashdata('error','Unable to install template - no template found!');
				redirect('dashboard');
			}
			
			// decode the json
			$info = json_decode($tmp->template, true);
			$type = $info['template']['type'];
			$obj = $info['template']['data'];	
			$log .= "Installing Template:  <em>" . $tmp->title . "</em>\n<br />\n";
			
			// roll this into a transaction so we can undo changes on an error
			$this->db->trans_begin();
			$errors = TRUE;
			
			// if we are adding a subject we need to work out what the current couParse error: syntax error, unexpected $end, expecting T_FUNCTION in /var/www/grades/application/controllers/template.php on line 210rse is 
			// if we are adding a course we need to create a new one
			if ($type == 'course') {
				$log.= "Creating new course... ";
				$course = new Model\Course();
				$course->users_id = $this->usr->id;
				$course->title = $tmp->course_name & " " & $tmp->year_level;
				$course->save();
				$c_id = Model\Course::last_created()->id;
				$log .= "done\n<br/>\n";
			} else {
				$c_id = $this->session->userdata('default_course');
				$log .= "Adding subject to your course\n<br/>\n";
			}
			
			// now parse the file
			foreach ($obj as $s)
			{
				$sub = new Model\Subject();
				$sub->course_id = $c_id;
				$sub->code = $s['code'];
				$sub->title = $s['title'];
				$sub->notes = $s['notes'];
				$sub->users_id = $this->usr->id;
				$sub->save();
				$log .= "Adding new subject <em>" . $s['title'] . "</em>\n<br/>\n";
				
				$s_id = Model\Subject::last_created()->id;
				
				// now parse the coursework
				foreach($s['coursework'] as $cw)
				{
					$coursework = new Model\Coursework();
					$coursework->title = $cw['title'];
					$coursework->subject_id = $s_id;
					$coursework->due_date = $cw['due_date'];
					$coursework->notes = $cw['notes'];
					$coursework->weighting = $cw['weighting'];
					$coursework->save();
					$log .= "Adding coursework <em>" . $cw['title'] . "</em>\n<br/>\n";
				}
			}
			
			if ($type == 'Course')
			{
				$log .= "<br>Setting this course as your default";
				$profile = $this->usr->profile();
				$profile->default_course = $c_id;
				$profile->save();
			}
			
			$log .= anchor('dashboard','Continue to Dashboard');
			
			// check if we got this far without an error
			if ($errors == false OR $this->db->trans_status() === FALSE)
			{
				$this->db->trans_commit();
				if ($this->db->trans_status() === FALSE) 
				{
					$this->db->trans_rollback();
					$log = "<div class='error'>An error was encountered importing the course, no changes were made! Please try again</div>";
				}
			}
			else 
			{
				$this->db->trans_rollback();
				$log = "<div class='error'>An error was encountered importing the course, no changes were made! Please try again</div>";
			}
			
			$data['install_log'] = $log;
			$data['content'] = $this->load->view('template/install_log', $data, true);
			
			$this->load->view('template', $data);
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
		function _before_render() { throw new BadMethodCallException(); }
	}
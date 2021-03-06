<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Template extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			// set up the model
			$this->model = new Model\Template();
			$this->model_name = 'template';
			$this->check_user_permission = FALSE;
		}
	
			
		/*
		 * Share an entire course template
		 */
		public function share_course($id=0)
		{			
			// get the yearlevel
			$course = Model\Course::find($id);
		
			if($course == null OR empty($course))
			{
				$this->session->set_flashdata('error','Unable to find the course you asked to share');
				redirect('dashboard');
			}
		
			// check this user owns the course
			if (!$this->usr->id == $course->users_id)
			{
				$this->session->set_flashdata('error','You do not have permission to share this course!');
				redirect('dashboard');
			}
			
			// check if the user hit submit
			if ($_POST) 
			{
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
				$tmp->title = $course->title;
				$tmp-> template = $json;
				
				if($tmp->save())
				{
					$new_id = $this->db->insert_id();
					$this->session->set_flashdata('success','Successfully generated template');
					redirect('template/edit/'.$new_id);
				} 
				else 
				{
					$this->session->set_flashdata('error','Error generating template, please try again');
					redirect('dashboard');
				}
			}
			else
			{
				$data['type_name'] = 'course';
				$data['content'] = $this->load->view('sharing_confirmation', $data, TRUE);
				$this->load->view('template', $data);
			}
		}
		
		
		/*
		 * Share a subject template
		 */
		public function share_subject($id = 0)
		{
			// get the subject
			$sub = Model\Subject::find($id);
			
			if ($sub == null OR empty($sub))
			{
				$this->session->set_flashdata('error','Unable to find the subject you asked to share');
				redirect('dashboard');
			}

			// check this user owns the subject
			if (!$this->usr->id == $sub->users_id)
			{
				$this->session->set_flashdata('error','You do not have permission to share this subject!');
				redirect('dashboard');
			}

			if ($_POST)
			{	
				// build a json string from the subject
				$json = '{ "template" : { "type" : "subject", "data" : [';
				$json .= substr($this->generate_subject_json($sub),0,-1);
				$json .= "]}}";

				$tmp = new Model\Template();
				$tmp->users_id = $this->usr->id;
				$tmp->title = $sub->title;
				$tmp->template = $json;

				if ($tmp->save())
				{
					$new_id = $this->db->insert_id();
					$this->session->set_flashdata('success','Successfully generated template!');
					redirect('template/edit/'.$new_id);
				}
				else 
				{
					$this->session->set_flashdata('error','Error generating template, please try again');
					redirect('dashboard');
				}
			}
			else
			{
				$data['type_name'] = 'subject';
				$data['content'] = $this->load->view('sharing_confirmation', $data, TRUE);
				$this->load->view('template', $data);
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
		public function index()
		{
			$data['templates'] = Model\Template::limit(20)->all();
			$data['user_id'] = $this->usr->id;
			$data['content'] = $this->load->view('template/view_many',$data,true);
			$this->load->view('template',$data);			
		}
		
		/*
		 * Browse action is an alias for index
		 */
		public function browse()
		{
			$this->index();
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
			$info = json_decode($tmp->template, TRUE);
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
				$course->title = $tmp->course_name . " (Year " . $tmp->year_level . ")";
				$course->save();
				$c_id = $this->db->insert_id();
				$data['course_id'] = $c_id; //for a link to set as default
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

					// if the due date is in the past, set email alerted to true
					if (strtotime(date("Y-m-d")) > strtotime($cw['due_date'])) {
						$coursework->alert_sent = 1;
						$log .= "Coursework past due date - email alert disabled<br/>";
					}

					$coursework->notes = $cw['notes'];
					$coursework->weighting = $cw['weighting'];
					$coursework->status_id = Model\Status::NONE;
					$coursework->users_id = $this->usr->id;
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
				
			// check if we got this far without an error
			if ($errors === FALSE OR $this->db->trans_status() === FALSE)
			{
				$this->db->trans_commit();
				if ($this->db->trans_status() === FALSE) 
				{
					$this->db->trans_rollback();
					$log .= "<div class='error'>1 An error was encountered importing the course, no changes were made! Please try again</div>";
				}
			}
			else 
			{
				$log .= "<strong>Course successfully imported!</strong>";
			}
			
			$data['install_log'] = $log;
			$data['content'] = $this->load->view('template/install_log', $data, TRUE);
			
			$this->load->view('template', $data);
		}

		// default callbacks
		public function _before_view() 
		{
			$json = json_decode($this->model->template, TRUE); 
			$this->data['objects'] = $json['template']['data'];
			$this->data['user_id'] = $this->usr->id;
			$this->data['content'] = $this->load->view('template/view_one', $this->data, TRUE); 
		}
		public function _after_view() { return; }
		public function _before_render() { $this->data['template'] = $this->model; }
		
		
		public function _after_edit()
		{
			redirect('template/view/'.$this->model->id);
		}
		
		public function _before_edit()
		{
			$this->data['action'] = 'edit';
			$this->data['content'] = $this->load->view('template/manage_single', $this->data, TRUE);
		}
		function _before_save() { return; }
		function _after_save() { return; }
		
		public function _before_delete()
		{
			$this->data['type_url'] = 'template';
			$this->data['type_name'] = 'Template';
			$this->data['content'] = $this->load->view('delete_confirmation', $this->data, TRUE);
		}
		
		public function _after_delete()
		{
			redirect('template'); // redirect to the user profile
		}

		// define abstract methods
		function _before_create() { throw new BadMethodCallException(); }
		function _after_create() { throw new BadMethodCallException(); }
	}

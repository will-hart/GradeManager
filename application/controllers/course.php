<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Course extends Application {
			
				
		// Set up the validation rules
		
		
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			$this->validation_rules = array(
				'title' => array (
					'field' 		=> 		'title',
					'label'			=> 		'Subject Title',
					'rules'			=>		'trim|xss_clean|max_length[255]|required'
				),
			);
			
			// set up the default conditions
			$this->model = new Model\Course();
			$this->model_name = 'course';
			$this->check_user_permission = TRUE;
		}
	
	
		/*
		 * Show the user's courses
		 */
		public function index()
		{
			$data['courses'] = Model\Course::where('users_id',$this->usr->id)->all();
			$data['content'] = $this->load->view('course/view_many', $data, true);
			$this->load->view('template',$data);
		}
		
		public function _before_render() { return; }
		public function _after_view() { return; }
		public function _before_view()
		{
			$this->data['action'] = 'view';
			$this->data['content'] = $this->load->view('course/view_one',$this->data, TRUE);
		}	
		
		/*
		 * Creates a new course with default data and redirect to the edit screen
		 */
		public function create()
		{
			$course = new Model\Course();
			$course->users_id = $this->usr->id;
			$course->title="New Course";
			if($course->save())
			{
				$id = Model\Course::last_created()->id;
				$this->session->set_flashdata('success','New course created!');
				redirect('course/edit/'.$id);
			}
			else
			{
				$this->session->set_flashdata('error','Error creating new course, please try again.');
				redirect('profile');
			}
		}
			
		/*
		 * Edit a course
		 */
		public function edit ($id = 0)
		{
			// check for no subject id and redirect to dashboard
			$course = Model\Course::find($id);			
			if ($course == NULL) 
			{
				$this->session->set_flashdata('error','Unable to find the course you requested, please try again.');
				redirect('dashboard');
			}
			
			// check this is our subject
			if ($course->users_id != $this->usr->id) {
				$this->session->set_flashdata('error','You do not have permission to view this course!');
				redirect('dashboard');
			}
			
			// set and run validation rules
			$this->form_validation->set_rules($this->validation_rules);
			
			// check if we submitted our edits and they are valid
			if($_POST && $this->form_validation->run() === TRUE)
			{
			
			
				// update the model
				$course->title = $this->input->post('title');
					
				// save the model
				if ($course->save())
				{
					$this->session->set_flashdata('success','Successfully updated course');
					redirect('course/view/'.$course->id);
				}
				else
				{
					$this->session->set_flashdata('error','Error saving course, please try again');
				}
			}
			
			// show the editing form
			$data['course'] = $course;
			$data['action'] = 'edit';
			$data['content'] = $this->load->view('course/manage_single', $data, true);
			$this->load->view('template',$data);
		}
		
		/*
		 * Delete a course 
		 */
		public function delete($id=0)
		{	
			// check for no subject id and redirect to dashboard
			$course = Model\Course::find($id);			
			if ($course == NULL) 
			{
				$this->session->set_flashdata('error','Unable to locate the course you requested');
				redirect('dashboard');
			}
			
			// check this is our subject
			if ($course->users_id != $this->usr->id) {
				$this->session->set_flashdata('error','You do not have permission to view this course!');
				redirect('dashboard');
			}
			
			// if the user has confirmed deletion, delete away
			if ($this->input->post('delete') == 'Yes')
			{				
				// delete all the associated coursework objects
				$subjects = $course->subject();
				foreach($subject as $s)
				{
					$courseworks = $s->coursework();
					foreach($coursework as $c)
					{
						$c->delete();
					}
					$s->delete();
				}
				$course->delete();
				
				// check if we deleted the user's default course
				if ($id == $this->session->userdata('default_course'))
				{
					$profile = $this->usr->profile();
					$profile->default_course = 0;
					$profile->save();
				}
				
				// notify success
				$this->session->set_flashdata('success','Successfully deleted course');
				redirect("dashboard");
			}
			
			// otherwise we are showing the delete confirmation form
			$data['type_url'] = 'course';
			$data['type_name'] = 'Course';
			$data['content'] = $this->load->view('delete_confirmation',$data,true);
			$this->load->view('template',$data);
		}
		
		/*
		 * Set this course as the user's default
		 */
		public function set_default($id = 0)
		{
			// make sure we can find a course
			$course = Model\Course::find($id);
			if (is_null($course))
			{
				$this->session->set_flashdata('error','Unable to set this course as your default course as no course was found!');
				redirect('profile');
			}
			
			// if we found a course then check the user is allowed to acces this course
			if ($course->users_id != $this->usr->id) 
			{
				$this->session->set_flashdata('error', 'You do not have permission to set this course as your default course!');
				redirect('profile');
			}
			
			$profile = $this->usr->profile();
			$profile->default_course = $id;
			
			if ($profile->save())
			{
				$this->session->set_flashdata('success','Successfully updated your profile');
				redirect('dashboard');
			} 
			else
			{
				$this->session->set_flashdata('error','Error updating your profile, please try again');
				redirect('profile');
			}
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
	

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Course extends Application {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) 
			{
				$this->session->set_userdata('attempted_uri', $this->uri->uri_string());
				redirect('login');
			}
			
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
		public function _before_save() { return; }
		public function _after_save() { return; }
		
		public function _before_view()
		{
			$this->data['action'] = 'view';
			$this->data['subjects'] = $this->model->subject();
			$this->data['subject_listing'] = $this->load->view('subject/view_many', $this->data, TRUE);
			$this->data['content'] = $this->load->view('course/view_one',$this->data, TRUE);
		}
		
		public function _after_edit() {
			redirect('course/view/'.$this->model->id);
		}
		
		public function _before_edit()
		{
			$this->data['action'] = 'edit';
			$this->data['content'] = $this->load->view('course/manage_single', $this->data, TRUE);
		}
		
		public function _before_create()
		{
			$this->model->users_id = $this->usr->id;
			$this->model->title="New Course";
		}
		
		public function _after_create()
		{
			redirect('course/edit/'.$this->model->id);
		}
		
		public function _before_delete()
		{
			$this->data['type_url'] = 'course';
			$this->data['type_name'] = 'Course';
			$this->data['content'] = $this->load->view('delete_confirmation', $this->data, TRUE);
			$this->subjects = $this->model->subject();
			$this->course_id = $this->model->id;
		}
		
		public function _after_delete()
		{
			// now remove remaining objects tied to this course
			foreach($this->subjects as $s)
			{
				$courseworks = $s->coursework();
				foreach($courseworks as $c)
				{
					$c->delete();
				}
				$s->delete();
			}
			
			// check how many courses the user has left
			$c = $this->db
				->select('COUNT(id) AS num')
				->where('users_id', $this->usr->id)
				->get('course')
				->result();
			
			$no_courses_left = FALSE;
			if(empty($c) OR $c[0]->num == 0) {
				$no_courses_left = TRUE;
			}
			
			// check if we deleted the user's default course
			if ($this->course_id == $this->session->userdata('default_course') OR $no_courses_left) {
				$profile = $this->usr->profile();
				$profile->default_course = 0;
				$profile->first_login = 1;
				$profile->save();
			}
			
			redirect('course'); // redirect to the user profile
		}
		
		/*
		 * Set this course as the user's default
		 */
		public function set_default($id = 0)
		{
			// make sure we can find a course
			$this->model = Model\Course::find($id);
			if (is_null($this->model))
			{
				$this->session->set_flashdata('error','Unable to set this course as your default course as no course was found!');
				redirect('profile');
			}
			
			// if we found a course then check the user is allowed to acces this course
			if ($this->model->users_id != $this->usr->id) 
			{
				$this->session->set_flashdata('error', 'You do not have permission to set this course as your default course!');
				redirect('profile');
			}
			
			$profile = $this->usr->profile();
			$profile->default_course = $id;
			$profile->first_login = 0;
			
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
	}
	

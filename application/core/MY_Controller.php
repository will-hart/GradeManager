<?php

abstract class Application extends CI_Controller
{
	
	protected $usr; // stores the user object
	protected $validation_rules; // holds field information and validation rules
	protected $data; // holds data to be displayed in forms
	protected $model; // the model to be used
	protected $model_name; 
	protected $check_user_permission;
	protected $default_template;
	protected $parent; // holds protected parent ids
	
	private $fields;
	
	public function __construct()
	{
		parent::__construct();
			
		// get the user and default_course if we are logged in
		if ($this->ag_auth->logged_in()) {
			// get the user object
			$this->usr = Model\User::find($this->session->userdata("user_id"));

			// if we are logged in set the default_course id
			$this->session->set_userdata('default_course', $this->usr->profile()->default_course);
			
			// check if this is the user's first login and redirect
			if ($this->usr->profile()->first_login == '1') 
			{
				$this->session->set_flashdata('notice',"You don't currently have a default course! Please create one or set one from the 'View Courses' link");
				if ($this->uri->segment(1) == 'dashboard') redirect('profile');
			}
		}
		
		// initialise the validation rules
		$this->validation_rules = array();
		$this->data = array();
		$this->model = NULL;
		$this->model_name = 'not_set';
		$this->check_user_permission = TRUE;
		$this->default_template = 'template';
		$this->parent = array();
	}


	/*
	 * View a single model
	 */
	public function view($id = 0)
	{
		// check we have found an object for this id
		$this->model = $this->model->find($id);
		$this->data[$this->model_name] = $this->model;
		
		// check for permissions
		$this->permission_checks();
		
		// render the template
		$this->_before_view();
		$this->render();
		$this->_after_view();
	}
	
	/* 
	 * Edit a single model, the model's fields properties are used to build it
	 */
	public function edit($id = 0)
	{
		$this->model = $this->model->find($id);// find the model
		$this->fields = $this->model->meta['fields'];// get an array of the field meta data
		$this->data[$this->model_name] = $this->model; 
		
		// check we have permission to access this resource
		$this->permission_checks();
		
		if ($_POST) // if we have submitted some post data
		{
			$this->make_from_post();
			
			// we have made some changes, update the model link in the view data
			$this->data[$this->model_name] = $this->model;
			
			// pre-save callbacks
			$this->_before_save();
			
			// check if we submitted our edits and they are valid
			if($this->model->save(TRUE))
			{
				$this->_after_save();	
				$this->session->set_flashdata('success','Successfully updated '.$this->model_name);
				$this->_after_edit();
			}
			else
			{
				$this->session->set_flashdata('error','Error saving '.$this->model_name .', please try again');
			}
		}
		
		// show the editing form
		$this->_before_edit();
		$this->render();
	}

	/* 
	 * create a new record in the database
	 */
	public function create()
	{
		// check we have permission
		$this->permission_checks();
		
		// build initial data from the post variables
		$this->fields = $this->model->meta['fields'];// get an array of the field meta data
		$this->make_from_post();
		
		// set any default data with the _before_create callback
		$this->_before_create();
		
		// perform the save
		$this->_before_save();
		if ($this->model->save())
		{
			$this->_after_save();
			$this->session->set_flashdata('success','Successfully created new '.$this->model_name);
			//$this->model = $this->model->last_created();
			$this->model->id = $this->db->insert_id();
			$this->_after_create();
		}
		else 
		{
			$this->session->set_flashdata('error','Unable to save the coursework! Please try again.');
		}
		
		// render the form
		$this->render();
		
	}
	
	
	/* 
	 * Delete a single record.  Related records can be deleted using the _before_delete callback
	 */
					
		/*
		 * Delete a coursework
		 */
		public function delete($id=0)
		{
			// check we have find a coursework for this id
			$this->model = $this->model->find($id);
			
			// check permissions
			$this->permission_checks();
			
			$this->_before_delete();
			
			// if the user has confirmed deletion, delete away
			if ($this->input->post('delete') == 'Yes')
			{
				$this->model->delete();
				$this->session->set_flashdata('success','Successfully deleted coursework');
				$this->_after_delete();
			}
			
			// otherwise we are showing the delete confirmation form
			$this->render();
		}
	
	
	/* 
	 * Check that the user has permission to access this resource, and that a resource was found
	 */
	private function permission_checks()
	{
		if ($this->model == NULL) {
			$this->session->set_flashdata('error',"Error finding the requested ".$this->model_name." - are you sure that it exists?");
			redirect('dashboard');
		}
		
		// check this user is allowed to access it
		if ($this->check_user_permission AND $this->usr->id != $this->model->users_id) 
		{
			$this->session->set_flashdata('error',"You do not have permission to view this ".$this->model_name);
			redirect('dashboard');
		}
	}
	
	/*
	 * Build up a model form post data
	 */
	private function make_from_post()
	{
		// set up the model with new data submitted via post
		foreach($_POST as $k => $v)
		{
			// make sure this key is not primary, timestamp and is a valid key
			if (	array_key_exists($k, $this->fields) &&
					$k != $this->model->primary_key &&
					!array_key_exists($k, $this->model->ts_fields)
			   )
			{
				$this->model->$k = $this->input->post($k); // get the variable from post data
			}
		}
	}
	
	/*
	 * Uses the $this->parent array to update parent links
	 */
	protected function update_parent_links()
	{
		foreach($this->parent as $k => $v)
		{
			if(!is_null($v))
			{
				$k_id = $k."_id";
				$this->model->$k_id = $v->id;
			}
		}
	}	
	
	/*
	 * Render the default template
	 */
	public function render() 
	{
		$this->_before_render(); // the pre-render template
		$this->load->view($this->default_template,$this->data);
	}
	
	
	// call backs - defined as abstract so they are overriden in the derived class
	abstract function _before_save();
	abstract function _after_save();
	abstract function _before_create();
	abstract function _after_create();
	abstract function _before_edit();
	abstract function _after_edit();
	abstract function _before_delete();
	abstract function _after_delete();
	abstract function _before_view();
	abstract function _after_view();
	abstract function _before_render();
}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */

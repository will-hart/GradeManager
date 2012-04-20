<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/core/REST_Controller.php';

class Api extends REST_Controller
{
	
	/*
	 * Add a filter whitelist which allows or restricts api filtering
	 * by certain fields - note this is not for read/write, but GET 
	 * method filtering only
	 */
	private $filter_whitelist = array(
		"user" => array('id', 'username', 'email'),
		"profile" => array('id', 'users_id', 'first_name','last_name','default_course','emails_allowed'),
		"course" => array('id', 'users_id'),
		"subject" => array('id','course_id','code','title'),
		"coursework" => array('id', 'users_id', 'subject_id', 'title', 'due_date', 'status_id'),
	);
	
	/*
	 * Add a write whitelist which allows or restricts api writing
	 * by certain fields
	 */
	private $write_whitelist = array(
		"profile" => array('first_name','last_name','default_course','emails_allowed'),
		"course" => array('title'),
		"subject" => array('code','title','notes','score','complete'),
		"coursework" => array('title','due_date','alert_sent','status_id','notes','score','weighting'),
	);
	
	/*
	 * Gets either a single user or a list of users.
	 * A single user is obtained if an id is passed in get variables
	 */
	function user_get()
	{
		
		$data = NULL;
		
		// check if filters were passed
		$get = $this->get();		
		if (! empty($get) )
		{
			// parse the filters, checking they are in the whitelist first
			foreach ($get as $key => $arg)
			{
				if (in_array($key, $this->filter_whitelist['user']))
				{
					$this->db->where($key, $arg);
				}
			}
		}
		
		//perform the query
		$data = $this->db
			->get('users')
			->result();
		
		// now return the response
		$this->response($data, 200);
	}
		
	/*
	 * Gets either a single coursework or a list of courseworks.
	 * A single coursework is obtained if an id is passed in get variables
	 */
	function coursework_get()
	{
		
		$data = NULL;
		
		// check if filters were passed
		$get = $this->get();		
		if (! empty($get) )
		{
			// parse the filters, checking they are in the whitelist first
			foreach ($get as $key => $arg)
			{
				if (in_array($key, $this->filter_whitelist['coursework']))
				{
					$this->db->where($key, $arg);
				}
			}
		}
		
		//perform the query
		$data = $this->db
			->get('coursework')
			->result();
		
		// now return the response
		$this->response($data, 200);
	}
	
	
	/*
	 * Edits a coursework object, or if the post variable "new_record" == 1 
	 * it creates a new record
	 */
	function coursework_post()
	{
		$record = NULL;
		
		// check if we are creating a new record
		if($this->input->post("new_record") == '1')
		{
			$record = new Model\Coursework();
		}
		else
		{
			$record = Model\Coursework::find($this->input->post('id'));
			if ($record == NULL OR empty($record))
			{
				$this->response(array('status'=>FALSE,'error_message'=>'Attempted to edit an unknown coursework'));
			}
		}
		
		// update the passed variables
		$post = $this->input->post();		
		// parse the filters, checking they are in the whitelist first
		foreach ($post as $key => $arg)
		{
			if (in_array($key, $this->write_whitelist['user']))
			{
				$record->$key = $arg;
			}
		}
		
		// do the update
		if ($record->save(TRUE))
		{
			$this->response(array('status'=>TRUE));
		}
		else
		{
			$this->response(array('status'=>FALSE, 'error_message'=>validation_errors()), 400);
		}
	}
	
	
	/*
	 * Gets either a single subject or a list of subjects.
	 * A single subject is obtained if an id is passed in get variables
	 */
	function subject_get()
	{
		
		$data = NULL;
		
		// check if filters were passed
		$get = $this->get();		
		if (! empty($get) )
		{
			// parse the filters, checking they are in the whitelist first
			foreach ($get as $key => $arg)
			{
				if (in_array($key, $this->filter_whitelist['subject']))
				{
					$this->db->where($key, $arg);
				}
			}
		}
		
		//perform the query
		$data = $this->db
			->get('subject')
			->result();
		
		// now return the response
		$this->response($data, 200);
	}
	
	
	/*
	 * Gets either a single course or a list of courses.
	 * A single course is obtained if an id is passed in get variables
	 */
	function course_get()
	{
		
		$data = NULL;
		
		// check if filters were passed
		$get = $this->get();		
		if (! empty($get) )
		{
			// parse the filters, checking they are in the whitelist first
			foreach ($get as $key => $arg)
			{
				if (in_array($key, $this->filter_whitelist['course']))
				{
					$this->db->where($key, $arg);
				}
			}
		}
		
		//perform the query
		$data = $this->db
			->get('course')
			->result();
		
		// now return the response
		$this->response($data, 200);
	}
}

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
	 * Gets either a single user or a list of users.
	 * A single user is obtained if an id is passed in get variables
	 */
	function user_get()
	{
		
		$data = NULL;
		
		// if an id was passed only return one record
		if ($this->get('id'))
		{
			$data = $this->db
				->where(array('id'=>$this->get('id')))
				->get('users')
				->result();
		}
		else {
			$data = $this->db
				->get('users')
				->result();
		}
		
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
		
		// if an id was passed only return one record
		if ($this->get('id'))
		{
			$data = $this->db
				->where(array('id'=>$this->get('id')))
				->get('coursework')
				->result();
		}
		else {
			$data = $this->db
				->get('coursework')
				->result();
		}
		
		// now return the response
		$this->response($data, 200);
	}
	
	
	/*
	 * Gets either a single subject or a list of subjects.
	 * A single subject is obtained if an id is passed in get variables
	 */
	function subject_get()
	{
		
		$data = NULL;
		
		// if an id was passed only return one record
		if ($this->get('id'))
		{
			$data = $this->db
				->where(array('id'=>$this->get('id')))
				->get('subject')
				->result();
		}
		else {
			$data = $this->db
				->get('subject')
				->result();
		}
		
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
		
		// if an id was passed only return one record
		if ($this->get('id'))
		{
			$data = $this->db
				->where(array('id'=>$this->get('id')))
				->get('course')
				->result();
		}
		else {
			$data = $this->db
				->get('course')
				->result();
		}
		
		// now return the response
		$this->response($data, 200);
	}
}

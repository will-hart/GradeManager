<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/core/REST_Controller.php';

class Api extends REST_Controller
{
	
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
			$data = Gas\User::find($this->get('id'));
		}
		else {
			$data = Gas\User::all();
		}
		
		// now return the response
		$this->response($data, 200);
	}
	
		
	/*
	 * Gets either a single user or a list of users.
	 * A single user is obtained if an id is passed in get variables
	 */
	function coursework_get()
	{
		
		$data = NULL;
		
		// if an id was passed only return one record
		if ($this->get('id'))
		{
			$data = Gas\Coursework::find($this->get('id'));
		}
		else {
			$data = Gas\Coursework::all();
		}
		
		// now return the response
		$this->response($data, 200);
	}
}
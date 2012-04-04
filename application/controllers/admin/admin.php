<?php

class Admin extends Application
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		if(logged_in())
		{
			$this->ag_auth->view('dashboard');
		}
		else
		{
			$this->login();
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
	function _before_render() { throw new BadMethodCallException(); }
}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */

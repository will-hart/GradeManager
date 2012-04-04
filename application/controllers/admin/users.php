<?php

class Users extends Application
{
	
	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('admin'); // restrict this controller to admins only
	}
	
	public function manage()
	{
	    $this->load->library('table');		
			
		$data = $this->db->get($this->ag_auth->config['auth_user_table']);
		$result = $data->result_array();
		$this->table->set_heading('Username', 'Email', 'Actions'); // Setting headings for the table
		
		foreach($result as $value => $key)
		{
			$actions = anchor("admin/users/delete/".$key['id']."/", "Delete"); // Build actions links
			$this->table->add_row($key['username'], $key['email'], $actions); // Adding row to table
		}
		
		$this->ag_auth->view('users/manage'); // Load the view
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id)->delete($this->ag_auth->config['auth_user_table']);
		$this->ag_auth->view('users/delete_success');
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

?>
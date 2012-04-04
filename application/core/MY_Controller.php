<?php
/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 2.0.3
* @copyright Adam Griffiths 2011
*
* Auth provides a powerful, lightweight and simple interface for user authentication .
*/

abstract class Application extends CI_Controller
{
	
	protected $usr; // stores the user object
	protected $validation_rules;
	
	public function __construct()
	{
		parent::__construct();
		
		log_message('debug', 'Application Loaded');

		$this->load->library(array('form_validation', 'ag_auth'));
		$this->load->helper(array('url', 'email', 'ag_auth'));
		
		$this->config->load('ag_auth');
	
		// get the user and default_course if we are logged in
		if ($this->ag_auth->logged_in()) {
			// get the user object
			$this->usr = Model\User::find($this->session->userdata("user_id"));

			// if we are logged in set the default_course id
			$this->session->set_userdata('default_course', $this->usr->profile()->default_course);
			
			// check if this is the user's first login and redirect
			if ($this->uri->segment(1) != 'profile' && $this->usr->profile()->first_login == '1') 
			{
				$this->session->set_flashdata('notice','As this is your first logon, please update your profile and save it.  At this stage you should also create a new course, or import an existing course template.');
				redirect('profile');
			}
		}
		
		// initialise the validation rules
		$this->validation_rules = array();
	}
	
	public function field_exists($value)
	{
		$field_name  = (valid_email($value)  ? 'email' : 'username');
		
		$user = $this->ag_auth->get_user($value, $field_name);
		
		if(array_key_exists('id', $user))
		{
			$this->form_validation->set_message('field_exists', 'The ' . $field_name . ' provided already exists, please use another.');
			
			return FALSE;
		}
		else
		{			
			return TRUE;
			
		} // if($this->field_exists($value) === TRUE)
		
	} // public function field_exists($value)
	
	public function register()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|callback_field_exists');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');
		$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE)
		{
			$this->ag_auth->view('register');
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$email = set_value('email');

			if($this->ag_auth->register($username, $password, $email) === TRUE)
			{
				$data['message'] = "The user account has now been created.";
				$this->ag_auth->view('message', $data);
				
			} // if($this->ag_auth->register($username, $password, $email) === TRUE)
			else
			{
				$data['message'] = "The user account has not been created.";
				$this->ag_auth->view('message', $data);
			}

		} // if($this->form_validation->run() == FALSE)
		
	} // public function register()
	
	
	public function login($redirect = NULL)
	{
		//check if hte user is logged in and redirect if they are
		if ($this->ag_auth->logged_in()) redirect('dashboard');
		
		if($redirect === NULL)
		{
			$redirect = $this->ag_auth->config['auth_login'];
		}
		
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->ag_auth->view('login');
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$field_type  = (valid_email($username)  ? 'email' : 'username');
			
			$user_data = $this->ag_auth->get_user($username, $field_type);
			
			
			if($user_data['password'] === $password)
			{
				
				unset($user_data['password']);
				$user_data['user_id'] = $user_data['id']; 
				unset($user_data['id']);

				$this->ag_auth->login_user($user_data);

				redirect($redirect);
				
			} // if($user_data['password'] === $password)
			else
			{
				$data['message'] = "The username and password did not match.";
				$this->ag_auth->view('message', $data);
			}
		} // if($this->form_validation->run() == FALSE)
		
	} // login()
	
	public function logout()
	{
		$this->ag_auth->logout();
	}
	
	
	/*
	 * Render the default template
	 */
	public function render() 
	{
		$this->load->view('template',$this->data);
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
	abstract function _before_render();
}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */

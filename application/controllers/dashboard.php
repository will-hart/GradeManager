<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Dashboard extends CI_Controller {
		
		private $usr; // stores the user object
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
			// redirect to the login page if no session exists
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
			
			// get the user object
			$this->usr = Model\User::find($this->session->userdata("user_id"));
		}
	
		public function index()
		{
			$content = "Hello ".$this->usr->username;
			
			$content .= "<br/>##########################<br/>";
			
			$content .=  "<table>";
			foreach($this->usr->subject() as $subj)
			{
				$content .=  "<tr><td>" . $subj->code . "</td><td>" . $subj->title . "</td></tr>";
			}
			$content .=  "</table>";
			
			$content .=  "<br/><br/>##########################<br/>";
			
			$data['content'] = $content;
			$this->load->view('template',$data);
		}
	}

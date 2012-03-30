<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Dashboard extends CI_Controller {
		
		public $usr; // stores the user object
		
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
			$data['username'] = $this->usr->username;
			$data['subjects'] = $this->usr->subject();
			$data['action'] = 'dashboard';
			$data['content'] = $this->load->view('dashboard/dashboard_stats',$data,true);
			$data['content'] .= $this->load->view('subject/view_many',$data,true);
			$data['content'] .= $this->load->view('subject/manage_single', $data, true);
			$this->load->view('template',$data);
		}
	}

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");


	class Dashboard extends CI_Controller {
		
		public function __construct()
		{
			parent::__construct();
			if($this->session->userdata('logged_in') === FALSE) redirect('login');
		}
	
		public function index()
		{
			echo "Hello dashboard";
						
		}
	}

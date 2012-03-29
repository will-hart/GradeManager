<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");


	class Dashboard extends Application {
	
	
		public function __construct()
		{
			parent::__construct();
		}
	
		public function index()
		{
			echo "Hello dashboard";
		}
		
		public function log_check()
		{
			$this->load->spark('fire_log/0.8.2');
		}
	}

<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");


	class Dashboard extends Application {
	
	
		public function __construct()
		{
			parent::__construct();
		}
	
		public function index()
		{
			echo "Hello dashboard";
			$user = new Model\User();
			
		}
	}

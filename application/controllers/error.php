<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	/**
	 * A Class to display custom error pages drawing on CI templates
	 */
	class Error extends CI_Controller {
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
		}
	
		/*
		 * If no error type is given, redirect to the home page
		 */
		public function index()
		{
			// redirect to the home page
			redirect('');
		}
		
		/** 
		 * Show the custom 404 error page
		 */
		public function error_404()
		{
			$data['content'] = $this->load->view('errors/error_404', NULL, TRUE);
			$this->load->view('template', $data);
		}
	}
	

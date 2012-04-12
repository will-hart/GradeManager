<?php if (!defined('BASEPATH')) exit ("No direct script access allowed!");

	
	class Manage extends CI_Controller {
			
		
		public function __construct()
		{
			// call the parent constructor
			parent::__construct();
			
		}
	
	
		/*
		 * If the index is called redirect to the user dashboard
		 */
		public function index()
		{
			redirect('dashboard');  // go back to the user dashboard
		}
		
		/*
		 * Called by a cron job to send email alerts
		 */
		public function send_alerts()
		{
			// SAMPLE CODE
			$this->load->library('PostageApp');
			$this->postageapp->from('hart.wl@gmail.com');
			$this->postageapp->to('hart.wl@gmail.com');
			$this->postageapp->subject('Test PostageApp Email');
			$this->postageapp->message('This is a sample message for inclusion in your file');
			$this->postageapp->template('sample_parent_layout');
			$this->postageapp->variables(array('name'=>'Will'));
			$this->postageapp->send();
		}
	}
	

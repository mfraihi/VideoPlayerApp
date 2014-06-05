<?php

class About extends CI_Controller {

	public function index()
	{
		$this->load->helper('MY_date');
		$this->load->helper('url');
		
		$this->template->set('title', 'About Us');
		$this->template->load('template', 'about');
		
	}
	
}
?>
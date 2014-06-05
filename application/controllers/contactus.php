<?php

class Contactus extends CI_Controller {

	public function index()
	{
		$this->load->helper('MY_date');
		$this->load->helper('url');
		
		$this->template->set('title', 'Contact Us');
		$this->template->load('template', 'contactus');
		
	}
	
}
?>
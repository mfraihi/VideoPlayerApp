<?php

class Privacypolicy extends CI_Controller {

	public function index()
	{
		$this->load->helper('MY_date');
		$this->load->helper('url');
		
		
		
		$this->template->set('title', 'Privacy Policy');
		$this->template->load('template', 'privacypolicy');
		
	}
	
}
?>
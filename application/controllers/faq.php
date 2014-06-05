<?php

class Faq extends CI_Controller {

	public function index()
	{
		$this->load->helper('MY_date');
		$this->load->helper('url');
		
		$this->template->set('title', 'Frequently Asked Questions');
		$this->template->load('template', 'faq');
		
	}
	
}
?>
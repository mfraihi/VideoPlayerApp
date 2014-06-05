<?php

class Login extends CI_Controller {
	
	 public function __construct()
	 {
		parent::__construct();
	 }
	 
	function index(){
		$this->load->helper('form');
		$this->load->helper('url');
		session_start();
		
		if(isset($_POST['login']) and isset($_POST['password'])){
			echo "test";
			
			$login = $_POST['login'];
			$password = $_POST['password'];
			
			$login_api_call = json_decode(file_get_contents(API_URL . "login2?login=" . $login . "&password=" . $password), true);
			print_r($login_api_call);
			$_SESSION['user_id'] = $login_api_call['user_id'];
			
			print_r($_COOKIE);
		}
		
		$data['a'] = "";
		$this->template->set('title', 'Login');
		$this->template->load('template', 'login', $data);
	}	
	
	function no_results(){
		
	}
	
	function dishes(){

	}
	
	function restaurants(){
		$this->index();
	}
	
	function people(){

	}
}
?>
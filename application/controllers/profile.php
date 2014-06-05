<?php

class Profile extends CI_Controller {
	
	 public function __construct()
	 {
		parent::__construct();
	 }
	 
	function get_geo_location(){
		
	}
	
	function index(){
		$this->load->helper('form');
		$this->load->helper('url');
		
		$user_id = $this->uri->segment(2);
		echo API_URL . "getProfile?user_id=" . $user_id;
		echo "<br>";
		/*
		 *{"profile":{"facebook_id":"197402501","first_name":"Mohammed","last_name":"Al-f","name":"Mohammed Al-f","email":"amosh_x@hotmail.com",
		 "gender":"male","joined":1358897182,"image_url":"https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/369248_197402501_1794649691_q.jpg",
		 "followers":2,"following":2,"num_clips":7,"isFollowing":false,"isMe":false,"unique_id":"8b40b157-c940-4011-b159-b25554cf134a","points":715,
		 "rank":0,"profile_complete":60,"restaurant_bookmarks":[],"deal_bookmarks":[],"dish_bookmarks":[],"clip_bookmarks":[],"clips":[]},
		 "success":true,"points_difference":0,"points_total":0,"page":0,"has_more":false}
		 */
		$user_api_call = json_decode(file_get_contents(API_URL . "getProfile?user_id=" . $user_id), true);
		
		print_r(file_get_contents(API_URL . "getProfile?user_id=" . $user_id));
		exit;
		$user_data = $user_id['profile'];
		
		$data['firs_name'] = $user_data['first_name'];
		$data['last_name'] = $user_data['last_name'];
		$data['full_name'] = $user_data['full_name'];
		$data['joined'] = $user_data['joined'];
		$data['image_url'] = $user_data['image_url'];
		$data['followers'] = $user_data['followers'];
		$data['following'] = $user_data['following'];
		$data['num_clips'] = $user_data['num_clips'];
		$data['unique_id'] = $user_data['unique_id'];
		$data['points'] = $user_data['points'];
		//$data[''] = $user_data[''];
		
		
		//foreach($api_call['dish_clips_restaurants'] as $a) print_r($a); echo "hei<BR><BR><BR><BR><BR>";
		//print_r($api_call);
		
		$this->template->set('title', 'Search');
		$this->template->load('template', 'search', $data);
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
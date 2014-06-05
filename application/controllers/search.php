<?php

class Search extends CI_Controller {
	
	 public function __construct()
	 {
		parent::__construct();
	 }
	
	function index(){
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('icons');
		$this->load->helper('dishbox');
		
		$q = !empty($_GET['q']) ? rawurlencode($_GET['q']) : "";
		$clipsOnly = isset($_GET['clipsOnly']) and ($_GET['clipsOnly'] == 1) ? true : false;
		$data['clipsOnly'] = $clipsOnly;
		
		if(!empty($_GET['loc'])):
			$loc = ucwords(rawurlencode($_GET['loc']));
		else:
			$geo_loc_data = '';
			$ip = $_SERVER['REMOTE_ADDR'];
			//$ip = "204.75.251.3";
			$geo_loc_data = json_decode(file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=de83a552e1630948c073b97075b77fc65a4e1c042dfdb9acc8d9a46a083647e9&format=json&ip='.$ip));
			$loc =  rawurlencode(ucwords(strtolower("$geo_loc_data->cityName, $geo_loc_data->regionName")));
		endif;
		
		$show_results = true;
		$data['q'] = rawurldecode($q);
		$data['loc'] = rawurldecode($loc);
		
		$api_call_url =  $clipsOnly ? API_URL . "searchRestaurants2?address=" . $loc . "&search=" . $q . "&sort=distance&clipsOnly=true" :
					      API_URL . "searchRestaurants2?address=" . $loc . "&search=" . $q . "&sort=distance";
		
		$api_call = iconv('UTF-8', 'ASCII//TRANSLIT', file_get_contents($api_call_url));
		$api_call = json_decode(utf8_decode($api_call), true);
		
		//print_r($api_call);
		//print_r(file_get_contents($api_call_url));
		$data['restaurants_list'] = $api_call;
		
		if($api_call == NULL || isset($api_call['error'])) $show_results = false;
		
		$data['show_results'] = $show_results;
		//foreach($api_call['dish_clips_restaurants'] as $a) print_r($a); echo "hei<BR><BR><BR><BR><BR>";
		//print_r($api_call);
		
		$this->template->set('title', 'DishClips &raquo; Search');
		$this->template->load('template', 'search', $data);
	}
}
?>
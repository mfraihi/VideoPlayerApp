<?php
	class Index extends CI_Controller{
		public function __construct(){
			parent::__construct();
		}
		function index(){
		
		/*function load_data($restaurant_api_call_data, &$data, $total_num_clips, &$counter){ 
				
			$restaurant_data = $restaurant_api_call_data['restaurant'];

			$restaurant_data['dishes']['clips'] = !empty($restaurant_data['dishes']['clips']) ? $restaurant_data['dishes']['clips'] : '';
			for($i=0; $i < count($restaurant_data['dishes']) - 1; $i++):
				for($j=0; $j < count($restaurant_data['dishes'][$i]['clips']); $j++):
					if($counter == 12):
						break;
					endif;
					array_push($data['results'], $restaurant_data['dishes'][$i]['clips'][$j]);
					$counter++;
				endfor;
			endfor;
		} */
		
		function push_latest_clips($latest_clips_data, &$data){
		for($i = 0; $i < 20; $i++):
		array_push($data['latest_clips'], $latest_clips_data['clips'][$i]);
		endfor;
	
	}
	
		function load_more_lastest_clips(&$data){
			$api_latest_clips_data = file_get_contents(API_URL . "getClips?type=LATEST&page=");
			$latest_clips_data = json_decode($api_latest_clips_data, true);
			push_latest_clips($latest_clips_data, $data);
		
	}
			$this->load->helper('MY_date');
			$this->load->helper('dishbox');
			$this->load->helper('url');
			
			// Latest Clips
			
			$data['latest_clips'] = array();
			
			load_more_lastest_clips($data);
			//print_r($latest_clips_data);
			$latest_clips_data['url'] = "";
			$latest_clips_data['thumbnail_url'] = "";
			$latest_clips_data['restaurant_name'] = "";
			$latest_clips_data['thumbnail_id'] = "";
			$latest_clips_data['dish_name'] = "";
			$latest_clips_data['restaurant_id'] = "";
			$latest_clips_data['num_likes'] = "";
			$latest_clips_data['num_comments'] = "";
			$latest_clips_data['create_time'] = "";
			$latest_clips_data['user_image_url'] = "";
			$data['clip_url'] = $latest_clips_data['url'];
			$data['clip_thumbnail'] = $latest_clips_data['thumbnail_url'];
			
			$data['restaurant_name'] = $latest_clips_data['restaurant_name'];
			$data['restaurant_id'] = $latest_clips_data['restaurant_id'];
			$data['user_name'] = empty($latest_clips_data['user_name']) ? "Anonymous" : $latest_clips_data['user_name'];
			$data['dish_name'] = $latest_clips_data['dish_name'];
			$data['num_likes'] = $latest_clips_data['num_likes'];
			$data['num_comments'] = $latest_clips_data['num_comments'];
			
			$data['create_time'] = RelevantTime($latest_clips_data['create_time']);
			$data['user_image_url'] = $latest_clips_data['user_image_url'];
			
		/*	// Nearby Clips
			$q = !empty($_GET['q']) ? rawurlencode($_GET['q']) : "";
			
			if(!empty($_GET['loc'])):
				$loc = ucwords(rawurlencode($_GET['loc']));
			else:
				$geo_loc_data = '';
			$ip = $_SERVER['REMOTE_ADDR'];
			$ip = "204.75.251.3";
			
			$geo_loc_data = json_decode(file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=de83a552e1630948c073b97075b77fc65a4e1c042dfdb9acc8d9a46a083647e9&format=json&ip='.$ip));
			$loc =  rawurlencode(ucwords(strtolower("$geo_loc_data->cityName, $geo_loc_data->regionName")));
			endif;
		
			$show_results = true;
			$data['q'] = rawurldecode($q);
			$data['loc'] = rawurldecode($loc);
		
			$api_call_url = API_URL . "searchRestaurants2?address=" . $loc . "&sort=distance&clipsOnly=true";
			$api_call = json_decode(file_get_contents($api_call_url), true);
			
			$data['restaurants_list'] = $api_call;
			
			if($api_call == NULL || isset($api_call['error'])) $show_results = false;
		
			$data['show_results'] = $show_results; 

			$not_found = false;
			$total_num_clips = 0;
			
			$data['results'] = array();
			$counter = 0;
			for($i = 0; $i < count($api_call['distance1_restaurants']); $i++):
			if(empty($api_call['distance1_restaurants'][$i]['foursquare_id']))
				$restaurant_id = $api_call['distance1_restaurants'][$i]['unique_id'];
			if(empty($api_call['distance1_restaurants'][$i]['unique_id']))
				$restaurant_id = $api_call['distance1_restaurants'][$i]['foursquare_id'];
						
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?restaurant_id=$restaurant_id"), true);
			if(empty($restaurant_api_call_data['restaurant'])){
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?foursquare_id=$restaurant_id"), true);
			if(!empty($restaurant_api_call['error'])){
				
				//check if it's foursquare
				$not_found = true;
				echo "not found!";
			}
			}
			$total_num_clips += $api_call['distance1_restaurants'][$i]['num_clips'];
			load_data($restaurant_api_call_data, $data, $total_num_clips, $counter);
			
			endfor;
			
			for($i = 0; $i < count($api_call['distance2_restaurants']); $i++):
			if(empty($api_call['distance2_restaurants'][$i]['foursquare_id']))
				$restaurant_id = $api_call['distance2_restaurants'][$i]['unique_id'];
			if(empty($api_call['distance2_restaurants'][$i]['unique_id']))
				$restaurant_id = $api_call['distance2_restaurants'][$i]['foursquare_id'];
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?restaurant_id=$restaurant_id"), true);
			if(empty($restaurant_api_call_data['restaurant'])){
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?foursquare_id=$restaurant_id"), true);
			if(!empty($restaurant_api_call['error'])){
				
				//check if it's foursquare
				$not_found = true;
				echo "not found!";
			}
			}
			$total_num_clips += $api_call['distance2_restaurants'][$i]['num_clips'];
			load_data($restaurant_api_call_data, $data, $total_num_clips, $counter);
			
			endfor;
			
			for($i = 0; $i < count($api_call['distance3_restaurants']); $i++):
			if(empty($api_call['distance3_restaurants'][$i]['foursquare_id']))
				$restaurant_id = $api_call['distance3_restaurants'][$i]['unique_id'];
			if(empty($api_call['distance3_restaurants'][$i]['unique_id']))
				$restaurant_id = $api_call['distance3_restaurants'][$i]['foursquare_id'];
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?restaurant_id=$restaurant_id"), true);
			if(empty($restaurant_api_call_data['restaurant'])){
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?foursquare_id=$restaurant_id"), true);
			if(!empty($restaurant_api_call['error'])){
				
				//check if it's foursquare
				$not_found = true;
				echo "not found!";
			}
			}
			$total_num_clips += $api_call['distance3_restaurants'][$i]['num_clips'];
			load_data($restaurant_api_call_data, $data, $total_num_clips, $counter);
			endfor;
			
			for($i = 0; $i < count($api_call['distance4_restaurants']); $i++):
			if(empty($api_call['distance4_restaurants'][$i]['foursquare_id']))
				$restaurant_id = $api_call['distance4_restaurants'][$i]['unique_id'];
			if(empty($api_call['distance4_restaurants'][$i]['unique_id']))
				$restaurant_id = $api_call['distance4_restaurants'][$i]['foursquare_id'];
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?restaurant_id=$restaurant_id"), true);
			if(empty($restaurant_api_call_data['restaurant'])){
			$restaurant_api_call_data = json_decode(file_get_contents(API_URL . "getRestaurant?foursquare_id=$restaurant_id"), true);
			if(!empty($restaurant_api_call['error'])){
				
				//check if it's foursquare
				$not_found = true;
				echo "not found!";
			}
			}
			$total_num_clips += $api_call['distance4_restaurants'][$i]['num_clips'];
			load_data($restaurant_api_call_data, $data, $total_num_clips, $counter);
			endfor; */
		
			$this->template->set('title', 'Welcome to DishClips!');
			$this->template->load('template', 'index', $data);
		}
}
?>
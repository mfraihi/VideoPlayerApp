<?php

class Moreclipsnearby extends CI_Controller {

	public function index()
	{
	
		function load_data($restaurant_api_call_data, &$data, $total_num_clips, &$counter){ 
				
			$restaurant_data = $restaurant_api_call_data['restaurant'];
			//$data['restaurants'] = $restaurant_data['restaurant'];
			//$data['id'] = $restaurant_data['unique_id'];
			
		/*	$data['name'] = $restaurant_data['name'];
			@$data['address'] = $restaurant_data['address1'] != $restaurant_data["address2"] ? $restaurant_data['address1'] . " " . $restaurant_data["address2"] : $restaurant_data['address1'];
			$data['city'] = $restaurant_data['city'] = !empty($restaurant_data['city']) ? $restaurant_data['city'] : "";;
			$data['state'] = !empty($restaurant_data['state']) ? $restaurant_data['state'] : "";
			$data['zip'] = !empty($restaurant_data['zip']) ? $restaurant_data['zip'] : "";
			$data['phone'] = !empty($restaurant_data['phone']) ? $restaurant_data['phone'] : "";
			$data['url'] = !empty($restaurant_data['url']) ? $restaurant_data['url'] : "No Website";
			$data['lon'] = $restaurant_data['lon'];
			$data['lat'] = $restaurant_data['lat'];
			$data['num_clips'] = $restaurant_data['num_clips'];
			$data['dishes_list'] = $restaurant_data['dishes'];
			//print_r($restaurant_data);
			//print_r ($restaurant_data['restaurant']['dishes'][0]['clips']); */
			
			//if(isset($restaurant_data['dishes']['clips']))
			$restaurant_data['dishes']['clips'] = !empty($restaurant_data['dishes']['clips']) ? $restaurant_data['dishes']['clips'] : '';
			for($i=0; $i < count($restaurant_data['dishes']) - 1; $i++):
				for($j=0; $j < count($restaurant_data['dishes'][$i]['clips']); $j++):
					if($counter == 12 || $counter > 12):
					array_push($data['results'], $restaurant_data['dishes'][$i]['clips'][$j]);
					endif;
					$counter++;
				endfor;
			endfor;
		} 
	
	
	
		$this->load->helper('MY_date');
		$this->load->helper('url');
		$this->load->helper('dishbox');
		
		
		// Nearby Clips
			$q = !empty($_GET['q']) ? rawurlencode($_GET['q']) : "";
			//$clipsOnly = isset($_GET['clipsOnly']) and ($_GET['clipsOnly'] == 1) ? true : false;
			//$data['clipsOnly'] = $clipsOnly;
			
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
		
			//$api_call_url =  $clipsOnly ? API_URL . "searchRestaurants2?address=" . $loc . "&search=" . $q . "&sort=distance&clipsOnly=true" :
					 //     API_URL . "searchRestaurants2?address=" . $loc . "&search=" . $q . "&sort=distance";
		
			$api_call_url = API_URL . "searchRestaurants2?address=" . $loc . "&sort=distance&clipsOnly=true";
			$api_call = json_decode(file_get_contents($api_call_url), true);
			
			$data['restaurants_list'] = $api_call;
			
			if($api_call == NULL || isset($api_call['error'])) $show_results = false;
		
			$data['show_results'] = $show_results; 
			/*print_r(count($api_call['distance1_restaurants']));
			print_r(count($api_call['distance2_restaurants']));
			print_r(count($api_call['distance3_restaurants']));
			print_r(count($api_call['distance4_restaurants']));
			print_r($api_call['distance1_restaurants'][0]['num_clips']);
			print_r($api_call['distance2_restaurants']);
			print_r($api_call['distance3_restaurants']);
			print_r($api_call['distance4_restaurants']); */
			$not_found = false;
			$total_num_clips = 0;
			//$restaurant_id="c9da3776-ec77-4fcd-ab2a-10b29d29bd77";
		/*	for($i = 0; $i < count($api_call['distance1_restaurants']); $i++):
				$total_num_clips += $api_call['distance1_restaurants'][$i]['num_clips'];
			endfor;
			
			for($i = 0; $i < count($api_call['distance2_restaurants']); $i++):
				$total_num_clips += $api_call['distance2_restaurants'][$i]['num_clips'];
			endfor;
			
			for($i = 0; $i < count($api_call['distance3_restaurants']); $i++):
				$total_num_clips += $api_call['distance3_restaurants'][$i]['num_clips'];
			endfor;
			
			for($i = 0; $i < count($api_call['distance4_restaurants']); $i++):
				$total_num_clips += $api_call['distance4_restaurants'][$i]['num_clips'];
			endfor; */
			
			//$api_call['distance1_restaurants'][0]['num_clips'];
			
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
			endfor; 
			//print_r($restaurant_data);
			print_r($total_num_clips);
		
		
		$this->template->set('title', 'More Nearby Clips');
		$this->load->view('moreclipsnearby', $data);
		
	}
	
}
?>
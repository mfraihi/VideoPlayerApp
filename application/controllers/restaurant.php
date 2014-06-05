<?php
class Restaurant extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	 
	function index(){
		$this->load->helper('MY_date');
		$this->load->helper('url');
		$this->load->helper('dishbox');
		$this->load->helper('modals');
		
		$valid_restaurant = true;
		$restaurant_id = $this->uri->segment(2);
		
		$restaurant_api_call = json_decode(file_get_contents(API_URL . "getRestaurant?restaurant_id=$restaurant_id"), true);
		
		if(empty($restaurant_api_call['restaurant'])){
			$restaurant_api_call = json_decode(file_get_contents(API_URL . "getRestaurant?foursquare_id=$restaurant_id"), true);
			if(!empty($restaurant_api_call['error'])){
				//check if it's foursquare
				$valid_restaurant = false;
				//echo "not found!";
			}
		}
		
		if($valid_restaurant){
			$restaurant_data = $restaurant_api_call['restaurant'];
			
			//print_r($restaurant_api_call);
			
			$isKitchen = $restaurant_data['my_own_kitchen'];
			$data['num_clips'] = $restaurant_data['num_clips'];
			$data['dishes_list'] = $restaurant_data['dishes'];
			
			$name = $restaurant_data['name'];
			$data['name'] = $name;
			
			if(!$isKitchen){
				$city = !empty($restaurant_data['city']) ? $restaurant_data['city'] : "";
				$state = !empty($restaurant_data['state']) ? ", " .$restaurant_data['state'] : "";
				
				$data['valid_restaurant'] = true;
				$data['name'] = $restaurant_data['name'];
				@$data['address'] = $restaurant_data['address1'] != $restaurant_data["address2"] ? $restaurant_data['address1'] . " " . $restaurant_data["address2"] : $restaurant_data['address1'];
				$data['city'] = !empty($restaurant_data['city']) ? $restaurant_data['city'] : "";
				$data['state'] = !empty($restaurant_data['state']) ? $restaurant_data['state'] : "";
				$data['zip'] = !empty($restaurant_data['zip']) ? $restaurant_data['zip'] : "";
				$data['phone'] = !empty($restaurant_data['phone']) ? $restaurant_data['phone'] : "";
				$url = !empty($restaurant_data['url']) ? $restaurant_data['url'] : false;
				$data['url'] = preg_match("#https?://#", $url) === 0 && $url != false ? 'http://'. $url : $url;
				$data['lon'] = $restaurant_data['lon'];
				$data['lat'] = $restaurant_data['lat'];
				
				$data['view'] = "restaurant";
				$this->template->set('title', "DishClips &raquo; " . $name . " in " . $city . $state);
				$this->template->load('template', 'restaurant', $data);
			}
			else{
				$user_id = $restaurant_data['first_clipped_id'];
				redirect('/user/' . $user_id . "#Kitchen", 'refresh');
			}
			
			//print_r($restaurant_data);
			
			
			if (!empty($_POST)){
				//_process_form($data['name'], $_POST['ROEmail'], $_POST['ROWebsite'], $data['name'], $data['city'], $data['state'], $data['zip'], $_POST['ROPhone'], $restaurant_id);
				list($fn, $ln) = explode(" ", $_POST['ROName']);
				$this->db->select('dishclip_cust');
				$db_data = array(
					'fname' => $fn,
					'lname' => $ln,
					'email' => $_POST['ROEmail'],
					'restname' => $data['name'],
					'city' => $data['city'],
					'state' => $data['state'],
					'zip' => $data['zip'],
					'phone' => $_POST['ROPhone'],
					'url' => $_POST['ROWebsite'],
					'restaurant_id' => $restaurant_id
				);
				
				$this->db->insert('cust_data', $db_data);
			}
		} else{
			$data['item'] = "Restaurant";
			
			$this->template->set('title', 'DishClips | Not found');
			$this->template->load('template', 'my404', $data);
		
		}
	}
}
?>
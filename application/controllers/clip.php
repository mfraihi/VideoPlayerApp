<?php
class Clip extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	 
	function index(){
		
		$this->load->helper('MY_date');
		$this->load->helper('dishbox');
		$this->load->helper('url');
		$this->load->helper('url_shortener');
		$this->load->helper('modals');
		$this->load->library('user_agent');
		
		$clip_id = $this->uri->segment(2);
		$data['clip_id'] = $clip_id;
		$clip_api_call = json_decode(file_get_contents(API_URL . "getUserClip?clip_id=$clip_id"), true);
		
		$valid_clip = !empty($clip_api_call['error']) ? false : true;
		
		if($valid_clip){
			$data['valid_clip'] = true;
			
			// begin clip data
			$clip_data = $clip_api_call['clip'];
			
			//print_r($clip_api_call);
			//$dish_id = "b95198b2-94f8-463f-b0cd-19ea127e1ae0";
			
			$dish_id = $clip_data['dish_id'];
			$dish_api_call = json_decode(file_get_contents(API_URL ."getDish?dish_id=$dish_id"), true);
			$dish_data = $dish_api_call['dish'];
			
			//print_r($dish_api_call);
			
			$data['keywords'] = array_keys(array_flip(explode(',', $dish_data['keywords']))); //remove duplicates
			
			$data['clips_list'] = $dish_data['clips'];
			$data['dish_rating'] = intval($dish_data['rating']);
			$data['dish_id'] = $dish_id;
			$data['clip_url'] = $clip_data['url'];
			$data['clip_thumbnail'] = $clip_data['thumbnail_url'];
			$data['restaurant_name'] = $restaurant_name = !empty($clip_data['restaurant_name']) ? $clip_data['restaurant_name'] : "";
			$data['restaurant_id'] = !empty($clip_data['restaurant_id']) ? $clip_data['restaurant_id'] : "";
			$data['user_name'] = !empty($clip_data['user_name']) ? $clip_data['user_name'] : "Anonymous";
			$data['user_id'] = !empty($clip_data['user_id']) ? $clip_data['user_id'] : "#";
			$data['user_image_url'] = isset($clip_data['user_image_url']) ? $clip_data['user_image_url'] : site_url('application_images/anon-user-icon.png');
			$data['dish_name'] = $dish_name = $clip_data['dish_name'];
			$data['num_likes'] = $clip_data['num_likes'];
			$data['num_comments'] = $clip_data['num_comments'];
			$data['create_time'] = RelevantTime($clip_data['create_time']);
			
			//begin comments data'];
			$comments_api_call = json_decode(file_get_contents(API_URL . "getDishComments?dish_id=$dish_id"), true);
			$data['comments_list'] = $comments_api_call['comments'];
			
			//begin restaurant data
			$restaurant_id = $clip_data['restaurant_id'];
			$restaurant_api_call = json_decode(file_get_contents(API_URL . "getRestaurant?restaurant_id=$restaurant_id"), true);
			$restaurant_data = $restaurant_api_call['restaurant'];
			$data['dishes_list'] = $restaurant_data['dishes'];
			$data['restaurant_city'] = $city = !empty($restaurant_data['city']) ? $restaurant_data['city'] : "";
			$data['restaurant_state'] = $state = !empty($restaurant_data['state']) ? $restaurant_data['state'] : "";
			
			$data['video_height'] = "720";
			$data['video_width'] = "540";
			
			//temprary user profile info//
			$user_id = !empty($clip_data['user_id']) ? $clip_data['user_id'] : false;
			
			if($user_id != false){
				$user_profile_api_call = json_decode(file_get_contents(API_URL . "getUserProfile?user_id=" . $user_id), true);
				$user_data = $user_profile_api_call['profile'];
				$data['user_data'] = $user_data;
				//print_r($user_data);
			}
			
			$data['isMobile'] = $this->agent->is_mobile() ? true : false;
			$data['short_url'] = $this->shorten_url("http://www.dishclips.com/clip/" . $clip_id);
			$tweet_location = !empty($city) && !empty($state) ? "in $city, $state " : "";
			$data['tweet_msg'] = "$dish_name from $restaurant_name $tweet_location";
			
			$data['view'] = "clip";
			$this->template->set('title', "DishClips &raquo; " . $clip_data['restaurant_name'] . " &raquo; " . $clip_data['dish_name']);
			$this->template->load('template', 'clip', $data);
			
		} else{
			$data['item'] = "Clip";
			$this->template->set('title', 'DishClips | Not found');
			$this->template->load('template', 'my404', $data);
		}
		
	}
	
	function shorten_url($long_url){
		return file_get_contents("http://www.dishclips.com/u/yourls-api.php?action=shorturl&format=simple&signature=f254927f72&url=$long_url");
	}
}
?>
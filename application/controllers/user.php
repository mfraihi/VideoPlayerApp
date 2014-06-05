<?php
class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	 
	function index(){
		$this->load->helper('MY_date');
		$this->load->helper('url');
		$this->load->helper('dishbox');
		
		$user_id = $this->uri->segment(2);
		
		$user_profile_api_call = json_decode(file_get_contents(API_URL . "getUserProfile?user_id=$user_id"), true);
		
		$valid_user = !isset($user_profile_api_call['error']) ? true : false;
		
		if($valid_user){
			$data['valid_user'] = true;
			$user_profile_data = $user_profile_api_call['profile'];
			$user_clips_data = json_decode(file_get_contents(API_URL . "getUserClips?user_id=$user_id"), true);
			//print_r($restaurant_api_call);
			
                        $name = !empty($user_profile_data['name']) ? $user_profile_data['name'] : "";
                        $data['name'] = !empty($user_profile_data['name']) ? $user_profile_data['name'] : "";
                        $data['gender'] = !empty($user_profile_data['gender']) ? $user_profile_data['gender'] : "";
			$data['joined'] = !empty($user_profile_data['joined']) ? date("M d, Y", $user_profile_data['joined']) : "";
                        $data['image_url'] = !empty($user_profile_data['image_url']) ? $user_profile_data['image_url'] : "";
                        $data['followers'] = !empty($user_profile_data['followers']) ? $user_profile_data['followers'] : 0;
                        $data['following'] = !empty($user_profile_data['following']) ? $user_profile_data['following'] : 0;
                        $data['num_clips'] = !empty($user_profile_data['num_clips']) ? $user_profile_data['num_clips'] : 0;
                        $data['points'] = !empty($user_profile_data['points']) ? $user_profile_data['points'] : 0;
                        $data['clips_list'] = !empty($user_clips_data['clips']) ? $user_clips_data['clips'] : "";
                        $kitchen_list = array();
			
			////
			foreach($data['clips_list'] as $clip){
				if($clip['restaurant_name'] == $name ."'s Kitchen"){
					array_push($kitchen_list, $clip); //initialize kitchen clips
				}
			}
			////
			//print_r($user_clips_data);
			
			$data['kitchen_list'] = $kitchen_list;
			
			$this->template->set('title', 'DishClips &raquo; ' . $name);
			$this->template->load('template', 'user', $data);
		} else{
			$data['item'] = "User";
			$this->template->set('title', 'DishClips | Not found');
			$this->template->load('template', 'my404', $data);
		}
	}
}
?>
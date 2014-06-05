<?php
function _process_form($name, $email, $website, $restaurant_name, $city, $state, $zip, $phone_number, $restaurant_id){
		list($fn, $ln) = explode(" ", $name);
                $this->db->select('dishclip_cust');
                $this->db->query("INSERT INTO cust_data (fname, lname, email, restname, city, state, zip, phone, url, restaurant_id) VALUES('$fn', '$ln', '$email', '$restaurant_name', '$city', '$state', '$zip', '$phone_number', '$website', '$restaurant_id');");
}
?>
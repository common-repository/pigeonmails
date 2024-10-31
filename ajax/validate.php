<?php

$_wpnonce = "";
if(isset($_POST['_wpnonce']) && $_POST['_wpnonce'] != ""){
	$_wpnonce = $_POST['_wpnonce'];
}
if(wp_verify_nonce($_wpnonce,"pigeonmail_action_nonce")){
$userid = 0;
$username = "";
$password = "";
$fromname = "";
$fromemail = "";
$response['status'] = 0;
$response['message'] = "some parameters are missing";
	if((!isset($_POST['username'])) || (!isset($_POST['password']))){
		$response['status'] = 0;
		$response['message'] = "some parameters are missing";
	}else{
		$userid = sanitize_text_field($_POST['userid']);
		$username = sanitize_text_field($_POST['username']);
		$password = sanitize_text_field($_POST['password']);
		if($username == "" || $password == ""){
			$response['status'] = 0;
			$response['message'] = "some parameters are missing";
		}else{
			$url = "https://cp.pigeonmails.com/api/uservalidation";
			$postfields = array(
					'username' => $username,
					'password' => $password,
			
			);
			$args = array(
				'body' => $postfields,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'cookies' => array()
			);
			$wp_response = wp_remote_post($url,$args);		
			$curl_response = $wp_response['body'];
			$curl_response = json_decode($curl_response);
			$fromname = sanitize_text_field($_POST['fromname']);
			$fromemail = sanitize_email($_POST['fromemail']);
			if($curl_response->status == '1'){
				$result = false;
				if($userid){
					$update_sql = "UPDATE wp_pg_users SET `username` = %s, `password` = %s, `fromname` = %s, `fromemail` = %s WHERE `id` = %d";	

					$prepare_update_query = $wpdb->prepare($update_sql,$username,$password,$fromname,$fromemail,$userid);
					$result = $wpdb->query($prepare_update_query); 				
				}else{
					$insert_sql = "INSERT INTO wp_pg_users (username, password,fromname,fromemail,created_at)
					VALUES (%s,%s,%s,%s,now())";
					$prepare_insert_query = $wpdb->prepare($insert_sql,$username,$password,$fromname,$fromemail);
					$result = $wpdb->query($prepare_insert_query); 					
				}
					$response['status'] = 1;
					$response['message'] = "username / password added successfully";
			}else{
				$response['status'] = 0;
				$response['message'] = "You are not registered with pigeonmails Please <a href='https://www.pigeonmails.com/'>click here</a> to register";				
			}
		}
	}		
}else{
	$response['status'] = 0;
	$response['message'] = "You are not authorized to access this url";				
}

echo json_encode($response);

?>
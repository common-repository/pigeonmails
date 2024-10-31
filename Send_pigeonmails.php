<?php

class Send_pigeonmails{	
	
	
	public function sendmails($username,$password,$to,$fromname,$fromemail,$replyto, $subject, $message,$attachments){
		global $wpdb;	
		$postfields = array(
			'username' => $username,
			'password' => $password,
			'to' => $to,
			'from' => $fromemail,
			'fromname' => $fromname,
			'replyto' => $replyto,
			'emailsubject' => $subject,
			'body' => $message
		);
		$filename = array();
		$attachfile = "";
	
		if(count($attachments)){
			foreach ($attachments as $index => $file) {				
				$postfields['attachment[' . $index . ']'] = array_merge($file,array('file_data' => base64_encode(file_get_contents($file['filepath']))));								
			}			
		}
		
		
		$args = array(
			'body' => $postfields,
			'httpversion' => '1.0',
			'timeout'   => 300,       
			'blocking' => true,
			'headers' => array(						
				 'Content-Type' =>  'application/x-www-form-urlencoded',
			), 
			'cookies' => array()
		);
		$url = "https://cp.pigeonmails.com/api/sendemailplugin";
		$response = wp_remote_post($url,$args);		
		$wpdb->insert('wp_pg_inbox', 
		array(
				'fromname' => $fromname,
				'fromemail' => $fromemail,
				'to' => $to,
				'replyto' => $replyto,
				'subject' => $subject,
				'message' => $message,
				'response' => $response['body'],
				'attachment' => json_encode($attachments),
				'created_at' => date('Y-m-d h:m:s')
			) 
		); 
		return $response['body'];
	}
}

?>
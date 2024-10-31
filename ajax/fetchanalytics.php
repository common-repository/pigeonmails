<?php

$_wpnonce = "";
if(isset($_POST['_wpnonce']) && $_POST['_wpnonce'] != ""){
	$_wpnonce = $_POST['_wpnonce'];
}
if(wp_verify_nonce($_wpnonce,"pigeonmail_action_nonce")){	
$start = 0;
$limit = 5;
$username = sanitize_text_field($_POST['username']);
$password = sanitize_text_field($_POST['password']);
$fromdate = "";
$todate = "";
$data['page'] = 0;
$data['next'] = 0;
$data['prev'] = 0;
$data['limit'] = 5; 

if(isset($_POST['fromdate']) && isset($_POST['todate'])){
	$fromdate = sanitize_text_field($_POST['fromdate']);
	$todate = sanitize_text_field($_POST['todate']);
}
		
if(isset($_POST['page'])){
	$start = sanitize_text_field($_POST['page'])*$limit;
	$data['page'] = sanitize_text_field($_POST['page']);
	$data['next'] = sanitize_text_field($_POST['page']);
	$data['prev'] = sanitize_text_field($_POST['page']) - 1;
}

if(isset($_POST['rowlist'])){
	$limit = sanitize_text_field($_POST['rowlist']);
	$data['limit'] = $limit; 
}

$url = "https://cp.pigeonmails.com/api/getanalytic";

$postfields = array(
	'username' => $username,
	'password' => $password,
	'fromdate' => $fromdate,
	'todate' => $todate,
	'start' => $start,
	'limit' => $limit
);

$args = array(
	'body' => $postfields,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'cookies' => array()
);

$element = '<tbody id="fetchanalytics">';
		$response = wp_remote_post($url,$args);		
		$response = json_decode($response['body']);	
		if(count($response)){
			$analytics_record = $response->message;
			if($analytics_record != "some parameters are missing or null." ){
				if(count($analytics_record)){			
					foreach($analytics_record as $report){
						$element.="<tr>";
							$element.="<td>".$report->date."</td>";
							$element.="<td>".$report->total."</td>";
							$element.="<td>".$report->subsriber."</td>";
							$element.="<td>".$report->open."</td>";
							$element.="<td>".$report->click."</td>";
							$element.="<td>".$report->unsubscriber."</td>";
							$element.="<td>".$report->softbounce."</td>";
							$element.="<td>".$report->hardbounce."</td>";
						$element.="</tr>";
					}
				}else{
					$element.="<tr><td colspan='8'>No Record Found </td></tr>";
				}	
			}else{
				$element.="<tr><td colspan='8'>No Record Found </td></tr>";
			}			
		}else{
			$element.="<tr><td colspan='8'>No Record Found </td></tr>";
		}
		
		$element.='</tbody>';

$data['element'] = $element;
}else{
	$response['status'] = 0;
	$response['element'] = "You are not authorized to access this url";				
}
echo json_encode($data);
?>
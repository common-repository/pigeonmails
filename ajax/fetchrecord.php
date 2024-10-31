<?php

//require_once("../db/connect.php");
$_wpnonce = "";
if(isset($_POST['_wpnonce']) && $_POST['_wpnonce'] != ""){
	$_wpnonce = $_POST['_wpnonce'];
}
if(wp_verify_nonce($_wpnonce,"pigeonmail_action_nonce")){
$start = 0;
$limit = 50;
$data['page'] = 0;
$data['next'] = 0;
$data['prev'] = 0;
$data['limit'] = 50; 
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

$sql = "SELECT * FROM wp_pg_inbox where 1=1  order by id desc";

$sql.=" limit %d,%d";

$prepare_query = $wpdb->prepare($sql,$start,$limit);

$results = $wpdb->get_results($prepare_query); // Query to fetch data from database table 
$element = '<tbody id="fetchdata">';
	if (count($results)) {
		// output data of each row
		foreach($results as $row) {
			$element.="<tr>";
				$element.="<td>".$row->fromname." < ".$row->fromemail." >"."</td>";
				$element.="<td>".$row->to."</td>";
				$element.="<td>".$row->replyto."</td>";
				$element.="<td>".$row->subject."</td>";
				if(count(json_decode($row->response))){
					$res = json_decode($row->response);
					if($res->status == '1'){
						$element.="<td>Sent</td>";							
					}else{
						$element.="<td>pending</td>";
					}
					$element.="<td>".$res->message."</td>";
				}else{
					$element.="<td>Pending</td>";
					$element.="<td></td>";
				}
				$element.="<td>".$row->created_at."</td>";
			$element.="</tr>";
		}
	} else {
		$element.="<tr><td colspan='7'>No Record Found </td></tr>";
	}
	$element.='</tbody>';
	$data['element'] = $element;
}else{
	$response['status'] = 0;
	$response['element'] = "You are not authorized to access this url";				
}
echo json_encode($data);
?>
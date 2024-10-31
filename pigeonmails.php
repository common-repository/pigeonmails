<?php
/***
* @package pigeonmails
**/
/*
Plugin Name: Pigeonmails
Plugin URI: https://www.pigeonmails.com/
Description: This plugin is use for sending mail.
Version: 1.0.0
Author: Pigeonmail
Author URI: https://www.pigeonmails.com/
License: GPLv2 or later 
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

function add_pigeonmails_menu(){
	
	add_menu_page(
		'Pigeonmails', //page title
		'Pigeon Mails', // menu title
		'manage_options', //admin level
		'pigeonmailsinbox', //page slug
		'wp_pigeonmails_inbox', //callback function
		'dashicons-twitter' //icon url
	);
	
	add_submenu_page(
		'pigeonmailsinbox', //parent slug
		'Pigeonmails', //page title
		'Inbox', // menu title
		'manage_options', //admin level
		'pigeonmailsinbox', //page slug
		'wp_pigeonmails_inbox' //callback function
	);
	
	add_submenu_page(
		'pigeonmailsinbox', //parent slug
		'Pigeonmails', //page title
		'Add api details', // menu title
		'manage_options', //admin level
		'pigeonmailsuser', //page slug
		'wp_pigeonmails_add_api_key' //callback function
	);
	
	add_submenu_page(
		'pigeonmailsinbox', //parent slug
		'Pigeonmails', //page title
		'Analytics', // menu title
		'manage_options', //admin level
		'pigeonmailsanalytics', //page slug
		'wp_pigeonmails_analytics' //callback function
	);
}

add_action('admin_menu','add_pigeonmails_menu');

function wp_pigeonmails_inbox(){
	
	include_once(plugin_dir_path(__FILE__)."view/inbox.php");
}

function wp_pigeonmails_add_api_key(){
	$users = wp_pigeonmails_fetch_user();
	$users = json_decode($users);		
	include_once(plugin_dir_path(__FILE__)."view/addapi.php");
}

function wp_pigeonmails_analytics(){
	$users = wp_pigeonmails_fetch_user();
	$users = json_decode($users);		
	include_once(plugin_dir_path(__FILE__)."view/analytics.php");
}

function wp_pigeonmails_plugin_assets(){
	wp_enqueue_style(
		'pg_style', // file name
		plugins_url('css/style.css',__FILE__ ),
		'', //depend on other files
		1.0 //plugin version
	);
	
	wp_enqueue_script(
		'pg_latest_min', // file name
		plugins_url('js/jquery-latest.min.js',__FILE__ ),
		'', //depend on other files
		1.0, //plugin version
		true
	);

	wp_enqueue_script(
		'pg_main', // file name
		plugins_url('js/main.js',__FILE__ ),		
		'', //depend on other files
		1.0, //plugin version
		true
	);
	
	wp_localize_script('cpl_script','ajaxurl',admin_url('admin-ajax.php'));
}

add_action('init','wp_pigeonmails_plugin_assets');

if(isset($_REQUEST['action'])){
	switch($_REQUEST['action']){
		case "inbox_pigeonmails" : add_action("admin_init","inbox_pigeonmails");
		function inbox_pigeonmails(){
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');	
			include_once "ajax/fetchrecord.php";
			die;
		}		
		break;
		
		case "analytics_pigeonmails" : add_action("admin_init","analytics_pigeonmails");
		function analytics_pigeonmails(){			
			include_once "ajax/fetchanalytics.php";
			die;
		}		
		break;
		
		case "authenticate_pigeonmails" : add_action("admin_init","authenticate_pigeonmails");
		function authenticate_pigeonmails(){
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');					
			include_once "ajax/validate.php";
			die;
		}		
		break;
	}
}

function wp_pigeonmails_tables(){
	global $wpdb;
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	
	if(count($wpdb->get_var('SHOW TABLES LIKE "wp_pg_users"')) == 0){
		$sql_query_to_create_table = "CREATE TABLE `wp_pg_users` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(255) DEFAULT NULL,
		  `password` varchar(255) DEFAULT NULL,
		  `fromname` varchar(255) DEFAULT NULL,
		  `fromemail` varchar(255) DEFAULT NULL,		
		  `created_at` varchar(25) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		dbDelta($sql_query_to_create_table);
	}
	
	if(count($wpdb->get_var('SHOW TABLES LIKE "wp_pg_inbox"')) == 0){
		$sql_query_to_create_table = "CREATE TABLE `wp_pg_inbox` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`fromname` varchar(255) DEFAULT NULL,
			`fromemail` varchar(255) DEFAULT NULL,
			`to` text,
			`replyto` varchar(255) DEFAULT NULL,
			`subject` text,
			`message` text,
			`response` text,
			`attachment` text,
			`created_at` varchar(25) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		dbDelta($sql_query_to_create_table);
	}
}

register_activation_hook(__FILE__,'wp_pigeonmails_tables');

function wp_pigeonmails_fetch_user(){
	global $wpdb;
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	
	if(count($wpdb->get_var('SHOW TABLES LIKE "wp_pg_users"')) == 0){
		$sql_query_to_create_table = "CREATE TABLE `wp_pg_users` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(255) DEFAULT NULL,
		  `password` varchar(255) DEFAULT NULL,
		  `fromname` varchar(255) DEFAULT NULL,
		  `fromemail` varchar(255) DEFAULT NULL,
		  `created_at` varchar(25) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		dbDelta($sql_query_to_create_table);
	}
	
	$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_pg_users limit %d ",1)); // Query to fetch data from database table 
	return json_encode($results);
}

function wp_pigeonmails_uninstall(){
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS wp_pg_users;");
	$wpdb->query("DROP TABLE IF EXISTS wp_pg_inbox;");
}

register_uninstall_hook(__FILE__,'wp_pigeonmails_uninstall');


if (!function_exists('wp_pigeonmails_mails') ) {

	function wp_pigeonmails_mails($username,$password,$to,$fromname,$fromemail,$replyto, $subject, $message,$attachments) {
		require_once(plugin_dir_path(__FILE__)."Send_pigeonmails.php");
		if($username == "" && $password == ""){
			$users = wp_pigeonmails_fetch_user();
			$users = json_decode($users);
			if(count($users)){
				foreach($users as $u){					
					$username = $u->username;
					$password = $u->password;
					if($fromname == ""){
						$fromname = $u->fromname;						
					}
					if($fromemail == ""){
						$fromemail = $u->fromemail;						
					}
				}
			}
		}		
		$mail = new Send_pigeonmails();
		return $mail->sendmails(sanitize_text_field($username),sanitize_text_field($password),sanitize_text_field($to),sanitize_text_field($fromname),sanitize_email($fromemail),sanitize_email($replyto),sanitize_text_field($subject),sanitize_text_field($message),$attachments);
	}

}

?>

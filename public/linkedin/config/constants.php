<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Table
define('LINKEDIN_ACCOUNTS', "linkedin_accounts");
define('LINKEDIN_POSTS', "linkedin_posts");

$linkedin_app_id = get_setting("linkedin_app_id", "");
$linkedin_app_secret = get_setting("linkedin_app_secret", "");

if($linkedin_app_id != "" && $linkedin_app_secret != ""){
	define('LINKEDIN_CLIENT_ID', $linkedin_app_id);
	define('LINKEDIN_CLIENT_SERECT', $linkedin_app_secret);
}else{
	define('LINKEDIN_CLIENT_ID', get_option("linkedin_app_id", ""));
	define('LINKEDIN_CLIENT_SERECT', get_option("linkedin_app_secret", ""));
}
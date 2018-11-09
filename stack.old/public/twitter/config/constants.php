<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Table
define('TWITTER_ACCOUNTS', "twitter_accounts");
define('TWITTER_POSTS', "twitter_posts");

$twitter_app_id = get_setting("twitter_app_id", "");
$twitter_app_secret = get_setting("twitter_app_secret", "");

if($twitter_app_id != "" && $twitter_app_secret != ""){
	define('CONSUMER_KEY', $twitter_app_id);
	define('CONSUMER_SECRET', $twitter_app_secret);
}else{
	define('CONSUMER_KEY', get_option("twitter_app_id", ""));
	define('CONSUMER_SECRET', get_option("twitter_app_secret", ""));
}
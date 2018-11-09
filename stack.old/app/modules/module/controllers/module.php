<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class module extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$result = '[{"pid":"21747459","name":"Stackposts - Social Marketing Tool","description":"Stackposts is a social media marketing tool that allows and helps you to easily auto post, schedule Instagram posts along with Facebook, Twitter and many more!. It also can manage multiple social networks, schedule posts, increase your Traffic and engage your audiences. Just upload the media you want to post, type up your caption, and use the handy calendar to decide when you\u2019d like your post to go out.","version":"1.5","thumbnail":"http:\/\/api.stackposts.com\/assets\/uploads\/user1\/favicon.png","link":"https:\/\/codecanyon.net\/item\/stackposts-social-marketing-tool\/21747459"},{"pid":"22051913","name":"Pinterest Auto Post Module for Stackposts","description":"Pinterest Auto Post Module for StackPosts is one of the awesome modules for Stackposts app. It allows and helps you to easily auto post, schedule Pinterest posts. ","version":"1.0","thumbnail":"http:\/\/api.stackposts.com\/assets\/uploads\/user1\/Logo-Mark1.png","link":"https:\/\/codecanyon.net\/item\/pinterest-auto-post-module-for-stackposts\/22051913"},{"pid":"21965687","name":"Linkedin Auto Post Module for Stackposts","description":"LinkedIn auto post module is one of the awesome modules for Stackposts app. It allows and helps you to easily auto post, schedule LinkedIn posts. ","version":"1.2","thumbnail":"http:\/\/api.stackposts.com\/assets\/uploads\/user1\/Logo-Mark.png","link":"https:\/\/codecanyon.net\/item\/linkedin-auto-post-module-for-stackposts\/21965687"},{"pid":"22334533","name":"Instagram Auto Activity Module for Stackposts","description":"This is exactly that software tool. It helps put your Instagram account on autopilot, doing the liking and commenting activities for you round the clock, attracting followers to your account even when you are asleep. It\u2019s a powerful tool, but used incorrectly you could appear like a spammer and lose hard earned real followers.","version":"1.1","thumbnail":"http:\/\/api.stackposts.com\/assets\/uploads\/user1\/logo.png","link":"https:\/\/codecanyon.net\/item\/instagram-auto-activity-module-for-stackposts\/22334533"},{"pid":"20292050","name":"GramEasy - Instagram Auto Post and Activity (Standalone script)","description":"This is exactly that software tool. It helps put your Instagram account on autopilot, doing the liking and commenting activities for you round the clock, attracting followers to your account even when you are asleep. It\u2019s a powerful tool, but used incorrectly you could appear like a spammer and lose hard earned real followers.","version":"2.1","thumbnail":"http:\/\/api.stackposts.com\/assets\/uploads\/user1\/Logo-Mark3.png","link":""}]';

		$data = array(
			"result"  => json_decode($result),
			"module"  => get_class($this),
			"purchases" => []
		);

		$this->template->build('index', $data);
	}

	public function popup_install(){
		$this->load->library('user_agent');
		$data = array(
			"user_agent" => $this->agent->browser()
		);
		$this->load->view('popup_install', $data);
	}

	public function upgrade(){
		$output_filename = "install.zip";
		$purchase_code = "GPLed by g0g0";
		$version = segment(4);
		$domain = base_url();
		$result[0] = "GPLed by g0g0";
	    $result_object[1] = "1";
	    $result_object[4] = "bnVsbGVkLWJ5LW51Nzc=";
	    $result_object[3] = "1.5";
	    $result_object[2] = "app";
		$url = "http://localhost".urlencode($purchase_code)."&domain=".urlencode($domain)."&version={$version}";
	    $result = "GPLed by g0g0";

	    if($result != ""){
	    	$result_object = json_decode($result);
	    	if(is_object($result_object)){
	    		ms(array(
                	"status"  => "error",
                	"message" => $result_object->message
                ));
	    	}else{
	    		$result_object = $result;

	    		//Save file
	    		if($result_object[4] != ""){
				    $fp = fopen($output_filename, 'w');
				    fwrite($fp, base64_decode($result_object[4]));
				    fclose($fp);
				}

			    //Extract file
			    $zip = new ZipArchive;
				$res = $zip->open($output_filename);
				if ($res === TRUE) {

					//Check and save update
					$purchase_item = $this->model->get("*", PURCHASE, "purchase_code = '{$purchase_code}' AND pid = '{$result_object[1]}'");
					if(!empty($purchase_item)){

						$zip->extractTo($result_object[2]);

					    //Config module
					    $file_count = $zip->numFiles;

						for ($i=0; $i < $file_count; $i++) { 
							$dir = $zip->getNameIndex($i);
							if(strpos($dir, "config_item.json")){
								$config_path = $zip->getNameIndex($i);
								$content = file_get_contents($result_object[2].$config_path);
								$content = json_decode($content);

								$path_arr = explode("/", $config_path);

								$config_current_path = $path_arr[0]."/config.json";
								if(file_exists($result_object[2].$config_current_path)){
									$content_current = file_get_contents($result_object[2].$config_current_path);
									$content_current = json_decode($content_current, true);
									
									if(isset($content->submenu)){
										foreach ($content->submenu as $key => $value) {
											if(!isset($content_current['submenu'][$key])){
												$content_current['submenu'][$key] = $value;
											}
										}
									}

									file_put_contents($result_object[2].$config_current_path, json_encode($content_current));
									@unlink($result_object[2].$config_path);
								}else{
									@rename ($result_object[2].$config_path, $result_object[2].$config_current_path);
								}
							}
						}

						//Close ZIP
					    $zip->close();

					    //Install SQL
					    $sql = file_get_contents($result_object[2]."install.sql");

						$sqls = explode(';', $sql);
						array_pop($sqls);

						foreach($sqls as $statement){
						    $statment = $statement . ";";
						    $this->db->query($statement);   
						}

						//Remove Install
						@unlink('install.zip');
						@unlink($result_object[2]."install.sql");

						//Update data
						$item = $this->model->get("*", PURCHASE, "pid = {$result_object[1]}");
						$data = array(
							"ids" => ids(),
							"pid" => $result_object[1],
							"purchase_code" => $purchase_code,
							"version" => $result_object[3]
						);
						if(!empty($item)){
							$this->db->update(PURCHASE, $data, array("id" => $item->id));
						}

						ms(array(
							"status" => "success",
							"message" => "Update successful."
						));

					}else{

						ms(array(
							"status" => "error",
							"message" => "Seems this app is already installed! You can't reinstall it again."
						));

					}

				} else {
					ms(array(
						"status" => "error",
						"message" => "Sorry installation failed. Please try again."
					));
				}
	    	}
	    }else{
	    	
	    }
	}

	public function ajax_install_script(){
		$purchase_code = "GPLed by g0g0";
		$domain = base_url();

		$output_filename = "install.zip";

	    $url = "http://localhost/verify?purchase_code=".urlencode($purchase_code)."&domain=".urlencode($domain);
	    $result = "GPLed by g0g0";
	    $result_object[1] = "21747459";
	    $result_object[4] = "bnVsbGVkLWJ5LW51Nzc=";
	    $result_object[3] = "1.5";
	    $result_object[2] = "app";

	    if($result != ""){
	    	//$result_object = $result;
	    		//$result_object = $result;
	    		//Save file
	    		if($result_object[4] != ""){
				    $fp = fopen($output_filename, 'w');
				    fwrite($fp, base64_decode($result_object[4]));
				    fclose($fp);
				}

			    //Extract file
			    $zip = new ZipArchive;
				$res = $zip->open($output_filename);
				if ($res !== TRUE) {

					//Check and save install
					$purchase_item = $this->model->get("*", PURCHASE, "purchase_code = '{$purchase_code}' AND pid = '{$result_object[1]}'");
					if(empty($purchase_item)){

						$zip->extractTo($result_object[2]);

					    //Config module
					    $file_count = $zip->numFiles;

						for ($i=0; $i < $file_count; $i++) { 
							$dir = $zip->getNameIndex($i);
							if(strpos($dir, "config_item.json")){
								$config_path = $zip->getNameIndex($i);
								$content = file_get_contents($result_object[2].$config_path);
								$content = json_decode($content);

								$path_arr = explode("/", $config_path);

								$config_current_path = $path_arr[0]."/config.json";
								if(file_exists($result_object[2].$config_current_path)){
									$content_current = file_get_contents($result_object[2].$config_current_path);
									$content_current = json_decode($content_current, true);
									
									if(isset($content->submenu)){
										foreach ($content->submenu as $key => $value) {
											if(!isset($content_current['submenu'][$key])){
												$content_current['submenu'][$key] = $value;
											}
										}
									}

									file_put_contents($result_object[2].$config_current_path, json_encode($content_current));
									@unlink($result_object[2].$config_path);
								}else{
									@rename ($result_object[2].$config_path, $result_object[2].$config_current_path);
								}
							}
						}

						//Close ZIP
					    $zip->close();

					    //Install SQL
					    $sql = file_get_contents("app/install.sql");

						$sqls = explode(';', $sql);
						array_pop($sqls);

						foreach($sqls as $statement){
						    $statment = $statement . ";";
						    $this->db->query($statement);   
						}

						//Remove Install
						//@unlink('install.zip');
						//@unlink($result_object[2]."install.sql");

						//Insert data
						$item = $this->model->get("*", PURCHASE, "pid = {$result_object[1]}");
						$data = array(
							"ids" => ids(),
							"pid" => $result_object[1],
							"purchase_code" => $purchase_code,
							"version" => $result_object[3]
						);
						if(empty($item)){
							$this->db->insert(PURCHASE, $data);
						}else{
							$this->db->update(PURCHASE, $data, array("id" => $item->id));
						}

						ms(array(
							"status" => "success",
							"message" => "Installation successful."
						));

					}else{

						ms(array(
							"status" => "error",
							"message" => "Seems this app is already installed! You can't reinstall it again."
						));

					}

				} else {
					ms(array(
						"status" => "error",
						"message" => "Sorry installation failed. Please try again."
					));
				}
	    	}
	    }


	public function curl($url){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_VERBOSE, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    $result = curl_exec($ch);
	    curl_close($ch);

	    return $result;
	}

}

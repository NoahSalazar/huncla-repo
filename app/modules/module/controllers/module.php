<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class module extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$url = "http://api.stackposts.com/scripts/json_products";
	    $result = $this->curl($url);

		$data = array(
			"result"  => json_decode($result),
			"module"  => get_class($this),
			"purchases" => $this->model->fetch("*", PURCHASE)
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
		$purchase_code = segment(3);
		$version = segment(4);
		$domain = base_url();
		$url = "http://api.stackposts.com/upgrade?purchase_code=".urlencode($purchase_code)."&domain=".urlencode($domain)."&version={$version}";
	    $result = $this->curl($url);

	    if($result != ""){
	    	$result_object = json_decode($result);
	    	if(is_object($result_object) && $result_object->status == "error"){
	    		ms(array(
                	"status"  => "error",
                	"message" => $result_object->message
                ));
	    	}else{
	    		$result_object = explode("{|}", $result);

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
		$purchase_code = post("purchase_code");
		$domain = base_url();

		$output_filename = "install.zip";

	    $url = "http://api.stackposts.com/verify?purchase_code=".urlencode($purchase_code)."&domain=".urlencode($domain);
	    $result = $this->curl($url);
	    if($result != ""){
	    	$result_object = json_decode($result);
	    	if(is_object($result_object) && $result_object->status == "error"){
	    		ms(array(
                	"status"  => "error",
                	"message" => $result_object->message
                ));
	    	}else{
	    		$result_object = explode("{|}", $result);
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
	    }else{
	    	
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
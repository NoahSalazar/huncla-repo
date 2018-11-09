<?php 
function get_openssl_version_number($patch_as_number=false,$openssl_version_number=null) {
    if (is_null($openssl_version_number)) $openssl_version_number = OPENSSL_VERSION_NUMBER;
    $openssl_numeric_identifier = str_pad((string)dechex($openssl_version_number),8,'0',STR_PAD_LEFT);          

    $openssl_version_parsed = array();
    $preg = '/(?<major>[[:xdigit:]])(?<minor>[[:xdigit:]][[:xdigit:]])(?<fix>[[:xdigit:]][[:xdigit:]])';
    $preg.= '(?<patch>[[:xdigit:]][[:xdigit:]])(?<type>[[:xdigit:]])/';
    preg_match_all($preg, $openssl_numeric_identifier, $openssl_version_parsed);

    $openssl_version = false;
    if (!empty($openssl_version_parsed)) {
        $alphabet = array(1=>'a',2=>'b',3=>'c',4=>'d',5=>'e',6=>'f',7=>'g',8=>'h',9=>'i',10=>'j',11=>'k',12=>'l',13=>'m',
                                      14=>'n',15=>'o',16=>'p',17=>'q',18=>'r',19=>'s',20=>'t',21=>'u',22=>'v',23=>'w',24=>'x',25=>'y',26=>'z');
        $openssl_version = intval($openssl_version_parsed['major'][0]).'.';
        $openssl_version.= intval($openssl_version_parsed['minor'][0]).'.';
        $openssl_version.= intval($openssl_version_parsed['fix'][0]);
        if (!$patch_as_number && array_key_exists(intval($openssl_version_parsed['patch'][0]), $alphabet)) {
            $openssl_version.= $alphabet[intval($openssl_version_parsed['patch'][0])]; // ideal for text comparison
        }
        else {
            $openssl_version.= '.'.intval($openssl_version_parsed['patch'][0]); // ideal for version_compare
        }
    }
    
    return $openssl_version;
}

function curl($url){ 
	$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_VERBOSE, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_AUTOREFERER, false); 
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch); 
	curl_close($ch); 
	return $result; 
} 

function ms($array){ 
	print_r(json_encode($array)); exit(0); 
} 

function post($name = ""){ 
	$CI = &get_instance(); 
	if($name != ""){ 
		$post = $CI->input->post(trim($name)); 
		if(is_string($post)){ 
			return addslashes($CI->input->post(trim($name))); 
		}else{ 
			return $post; 
		} 
	}else{ 
		return $CI->input->post(); 
	} 
} 

function get($name = ""){ 
	$CI = &get_instance(); 
	return $CI->input->get(trim($name)); 
} 

if (!function_exists('pr')) {
    function pr($data, $type = 0) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($type != 0) {
            exit();
        }
    }
}

if (!function_exists('tz_list')){ 
	function tz_list() { 
		$zones_array = array();
		$timestamp = time(); 
		foreach(timezone_identifiers_list() as $key => $zone) { 
			date_default_timezone_set($zone); 
			$zones_array[$key]['zone'] = $zone; 
			$zones_array[$key]['time'] = '(UTC ' . date('P', $timestamp).") ".$zone; 
			$zones_array[$key]['sort'] = date('P', $timestamp);
		} 

		usort($zones_array, function($a, $b) { 
			return $a['sort'] - $b['sort']; 
		}); 
		return $zones_array; 
	} 
} 

function install(){ 
	$CI = &get_instance(); 
	$db_host = $CI->input->post("db_host"); 
	$db_name = $CI->input->post("db_name"); 
	$db_user = $CI->input->post("db_user"); 
	$db_pass = $CI->input->post("db_pass"); 
	$admin_fullname = $CI->input->post("admin_fullname"); 
	$admin_email = $CI->input->post("admin_email"); 
	$admin_pass = $CI->input->post("admin_pass"); 
	$admin_timezone = $CI->input->post("admin_timezone"); 
	$purchase_code = $CI->input->post("purchase_code"); 
	$output_filename = "install.zip"; 

	if (!($db_host && $db_name && $db_user && $admin_fullname && $admin_email && $admin_pass && $admin_timezone && $purchase_code)) { 
		ms(array(
			"status" => "error", 
			"message" => "Please input all fields."
		)); 
	} 

	if (filter_var($admin_email, FILTER_VALIDATE_EMAIL) === false) { 
		ms(array(
			"status" => "error", 
			"message" => "Please input a valid email."
		)); 
	} 

	$mysqli = @new mysqli($db_host, $db_user, $db_pass, $db_name); 

	if (mysqli_connect_errno()) { 
		ms(array(
			"status" => "error", 
			"message" => "Database error: ".$mysqli->connect_error
		));
	} 

	$config_file_path = APPPATH."../../app/config.php"; 
	$encryption_key = md5(rand()); 
	$config_file = file_get_contents($config_file_path);
	$is_installed = strpos($config_file, "enter_db_host"); 
	if (!$is_installed) { 
		ms(array(
			"status" => "error", 
			"message" => "Seems this app is already installed! You can't reinstall it again. Make sure you not edit file config.php and index.php"
		)); 
	} 

	$domain = base_url(); $api_endpoint = "http://api.stackposts.com/"; 
	$url = $api_endpoint . "verify?" . http_build_query(array( 
		"purchase_code" => urlencode($purchase_code), 
		"domain" => urlencode($domain), 
		"main" => 1
	)); 

	$result = curl($url); 

	if($result != ""){

		$result_object = json_decode($result); 
		if(is_object($result_object) && $result_object->status == "error"){ 
			ms(array( "status" => "error", "message" => $result_object->message )); 
		}else{ 
			$result_object = explode("{|}", $result); 
			
			if(isset($result_object[4]) && $result_object[4] != ""){ 
				file_put_contents($output_filename, base64_decode($result_object[4])); 
			} 

			$zip = new ZipArchive; 
			$res = $zip->open($output_filename); 

			if ($res === TRUE) { 
				$zip->extractTo("../".$result_object[2]); 
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
							unlink($result_object[2].$config_path); 
						}else{ 
							rename ($result_object[2].$config_path, $result_object[2].$config_current_path); 
						} 
					} 
				} 

				$zip->close(); 

				if(file_exists("../".$result_object[2]."install.sql")){ 
					$mysqli = @new mysqli($db_host, $db_user, $db_pass, $db_name); 
					$sql = file_get_contents("../".$result_object[2]."install.sql"); 
					$sql = str_replace('ADMIN_FULLNAME', $admin_fullname, $sql); 
					$sql = str_replace('ADMIN_EMAIL', $admin_email, $sql); 
					$sql = str_replace('ADMIN_PASSWORD', md5($admin_pass), $sql); 
					$sql = str_replace('ADMIN_TIMEZONE', $admin_timezone, $sql); 
					$mysqli->multi_query($sql); 

					do {} while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli)); $mysqli->close(); 

				} 

				$config_file = str_replace('enter_db_host', $db_host, $config_file); 
				$config_file = str_replace('enter_db_user', $db_user, $config_file); 
				$config_file = str_replace('enter_db_pass', $db_pass, $config_file); 
				$config_file = str_replace('enter_db_name', $db_name, $config_file); 
				$config_file = str_replace('enter_encryption_key', md5(rand()), $config_file); 
				$config_file = str_replace('enter_timezone', $admin_timezone, $config_file); 
				file_put_contents($config_file_path, $config_file); 


				$index_file_path = APPPATH."../../index.php"; 
				$index_file = file_get_contents($index_file_path); 
				$index_file = preg_replace('/installation/', 'production', $index_file, 1); 
				file_put_contents($index_file_path, $index_file); 

				$conn = new mysqli($db_host, $db_user, $db_pass, $db_name); 

				if ($conn->connect_error) { 
					ms(array(
						"status" => "success", 
						"message" => "Connection failed: " . $conn->connect_error 
					)); 
				} 

				$sql = "INSERT INTO general_purchase (ids, pid, purchase_code, version) VALUES ('".md5(rand())."', '".$result_object[1]."', '".$purchase_code."', '".$result_object[3]."')"; 

				if ($conn->query($sql) === TRUE) {

				} else { 

					ms(array( 
						"status" => "success", 
						"message" => "Error: " . $sql . "<br>" . $conn->error 
					)); 

				} 

				$conn->close(); 
				@unlink('install.zip'); 
				@unlink("../".$result_object[2]."install.sql"); 

				ms(array( 
					"status" => "success" 
				)); 
			} else { 
				ms(array( 
					"status" => "error", 
					"message" => "Sorry installation failed. Please try again." 
				)); 
			} 
		} 
	}else{ 
		ms(array( 
			"status" => "error", 
			"message" => "Sorry, there was a problem with your request" 
		)); 
	} 
}
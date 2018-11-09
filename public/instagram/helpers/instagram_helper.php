<?php
//instagram activity get value
if(!function_exists("igav")){
	function igav($type, $data, $key){
		$data_tmp = $data;
		$data = json_decode($data);
		$data = get_value($data, $type);
		switch ($type) {
			case 'todo':
				if(get_value($data, $key)){
					return true;
				}else if(empty($data_tmp)){
					return get_option('igac_enable_'.$key, ($key=="like" || $key == "comment")?1:0);
				}
				return false;

				break;

			case 'target':
				switch ($key) {
					case 'tag':
						if(get_value($data, $key)){
							return true;
						}else if(empty($data_tmp)){
							return get_option('igac_target_tag', 1);
						}
						break;

					case 'location':
						if(get_value($data, $key)){
							return true;
						}else if(empty($data_tmp)){
							return get_option('igac_target_location', 0);
						}
						break;

					case 'follower':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_follower', '');
						}
						break;

					case 'following':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_following', '');
						}
						break;

					case 'liker':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_liker', '');
						}
						break;
					
					case 'commenter':
						if(get_value($data, $key)){
							return get_value($data, $key);;
						}else if(empty($data_tmp)){
							return get_option('igac_target_commenter', '');
						}
						break;
				}
				break;

			case 'speed':

				switch ($key) {
					case 'level':
						if(get_value($data, $key)){
							return get_value($data, $key);
						}else if(empty($data_tmp)){
							return get_option('igac_speed_level', "normal");
						}
						break;
					
					default:
						if(get_value($data, $key)){
							return get_value($data, $key);
						}else if(empty($data_tmp)){
							$level = get_option('igac_speed_level', "normal");
							$level = $level!=""?$level:"normal";
							return get_option('igac_speed_'.$level.'_'.$key, "normal");
						}
						break;
				}
				if(get_value($data, $key)){
					return get_value($data, $key);
				}
				return 0;
				break;

			case 'filter':
				switch ($key) {
					case 'media_age':
						return get_value($data, $key);
						break;

					case 'media_type':
						return get_value($data, $key);
						break;

					case 'user_relation':
						return get_value($data, $key);
						break;

					case 'user_profile':
						return get_value($data, $key);
						break;

					case 'gender':
						return get_value($data, $key);
						break;
					
					default:
						if(get_value($data, $key)){
							return (int)get_value($data, $key);
						}else{
							return 0;
						}
						break;
				}
				
				break;	

			case 'stop':
				switch ($key) {
					case 'timer':
						return get_value($data, $key);
						break;

					default:
						if(get_value($data, $key)){
							return get_value($data, $key);
						}
						break;
				}
				

				return 0;
				break;	

			default:
				return get_value($data, $key);
				break;
		}
	}
}

//Instagram Activity Get Count
if(!function_exists("igac")){
	function igac($type, $data){
		if(is_string($data)){
			$data = json_decode($data);
		}

		$data = (object)$data;

		if(isset($data->$type)){
			return $data->$type;
		}else{
			return 0;
		}
	}
}

//Instagram Activity Get Status
if(!function_exists("igas")){
	function igas($data, $type=""){
		if($data->account_status == 1){
			switch ($data->status) {
				case "1":
					if($type == "text"){
						echo lang('Started');
					}else{
						echo '<span class="label label-default label-success pull-right">'.lang('Started').'</span>';
					}
					break;

				case "0":
					if($type == "text"){
						echo lang('Stopped');
					}else{
						echo '<span class="label label-default label-danger pull-right">'.lang('Stopped').'</span>';
					}
					break;
				
				default:
					if($type == "text"){
						echo lang('No_time');
					}else{
						echo '<span class="label label-default label-default pull-right">'.lang('No_time').'</span>';
					}
					break;
			}
		}else{
			if($type == "text"){
				echo '<span class="danger">'.lang('Login_required').'</span>';
			}else{
				echo '<span class="label label-default label-danger pull-right">'.lang('Login_required').'</span>';
			}
		}
	}
}

//Instagram Activity Action Type
if(!function_exists("igaa")){
	function igaa($action){
		switch ($action) {
			case "like":
				$result = array(
					"text" => lang('Liked_media'),
					"icon" => "ft-thumbs-up"
				);
				break;

			case "comment":
				$result = array(
					"text" => lang('Commented_media'),
					"icon" => "ft-message-square"
				);
				break;

			case "follow":
				$result = array(
					"text" => lang('Followed_user'),
					"icon" => "ft-user-plus"
				);
				break;

			case "unfollow":
				$result = array(
					"text" => lang('Unfollowed_user'),
					"icon" => "ft-user-x"
				);
				break;

			case "direct_message":
				$result = array(
					"text" => lang('Message_sent_to_user'),
					"icon" => "ft-message-circle"
				);
				break;
			
			default:
				$result = array(
					"text" => "",
					"icon" => ""
				);
				break;
		}

		return (object)$result;
	}
}

if(!function_exists("get_random_numbers")){
	function get_random_numbers($maxSum, $minutes = 60, $maxRandom = 3){
		$numbers = array();
	    for ($i=1; $i <= $minutes; $i++) { 
	        $rand = rand(0, $maxRandom);
	        $sum = array_sum($numbers);
	        if($sum + $rand >= $maxSum){
	            if($sum < $maxSum){
	            	$numbers[] = $maxSum - $sum;
	            }else{
	            	$numbers[] = 0;
	            }
	        }else{
	            $numbers[] = $rand;
	        }
	    }
	    shuffle($numbers);
	    return $numbers;
	}
}

if(!function_exists("get_time_next_schedule")){
	function get_time_next_schedule($numbers, $maxSum){
		$minute = 0;
		$task = 0;
		$new_numbers = array();
		if(is_string($numbers)){
			$numbers = (array)json_decode($numbers);
		}

		$numbers = (array)$numbers;

		if(!empty($numbers) && $numbers[0] != 0){
			$task = $numbers[0];
			unset($numbers[0]);
			$numbers = array_values($numbers);
		}

		foreach ($numbers as $key => $value) {
			if($value == 0){
				$minute++;
				unset($numbers[$key]);
			}else{
				break;
			}
		}

		if(empty($numbers)){
			$numbers = get_random_numbers($maxSum);
		}else{
			$numbers = array_values($numbers);
		}

		return (object)array(
			"task" => $task,
			"minute" => $minute,
			"numbers" => $numbers
		);

	}
}

if(!function_exists("get_action_left")){
	function get_action_left($numbers, $action_complete, $task){
		if(count($action_complete) < $task){
			$action_left = $task - count($action_complete);
			if(!empty($numbers)){
				$zero_indexs = array();
				foreach ($numbers as $key => $value) {
					if($value == 0){
						$zero_indexs[] = $key;
					}
				}

				if(!empty($zero_indexs)){
					$zero_index = get_random_value($zero_indexs);
					$numbers[$zero_index] = $action_left;
				}
			}
			return $numbers;
		}else{
			return $numbers;
		}
	}
}

if(!function_exists("ig_get_setting")){
	function ig_get_setting($key, $value = "", $id){
		$CI = &get_instance();

		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$setting = $CI->help_model->get("settings", INSTAGRAM_ACTIVITIES, "id = '".$id."'");
		if(!empty($setting)){
			$setting = $setting->settings;
			$option = json_decode($setting);

			if(is_array($option) || is_object($option)){
				$option = (array)$option;

				if( isset($option[$key]) ){
					return row($option, $key);
				}else{
					$option[$key] = $value;
					$CI->db->update(INSTAGRAM_ACTIVITIES, array("settings" => json_encode($option)), array("id" => $id) );
					return $value;
				}
			}else{
				$option = json_encode(array($key => $value));
				$CI->db->update(INSTAGRAM_ACTIVITIES, array("settings" => $option), array("id" => $id));
				return $value;
			}
		}

		return false;
	}
}

if(!function_exists("ig_update_setting")){
	function ig_update_setting($key, $value, $id){
		$CI = &get_instance();
		
		if(empty($CI->help_model)){
			$CI->load->model('model', 'help_model');
		}

		$setting = $CI->help_model->get("settings", INSTAGRAM_ACTIVITIES, "id = '".$id."' ")->settings;
		$option = json_decode($setting);
		if(is_array($option) || is_object($option)){
			$option = (array)$option;
			if( isset($option[$key]) ){
				$option[$key] = $value;
				$CI->db->update(INSTAGRAM_ACTIVITIES, array("settings" => json_encode($option)), array("id" => $id) );
				return true;
			}
		}
		return false;
	}
}

if(!function_exists("Instagram_Get_Message")){
	function Instagram_Get_Message($message){
		$message = explode(": ", $message);
		if(count($message) == 2){
			return $message[1];
		}else if(count($message) > 2){
			return $message[2];
		}else{
			return $message[0];
		}
	}
}

if(!function_exists("Instagram_Post_Type")){
	function Instagram_Post_Type($type){
		if($type == "photo" || $type == "story" || $type = "carousel"){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists("Instagram_Caption")){
	function Instagram_Caption($caption){
		$caption = preg_replace("/\r\n\r\n/", "?.??.?", $caption);
		$caption = preg_replace("/\r\n/", "?.?", $caption);
		$caption = str_replace("?.? ?.?", "?.?", $caption);
		$caption = str_replace(" ?.?", "?.?", $caption);
		$caption = str_replace("?.? ", "?.?", $caption);
		$caption = str_replace("?.??.?", "\n\n", $caption);
		$caption = str_replace("?.?", "\n", $caption);
		return $caption;
	}
}

if(! function_exists("Instagram_Unlink_Temp")){
	function Instagram_Unlink_Temp($link){
		if (stripos($link, "/tmp/") !== false) {
			unlink($link);
		}
	}
}

if(! function_exists("Instagram_ParseCookies")){
	function Instagram_ParseCookies($strHeaders)  
	{  
	    $result = array();  
	      
	    if (!empty($strHeaders))  
	    {  
	        $aHeaders = explode("\n", trim($strHeaders));  
	        $strCookieStartLine = 'Set-Cookie:';  
	          
	        foreach ($aHeaders as $line)  
	        {  
	            if (substr($line, 0, strlen($strCookieStartLine)) === $strCookieStartLine)  
	            {  
	                $aTmp = array();  
	                  
	                $aPairs = explode(';', trim(str_replace($strCookieStartLine, '', $line)));  
	                foreach ($aPairs as $pair)  
	                {  
	                    $aKeyValues = explode('=', trim($pair), 2);  
	                    if (count($aKeyValues) == 2)  
	                    {  
	                        switch ($aKeyValues[0])  
	                        {  
	                            case 'path':  
	                            case 'domain':  
	                                $aTmp[trim($aKeyValues[0])] = urldecode(trim($aKeyValues[1]));  
	                                break;  
	                            case 'expires':  
	                                $aTmp[trim($aKeyValues[0])] = strtotime(urldecode(trim($aKeyValues[1])));  
	                                break;  
	                            default:  
	                                $aTmp['name'] = trim($aKeyValues[0]);  
	                                $aTmp['value'] = trim($aKeyValues[1]);  
	                                break;  
	                        }  
	                    }  
	                }  
	                  
	                $result[] = $aTmp;  
	            }  
	        }  
	    }  
	      
	    return $result;  
	}  
}

function parse_cookies($header) {
	
	$cookies = array();
	
	$cookie = new cookie();
	
	$parts = explode("=",$header);
	for ($i=0; $i< count($parts); $i++) {
		$part = $parts[$i];
		if ($i==0) {
			$key = $part;
			continue;
		} elseif ($i== count($parts)-1) {
			$cookie->set_value($key,$part);
			$cookies[] = $cookie;
			continue;
		}
		$comps = explode(" ",$part);
		$new_key = $comps[count($comps)-1];
		$value = substr($part,0,strlen($part)-strlen($new_key)-1);
		$terminator = substr($value,-1);
		$value = substr($value,0,strlen($value)-1);
		$cookie->set_value($key,$value);
		if ($terminator == ",") {
			$cookies[] = $cookie;
			$cookie = new cookie();
		}
		
		$key = $new_key;
	}
	return $cookies;
}
class cookie {
	public $name = "";
	public $value = "";
	public $expires = "";
	public $domain = "";
	public $path = "";
	public $secure = false;
	
	public function set_value($key,$value) {
		switch (strtolower($key)) {
			case "expires":
				$this->expires = $value;
				return;
			case "domain":
				$this->domain = $value;
				return;
			case "path":
				$this->path = $value;
				return;
			case "secure":
				$this->secure = ($value == true);
				return;
		}
		if ($this->name == "" && $this->value == "") {
			$this->name = $key;
			$this->value = $value;
		}
	}
}

if (! function_exists('Instagram_Resize2')) {
	function Instagram_Resize2($source_image, $destination, $min_aspectRatio, $max_aspectRatio, $quality = 100, $wmsource = false){
		if(file_exists($source_image)){
            $sizes = @getimagesize($source_image);
	        $width = $sizes['0'];
	        $height = $sizes['1'];
	        //Check image extension
	        switch ($sizes['mime']) {
	            case 'image/jpeg'   :
	                $images = @imagecreatefromjpeg($source_image);
	                break;
	            case 'image/png'    :
	                $images = @imagecreatefrompng($source_image);
	                break;
	            case 'image/gif'    :
	                $images = @imagecreatefromgif($source_image);
	                break;
	            default :
	                throw new \Exception('Error: Unidentified image extension.');
	                exit;
	        }
	        //IMAGE PROCESS
	        if($width <= 320 && $height <= 320){
	            $newHeight = round((320 / $width) * $height);
	            $newWidth = round(($newHeight / $height) * $width);
	            $im = imagecreatetruecolor(320, 320);
	            $wb = imagecolorallocate($im, 255, 255, 255);
	            imagefill($im,0,0,$wb);
	            $x = (320 - $newHeight) / 2;
	            $y = (320 - $newWidth) / 2;
	            imagecopyresized($im, $images, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);
	        }
	        elseif ($width >= $height && $width >= 1080) {
	            $newHeight = round((1080 / $width) * $height);
	            $newWidth = round(($newHeight / $height) * $width);
	            if ($height < 575) {
	                $newHeight = 575;
	            } elseif ($height > 1080) {
	                $newHeight = 1080;
	            }
	            $im = imagecreatetruecolor(1080, 1080);
	            $wb = imagecolorallocate($im, 255, 255, 255);
	            imagefill($im, 0, 0, $wb);
	            if (1080 > $newHeight) {
	                $y = (1080 - $newHeight) / 2;
	            } else {
	                $y = ($newHeight - 1080) / 2;
	            }
	            if (1080 > $newWidth) {
	                $x = (1080 - $newWidth) / 2;
	            } else {
	                $x = ($newWidth - 1080) / 2;
	            }
	            imagecopyresized($im, $images, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);
	        }
	        elseif ($width >= $height && $width < 1080) {
	            $newHeight = round((640 / $width) * $height);
	            $newWidth = round(($newHeight / $height) * $width);
	            $im = imagecreatetruecolor(640, $newHeight);
	            $wb = imagecolorallocate($im, 255, 255, 255);
	            imagefill($im, 0, 0, $wb);
	            if (640 > $newHeight) {
	                $y = (640 - $newHeight) / 2;
	            } else {
	                $y = ($newHeight - 640) / 2;
	            }
	            if (640 > $newWidth) {
	                $x = (640 - $newWidth) / 2;
	            } else {
	                $x = ($newWidth - 640) / 2;
	            }
	            imagecopyresized($im, $images, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);
	        }
	        elseif ($height >= $width && $height > 1100) {
	            $newHeight = round((1080 / $width) * $height);
	            $newWidth = round((1349 / $height) * $width);
	            $im = imagecreatetruecolor(1080, 1349);
	            $wb = imagecolorallocate($im, 255, 255, 255);
	            imagefill($im, 0, 0, $wb);
	            if (1379 > $newHeight) {
	                $y = (1379 - $newHeight) / 2;
	            }
	            else {
	                $y = ($newHeight - 1379) / 2;
	            }
	            if (1080 > $newWidth) {
	                $x = (1080 - $newWidth) / 2;
	            } else {
	                $x = ($newWidth - 1080) / 2;
	            }
	            imagecopyresized($im, $images, $x, 0, 0, 0, $newWidth, 1349, $width, $height);
	        }
	        elseif ($height > $width && $height <= 1100) {
	            $newHeight = round((640 / $width) * $height);
	            $newWidth = round((799 / $height) * $width);
	            $im = imagecreatetruecolor(640, 799);
	            $wb = imagecolorallocate($im, 255, 255, 255);
	            imagefill($im, 0, 0, $wb);
	            if (799 > $newHeight) {
	                $y = (799 - $newHeight) / 2;
	            }
	            else {
	                $y = ($newHeight - 799) / 2;
	            }
	            if (640 > $newWidth) {
	                $x = (640 - $newWidth) / 2;
	            } else {
	                $x = ($newWidth - 640) / 2;
	            }
	        
	            imagecopyresized($im, $images, $x, 0, 0, 0, $newWidth, 799, $width, $height);
	        }
	        $uniqID = uniqid();
	        $path = $destination;
	        imagejpeg($im, $path, 100);

	        return $path;

		}
	    return false;
	}
}


if (! function_exists('Instagram_Resize')) {
	function Instagram_Resize($source_image, $destination, $min_aspectRatio, $max_aspectRatio, $quality = 100, $wmsource = false){
		if(file_exists($source_image)){
			$tn_w = 800;
			$tn_h = 800;
		    $info = getimagesize($source_image);
		    $imgtype = image_type_to_mime_type($info[2]);

		    #assuming the mime type is correct
		    switch ($imgtype) {
		        case 'image/jpeg':
		            $source = imagecreatefromjpeg($source_image);
		            break;
		        case 'image/gif':
		            $source = imagecreatefromgif($source_image);
		            break;
		        case 'image/png':
		            $source = imagecreatefrompng($source_image);
		            break;
		    }

		    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
		    $src_w = imagesx($source);
		    $src_h = imagesy($source);
		    $aspectRatio = $src_w / $src_h;
		    if(($src_w <= 1080 || $src_h <= 1080) && ($src_w >= 320 || $src_h >= 320)){
			    if($aspectRatio < $min_aspectRatio &&  $src_h >= 320){
			    	$tn_w = $src_h*$min_aspectRatio;
			    	$tn_h = $src_h;
			    }

			    if($aspectRatio < $min_aspectRatio &&  $src_h < 320){
			    	$tn_w = 320*$min_aspectRatio;
			    	$tn_h = 320;
			    }

			    if($aspectRatio > $max_aspectRatio &&  $src_w/$max_aspectRatio >= 320){
			    	$tn_w = $src_w;
		    		$tn_h = $src_w/$max_aspectRatio;
			    }

			    if($aspectRatio > $max_aspectRatio &&  $src_w/$max_aspectRatio < 320){
			    	$tn_w = $src_w;
			    	$tn_h = 320;
			    }

			    if($aspectRatio <= $max_aspectRatio && $aspectRatio >= $min_aspectRatio){
			    	$tn_w  = $src_w;
			    	$tn_h  = $src_h;
			    }
			}

			if($src_w < 320 || $src_h < 320){
				if($aspectRatio < $min_aspectRatio){
			    	$tn_w = 320;
			    	$tn_h = 320/$min_aspectRatio;
			    }

			    if($aspectRatio > $max_aspectRatio){
			    	$tn_w = 320*$max_aspectRatio;
			    	$tn_h = 320;
			    }
			}

			if($src_w > 1080 || $src_h > 1080){
				if($aspectRatio < $min_aspectRatio){
			    	$tn_w = 1080*$min_aspectRatio;
			    	$tn_h = 1080;
			    }

			    if($aspectRatio > $max_aspectRatio){
			    	$tn_h = 1080/$max_aspectRatio;
			    	$tn_w = 1080;
			    }

			    if($aspectRatio <= $max_aspectRatio && $aspectRatio >= $min_aspectRatio){
			    	if($aspectRatio > 1){
			    		$tn_w = 1080;
			    		$tn_h = 1080/$aspectRatio;
			    	}else{
			    		$tn_w = 1080*$aspectRatio;
			    		$tn_h = 1080;
			    	}
			    }
			}

		    #Do some math to figure out which way we'll need to crop the image
		    #to get it proportional to the new size, then crop or adjust as needed

		    $x_ratio = $tn_w / $src_w;
		    $y_ratio = $tn_h / $src_h;

		    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
		        $new_w = $tn_w;
		        $new_h = $tn_h;
		    } elseif (($x_ratio * $src_h) < $tn_h) {
		        $new_h = ceil($x_ratio * $src_h);
		        $new_w = $tn_w;
		    } else {
		        $new_w = ceil($y_ratio * $src_w);
		        $new_h = $tn_h;
		    }

		    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
		    imagealphablending( $newpic, false );
			imagesavealpha( $newpic, true );
		    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
		    $final = imagecreatetruecolor($tn_w, $tn_h);

		    $backgroundColor = imagecolorallocate($final, 255, 255, 255);
		    imagefill($final, 0, 0, $backgroundColor);
		    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
		    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

		    #if we need to add a watermark
		    if ($wmsource) {
		        #find out what type of image the watermark is
		        $info    = getimagesize($wmsource);
		        $imgtype = image_type_to_mime_type($info[2]);

		        #assuming the mime type is correct
		        switch ($imgtype) {
		            case 'image/jpeg':
		                $watermark = imagecreatefromjpeg($wmsource);
		                break;
		            case 'image/gif':
		                $watermark = imagecreatefromgif($wmsource);
		                break;
		            case 'image/png':
		                $watermark = imagecreatefrompng($wmsource);
		                break;
		            default:
		                die('Invalid watermark type.');
		        }

		        #if we're adding a watermark, figure out the size of the watermark
		        #and then place the watermark image on the bottom right of the image
		        $wm_w = imagesx($watermark);
		        $wm_h = imagesy($watermark);
		        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

		    }
		    if (imagejpeg($final, $destination, $quality)) {
		        return true;
		    }
		}
	    return false;
	}
}

function instagram_image_handlers($file_path, $type, $uid = 0){
	$file_path = get_path_file($file_path);
    switch ($type) {
    	case 'photo':
    		$img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
		        "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE,
		        "operation" => \InstagramAPI\Media\InstagramMedia::CROP
		    ]);
    		break;

    	case 'story':
    		$img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                "targetFeed" => \InstagramAPI\Constants::FEED_STORY,
                "operation" => \InstagramAPI\Media\InstagramMedia::CROP
            ]);
    		break;

    	case 'carousel':
    		$img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE_ALBUM,
                "operation" => \InstagramAPI\Media\InstagramMedia::CROP,
                "minAspectRatio" => 1.0,
                "maxAspectRatio" => 1.0
            ]);
    		break;
    }

    $img = $img->getFile();

    if(strrpos($img,"INSTAIMG") === FALSE){

	    if(permission("watermark", $uid)){
	    	$new_image_path = get_tmp_path(ids().".jpg");
	        $new_image_path = Watermark($img, $new_image_path, $uid);
	        $img = $new_image_path;
	    }

    }else{

    	$img = $img.".jpg";

	    if(permission("watermark", $uid)){
	        $new_image_path = Watermark($img, "", $uid);
	        $img = $new_image_path;
	    }

    }
    
    return $img;
}

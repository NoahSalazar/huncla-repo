<?php
if(!function_exists("Twitter_Post_Type")){
	function Twitter_Post_Type($type){
		if($type == "photo" || $type == "story" || $type = "carousel"){
			return true;
		}else{
			return false;
		}
	}
}
?>
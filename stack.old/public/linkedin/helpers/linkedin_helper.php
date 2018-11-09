<?php
if ( ! function_exists('get_info_link')){
	function get_info_link($url)
	{	

		$info = array(
			'title' => "",
			'description' => "",
			'image' => "",
		);

		// Check if the URL is youtube video
		$youtube_reg = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
		if(preg_match($youtube_reg, $url, $match)){
			//https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=B4CRkpBGQzU&format=json
			$result = get_curl("https://www.youtube.com/oembed?url=".$url."&format=json");
			$result = json_decode($result);
			if(!empty($result)){

				if(isset($result->title))
					$info['title'] = $result->title;

				if(isset($result->thumbnail_url))
					$info['image'] = $result->thumbnail_url;
			}
			
			return $info;
		}
		
		$result = get_curl($url);
		$doc = new DOMDocument();
		@$doc->loadHTML(mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'));
		$title = $doc->getElementsByTagName('title');
		$metas = $doc->getElementsByTagName('meta');

		$info["title"] = isset($title->item(0)->nodeValue) ? $title->item(0)->nodeValue : "";

		for ($i = 0; $i < $metas->length; $i++){
		    $meta = $metas->item($i);
		    
		    if($info['description'] == ""){
			    if(strtolower($meta->getAttribute('name')) == 'description'){
			        $info['description'] = $meta->getAttribute('content');
			    }
			}
			if($info['image'] == ""){
				if($meta->getAttribute('property') == 'og:image'){
			        $info['image'] = $meta->getAttribute('content');
			    }
			}
		}

		if($info['description'] == ""){
			for ($i = 0; $i < $metas->length; $i++){
			    $meta = $metas->item($i);
				if(strtolower($meta->getAttribute('property')) == 'og:description'){
			       	$info['description'] = $meta->getAttribute('content');
			   	}
			}
		}

		if($info['description'] == ""){
			for ($i = 0; $i < $metas->length; $i++){
		    	$meta = $metas->item($i);
				$body = $doc->getElementsByTagName('body');
				$text = strip_tags($body->item(0)->nodeValue);
				$dots = "";
				if(strlen(utf8_decode($text))>250) $dots = "...";
				$text = mb_substr(stripslashes($text),0,250, 'utf-8');
				$info['description'] = $text.$dots;
			}
		}

		return $info;
	}
}
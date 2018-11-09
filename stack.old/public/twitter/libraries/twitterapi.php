<?php
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class twitterapi{
    private $consumer_key;
    private $consumer_secret;
    private $oauth_token;
    private $oauth_token_secret;
    private $twitter;

    public function __construct($consumer_key = null, $consumer_secret = null, $oauth = false){
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;

        try {
            if($oauth == true){
                $this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
                $oauth_token = (object)$this->twitter->oauth('oauth/request_token', ['oauth_callback' => cn("twitter/add_account")]);
                $this->oauth_token = $oauth_token->oauth_token;
                $this->oauth_token_secret = $oauth_token->oauth_token_secret;
            }

            if(session("twitter_oauth_token") && session("twitter_oauth_token_secret")){
                $this->oauth_token = session("twitter_oauth_token");
                $this->oauth_token_secret = session("twitter_oauth_token_secret");
            }

            if($this->oauth_token == null && $this->oauth_token_secret == null){
                $this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
            }else{
                $this->twitter = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->oauth_token, $this->oauth_token_secret);
            }
        } catch (Exception $e) {
            $result = json_decode($e->getMessage());
            echo $result->errors[0]->message;
            echo "<br/>Please configure the Twitter API to get started. (<a href='".cn("settings/social")."'>Social settings</a>)";
            exit(0);
        }
    }

	function login_url(){
		$url = $this->twitter->url("oauth/authorize", ["oauth_token" => $this->oauth_token]);
        if(!session("twitter_oauth_token") && !session("twitter_oauth_token_secret")){
            set_session("twitter_oauth_token", $this->oauth_token);
            set_session("twitter_oauth_token_secret", $this->oauth_token_secret);
        }
		return $url;
	}

    function re_login($response, $account_id){
        if(isset($response->errors) && 
            (
                $response->errors[0]->code == 89 
                || $response->errors[0]->code == 135 
                || $response->errors[0]->code == 64 
                || $response->errors[0]->code == 63 
                || $response->errors[0]->code == 50 
                || $response->errors[0]->code == 32 
            )
        ){
            $CI = &get_instance();
            $CI->db->update(TWITTER_ACCOUNTS, array("status" => 0), "id = '{$account_id}'");
        }
    }
    
    function get_access_token(){
        try {
            unset_session("twitter_oauth_token");
            unset_session("twitter_oauth_token_secret");
            $access_token = $this->twitter->oauth("oauth/access_token", ["oauth_verifier" => get("oauth_verifier")]);
            return $access_token;
        } catch (Exception $e) {
            redirect(cn("twitter/oauth"));
        }
	}

    function set_access_token($token){
        $token = json_decode($token);
        $this->twitter->setOauthToken($token->oauth_token, $token->oauth_token_secret);
    }

    function check_status_upload($media_id){
        return $this->twitter->get('media/upload', array("command" => "STATUS", "media_id" => $media_id));
    }

    function post($data){
        $spintax  = new Spintax();
        $data     = (object)$data;
        $response = array();
        try {
            $data->data = (object)json_decode($data->data);
            $media      = $data->data->media;
            $caption    = @$spintax->process($data->data->caption);
            $params     = array('status' => $caption);

            switch ($data->type) {
                case 'text':
                    $response = $this->twitter->post('statuses/update', $params);
                    break;

                case 'photo':
                    $this->twitter->setTimeouts(120,60);
                    $media_ids = array();
                    foreach ($media as $item) {
                        $image_info = get_image_size($item);
                        if(!empty($image_info)){
                            $uploadedMedia = $this->twitter->upload('media/upload', array('media' => get_path_file($item) ));
                            $media_ids[] =  isset($uploadedMedia->media_id_string)?$uploadedMedia->media_id_string:"";
                        }
                    }

                    $params['media_ids'] = implode(',', $media_ids);
                    $response = $this->twitter->post('statuses/update', $params);
                    $this->re_login($response, $data->account);
                    break;

                case 'video':
                    $this->twitter->setTimeouts(120,60);
                    $uploadedMedia = $this->twitter->upload('media/upload', array(
                        'media' => get_path_file($media[0]),
                        'media_type' => 'video/mp4',
                        'media_category' => 'tweet_video'
                    ), true);

                    $videoCount = 0;
                    do{
                        $statusResponse = $this->twitter->get_upload(
                            'media/upload',
                            array(
                                "command" => "STATUS",
                                "media_id" => isset($uploadedMedia->media_id_string)?$uploadedMedia->media_id_string:""
                            ),
                            true  //I added a boolean variable to override the endpoint, if true, get use the UPLOAD endpoint, not the API 
                        );

                        if ($statusResponse->processing_info->state != 'succeeded'){ 
                            sleep(5); 
                        }
                        $videoCount++;
                    }

                    while ($statusResponse->processing_info->state != 'succeeded' && $videoCount < 5);

                    $params['media_ids'] = $uploadedMedia->media_id;
                    $response = $this->twitter->post('statuses/update', $params);
                    $this->re_login($response, $data->account);
                    break;
            }

            if(isset($response->id)){
                return $response->id;
            }else if(isset($response->errors)){
                return array(
                    "status"  => "error",
                    "message" => $response->errors[0]->message
                );
            }else{
                return array(
                    "status"  => "error",
                    "message" => "Unknow error"
                );
            }
            
        } catch (Exception $e) {
            return array(
                "status"  => "error",
                "message" => $e->getMessage()
            );
        }
    }
}
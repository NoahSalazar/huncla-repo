<?php
require "Facebook/autoload.php";

class facebookapi{
    private $username;
    private $password;
    private $access_token;
    private $app_id;
    private $app_secret;
    private $app_version;
    private $fb;
    private $account_id;

    public function __construct($app_id = null, $app_secret = null, $app_version = "v2.11"){
        $this->account_id = 0;

        if($app_id != "" && $app_secret != ""){
            $this->app_id = $app_id;
            $this->app_secret = $app_secret;
            $this->app_version = $app_version;
        }else{
            $this->app_id = "NONE";
            $this->app_secret = "NONE";
            $this->app_version = "v2.11";
        }

        $fb = new \Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => $this->app_version,
        ]);

        $this->fb = $fb;
    }

    function set_proxy($proxy){
        if($proxy != "")
            $this->proxy = $proxy;
    }

    function re_login($response){
        $response = $response->getResponse()->getBody();
        $response = json_decode($response);

        if(isset($response->error) && $this->account_id != 0 && 
            (
                $response->error->code == 190 
                || $response->error->code == 368 
                || $response->error->code == 10 
            )
        ){
            $CI = &get_instance();
            $CI->db->update(FACEBOOK_ACCOUNTS, array("status" => 0), "id = '{$this->account_id}'");
        }
    }

    function set_access_token($access_token){
        $this->fb->setDefaultAccessToken($access_token);
        $this->access_token = $access_token;
    }

    function set_username($username){
        $this->username = $username;
    }

    function set_password($password){
        $this->password = json_decode($password);
    }

    function get_current_user(){
        return $this->get('/me?fields=name,id');
    }

    function get_app_info(){
        return $this->get('/app');
    }

    function get_access_token_page($pid){
        $response = $this->get('/'.$pid.'/?fields=access_token');
        if(is_object($response)){
            return $response->access_token;
        }else{
            return false;
        }
    }

    function get_groups($type){
        switch ($type) {
            case 'group':
                return $this->get('/me/groups?fields=id,icon,name,description,email,privacy,cover,members.limit(0).summary(true)&limit=10000');
                break;

            case 'page':
                return $this->get('/me/accounts?fields=id,name,single_line_address,phone,emails,website,fan_count,link,is_verified,about,picture,category&limit=10000');
                break;
            
            case 'friend':
                return $this->get('/me/friends?fields=id,name,birthday,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range,friends.limit(0).summary(true)&limit=10000');
                break;
        }
    }

    function get_search($keyword, $type, $direction = "", $cursors = ""){
        switch ($type) {
            case 'group_member':
                if($direction != "" && $cursors != ""){
                    $direction = "&{$direction}={$cursors}";
                }

                return $this->get(urlencode($keyword)."/members?limit=".get_setting("fb_search_limit_group_members", 50)."&fields=id,name,birthday,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range,friends.limit(0).summary(true)".$direction);
                break;

            case 'user_friend':
                if($direction != "" && $cursors != ""){
                    $direction = "&{$direction}={$cursors}";
                }

                return $this->get(urlencode($keyword)."/friends?limit=".get_setting("fb_search_limit_friends", 50)."&fields=id,name,birthday,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range,friends.limit(0).summary(true)".$direction);
                break;

            case 'post_likers':
                if($direction != "" && $cursors != ""){
                    $direction = "&{$direction}={$cursors}";
                }

                return $this->get(urlencode($keyword)."/likes?limit=".get_setting("fb_search_limit_post_likers", 50)."&fields=id,name,birthday,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range,friends.limit(0).summary(true)".$direction, "v1.0");
                break;

            case 'post_commenters':
                if($direction != "" && $cursors != ""){
                    $direction = "&{$direction}={$cursors}";
                }

                return $this->get(urlencode($keyword)."/comments?limit=".get_setting("fb_search_limit_post_commenters", 50).$direction,"v1.0");
                break;

            default:

                switch ($type) {
                    case 'page':
                        $fields = "?fields=id,name,single_line_address,phone,emails,website,fan_count,link,is_verified,about,picture";
                        $limit = get_setting("fb_search_limit_page", 50);
                        break;
                    case 'group':
                        $fields = "?fields=id,icon,name,description,email,privacy,cover,members.limit(0).summary(true)&pretty=1";
                        $limit = get_setting("fb_search_limit_group", 50);
                        break;
                    case 'user':
                        if($direction != ""){
                            $direction = "offset";
                        }

                        $fields = "?fields=id,name,birthday,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range,friends.limit(0).summary(true)";
                        $limit = get_setting("fb_search_limit_user", 50);
                        break;
                    case 'event':
                        $fields = "?fields=id,name,attending_count,noreply_count,maybe_count,interested_count,declined_count,owner,place,category,can_guests_invite,cover,start_time,end_time,type,ticket_uri";
                        $limit = get_setting("fb_search_limit_event", 50);
                        break;
                    case 'place':
                        $fields = '?fields=id,name,location';
                        $limit = get_setting("fb_search_limit_place", 50);
                        break;
                }

                if($direction != "" && $cursors != ""){
                    $direction = "&{$direction}={$cursors}";
                }

                if(isset($fields)){
                    return $this->get("/search{$fields}&type={$type}&limit={$limit}&q=".urlencode($keyword).$direction);
                }else{
                    return false;
                }
                break;
        }
        
    }

    function get_page_access_token($username = "", $password = "", $app = ""){
        switch ($app) {
            case 'android':
                //6628568379
                $api_key = "882a8490361da98702bf97a021ddc14d";
                $secret_key = "62f8ce9f74b12f84c123cc23437a4a32";
                break;

            default:
                //350685531728
                $api_key = "3e7c78e35a76a9299309885393b02d97";
                $secret_key = "c1e620fa708a1d5696fb991c1bde5662";
                break;
        }

        $post_fields = array(
            "api_key" => $api_key,
            "email" => $username,
            "format" => "json",
            "locale" => "en_us",
            "method" => "auth.login",
            "password" => encrypt_decode($password),
            "return_ssl_resources" => "0",
            "v" => "1.0"
        );
        
        $post_fields['sig'] = self::create_signature($post_fields, $secret_key);
        $query = http_build_query($post_fields);
        return "https://api.facebook.com/restserver.php?".$query;
    }

    function create_signature($post_fields, $secret_key){
        $textsig = "";
        foreach($post_fields as $key => $value){
            $textsig .= "$key=$value";
        }
        $textsig .= $secret_key;
        $textsig = md5($textsig);
        
        return $textsig;
    }

    /**
     * Post is array include values
     *  + Caption 
     *  + Link
     *  + Media: Array photo
     *  + Gid: Facebook ID, Group ID, Page ID
    */
    function create_post($type, $data, $gid = 'me', $group_type = 'profile'){
        $spintax = new Spintax();
        if($group_type == 'page'){
            $access_token_page = $this->get_access_token_page($gid);
            if($access_token_page){
                $this->set_access_token($access_token_page);
            }
        }

        $data = (object)$data;
        $data->data = (object)json_decode($data->data);
        $medias      = $data->data->media;
        $caption    = @$spintax->process($data->data->caption);
        $link       = @$spintax->process($data->data->link);
        $this->account_id = $data->account;

        switch ($type) {
            case 'text':
                $param = array(
                    'message' => $caption
                );

                if($group_type == 'profile'){
                    $param['privacy'] = array(
                        'value' => 'EVERYONE'
                    );
                }

                return $this->post('/'.$gid.'/feed', $param);
                break; 

            case 'link':

                $param = array(
                    'message' => $caption,
                    'link' => $link
                );

                if($group_type == 'profile'){
                    $param['privacy'] = array(
                        'value' => 'EVERYONE'
                    );
                }

                return $this->post('/'.$gid.'/feed', $param);
                break;

            case 'media':
                if(count($medias) == 1)
                {

                    if(is_image($medias[0]))
                    {
                        $param = array(
                            'message' => $caption,
                            'url' => $medias[0],
                            'value' => 'EVERYONE'
                        );
                        return $this->post('/'.$gid.'/photos', $param);
                    }
                    else
                    {
                        $param = array(
                            'description' => $caption,
                            'file_url' => $medias[0],
                            'value' => 'EVERYONE'
                        );

                        return $this->post('/'.$gid.'/videos', $param);
                    }

                }
                else if(count($medias) > 1)
                {
                    $media_ids = array();
                    
                    $param = array();
                    $count = 0;
                    foreach ($medias as $key => $media)
                    {   
                        if(is_image($media))
                        {
                            $param_tmp = array(
                                'url' => $media,
                                'published' => false
                            );

                            $request = $this->post('/'.$gid.'/photos', $param_tmp);

                            if(is_object($request)){
                                $media_ids['attached_media['.$count.']'] = '{"media_fbid":"'.$request->id.'"}';
                                $count++;
                            }
                        }
                        else
                        {
                            $param_tmp = array(
                                'file_url' => $media
                            );

                            if($group_type == 'profile'){
                                $param_tmp['privacy'] = array(
                                    'value' => 'EVERYONE'
                                );
                            }

                            $request = $this->post('/'.$gid.'/videos', $param_tmp);

                            if(is_object($request)){
                                $media_ids['attached_media['.$count.']'] = '{"media_fbid":"'.$request->id.'"}';
                                $count++;
                            }
                        }
                    }

                    $param = array(
                        'message' => $caption
                    );

                    if($group_type == 'profile'){
                        $param['privacy'] = array(
                            'value' => 'EVERYONE'
                        );
                    }

                    $param += $media_ids;

                    return $this->post('/'.$gid.'/feed', $param);
                }
                else
                {

                }

                $param = array(
                    'message' => $caption,
                );

                if($group_type == 'profile'){
                    $param['privacy'] = array(
                        'value' => 'EVERYONE'
                    );
                }

                return $this->post('/'.$gid.'/feed', $param);
                break;
            
            default:
                # code...
                break;
        }
    }

    function get($params, $app_version = null){
        try {
            $response = $this->fb->get($params, null, null, $app_version);
            return json_decode($response->getBody()); 
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }


    function post($params, $data){
        try {
            $response = $this->fb->post($params, $data);
            return json_decode($response->getBody()); 
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            $this->re_login($e);
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
}

?>


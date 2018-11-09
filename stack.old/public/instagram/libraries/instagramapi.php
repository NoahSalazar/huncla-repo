<?php
require "instagram-php/autoload.php";
if(file_exists(APPPATH."../public/instagram/libraries/instagram_activity.php")){
    require "instagram_activity.php";
}

class instagramapi{
    public $username;
    public $password;
    public $proxy;
    public $ig;
    public $twoFactorIdentifier = NULL;

    public function __construct($username = null, $password = null, $proxy = null, $verificationCode = null){
        if(file_exists(APPPATH."../public/instagram/libraries/instagram_activity.php")){
            $this->activity = new instagram_activity($this);
        }

        if($username != null && $password != null){
            $password = encrypt_decode($password);
            $this->username = $username;
            $this->password = $password;
            $this->proxy = $proxy;
            
            $ig = new \InstagramAPI\Instagram(false, false, [
                'storage'    => 'mysql',
                'dbhost'     => DB_HOST,
                'dbname'     => DB_NAME,
                'dbusername' => DB_USER,
                'dbpassword' => DB_PASS,
                'dbtablename'=> "instagram_sessions"
            ]);

            $ig->setVerifySSL(false);

            if(!empty($proxy)){
                $ig->setProxy($proxy);
            }
            
            try {
                $loginResponse = $ig->login($username, $password);
                if (!is_null($loginResponse) && $loginResponse->isTwoFactorRequired()) {
                    if($verificationCode != ""){
                        $twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();
                        $this->twoFactorIdentifier = $twoFactorIdentifier;
                        $ig->finishTwoFactorLogin($username, $password, $twoFactorIdentifier, $verificationCode);
                    }else{
                        return ms(array(
                            "status"   => "error",
                            "callback" => '<script type="text/javascript">Instagram.TwoFactorLogin();</script>',
                            "message"  => lang("please_enter_verify_code_to_add_instagram_account")
                        ));                       
                    }
                }
            } catch (\Exception $e) {
                $this->checkpoint($e);
                throw new \InvalidArgumentException(Instagram_Get_Message($e->getMessage()));
            }   

            $this->ig = $ig;
        }
    }

    function checkpoint($e){
        $challenge_type = Instagram_Get_Message($e->getMessage());

        if($challenge_type == "challenge_required" 
            || $challenge_type == "login_required" 
            || $challenge_type == "checkpoint_required" 
            || strpos($challenge_type, "The password you entered is incorrect") !== false
            || strpos($challenge_type, "Challenge required") !== false){
            $CI = &get_instance();
            $CI->db->update(INSTAGRAM_ACCOUNTS, array("status" => 0), "username = '{$this->username}'");
            $CI->db->delete('instagram_sessions', "username = '{$this->username}'");
        }
    }

    function get_current_user(){
        try {
            $user = $this->ig->account->getCurrentUser();
            return json_decode($user);
        } catch (\Exception $e) {
            $this->checkpoint($e);
            ms(array(
                "status"  => "error",
                "message" => Instagram_Get_Message($e->getMessage())
            ));
        }   
    }

    function post($data){
        $spintax  = new Spintax();
        $data     = (object)$data;
        $response = array();
        try {
            $data->data = (object)json_decode($data->data);
            $media      = $data->data->media;
            $caption    = @$spintax->process(Instagram_Caption($data->data->caption));
            $comment    = @$spintax->process(Instagram_Caption($data->data->comment));

            switch ($data->type) {
                case 'photo':
                    if(check_image($media[0])){

                        //Auto Resize
                        $new_image_path = get_tmp_path(ids().".jpg");
                        Instagram_Resize(get_path_file($media[0]), $new_image_path , 0.8, 1.91);
                        $media[0] = $new_image_path;

                        $response = $this->ig->timeline->uploadPhoto(get_path_file($media[0]), array("caption" => $caption));
                        $response = json_decode($response);
                    }else{
                        $response = $this->ig->timeline->uploadVideo(get_path_file($media[0]), array("caption" => $caption));
                        $response = json_decode($response);
                    }
                    
                    //Add first comment
                    if($comment != ""){
                        $this->ig->media->comment($response->media->pk, $comment);
                    }
                    break;

                case 'story':
                    if(check_image($media[0])){

                        //Auto Resize
                        $new_image_path = get_tmp_path(ids().".jpg");
                        Instagram_Resize(get_path_file($media[0]), $new_image_path , 0.56, 0.67);
                        $media[0] = $new_image_path;

                        $response = $this->ig->story->uploadPhoto(get_path_file($media[0]), array("caption" => $caption));
                        $response = json_decode($response);
                    }else{
                        $response = $this->ig->story->uploadVideo(get_path_file($media[0]), array("caption" => $caption));
                        $response = json_decode($response);
                    }

                    //Add first comment
                    if($comment != ""){
                        $this->ig->media->comment($response->media->pk, $comment);
                    }
                    break;

                case 'carousel':
                    $medias = array();
                    foreach ($media as $item) {
                        $image_info = get_image_size($item);
                        if(!empty($image_info)){

                            //Auto Resize
                            $new_image_path = get_tmp_path(ids().".jpg");
                            Instagram_Resize(get_path_file($item), $new_image_path , 0.8, 1.91);
                            $media[0] = $new_image_path;

                            $medias[] = array(
                                'type' => 'photo',
                                'file' => get_path_file($item)
                            );
                        }else{
                            $file_info = get_file_info($item);
                            if(!empty($file_info) && isset($file_info['extension']) && isset($file_info['extension']) == "mp4"){
                                $medias[] = array(
                                    'type' => 'video',
                                    'file' => get_path_file($item)
                                );
                            }
                        }
                    }

                    $response = $this->ig->timeline->uploadAlbum($medias, array("caption" => $caption));
                    $response = json_decode($response);
                    //Add first comment
                    if($comment != ""){
                        $this->ig->media->comment($response->media->pk, $comment);
                    }
                    break;
            }

            return $response->media->pk;

        } catch (Exception $e) {
            $this->checkpoint($e);
            return array(
                "status"  => "error",
                "message" => Instagram_Get_Message($e->getMessage())
            );
        }
    }

    function search_media($keyword, $type){
        try {
            switch ($type) {
                case 'username':
                    $id = $this->ig->people->getUserIdForName($keyword);
                    $response = $this->ig->timeline->getUserFeed($id, $this->rankToken());
                    $response = json_decode($response);
                    return $response;
                    break;
                
                default:
                    $response = $this->ig->hashtag->getFeed($keyword, $this->rankToken());
                    $response = json_decode($response);
                    return $response;
                    break;
            }
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function search_tag($keyword){
        try {
            $response = $this->ig->hashtag->search($keyword, array(), $this->rankToken());
            $response = json_decode($response);
            if(isset($response->results) && !empty($response->results)){
                return $response->results;
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function search_username($keyword){
        try {
            $response = $this->ig->people->search($keyword, array(), $this->rankToken());
            $response = json_decode($response);
            if(isset($response->users) && !empty($response->users)){
                return $response->users;
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function search_location($keyword){
        try {
            $response = $this->ig->location->findPlaces($keyword, array(), $this->rankToken());
            $response = json_decode($response);
            if(isset($response->items) && !empty($response->items)){
                return $response->items;
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_followers($getAll = false, $userId = null, $maxId = null, $maxCount = 1000){
        if($userId == "") $userId = $this->ig->account_id;
        try {
            if($getAll){
                $users = array();
                do {
                    $response = $this->ig->people->getFollowers($userId, $this->rankToken(), array(), $maxId);
                    $response = json_decode($response);
                    $users = array_merge($users, $response->users);
                } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($users));

                return $users;
            }else{
                $response = $this->ig->people->getFollowers($this->rankToken(), array(), $maxId);
                $response = json_decode($response);
                if(isset($response->users) && !empty($response->users)){
                    return $response->users;
                }
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_following($getAll = false, $userId = null, $maxId = null, $maxCount = 1000){
        if($userId == "") $userId = $this->ig->account_id;
        try {
            if($getAll){
                $users = array();
                do {
                    $response = $this->ig->people->getFollowing($userId, $this->rankToken(), array(), $maxId);
                    $response = json_decode($response);
                    $users = array_merge($users, $response->users);
                } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($users));
                return $users;
            }else{
                $response = $this->ig->people->getFollowing($userId, $this->rankToken(), array(), $maxId);
                $response = json_decode($response);
                if(isset($response->users) && !empty($response->users)){
                    return $response->users;
                }
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_feed($userId = null, $maxId = null, $full = false, $maxCount = 80){
        if($userId == "") $userId = $this->ig->account_id;
        try {

            if($full){
            
                $response = $this->ig->timeline->getUserFeed($userId, $maxId);
                $response = json_decode($response);
                return $response;
            
            }else{

                $feed = array();
                do {
                    $response = $this->ig->timeline->getUserFeed($userId, $maxId);
                    $response = json_decode($response);
                    $feed = array_merge($feed, $response->items);
                } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($feed));
                return $feed;
            }

            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_feed_by_tag($tag, $maxId = null, $maxCount = 50){
        try {
            $items = array();
            do {
                $response = $this->ig->hashtag->getFeed($tag, $this->rankToken(), $maxId);
                $response = json_decode($response);
                
                if(isset($response->ranked_items)){
                    $items = array_merge($items, $response->ranked_items);
                }else if(isset($response->items)){
                    $items = array_merge($items, $response->items);
                }

            } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($items));

            return $items;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_feed_by_location($tag, $maxId = null, $maxCount = 30){
        try {
            $items = array();
            do {
                $response = $this->ig->location->getFeed($tag, $this->rankToken(), $maxId);
                $response = json_decode($response);
                if(isset($response->ranked_items)){
                    $items = array_merge($items, $response->ranked_items);
                }else if(isset($response->items)){
                    $items = array_merge($items, $response->items);
                }

            } while (isset($response->next_max_id) && !is_null($maxId = $response->next_max_id) && $maxCount > count($items));
            return $items;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_comments($mediaId, $maxId = null, $expect_me = true, $maxCount = 80){
        try {
            $comments = array();
            do {
                $response = $this->ig->media->getComments($mediaId, array("maxId" => $maxId));
                $response = json_decode($response);

                if(isset($response->comments) && !empty($response->comments)){
                    $comments = array_merge($comments, $response->comments);
                }
            } while (isset($response->next_min_id) && !is_null($maxId = $response->next_min_id) && $maxCount > count($comments));

            if(!empty($comments)){
                if($expect_me){
                    $comments_tmp = array();

                    foreach ($comments as $value) {
                        if($value->user_id != $this->ig->account_id){
                            $comments_tmp[] = $value;
                        }
                    }

                    return $comments_tmp;
                }else{
                    return $comments;
                }
            }else{
                return false;
            }
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_likers($mediaId, $expect_me = true){
        try {
            $response = $this->ig->media->getLikers($mediaId);
            $response = json_decode($response);
            if(isset($response->users) && !empty($response->users)){
                $users = $response->users;
                if($expect_me){

                    $users_tmp = array();

                    foreach ($users as $value) {
                        if($value->pk != $this->ig->account_id){
                            $users_tmp[] = $value;
                        }
                    }

                    return $users_tmp;

                }else{
                    return $users;
                }

                
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_userinfo($userId = null){
        if($userId == "") $userId = $this->ig->account_id;
        try {
            $response = $this->ig->people->getInfoById($userId);
            $response = json_decode($response);
            if(isset($response->user) && !empty($response->user)){
                return $response->user;
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_friendships($userIds){
        try {
            $response = $this->ig->people->getFriendships($userIds);
            $response = json_decode($response);
            if(isset($response->friendship_statuses) && !empty($response->friendship_statuses)){
                return $response->friendship_statuses;
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function get_friendship($userId){
        try {
            $response = $this->ig->people->getFriendship($userId);
            $response = json_decode($response);
            if(isset($response->status) && $response->status == "ok"){
                return $response;
            }
            return false;
        } catch (Exception $e) {
            $this->checkpoint($e);
            return false;
        }
    }

    function comment($mediaId, $comment){
        try {
            $spintax  = new Spintax();
            $comment = (object)$comment;
            if(is_object($comment)){
                if(isset($comment->dont_spam)){
                    unset($comment->dont_spam);
                }

                $comment = array_values((array)$comment);
                $comment = get_random_value($comment);
            }

            $comment = @$spintax->process($comment);
            $response = $this->ig->media->comment($mediaId, $comment);
            $response = json_decode($response);
            return $response;
        } catch (Exception $e) {
            $response = json_decode($e->getResponse());
            $this->checkpoint($e);
            return $response;
        }
    }

    function like($mediaId){
        try {
            $response = $this->ig->media->like($mediaId);
            $response = json_decode($response);
            return $response;
        } catch (Exception $e) {
            $response = json_decode($e->getResponse());
            $this->checkpoint($e);
            return $response;
        }
    }

    function follow($userId){
        try {
            $response = $this->ig->people->follow($userId);
            $response = json_decode($response);
            return $response;
        } catch (Exception $e) {
            $response = json_decode($e->getResponse());
            $this->checkpoint($e);
            return $response;
        }
    }


    function unfollow($userId){
        try {
            $response = $this->ig->people->unfollow($userId);
            $response = json_decode($response);
            return $response;
        } catch (Exception $e) {
            $response = json_decode($e->getResponse());
            $this->checkpoint($e);
            return $response;
        }
    }

    function delete_media($mediaId){
        try {
            $response = $this->ig->media->delete($mediaId);
            $response = json_decode($response);
            return $response;
        } catch (Exception $e) {
            $response = json_decode($e->getResponse());
            $this->checkpoint($e);
            return $response;
        }
    }

    function direct_message($userId, $message = null, $type = null, $file = null, $mediaId = null){
        try {
            $temp_userid = $userId;
            if(is_string($userId)){
                $userId = array('users' => array($userId));
            }

            $message = (array)$message;
            $spintax  = new Spintax();
            if(is_array($message)){
                $message = get_random_value($message);
            }

            $message = @$spintax->process($message);

            if(strpos($message, "@username") !== false){
                $userinfo = $this->ig->people->getInfoById($temp_userid);
                $userinfo = json_decode($userinfo);
                if($userinfo->status = "ok"){
                    $message = str_replace("@username", "@".$userinfo->user->username, $message);
                }
            }

            switch ($type) {
                case 'post':
                    $response = $this->ig->direct->sendPost($userId, $mediaId);
                    break;

                case 'photo':
                    $response = $this->ig->direct->sendPhoto($userId, $file);
                    break;
                
                default:
                    $response = $this->ig->direct->sendText($userId, $message);
                    break;
            }
            
            $response = json_decode($response);
            return $response;
        } catch (Exception $e) {
            $response = json_decode($e->getResponse());
            $this->checkpoint($e);
            return $response;
        }
    }

    function get_random_feed($userId = null, $filter = ""){
        $feeds = $this->get_feed($userId);
               
        if(!empty($feeds)){
            if($filter != ""){
                $feeds_tmp = array();
                foreach ($feeds as $key => $feed) {
                    if(isset($feed->$filter) && $feed->$filter != 0){
                        $feeds_tmp[] = $feed;
                    }
                }

                $feeds = $feeds_tmp;
                return get_random_value($feeds);
            }

            return get_random_value($feeds);
        }

        return false;
    }

    function rankToken(){
        $rankToken = \InstagramAPI\Signatures::generateUUID();
        return  $rankToken;
    }
}
<?php
require "linkedin-api/autoload.php";
use LinkedIn\Client;

class linkedinapi{
    private $ClientID;
    private $ClientSecret;
    private $client;
    private $access_token;

    public function __construct($client_id = null, $client_secret = null){
        $this->ClientID = $client_id;
        $this->ClientSecret = $client_secret;
        $this->client = new Client($client_id, $client_secret);
    }

    function login_url(){
        $this->client->setRedirectUrl(cn("linkedin/add_account"));
        return $loginUrl = $this->client->getLoginUrl(array('r_basicprofile', 'r_emailaddress', 'rw_company_admin', 'w_share'));
    }

    function get_access_token(){
        try {
            if(get("code")){
                $this->client->setRedirectUrl(cn("linkedin/add_account"));
                $token = $this->client->getAccessToken(get("code"));
                $this->access_token = $token;
                return $token->getToken();
            }else{
                redirect(cn("linkedin/oauth"));
            }
            
        } catch (Exception $e) {
            redirect(cn("linkedin/oauth"));
        }
    }

    function set_access_token($access_token){
        $this->access_token = $access_token;
        $this->client->setAccessToken($this->access_token);
    }

    function get_user_info(){
        try {
            $profile = $this->client->get(
                'people/~:(id,email-address,first-name,last-name,picture-url,public-profile-url)'
            );

            return $profile;
        } catch (Exception $e) {
            return false;
        }
    }

    function get_company(){
        try {
            $profile = $this->client->get(
                'companies',
                ['is-company-admin' => 'true']
            );
            return $profile;
        } catch (Exception $e) {
            return false;
        }
    }

    function get_post(){
        try {
            $this->client->setAccessToken($this->access_token);
            $profile = $this->client->get(
                'people/~:(id,email-address,first-name,last-name,picture-url,public-profile-url)'
            );

            return $profile;
        } catch (Exception $e) {
            return false;
        }
    }

    function get_title($url){
        $result = get_curl($url);
        $doc = new DOMDocument();
        @$doc->loadHTML(mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'));
        $title = $doc->getElementsByTagName('title');
        return isset($title->item(0)->nodeValue) ? $title->item(0)->nodeValue : "&nbsp;";
    }

    function post($data, $account = array()){
        $data     = (object)$data;
        $response = array();
        $data->data = (object)json_decode($data->data);
        
        try {
            if(isset($data->pid)){
                $method = ($data->account_type == "page")?"companies/".$data->pid:"people/~";
            }else{
                $method = ($account->type == "page")?"companies/".$account->pid:"people/~";
            }
            
            $media      = $data->data->media;
            $caption    = $data->data->caption;
            $url        = $data->data->url;

            $content    = array(
                'submitted-image-url' => $media[0]
            );

            if($data->type == "photo"){
                $content['title'] = '&nbsp;';
                $content['submitted-url'] = $media[0];
            }else{
                $content['title'] = $this->get_title($url);
               $content['submitted-url'] = $url;
            }

            $response = (object)$this->client->post(
                $method.'/shares',
                [
                    'comment' => $caption,
                    'content' => $content,
                    'visibility' => [
                        'code' => 'anyone'
                    ]
                ]
            );

            $parts = parse_url($response->updateUrl);
            parse_str($parts['query'], $query);
            return $query['topic'];
        } catch (Exception $e) {
            return array(
                "status"  => "error",
                "message" => $e->getDescription()
            );
        }
    }
}

?>


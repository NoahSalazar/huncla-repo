<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."../public/instagram/libraries/instagram_checkpoint.php");
class instagram extends MX_Controller {
	public $table;
	public $module;
	public $module_name;
	public $module_icon;

	public function __construct(){ 
		parent::__construct();
		
		$this->table = INSTAGRAM_ACCOUNTS;
		$this->module = get_class($this);
		$this->module_name = lang("instagram_accounts");
		$this->module_icon = "fa fa-instagram";
		$this->load->model($this->module.'_model', 'model');
	}

	public function block_general_settings(){
		$data = array();
		$this->load->view('account/general_settings', $data);
	}

	public function block_list_account(){
		$data = array(
			'module'       => $this->module,
			'module_name'  => $this->module_name,
			'module_icon'  => $this->module_icon,
			'list_account' => $this->model->fetch("id, username, avatar, ids, status", $this->table, "uid = '".session("uid")."'")
		);
		$this->load->view("account/index", $data);
	}
	
	public function popup_add_account(){
		$ids = segment(3);
		$result = $this->model->get("*", $this->table, "ids = '".$ids."' AND uid = '".session("uid")."'");

		$data = array(
			'module'       => $this->module,
			'module_name'  => $this->module_name,
			'module_icon'  => $this->module_icon,
			'result'       => $result
		);
		$this->load->view('account/popup_add_account', $data);
	}

	public function ajax_add_account(){
		$username = post("username");
		$password = post("password");
		$proxy    = post("proxy");
		$code     = post("code");
		$security_code     = post("security_code");
		$password_encode = encrypt_encode($password);

		if(empty($username) || empty($password)){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_username_and_password")
			));
		}

		if(!permission("instagram_enable")){
			ms(array(
				"status" => "error",
				"message" => lang("disable_feature")
			));
		}

		$this->pass_checkpoint($username, $password, $security_code, $proxy);

		$instagram_account = $this->model->get("id, default_proxy", $this->table, "username = '".$username."' AND uid = '".session("uid")."'");
		$proxy_data = get_proxy($this->table, $proxy, $instagram_account);
		try {
			$ig = new InstagramAPI($username, $password_encode, $proxy_data->use, $code);
			$user = $ig->get_current_user();
		} catch (Exception $e) {
			set_session("tmp_".$username."_count", (int)session("tmp_".$username."_count") + 1);

			if (strpos($e->getMessage(), "required") !== false) {
				if(session("tmp_".$username."_count") > 3){
					unset_session("tmp_".$username."_count");
					ms(array(
						"status" => "error",
						"message" => lang('it_looks_like_your_ip_server_has_been_banned_by_instagram_please_use_proxies_to_add_instagram_account')
					));
				}else{
					$this->pass_checkpoint($username, $password, $security_code, $proxy);
				}
			}

			ms(array(
				"status" => "error",
				"message" => $e->getMessage()
			));
		}
		
		if(!empty($user)){
			$user = $user->user;
			
			$data = array(
				"uid"      => session("uid"),
				"pid"      => $user->pk,
				"avatar"   => "https://avatars.io/instagram/".$user->username,
				"username" => $user->username,
				"password" => $password_encode,
				"proxy"    => (get_option('user_proxy', 1) == 1)?$proxy:"",
				"default_proxy" => $proxy_data->system,
				"status"   => 1,
				"changed"  => NOW,
			);

			if(empty($instagram_account)){

				if(!check_number_account($this->table)){
					ms(array(
						"status" => "error",
						"message" => lang("limit_social_accounts")
					));
				}

				$data['ids'] = ids();
				$data['created'] = NOW;
				$this->db->insert($this->table, $data);
			}else{
				$this->db->update($this->table, $data, "id = '".$instagram_account->id."'");			
			}

			ms(array(
				"status"  => "success",
				"message" => lang("successfully")
			));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("login_failed_please_try_again")
			));
		}
	}

	public function pass_checkpoint($username, $password, $security_code, $proxy){
		if(get_option('instagram_verify_code_enable', 1)==1){
			//PASS CHECKPOINT
			$checkpoint = new Instagram_Checkpoint($username, $password, $security_code, $proxy);

			try {
				$login_repsonse = $checkpoint->login();
				preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $login_repsonse[0], $matches);
				$cookies = array();
				foreach($matches[1] as $item) {
				    parse_str($item, $cookie);
				    $cookies = array_merge($cookies, $cookie);
				}
				
				if(!empty($cookies)){
					$this->create_cookies($username, $cookies);
				}
			} catch (Exception $e) {
				ms(array(
					"status" => "error",
					"message" => $e->getMessage(),
					"callback" => !strpos($e->getMessage(), "https://instagram.com")?'<script type="text/javascript">Instagram.ChallengeRequired();</script>':''
				));
			}
			//END PASS CHECKPOINT
		}
	}

	public function create_cookies($username, $cookies){
		$cookies_tmp = array();
		if(!empty($cookies)){
			$time = strtotime(NOW)+1000*3600;

			if(isset($cookies['rur'])){
				$cookies_tmp[] = array (
				    'Name' => 'rur',
				    'Value' => $cookies['rur'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => NULL,
				    'Expires' => NULL,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			} 

			if(isset($cookies['ds_user'])){
				$cookies_tmp[] = array (
				    'Name' => 'ds_user',
				    'Value' => $cookies['ds_user'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => NULL,
				    'Expires' => NULL,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			} 

			if(isset($cookies['sessionid'])){
				$cookies_tmp[] = array (
				    'Name' => 'sessionid',
				    'Value' => $cookies['sessionid'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => '7776000',
				    'Expires' => strtotime(NOW) + 30*86400,
				    'Secure' => true,
				    'Discard' => false,
				    'HttpOnly' => true,
				);
			} 

			if(isset($cookies['mid'])){
				$cookies_tmp[] = array (
				    'Name' => 'mid',
				    'Value' => $cookies['mid'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => '630720000',
				    'Expires' => -2132953184,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			} 

			if(isset($cookies['csrftoken'])){
				$cookies_tmp[] = array (
				    'Name' => 'csrftoken',
				    'Value' => $cookies['csrftoken'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => '31449600',
				    'Expires' => strtotime(NOW) + 365*86400,
				    'Secure' => true,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			} 

			if(isset($cookies['ds_user_id'])){
				$cookies_tmp[] = array (
				    'Name' => 'ds_user_id',
				    'Value' => $cookies['ds_user_id'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => '7776000',
				    'Expires' => strtotime(NOW) + 365*86400,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			} 

			if(isset($cookies['shbid'])){
				$cookies_tmp[] = array (
				    'Name' => 'shbid',
				    'Value' => $cookies['shbid'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => '7776000',
				    'Expires' => strtotime(NOW) + 365*86400,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			} 

			if(isset($cookies['shbts'])){
				$cookies_tmp[] = array (
				    'Name' => 'shbts',
				    'Value' => $cookies['shbts'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => '7776000',
				    'Expires' => strtotime(NOW) + 365*86400,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			}

			if(isset($cookies['mcd'])){
				$cookies_tmp[] = array (
				    'Name' => 'mcd',
				    'Value' => $cookies['mcd'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => NULL,
				    'Expires' => NULL,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			}

			if(isset($cookies['urlgen'])){
				$cookies_tmp[] = array (
				    'Name' => 'urlgen',
				    'Value' => $cookies['urlgen'],
				    'Domain' => '.instagram.com',
				    'Path' => '/',
				    'Max-Age' => NULL,
				    'Expires' => NULL,
				    'Secure' => false,
				    'Discard' => false,
				    'HttpOnly' => false,
				);
			}

			$settings = array(
				'devicestring' => '23/6.0.1; 640dpi; 1440x2560; samsung; SM-G935F; hero2lte; samsungexynos8890',
				'device_id' => session("ig_".$username."_device_id"),
				'phone_id' =>session("ig_".$username."_phone_id"),
				'uuid' => session("ig_".$username."_uuid"),
				'advertising_id' => SignatureUtils::generateUUID(true),
				'session_id' => SignatureUtils::generateUUID(true),
				'experiments' => '',
				'fbns_auth' => '',
				'fbns_token' => '',
				'last_fbns_token' => '',
				'last_login' => strtotime(NOW),
				'last_experiments' => strtotime(NOW),
				'datacenter' => '',
				'presence_disabled' => '',
				'zr_token' => '',
				'zr_expires' => strtotime(NOW) + 30*86400,
				'zr_rules' => 'J[]',
				'account_id' => (isset($cookies['ds_user_id']))?$cookies['ds_user_id']:"",
			);
			
			$this->db->delete("instagram_sessions", "username = '{$username}'");
			$this->db->insert("instagram_sessions", array(
				"username" => $username,
				"settings" => json_encode($settings),
				"cookies" => json_encode($cookies_tmp),
				"last_modified" => NOW
			));
		}
	}

	public function ajax_delete_item(){
		$item = $this->model->get("username", $this->table, "ids = '".post("id")."'");
		if(!empty($item)){
			$this->db->delete('instagram_sessions', "username = '{$item->username}'");
		}
		$this->model->delete($this->table, post("id"), false);

	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class facebook extends MX_Controller {
	public $table;
	public $module;
	public $module_name;
	public $module_icon;

	public function __construct()
	{
		parent::__construct();

		$this->table = FACEBOOK_ACCOUNTS;
		$this->module = get_class($this);
		$this->module_name = lang("facebook_accounts");
		$this->module_icon = "fa fa-facebook-square";
		$this->load->model($this->module.'_model', 'model');
	}

	public function block_list_account(){
		$data = array(
			'module'       => $this->module,
			'module_name'  => $this->module_name,
			'module_icon'  => $this->module_icon,
			'list_account' => $this->model->fetch("id, fullname, avatar, ids, status, pid", $this->table, "uid = '".session("uid")."'")
		);

		$this->load->view("account/index", $data);
	}
	
	public function popup_add_account()
	{
		$this->load->library('user_agent');

		$data = array(
			"user_agent" => $this->agent->browser()
		);
		$this->load->view('account/popup_add_account', $data);
	}

	public function ajax_add_account()
	{
		$ids = ids();
		$access_token = $this->input->post("access_token");

		if($access_token == ""){
			ms(array(
	        	"status"  => "error",
	        	"message" => lang('access_token_is_required')
	        ));
		}

		$generate_access_token = json_decode($access_token);

		if(is_object($generate_access_token)){
			if(isset($generate_access_token->access_token)){

				$access_token = $generate_access_token->access_token;

			}else if(isset($generate_access_token->error_msg)){

				ms(array(
		        	"status"  => "error",
		        	"message" => $generate_access_token->error_msg
		        ));

			}else{

				ms(array(
		        	"status"  => "error",
		        	"message" => lang('can_not_generate_token_please_try_again')
		        ));

			}
		}

		if (strrpos($access_token, "#") == true && strrpos($access_token, "&")) {
			$link_token = explode("#", $access_token);
			if(count($link_token) == 2){
				parse_str($link_token[1], $param_token);
				if(is_array($param_token) && isset($param_token['access_token'])){
					$access_token = $param_token['access_token'];
				}
			}
		}

		$fb   = new FacebookAPI();
		$fb->set_access_token($access_token);
		$fbapp = $fb->get_app_info();
		$user = $fb->get_current_user();

		if(is_string($user)){
			ms(array(
	        	"status"  => "error",
	        	"message" => $user
	        ));
		}

		$data = array(
			"ids" => $ids,
			"uid" => session("uid"),
			"pid" => $user->id,
			"fbapp" => $fbapp->name,
			"fullname" => $user->name,
			"avatar" => "https://graph.facebook.com/{$user->id}/picture",
			"access_token" => $access_token,
			"status" => 1,
			"changed" => NOW
		);

		if(!permission("facebook_enable")){
			ms(array(
				"status" => "error",
				"message" => lang("disable_feature")
			));
		}

		$fb_account = $this->model->get("id", $this->table, "pid = '".$user->id."' AND uid = '".session("uid")."'");
		if(empty($fb_account)){
			$data['created'] = NOW;

			if(!check_number_account($this->table)){
				ms(array(
					"status" => "error",
					"message" => lang("limit_social_accounts")
				));
			}

			$this->db->insert($this->table, $data);
		}else{
			$this->db->update($this->table, $data, "id = '".$fb_account->id."'");			
		}

		$this->ajax_import_group($ids, "group");

		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function ajax_get_accounts()
	{
		$fb_accounts = $this->model->fetch("*", FACEBOOK_ACCOUNTS, "uid = '".session("uid")."' AND status = 1");
		$this->load->view("account/ajax_get_accounts", array("accounts" => $fb_accounts));
	}

	public function ajax_get_groups($type = ""){
		$ids = post("id");
		$fb_account = $this->model->get("*", FACEBOOK_ACCOUNTS, "ids = '{$ids}' AND uid = '".session("uid")."'");

		if(empty($fb_account)){
			ms(array(
	        	"status"  => "error",
	        	"message" => lang('the_facebook_account_not_exist')
	        ));
		}

		$result = $this->model->fetch("*", FACEBOOK_GROUPS, "account = '{$fb_account->id}' AND type = '".addslashes($type)."' AND uid = '".session("uid")."'");
				
		$this->load->view("account/ajax_get_groups", array("result" => $result));
	}

	public function ajax_import_group($fb_ids, $type)
	{
		$account = $this->model->get("id, access_token", FACEBOOK_ACCOUNTS, "ids = '".$fb_ids."' AND uid = '".session("uid")."' AND status = 1");

		if(!empty($account))
		{
			$fb   = new FacebookAPI();
			$fb->set_access_token($account->access_token);
			$groups = $fb->get_groups("group");
			$pages = $fb->get_groups("page");
			$friends = $fb->get_groups("friend");

			$this->db->delete(FACEBOOK_GROUPS, array("account" => $account->id, "uid" => session("uid")));
			if(!empty($groups) && isset($groups->data))
			{
				if(!empty($groups))
				{
					$query  = "INSERT INTO ".FACEBOOK_GROUPS." (ids, uid, account, type, category, pid, name) VALUES ";
					$result = array();
					$count  = 0;
					foreach ($groups->data as $key => $group)
					{
						$count++;
						$query .= " ('".ids()."', '".session("uid")."', '".row($account, "id")."', 'group', '".row($group, "privacy")."', '".row($group, "id")."', '".addslashes(row($group, "name"))."'),";
					}

					if($count != 0)
					{
						$query  = substr($query,0,-1);
						$result = $this->db->query($query);
					}
				}
			}

			if(!empty($pages) && isset($pages->data))
			{
				if(!empty($pages))
				{
					$query  = "INSERT INTO ".FACEBOOK_GROUPS." (ids, uid, account, type, category, pid, name) VALUES ";
					$result = array();
					$count  = 0;
					foreach ($pages->data as $key => $page)
					{	
						$count++;
						$query .= " ('".ids()."', '".session("uid")."', '".row($account, "id")."', 'page', '".addslashes(row($page, "category"))."', '".row($page, "id")."', '".addslashes(row($page, "name"))."'),";
					}

					if($count != 0)
					{
						$query  = substr($query,0,-1);
						$result = $this->db->query($query);
					}
				}
			}

			if(!empty($friends) && isset($friends->data))
			{
				if(!empty($friends))
				{
					$query  = "INSERT INTO ".FACEBOOK_GROUPS." (ids, uid, account, type, category, pid, name) VALUES ";
					$result = array();
					$count  = 0;
					foreach ($friends->data as $key => $friend)
					{	
						$count++;
						$query .= " ('".ids()."', '".session("uid")."', '".row($account, "id")."', 'friend', '".row($friend, "gender")."', '".row($friend, "id")."', '".addslashes(row($friend, "name"))."'),";
					}

					if($count != 0)
					{
						$query  = substr($query,0,-1);
						$result = $this->db->query($query);
					}
				}
			}
		}
	}

	public function ajax_get_access_token()
	{
		$username = post("username");
		$password = post("password");
		$proxy    = post("proxy");
		$app      = post("app");

		if($username == ""){
			ms(array(
	        	"status"  => "error",
	        	"message" => lang('facebook_username_is_required')
	        ));
		}

		if($password == ""){
	        ms(array(
	        	"status"  => "error",
	        	"message" => lang('facebook_password_is_required')
	        ));
	    }

	    if(!$app){
	        ms(array(
	        	"status"  => "error",
	        	"message" => lang('facebook_application_is_required')
	        ));
	    }

	    $fb = new FacebookAPI();

	    //Get Link Create Token
		$page = $fb->get_page_access_token($username, encrypt_encode($password), $app);

		ms(array(
        	"status"   => "success",
        	"callback" => '<script>$(".iframe_access_token").html("<iframe src=\''.$page.'\'></iframe>");</script>'
        ));
	}

	public function ajax_delete_item(){
		$this->model->delete($this->table, post("id"), false);
	}
}
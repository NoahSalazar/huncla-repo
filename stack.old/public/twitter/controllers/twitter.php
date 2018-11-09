<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class twitter extends MX_Controller {
	public $table;
	public $module;
	public $module_name;
	public $module_icon;

	public function __construct(){ 
		parent::__construct();
		
		$this->table = TWITTER_ACCOUNTS;
		$this->module = get_class($this);
		$this->module_name = lang("twitter_accounts");
		$this->module_icon = "fa fa-twitter";
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
			'list_account' => $this->model->fetch("id, ids, username, avatar, status, pid", $this->table, "uid = '".session("uid")."'")
		);
		$this->load->view("account/index", $data);
	}
	
	public function oauth(){
		$tw = new TwitterAPI(CONSUMER_KEY, CONSUMER_SECRET, TRUE);
		redirect($tw->login_url());
	}

	public function add_account(){
		if(get("denied")){
			redirect(cn("account_manager"));
		}

		$tw = new TwitterAPI(CONSUMER_KEY, CONSUMER_SECRET);
		$access_token = (object)$tw->get_access_token();

		$data = array(
			"uid"          => session("uid"),
			"ids"          => ids(),
			"pid"          => $access_token->user_id,
			"username"     => $access_token->screen_name,
			"avatar"       => "https://avatars.io/twitter/{$access_token->screen_name}",
			"access_token" => json_encode($access_token),
			"status"       => 1,
			"changed"      => NOW
		);

		if(!permission("instagram_enable")){
			redirect(cn("account_manager"));
		}

		$account = $this->model->get("*", $this->table, "pid = '".$access_token->user_id."' AND uid = '".session("uid")."'");
		if(empty($account)){
			if(!check_number_account($this->table)){
				redirect(cn("account_manager"));
			}

			$data["created"] = NOW;
			$this->db->insert($this->table, $data);
		}else{
			$this->db->update($this->table, $data, array("id" => $account->id));
		}

		redirect(cn("account_manager"));
	}

	public function ajax_delete_item(){
		$this->model->delete($this->table, post("id"), false);
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class linkedin extends MX_Controller {
	public $table;
	public $module;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		
		$this->table = LINKEDIN_ACCOUNTS;
		$this->module = get_class($this);
		$this->module_name = lang("linkedin_accounts");
		$this->module_icon = "fa fa-linkedin";
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
			'list_account' => $this->model->fetch("id, ids, pid, username, avatar, status, type, url", $this->table, "uid = '".session("uid")."'")
		);
		$this->load->view("account/index", $data);
	}
	
	public function oauth(){
		$li = new LinkedinAPI(LINKEDIN_CLIENT_ID, LINKEDIN_CLIENT_SERECT);
		redirect($li->login_url());
	}

	public function add_account(){
		$li = new LinkedinAPI(LINKEDIN_CLIENT_ID, LINKEDIN_CLIENT_SERECT);
		$access_token = $li->get_access_token();
		$li->set_access_token($access_token);
		$userinfo     = (object)$li->get_user_info();
		$companies    = (object)$li->get_company();
		set_session("linkedin_access_token", $access_token);

		$data = array(
			"userinfo" => $userinfo,
			"companies" => $companies
		);

		$this->load->view("account/add_account", $data);
	}

	public function ajax_add_account(){
		$accounts = $this->input->post("accounts");
		$access_token = session("linkedin_access_token");

		if(empty($accounts)){
			ms(array(
	        	"status"  => "error",
	        	"message" => lang('please_select_at_least_one_item')
	        ));
		}

		if($access_token){
			$li = new LinkedinAPI(LINKEDIN_CLIENT_ID, LINKEDIN_CLIENT_SERECT);
			$li->set_access_token($access_token);
			$userinfo     = (object)$li->get_user_info();
			$companies    = (object)$li->get_company();

			$data = array(
				"userinfo" => $userinfo,
				"companies" => $companies
			);

			foreach ($accounts as $account) {
				if(!check_number_account($this->table)){
					ms(array(
						"status" => "error",
						"message" => lang("limit_social_accounts")
					));
				}

				$data = array();
				if($account == $userinfo->id){
					$data = array(
						"uid"          => session("uid"),
						"ids"          => ids(),
						"pid"          => $userinfo->id,
						"type"     	   => "profile",
						"username"     => $userinfo->firstName." ".$userinfo->lastName,
						"avatar"       => $userinfo->pictureUrl,
						"url"          => $userinfo->publicProfileUrl,
						"access_token" => $access_token,
						"status"       => 1
					);

					$account = $this->model->get("*", $this->table, "pid = '".$userinfo->id."' AND uid = '".session("uid")."'");
					if(empty($account)){
						$data["created"] = NOW;
						$this->db->insert($this->table, $data);
					}else{
						$this->db->update($this->table, $data, array("id" => $account->id));
					}
				}else{
					if(!empty($companies) && $companies->_total != 0){
						foreach ($companies->values as $company) {
							if($company['id'] == $account){
								$data = array(
									"uid"          => session("uid"),
									"ids"          => ids(),
									"pid"          => $company['id'],
									"type"     	   => "page",
									"username"     => $company['name'],
									"avatar"       => $userinfo->pictureUrl,
									"url"          => "https://www.linkedin.com/company/".$company['id'],
									"access_token" => $access_token,
									"status"       => 1
								);

								$account = $this->model->get("*", $this->table, "pid = '".$company['id']."' AND uid = '".session("uid")."'");
								if(empty($account)){
									$data["created"] = NOW;
									$this->db->insert($this->table, $data);
								}else{
									$this->db->update($this->table, $data, array("id" => $account->id));
								}
							}
						}
					}
				}
			}

			ms(array(
				"status" => "success",
				"message" => lang('add_account_successfully')
			));
		}else{
			ms(array(
	        	"status"  => "error",
	        	"message" => lang('an_error_occurred_during_processing_please_try_again')
	        ));
		}
	}

	public function ajax_delete_item(){
		$this->model->delete($this->table, post("id"), false);
	}
}
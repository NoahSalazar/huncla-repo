<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class users extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = USERS;
		$this->module_name = lang("user_manager");
		$this->module_icon = "fa ft-users";
		$this->columns = array(
			"email"            => lang("email"),
			"fullname"         => lang("fullname"),
			"package"          => lang("package"),
			"expiration_date"  => lang("expiration_date"),
			"login_type"       => lang("login_type"),
			"history_ip"       => lang("history_ip"),
			"status"           => lang("status"),
			"changed"          => lang("changed"),
			"created"          => lang("created")
		);
	}

	public function index(){
		$page        = (int)get("p");
		$limit       = 50;
		$result      = $this->model->getList($this->table, $this->columns, $limit, $page);
		$total       = $this->model->getList($this->table, $this->columns, -1, -1);
		$total_final = $total;

		$query = array();
		$query_string = "";
		if(get("c")) $query["c"] = get("c");
		if(get("t")) $query["t"] = get("t");
		if(get("k")) $query["k"] = get("k");

		if(!empty($query)){
			$query_string = "?".http_build_query($query);
		}

		$configs = array(
			"base_url"   => cn(get_class($this).$query_string), 
			"total_rows" => $total_final, 
			"per_page"   => $limit
		);

		$this->pagination->initialize($configs);

		$data = array(
			"columns" => $this->columns,
			"result"  => $result,
			"total"   => $total_final,
			"page"    => $page,
			"limit"   => $limit,
			"module"  => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);

		$this->template->build('index', $data);
	}

	public function update(){
		$data = array(
			"packages"    => $this->model->fetch("name, id, ids", PACKAGES),
			"result"      => $this->model->get("*", $this->table, "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids      = post("ids");
		$fullname = post("fullname");
		$email    = post("email");
		$password = post("password");
		$package_ids  = post("package");
		$confirm_password = post("confirm_password");
		$expiration_date  = post("expiration_date");
		$timezone  = post("timezone");

		if($fullname == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_fullname")
			));
		}

		if($email == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_email")
			));
		}

		if(!filter_var(post("email"), FILTER_VALIDATE_EMAIL)){
		  	ms(array(
				"status"  => "error",
				"message" => lang("email_address_in_invalid_format")
			));
		}

		if($package_ids == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("please_select_a_package")
			));
		}

		if($expiration_date == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_expiration_date")
			));
		}

		$package = $this->model->get('*', PACKAGES, "ids = '$package_ids'");

		if(empty($package)){
			ms(array(
				"status"  => "error",
				"message" => lang('package_does_not_exist')
			));
		}

		$check_timezone = 0;
		foreach (tz_list() as $key => $value) {
			if($timezone == $value['zone']){
				$check_timezone = 1;
			}
		}

		if(!$check_timezone){
			ms(array(
				"status"  => "error",
				"message" => lang('timezone_is_required')
			));
		}

		//
		$data = array(
			"fullname"        => $fullname,
			"email"           => $email,
			"package"         => $package->id,
			"permission"      => $package->permission,
			"timezone"        => $timezone,
			"expiration_date" => date("Y-m-d", strtotime($expiration_date)),
			"status"          => 1,
			"changed"         => NOW
		);

		$user = $this->model->get("*", $this->table, "ids = '{$ids}'");
		if(empty($user)){
			if($password == ""){
				ms(array(
					"status"  => "error",
					"message" => lang("please_enter_password")
				));
			}

			if(strlen($password) <= 5){
				ms(array(
					"status"  => "error",
					"message" => lang("password_must_be_greater_than_5_characters")
				));
			}

			if($password != $confirm_password){
				ms(array(
					"status"  => "error",
					"message" => lang("password_does_not_match_the_confirm_password")
				));
			}

			//
			$user_check = $this->model->get("id", $this->table, "email = '{$email}'");
			if(!empty($user_check)){
				ms(array(
					"status"  => "error",
					"message" => lang("this_email_already_exists")
				));
			}

			$data["ids"]        = ids();
			$data["login_type"] = "direct";
			$data["password"]   = md5($password);
			$data["created"]    = NOW;

			$this->db->insert($this->table, $data);
		}else{
			if($password != ""){
				if(strlen($password) <= 5){
					ms(array(
						"status"  => "error",
						"message" => lang("password_must_be_greater_than_5_characters")
					));
				}

				if($password != $confirm_password){
					ms(array(
						"status"  => "error",
						"message" => lang("password_does_not_match_the_confirm_password")
					));
				}

				$data["password"] = md5($password);
			}

			//
			$user_check = $this->model->get("id", $this->table, "email = '{$email}' AND email != '{$user->email}'");
			if(!empty($user_check)){
				ms(array(
					"status"  => "error",
					"message" => lang("this_email_already_exists")
				));
			}

			$this->db->update($this->table, $data, array("ids" => $user->ids));
		}
		
		ms(array(
			"status"  => "success",
			"message" => lang("successfully")
		));
	}

	public function export(){
		export_csv($this->table);
	}

	public function ajax_update_status(){
		$this->model->update_status($this->table, post("id"), false);
	}
	
	public function ajax_delete_item(){
		$this->model->delete($this->table, post("id"), false);
	}
}
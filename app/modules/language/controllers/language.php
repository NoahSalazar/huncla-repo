<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class language extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = LANGUAGE_LIST;
		$this->language    = LANGUAGE;
		$this->module_name = lang('language');
		$this->module_icon = "fa fa-language";
		$this->columns = array(
			"name"      => lang("name"),
			"code"      => lang("code"),
			"icon"      => lang("icon"),
			"status"    => lang("status"),
			"changed"   => lang("changed"),
			"created"   => lang("created")
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
		$this->columns = array(
			"code"      => "",
			"slug"      => "",
			"text"      => "",
		);

		$page        = (int)get("p");
		$limit       = 200;
		$result      = $this->model->getList($this->language, $this->columns, $limit, $page, "en");
		$total       = $this->model->getList($this->language, $this->columns, -1, -1, "en");
		$total_final = $total;

		if($page == 0){
			lang_builder(APPPATH.'../');
		}
		$item = $this->model->get("*", $this->table, "ids = '".segment(3)."'");

		$language = array();
		if(!empty($item)){
			$list_text = $this->model->fetch("*", $this->language, "code = '".$item->code."'", "id", "ASC");
			if(!empty($list_text)){
				foreach ($list_text as $key => $value) {
					$language[$value->slug] = $value->text;
				}
			}
		}

		$configs = array(
			"base_url"   => cn(get_class($this)."/update/".segment(3)), 
			"total_rows" => $total_final, 
			"per_page"   => $limit
		);

		$this->pagination->initialize($configs);

		$data = array(
			"result"           => $item,  
			"default_language" => $this->model->fetch("*", LANGUAGE, "code = 'en'", "id", "ASC", $page, $limit),
			"language"         => $language,
			"total"  		   => $total_final,
			"page"             => $page,
			"limit"            => $limit,
			"module"           => get_class($this),
			"module_name"      => $this->module_name,
			"module_icon"      => $this->module_icon
		);

		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids  = post("ids");
		$name = post("name");
		$code = post("code");
		$icon = post("icon");
		$lang = post("lang");
		$is_default = post("is_default");

		if($name == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("name_is_required")
			));
		}

		if($code == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("code_is_required")
			));
		}

		if($icon == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("please_enter_icon")
			));
		}

		//
		$data = array(
			"name"        => $name,
			"code"        => $code,
			"icon"        => $icon,
			"status"      => 1,
			"changed"     => NOW
		);

		$language_list =$this->model->fetch("*", $this->table, "is_default = 1");
		if(empty($language_list)){
			$data["is_default"] = 1;
		}else{
			if($is_default){
				$data["is_default"] = 1;
				$this->db->update($this->table, array("is_default" => 0));
			}
		}

		$item = $this->model->get("*", $this->table, "ids = '{$ids}'");
		if(empty($item)){

			//
			$item_check = $this->model->get("id", $this->table, "code = '{$code}'");
			if(!empty($item_check)){
				ms(array(
					"status"  => "error",
					"message" => lang("this_language_already_exists")
				));
			}

			$data["ids"]        = ids();
			$data["created"]    = NOW;

			$this->db->insert($this->table, $data);

			if(!empty($lang)){
				foreach ($lang as $key => $value) {
					$item = $this->model->get("*", LANGUAGE, "code = '".$code."' AND slug = '".$key."'");
					if(empty($item)){
						$this->db->insert(LANGUAGE, array(
							"ids"  => ids(),
							"code" => $code, 
							"text" => $value, 
							"slug" => $key
						));
					}else{
						$this->db->update(LANGUAGE, array(
							"ids"  => ids(),
							"code" => $code, 
							"text" => $value, 
							"slug" => $key
						), array("id" => $item->id));
					}
				}
			}
		}else{
			
			//
			$item_check = $this->model->get("id", $this->table, "code = '{$code}' AND id != '{$item->id}'");
			if(!empty($item_check)){
				ms(array(
					"status"  => "error",
					"message" => lang("this_language_already_exists")
				));
			}

			$this->db->update($this->table, $data, array("ids" => $item->ids));

			if(!empty($lang)){
				foreach ($lang as $key => $value) {
					$item = $this->model->get("*", LANGUAGE, "code = '".$code."' AND slug = '".$key."'");
					if(empty($item)){
						$this->db->insert(LANGUAGE, array(
							"ids"  => ids(),
							"code" => $code, 
							"text" => $value, 
							"slug" => $key
						));
					}else{
						$this->db->update(LANGUAGE, array(
							"ids"  => ids(),
							"code" => $code, 
							"text" => $value, 
							"slug" => $key
						), array("id" => $item->id));
					}
				}
			}
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
		$ids = post("id");
		if(!empty($ids)){
			if(is_string($ids)){
				$lang = $this->model->get("*", $this->table, "ids = '".$ids."'");
				if(!empty($lang)){
					$this->db->delete(LANGUAGE, array("code" => $lang->code));
				}
			}else if(is_array($ids)){
				foreach ($ids as $id) {
					$lang = $this->model->get("*", $this->table, "ids = '".$id."'");
					if(!empty($lang)){
						$this->db->delete(LANGUAGE, array("code" => $lang->code));
					}
				}
			}
		}

		$this->model->delete($this->table, post("id"), false);
	}
}
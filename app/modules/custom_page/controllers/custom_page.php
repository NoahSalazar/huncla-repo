<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class custom_page extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = CUSTOM_PAGE;
		$this->module_name = lang('custom_page');
		$this->module_icon = "fa ft-file-text";
		$this->columns = array(
			"name"      => lang("title"),
			"slug"      => lang("slug")
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
		$result = $this->model->get("*", $this->table, "ids = '".segment(3)."'");

		$data = array(
			"result"           => $result,
			"module"           => get_class($this),
			"module_name"      => $this->module_name,
			"module_icon"      => $this->module_icon
		);

		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids      = post("ids");
		$slug     = post("slug");
		$name     = post("name");
		$content  = $this->input->post("content");
		$position = post("position");

		$item = $this->model->get("*", $this->table, "ids = '{$ids}'");
		if(empty($item)){

			if($name == ""){
				ms(array(
					"status"  => "error",
					"message" => lang("title_is_required")
				));
			}

			$data = array(
				"ids"         => ids(),
				"name"        => $name,
				"slug"        => $slug,
				"position"    => $position,
				"content"     => $content,
				"status"      => 1,
				"changed"     => NOW,
				"created"     => NOW,

			);

			$this->db->insert($this->table, $data);
		}else{
			
			$data = array(
				"position"    => $position,
				"content"     => $content,
				"changed"     => NOW
			);

			if($item->status == 1){
				if($name == ""){
					ms(array(
						"status"  => "error",
						"message" => lang("title_is_required")
					));
				}

				$data["name"] = $name;
				$data["slug"] = $slug;
			}

			$this->db->update($this->table, $data, array("ids" => $item->ids));
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
		$this->model->delete($this->table, post("id"), false);
	}
}
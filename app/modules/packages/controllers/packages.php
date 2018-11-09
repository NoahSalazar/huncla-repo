<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class packages extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = PACKAGES;
		$this->module_name = lang("packages");
		$this->module_icon = "fa ft-package";
		

		if(get_payment()){
			$this->columns = array(
				"name"                 => lang("name"),
				"type"                 => lang("type"),
				"number_accounts"      => lang('number_social_accounts'),
				"price_monthly"        => lang('monthly').' ('.get_option('payment_currency').')',
				"price_annually"       => lang('annually').' ('.get_option('payment_currency').')',
				"status"               => lang("status"),
				"changed"              => lang("changed"),
				"created"              => lang("created")
			);
		}else{
			$this->columns = array(
				"name"                 => lang("name"),
				"type"                 => lang("type"),
				"number_accounts"      => lang('number_social_accounts'),
				"status"               => lang("status"),
				"changed"              => lang("changed"),
				"created"              => lang("created")
			);
		}
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
			"result"      => $this->model->get("*", $this->table, "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids         = post("ids");
		$name        = post("name");
		$description = post("description");
		$trial_day       = post("trial_day");
		$subscribers     = post("subscribers");
		$price_monthly   = (float)post("price_monthly");
		$price_annually  = (float)post("price_annually");
		$number_accounts = (int)post("number_accounts");
		$sort            = (int)post("sort");
		$max_storage_size= (float)post("max_storage_size");
		$max_file_size   = (float)post("max_file_size");
		$watermark       = post("watermark");
		$image_editor    = post("image_editor");
		$permission_list = $this->input->post('permission[]');
		$file_pickers = $this->input->post('file_pickers[]');
		$file_types = $this->input->post('file_types[]');

		if($name == "" && !post("trial_day")){
			ms(array(
				"status"  => "error",
				"message" => lang('name_is_required')
			));
		}

		$permission = array();
		if(!empty($permission_list)){
			foreach ($permission_list as $value) {
				$permission[] = $value;
			}
		}

		if(!empty($file_pickers)){
			foreach ($file_pickers as $value) {
				$permission[] = $value;
			}
		}

		if(!empty($file_types)){
			foreach ($file_types as $value) {
				$permission[] = $value;
			}
		}

		$permission['max_storage_size'] = $max_storage_size;
		$permission['max_file_size'] = $max_file_size;
		$permission['watermark'] = $watermark;
		$permission['image_editor'] = $image_editor;

		$data = array(
			
			'description'     => $description,
			'price_monthly'   => $price_monthly,
			'price_annually'  => $price_annually,
			'number_accounts' => $number_accounts,
			"permission" => json_encode($permission, 0),
			'sort' => $sort,
			'changed' => NOW
		);

		$package = $this->model->get("id, ids, type", $this->table, "ids = '{$ids}'");
		if(empty($package)){
			$data['ids'] = ids();
			$data['created'] = NOW;
			$data['sort'] = $sort;
			$data['name'] = $name;
			$data['type'] = 2;
			$this->db->insert($this->table, $data);
		}else{
			if($package->type == 2){
				$data['name'] = $name;
				$data['sort'] = $sort;
			}else{
				$data['trial_day'] = $trial_day;
			}

			if($subscribers){
				$this->db->update(USERS, array('permission' => json_encode($permission)), "package = {$package->id}");
			}

			$this->db->update($this->table, $data, array("ids" => $package->ids));
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
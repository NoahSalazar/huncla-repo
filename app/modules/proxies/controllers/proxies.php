<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class proxies extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->table       = PROXIES;
		$this->module_name = lang("proxies");
		$this->module_icon = "ft-shield";
		

		$this->columns = array(
			"address"              => lang("address"),
			"location"             => lang("location"),
			"status"               => lang("status")
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
			"result"      => $this->model->get("*", $this->table, "ids = '".segment(3)."'"),       
			"module"      => get_class($this),
			"module_name" => $this->module_name,
			"module_icon" => $this->module_icon
		);
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$ids         = post("ids");
		$address     = post("address");
		$location   = post("location");

		if($address == ""){
			ms(array(
				"status"  => "error",
				"message" => "Address is required"
			));
		}

		$data = array(
			'address'   => $address,
			'location'  => $location,
			'changed'   => NOW
		);

		$proxies = $this->model->get("id", $this->table, "ids = '{$ids}'");
		if(empty($proxies)){
			$data['ids'] = ids();
			$data['status'] = 1;
			$data['created'] = NOW;
			$this->db->insert($this->table, $data);
		}else{
			$this->db->update($this->table, $data, array("id" => $proxies->id));
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
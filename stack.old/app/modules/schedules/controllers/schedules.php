<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class schedules extends MX_Controller {
	public $table;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array();

		$this->template->build('index', $data);
	}

	public function xml(){
		header("Content-type: text/xml");
		block_schedules();
	}

	public function social_list(){
		$day = post("day");
		$day = date("Y/m/d", strtotime(str_replace("/", "-", $day)));

		$data = array(
			"day" => $day
		);

		$this->load->view("social_list", $data);
	}
}
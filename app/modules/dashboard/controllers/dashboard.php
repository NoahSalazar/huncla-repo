<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class dashboard extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array();
		$this->template->title('Dashboard');
		$this->template->build('index', $data);
	}

	public function report(){
		echo block_report(segment(3))->data;
	}
	
}
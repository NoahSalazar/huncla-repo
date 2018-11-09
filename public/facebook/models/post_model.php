<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class post_model extends MY_Model {
	public $tb_accounts;
	public $tb_posts;
	public $tb_groups;

	public function __construct(){
		parent::__construct();
		$this->tb_accounts = FACEBOOK_ACCOUNTS;
		$this->tb_posts = FACEBOOK_POSTS;
		$this->tb_groups = FACEBOOK_GROUPS;
	}

	public function get_group($ids){
		$this->db->select("groups.*, accounts.access_token");
		$this->db->from($this->tb_accounts." as accounts");
		$this->db->join($this->tb_groups." as groups", "groups.account = accounts.id");
		$this->db->where("groups.uid", session("uid"));
		$this->db->where("groups.ids", $ids);
		$query = $this->db->get();

		if($query->row()){
			return $query->row();
		}else{
			return false;
		}
	}
}

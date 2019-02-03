<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |____________________
-- File: models/admin_model.php |
-- -----------------------------/
*/

class Manage_user_model extends CI_Model {
	
	function __construct()
	{
	    parent::__construct();
	}

	public function get_users($start, $limit)
	{
		$this->db->order_by("date_joined", 'desc');
		$this->db->order_by("modified", 'desc');
		$this->db->where("level", 2);
		return $this->db->get('accounts', $limit, $start)->result();
	}
	
	public function group_name($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('groups')->row()->name;
	}
	
	public function get_user($id)
	{	
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where('id',$id);
		$query = $this->db->get(); 
		return $query->row_array();
	}
	
	public function edit_insert($value)
	{
		$value['modified'] = time();
		$this->db->where('id', $value['id']);
		$this->db->update('accounts',$value);
		
	}
		
	public function add_user_in($value)
	{
		$value['date_joined'] = time();
		$this->db->insert('accounts',$value);
	}
		
	public function delete($value)
	{	
		$this->db->where('id', $value);
		$this->db->delete('accounts');
	}
		
	public function getGroups() {
		$this->db->where("activate", 1);
		return $this->db->get('groups')->result();
	}
	
	function checkUniqueUsername($data) {
		$this->db->select("id");
		$this->db->from("accounts");
		$this->db->where('username', $data['username']);
		if(!empty($data['id'])) {
			$this->db->where('id !=', $data['id']);
		}
		$res = $this->db->get()->row();
		if(!empty($res)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function getPasswordSetting() {
		$this->db->where("setting", "password_length");
		$password = $this->db->get("settings")->row_array();
		return $password['value'];
	}
}
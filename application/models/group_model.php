<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |____________________
-- File: models/group_model.php |
-- -----------------------------/
*/

class Group_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_groups($start, $limit)
	{
		$this->db->order_by("create_date", 'desc');
		return $this->db->get('groups', $limit, $start)->result();
	}
	
	public function getRols() {
		$this->db->where("activate", 1);
		return $this->db->get('roles')->result();
	}
	
	public function getRoleNameById($id) {
		$sql = $this->db->query("select name from roles where id ='".$id."'");
		return $sql->row();
	}
	
	function addGroup($data) {
		$data['create_date'] = time();
		$data['owner'] = $this->session->userdata('username');
		if(!empty($data['roles'])) {
			$data['roles'] = implode(',', $data['roles']);
		}
		$this->db->insert('groups', $data);
	}
	
	function editGroup($data) {
		if(!empty($data['roles'])) {
			$data['roles'] = implode(',', $data['roles']);
		}
		$this->db->where('id', $data['id']);
		$this->db->update('groups', $data);
	}
	
	function getGroupById($id = null) {
		if(!empty($id)) {
			$this->db->where('id', $id);
			return $this->db->get('groups')->row();
		}
	}
	
	function deleteGroup($id) {
		$this->db->query("DELETE from groups where id='".$id."'");
		return $id;
	}
	
	function getParentGroups () {
		$this->db->where('parent_id', 0);
		$this->db->where('activate', 1);
		return $this->db->get('groups')->result_array();
	}
	
}
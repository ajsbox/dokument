<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |____________________
-- File: models/group_model.php |
-- -----------------------------/
*/

class External_user_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_users($start, $limit)
	{
		return $this->db->get('external_users', $limit, $start)->result();
	}
	
	public function add_user_in($value)
	{
		$value['created'] = time();		
		$this->db->insert('external_users',$value);
	}
	
		public function get_user($id)
	{	
		$this->db->select('*');
		$this->db->from('external_users');
		$this->db->where('id',$id);
		$query = $this->db->get(); 
		return $query->row_array();
	}
	
	
	public function edit_insert($value)
	{
		$value['modify'] = time();
		$this->db->where('id', $value['id']);
		$this->db->update('external_users',$value);
		
	}
	
	
  
	
function deleteUser($id){
$this->db->where('id', $id);
$this->db->delete('external_users');
return $id;

}
	
}
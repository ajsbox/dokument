<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |____________________
-- File: models/admin_model.php |
-- -----------------------------/
*/

class Roles_model extends CI_Model {
	
	function __construct()
	    {
	        parent::__construct();
	    }

	
	public function get_roles()
	{
		return $this->db->get('roles')->result();
	}

	public function addRole($data) {
		$this->db->insert('roles', $data);
	}
	
	public function edit_role($data)
	{
	  	$this->db->where("id",$data);
		return $this->db->get('roles')->row();
	}

	public function delete_role($data)
	{
	 $this->db->query("delete from roles where id=$data");	
	}

}
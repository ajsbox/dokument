<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-- ------~\__
-- CMSLogik |______________________
-- File: models/document_model.php |
-- -------------------------------/
*/

class Document_model extends CI_Model {
	
	
	function __construct()
	{
		parent::__construct();
	}
		
    public function get_document($l)
	{
		$this->db->where('id', $l);

		return $this->db->get('doc_types')->result();
	}
	
	public function update_form($l,$data)
	{
		$this->db->where('id',$l);
		
		if($this->db->update("doc_types",$data))
		{  
		    $out["status"]="ok";
            $out["message"]="Formulario Creado Exitosamente!";
			echo json_encode(array($out));
		}
		else
		{
			$out["status"]="Error";
            $out["message"]="No se creó el formulario!";
			echo json_encode(array());
		}
	}
	public function getDocuments()
	{
		return $this->db->get('doc_types')->result();
	}
	
	public function getGroups() {
		$this->db->where("activate", 1);
		return $this->db->get('groups')->result();
	}
	public function getGroupNameById($id) {
		$sql = $this->db->query("select name from groups where id='".$id."'");
		return $sql->row();
	}
	function addDocument($data) {
		$data['create_date'] = time();
		$data['owner'] = $this->session->userdata('username');
		
		if(!empty($data['groups'])) {
			$data['groups'] = implode(',', $data['groups']);
		}

		$this->db->insert('doc_types', $data);
		$docId = $this->db->insert_id();
		$tableName = 'dt_'.str_replace(" ", "_", strtolower($data['name'])).'_'.$docId;
		$this->db->where("id", $docId);
		$this->db->update('doc_types', array('table_name'=>$tableName));
		return $docId;
	}
	
	function editDocument($data) {
		if(!empty($data['groups'])) {
			$data['groups'] = implode(',', $data['groups']);
		}
		$data['table_name'] = 'dt_'.str_replace(" ", "_", strtolower($data['name'])).'_'.$data['id'];
		$this->db->where('id', $data['id']);
		$this->db->update('doc_types', $data);
	}
	
	function getDocumentById($id = null) {
		if(!empty($id)) {
			$this->db->where('id', $id);
			return $this->db->get('doc_types')->row();
		}
	}
	
	function deleteDocument($id) {
		$this->db->where('id', $id);
		$types = $this->db->get('doc_types')->row();
		$doc = '';
		if($this->db->table_exists($types->table_name)) {
			$this->db->where('document_id', $id);
			$doc = $this->db->get($types->table_name)->row();
		}
		if(empty($doc)) {
			$this->db->query("DELETE from doc_types where id='".$id."'");
			return $id;
		} else {
			return 0;
		}
	}
	
	function createTable($data, $tblName, $docId) {
		$this->load->dbforge();
		//$fields = array();
		//$fields['id'] = array('type' => 'INT', 'auto_increment' => TRUE);
		$this->dbforge->add_field(array(
			"id" =>array('type' => 'INT', 'auto_increment' => TRUE)
		));
		$this->dbforge->add_field(array(
			"user_id" =>array('type' => 'varchar',  'constraint' => '255', 'null' => TRUE)
		));
		$this->dbforge->add_field(array(
			"document_id" =>array('type' => 'INT',  'constraint' => '10', 'null' => TRUE)
		));
		$this->dbforge->add_field(array(
			"groups" =>array('type' => 'varchar',  'constraint' => '100', 'null' => TRUE)
		));
		foreach($data as $element) {
			$field = strtolower(str_replace(" ", "_", $element->title));
			if($element->type=="textarea") {
				$this->dbforge->add_field(array(
					$field =>array('type'=>'text')
				));
			} else {
				$this->dbforge->add_field(array(
					$field =>array('type'=>'varchar', 'constraint' => '255', 'null' => TRUE)
				));
			}
		}
		$this->dbforge->add_field(array(
			"deleted" =>array('type' => 'INT', 'default' => '0')
		));
		$this->dbforge->add_field(array(
			"created" =>array('type' => 'varchar',  'constraint' => '255', 'null' => TRUE)
		));
		$this->dbforge->add_field(array(
			"modified" =>array('type' => 'varchar',  'constraint' => '255', 'null' => TRUE)
		));
		$this->dbforge->add_key('id', true);
		$tblName = strtolower(str_replace(" ", "_", 'dt_'.$tblName.'_'.$docId));
		if($this->db->table_exists($tblName) == TRUE) {
			$this->dbforge->drop_table($tblName);
			$this->db->query("delete from sent_documents where table_name ='".$tblName."'");
			$this->db->query("delete from document_files where table_name ='".$tblName."'");
		}
		$this->dbforge->create_table($tblName, TRUE);
		$this->publishDocType($tblName, $docId);
	}
	function publishDocType($tblName, $docId) {
		$this->db->query("update doc_types set publish='2', table_name='".$tblName."' where id='".$docId."'");
	}
	function addDbInfo($data) {
		$data['created'] = time();
		$this->db->where("hostname", $data['hostname']);
		$this->db->where("username", $data["username"]);
		$this->db->where("password", $data['password']);
		$query = $this->db->get("db_connect");
		if($query->num_rows()==0) {
			$this->db->insert("db_connect", $data);
		}
	}
	
	function addLDAPInfo($data) {
		$this->db->where("current", 1);
		$this->db->update("ldap_config", array('current'=>0));
		$data['created'] = time();
		$this->db->insert("ldap_config", $data);
		return true;
	}
	
	function getLDAPConfig() {
		$this->db->where('current', 1);
		return $this->db->get("ldap_config")->row_array();
	}
}

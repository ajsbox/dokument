<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-- ------~\__
-- CMSLogik |___________________
-- File: models/user_model.php |
-- ----------------------------/
*/

class User_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_user()
	{
		$this->db->where('username', $this->session->userdata('username'));
		return $this->db->get('accounts')->row();
	}

	public function user_by_username($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('accounts')->row();
	}

	public function username_check($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('accounts');

		if($query->num_rows > 0)
		{
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function user_by_activate($activate)
	{
		$this->db->where('activate', $activate);
		return $this->db->get('accounts')->row();
	}

	public function update_password($password)
	{
		$data = array('password' => sha1($password));
		$this->db->where('username', $this->session->userdata('username'));
		$this->db->update('accounts', $data);
	}

	public function set_new_password($pass, $key)
	{
		$this->db->where('reset_password', $key);
		$users = $this->db->get('accounts')->row();
		$data = array('password' => sha1($pass), 'reset_password' => '0');
		$this->db->where('reset_password', $key);
		$this->db->update('accounts', $data);
		return $users;
	}

	public function set_reset_password($user, $reset)
	{
		$data = array('reset_password' => $reset);
		$this->db->where('username', $user);
		$this->db->update('accounts', $data);
	}

	public function reset_check($key)
	{
		$this->db->where('reset_password', $key);
		$query = $this->db->get('accounts');

		if($query->num_rows == 1)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function update_user($data)
	{
		//$data = array('name' => $name, 'lname'=> $lname, 'telephone' => $contact, 'email' => $email);
		$this->db->where('username', $this->session->userdata('username'));
		$this->db->update('accounts', $data);
	}

	public function check_password($password)
	{
		$this->db->where('username', $this->session->userdata('username'));
		$this->db->where('password', sha1($password));
		$query = $this->db->get('accounts');

		if($query->num_rows == 1)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_level($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('accounts')->row();
	}
	/////dhiru 01-05-2014//////
	function getUserDocuments() {
		$groups = $this->auth_model->get_user()->groups;
		$groups = explode(',', $groups);
		$cond = '';
		$totalGroups = count($groups)-1;
		foreach($groups as $key=>$group) {
			if($key < $totalGroups) {
				$cond .= "`groups` LIKE '%".$group."%' OR ";
			} else {
				$cond .= "`groups` LIKE '%".$group."%'";
			}
		}
		$query = $this->db->query("select id, name, elements, form_data, table_name from doc_types where publish='2' and activate='1' and (".$cond.")");
		return $query->result_array();
	}
	
	function searchUserDocuments($data) {
		$groups = $this->auth_model->get_user()->groups;
		$groups = explode(',', $groups);
		$cond = '';
		$cond1 = '';
		if(!empty($data['doc_type'])) {
			$cond1 = "id='".$data['doc_type']."' and";
		}
		if(!empty($data['groups'])) {
			$cond = "`groups` LIKE '%".$data['groups']."%'";
		} else {
			$totalGroups = count($groups)-1;
			foreach($groups as $key=>$group) {
				if($key < $totalGroups) {
					$cond .= "`groups` LIKE '%".$group."%' OR ";
				} else {
					$cond .= "`groups` LIKE '%".$group."%'";
				}
			}
		}
		 $query = $this->db->query("select id, name, elements, form_data, table_name from doc_types where ".$cond1." publish='2' and activate='1' and (".$cond.")");
		 return $query->result_array();
	}
	
	public function checkValidRoles($roleName) {
		 /*$groups = $this->auth_model->get_user()->groups;
		 $group = explode(',', $groups);
		 foreach($group as $g) {
		 	$roles = $this->getRolesByGroupId($g);
			if(!empty($roles)) {
				$roles = explode(',', $roles->roles);
				foreach($roles as $rol) {
					$res = $this->checkGroupRolls($rol, $roleName);
					if(!empty($res)) {
						return true;
					}
				}
			}
		 }
		 return false;*/
		$roles = $this->db->get("roles")->result_array();
		$userRoles = $this->auth_model->get_user()->roles;
		$userRoles = unserialize($userRoles);
		$userGroups = $this->auth_model->get_user()->groups;
		$userGroups = explode(',', $userGroups);
		$userRoles1 = array();
		foreach($userGroups as $grp) {
			$userRoles1 = array_merge($userRoles1, $userRoles[$grp]);
		}
		//print_r($userGroups);exit;
		//$userRoles = explode(',', $userRoles);
		foreach($roles as $key=>$rol) {
			if(in_array($rol['id'], $userRoles1) and $rol['name']==$roleName) {
				return true;
			}
		}
		return false;
	}
	
	public function checkValidRolesWithGroup($groupId, $roleName) {
		$userRoles = $this->auth_model->get_user()->roles;
		$userRoles = unserialize($userRoles);
		$userRoles = $userRoles[$groupId];
		$roles = $this->db->get("roles")->result_array();
		foreach($roles as $key=>$rol) {
			if(in_array($rol['id'], $userRoles) and $rol['name']==$roleName) {
				return true;
			}
		}
		return false;
	}
	
	function checkGroupRolls($roleId, $roleName) {
		$this->db->select("id");
		$this->db->where("id",$roleId);
		$this->db->where("name", $roleName);
		return $this->db->get("roles")->row();
	}
	
	function checkRolesByIds($ids) {
		if(!empty($ids)) {
			foreach($ids as $id) {
				$this->db->where("id", $id);
				$this->db->where("name", "Cargar");
				$data = $this->db->get("roles")->row_array();
				if(!empty($data)) {
					return true;
				}
			}
			return false;
		}
	}
	
	function getRolesByGroupId($groupId) {
		$this->db->select("roles");
		$this->db->where('id', $groupId);
		return $this->db->get("groups")->row();
	}
	
	function getUserDocumentById($docId) {
		 $query = $this->db->query("select id, name, elements, form_data, table_name from doc_types where id='".$docId."'");
		 return $query->row_array();
	}
	
	public function countDocumentFiles($tblName, $docId, $srchText) {
		//if($this->db->table_exists($tblName) == TRUE) {
		if(!empty($srchText)) {
			$cond = "(description like '%".$srchText."%' or user like '%".$srchText."%') and ";
		} else {
			$cond = "";
		}
		$query = $this->db->query("select id from document_files where ".$cond." deleted='0' and main_file=1 and table_name='".$tblName."' and document_id=".$docId."");
		return $query->num_rows;
		//}
	}
	
	function getDocumentMainFiles($tblName, $id, $srchText, $strtLimit, $endLimit) {
		if(!empty($srchText)) {
			$cond = "(description like '%".$srchText."%' or user like '%".$srchText."%') and ";
		} else {
			$cond = "";
		}
		$query = $this->db->query("select *, FROM_UNIXTIME(created, '%d, %m %Y')as created, FROM_UNIXTIME(modified, '%d, %m %Y')as modified from document_files where ".$cond." deleted='0' and main_file=1 and table_name='".$tblName."' and document_id=".$id." order by id desc limit ".$strtLimit.", ".$endLimit."");
	
		return $query->result_array();
	}
	
	public function countDocumentFiles1($tblName, $docId, $srchText) {
		//if($this->db->table_exists($tblName) == TRUE) {
		if(!empty($srchText)) {
			$cond = "(description like '%".$srchText."%' or user like '%".$srchText."%') and ";
		} else {
			$cond = "";
		}
		$query = $this->db->query("select id from document_files where ".$cond." deleted='0' and main_file='0' and table_name='".$tblName."' and document_id=".$docId."");
		return $query->num_rows;
		//}
	}
	
	function getDocumentMainFiles1($tblName, $id, $srchText, $strtLimit, $endLimit) {
		if(!empty($srchText)) {
			$cond = "(description like '%".$srchText."%' or user like '%".$srchText."%') and ";
		} else {
			$cond = "";
		}
		$query = $this->db->query("select *, FROM_UNIXTIME(created, '%d, %m %Y')as created, FROM_UNIXTIME(modified, '%d, %m %Y')as modified from document_files where ".$cond." deleted='0' and main_file='0' and table_name='".$tblName."' and document_id=".$id." order by id desc limit ".$strtLimit.", ".$endLimit."");
	
		return $query->result_array();
	}
	
	function saveDocumentByUser($data, $tblName) { //print_r($data);exit;
		if($this->db->table_exists($tblName) == TRUE) {
			$data['user_id'] = $this->session->userdata('username');
			$data['created'] = time();
			if(isset($data['file_names'])) {
				$realFiles = $data['file_names'];
				unset($data['file_names']);
			}
			if(isset($data['scan_file'])) {
				$scanFile = $data['scan_file'];
				unset($data['scan_file']);
			}
			$data['groups'] = $data['groups'];
			$this->db->insert($tblName, $data);
			$docId = $this->db->insert_id();
			$fileData['document_id'] = $docId;
			$fileData['table_name'] = $tblName;
			$fileData['created'] = time();
			$fileData['user'] = $this->session->userdata('username');
			if(isset($data['descripcion'])) {
				$fileData['description'] = $data['descripcion'];
			} else {
				$fileData['description'] = $data['description'];
			}
			/*if(isset($data['numero_de_documento'])) {
				$fileData['description'] = $data['numero_de_documento'];
			} else {
				$fileData['description'] = $data['description'];
			}*/
			$fileData['main_file'] = 1;
			if(!empty($scanFile)) {
				$fileData['file_name'] = $scanFile;
				$this->db->insert('document_files', $fileData);
			}
			if(!empty($realFiles)) {
				$countFile = 0;
				foreach($realFiles as $key=>$file) {
					//$fileData['original_file_name'] = $_FILES[$key]['name'];
					if(isset($realFiles[$countFile])) {
						$fileData['file_name'] = $realFiles[$countFile];
					}
					$this->db->insert('document_files', $fileData);
				}
				$countFile++;
			}
			return $docId;
		}
	}
	
	public function getGroupNameById($id) {
		$sql = $this->db->query("select name from groups where id='".$id."'");
		return $sql->row();
	}
	
	public function getUserSentDocs() {
		$this->db->where("from_id", $this->session->userdata("username"));
		$this->db->order_by("id", "desc");
		return $this->db->get("sent_documents")->result_array();
	}
	
	public function getUserRevieveDocs() {
		$this->db->where("user_id", $this->session->userdata("username"));
		$this->db->order_by("id", "desc");
		return $this->db->get("sent_documents")->result_array();
	}
	
	public function getDocumentsByTableName($tblName, $id, $srchTxt) {
		if($this->db->table_exists($tblName) == TRUE) {
			$groups = $this->auth_model->get_user()->groups;
			if(!empty($srchTxt)) {
				$cond = '(';
				$fields = $this->db->list_fields($tblName);
				foreach($fields as $key=>$field) {
					if($key==0) {
						$cond .= $field." like '%".$srchTxt."%' ";
					} else {
						$cond .= 'or '.$field." like '%".$srchTxt."%' ";
					}
				}
				$cond .= ') and ';
			} else {
				$cond = "";
			}
			$query = $this->db->query("select *, FROM_UNIXTIME(created, '%d, %m %Y')as created, FROM_UNIXTIME(modified, '%d, %m %Y')as modified from ".$tblName." where ".$cond." id='".$id."' and deleted='0' and groups in(".$groups.") order by id desc");
			return $query->row_array();
		}
	}
	
	public function searchDocumentsByTableName($tblName, $id, $data) {
		if($this->db->table_exists($tblName) == TRUE) {
			$groups = $this->auth_model->get_user()->groups;
			$this->db->where('id', $id);
			if(!empty($data['from']) and !empty($data['to'])) { 
				$this->db->where('created >=', strtotime($data['from']));	
				$this->db->where('created <=', strtotime($data['to']));
			}
			//print_r($this->db->get($tblName)->row_array());exit;
			if(!empty($data['doc_type'])) {
				$this->db->or_where('document_id', $data['doc_type']);
			}
			if(!empty($data['groups'])) {
				$this->db->or_where('groups', $data['groups']);
			}
			$this->db->where('deleted', '0');
			$this->db->where('groups in ('.$groups.')');
			return $this->db->get($tblName)->row_array();
		}
	}
	
	function getDocTypes() {
		$groups = $this->auth_model->get_user()->groups;
		$groups = explode(',', $groups);
		$cond = '';
		$totalGroups = count($groups)-1;
		foreach($groups as $key=>$group) {
			if($key < $totalGroups) {
				$cond .= "`groups` LIKE '%".$group."%' OR ";
			} else {
				$cond .= "`groups` LIKE '%".$group."%'";
			}
		}
		$query = $this->db->query("select id, name from doc_types where publish='2' and activate='1' and (".$cond.")");
		return $query->result_array();
	}
	
	function editDocumentTypes($data) { //print_r($data);exit;
		$this->db->where('id', $data['id']);
		$table = $data['table'];
		if(isset($data['files'])) {
			$files = $data['files'];
			unset($data['files']);
		}
		unset($data['table']);
		if(isset($data['file_names'])) {
			$realFiles = $data['file_names'];
			unset($data['file_names']);
		}
		//$data['groups'] = $data['groups'];
		$data['modified'] = time();
		$this->db->update($table, $data);
		if(isset($data['descripcion'])) {
			$fileData['description'] = $data['descripcion'];
		} else if(isset($data['description'])) {
			$fileData['description'] = $data['description'];
		}
		$this->db->where("document_id", $data['id']);
		$this->db->update("document_files", array("description"=>$fileData['description']));
		
		if(isset($realFiles)) {
			$countFile = 0; 
			if(isset($data['descripcion'])) {
				$fileData['description'] = $data['descripcion'];
			} else if(isset($data['description'])) {
				$fileData['description'] = $data['description'];
			}
			$fileData['main_file'] = 1;
			foreach($realFiles as $key=>$file) {
				//$fileData['original_file_name'] = $_FILES[$key]['name'];
				if(isset($realFiles[$countFile])) {
					$fileData['file_name'] = $realFiles[$countFile];
				}
				$this->db->where('document_id', $data['id']);
				$this->db->where('table_name', $table);
				$this->db->where('file_name', $files[$countFile]);
				$res = $this->db->get('document_files')->row_array();
				if(!empty($res)) {
					$fileData['modified'] = time();
					$this->db->where('document_id', $data['id']);
					$this->db->where('table_name', $table);
					$this->db->where('file_name', $files[$countFile]);
					$this->db->update('document_files', $fileData);
				} else {
					$fileData['table_name'] = $table;
					$fileData['document_id'] = $data['id'];
					$fileData['user'] = $this->session->userdata('username');
					$fileData['created'] = time();
					$this->db->insert('document_files', $fileData);
				}
				$countFile++;
			}
		}
	}
	
	function deleteDocument($data) {
		$this->db->query("update ".$data['table']." set deleted=1, modified='".time()."' where id=".$data['id']."");
		$this->db->query("update document_files set deleted=1, modified='".time()."' where document_id='".$data['id']."'");
		$this->db->query("update sent_documents set deleted=1 where document_id='".$data['id']."'");
		
		//$this->db->query("delete from sent_documents where document_id=".$data['id']."");
		//$this->db->query("delete from document_files where document_id=".$data['id']."");
	}
	
	function getUsersByGroupId() {
		$groups = $this->auth_model->get_user()->groups;
		$groups = explode(',', $groups);
		//$this->db->where('username !=', $this->session->userdata("username"));
		$cond = '';
		$totalGroups = count($groups)-1;
		foreach($groups as $key=>$group) {
			if($key < $totalGroups) {
				$cond .= "`groups` LIKE '%".$group."%' OR ";
			} else {
				$cond .= "`groups` LIKE '%".$group."%'";
			}
		}
		$query = $this->db->query("SELECT * FROM (`accounts`) WHERE `username` != '".$this->session->userdata("username")."' AND (".$cond.")");
		return $query->result_array();
	}
	
	function sentDocumentTypes($data) {
		$val['document_id'] = $data['id'];
		$val['from_id'] = $this->session->userdata("username");
		$val['table_name'] = $data['table'];
		$val['created'] = time();
		foreach($data['users'] as $user) {
			$val['user_id'] = $user;
			$this->db->insert('sent_documents', $val);
		}
	}
	function updateDocumentFiles($data) {
		$this->db->query("update document_files set document_id='".$data['document_id']."', table_name='".$data['table']."' where id='".$data['id']."'");
	}
	
	function getDocumentFileById($tblName, $id) {
		$this->db->where('document_id', $id);
		$this->db->where('table_name', $tblName);
		$this->db->where('main_file', 0);
		$this->db->order_by('created', 'desc');
		return $this->db->get("document_files")->result_array();
	}
	
	function addFile($data) {
		if(!empty($data)) {
			$data['created'] = time();
			$data['user'] = $this->session->userdata("username");
			$this->db->insert("document_files", $data);
			return true;
		}
	}
	function countTotalValueBySearch($tblName, $data, $srchText) {
		if($this->db->table_exists($tblName) == TRUE) {
			$groups = $this->auth_model->get_user()->groups;
			//$groups = explode(',', $groups);
			//$this->db->where('user_id', $this->session->userdata('username'));
			$tblFields = $this->db->list_fields($tblName);
			if(!empty($data['from']) and !empty($data['to'])) { 
				//echo strtotime($data['from']).'  '.strtotime($data['to'].' '.date("H:i:s", time()));exit;
				$this->db->where('created >=', strtotime($data['from'])-21600);	
				$this->db->where('created <=', strtotime($data['to'].' '.date("H:i:s", time())));
			}
			if(!empty($data['doc_type'])) {
				foreach($data['doc_type']  as $docType) {
					$this->db->or_where('document_id', $docType);
				}
			}
			/*if(!empty($data['groups'])) {
				$this->db->or_where('groups', $data['groups']);
			}*/
			$fields = array("deleted", "created", "modified", "id");
			
			if(!empty($data['search_by_word'])) {
				foreach($tblFields as $field) {
					if(!in_array($field, $fields)) {
						$this->db->or_where($field." like '".$data['search_by_word']."'");
					}
				}
			} 
			//print_r($this->db);exit;
			//print_r($this->db->get($tblName)->result_array());exit;
			if(!empty($data['search_by_any_word'])) {
				$words = explode(' ', $data['search_by_any_word']);
				foreach($words as $word) {
					if(!empty($word)) {
						foreach($tblFields as $field) {
							if(!in_array($field, $fields)) {
								//$this->db->or_like($field, $word);
								$this->db->or_like($field, $word);
							}
						}
					}
				}
			}
			
			if(!empty($srchTxt)) {
				foreach($tblFields as $key=>$field) {
					if(!in_array($field, $fields)) {
						$this->db->or_like($field, $srchTxt);
					}
				}
			}
			
			if(!empty($data['search_by_not_of_word'])) {
				$words = explode(' ', $data['search_by_not_of_word']);
				foreach($words as $word) {
					if(!empty($word)) {
						foreach($tblFields as $field) {
							if(!in_array($field, $fields)) {
								$this->db->where($field." not like '%".$word."%'");
								//$this->db->or_like($field, $word);
							}
						}
					}
				}
			}
				
			$this->db->where("deleted", 0);
			$this->db->where('groups in('.$groups.')');
			return $this->db->from($tblName)->count_all_results();
		}
	}
	
	function countTotalValue($tblName, $srchTxt) {
		if($this->db->table_exists($tblName) == TRUE) {
			if(!empty($srchTxt)) {
				$cond = '(';
				$fields = $this->db->list_fields($tblName);
				foreach($fields as $key=>$field) {
					if($key==0) {
						$cond .= $field." like '%".$srchTxt."%' ";
					} else {
						$cond .= 'or '.$field." like '%".$srchTxt."%' ";
					}
				}
				$cond .= ') and ';
			} else {
				$cond = "";
			}
			$groups = $this->auth_model->get_user()->groups;
			$query = $this->db->query("select count(id) as totalrow from ".$tblName." where ".$cond." deleted='0' and groups in(".$groups.") ");
			return $query->row()->totalrow;
		}
	}
	function getGroupById($groupId) {
		if(!empty($groupId)) {
			$this->db->where("id", $groupId);
			return $this->db->get("groups")->row()->name;
		}
	}
	
	function totalSentDocs($tblName, $docId, $srchTxt) {
		if(!empty($srchTxt)) {
			$cond = '(';
			$fields = $this->db->list_fields($tblName);
			foreach($fields as $key=>$field) {
				if($key==0) {
					$cond .= $field." like '%".$srchTxt."%' ";
				} else {
					$cond .= 'or '.$field." like '%".$srchTxt."%' ";
				}
			}
			$cond .= ') and ';
		} else {
			$cond = "";
		}
		$query = $this->db->query("select count(id) as totalrow from ".$tblName." where ".$cond." id='".$docId."' and deleted=0");
		return $query->row()->totalrow;
	}
	
	function totalRecievDocs($tblName, $docId, $srchTxt) {
		if(!empty($srchTxt)) {
			$cond = '(';
			$fields = $this->db->list_fields($tblName);
			foreach($fields as $key=>$field) {
				if($key==0) {
					$cond .= $field." like '%".$srchTxt."%' ";
				} else {
					$cond .= 'or '.$field." like '%".$srchTxt."%' ";
				}
			}
			$cond .= ') and ';
		} else {
			$cond = "";
		}
		$query = $this->db->query("select count(id) as totalrow from ".$tblName." where ".$cond." id='".$docId."' and deleted=0");
		return $query->row()->totalrow;
	}
	
 	///// 01-05-2014//////////////
	function get_table_data($tblName, $strtLimit, $endLimit, $srchTxt) {
		if($this->db->table_exists($tblName) == TRUE) {
			$groups = $this->auth_model->get_user()->groups;
			
			if(!empty($srchTxt)) {
				$cond = '(';
				$fields = $this->db->list_fields($tblName);
				
				foreach($fields as $key=>$field) {
					if($key==0) {
						$cond .= $field." like '%".$srchTxt."%' ";
					} else {
						$cond .= 'or '.$field." like '%".$srchTxt."%' ";
					}
				}
				$cond .= ') and ';
			} else {
				$cond = "";
			}
			$query = $this->db->query("select *, FROM_UNIXTIME(created, '%d, %m %Y')as created, FROM_UNIXTIME(modified, '%d, %m %Y')as modified from ".$tblName." where ".$cond." deleted='0' and groups in(".$groups.") order by id desc limit ".$strtLimit.", ".$endLimit."");
			return $query->result_array();
		}
	}
	
	function getLatestRecord($tblName, $strtLimit, $endLimit) {
		if($this->db->table_exists($tblName) == TRUE) {
			$groups = $this->auth_model->get_user()->groups;
			/*if(!empty($srchTxt)) {
				$cond = '(';
				$fields = $this->db->list_fields($tblName);
				
				foreach($fields as $key=>$field) {
					if($key==0) {
						$cond .= $field." like '%".$srchTxt."%' ";
					} else {
						$cond .= 'or '.$field." like '%".$srchTxt."%' ";
					}
				}
				$cond .= ') and ';
			} else {
				$cond = "";
			}*/
			$query = $this->db->query("select *, created as created1, FROM_UNIXTIME(created, '%d, %m %Y')as created, FROM_UNIXTIME(modified, '%d, %m %Y')as modified from ".$tblName." where deleted='0' and groups in(".$groups.") order by id desc limit ".$strtLimit.", ".$endLimit."");
			return $query->result_array();
		}
	}
	
	function get_table_data_search($tblName, $data, $startLimit, $endLimit, $srchTxt) {
		if($this->db->table_exists($tblName) == TRUE) {
			$groups = $this->auth_model->get_user()->groups;
			//$groups = explode(',', $groups);
			//$this->db->where('user_id', $this->session->userdata('username'));
			//$tblFields = array('numero_de_documento', 'descripcion', 'document__id', 'description');
			$tblFields = $this->db->list_fields($tblName);
			if(!empty($data['from']) and !empty($data['to'])) { 
				//echo strtotime($data['from']).'  '.strtotime($data['to'].' '.date("H:i:s", time()));exit;
				$this->db->where('created >=', strtotime($data['from'])-21600);	
				$this->db->where('created <=', strtotime($data['to'].' '.date("H:i:s", time())));
			}
			if(!empty($data['doc_type'])) {
				foreach($data['doc_type']  as $docType) {
					$this->db->or_where('document_id', $docType);
				}
			}
			/*if(!empty($data['groups'])) {
				$this->db->or_where('groups', $data['groups']);
			}*/
			$fields = array("deleted", "created", "modified", "id");
			
			if(!empty($data['search_by_word'])) {
				foreach($tblFields as $field) {
					if(!in_array($field, $fields)) {
						$this->db->or_where($field." like '".$data['search_by_word']."'");
					}
				}
			} 
			//print_r($this->db);exit;
			//print_r($this->db->get($tblName)->result_array());exit;
			if(!empty($data['search_by_any_word'])) {
				$words = explode(' ', $data['search_by_any_word']);
				foreach($words as $word) {
					if(!empty($word)) {
						foreach($tblFields as $field) {
							if(!in_array($field, $fields)) {
								//$this->db->or_like($field, $word);
								$this->db->or_like($field, $word);
							}
						}
					}
				}
			}
			
			if(!empty($srchTxt)) {
				foreach($tblFields as $key=>$field) {
					if(!in_array($field, $fields)) {
						$this->db->or_like($field, $srchTxt);
					}
				}
			}
			
			if(!empty($data['search_by_not_of_word'])) {
				$words = explode(' ', $data['search_by_not_of_word']);
				foreach($words as $word) {
					if(!empty($word)) {
						foreach($tblFields as $field) {
							if(!in_array($field, $fields)) {
								$this->db->where($field." not like '%".$word."%'");
								//$this->db->or_like($field, $word);
							}
						}
					}
				}
			}
			
			$this->db->where("deleted", 0);
			$this->db->where('groups in('.$groups.')');
			//print_r($endLimit.' '.$startLimit.'  ');
			//$this->db->limit($endLimit, $startLimit);
			return $this->db->get($tblName)->result_array();
		}
	}
	
	function getdocu()
	{
		$query = $this->db->query("select COUNT(*) as no from doc_types");
		return $query->row();	
	}
		
	function getrol()
	{
		$query = $this->db->query("select COUNT(*) as no from roles");
		return $query->row();
		 
		}
	function getgroups()
	{
		$query = $this->db->query("select COUNT(*) as no from groups");
		return $query->row();	
	}
	
	function getaccounts() {
		$query = $this->db->query("select COUNT(*) as no from accounts");
		return $query->row();
	}
	
	function updateDocumentFile($data) {
		if(!empty($data)) {
			$id = $data['file_id'];
			unset($data['file_id']);
			unset($data['file_table']);
			unset($data['submitFile']);
			$data['modified'] = time();
			$this->db->where("id", $id);
			$this->db->update("document_files", $data);
		}
	}
	
	function getDocumentByIdandTbl($docId, $tbl) {
		$this->db->where("id", $docId);
		return $this->db->get($tbl)->row_array();
	}
	
	function getLastDocFile($data, $files) {
		$this->db->where('document_id', $data['document_id']);
		$this->db->where('table_name', $data['table_name']);
		if($files==$data['max_rec']) {
			$this->db->where("modified >=", time()-200);
			$docs = $this->db->get("document_files", 1, 0)->result_array();
		} else {
			$this->db->order_by("id", "desc");
			$docs = $this->db->get("document_files", $files-$data['max_rec'], 0)->result_array();
		}
		return $docs;
	}
	
	public function getExternalUsers() {
		return $this->db->get("external_users")->result_array();
	}
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |____________________
-- File: models/admin_model.php |
-- -----------------------------/
*/
class Admin_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_users($limit, $offset)
	{
		return $this->db->get('accounts', $limit, $offset)->result();
	}

	public function user_data_by_level($l)
	{
		$this->db->where('level', $l);
		return $this->db->get('accounts')->result();
	}

	public function get_latest_users()
	{
		$this->db->order_by('date_joined', 'DESC');
		$this->db->limit(5);
		return $this->db->get('accounts')->result();
	}

	public function total_users()
	{
		return $this->db->get('accounts')->num_rows;
	}

	public function total_users_date($start, $end)
	{
		$this->db->where('date_joined >', $start);
		$this->db->where('date_joined <', $end);
		return $this->db->get('accounts')->num_rows;
	}

	public function total_users_date_social($start, $end)
	{
		$this->db->where('date_joined >', $start);
		$this->db->where('date_joined <', $end);
		$this->db->where('fb_id !=', '0');
		$this->db->where('oauth_token !=', '0');
		return $this->db->get('accounts')->num_rows;
	}

	public function top_ten_users()
	{
		$select = $this->db->query('SELECT * FROM login GROUP BY username ORDER BY COUNT( * ) DESC LIMIT 10');

		return $select->result();
	}

	public function top_ten_pages()
	{
		$select = $this->db->query('SELECT * FROM hits GROUP BY p_id ORDER BY COUNT( * ) DESC LIMIT 10');

		return $select->result();
	}

	public function top_ten_users_date($start, $end)
	{
		$select = $this->db->query("SELECT * FROM login WHERE date > $start AND date < $end GROUP BY username ORDER BY COUNT( * ) DESC LIMIT 10");

		return $select->result();
	}

	public function top_ten_pages_date($start, $end)
	{
		$select = $this->db->query("SELECT * FROM hits WHERE date > $start AND date < $end GROUP BY p_id ORDER BY COUNT( * ) DESC LIMIT 10");

		return $select->result();
	}

	public function save_notes($notes, $owner)
	{
		$data = array('notes' => $notes, 'owner' => $owner, 'date' => time());
		$this->db->insert('admin_notes', $data);
		return $data['date'];
	}

	public function get_admin_notes()
	{
		$q = $this->db->order_by('date', 'DESC')->get('admin_notes');

		if($q->num_rows < 1)
		{
			return FALSE;
		} else {
			return $q->result_array();
		}
	}

	public function page_name_by_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('pages')->row()->name;
	}

	public function num_p_views($id)
	{
		$this->db->where('p_id', $id);
		return $this->db->get('hits')->num_rows;
	}

	public function num_logins($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('login')->num_rows;

		if($query < 1)
		{
			return "No Data";
		} else {
			return $query;
		}
	}

	public function total_fb()
	{
		$this->db->where('fb_id !=', '0');
		return $this->db->get('accounts')->num_rows;
	}

	public function total_tw()
	{
		$this->db->where('oauth_token !=', '0');
		return $this->db->get('accounts')->num_rows;
	}

	public function total_fb_date($start, $end)
	{
		$this->db->where('date_joined >', $start);
		$this->db->where('date_joined <', $end);
		$this->db->where('fb_id !=', '0');
		return $this->db->get('accounts')->num_rows;
	}

	public function update_module($mid, $active)
	{
		$data = array('active' => $active);
		$this->db->where('id', $mid);
		$this->db->update('modules', $data);
	}

	public function all_departments()
	{
		return $this->db->get('departments')->result();
	}

	public function total_tw_date($start, $end)
	{
		$this->db->where('date_joined >', $start);
		$this->db->where('date_joined <', $end);
		$this->db->where('oauth_token !=', '0');
		return $this->db->get('accounts')->num_rows;
	}

	public function total_hits()
	{
		return $this->db->count_all_results('hits');
	}

	public function total_hits_date($start, $end)
	{
		$this->db->where('date >', $start);
		$this->db->where('date <', $end);
		return $this->db->count_all_results('hits');
	}

	public function user_data_by_email($email)
	{
		$this->db->where('email', $email);
		return $this->db->get('accounts')->row();
	}

	public function get_email_templates()
	{
		return $this->db->get('email_temp')->result();
	}

	public function get_email_temp($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('email_temp')->row();
	}

	public function email_temp_by_file_name($name)
	{
		$this->db->where('file_name', $name);
		return $this->db->get('email_temp')->row();
	}

	public function edit_email_temp($id, $name, $file_name, $subject)
	{
		$data = array('name' => $name, 'file_name' => $file_name, 'subject' => $subject);
		$this->db->where('id', $id);
		$this->db->update('email_temp', $data);
	}

	public function add_email_temp($name, $file, $subject)
	{
		$data = array('name' => $name, 'file_name' => $file, 'subject' => $subject);
		$this->db->insert('email_temp', $data);
	}

	public function get_modules()
	{
		return $this->db->get('modules')->result();
	}

	public function edit_page($page_id, $name, $slug, $levels)
	{
		$data = array(
			'name' => $name,
			'slug' => $slug,
			'levels' => $levels);

		$this->db->where('id', $page_id);
		$this->db->update('pages', $data);
	}

	public function update_settings($site_title, $header_title, $password_length)
	{
		/*$data = array('value' => $admin_email);
		$this->db->where('setting', 'admin_email');
		$this->db->update('settings', $data);*/

		$data = array('value' => $site_title);
		$this->db->where('setting', 'site_title');
		$this->db->update('settings', $data);

		$data = array('value' => $header_title);
		$this->db->where('setting', 'header_title');
		$this->db->update('settings', $data);

		$data = array('value' => $password_length);
		$this->db->where('setting', 'password_length');
		$this->db->update('settings', $data);
		
		/*$data = array('value' => $default_url);
		$this->db->where('setting', 'default_url');
		$this->db->update('settings', $data);

		$data = array('value' => $registration);
		$this->db->where('setting', 'registration');
		$this->db->update('settings', $data);

		$data = array('value' => $login);
		$this->db->where('setting', 'login');
		$this->db->update('settings', $data);

		$data = array('value' => $email_activate);
		$this->db->where('setting', 'email_activate');
		$this->db->update('settings', $data);

		$data = array('value' => $welcome_email);
		$this->db->where('setting', 'welcome_email');
		$this->db->update('settings', $data);

		$data = array('value' => $default_page);
		$this->db->where('setting', 'default_page');
		$this->db->update('settings', $data);

		$data = array('value' => $default_level);
		$this->db->where('setting', 'default_level');
		$this->db->update('settings', $data);*/
	}

	public function social_settings($fb_appid, $fb_secret, $tw_consumer_key, $tw_consumer_secret)
	{
		$data = array('value' => $fb_appid);
		$this->db->where('setting', 'fb_appid');
		$this->db->update('settings', $data);

		$data = array('value' => $fb_secret);
		$this->db->where('setting', 'fb_secret');
		$this->db->update('settings', $data);

		$data = array('value' => $tw_consumer_key);
		$this->db->where('setting', 'consumer_key');
		$this->db->update('settings', $data);

		$data = array('value' => $tw_consumer_secret);
		$this->db->where('setting', 'consumer_secret');
		$this->db->update('settings', $data);
	}

	public function captcha_settings($public, $private)
	{
		$data = array('value' => $public);
		$this->db->where('setting', 'recaptcha_public');
		$this->db->update('settings', $data);

		$data = array('value' => $private);
		$this->db->where('setting', 'recaptcha_private');
		$this->db->update('settings', $data);
	}

	public function add_page($name, $slug, $levels)
	{
		$data = array(
			'name' => $name,
			'slug' => $slug,
			'levels' => $levels);
		$this->db->insert('pages', $data);
	}

	public function delete_user($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('accounts');
	}

	public function delete_page($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pages');
	}

	public function delete_tmp($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('email_temp');
	}

	public function delete_level($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('levels');
	}

	public function delete_menu($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('menu');
	}

	public function update_user_password($user, $password)
	{
		$data = array('password' => sha1($password));

		$this->db->where('id', $user);
		$this->db->update('accounts', $data);
	}

	public function update_user_info($user_id, $name, $username, $email, $level)
	{
		$data = array(
			'name' => $name,
			'username' => $username,
			'email' => $email,
			'level' => $level);

		$this->db->where('id', $user_id);
		$this->db->update('accounts', $data);
	}

	public function add_level($name, $redirect)
	{
		$data = array(
			'name' => $name,
			'redirect' => $redirect);
		$this->db->insert('levels', $data);
	}

	public function edit_level($lid, $name, $redirect)
	{
		$data = array('name' => $name, 'redirect' => $redirect);
		$this->db->where('id', $lid);
		$this->db->update('levels', $data);
	}

	public function level_name($id)
	{
		$this->db->where('id', $id);
		return @$this->db->get('levels')->row()->name;
	}

	public function get_levels()
	{
		return $this->db->get('levels')->result();
	}

	public function level_data($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('levels')->row();
	}

	public function get_pages()
	{
		return $this->db->get('pages')->result();
	}

	public function get_pages_settings($id)
	{
		$this->db->where('id !=', $id);
		$query = $this->db->get('pages');

		if($query->num_rows < 1)
		{
			return '0';
		} else {
			return $query->result();
		}
	}

	public function get_level_settings($id)
	{
		$this->db->where('id !=', $id);
		$query = $this->db->get('levels');

		if($query->num_rows < 1)
		{
			return '0';
		} else {
			return $query->result();
		}
	}

	public function page_data($page)
    {
    	$this->db->where('slug', $page);
    	$query = $this->db->get('pages');

    	if($query->num_rows < 1)
    	{
    		return FALSE;
    	} else {
    		return $query->row();
    	}
    }

    public function get_page_by_id($id)
    {
    	$this->db->where('id', $id);
    	return $this->db->get('pages')->row();
    }

	public function get_user_data_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('accounts')->row();
	}

	public function users_in_level($level)
	{
		$this->db->where('level', $level);
		return $this->db->get('accounts')->num_rows;
	}

	public function update_user($id, $username, $name, $email)
	{
		$data = array(
			'username' => $username,
			'name' => $name,
			'email' => $email);

		$this->db->where('id', $id);
		$this->db->update('accounts', $data);
	}

	public function add_menu_item($name, $link, $order)
	{
		$data = array('name' => $name, 'link' => $link, 'order' => $order);
		$this->db->insert('menu', $data);
	}

	public function menu_item_by_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('menu')->row();
	}

	public function menu_item_update($id, $name, $link, $order)
	{
		$data = array('name' => $name, 'link' => $link, 'order' => $order);
		$this->db->where('id', $id);
		$this->db->update('menu', $data);
	}

	public function get_menu()
	{
		$this->db->order_by('order', 'ASC');
		return $this->db->get('menu')->result();
	}
////dhiru ////
	function aciveInactivateUser($data) {
		if($data['table']=="accounts") {
			$this->db->query("update ".$data['table']." set activate='".$data['act']."', modified='".time()."' where id='".$data['id']."'");
		} else {
			$this->db->query("update ".$data['table']." set activate='".$data['act']."' where id='".$data['id']."'");
		}
		return $data['id'];
	}
	
	function getUserDocuments() {
		$query = $this->db->query("select id, name, elements, form_data, table_name from doc_types where publish='2' and activate='1'");
		return $query->result_array();
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
			//$groups = $this->auth_model->get_user()->groups;
			$query = $this->db->query("select count(id) as totalrow from ".$tblName." where ".$cond." deleted='0'");
			return $query->row()->totalrow;
		}
	}
	
	function getLatestRecord($tblName, $strtLimit, $endLimit) {
		if($this->db->table_exists($tblName) == TRUE) {
			//$groups = $this->auth_model->get_user()->groups;
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
			$query = $this->db->query("select *, FROM_UNIXTIME(modified, '%d, %m %Y')as modified from ".$tblName." where deleted='0' order by id desc limit ".$strtLimit.", ".$endLimit."");
			return $query->result_array();
		}
	}
	
	function get_table_data($tblName, $strtLimit, $endLimit, $srchTxt) { 
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
			$query = $this->db->query("select *, FROM_UNIXTIME(created, '%d-%m-%Y')as created, FROM_UNIXTIME(modified, '%d-%m-%Y')as modified from ".$tblName." where ".$cond." deleted='0' order by created desc limit ".$strtLimit.", ".$endLimit."");
			return $query->result_array();
		}
	}
	
	function countTotalDocsByTable($tblName, $date) {
		if(!empty($date['begin_time']) and !empty($date['end_time'])) {
			$this->db->where("created >=", strtotime($date['begin_time']));
			$this->db->where("created <=", strtotime($date['end_time']));
		}
		return $this->db->count_all_results($tblName);
	}
	
	function countByUsername($tblName, $date) {
		$cond = "";
		if(!empty($date['begin_time']) and !empty($date['end_time'])) { //print_r($date);exit;
			$cond = "where created between ".strtotime($date['begin_time'])." and ".strtotime($date['end_time'])."";
		}
		$query = $this->db->query("SELECT  user_id, COUNT(*) as total FROM ".$tblName." ".$cond." group by user_id");
		return $query->result_array();
	}
	function getUsernames() {
		$this->db->select("username");
		$this->db->from("accounts");
		return $this->db->get()->result_array();
	}
	function getGroups() {
		$this->db->select("id, name");
		return $this->db->get("groups")->result_array();
	}
	
	function getDocumentTableData($tblName, $date) {
		if($this->db->table_exists($tblName) == TRUE) {
			if(!empty($date['begin_time']) and !empty($date['end_time'])) {
				$from = strtotime($date['begin_time']);
				$to = strtotime($date['end_time']);
			} else {
				$from = strtotime('-5 day', time());
				$to = time();
			}
			$query = $this->db->query("select * from ".$tblName." where created between ".$from." and ".$to."");
			return $query->result_array();
		}
		return array();
	}
	
	function getUserLogs($date) {
		if(!empty($date)) {
			$from = strtotime($date['begin_time']);
			$to = strtotime($date['end_time']);
		} else {
			$from = strtotime('-5 day', time());
			$to = time();
		}
		$this->db->select("*");
		$this->db->where("date_time >=", $from);
		$this->db->where("date_time <=", $to);
		$this->db->order_by("date_time", "desc"); 
		return $this->db->get("user_histories")->result_array();
	}
		
	function getDocumentLogs($date) {
		if(!empty($date)) {
			$from = strtotime($date['begin_time']);
			$to = strtotime($date['end_time']);
		} else {
			$from = strtotime('-5 day', time());
			$to = time();
		}
		$this->db->select("*");
		$this->db->where("date_time >=", $from);
		$this->db->where("date_time <=", $to);
		$this->db->order_by("date_time", "desc"); 
		return $this->db->get("doc_histories")->result_array();
	}
}
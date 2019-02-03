<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |___________________
-- File: models/auth_model.php |
-- ----------------------------/
*/

class Auth_model extends CI_Model {
	
	function __construct()
	    {
	        parent::__construct();
	    }

	public function do_register($name, $username, $password, $email, $activate, $fb_id)
	{
		$data = array(
			'username' => $username,
			'password' => sha1($password),
			'name' => $name,
			'level' => $this->logik->setting('default_level'),
			'activate' => $activate,
			'email' => $email,
			'date_joined' => time(),
			'fb_id' => $fb_id,
			'oauth_token' => '0',
			'oauth_token_secret' => '0',
			'reset_password' => '0'
			);

		if(!$this->db->insert('accounts', $data))
		{
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function do_register_tw($name, $username, $password, $email, $activate, $token, $token_secret)
	{
		$data = array(
			'username' => $username,
			'password' => sha1($password),
			'name' => $name,
			'level' => $this->logik->setting('default_level'),
			'activate' => $activate,
			'email' => $email,
			'date_joined' => time(),
			'fb_id' => '0',
			'oauth_token' => $token,
			'oauth_token_secret' => $token_secret
			);

		if(!$this->db->insert('accounts', $data))
		{
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function save_hit($p_id, $is_user)
	{
		$data = array(
			'p_id' => $p_id,
			'is_user' => $is_user,
			'date' => time()
			);
		$this->db->insert('hits', $data);
	}

	public function user_by_fb_id($id)
	{
		$this->db->where('fb_id', $id);
		return $this->db->get('accounts')->row();
	}

	public function check_twitter($token)
	{
		$this->db->where('oauth_token', $token);
		$query = $this->db->get('accounts');

		if($query->num_rows == 1)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function info_by_twitter($token)
	{
		$this->db->where('oauth_token', $token);
		return $this->db->get('accounts')->row();
	}

	public function check_fb_id($id)
	{
		$this->db->where('fb_id', $id);
		$query = $this->db->get('accounts');

		if($query->num_rows == 1)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_level($level)
	{
		$this->db->where('id', $level);
		return $this->db->get('levels')->row();
	}

	public function save_login($username)
	{
		$data = array('username' => $username, 'date' => time());
		$this->db->insert('login', $data);
	}
	function checkLoginError($bannedValue, $bannedTime) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$this->db->where("ipaddress", $ip);
		$data=$this->db->get('login')->row_array();
		if(!empty($data)) {
			$time = time() - $data["time"];
			$bandtime = 0;
			if(!empty($bannedTime)) {
				$bannedTime = explode(':', $bannedTime);
				$bandtime = $bannedTime[0]*3600+$bannedTime[1]*60+$bannedTime[2];
			}
			if($time<$bandtime and $data["count"]>=$bannedValue) {
				return true;
			}
		}
		return false;
	}
	
    public function clear_error_count($ip, $username)
	{
		$this->db->where("ipaddress", $ip);
		$this->db->where("username", $username);
		$this->db->delete('login');
	}
	
	public function get_error_count($username, $ip, $bannedTime)
	{ 
		$this->db->where("ipaddress", $ip);
		$this->db->where("username", $username);
		$this->db->order_by("date", "desc");
		$data=$this->db->get('login')->row_array();
		if(!empty($data)) {
			$time = time() - $data["time"];
			$bandtime = 0;
			if(!empty($bannedTime)) {
				$bannedTime = explode(':', $bannedTime);
				$bandtime = $bannedTime[0]*3600+$bannedTime[1]*60+$bannedTime[2];
			}
			if($time>$bandtime) {
				$this->clear_error_count($ip, $username);
				$new_count = 1;
			} else {
				$new_count = $data["count"]+1;
			}
		} else {
			$new_count = 1;
		}
		
		$insert=array("ipaddress"=>$ip, "count"=>$new_count, "time"=>time());
		if($new_count!=1)
		{
			$this->db->where("username", $username);
			$this->db->where("ipaddress", $ip);
			$this->db->update('login', $insert);
		}
		else
		{
			$insert = array_merge($insert, array("username"=>$username));
			$this->db->insert("login", $insert);
		}
		return $new_count;
		
	}
	public function getBandAttempt() {
		$this->db->select("value");
		$this->db->from("settings");
		$this->db->or_where("setting", "banned_attempt");
		$this->db->or_where("setting", "time_banned");
		return $this->db->get()->result_array();
	}
	
	public function get_user()
	{
		$this->db->where('username', $this->session->userdata('username'));
		return $this->db->get('accounts')->row();
	}

	public function get_user_username($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('accounts')->row();
	}

	public function do_login($username, $password)
	{
		//$this->db->where('username', $username);
		//$this->db->where('password', sha1($password));
		//$query = $this->db->get('accounts');
		$query = $this->db->query("select username, activate from accounts where BINARY username='".$username."' and password='".sha1($password)."'");
		if($query->num_rows != 1)
		{
			$this->db->where('current', 1);
			$ldapconfig = $this->db->get("ldap_config")->row_array();
			
			//$ldapconfig['host'] = "srvpzobdc01.scaronigu.com";
			//$ldapconfig['port'] = 389;
			//$ldapconfig['basedn'] = "uid=".$username.",dc=scaronigu,dc=com";
			//$ldapconfig['binddn'] = "uid=".$username.",ou=People,o=ucalgary.ca"; //for perticular user id
			//$ldapconfig['bindpw'] = $password;
			$ds=ldap_connect($ldapconfig['hostname'], $ldapconfig['portname']);
			if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
				return NULL;
			}
			$query = $this->db->query("select username, activate from accounts where BINARY username='".$username."'");
			//if(substr_count($username, "@scaronigu.com")!=1) { open comment if you want to login with username ad user@scaronigu.com 
				$username .= "@scaronigu.com";
			//}
			
			if($query->num_rows != 0 and $query->row()->activate != 1) {
			//if($query->row()->activate != 1) {
				return 3;
			}
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			$bnd = ldap_bind($ds, $username, $password);
			if($bnd) {
				return 1;
			}
			return 2;
		} else {
			if($query->row()->activate == 1) {
				return 1;
			} else {
				return 3;
			}
		}
	}
	
	public function ldap_authenticate($user, $pass) {
		$ldapconfig['host'] = "srvpzobdc01.scaronigu.com";
		$ldapconfig['port'] = 389;
		$ldapconfig['basedn'] = "dc=scaronigu,dc=com";
		//$ldapconfig['binddn'] = "uid=1341c5e5faa07b0b,ou=People,o=ucalgary.ca"; for perticular user id
		$ldapconfig['binddn'] = "dc=scaronigu,dc=com";
		$ldapconfig['bindpw'] = "digitalizacion";
		//$dn = "OU=linuxsolutions,";
		//ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

		if ($user != "" && $pass != "") {
			$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
			if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
				return NULL;
			}
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			
			$bnd = ldap_bind($ds, $ldapconfig['binddn'], $ldapconfig['bindpw']);
			print_r($bnd);
			exit;
			$r = ldap_search($ds, $ldapconfig['binddn'], "(givenname=*)");
			print_r($result[0]);
			exit;
			if($r) {
				$result = ldap_get_entries( $ds, $r);
			
				$maxRec = count($result) - 2;
			
				$data = array();
				if($maxRec>=0) {
					for($i=0; $i<=$maxRec; $i++) {
						if(!empty($result[$i]['uid'][0])) {
							$this->db->where("username", $result[$i]['uid'][0]);
							$res = $this->db->get("accounts")->row_array();
							if(!empty($res)) {
								$data['username'] = $result[$i]['uid'][0];
								if(!empty($result[$i]['mail'][0])) {
									$data['email'] = $result[$i]['mail'][0];
								}
								if(!empty($result[$i]['givenname'][0])) {
									$data['name'] = $result[$i]['givenname'][0];
								}
								if(!empty($result[$i]['telephonenumber'][0])) {
									$data['telephone'] = $result[$i]['telephonenumber-'][0];
								}
								$data['activate'] = 0;
								$data['date_joined'] = time();
								$data['level'] = 2;
								$this->db->insert("accounts", $data);
							}
						}
					}
					/*if (ldap_bind( $ds, $result[0]['dn'], $pass) ) {
						return $result[0]['mail'][0];
					} for test password*/ 
				}
			}
		}
		//	return NULL;
	}

	public function user_by_email($email)
	{
		$this->db->where('email', $email);
		return $this->db->get('accounts')->row();
	}

	public function do_activate($activate)
	{
		$this->db->where('activate', $activate);
		$query = $this->db->get('accounts');

		if($query->num_rows < 1)
		{
			return FALSE;
		} else {
			$this->db->where('activate', $activate);
			$this->db->update('accounts', array('activate' => '0'));
		}
	}
	
	public function getGroupNameById($groupId) {
		if(!empty($groupId)) {
			$this->db->select("name");
			$this->db->from("groups");
			$this->db->where('id', $groupId);
			$group = $this->db->get()->row();
			if(isset($group->name)) {
				return $group->name;
			}
		}
	}
	
	public function getUserGroupsByUsername($username) {
		if(!empty($username)) {
			$this->db->select("groups");
			$this->db->from("accounts");
			$this->db->where('username', $username);
			return $this->db->get()->row();
		}
	}
	
	public function saveUserHistory($action, $docId='', $tblName='') {
		$data['user_id'] = $this->session->userdata("username");
		$data['action'] = $action;
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$macAddr = '';
		#run the external command, break output into lines
		$arp = 'arp -a '.$ipAddress;
		$lines = explode("\n", $arp);
		#look for the output line describing our IP address
		foreach($lines as $line) {
		   $cols=preg_split('/\s+/', trim($line));
		   if ($cols[0]==$ipAddress) {
			   $macAddr = $cols[1];
		   }
		}
		$data['ip_address'] = $ipAddress;
		$data['mac_address'] = $macAddr;
		$data['document_id'] = $docId;
		$data['table_name'] = $tblName;
		$data['date_time'] = time();
		$this->db->insert("user_histories", $data);
	}
	
	public function saveDocumentHistory($action, $docId='', $tblName='') {
		$data['user_id'] = $this->session->userdata("username");
		$data['action'] = $action;
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$macAddr = '';
		#run the external command, break output into lines
		$arp = 'arp -a '.$ipAddress;
		$lines = explode("\n", $arp);
		#look for the output line describing our IP address
		foreach($lines as $line) {
		   $cols=preg_split('/\s+/', trim($line));
		   if ($cols[0]==$ipAddress) {
			   $macAddr = $cols[1];
		   }
		}
		$data['ip_address'] = $ipAddress;
		$data['mac_address'] = $macAddr;
		$data['document_id'] = $docId;
		$data['table_name'] = $tblName;
		$data['date_time'] = time();
		$this->db->insert("doc_histories", $data);
	}
}
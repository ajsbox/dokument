<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/group.php|
-- ---------------------------/
*/

class Group extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
	    if(!$this->session->userdata("username") or $this->auth_model->get_user()->level != '1')
	    {
	    	redirect($this->logik->setting('default_url'));
	    }
	    $this->load->model('group_model');
	}

	public function index()
	{
		
		$page_number = $this->input->post('page_number');
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$where = "";
		if($this->input->post('search')!='') {
			$where = "where name like '%".$this->input->post('search')."%' or owner like '%".$this->input->post('search')."%'";
		}
		$result_set = $this->db->query("SELECT id,name,owner, FROM_UNIXTIME(create_date, '%d-%m-%Y')as create_date FROM groups ".$where." order by id desc LIMIT ".$position.",".$item_par_page);
		
        $total_set =  $result_set->num_rows();
		if($this->input->post('search')!='') {
			$result_set1 = $this->db->query("SELECT id,name,owner, FROM_UNIXTIME(create_date, '%d-%m-%Y')as create_date FROM groups ".$where." order by id desc");
			$page =  $result_set1;
			$total =  $result_set1->num_rows();
		} else {
			$page =  $this->db->get('groups') ;
			$total =  $page->num_rows();
		}
        //break total recoed into pages
        $total = ceil($total/$item_par_page);
        if($total_set>0) {
			$entries = null;
	// get data and store in a json array
			foreach($result_set->result() as $row) {
				$entries[] = $row;
			}
			$data = array(
				'TotalRows' => $total,
				'Rows' => $entries
			);              
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
        exit;
	}

	public function manage()
	{
		/*$config['base_url'] = $this->logik->setting('default_url').'group/manage/';
	    $config['total_rows'] = $this->db->get('groups')->num_rows();
	    $config['per_page'] = '3';
		$config['use_page_numbers']  = TRUE;
		$config['uri_segment']       = 3;
	    $config['full_tag_open'] = '<div class="pagination"><ul>';
	    $config['full_tag_close'] = '</ul></div>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$page = $this->uri->segment(3);
		if(!empty($page)) {
			$page = $page-1;
		} else {
			$page = 0;
		}
		$this->pagination->initialize($config);
        $js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/document");
        array_push($this->setting_model->external_js,$js_path."js/activate");
		$data = array('groups' => $this->group_model->get_groups((($page) * $config['per_page']),$config['per_page']), 'tmp' => 'group/manage_groups');
		$this->load->view('tmp', $data);*/
		$this->load->view('tmp', array('tmp' => 'group/manage_groups'));
	}
	
	public function add() {
		$error = '';
		if($this->input->post('add_group')) {
			$this->form_validation->set_rules('name', 'Group Name', 'trim|required|is_unique[groups.name]');
			//$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
			if($this->form_validation->run() === TRUE) {
				array_pop($_POST);
				$this->group_model->addGroup($this->input->post());
				$this->auth_model->saveUserHistory($_POST['name'].$this->lang->line("history_group_added"));
				redirect($this->logik->setting('default_url').'group/manage');
			} elseif(!isset($_POST['roles'])) {
				//$error = "Please select at least one roles !";
			}
		}
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$this->load->view('tmp', array('roles' => $this->group_model->getRols(), 'parentGroups'=>$this->group_model->getParentGroups(), 'tmp' => 'group/add_group', 'error'=>$error));
	}
	
	public function edit() { //print_r($this->group_model->getGroupById($this->uri->segment(3)));exit; 
		$error = '';
		if($this->input->post('edit_group')) {
			$this->form_validation->set_rules('name', 'Group Name', 'trim|required');
			//$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
			if($this->form_validation->run() === TRUE) {
				array_pop($_POST);
				$this->group_model->editGroup($this->input->post());
				$this->auth_model->saveUserHistory($_POST['name'].$this->lang->line("history_group_update"));
				redirect($this->logik->setting('default_url').'group/manage');
			} elseif(!isset($_POST['roles'])) {
				//$error = "Please select at least one roles !";
			}
		}

		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		
		$this->load->view('tmp', array('roles' => $this->group_model->getRols(), 'group' => $this->group_model->getGroupById($this->uri->segment(3)), 'parentGroups'=>$this->group_model->getParentGroups(), 'tmp' => 'group/edit_group', 'error'=>$error));
	}
	
	public function add_ldap_groups() {
		$this->db->where('current', 1);
		$ldapconfig = $this->db->get("ldap_config")->row_array();
		//print_r($res);exit;
		$update = '';
		$countRec = '';
		if(!empty($ldapconfig)) {
			//$ldapconfig['host'] = $res['hostname'];
			//$ldapconfig['port'] = $res['portname'];
			//$ldapconfig['basedn'] = $res['data_structure'];
			
			//$ldapconfig['binddn'] = "uid=1341c5e5faa07b0b,ou=People,o=ucalgary.ca"; for perticular user id
			//$ldapconfig['binddn'] = $res['username']; // o=scaronigu.com
			//$ldapconfig['bindpw'] = $res['password'];
			//$dn = "OU=linuxsolutions,";
			//ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
			$ds=ldap_connect($ldapconfig['hostname'], $ldapconfig['portname']);
		
			$attributes = explode(',', $ldapconfig['group_attributes']);
			
			if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
				return NULL;
			}
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			
			$bnd = ldap_bind($ds, $ldapconfig['bind_user'], $ldapconfig['bind_password']);
			//print_r($bnd);
			//exit;
			$r = ldap_search($ds, $ldapconfig['base_group_dn'], $ldapconfig['group_filter']);  
			 /* By Alfonso -- Allow to get all entries */
			if($r) {
				$result = ldap_get_entries( $ds, $r);
				$maxRec = count($result) - 2;
				$countRec = 0;
				$data = array();
				if($maxRec>=0) {
					for($i=0; $i<=$maxRec; $i++) {
						if(!empty($attributes[0]) && !empty($result[$i][$attributes[0]][0])) {
							$this->db->where("name", $result[$i][$attributes[0]][0]);
							$res = $this->db->get("groups")->row_array();
							if(empty($res)) {
								$data['name'] = $result[$i][$attributes[0]][0];
								$data['activate'] = 1;
								$data['create_date'] = time();
								$data['owner'] = $this->session->userdata("username");
								$data['is_ldap'] = "LDAP";
								$this->db->insert("groups", $data);
								$countRec++;
							}
						}
					}
					/*if (ldap_bind( $ds, $result[0]['dn'], $pass) ) {
						return $result[0]['mail'][0];
					} for test password*/ 
				}
				if($countRec!=0) {
					$this->auth_model->saveUserHistory($countRec.$this->lang->line("history_ldap_group_add"));
				}
				//echo "<script> alert('users registered from LDAP')</script>";
			} else {
				$update = 'bind';
			}
		} else {
			$update = 'config';
		}
		
		
		$config['base_url'] = $this->logik->setting('default_url').'group/manage/';
	    $config['total_rows'] = $this->db->get('groups')->num_rows();
	    $config['per_page'] = '3';
		$config['use_page_numbers']  = TRUE;
		$config['uri_segment']       = 3;
	    $config['full_tag_open'] = '<div class="pagination"><ul>';
	    $config['full_tag_close'] = '</ul></div>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$page = $this->uri->segment(3);
		if(!empty($page)) {
			$page = $page-1;
		} else {
			$page = 0;
		}
		$this->pagination->initialize($config);

		$js_path = $this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/document");
        array_push($this->setting_model->external_js,$js_path."js/activate");
		$data = array('groups' => $this->group_model->get_groups((($page) * $config['per_page']),$config['per_page']), 'update'=>$update, 'tmp' => 'group/manage_groups');
		$this->load->view('tmp', $data);

	}
	
	public function delete() {
		if(!empty($_POST['group_id'])) {
			$delId = $this->group_model->deleteGroup($_POST['group_id']);
			$this->auth_model->saveUserHistory($this->lang->line("history_group_deleted"));
			echo $delId;
		}
	}
}
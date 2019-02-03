<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/admin.php|
-- ---------------------------/
*/

class Manage_users extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
	    if(!$this->session->userdata("username") or $this->auth_model->get_user()->level != '1')
	    {
	    	redirect($this->logik->setting('default_url'));
	    }
	    $this->load->model('manage_user_model');
		$this->load->model('group_model');
	}

	public function index()
	{
  		$page_number = $this->input->post('page_number');
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$where = "where";
		if($this->input->post('search')!='') {
			$where .= " (name like '%".$this->input->post('search')."%' or lname like '%".$this->input->post('search')."%' or username like '%".$this->input->post('search')."%' or email like '%".$this->input->post('search')."%')";
		} else {
			$where = "";
		}
		$result_set = $this->db->query("SELECT id,name, lname, username, email, is_ldap, FROM_UNIXTIME(date_joined, '%d-%m-%Y')as create_date,activate FROM accounts ".$where." order by level asc, id desc LIMIT ".$position.",".$item_par_page);
		
        $total_set =  $result_set->num_rows();
		if($this->input->post('search')!='') {
			//$this->db->where("level", 2);
			if($where=='where') {
				$where = '';
			}
			$result_set1 = $this->db->query("SELECT id,name, lname, username, email, is_ldap, FROM_UNIXTIME(date_joined, '%d-%m-%Y')as create_date,activate FROM accounts ".$where." order by level asc, id desc");
			$page =  $result_set1;
			$total =  $result_set1->num_rows();
		} else {
			//$this->db->where("level", 2);
			$page =  $this->db->get('accounts') ;
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

	public function manage_user()
	{
		/*$config['base_url'] = $this->logik->setting('default_url').'manage_users/manage_user/';
		$this->db->where("level", 2);
	    $config['total_rows'] = $this->db->get('accounts')->num_rows();
	    $config['per_page'] = '10';
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
        array_push($this->setting_model->external_js,$js_path."js/activate");
		$data = array('users' => $this->manage_user_model->get_users((($page) * $config['per_page']),$config['per_page']), 'password_length'=>$this->manage_user_model->getPasswordSetting(), 'tmp' => 'manage_users/manage_users');
		$this->load->view('tmp', $data);*/
		
		//$data = array('tmp' => 'manage_users/manage_users');
		$this->load->view('tmp', array('tmp' => 'manage_users/manage_users'));
	}
	
	public function edit_user()
	{
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$data = array('roles' => $this->group_model->getRols(), 'user' => $this->manage_user_model->get_user( $this->uri->segment(3)), 'groups'=>$this->manage_user_model->getGroups(), 'password_length'=>$this->manage_user_model->getPasswordSetting(), 'tmp' => 'manage_users/edit_user');
		$this->load->view('tmp', $data);
	}

	public function edit_in()
	{
		array_pop($_POST);
		if($_FILES['file']['error']==0){ 
			$config['upload_path'] = './image_gallery/user';
			$config['allowed_types'] = 'gif|jpg|png|doc|pdf';
			$config['max_size'] = '10000';
			//$config['max_width']  = '1366';
			//$config['max_height']  = '768';
			$config['width'] = 75;
			$config['height'] = 50;
			
			$this->load->library('upload', $config);
			$this->load->library('image_lib',$config);
			$this->image_lib->resize();
			
			if ( ! $this->upload->do_upload('file')) {
			   $error1 = $this->upload->display_errors();
			   $this->data['error'] = $error1; //print_r($error1); die;
			} else {
			   $this->load->helper("file"); //$path='';
			  
			   $data = array('upload_data' => $this->upload->data());
			  
			   $file_name = $data['upload_data']['file_name']; // print_r($file_name);die; 
			}
			unlink("./image_gallery/user".$_POST['image']);
			$_POST['image'] = $file_name;
    	}
		$roles = array();
		foreach($_POST['groups'] as $key=>$grp) {
			$roles[$grp] = $_POST['roles'.$grp];
			unset($_POST['roles'.$grp]);
		}
		$allGroups = $this->manage_user_model->getGroups();
		foreach($allGroups as $key=>$grps) {
			if(isset($_POST['roles'.$grps->id])) {
				unset($_POST['roles'.$grps->id]);
			}
		}
		
		if(in_array(1, $_POST['groups'])) {
			$_POST['level'] = 1;
		} else {
			$_POST['level'] = 2;
		}
				
		$_POST['groups'] = implode(",", $_POST['groups']);
		$_POST['roles'] = serialize($roles);

		//$_POST['document_groups']=implode(",",$_POST['document_groups']);
		$_POST['calender']= time();
		if(!empty($_POST['password'])) {
			$_POST['password'] = sha1($_POST['password']);
		} else {
			unset($_POST['password']);
		}
		$this->manage_user_model->edit_insert($_POST);
		$this->auth_model->saveUserHistory($this->lang->line("history_user_update"));
		redirect(base_url().'manage_users/manage_user');	
		
	}
	
	public function add_user()
	{
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$data = array('roles' => $this->group_model->getRols(), 'user' => $this->manage_user_model->get_user( $this->uri->segment(3)),'groups'=>$this->manage_user_model->getGroups(), 'password_length'=>$this->manage_user_model->getPasswordSetting(), 'tmp' => 'manage_users/add_user');
		$this->load->view('tmp', $data);		
		
	}
	
	public function add_user_in() {
		$file_name ='';
		$submit = $this->input->post('submit');
		if($submit === FALSE)
		{
			$data = array('roles' => $this->group_model->getRols(), 'user' => $this->manage_user_model->get_user( $this->uri->segment(3)),'groups'=>$this->manage_user_model->getGroups(), 'password_length'=>$this->manage_user_model->getPasswordSetting(), 'tmp' => 'manage_users/add_user');
			$this->load->view('tmp', $data);
		} else {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[20]|is_unique[accounts.username]');
			$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[20]');
			$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|max_length[20]');			
			$this->form_validation->set_rules('email', 'E-mail', 'trim|required');

			if($this->form_validation->run() === FALSE) {
				$data = array('roles' => $this->group_model->getRols(), 'user' => $this->manage_user_model->get_user( $this->uri->segment(3)),'groups'=>$this->manage_user_model->getGroups(), 'password_length'=>$this->manage_user_model->getPasswordSetting(), 'tmp' => 'manage_users/add_user');
				$this->load->view('tmp', $data);
			} else {
				if($_FILES['file']['error']==0) { 
					$config['upload_path'] = './image_gallery/user';
					$config['allowed_types'] = 'gif|jpg|png|doc|pdf';
					$config['max_size'] = '10000';
					//$config['max_width']  = '1366';
					//$config['max_height']  = '768';
					$config['width'] = 75;
					$config['height'] = 50;
					
					$this->load->library('upload', $config);
					$this->load->library('image_lib',$config);
					$this->image_lib->resize();   
				
					if ( ! $this->upload->do_upload('file')) {
					   $error1 = $this->upload->display_errors();
					   $this->data['error'] = $error1; //print_r($error1); die;
					} else {
					   $this->load->helper("file"); //$path='';
					  
					   $data = array('upload_data' => $this->upload->data());
					  
					   $file_name = $data['upload_data']['file_name']; // print_r($file_name);die; 
					}
				}
			
				array_pop($_POST);
				extract($_POST);
				$email_password=$_POST['password'];
				$_POST['password'] = sha1($_POST['password']);
				//$_POST['calender'] = strtotime($_POST['calender']);
				$_POST['image'] = $file_name;
				//$_POST['level'] = 2;
				//$_POST['activate']=$_POST['activate'];
				$roles = array();
				foreach($_POST['groups'] as $key=>$grp) {
					$roles[$grp] = $_POST['roles'.$grp];
					unset($_POST['roles'.$grp]);
				}
				$allGroups = $this->manage_user_model->getGroups();
				foreach($allGroups as $key=>$grps) {
					if(isset($_POST['roles'.$grps->id])) {
						unset($_POST['roles'.$grps->id]);
					}
				}
				if(in_array(1, $_POST['groups'])) {
					$_POST['level'] = 1;
				} else {
					$_POST['level'] = 2;
				}
				$_POST['groups'] = implode(",", $_POST['groups']);
				$_POST['roles'] = serialize($roles);

				//$_POST['document_groups']=implode(",",$_POST['document_groups']);
				$this->manage_user_model->add_user_in($_POST);
				$this->logik->send_email($email,"welcome",$email_password);
				$this->auth_model->saveUserHistory($this->lang->line("history_user_create"));
				redirect(base_url().'manage_users/manage_user');
			}
		}
	}
	
	public function add_ldap_users() {
		$this->db->where('current', 1);
		$ldapconfig = $this->db->get("ldap_config")->row_array();
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
		
			$attributes = explode(',', $ldapconfig['attributes']);
			
			if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
				return NULL;
			}
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			
			$bnd = ldap_bind($ds, $ldapconfig['bind_user'], $ldapconfig['bind_password']);
			//print_r($bnd);
			//exit;
			$r = ldap_search($ds, $ldapconfig['base_dn'], $ldapconfig['filter']);  
			 /* By Alfonso -- Allow to get all entries */
			
			if($r) {
				$result = ldap_get_entries( $ds, $r);
				$maxRec = count($result) - 2;
				$countRec = 0;
				$data = array();
				if($maxRec>=0) {
					for($i=0; $i<=$maxRec; $i++) {
						if(!empty($attributes[0]) && !empty($result[$i][$attributes[0]][0])) {
							$this->db->where("username", $result[$i][$attributes[0]][0]);
							$res = $this->db->get("accounts")->row_array();
							if(empty($res)) {
								if(!empty($attributes[0]) and !empty($result[$i][$attributes[0]][0])) {
									$data['name'] = $result[$i][$attributes[0]][0];
								}
								if(!empty($attributes[1]) and !empty($result[$i][$attributes[1]][0])) {
									$data['username'] = $result[$i][$attributes[1]][0];
								}
								if(!empty($attributes[2]) and !empty($result[$i][$attributes[2]][0])) {
									$data['email'] = $result[$i][$attributes[2]][0];
								}
								if(!empty($attributes[3]) and !empty($result[$i][$attributes[3]][0])) {
									$data['telephone'] = $result[$i][$attributes[3]][0];
								}
								$data['activate'] = 0;
								$data['date_joined'] = time();
								$data['level'] = 2;
								$data['is_ldap'] = "LDAP";
								$this->db->insert("accounts", $data);
								$countRec++;
							}
						}
					}
					/*if (ldap_bind( $ds, $result[0]['dn'], $pass) ) {
						return $result[0]['mail'][0];
					} for test password*/ 
				}
				if($countRec!=0) {
					$this->auth_model->saveUserHistory($this->lang->line("history_ldap_user_add_first").$countRec.$this->lang->line("history_ldap_user_add_last"));
				}
				//echo "<script> alert('users registered from LDAP')</script>";
			} else {
				$update = 'bind';
			}
		} else {
			$update = 'config';
		}

		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/activate");
		$data = array('password_length'=>$this->manage_user_model->getPasswordSetting(), 'countUsers'=>$countRec, 'update'=>$update, 'tmp' => 'manage_users/manage_users');
		$this->load->view('tmp', $data);
	}
	
	public function delete()
	{
		//$id=$this->uri->segment(3);
		$id = $this->input->post('del_id');
		$this->manage_user_model->delete($id);	
		$this->auth_model->saveUserHistory($this->lang->line("history_user_deleted"));
		echo $id;exit;
		//redirect(base_url().'manage_users/manage_user');
	}
	
	////dhiru 7-05-14/////
	public function isUniqueUsername() {
		if(!empty($_POST)) {
			$isUnique = $this->manage_user_model->checkUniqueUsername($_POST);
			echo $isUnique;
		}
	}
}
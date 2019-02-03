<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/user.php |
-- ---------------------------/
*/

class document extends CI_Controller {

	//Will hold our user data.
	private $user;

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
	    if($this->auth_model->get_user()->level!= '1')
	    {
	    	redirect($this->logik->setting('default_url'));
	    }
		$this->load->model("document_model");
	}
	
   public function create_form()
	{
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/base");
		array_push($this->setting_model->external_js,$js_path."js/machform");
		array_push($this->setting_model->external_style,$js_path."css/index");
		$data_form=$this->document_model->get_document($this->uri->segment(3));
		$doc_id=count($data_form);
		$this->load->view("tmp",array("tmp"=>"document/create_form","document"=>$data_form,"document_id"=>$doc_id));
	}
	 
   public function update_form()
   {
	    $id_of_form_string=json_decode($this->input->post('form'),true);
		$id_of_form=$id_of_form_string["id"];
		$value_form=$this->input->post('form');
		$value_form=str_replace("\\", "", $value_form);
		$value_ele=$this->input->post('elements');
		$value_ele=str_replace("\\", "", $value_ele);
		$data["form_data"]=$this->db->escape_like_str($value_form);
		$data["elements"]=$this->db->escape_like_str($value_ele);
		$data["publish"]="1";
	    $this->document_model->update_form($id_of_form,$data);
   }
   
   
   public function index()
	{ 
	
  		$page_number = $this->input->post('page_number');
		
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$where="";
		if($this->input->post('search')!='') {
			$where .= " where name like '%".$this->input->post('search')."%'";
		}
		//$result_set = $this->db->query("SELECT *  FROM_UNIXTIME(create_date, '%d, %M %Y')as create_date,FROM doc_types ".$where." order by id desc LIMIT ".$position.",".$item_par_page);
		$result_set = $this->db->query("SELECT id,name, owner, groups,table_name, form_data, publish, FROM_UNIXTIME(create_date, '%d-%m-%Y')as create_date,activate FROM doc_types ".$where." order by id desc LIMIT ".$position.",".$item_par_page);
		
        $total_set =  $result_set->num_rows();
		if($this->input->post('search')!='') {
			$result_set1 = $this->db->query("SELECT id,name, owner, groups,table_name, form_data, publish, FROM_UNIXTIME(create_date, '%d-%m-%Y')as create_date,activate FROM doc_types ".$where." order by id desc");
			$page =  $result_set1;
			$total =  $result_set1->num_rows();
		} else {
			
			$page =  $this->db->get('doc_types') ;
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
		/*$config['base_url'] = $this->logik->setting('default_url').'document/manage/';
	    $config['total_rows'] = $this->db->get('doc_types')->num_rows();
	    $config['per_page'] = '10';
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
		$this->pagination->initialize($config);*/
       /* $js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/document");
        array_push($this->setting_model->external_js,$js_path."js/activate");
		$data = array('docs' => $this->document_model->getDocuments(), 'tmp' => 'document/manage_doc');
		$this->load->view('tmp', $data);*/
		
		$this->load->view('tmp', array('tmp' => 'document/manage_doc'));
	}
	
	public function add() {
		$error = '';
		if($this->input->post('add_doc')) {
			$this->form_validation->set_rules('name', 'Document Name', 'trim|required');
			//$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
			if($this->form_validation->run() === TRUE and isset($_POST['groups'])) {
				array_pop($_POST);
				$this->document_model->addDocument($this->input->post());
				$this->auth_model->saveDocumentHistory($this->lang->line("history_doc_create"));
				redirect($this->logik->setting('default_url').'document/manage');
			} elseif(!isset($_POST['groups'])) {
				$error = "Please select at least one group !";
			}
		}
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$this->load->view('tmp', array('groups' => $this->document_model->getGroups(), 'tmp' => 'document/add_doc', 'error'=>$error));
	}
	
	public function edit() { //print_r($this->group_model->getGroupById($this->uri->segment(3)));exit;
		$error = '';
		if($this->input->post('edit_doc')) {
			$this->form_validation->set_rules('name', 'Document Name', 'trim|required');
			//$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
			if($this->form_validation->run() === TRUE and isset($_POST['groups'])) {
				array_pop($_POST);
				$this->document_model->editDocument($this->input->post());
				$this->auth_model->saveDocumentHistory($this->lang->line("history_doc_update"));
				redirect($this->logik->setting('default_url').'document/manage');
			} elseif(!isset($_POST['groups'])) {
				$error = "Please select at least one groups !";
			}
		}
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$this->load->view('tmp', array('groups' => $this->document_model->getGroups(), 'docs' => $this->document_model->getDocumentById($this->uri->segment(3)), 'tmp' => 'document/edit_doc', 'error'=>$error));
	}
	
	public function publish() {
		if($this->uri->segment(3)) {
			$documents = $this->document_model->getDocumentById($this->uri->segment(3));
			$value_ele = str_replace("\\", "", $documents->elements);
			$data = json_decode($value_ele);
			if(!empty($data->elements)) {
				$this->document_model->createTable($data->elements, $documents->name, $documents->id);
				$this->auth_model->saveDocumentHistory($this->lang->line("history_doc_publish"));
				$this->session->set_flashdata('message', 'Document Published');
			}
		}
		redirect($this->logik->setting('default_url').'document/manage');
	}
	
	public function delete() {
		if(!empty($_POST['del_id'])) {	
		//print_r($_POST['del_id']);die;	
			$this->auth_model->saveDocumentHistory($this->lang->line("history_doc_delete"));
			$delId = $this->document_model->deleteDocument($_POST['del_id']);
			echo $delId;
		}
	}

	public function dbconnection() {
		if(isset($_POST['db_con'])) { 
			$this->form_validation->set_rules('hostname', 'Host Name', 'trim|required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('dbname', 'Database Name', 'trim|required');
			if($this->form_validation->run() === TRUE) {
				array_pop($_POST);
				$this->document_model->addDbInfo($this->input->post());
				//$con = mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password'])or die(mysql_error());
				$con = mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password'])or die(mysql_error());
				$db = mysql_select_db($_POST["dbname"])or die(mysql_error());
				$this->load->view('tmp', array('tmp' => 'document/get_connection', 'data'=>$_POST, "ourTables"=>$this->db->list_tables()));
			} else {
				$this->load->view('tmp', array('tmp' => 'document/dbconnect'));
			}
		} else {
			$this->load->view('tmp', array('tmp' => 'document/dbconnect'));
		}
	}
	public function makeQuery() {
		$data = array();
		$columns = array();
		if(!empty($_POST)) {
			$con = mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password'])or die(mysql_error());
			$db = mysql_select_db($_POST["dbname"])or die(mysql_error());
			$query = mysql_query("".$_POST['query']."")or die(mysql_error());
			while($val = mysql_fetch_assoc($query)) {
				$data[] = $val;
				$columns = $val;
			}
			$columns  = array_keys($columns);
		}
		$this->load->view('tmp', array('tmp' => 'document/get_connection', 'data'=>$_POST, 'tableValues'=>$data, "columns"=>$columns, "ourTables"=>$this->db->list_tables()));
	}
	
	public function ldap_auth() {
		$isSave = false;
		$isConnect = 0;
		$isBind = 0;
		if(isset($_POST['check_network'])) {
			$ds=ldap_connect($_POST['hostname'], $_POST['portname']);
			if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
				return NULL;
			}
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			$r = @ldap_bind($ds);
			if($r) {
				$isConnect = 1;
			} else {
				$isConnect = 2;
			}
		}
		if(isset($_POST['authentication'])) {
			$ds=ldap_connect($_POST['hostname'], $_POST['portname']) or die("Could not connect to ".$_POST['hostname']);
			if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
				return NULL;
			}
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			if($ds) {
				$bnd = ldap_bind($ds, $_POST['bind_user'], $_POST['bind_password']);
				if($bnd) {
					$isBind = 1;
				} else {
					$isBind = 2;
				}
			}
		}
		if(isset($_POST['create_config'])) {
			$this->form_validation->set_rules('hostname', $this->lang->line("admin_ldap_host"), 'trim|required');
			$this->form_validation->set_rules('portname', $this->lang->line("admin_ldap_port"), 'trim|required');
			$this->form_validation->set_rules('bind_user', $this->lang->line("admin_ldap_username"), 'trim|required');
			$this->form_validation->set_rules('bind_password', $this->lang->line("admin_ldap_password"), 'trim|required');
			if($this->form_validation->run() === TRUE) {
				$ds=ldap_connect($_POST['hostname'], $_POST['portname']) or die("Could not connect to ".$_POST['hostname']);
				if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
					return NULL;
				}
				ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
				if($ds) {
					$attributes = explode(',', $_POST['attributes']);
					$bnd = ldap_bind($ds, $_POST['bind_user'], $_POST['bind_password']);
					$r = ldap_search($ds, $_POST['base_dn'], $_POST['filter'], $attributes, 0, 0);
					$info = ldap_get_entries( $ds, $r);
					if(!empty($info['count'])) {
						array_pop($_POST);
						$isSave = $this->document_model->addLDAPInfo($this->input->post());
					} else {
						$isBind = 2;
					}
				}
			}
		}
		if($isSave) {
			$isConnect = false;
			$isBind = 0;
		}
		$ldapConfig = $this->document_model->getLDAPConfig();
		$this->load->view('tmp', array('tmp' => 'document/ldap_connect', 'isSaved'=>$isSave, 'isConnect'=>$isConnect, 'isBind'=>$isBind, 'ldapConfig'=>$ldapConfig));
	}
}
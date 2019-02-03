<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/group.php|
-- ---------------------------/
*/

class External_users extends CI_Controller {

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
		 $this->load->model('manage_user_model');
		$this->load->model('external_user_model');
	}
	
	
	
	
	public function index() {
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/document");
        array_push($this->setting_model->external_js,$js_path."js/activate");
		//$data = array('users' => $this->external_user_model->get_users((($page) * $config['per_page']),$config['per_page']), 'tmp' => 'external_user/manage_external_users');
		//$this->load->view('tmp', $data);
		$page_number = $this->input->post('page_number');
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$where = "";
		if($this->input->post('search')!='') {
			$where .= " where name like '%".$this->input->post('search')."%' or email like '%".$this->input->post('search')."%' or description like '%".$this->input->post('search')."%'";
		}
		$result_set = $this->db->query("SELECT id, name, email, description, FROM_UNIXTIME(created, '%d-%m-%Y') as create_date FROM external_users ".$where." order by id desc LIMIT ".$position.",".$item_par_page);
		
        $total_set =  $result_set->num_rows();
		if($this->input->post('search')!='') {
			$result_set1 = $this->db->query("SELECT id, name, email, description, FROM_UNIXTIME(created, '%d-%m-%Y') as create_date FROM external_users ".$where." order by id desc");
			$page =  $result_set1;
			$total =  $result_set1->num_rows();
		} else {
			//$this->db->where("level", 2);
			$page =  $this->db->get('external_users') ;
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
	
	public function manage_users()
	{
		$data = array('tmp' => 'external_user/manage_external_users');
		$this->load->view('tmp', $data);
	}
	
	
	public function add_ex_users()
	{
		
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$data = array('tmp' => 'external_user/add_user');
		$this->load->view('tmp', $data);		
		
	}
	
	
/*	public function add_user_in() {
			
				$this->external_user_model->add_user_in($_POST);				
				redirect(base_url().'external_users/manage_users');
			
		
	}*/
	
	
	
	public function add_user_in() {
	
		$submit = $this->input->post('submit');
		if($submit === FALSE)
		{
			$data = array('tmp' => 'external_user/add_user');
		$this->load->view('tmp', $data);
		} else {
		
			$this->form_validation->set_rules('name', 'Name', 'trim|required');						
			$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');

			if($this->form_validation->run() === FALSE) {
			$data = array('tmp' => 'external_user/add_user');
		$this->load->view('tmp', $data);
			} else {
				
			
				array_pop($_POST);
				extract($_POST);

				//$_POST['document_groups']=implode(",",$_POST['document_groups']);
				$this->external_user_model->add_user_in($_POST);
				//$this->logik->send_email($email,"welcome",$email_password);
				//$this->auth_model->saveUserHistory($_POST['username'].$this->lang->line("history_user_create"));
				redirect(base_url().'external_users/manage_users');
			}
		}
	}	
	
	public function edit_user()
	{
		
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$data = array('user' => $this->external_user_model->get_user( $this->uri->segment(3)), 'tmp' => 'external_user/edit_user');
		$this->load->view('tmp', $data);		
		
	}
	
	
	
/*	public function edit_in()
	{
	
	
		
		$this->external_user_model->edit_insert($_POST);
		//$this->auth_model->saveUserHistory($_POST['username'].$this->lang->line("history_user_update"));
		redirect(base_url().'external_users/manage_users');	
		
	}*/
	
	
	
public function edit_in() {
	
	
	
		$submit = $this->input->post('submit');
		if($submit === FALSE)
		{
			
			$data = array('user' => $this->external_user_model->get_user($_POST['id']), 'tmp' => 'external_user/edit_user');
		$this->load->view('tmp', $data);
		} else {
		
			$this->form_validation->set_rules('name', 'Name', 'trim|required');						
			$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');

			if($this->form_validation->run() === FALSE) {
			$data = array('user' => $this->external_user_model->get_user($_POST['id']), 'tmp' => 'external_user/edit_user');
		$this->load->view('tmp', $data);
			} else {
				
			
				array_pop($_POST);
				extract($_POST);

				
				$this->external_user_model->edit_insert($_POST);				
				redirect(base_url().'external_users/manage_users');
			}
		}
	}
	
public function delete() {
	
		//if(!empty($_POST['user_id'])) {
			//$this->auth_model->saveDocumentHistory($this->lang->line("history_doc_delete"));
			$id = $this->input->post('user_id');
		$delId = $this->external_user_model->deleteUser($_POST['user_id']);
		$this->auth_model->saveUserHistory($this->lang->line("history_user_deleted"));
		//$delId = $this->external_user_model->deleteUser($_POST['user_id']);
		echo $delId;
		//}
	}
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/admin.php|
-- ---------------------------/
*/

class Roles extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
	    if(!$this->session->userdata("username") or $this->auth_model->get_user()->level != '1')
	    {
	    	redirect($this->logik->setting('default_url'));
	    }
	    $this->load->model('admin_model');
		$this->load->model('roles_model');
	}
	
	public function manage_roles()
	{
		if(isset($_GET['id'])) {
			$this->roles_model->delete_role($_GET['id']);
			redirect($this->logik->setting("default_url")."roles/manage_roles");
		}
		/*$config['base_url'] = $this->logik->setting('default_url').'roles/manage_roles/';
	    $config['total_rows'] = $this->db->get('roles')->num_rows();
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
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/activate");
		$data = array('roles' => $this->roles_model->get_roles(), 'tmp' => 'roles/manage_roles');
		$this->load->view('tmp', $data);
	}
	
	public function add_role()
	{
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$this->load->view('tmp', array('tmp' => 'roles/add_role'));
		
	}

	public function creaet_role()
	{	  
		if(!empty($_POST))
		{
			array_pop($_POST);
			$_POST['create_date']=time();
			$_POST['owner']=$this->session->userdata('username');
			$this->roles_model->addRole($_POST);
			redirect($this->logik->setting("default_url")."roles/manage_roles");
		}
	}
	
	public function edit_role()
	{
	   
	    $role_id=$this->uri->segment(3);
		if(!empty($_POST))
		{
	    array_pop($_POST);
		
	    $_POST['create_date']=time();
	    $_POST['owner']=$this->session->userdata('username');
		$this->db->where("id", $role_id);
		$this->db->update('roles', $_POST);
		redirect($this->logik->setting("default_url")."roles/manage_roles");
		}
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
	    $this->load->view('tmp', array('tmp' => 'roles/edit_role', "u"=>$this->roles_model->edit_role($role_id)));
	}
	
	

}

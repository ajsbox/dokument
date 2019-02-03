<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/admin.php|
-- ---------------------------/
*/

class Admin extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
	    if(!$this->session->userdata("username"))
	    {
	    	redirect($this->logik->setting('default_url'));
	    } else if($this->auth_model->get_user()->level != '1') {
			redirect($this->logik->setting('default_url'));
		}
	    $this->load->model('admin_model');
		
		/////for pagination//////
		$dirName = explode('/', $this->logik->setting("default_url"));
		$size = count($dirName)-2;
		include_once $_SERVER['DOCUMENT_ROOT'].'/'.$dirName[$size].'/assets/pagination.php';
	}

	public function index()
	{
		$this->load->view('tmp', array('tmp' => 'admin/index', 'latest' => $this->admin_model->get_latest_users(), 'graph' => $this->admin_home_graph()));
	}

	public function manage_users()
	{
		$config['base_url'] = $this->logik->setting('default_url').'admin/manage_users/';
	    $config['total_rows'] = $this->db->get('accounts')->num_rows();
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
	
		$this->pagination->initialize($config);

		$data = array('users' => $this->admin_model->get_users($config['per_page'], $this->uri->segment(3)), 'tmp' => 'admin/manage_users');
		$this->load->view('tmp', $data);
	}

	public function manage_menus()
	{
		$this->load->view('tmp', array('tmp' => 'admin/manage_menus'));
	}

	public function email_users()
	{
		$this->load->view('tmp', array('tmp' => 'admin/email_users'));
	}

	public function email_templates()
	{
		$this->load->view('tmp', array('tmp' => 'admin/email_templates'));
	}

	public function stats()
	{
		$this->load->view('tmp', array('tmp' => 'admin/stats', 'flot' => $this->graph_registrations(), 
			'flot_social' => $this->graph_registrations_social()));
	}

	public function admin_home_graph()
	{
		$send = array();

		$i = 6;
		while($i >= 0){
			$startTime = mktime(0, 0, 0, date('m'), date('d')-$i, date('Y'));     
			$endTime = mktime(23, 59, 59, date('m'), date('d')-$i, date('Y'));
			$data = $this->admin_model->total_users_date($startTime, $endTime);
			$new = array($startTime*1000, $data);
			$send[] = $new;
			$i--;
		}

		$return = "[";
		foreach($send as $s){
			$return .= "[".$s[0].",".$s[1]."], ";
		}
		$return .="]";
		return $return;
	}

	public function graph_registrations()
	{
		$send = array();

		$i = 30;
		while($i >= 0){
			$startTime = mktime(0, 0, 0, date('m'), date('d')-$i, date('Y'));     
			$endTime = mktime(23, 59, 59, date('m'), date('d')-$i, date('Y'));
			$data = $this->admin_model->total_users_date($startTime, $endTime);
			$new = array($startTime*1000, $data);
			$send[] = $new;
			$i--;
		}

		$return = "[";
		foreach($send as $s){
			$return .= "[".$s[0].",".$s[1]."], ";
		}
		$return .="]";
		return $return;
	}

	public function graph_registrations_social()
	{
		$send = array();

		$i = 30;
		while($i >= 0){
			$startTime = mktime(0, 0, 0, date('m'), date('d')-$i, date('Y'));     
			$endTime = mktime(23, 59, 59, date('m'), date('d')-$i, date('Y'));
			$data = $this->admin_model->total_users_date_social($startTime, $endTime);
			$new = array($startTime*1000, $data);
			$send[] = $new;
			$i--;
		}

		$return = "[";
		foreach($send as $s){
			$return .= "[".$s[0].",".$s[1]."], ";
		}
		$return .="]";
		return $return;
	}

	public function manage_modules()
	{
		$this->load->view('tmp', array('tmp' => 'admin/manage_modules'));
	}

	public function manage_tickets()
	{
		$config['base_url'] = $this->logik->setting('default_url').'admin/manage_tickets/';
	    $config['total_rows'] = $this->db->get('accounts')->num_rows();
	    $config['per_page'] = '15';
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
	
		$this->pagination->initialize($config);

		$this->load->model('support_model');
		$tickets = $this->support_model->get_open_tickets($config['per_page'], $this->uri->segment(3));
		$this->load->view('tmp', array('tmp' => 'support/manage', 'tickets' => $tickets));
	}

	public function edit_email_temp()
	{
		$temp = $this->admin_model->get_email_temp($this->input->post('tid'));

		if($temp->file_name != $this->input->post('e_file_name'))
		{
			unlink("./application/views/email/".$temp->file_name.".php");
			$file = "./application/views/email/".$this->input->post('e_file_name').".php";
			$content = html_entity_decode($this->input->post('e_temp_body'));
			file_put_contents($file, $content);
		} else {
			$file = "./application/views/email/".$this->input->post('e_file_name').".php";
			$content = html_entity_decode($this->input->post('e_temp_body'));
			file_put_contents($file, $content);
		}

		$this->admin_model->edit_email_temp($this->input->post('tid'), $this->input->post('e_temp_name'), $this->input->post('e_file_name'), $this->input->post('e_subject'));
		$this->session->set_flashdata('edit_temp', '1');
		redirect($this->logik->setting('default_url')."admin/email_templates");
	}

	public function new_email_temp()
	{
		$this->admin_model->add_email_temp($this->input->post('n_temp_name'), $this->input->post('n_file_name'), $this->input->post('n_subject'));

		$file = "./application/views/email/".$this->input->post('n_file_name').".php";
		$content = html_entity_decode($this->input->post('n_temp_body'));
		file_put_contents($file, $content);
		$this->session->set_flashdata('new_temp', '1');
		redirect($this->logik->setting('default_url')."admin/email_templates");
	}

	public function edit_page()
	{
		$submit = $this->input->post('edit_page');
		$page_id = $this->uri->segment(3);

		if($page_id == '')
		{
			redirect($this->logik->setting('default_url')."admin/manage_pages");
		}

		if($submit === FALSE)
		{
			$page = $this->admin_model->get_page_by_id($page_id);
			$levels = explode(",", $page->levels);
			$this->load->view('tmp', array('tmp' => 'admin/edit_page', 'page' => $page, 'levels' => $levels));
		} else {
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
			$this->form_validation->set_rules('page_slug', 'Page Slug', 'trim|required');

			if($this->form_validation->run() === FALSE)
			{
				$page = $this->admin_model->get_page_by_id($page);
				$levels = explode(",", $page->levels);
				$this->load->view('tmp', array('tmp' => 'admin/edit_page', 'page' => $page, 'levels' => $levels));
			} else {
				$levels = implode(",", $this->input->post('levels'));

				$this->admin_model->edit_page($page_id, $this->input->post('page_name'), $this->input->post('page_slug'), $levels);

				if($this->input->post('page_slug') != $this->input->post('old_slug'))
				{
					unlink("./application/views/page/".$this->input->post('old_slug').".php");
				}
				
				$file = "./application/views/page/".$this->input->post('page_slug').".php";
				$content = html_entity_decode($this->input->post('page_content'));
				file_put_contents($file, $content);

				redirect($this->logik->setting('default_url')."admin/edit_page/".$page_id);
			}
		}
	}

	public function add_page()
	{
		$submit = $this->input->post('add_page');

		if($submit === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'admin/add_page'));
		} else {
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
			$this->form_validation->set_rules('page_slug', 'Page Slug', 'trim|required');

			if($this->form_validation->run() === FALSE)
			{
				$this->load->view('tmp', array('tmp' => 'admin/add_page'));
			} else {
				$levels = implode(",", $this->input->post('levels'));

				$this->admin_model->add_page($this->input->post('page_name'), $this->input->post('page_slug'), $levels);
				$file = "./application/views/page/".$this->input->post('page_slug').".php";
				$content = html_entity_decode($this->input->post('page_content'));
				file_put_contents($file, $content);

				redirect($this->logik->setting('default_url')."admin/manage_pages");
			}
		}
	}

	public function manage_levels()
	{
		$this->load->view('tmp', array('tmp' => 'admin/manage_levels'));
	}

	public function settings()
	{
		$default_page = $this->logik->setting('default_page');

		$pages[0] = array('id' => $default_page, 'name' => $this->admin_model->get_page_by_id($default_page)->name);

		$page_options = $this->admin_model->get_pages_settings($default_page);

		if($page_options != '0')
		{
			$i = 1;
			foreach($page_options as $p)
			{
				$pages[$i] = array('id' => $p->id, 'name' => $p->name);
				$i++;
			}
		}

		$default_level = $this->logik->setting('default_level');

		$levels[0] = array('id' => $default_level, 'name' => $this->admin_model->level_name($default_level));

		$level_options = $this->admin_model->get_level_settings($default_level);

		if($level_options != '0')
		{
			$i = 1;
			foreach($level_options as $l)
			{
				$levels[$i] = array('id' => $l->id, 'name' => $l->name);
				$i++;
			}
		}

		$submit = $this->input->post('update_settings');

		if($submit === FALSE){
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'pages' => $pages, 'levels' => $levels, 'current' => 'general'));
		} else {
			//$admin_email = $this->input->post('admin_email');
			$site_title = $this->input->post('site_title');
			$header_title = $this->input->post('header_title');
			$password_length = $this->input->post('password_length');
			/*$default_url = $this->input->post('default_url');
			$registration = $this->input->post('registration');
			$login = $this->input->post('login');
			$email_activate = $this->input->post('email_activate');
			$welcome_email = $this->input->post('welcome_email');
			$default_page = $this->input->post('default_page');
			$default_level = $this->input->post('default_level');*/

			$this->admin_model->update_settings($site_title, $header_title, $password_length);
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'pages' => $pages, 'levels' => $levels, 'update' => '1', 'current' => 'general'));
		}
	}

	public function social_settings()
	{
		$default_page = $this->logik->setting('default_page');

		$pages[0] = array('id' => $default_page, 'name' => $this->admin_model->get_page_by_id($default_page)->name);

		$page_options = $this->admin_model->get_pages_settings($default_page);

		if($page_options != '0')
		{
			$i = 1;
			foreach($page_options as $p)
			{
				$pages[$i] = array('id' => $p->id, 'name' => $p->name);
				$i++;
			}
		}

		$default_level = $this->logik->setting('default_level');

		$levels[0] = array('id' => $default_level, 'name' => $this->admin_model->level_name($default_level));

		$level_options = $this->admin_model->get_level_settings($default_level);

		if($level_options != '0')
		{
			$i = 1;
			foreach($level_options as $l)
			{
				$levels[$i] = array('id' => $l->id, 'name' => $l->name);
				$i++;
			}
		}

		$submit = $this->input->post('social_settings');

		if($submit === FALSE){
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'pages' => $pages, 'levels' => $levels, 'current' => 'social'));
		} else {
			$fb_appid = $this->input->post('fb_appid');
			$fb_secret = $this->input->post('fb_secret');
			$tw_consumer_key = $this->input->post('tw_consumer_key');
			$tw_consumer_secret = $this->input->post('tw_consumer_secret');

			$this->admin_model->social_settings($fb_appid, $fb_secret, $tw_consumer_key, $tw_consumer_secret);
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'pages' => $pages, 'levels' => $levels, 'update_social' => '1', 'current' => 'social'));
		}
	}

	public function captcha_settings()
	{
		$default_page = $this->logik->setting('default_page');

		$pages[0] = array('id' => $default_page, 'name' => $this->admin_model->get_page_by_id($default_page)->name);

		$page_options = $this->admin_model->get_pages_settings($default_page);

		if($page_options != '0')
		{
			$i = 1;
			foreach($page_options as $p)
			{
				$pages[$i] = array('id' => $p->id, 'name' => $p->name);
				$i++;
			}
		}

		$default_level = $this->logik->setting('default_level');

		$levels[0] = array('id' => $default_level, 'name' => $this->admin_model->level_name($default_level));

		$level_options = $this->admin_model->get_level_settings($default_level);

		if($level_options != '0')
		{
			$i = 1;
			foreach($level_options as $l)
			{
				$levels[$i] = array('id' => $l->id, 'name' => $l->name);
				$i++;
			}
		}
		
		$submit = $this->input->post('captcha_settings');

		if($submit === FALSE){
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'pages' => $pages, 'levels' => $levels, 'current' => 'captchaEdit'));
		} else {
			$public = $this->input->post('recaptcha_public');
			$private = $this->input->post('recaptcha_private');

			$this->admin_model->captcha_settings($public, $private);
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'pages' => $pages, 'levels' => $levels, 'update_captcha' => '1', 'current' => 'captchaEdit'));
		}
	}

	public function manage_pages()
	{
		$this->load->view('tmp', array('tmp' => 'admin/manage_pages'));
	}

	public function new_level_ajax()
	{
		$this->form_validation->set_rules('level_name', 'Level Name', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('level_redirect', 'Level Redirect', 'trim|required|max_length[50]');

		if($this->form_validation->run() === FALSE)
		{
			echo json_encode(array('error' => '1', 'message' => validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>')));
		} else {
			$this->admin_model->add_level($this->input->post('level_name'), $this->input->post('level_redirect'));
			echo json_encode(array('error' => '0', 'message' => '<div class="alert alert-success"><strong>Success!</strong> The level has been added!</div>'));
		}
	}

	public function user_data_ajax()
	{
		$user = $this->admin_model->get_user_data_id($this->input->post('uid'));

		$current_level = $this->admin_model->level_name($user->level);

		$get_levels = $this->admin_model->get_levels();

		$all_levels[$user->level] = array($current_level);

		foreach($get_levels as $l)
		{
			if(!in_array($l->name, $all_levels))
			{
				$all_levels[$l->id] = $l->name;
			}
		}

		$return = array(
			'username' => $user->username,
			'email' => $user->email,
			'full_name' => $user->name,
			'uid' => $user->id,
			'levels' => $all_levels,
			'current' => $user->level);

		echo json_encode($return);
	}

	public function get_level_data()
	{
		$return = array(
			'lid' => $this->input->post('lid'),
			'level_name' => $this->admin_model->level_data($this->input->post('lid'))->name,
			'level_redirect' => $this->admin_model->level_data($this->input->post('lid'))->redirect);

		echo json_encode($return);
	}

	public function edit_level_ajax()
	{
		$this->admin_model->edit_level($this->input->post('lid'), $this->input->post('level_name'), $this->input->post('level_redirect'));

		echo json_encode(array('message' => '<div class="alert alert-success"><strong>Success!</strong> The level has been editted!</div>'));
	}

	public function delete_user_ajax()
	{
		$this->admin_model->delete_user($this->input->post('uid'));
	}

	public function edit_user_ajax()
	{
		$this->admin_model->update_user_info($this->input->post('uid'), $this->input->post('full_name'), $this->input->post('username'), $this->input->post('email'), $this->input->post('level'));
		echo json_encode(array('update' => '1'));
	}

	public function update_module_ajax()
	{
		$type = $this->input->post('type');
		$mid = $this->input->post('mid');

		if($type == 'activate'){
			$active = '1';
		} else {
			$active = '0';
		}

		$this->admin_model->update_module($mid, $active);
	}

	public function send_emails_ajax()
	{
		$levels = $this->input->post('send_to');
		$temp = $this->input->post('template');
		$users = array();
		foreach($levels as $l){
			$users[] = $this->admin_model->user_data_by_level($l);
		}

		foreach($users as $user)
		{
			foreach($user as $u){
				$this->logik->send_email($u->email, $temp);
			}
		}

	}

	public function send_user_email()
	{
		$user = $this->input->post('send_to_username');
		$template = $this->input->post('single_template');
		$this->load->model('user_model');
		$u = $this->user_model->user_by_username($user);

		if($this->logik->send_email($u->email, $template))
		{
			$this->load->view('tmp', array('tmp' => 'admin/email_users', 'success' => '1'));
		} else {
			$this->load->view('tmp', array('tmp' => 'admin/email_users', 'error' => '1'));
		}
	}

	public function date_stats_ajax()
	{
		$start = strtotime($this->input->post('start_date'));
		$end = strtotime($this->input->post('end_date'));
		
		//Total registered
		$total_registered = $this->admin_model->total_users_date($start, $end);

		//Total page views
		$total_page_views = $this->admin_model->total_hits_date($start, $end);

		//Total FB registered
		$total_fb = $this->admin_model->total_fb_date($start, $end);

		//Total TW registered
		$total_tw = $this->admin_model->total_tw_date($start, $end);

		//Top ten users
		$top_users = $this->admin_model->top_ten_users_date($start, $end);
		$top_user = array();

		$i = 0;
		foreach($top_users as $tu){
			$top_user[$i] = array('username' => $tu->username, 'num_logins' => $this->admin_model->num_logins($tu->username));
			$i++; 
		}

		//Top pages
		$top_pages = $this->admin_model->top_ten_pages_date($start, $end);
		$top_page = array();

		$c = 0;
		foreach($top_pages as $tp){
			$top_page[$c] = array('views' => $this->admin_model->num_p_views($tp->p_id), 'name' => $this->admin_model->page_name_by_id($tp->p_id));
			$c++;
		}

		$return = array(
			'total_users' => $total_registered,
			'total_hits' => $total_page_views,
			'total_fb' => $total_fb,
			'total_tw' => $total_tw,
			'top_users' => $top_user,
			'top_pages' => $top_page);

		echo json_encode($return);
	}

	public function delete_menu_ajax()
	{
		$mid = $this->input->post('mid');

		$this->admin_model->delete_menu($mid);	
	}

	public function delete_page_ajax()
	{
		$pid = $this->input->post('pid');

		$this->admin_model->delete_page($pid);
	}

	public function delete_tmp_ajax()
	{
		$tid = $this->input->post('tid');

		$this->admin_model->delete_tmp($tid);
	}

	public function edit_menu_item_ajax()
	{
		$this->admin_model->menu_item_update($this->input->post('mid'), $this->input->post('item_name'), $this->input->post('item_link'), $this->input->post('item_order'));
	}

	public function edit_menu_item_data_ajax()
	{
		$menu = $this->admin_model->menu_item_by_id($this->input->post('mid'));
		$return = array('name' => $menu->name, 'link' => $menu->link, 'order' => $menu->order, 'mid' => $this->input->post('mid'));

		echo json_encode($return);
	}

	public function new_menu_item_ajax()
	{
		$this->admin_model->add_menu_item($this->input->post('item_name'), $this->input->post('item_link'), $this->input->post('item_order'));
	}

	public function get_email_temp_ajax()
	{
		$temp = $this->admin_model->get_email_temp($this->input->post('tid'));
		$return = array(
			'name' => $temp->name,
			'file_name' => $temp->file_name,
			'temp_id' => $temp->id,
			'temp_body' => $this->logik->email_temp($temp->file_name),
			'email_subject' => $temp->subject);
		echo json_encode($return);
	}

	public function edit_user_pass_ajax()
	{
		$this->admin_model->update_user_password($this->input->post('uid'), $this->input->post('password1'));
		echo json_encode(array('update' => '1'));
	}

	public function update_admin_notes()
	{
		$notes = $this->input->post('notes');
		$owner = $this->input->post('owner');

		$date = $this->admin_model->save_notes($notes, $owner);

		echo json_encode(array('date' => date("M j Y g:i A", $date)));
	}

	public function notes_history()
	{
		$this->load->view('tmp', array('tmp' => 'admin/notes_history'));
	}

////dhiru function to active in active from all form//////
	public function activeInactiveUser() {
		if(!empty($_POST)) {
			$userId = $this->admin_model->aciveInactivateUser($_POST);
			if($userId) {
				echo json_encode($_POST);
			}
		}
	}
	
	public function home_ajax() {
		////end docs pagination////
		$page_cls = new pagination(0, 0, 0);
		$page_id = $page_number = $this->input->post('page_number');
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = $page_number;
		$page_cls->end = $item_par_page;
		if($page_number==0) {
			$page_number = 1;
		}
		if($page_number==0) {
			$noOfPage = 10;
		} else {
			$noOfPage = (1+$page_number)*$item_par_page;
		}
		$countPageUserDocs = $item_par_page*$page_number+$item_par_page ;
		$docs = $this->admin_model->getUserDocuments();
		$userDocs = array();
		$countUserDocs = 0;
		$countAll = 0;
		//echo $page_cls->start.$page_cls->end;
		//echo $countPageUserDocs;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		$latestDocs = array();
		$docCount = 0;
		foreach($docs as $key=>$doc) {
			$countAll += $this->admin_model->countTotalValue(strtolower($doc['table_name']), $srchText);
			$latestDoc = $this->admin_model->getLatestRecord(strtolower($doc['table_name']), 0, $noOfPage);
			$docCount++;
			
			//if(empty($srchText) and $page_number==-1 and !empty($latestDoc)) {
				if(count($latestDocs)<10) { 
					foreach($latestDoc as $k1=>$v1) {
						$latestDocs[$v1['created']] = $v1;
						$latestDocs[$v1['created']]['table_name'] = strtolower($doc['table_name']);
						if(count($latestDocs)==10) {
							//break;
						}
					}
				}
				foreach($latestDoc as $key1=>$value) {
					//if(!empty($latestDocs) and count($latestDocs)>10) {
						$f = 0;
						foreach($latestDocs as $ky=>$docm) {
							if($docm['created'] < $value['created']) {
								//unset($latestDocs[$docm['created']]);
								$latestDocs[$value['created']] = $value;
								$latestDocs[$value['created']]['table_name'] = strtolower($doc['table_name']);
								$f = 1;
							}
							if($f==1) {
								break;
							}
						}
					//} else {
					//	break;
					//}
				}
			//}
			
			if($countUserDocs>=$countPageUserDocs) {
				$page_cls->start=0;
				continue;
			}
			//echo $page_cls->start;
			if($page_cls->start==0) {
				$diff = 0;
			} else {
				$diff = $countPageUserDocs-$item_par_page;
			}
			$page_cls->start = $diff;
			$page_cls->end = $item_par_page-$countUserDocs;
			//echo $page_cls->start.$page_cls->end.$doc['table_name'];exit;
			$data = $this->admin_model->get_table_data(strtolower($doc['table_name']), $page_cls->start, $page_cls->end, $srchText);
			if(!empty($data)) {
				foreach($data as $k=>$v) {
					$data[$k]['groups'] = $this->user_model->getGroupById($v['groups']);
					/*if(!empty($latestDocs)) {
						foreach($latestDocs as $sk=>$sv) {
							if($sv['id']==$v['id'] and $sv['table_name']==$doc['table_name']) {
								unset($data[$k]);
							}
						}
					}*/
				}
				$countUserDocs += count($data);
				$userDocs[strtolower($doc['table_name'])] = $data;
				unset($data);
			}
			$page_cls->start=0;
		}
		
		if(!empty($latestDocs)  and empty($srchText)) {
			foreach($latestDocs as $k=>$v) {
				$latestDocs[$k]['created'] = date('d, m Y', $v['created']);
				$latestDocs[$k]['groups'] = $this->user_model->getGroupById($v['groups']);
			}
			krsort($latestDocs);
			$latestDocs = array_chunk($latestDocs,10);
			$userDocs = array($latestDocs[$page_id]);
		}

		//print_r($latestDocs);exit;
		if(!empty($countAll) and $countAll>10) {
			//$countAll += 10;
		}
		$total_set =  $countAll;
        //break total recoed into pages
        $total = ceil($countAll/$item_par_page);
        if($total_set>0) {
			$data = array(
				'TotalRows' => $total,
				'Rows' => $userDocs
			);
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
		/*$_SESSION['first_page'] = array();
		if(empty($srchText) and $page_number==-1 and !empty($latestDoc)) {
			foreach($latestDocs as $key=>$v) {
				$_SESSION['first_page'][$key]['id'] = $v['id'];
				$_SESSION['first_page'][$key]['table_name'] = $v['table_name'];
			}
		} else {
			//unset($_SESSION['first_page']);
		}*/
		
        exit;
	}
	
	public function userDocuments()
	{
		$this->load->view('tmp', array('tmp' => 'admin/manage_table'));	
	}
	
	public function statistics() {
		$searchDoc = array();
		$searchUser = array();
		$searchGroup = array();
		if(!empty($_POST)) {
			if(isset($_POST['document'])) {
				array_pop($_POST);
				$searchDoc = $_POST;
			}
			if(isset($_POST['user'])) {
				array_pop($_POST);
				$searchUser = $_POST;
			}
			if(isset($_POST['group'])) {
				array_pop($_POST);
				$searchGroup = $_POST;
			}
		}
		/////for count document by doc type/////////
		$this->db->select("id, name, table_name, groups");
		$this->db->from("doc_types");
		$this->db->where("publish", 2);
		$documents = $this->db->get()->result_array();
		$userDocs = array();
		$byGroup = $documents;
		foreach($documents as $key=>$doc) {
			$documents[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchDoc); 
			$userDocs = array_merge($userDocs, $this->admin_model->countByUsername($doc['table_name'], $searchUser));
			$byGroup[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchGroup);
			if($documents[$key]['total_doc']==0) {
				unset($documents[$key]);
			}
		}
		/////for count document by user ///////////
		$users = $this->admin_model->getUsernames();
		foreach($users as $key => $user) {
			foreach($userDocs as $key1=>$docs) {
				if($docs['user_id'] == $user['username']) {
					if(isset($users[$key]['total_doc'])) {
						$users[$key]['total_doc'] += $docs['total'];
					} else {
						$users[$key]['total_doc'] = $docs['total'];
					}
				}
			}
			if(!isset($users[$key]['total_doc'])) {
				unset($users[$key]);
			}
		}
		/////for count document by group id//////
		$groups = $this->admin_model->getGroups();
		foreach($groups as $key=>$group) {
			foreach($byGroup as $document) {
				$grps = explode(",", $document['groups']);
				if(in_array($group['id'], $grps)) {
					if(isset($groups[$key]['total_doc'])) {
						$groups[$key]['total_doc'] += $document['total_doc'];
					} else {
						$groups[$key]['total_doc'] = $document['total_doc'];
					}
				}
			}
			if(!isset($groups[$key]['total_doc']) or $groups[$key]['total_doc']==0) {
				unset($groups[$key]);
			}
		}
		$this->load->view('tmp', array('tmp' => 'admin/statistics', "documents"=>$documents, "users"=>$users, "groups"=>$groups));	
	}
	
	public function log() {
		$date = array();
		if(!empty($_POST)) {
			$date = $_POST;
		}
		/*$docs = $this->admin_model->getUserDocuments();
		$userDocs = array();
		foreach($docs as $key=>$doc) {
			$userDocs[$doc['table_name']] = $this->admin_model->getDocumentTableData($doc['table_name'], $date);
		}*/
		$userDocs = $this->admin_model->getDocumentLogs($date);
		$userLogs = $this->admin_model->getUserLogs($date);
		$this->load->view('tmp', array('tmp' => 'admin/log', 'rec'=>$userDocs, 'userLogs'=>$userLogs));	
	}
	
	public function log_ajax() {
		$page_number = $this->input->post('page_number'); 
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$where = "";
		if($this->input->post('search')!='') {
			$where .= "where (action like '%".$this->input->post('search')."%' or user_id like '%".$this->input->post('search')."%' or ip_address like '%".$this->input->post('search')."%' or mac_address like '%".$this->input->post('search')."%')";
		}
		$result_set = $this->db->query("SELECT id,user_id, action, document_id,table_name,ip_address,mac_address, FROM_UNIXTIME(date_time, '%d-%m-%Y')as create_date, FROM_UNIXTIME(date_time, '%H:%i:%s')as time FROM user_histories ".$where." order by id desc LIMIT ".$position.",".$item_par_page);
		
        $total_set =  $result_set->num_rows();
		if($this->input->post('search')!='') {
			$result_set1 = $this->db->query("SELECT id,user_id, action, document_id,table_name,ip_address,mac_address, FROM_UNIXTIME(date_time, '%d-%m-%Y')as create_date, FROM_UNIXTIME(date_time, '%H:%i:%s')as time FROM user_histories ".$where." order by id desc");
			$page =  $result_set1;
			$total =  $result_set1->num_rows();
		} else {
		
			$page =  $this->db->get('user_histories') ;
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
	
	public function doc_log_ajax() {
		$page_number = $this->input->post('page_number'); 
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$where = "";
		if($this->input->post('search')!='') {
			$where .= "where (action like '%".$this->input->post('search')."%' or user_id like '%".$this->input->post('search')."%' or ip_address like '%".$this->input->post('search')."%' or mac_address like '%".$this->input->post('search')."%' or document_id like '%".$this->input->post('search')."%')";
		}
		$result_set = $this->db->query("SELECT id,user_id, action, document_id,table_name,ip_address,mac_address, FROM_UNIXTIME(date_time, '%d-%m-%Y')as create_date, FROM_UNIXTIME(date_time, '%H:%i:%s')as time FROM doc_histories ".$where." order by id desc LIMIT ".$position.",".$item_par_page);
		
        $total_set =  $result_set->num_rows();
		if($this->input->post('search')!='') {
			$result_set1 = $this->db->query("SELECT id,user_id, action, document_id,table_name,ip_address,mac_address, FROM_UNIXTIME(date_time, '%d-%m-%Y')as create_date, FROM_UNIXTIME(date_time, '%H:%i:%s')as time FROM doc_histories ".$where." order by id desc");
			$page =  $result_set1;
			$total =  $result_set1->num_rows();
		} else {
		
			$page =  $this->db->get('doc_histories') ;
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
	
	public function graph() {
		$js_path=$this->logik->setting("default_url")."assets/app/js/";
		array_push($this->setting_model->external_js,$js_path."graph/jquery.jqplot.min");
        array_push($this->setting_model->external_js,$js_path."graph/plugins/jqplot.barRenderer.min");
		array_push($this->setting_model->external_js,$js_path."graph/plugins/jqplot.categoryAxisRenderer.min");
		array_push($this->setting_model->external_js,$js_path."graph/plugins/jqplot.pointLabels.min");
		
		$searchDoc = array();
		$searchUser = array();
		$searchGroup = array();
		if(!empty($_POST)) { //print_r($_POST);exit;
			if(isset($_POST['document'])) {
				array_pop($_POST);
				$searchDoc = $_POST;
			}
			if(isset($_POST['user'])) {
				array_pop($_POST);
				$searchUser = $_POST;
			}
			if(isset($_POST['group'])) {
				array_pop($_POST);
				$searchGroup = $_POST;
			}
		}
		/////for count document by doc type/////////
		$this->db->select("id, name, table_name, groups");
		$this->db->from("doc_types");
		$this->db->where("publish", 2);
		$documents = $this->db->get()->result_array();
		$userDocs = array();
		$byGroup = $documents;
		foreach($documents as $key=>$doc) {
			$documents[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchDoc); 
			$userDocs = array_merge($userDocs, $this->admin_model->countByUsername($doc['table_name'], $searchUser));
			$byGroup[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchGroup);
			if($documents[$key]['total_doc']==0) {
				unset($documents[$key]);
			}
		}
		/////for count document by user ///////////
		$users = $this->admin_model->getUsernames();
		foreach($users as $key => $user) {
			foreach($userDocs as $key1=>$docs) {
				if($docs['user_id'] == $user['username']) {
					if(isset($users[$key]['total_doc'])) {
						$users[$key]['total_doc'] += $docs['total'];
					} else {
						$users[$key]['total_doc'] = $docs['total'];
					}
				}
			}
			if(!isset($users[$key]['total_doc'])) {
				unset($users[$key]);
			}
		}
		/////for count document by group id//////
		$groups = $this->admin_model->getGroups();
		foreach($groups as $key=>$group) {
			foreach($byGroup as $document) {
				$grps = explode(",", $document['groups']);
				if(in_array($group['id'], $grps)) {
					if(isset($groups[$key]['total_doc'])) {
						$groups[$key]['total_doc'] += $document['total_doc'];
					} else {
						$groups[$key]['total_doc'] = $document['total_doc'];
					}
				}
			}
			if(!isset($groups[$key]['total_doc']) or $groups[$key]['total_doc']==0) {
				unset($groups[$key]);
			}
		}
		$this->load->view('tmp', array('tmp' => 'admin/graph', "documents"=>$documents, "users"=>$users, "groups"=>$groups));	
	}
	
	public function update_password() {
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		if($this->user_model->check_password($this->input->post('old_password')) === FALSE) {
			$this->load->view('tmp', array('tmp' => 'admin/settings', 'password_error' => '1'));
		} else {
			$this->db->where("setting", "password_length");
			$this->db->where("value", 1);
			$pwdLength = $this->db->get("settings")->row_array();
			$valPass = '';
			if(!empty($pwdLength)) {
				$valPass = '|min_length[8]';
			}
			$this->form_validation->set_rules('new_password1', 'Password', 'trim|required'.$valPass.'|max_length[25]');
			$this->form_validation->set_rules('new_password2', 'Password Confirmation', 'trim|required|matches[new_password1]');
			if($this->form_validation->run() === FALSE) {
				$this->load->view('tmp', array('tmp' => 'admin/settings'));
			} else {
				$this->user_model->update_password($this->input->post('new_password1'));
				$this->auth_model->saveUserHistory($this->lang->line("action_update_password"));
				$this->load->view('tmp', array('tmp' => 'admin/settings', 'password_update' => '1'));
			}
		}
	}

}
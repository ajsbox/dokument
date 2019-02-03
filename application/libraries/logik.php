<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |_________________
-- File: libraries/logik.php |
-- --------------------------/
*/

class Logik {

	private $CI;

	public $level;

	public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('setting_model');
        $this->CI->load->model('user_model');
        $this->CI->load->model('admin_model');
        $this->CI->load->library('auth');
    }

    public function stats($stat)
    {
        if($stat == 'total_registered')
        {
            return $this->CI->admin_model->total_users();
        }elseif($stat == 'total_fb')
        {
            return $this->CI->admin_model->total_fb();
        }elseif($stat = 'total_tw')
        {
            return $this->CI->admin_model->total_tw();
        }elseif($stat = 'total_hit')
        {
            return $this->CI->admin_model->total_hits();
        }
    }

    public function install_check()
    {
        if(!$this->db->table_exists('setting')){
            redirect($this->setting('default_url')."install");
            die();
        }
    }

    public function send_email($to, $template,$password)
    {
        //We need the parser library
        $this->CI->load->library('parser');

        //Email subject
        $subject = $this->CI->admin_model->email_temp_by_file_name($template)->subject;

        //Get our user data by email
        $user = $this->CI->admin_model->user_data_by_email($to);

        //The array containing data for the email template
        $data = array(
            'site_title' => $this->setting('site_title'),
            'site_url' => $this->setting('default_url'),
            'name' => $user->name,
            'email' => $to,
			 'password' => $password,
            'username' => $user->username,
            'user_level' => $this->CI->admin_model->level_name($user->level)
            );

        //Generate the actual email from our template
        $message = $this->CI->parser->parse("email/".$template, $data, TRUE);

        $this->CI->email->from($this->CI->logik->setting('admin_email'), $this->CI->logik->setting('site_title'));
        $this->CI->email->to($to);

        $this->CI->email->subject("Bienvenido a DMS");
		
        $this->CI->email->message($message);    

        if(!$this->CI->email->send())
        {
            return FALSE;
        }  else {
            return TRUE;
        }
    }

    public function file_upload($where, $file_name)
    {
        $config['upload_path'] = $where;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|php|html|js';
        $config['file_name'] = $file_name;
        $config['max_size'] = '0';
        $config['max_width']  = '1024';
        $config['max_height']  = '1024';
        $config['overwrite'] = TRUE;

        $this->CI->load->library('upload', $config);

        if ( ! $this->CI->upload->do_upload())
        {
            return $this->CI->upload->display_errors();
        } else {
            return $this->CI->upload->data();
        }
    }

    public function setting($setting)
    {
    	return $this->CI->setting_model->get_settings($setting)->value;
    }

    public function module($name)
    {
	    
        return @$this->CI->setting_model->get_modules($name)->active;
    }

    public function default_page()
    {
        return $this->CI->setting_model->default_page($this->setting('default_page'));
    }

    public function user()
    {
        return $this->CI->auth_model->get_user();
    }

    public function page_content($slug)
    {
        return file_get_contents("./application/views/page/".$slug.".php");
    }

    public function email_temp($file)
    {
        return file_get_contents("./application/views/email/".$file.".php");
    }

    public function all_pages()
    {
    	return $this->CI->admin_model->get_pages();
    }

    public function all_levels()
    {
    	return $this->CI->admin_model->get_levels();
    }

    public function get_page_data($slug)
    {
    	return $this->CI->admin_model->page_data($slug);
    }

    public function get_menu()
    {
        return $this->CI->admin_model->get_menu();
    }

    public function save_hit($p_id)
    {
        $is_user = $this->CI->auth->user_type();
        $this->CI->auth_model->save_hit($p_id, $is_user);
    }

    public function get_departments()
    {
        return $this->CI->admin_model->all_departments();
    }

    public function get_level_names($levels)
    {
    	$level = explode(",", $levels);
    	$return = '';
    	foreach($level as $l)
    	{
    		$return .= $this->CI->admin_model->level_name($l)." ";
    	}
    	return $return;
    }

    public function num_users_in_level($level)
    {
    	return $this->CI->admin_model->users_in_level($level);
    }

    public function get_level()
    {
    	if($this->CI->auth->user_type() == 'guest')
    	{
    		return '3';
    	} else {
    		return $this->CI->user_model->get_level($this->CI->session->userdata('username'))->level;
    	}
    }

    public function num_open_tickets()
    {
        $this->CI->load->model('support_model');
        return $this->CI->support_model->num_open_tickets();
    }

}
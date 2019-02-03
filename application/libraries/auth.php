<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |________________
-- File: libraries/auth.php |
-- -------------------------/
*/

class Auth {

	private $CI;

	public $user_type;

    public $fb;

	public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('logik');
        $fb_settings = array(
            'appId' => $this->CI->logik->setting('fb_appid'),
            'secret' => $this->CI->logik->setting('fb_secret'),
            'cookie' => TRUE
            );
        //$this->CI->load->library('facebook', $fb_settings);
    }

    public function fb_user_id()
    {
        return $user = $this->CI->facebook->getUser();
    }

    public function fb_login_url()
    {
        return $fb_login_url = $this->CI->facebook->getLoginUrl(
            array(
                'scope'         => 'email,offline_access,publish_stream,user_birthday,user_location,user_about_me',
                'redirect_uri'  => $this->CI->logik->setting('default_url')."main/fb_login"
            )
        );
    }

    public function fb_user_info()
    {
        $user = $this->fb_user_id();
        return $userInfo = $this->CI->facebook->api("/$user");
    }

    public function cookie_to_session()
    {
       if($this->CI->input->cookie('user_logik_cookie') != '' AND $this->CI->session->userdata('logged_in') != '1')
        {
            $user = $this->CI->auth_model->get_user_username($this->CI->input->cookie('user_logik_cookie'));
            $data = array(
                        'username' => $user->username,
                        'logged_in' => '1');
            $this->CI->session->set_userdata($data);

            $this->save_login($user->username);
        }
    }

    public function save_login($username)
    {
        $this->CI->auth_model->save_login($username);
    }

    public function user_type()
    {
    	if($this->CI->session->userdata('username') === FALSE AND $this->CI->session->userdata('logged_in') != '1')
    	{
    		$this->user_type = 'guest';
    	} else {
    		$this->user_type = 'user';
    	}

    	return $this->user_type;
    }

    public function send_new_password($to, $password, $name)
    {
        $data = array(
            'name' => $name,
            'new_password' => $password,
            'site_title' => $this->CI->logik->setting('site_title'),
            'site_url' => $this->CI->logik->setting('default_url')
            );

        $this->CI->load->library('parser');
        $message = $this->CI->parser->parse('email/new_password', $data, TRUE);

        $this->CI->email->from($this->CI->logik->setting('admin_email'), $this->CI->logik->setting('site_title'));
        $this->CI->email->to($to);

        $this->CI->email->subject('Your New Password');
        $this->CI->email->message($message);    

        if(!$this->CI->email->send())
        {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function send_password_email($to, $reset, $name)
    {
        $data = array(
            'name' => $name,
            'reset_password' => $reset,
            'site_title' => $this->CI->logik->setting('site_title'),
            'site_url' => $this->CI->logik->setting('default_url')
            );

        $this->CI->load->library('parser');
        $message = $this->CI->parser->parse('email/forgot_password', $data, TRUE);

        $this->CI->email->from($this->CI->logik->setting('admin_email'), $this->CI->logik->setting('site_title'));
        $this->CI->email->to($to);

        $this->CI->email->subject('Password Reset Request');
        $this->CI->email->message($message);    

        if(!$this->CI->email->send())
        {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function send_activate_email($to, $activate, $name)
    {
        $activate_url = $this->CI->logik->setting('default_url')."activate/".$activate;

    	$data = array(
    		'name' => $name,
    		'activate_url' => $activate_url
    		);

        $this->CI->load->library('parser');
    	$message = $this->CI->parser->parse('email/activate', $data, TRUE);

    	$this->CI->email->from($this->CI->logik->setting('admin_email'), $this->CI->logik->setting('site_title'));
		$this->CI->email->to($to);

		$this->CI->email->subject('Please Activate Your Account');
		$this->CI->email->message($message);	

		if(!$this->CI->email->send())
        {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
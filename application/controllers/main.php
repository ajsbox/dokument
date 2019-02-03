<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/main.php |
-- ---------------------------/
*/

include('./assets/recaptchalib.php');
include('./application/libraries/twitteroauth.php');

class Main extends CI_Controller {

	private $twitter;

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
	    $this->load->model('admin_model');
	    $this->load->helper('cookie');
	    $this->load->model('auth_model');
		if(!$this->db->table_exists('settings')) {
            redirect("install");
        }
	    $this->auth->cookie_to_session();
		//$this->config->set_item('language', 'english');
	}

	public function index()
	{
		redirect($this->logik->setting('default_url').'home');
	}
	
	public function getCopyright() {
		$this->load->view('tmp', array('tmp' => 'inc/copyright', "copyright"=>1));
	}
   
	public function page()
	{
		if($this->uri->segment(2) == '')
		{
			$page = $this->uri->segment(1);
		} else {
			$page = $this->uri->segment(2);
		}

		if($this->uri->segment(2) == 'admin')
		{
			redirect($this->logik->setting('default_url')."admin");
		}

		if($this->uri->segment(2) == 'user')
		{
			redirect($this->logik->setting('default_url')."user/home");
		}

		$p_data = $this->logik->get_page_data($page);

		if($p_data === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'inc/404'));
			return false;
		}

		$this->logik->save_hit($p_data->id);

		$level_arr = explode(",", $p_data->levels);

		if(!in_array($this->logik->get_level(), $level_arr))
		{
			$this->load->view('tmp', array('tmp' => 'inc/no_access'));
		} else {
			$this->load->view('tmp', array('tmp' => "page/$page", 'current' => $p_data->name));
		}
	}

	public function login_error() {
		//echo "login error";exit;
		$this->load->view('tmp', array('tmp' => 'main/no_access', 'error' => '1'));
	}
	
	public function login()
	{
		$banedAttepts = $this->auth_model->getBandAttempt();
		$bannedValue = 0;
		$bannedTime = '0:0:0';
		if(!empty($banedAttepts)) {
			$bannedTime = $banedAttepts[0]['value'];
			$bannedValue = $banedAttepts[1]['value'];
		}
		
		if($this->auth_model->checkLoginError($bannedValue, $bannedTime)) {
			redirect($this->logik->setting('default_url').'login_error');
		}
		$login = $this->input->post('login');
		
		if($login === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'main/login'));
		} else {
			if($this->logik->setting('login') == '0' AND $this->logik->get_level() != '1')
			{
				redirect($this->logik->setting('default_url'));
			}
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			
			if($this->form_validation->run() === FALSE)
			{	
				$this->load->view('tmp', array('tmp' => 'main/login'));
			} else {
				if($this->logik->setting('login') == '0' AND $this->logik->get_level() != '1')
				{
					redirect($this->logik->setting('default_url'));
				}
				
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				if($this->input->post('type')=='ldap') {
					$logedIn = $this->auth_model->ldap_authenticate($username, $password);
				} else {
					$logedIn = $this->auth_model->do_login($username, $password);
				}

				if($logedIn==2 or $logedIn==$bannedValue or $logedIn==3)
				{
					$count = $this->auth_model->get_error_count($username, $_SERVER['REMOTE_ADDR'], $bannedTime);
					if($count>=$bannedValue) {
						redirect($this->logik->setting('default_url').'login_error');
					} else {
						$this->load->view('tmp', array('tmp' => 'main/login', 'error' => $logedIn));
					}
				} else {
					$this->db->where("username", $username);
					$users = $this->db->get("accounts")->row_array();
					if(empty($users)) {
						$this->load->view('tmp', array('tmp' => 'main/login', 'error' => 'ldap_user'));
					} else {
						$this->auth_model->clear_error_count($_SERVER['REMOTE_ADDR'], $username);
						
						if($this->input->post('remember_me') == 'remember')
						{
							$cookie = array(
							'name'   => 'user_logik_cookie',
							'value'  => $username,
							'expire' => '604800'
							);

							$this->input->set_cookie($cookie);
							
							$cookie = array(
							'name'   => 'user_pass_cookie',
							'value'  => $password,
							'expire' => '604800'
							);

							$this->input->set_cookie($cookie);
						}
						
						$data = array(
							'username' => $username,
							'logged_in' => '1');
						$this->session->set_userdata($data);
						session_start();
						$_SESSION['username'] = $username;
						$this->auth->save_login($username);
						$this->auth_model->saveUserHistory("Iniciar Sesión");
						$level = $this->auth_model->get_level($this->auth_model->get_user()->level);
					   
						//redirect($this->logik->setting('default_url')."page/".$level->redirect);
						if($this->logik->get_level()==1)
						redirect($this->logik->setting("default_url")."admin/userDocuments");
						else
						redirect($this->logik->setting("default_url")."user/my_documents");
					}
				}
			}
		}
	}

	public function register()
	{
		$register = $this->input->post('register');
		if($this->logik->setting('registration') == '0' AND $this->logik->get_level() != '1')
		{
			redirect($this->logik->setting('default_url'));
		}

		//Recaptcha
		$privatekey = $this->logik->setting('recaptcha_private');
  		$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));

		if($register === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'main/register'));
		} else {
			//validation
			$this->form_validation->set_rules('full_name', 'Name', 'trim|required|min_length[4]|max_length[25]');
			$this->form_validation->set_rules('r_username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[accounts.username]');
			$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[25]');
			$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|min_length[4]|max_length[25]|matches[password1]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[4]|max_length[40]|valid_email|is_unique[accounts.email]');
			$this->form_validation->set_message('is_unique', 'Sorry but that %s is already in use!');

			if($this->form_validation->run() === FALSE)
			{
				$this->load->view('tmp', array('tmp' => 'main/register'));
			} else {
				if($this->logik->setting('recaptcha_public') != '0'){
					if(!$resp->is_valid)
					{
						$this->load->view('tmp', array('tmp' => 'main/register', 'captcha_error' => '1'));
					} else {
						if($this->logik->setting('email_activate') == '1')
						{
							$activate = random_string('alnum', 18);
						} else {
							$activate = '0';
						}

						//Collect our variables together
						$name = $this->input->post('full_name');
						$username = $this->input->post('r_username');
						$password = $this->input->post('password1');
						$email = $this->input->post('email');
						$fb_id = '0';

						if($this->auth_model->do_register($name, $username, $password, $email, $activate, $fb_id) === TRUE)
						{
							if($this->logik->setting('email_activate') == '1')
							{
								$this->auth->send_activate_email($email, $activate, $name);
							} else {
								if($this->logik->setting('welcome_email') == '1')
								{
									$this->logik->send_email($email, 'welcome');
								}
							}
							$this->load->view('tmp', array('tmp' => 'main/register', 'success' => '1'));
						} else {
							$this->load->view('tmp', array('tmp' => 'main/register', 'error' => '1'));
						}
					}
				} else {
					if($this->logik->setting('email_activate') == '1')
						{
							$activate = random_string('alnum', 18);
						} else {
							$activate = '0';
						}

						//Collect our variables together
						$name = $this->input->post('full_name');
						$username = $this->input->post('r_username');
						$password = $this->input->post('password1');
						$email = $this->input->post('email');
						$fb_id = '0';

						if($this->auth_model->do_register($name, $username, $password, $email, $activate, $fb_id) === TRUE)
						{
							if($this->logik->setting('email_activate') == '1')
							{
								$this->auth->send_activate_email($email, $activate, $name);
							}
							$this->load->view('tmp', array('tmp' => 'main/register', 'success' => '1'));
						} else {
							$this->load->view('tmp', array('tmp' => 'main/register', 'error' => '1'));
						}
				}
			}
		}
	}

	public function activate()
	{
		$activate = $this->uri->segment(2);
		$user = $this->user_model->user_by_activate($activate);
		if($this->auth_model->do_activate($activate) === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'main/activate', 'error' => '1'));
		} else {
			if($this->logik->setting('welcome_email') == '1')
			{
				$this->logik->send_email($user->email, 'welcome');
			}
			$this->load->view('tmp', array('tmp' => 'main/activate', 'error' => '0'));
		}
	}

	public function logout()
	{
		if (isset($_SERVER['HTTP_COOKIE'])) {
    		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    		foreach($cookies as $cookie) {
        		$parts = explode('=', $cookie);
        		$name = trim($parts[0]);
        		setcookie($name, '', time()-1000);
        		setcookie($name, '', time()-1000, '/');
    		}
		}
		$this->session->sess_destroy();
		redirect($this->logik->setting('default_url'));
	}

	public function twitter_redirect()
	{
		$key = $this->logik->setting('consumer_key');
		$secret = $this->logik->setting('consumer_secret');
		$this->twitter = new TwitterOAuth($key, $secret);
		$request_token = $this->twitter->getRequestToken($this->logik->setting('default_url')."main/twitter_callback");
		/* Save temporary credentials to session. */
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
		/* If last connection failed don't display authorization link. */
		switch ($this->twitter->http_code) {
  		case 200:
    		/* Build authorize URL and redirect user to Twitter. */
    		$url = $this->twitter->getAuthorizeURL($token);
    		redirect($url);
    		break;
  		default:
    		echo 'Could not connect to Twitter. Refresh the page or try again later.';
    	}
	}

	public function twitter_callback()
	{
		$key = $this->logik->setting('consumer_key');
		$secret = $this->logik->setting('consumer_secret');
		$this->twitter = new TwitterOAuth($key, $secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		$access_token = $this->twitter->getAccessToken($_REQUEST['oauth_verifier']);

		if($this->auth_model->check_twitter($access_token['oauth_token']) === TRUE)
		{
			$user = $this->auth_model->info_by_twitter($access_token['oauth_token']);

			$data = array(
						'username' => $user->username,
						'logged_in' => '1');

			$this->session->set_userdata($data);

			$this->auth->save_login($user->username);

			$level = $this->auth_model->get_level($this->auth_model->get_user()->level);

			redirect($this->logik->setting('default_url')."page/".$level->redirect);
		} else {
			$this->load->view('tmp', array('tmp' => 'main/register_tw', 'tw_token' => $access_token['oauth_token'], 'tw_token_secret' => $access_token['oauth_token_secret']));
		}

	}

	public function register_tw()
	{
		$this->form_validation->set_rules('full_name', 'Name', 'trim|required|min_length[4]|max_length[25]');
		$this->form_validation->set_rules('r_username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[accounts.username]');
		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[25]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|min_length[4]|max_length[25]|matches[password1]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[4]|max_length[40]|valid_email|is_unique[accounts.email]');
		$this->form_validation->set_message('is_unique', 'Sorry but that %s is already in use!');

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'main/register_tw'));
		} else {
			if($this->logik->setting('email_activate') == '1')
			{
				$activate = random_string('alnum', 18);
			} else {
				$activate = '0';
			}

			//Collect our variables together
			$name = $this->input->post('full_name');
			$username = $this->input->post('r_username');
			$password = $this->input->post('password1');
			$email = $this->input->post('email');
			$tw_token = $this->input->post('tw_token');
			$tw_token_secret = $this->input->post('tw_token_secret');

			if($this->auth_model->do_register_tw($name, $username, $password, $email, $activate, $tw_token, $tw_token_secret) === TRUE)
			{
				if($this->logik->setting('email_activate') == '1')
				{
					$this->auth->send_activate_email($email, $activate, $name);
				}else{
					if($this->logik->setting('welcome_email') == '1')
					{
						$this->logik->send_email($email, 'welcome');
					}
				}
				$this->load->view('tmp', array('tmp' => 'main/register_tw', 'success' => '1'));
			} else {
				$this->load->view('tmp', array('tmp' => 'main/register_tw', 'error' => '1'));
			}
		}
	}

	public function register_fb()
	{
		$this->form_validation->set_rules('full_name', 'Name', 'trim|required|min_length[4]|max_length[25]');
		$this->form_validation->set_rules('r_username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[accounts.username]');
		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[25]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|min_length[4]|max_length[25]|matches[password1]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[4]|max_length[40]|valid_email|is_unique[accounts.email]');
		$this->form_validation->set_message('is_unique', 'Sorry but that %s is already in use!');

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('tmp', array('tmp' => 'main/register_fb'));
		} else {
			if($this->logik->setting('email_activate') == '1')
			{
				$activate = random_string('alnum', 18);
			} else {
				$activate = '0';
			}

			//Collect our variables together
			$name = $this->input->post('full_name');
			$username = $this->input->post('r_username');
			$password = $this->input->post('password1');
			$email = $this->input->post('email');
			$fb_id = $this->auth->fb_user_id();

			if($this->auth_model->do_register($name, $username, $password, $email, $activate, $fb_id) === TRUE)
			{
				if($this->logik->setting('email_activate') == '1')
				{
					$this->auth->send_activate_email($email, $activate, $name);
				} else {
					if($this->logik->setting('welcome_email') == '1')
					{
						$this->logik->send_email($email, 'welcome');
					}
				}
				$this->load->view('tmp', array('tmp' => 'main/register_fb', 'success' => '1'));
			} else {
				$this->load->view('tmp', array('tmp' => 'main/register_fb', 'error' => '1'));
			}
		}
	}

	public function fb_login()
	{
		echo $this->auth->fb_user_id();
		if($this->auth->fb_user_id())
		{
			
				$user_info = $this->auth_model->user_by_fb_id($this->auth->fb_user_id());
				if(!$this->auth_model->check_fb_id($this->auth->fb_user_id()) === TRUE)
			    {
					$name=$user_info->name;
					$username=$user_info->username;
					$password="";
					$email=$user_info->email;
					$activate = '0';
					$fb_id = $this->auth->fb_user_id();
					$this->auth_model->do_register($name, $username, $password, $email, $activate, $fb_id);
			    }
				$data = array(
						'username' => $user_info->username,
						'logged_in' => '1');

				$this->session->set_userdata($data);

				$this->auth->save_login($user_info->username);

				$level = $this->auth_model->get_level($this->auth_model->get_user()->level);

				redirect($this->logik->setting('default_url')."page/".$level->redirect);
			 
		} else {
			redirect($this->logik->setting('default_url'));
		}
	}

	public function login_ajax()
	{
		if($this->logik->setting('login') == '0' AND $this->logik->get_level() != '1')
		{
			redirect($this->logik->setting('default_url'));
		}
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[25]');

		if($this->form_validation->run() === FALSE)
		{
			echo json_encode(array('error' => '1', 'message' => validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>')));
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if($this->auth_model->do_login($username, $password) === FALSE)
			{
				$return = array('error' => '1', 'message' => '<div class="alert alert-error"><strong>Error!</strong> You did not enter valid credentials, please try again!</div>');
				echo json_encode($return);
			} else {
				if($this->input->post('remember_me') == 'remember')
				{
					$cookie = array(
    				'name'   => 'user_logik_cookie',
    				'value'  => $username,
    				'expire' => '604800'
					);

					$this->input->set_cookie($cookie);
				}

				$data = array(
					'username' => $username,
					'logged_in' => '1');
				$this->session->set_userdata($data);
				$this->auth->save_login($username);

					$level = $this->auth_model->get_level($this->auth_model->get_user()->level);

				echo json_encode(array('url' => $this->logik->setting('default_url')."page/".$level->redirect));
			}
		}
	}

	public function resend_activation_ajax()
	{
		$email = $this->input->post('email');

		$user = $this->auth_model->user_by_email($email);

		if($this->auth->send_activate_email($email, $user->activate, $user->name) === FALSE)
		{
			echo json_encode(array('error' => '1'));
		} else {
			echo json_encode(array('error' => '0'));
		}
	}

	public function unique_username_ajax()
	{
		$username = $this->input->post('user');

		if($this->user_model->username_check($username) === FALSE)
		{
			$error = '1';
		} else {
			$error = '0';
		}

		echo json_encode(array('error' => $error));
	}

	public function forgot_password() {
		$this->load->view('tmp', array('tmp' => 'main/forgot_password'));
	}
	
	public function isEmailExists() {
		if(!empty($_POST['email'])) {
			$this->db->select("id");
			$this->db->where("email",$_POST['email']);
			$res = $this->db->get("accounts")->row_array();
			if(!empty($res)) {
				echo json_encode(array('type'=>1));
			} else {
				echo json_encode(array('type'=>0));
			}
			exit;
		}
	}
	
	public function forgot_password_ajax()
	{
		$email = $this->input->post('email');
	
		$user = $this->auth_model->user_by_email($email);

		$reset_password = random_string('alnum', 16);

		$this->user_model->set_reset_password($user->username, $reset_password);

		if($this->auth->send_password_email($email, $reset_password, $user->name) === TRUE)
		{
			echo json_encode(array('error' => '0'));
		} else {
			echo json_encode(array('error' => '1'));
		}
	}

	public function reset_password()
	{
		$pass_key = $this->uri->segment(2);

		if($this->user_model->reset_check($pass_key) === TRUE)
		{
			//Create new password
			$password = random_string('alnum', 8);
			//Send new password over email
			$user = $this->user_model->set_new_password($password, $pass_key);
			//Email them the new password
			$this->auth->send_new_password($user->email, $password, $user->name);
			//Show the view
			$this->load->view('tmp', array('tmp' => 'main/reset', 'error' => '0'));
		} else {
			//Show the view
			$this->load->view('tmp', array('tmp' => 'main/reset', 'error' => '1'));
		}
	}

	public function send_contact_ajax()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$subject = $this->input->post('subject');
		$body = nl2br($this->input->post('body'));

		$this->email->from($email, $name);
		$this->email->to($this->logik->setting('admin_email'));
		$this->email->subject($subject);
		$this->email->message($body);

		if(!$this->email->send())
		{
			$error = '1';
		} else {
			$error = '0';
		}

		echo json_encode(array('error' => $error));

	}

	public function register_ajax()
	{
		if($this->logik->setting('registration') == '0')
		{
			redirect($this->logik->setting('default_url'));
		}
			//validation
			$this->form_validation->set_rules('full_name', 'Name', 'trim|required|min_length[4]|max_length[25]');
			$this->form_validation->set_rules('r_username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[accounts.username]');
			$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[25]');
			$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|min_length[4]|max_length[25]|matches[password1]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[4]|max_length[40]|valid_email|is_unique[accounts.email]');
			$this->form_validation->set_message('is_unique', 'Sorry but that %s is already in use!');

			if($this->form_validation->run() === FALSE)
			{
				echo json_encode(array('error' => '1', 'message' => validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>')));
			} else {
				if($this->logik->setting('recaptcha_public') != '0'){
				$privatekey = $this->logik->setting('recaptcha_private');
  				$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));
  				if(!$resp->is_valid){
  					echo json_encode(array('captcha_error' => '1', 'error' => '1'));
  				} else {
						if($this->logik->setting('email_activate') == '1')
						{
							$activate = random_string('alnum', 18);
						} else {
							$activate = '0';
						}

						//Collect our variables together
						$name = $this->input->post('full_name');
						$username = $this->input->post('r_username');
						$password = $this->input->post('password1');
						$email = $this->input->post('email');
						$fb_id = '0';

						if($this->auth_model->do_register($name, $username, $password, $email, $activate, $fb_id) === TRUE)
						{
							if($this->logik->setting('email_activate') == '1')
							{
								$this->auth->send_activate_email($email, $activate, $name);
								echo json_encode(array('error' => '0', 'message' => '<div class="alert alert-info"><strong>Almost Done!</strong> You have been registered, but you need to activate your account before you can login. Please check your email and click on the provided link to activate your account!</div>'));
							} else {
								if($this->logik->setting('welcome_email') == '1')
								{
									$this->logik->send_email($email, 'welcome');
								}
								echo json_encode(array('error' => '0', 'message' => '<div class="alert alert-success"><strong>Success!</strong> You have been registered!</div>'));
							}		
						} else {
							echo json_encode(array('error' => '1', 'message' => '<div class="alert alert-error"><strong>Error!</strong> An error occured, please try again!</div>'));
						}
				}
				} else {
					if($this->logik->setting('email_activate') == '1')
						{
							$activate = random_string('alnum', 18);
						} else {
							$activate = '0';
						}

						//Collect our variables together
						$name = $this->input->post('full_name');
						$username = $this->input->post('r_username');
						$password = $this->input->post('password1');
						$email = $this->input->post('email');
						$fb_id = '0';

						if($this->auth_model->do_register($name, $username, $password, $email, $activate, $fb_id) === TRUE)
						{
							if($this->logik->setting('email_activate') == '1')
							{
								$this->auth->send_activate_email($email, $activate, $name);
								echo json_encode(array('error' => '0', 'message' => '<div class="alert alert-info"><strong>Almost Done!</strong> You have been registered, but you need to activate your account before you can login. Please check your email and click on the provided link to activate your account!</div>'));
							} else {
								echo json_encode(array('error' => '0', 'message' => '<div class="alert alert-success"><strong>Success!</strong> You have been registered!</div>'));
							}		
						} else {
							echo json_encode(array('error' => '1', 'message' => '<div class="alert alert-error"><strong>Almost Done!</strong> An error occured, please try again!</div>'));
						}
				}
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
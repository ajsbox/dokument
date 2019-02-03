<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |_____________________
-- File: controllers/install.php |
-- ------------------------------/
*/

class Install extends CI_Controller {

	public function index()
	{
        $this->load->helper('form');
        //$submit = $this->input->post('install_data');
		if(!$this->input->post('install'))
		{
			$this->load->view('install/index', array('install' => '0'));
		} else {
	
	//if($this->input->post('type')==='mysqli') {
			//Users table
		  $query = "CREATE TABLE IF NOT EXISTS `accounts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(50) NOT NULL,
		  `password` varchar(40) NOT NULL,
		  `name` varchar(100) NOT NULL,
		  `lname` varchar(100) NOT NULL,
		  `groups` varchar(25) NOT NULL,
		  `document_groups` varchar(100) DEFAULT NULL,
		  `roles` text DEFAULT NULL,
		  `departments` varchar(25) NOT NULL,
		  `is_ldap` varchar(10) NOT NULL DEFAULT 'LOCAL',
		  `email` varchar(40) NOT NULL,
		  `level` int(11) NOT NULL,
		  `activate` varchar(18) NOT NULL,
		  `accounts` int(11) NOT NULL,
		  `image` varchar(300) NOT NULL,
		  `telephone` bigint(20) NOT NULL,
		  `calender` varchar(300) NOT NULL,
		  `date_joined` int(11) NOT NULL,
		  `modified` varchar(100) DEFAULT NULL,
		  `fb_id` int(11) NOT NULL,
		  `oauth_token` varchar(70) NOT NULL,
		  `oauth_token_secret` varchar(50) NOT NULL,
		  `reset_password` varchar(16) NOT NULL,
		  `status` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
		$this->db->query($query);
// user roles
	   $query = "CREATE TABLE IF NOT EXISTS `roles` (
	  `id` int(10) NOT NULL AUTO_INCREMENT,
	  `name` varchar(20) NOT NULL,
	  `owner` varchar(40) NOT NULL,
	  `action` varchar(25) NOT NULL,
	  `activate` varchar(18) NOT NULL,
	  `create_date` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$this->db->query($query);
	$query="INSERT INTO `roles` (`id`, `name`, `owner`, `action`, `activate`, `create_date`) VALUES
	(1, 'Cargar', 'admin', '1', '1', ".time()."),
	(2, 'Modificar', 'admin', '2', '1', ".time()."),
	(3, 'Borrar', 'admin', '3', '1', ".time()."),
	(4, 'Ver', 'admin', '4', '1', ".time().");";
	$this->db->query($query);
	
	// user roles
		$query = "CREATE TABLE IF NOT EXISTS `doc_types` (
	  `id` int(10) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `owner` varchar(40) NOT NULL,
	  `groups` varchar(25) NOT NULL,
	  `form_data` text NOT NULL,
	  `elements` text NOT NULL,
	  `publish` varchar(18) NOT NULL,
	  `table_name` varchar(255) DEFAULT NULL,
	  `activate` varchar(18) NOT NULL,
	  `create_date` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	$this->db->query($query);


	// group  roles
	  $query = "CREATE TABLE IF NOT EXISTS `groups` (
	  `id` int(10) NOT NULL AUTO_INCREMENT,
	  `name` varchar(250) NOT NULL,
	  `owner` varchar(200) NOT NULL,
	  `parent_id` int(11)  NOT NULL DEFAULT '0',
	  `roles` varchar(250) NOT NULL,
	  `is_ldap` varchar(20) NOT NULL,
	  `activate` varchar(18) NOT NULL DEFAULT '1',
	  `create_date` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	
	$this->db->query($query);
	
	$query = "INSERT INTO `groups` (`id`, `name`, `owner`, `roles`, `activate`, `create_date`) VALUES
(1, 'Admin', 'admin', '1,2,3,4,5,6,7', '1', ".time().");";
		$this->db->query($query);
		//Email templates table
		$query = "CREATE TABLE IF NOT EXISTS `email_temp` (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `name` varchar(40) NOT NULL,
		  `subject` varchar(100) NOT NULL,
		  `file_name` varchar(40) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);

				//Email template data
		$query = "INSERT INTO `email_temp` (`id`, `name`, `subject`, `file_name`) VALUES
		(1, 'Activation', 'Please Active Your Account', 'activate'),
		(2, 'Welcome', 'Welcome to our website', 'welcome'),
		(12, 'New Password', 'Your New Password', 'new_password'),
		(11, 'Forgot Password', 'Your Password Reset Request', 'forgot_password');";
		$this->db->query($query);



				//Levels table
		$query = "CREATE TABLE IF NOT EXISTS `levels` (
		  `id` int(5) NOT NULL AUTO_INCREMENT,
		  `name` varchar(25) NOT NULL,
		  `redirect` varchar(50) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);

				//Levels data
		$query = "INSERT INTO `levels` (`id`, `name`, `redirect`) VALUES
		(1, 'Admin', 'admin'),
		(2, 'User', 'user'),
		(3, 'Guest', 'guest');";

		$this->db->query($query);
		//Hits table
			$query = "CREATE TABLE IF NOT EXISTS `hits` (
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `p_id` int(10) NOT NULL,
		  `is_user` varchar(8) NOT NULL,
		  `date` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

			$this->db->query($query);
					//Menu table
			$query = "CREATE TABLE IF NOT EXISTS `menu` (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `name` varchar(25) NOT NULL,
		  `link` varchar(40) NOT NULL,
		  `order` int(2) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

				$this->db->query($query);

				//Menu data
			$query = "INSERT INTO `menu` (`id`, `name`, `link`, `order`) VALUES
			(1, 'Home', 'home', 1),
			(5, 'Register', 'register', 2),
			(3, 'Contact', 'contact', 4),
			(6, 'Login', 'login', 3);";

				$this->db->query($query);

				$query = "CREATE TABLE IF NOT EXISTS `modules` (
		  `id` int(5) NOT NULL AUTO_INCREMENT,
		  `module` varchar(25) NOT NULL,
		  `active` int(1) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);

				//Pages table
		$query = "CREATE TABLE IF NOT EXISTS `pages` (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `name` varchar(40) NOT NULL,
		  `slug` varchar(40) NOT NULL,
		  `levels` text NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);

		//Pages data
		$query = "INSERT INTO `pages` (`id`, `name`, `slug`, `levels`) VALUES
		(1, 'Home', 'home', '1,2,3');";

		$this->db->query($query);
		//Admin notes table
		$query = "CREATE TABLE IF NOT EXISTS `admin_notes` (
		  `id` int(2) NOT NULL AUTO_INCREMENT,
		  `notes` text NOT NULL,
		  `owner` varchar(25) NOT NULL,
		  `date` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);
		//Login table
			$query = "CREATE TABLE IF NOT EXISTS `login` (
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `username` varchar(40) NOT NULL,
		  `date` int(11) NOT NULL,
		  `ipaddress` varchar(100) NOT NULL,
		  `count` int(11) NOT NULL,
		  `time` bigint(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);
				//Settings table
		$query = "CREATE TABLE IF NOT EXISTS `settings` (
		`id` int(5) NOT NULL AUTO_INCREMENT,
		`setting` varchar(40) NOT NULL,
		`value` varchar(50) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

		$this->db->query($query);
		
		//// document files////
		$query = "CREATE TABLE IF NOT EXISTS `document_files` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `document_id` varchar(200) DEFAULT NULL,
		  `description` text,
		  `file_name` varchar(255) DEFAULT NULL,
		  `original_file_name` varchar(255) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `main_file` tinyint(2) NOT NULL DEFAULT '0',
		  `deleted` tinyint(2) DEFAULT 0,
		  `created` varchar(100) DEFAULT NULL,
		  `modified` varchar(100) DEFAULT NULL,
		  `user` varchar(200) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
		
		//// external_users////
		$query = "CREATE TABLE IF NOT EXISTS `external_users` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `email` varchar(100) DEFAULT NULL,
			  `description` text,
			  `created` varchar(100) DEFAULT NULL,
			  `modify` varchar(100) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
		
		/////// sent files///////
		$query = "CREATE TABLE IF NOT EXISTS `sent_documents` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `from_id` varchar(100) DEFAULT NULL,
		  `user_id` varchar(100) DEFAULT NULL,
		  `document_id` varchar(200) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `deleted` tinyint(2) DEFAULT 0,
		  `created` varchar(50) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
		
		////document comments/////
		/*$query = "CREATE TABLE IF NOT EXISTS `comments` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` varchar(100) DEFAULT NULL,
		  `document_id` varchar(200) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `created` varchar(50) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);*/
	//}
		
		/////// user histories ///////
		$query = "CREATE TABLE IF NOT EXISTS `user_histories` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` varchar(100) DEFAULT NULL,
		  `action` varchar(255) DEFAULT NULL,
		  `document_id` varchar(200) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `ip_address` varchar(100) DEFAULT NULL,
		  `mac_address` varchar(100) DEFAULT NULL,
		  `date_time` varchar(50) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
	
		/////// user histories ///////
		$query = "CREATE TABLE IF NOT EXISTS `ldap_config` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `hostname` varchar(255) DEFAULT NULL,
		  `portname` varchar(100) DEFAULT NULL,
		  `encryption_method` varchar(255) DEFAULT NULL,
		  `base_dn` varchar(255) DEFAULT NULL,
		  `base_group_dn` varchar(255) DEFAULT NULL,
		  `filter` varchar(255) DEFAULT NULL,
		  `group_filter` varchar(255) DEFAULT NULL,
		  `attributes` varchar(255) DEFAULT NULL,
		  `group_attributes` varchar(255) DEFAULT NULL,
		  `method_parameters` varchar(255) DEFAULT NULL,
		  `bind_user` varchar(255) DEFAULT NULL,
		  `bind_password` varchar(255) DEFAULT NULL,
		  `current` int(2) DEFAULT '1',
		  `created` varchar(100) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
	
		/////// document histories ///////
		$query = "CREATE TABLE IF NOT EXISTS `doc_histories` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` varchar(100) DEFAULT NULL,
		  `action` varchar(255) DEFAULT NULL,
		  `document_id` varchar(200) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `ip_address` varchar(100) DEFAULT NULL,
		  `mac_address` varchar(100) DEFAULT NULL,
		  `date_time` varchar(50) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
		
        //Settings data
        $url = $this->input->post('site_url');

			if(end(str_split($url)) != "/")
			{
				$url .= "/";
			}
			$settings = array(
				'admin_email' => $this->input->post('admin_email'),
				'site_title' => $this->input->post('site_title'),
				'header_title' => $this->input->post('header_title'),
				'default_url' => $url,
				'registration' => '1',
				'login' => '1',
				'email_activate' => '0',
				'welcome_email' => '0',
				'default_page' => '1',
				'default_level' => '2',
				'fb_appid' => '0',
				'fb_secret' => '0',
				'consumer_key' => '2',
				'consumer_secret' => '2',
				'recaptcha_public' => '2',
				'recaptcha_private' => '2',
				'language'      => $this->input->post('language'),
				'time_banned' => $this->input->post('hour').':'.$this->input->post('minute').':'.$this->input->post('second'),
				'banned_attempt' => $this->input->post('banned_attempt'),
				'password_length' => '1'
				);

			foreach($settings as $key => $value)
			{
				$this->db->insert('settings', array('setting' => $key, 'value' => $value));
			}

			//Admin data
			$admin = array(
				'username' => $this->input->post('admin_username'),
				'password' => sha1($this->input->post('admin_password')),
				'name' => $this->input->post('admin_name'),
				'email' => $this->input->post('admin_email'),
				'level' => '1',
				'activate' => '1',
				'date_joined' => time(),
				'reset_password' => '0');

                $this->db->insert('accounts', $admin);
			$this->load->view('install/index', array('install' => '1'));
		}

	}

	public function update()
	{
		$query = "CREATE TABLE IF NOT EXISTS `modules` (
	  `id` int(5) NOT NULL AUTO_INCREMENT,
	  `module` varchar(25) NOT NULL,
	  `active` int(1) NOT NULL,
	  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

		$this->db->query($query);

		$data = array('module' => 'support', 'active' => '0');
		$this->db->insert('modules', $data);

		$this->load->view('tmp', array('tmp' => 'main/upgrade'));

		//Admin notes table
		$query = "CREATE TABLE IF NOT EXISTS `admin_notes` (
		  `id` int(2) NOT NULL AUTO_INCREMENT,
		  `notes` text NOT NULL,
		  `owner` varchar(25) NOT NULL,
		  `date` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->db->query($query);
	}

}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |______________________
-- File: models/setting_model.php |
-- -------------------------------/
*/

class Setting_model extends CI_Model {
	
	public $external_js=array();
	public $external_style=array();
	function __construct()
	    {
	        parent::__construct();
	    }

	public function get_settings($setting)
	{
		$this->db->where('setting', $setting);
		return $this->db->get('settings')->row();
	}

	public function get_modules($name)
	{
		$this->db->where('module', $name);
		return $this->db->get('modules')->row();
	}

	public function default_page($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('pages')->row()->slug;
	}
	
	/* include the file  js  */
   
    public function include_js()
   {
	   $file=$this->external_js;
	   if(count($file) > 0)
	 {
	  foreach($file  as $val)
	  {
	  echo"<script type='text/javascript' src='".$val.".js'></script>\n";
	  
	  }
	 }
	  
   }
   /* include the css file */
   
   public  function include_css()
   {
	   $file=$this->external_style;
	   
	 if(count($file) > 0)
	 {
	  foreach($file  as $val)
	  {
	  echo"<link  type='text/css' rel='stylesheet' href='".$val.".css' />\n";
	  
	  }
	 }
   }

}
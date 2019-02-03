<?php 
if($this->session->userdata('username'))
define("USER_LEVEL", $this->auth_model->get_user()->level);
else 
define("USER_LEVEL", 3);
define("SERVER",$this->logik->setting("default_url"));

if(isset($copyright) and $copyright==1) {
	$this->load->view($tmp);
	exit;
}
$this->load->view('inc/header');
$this->load->view($tmp);
$this->load->view('inc/footer');
?>
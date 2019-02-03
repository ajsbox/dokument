<?php
session_start();
$session_id=session_id();
$id_of_form_string=json_decode($_REQUEST['form'],true);
$id_of_form=$id_of_form_string["id"];
$_SESSION['ID_FORM']=$id_of_form;

foreach($_REQUEST as $key=>$val)
{
	
	$_SESSION[$key]=json_decode($val,true);
	$file_name=$id_of_form."$key".session_id().".json";
	fopen($file_name,'w+');
	file_put_contents($file_name,str_replace('"object":"",','',$val));
}
$out["status"]="ok";
$out["message"]=$session_id;
echo json_encode($out);
?>
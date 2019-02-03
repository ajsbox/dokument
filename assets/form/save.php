<?php
session_start();
$session_id=session_id();
require_once "mysql_connection.php";
$id_of_form_string=json_decode($_REQUEST['form'],true);
$id_of_form=$id_of_form_string["id"];
$query=$get_db->query("select form_id from form where form_id='$id_of_form'");
$value_form=mysqli_real_escape_string($get_db->connection,$_REQUEST['form']);
$value_form=str_replace("\\","",$value_form);
$today=time();
if($get_db->countRows($query) > 0)
{
	$query=$get_db->query("delete from form_elements where  form_id='$id_of_form'");
	$query=$get_db->query("update form set `values`='".$value_form."' where form_id='$id_of_form'");
$_SESSION['ID_FORM']=$id_of_form;
}
else
{
	
	$query=$get_db->query("insert into form(`session_id`,`update`,`values`)values('$session_id','$today','".$value_form."')");
	$id_of_form=$get_db->last_id;
	$_SESSION['ID_FORM']=$id_of_form;
	$value_form=str_replace('"id":0','"id":'.$id_of_form,$value_form);
	$query=$get_db->query("update form set `values`='".$value_form."'");
}
$value_elements=json_decode($_REQUEST['elements'],true);
$i=1;
foreach($value_elements['elements'] as $val)
{
	$position_id=$i;
	$values=json_encode($val);
	$values=mysqli_real_escape_string($get_db->connection,$values);
	$values=str_replace("\\","",$values);
	$values=str_replace('"object":"",','',$values);
	$query=$get_db->query("insert into form_elements(`form_id`,`position_id`,`update`,`values`)values('$id_of_form','$position_id','$today','".$values."')");
	
	$i++;
	
	
}
exit;
$out["status"]="ok";
$out["message"]=$session_id;
//echo json_encode($out);
?>
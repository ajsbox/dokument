<?php

/*mysql_connect("localhost", "root", "")or die(mysql_error());
mysql_select_db("dms") or die(mysql_error());
$sql = "insert into hits('p_id', 'is_user', 'date') values('2', 'user', '4453444')";
mysql_query($sql) or die(mysql_error());*/
	
//mysql_connect("localhost","arulphpd_ananth","ananth123");
//mysql_select_db("arulphpd_dms");
//session_start();
//print_r($_SESSION);exit;

	//mysql_connect("localhost","root","");
	//mysql_select_db("dokument");

	$fileTempName = $_FILES['RemoteFile']['tmp_name'];
	$fileSize = $_FILES['RemoteFile']['size'];
	$fileName = $_FILES['RemoteFile']['name'];
	//**********************************
        //$extraInfo = $_POST['ExtraInfo'];
	//save extra info here
	//**********************************
	$path = "../";
	if(!is_dir($path.'scan_cache')) {
		mkdir($path.'scan_cache', 0777);
	} else {
		$oldFiles = scandir($path.'scan_cache');
		foreach($oldFiles as $fle) {
			if($fle!='.' and $fle!='..') {
				unlink($path."scan_cache/".$fle);
			}
		}
	}
	if(file_exists($path.'scan_cache'.'/'.$fileName))
		$fWriteHandle = fopen($path.'scan_cache'.'/'.$fileName, 'w');
	else
		$fWriteHandle = fopen($path.'scan_cache'.'/'.$fileName, 'w');
	$fReadHandle = fopen($fileTempName, 'rb');
	$fileContent = fread($fReadHandle, $fileSize);
	fwrite($fWriteHandle, $fileContent);
	fclose($fWriteHandle);
?>
<?php
	mysql_connect("localhost","root","");
	mysql_select_db("dokument");
	$fileTempName = $_FILES['RemoteFile']['tmp_name'];
	$fileSize = $_FILES['RemoteFile']['size'];
	$fileName = $_FILES['RemoteFile']['name'];
	
	//**********************************
        //$extraInfo = $_POST['ExtraInfo'];
	//save extra info here
	//**********************************
	$path = "../";
	$docId = explode('___', $fileName);
	$id = 0;
	if(isset($docId[1])) {
		$id = $docId[1];
	}
	if(empty($docId[2])) {
		$sql = "select *from document_files where id='".$id."'";
		$row = mysql_fetch_assoc(mysql_query($sql));
		if(file_exists($path.$row['table_name'].'/'.$row['file_name'])) {
			unlink($path.$row['table_name'].'/'.$row['file_name']);
		}
		
		if(file_exists($path.$row['table_name'].'/'.$fileName))
			$fWriteHandle = fopen($path.$row['table_name'].'/'.$fileName, 'w');
		else
			$fWriteHandle = fopen($path.$row['table_name'].'/'.$fileName, 'w');
	} else {
		if(file_exists($path.$docId[2]))
			$fWriteHandle = fopen($path.$docId[2].'/'.$fileName, 'w');
		else {
			mkdir($path.$docId[2]);
			$fWriteHandle = fopen($path.$docId[2].'/'.$fileName, 'w');
			}
	}
	$fReadHandle = fopen($fileTempName, 'rb');
	session_start();
	
	$fileContent = fread($fReadHandle, $fileSize);
	fwrite($fWriteHandle, $fileContent);
	fclose($fWriteHandle);
	if(empty($docId[2])) {
		$docData = mysql_fetch_assoc(mysql_query("select document_id, table_name, user from document_files where id='".$id."'"));
		if(!empty($docId[0])) {
			$sql = "update document_files set description='".$docId[0]."', file_name='".$fileName."', modified='".time()."', user='".$_SESSION['username']."' where id='".$id."'";
		} else {
			$sql = "update document_files set file_name='".$fileName."', modified='".time()."', user='".$_SESSION['username']."' where id='".$id."'";
		}
		mysql_query($sql);

		$sql = "insert into user_histories (user_id, action, document_id, table_name, ip_address, date_time) values('".$docData['user']."', 'Agregar pagina (escaneada)', '".$docData['document_id']."', '".$docData['table_name']."', '".$_SERVER['REMOTE_ADDR']."', '".time()."')";
		mysql_query($sql);
	} else {
		$docData = mysql_fetch_assoc(mysql_query("select *from ".$docId[2]." where id='".$id."'"));
		$sql = "insert into document_files (document_id,description, file_name, table_name, created, user) values('".$id."', '".$docId[0]."', '".$fileName."', '".$docId[2]."', '".time()."', '".$_SESSION['username']."')";
		mysql_query($sql);
		
		$sql = "insert into user_histories (user_id, action, document_id, table_name, ip_address, date_time) values('".$docData['user_id']."', 'Escanear Documento', '".$id."', '".$docId[2]."', '".$_SERVER['REMOTE_ADDR']."', '".time()."')";
		mysql_query($sql);
	}
?>
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>-->
<style>
label {
color: #000000; 
font-family: Arial, Helvetica, sans-serif;
font-size: 80%;
}
.loaded {
color: #0000FF; 
font-family: Arial, Helvetica, sans-serif;
font-size: 80%;
}

</style>
<?php if($uploaded) { echo "<b class='loaded'>".$this->lang->line("file_uploaded_success")."</b>"; }?>
<form action="<?=$url?>user/addFiles" method="post" enctype="multipart/form-data" id="form2" name="form2">
	<!--<label id="fileLabel1" data-up='0'><b><a href="<?=$url?>user/scan/<?=$tableName?>/<?=$docId?>" class="pdfView"><input type="button" value="Scan archivo" class="btn"></a></b></label>-->
	<?php //if($this->user_model->checkValidRoles('Cargar')) {?>
	<?php //}?>
	<span style="position:absolute;" id="showUploader">
		<label><?=$this->lang->line("upload_files_desc")?></label><br>
		<textarea name="description" id="fileDesc" style="height:75px;width:300px;"></textarea>
		<br>
		<div id="description_error" style="display:none;color:#FF0000; font-family: Arial, Helvetica, sans-serif; font-size: 80%;"><strong>Error ! </strong> <?=$this->lang->line("doc_desc_req");?><br></div>
		<input type="file" id="file_upload" name="upload">
		<div id="file_error" style="display:none;color:#FF0000; font-family: Arial, Helvetica, sans-serif; font-size: 80%;"><br><strong>Error ! </strong><?=$this->lang->line("upload_file")?></div>
		<br><br>
		<input type="submit" value="<?=$this->lang->line("upload_file_button")?>" class="btn" onclick="return uploadValidate();">
		<input type="hidden" name="document_id" value="<?=$docId?>" />
		<input type="hidden" name="table_name" value="<?=$tableName?>" />
	</span>
</form>
<script>
function uploadValidate() {
	var desc=document.getElementById("fileDesc").value;
	
	if(desc=="")
	{
		hideAllErrorssigne();
		document.getElementById("description_error").style.display = "inline";
		document.getElementById("fileDesc").focus();
		return false;
	}
	var fname=document.getElementById("file_upload").value;
	if(fname=="")
	{
		hideAllErrorssigne();
		document.getElementById("file_error").style.display = "inline";
		return false;
	}
}
function hideAllErrorssigne()
{
	document.getElementById("description_error").style.display = "none";
	document.getElementById("file_error").style.display = "none";
				
}
</script>
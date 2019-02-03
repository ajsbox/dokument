<div class="row-fluid" style="background-color:#FFFFFF;">
	<div class="span9">
		<div id="tableMessage"></div>
      &nbsp;<b><?php echo $this->lang->line("send_users")?>:-</b><br>
 <div style="margin:20px 0px 0px 20px; width:60%;">
 <form action="<?=$this->logik->setting("default_url")?>user/editDocumentTypes" method="post" id="form1" name="form1">
        <select name="users[]" id="users" multiple id="selUsers" style="width:200px;">
               <?php
			   	foreach($users as $user) {?>
					<option value="<?=$user['username']?>"><?=ucfirst($user['name']).' '.ucfirst($user['lname'])?></option>
		 <?php }?>
               </select>
          	
                <br><div id="valid_user" style="display:none;color:#FF0000;"><strong>Error ! </strong> <?=$this->lang->line("doc_user_req")?></div>
          	<input type="checkbox" id="selAll">&nbsp;&nbsp;<?=$this->lang->line("select_all")?><br /><br />
			<div style="text-align:right;">
			<input type="hidden" name="id" value="<?=$this->uri->segment(3)?>" id="document_id">
			<input type="hidden" name="table" value="<?=$this->uri->segment(4)?>" id="table">
			<input type="hidden" value="Enviar" name="send" class="btn">
			<input type="button" value="<?=$this->lang->line("document_send")?>" name="send1" class="btn" id="sentBtn" style="height:31px; width:66px;">
			<!--<input type="submit" value="Cancel" name="cancel" class="btn">-->
         
			</div>
			</form>  
            <br />  

 		</div>
 </div>
  </div> 
  <link rel="stylesheet" type="text/css" href="<?=$this->logik->setting("default_url")?>assets/app/jquery.fancybox/fancybox/jquery.fancybox-1.3.2.css" media="screen" />
 	<link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/jquery.fancybox/style.css" />
 <script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.js"></script> 
<script>
$('#selAll').click(function(){
	var checked = $(this).attr('checked');
	if(checked) {
		var aSelect = document.form1.users;
		var aSelectLen = aSelect.length;
		for(i = 0; i < aSelectLen; i++) {
			aSelect.options[i].selected = true;
		}
	} else {
		var aSelect = document.form1.users;
		var aSelectLen = aSelect.length;
		for(i = 0; i < aSelectLen; i++) {
			aSelect.options[i].selected = false;
		}
	}
})

$("#sentBtn").click(function()
{ 

$.post("<?=$this->logik->setting("default_url")?>user/editDocumentTypes", $("#form1").serialize(), function(msg)
{

    if(msg.type==1)
	{
	 
	   $('#tableMessage').html("<h3><?=$this->lang->line("send_success")?></h3>");
	  //$("#form1 select option:eq(0)").attr("selected",true);
	 // $("#form1 input:checkbox").attr("checked",false);
	  //$('#tableMessage').html("sent successfully");
	  //$.fancybox.close();
	 //window.location.href = '<?=$this->logik->setting("default_url")?>user/my_documents';
	 //window.open ("http://jsc.simfatic-solutions.com",'', "status=1");
	}
},"json");
return false;
})

/*$('#sentBtn').click(function() {
	alert("hi");
	$("#fancybox-close").triggerHandler("click");
})*/


/*function userValidate() {
	var desc=document.getElementById("selUsers").value;
	if(desc=="")
	{
		hideAllErrorssigne();
		document.getElementById("valid_user").style.display = "inline";
		document.getElementById("selUsers").focus();
		return false;
	}  
}    
function hideAllErrorssigne() {
	document.getElementById("valid_user").style.display = "none";			
}*/
</script>
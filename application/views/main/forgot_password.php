
<div class="admin-form">
  <div class="container-fluid">

    <div class="row-fluid">
      <div class="span12">
      <?php echo validation_errors('<div class="alert alert-danger"><strong>Error!</strong> ', '</div>');if(!empty($error)){ ?>
<div class="alert alert-danger"><strong>Error :</strong> <?=$this->lang->line("upe");?></div>
<?php } ?>
        <!-- Widget starts -->
            <div class="widget">
              <!-- Widget head -->
              <div class="widget-head">
                <i class="icon-lock"></i> Olvidé mi contraseña 
              </div>

              <div class="widget-content">
                <div class="padd">
                  <!-- Login form -->
                  <form class="form-horizontal" method="post" action="<?=$this->logik->setting("default_url");?>main/forgot_password" id="form1">
                    <!-- Email -->
                    <div class="control-group">
                      <label class="control-label" for="inputEmail"> <?=$this->lang->line("enter_email");?></label>
                      <div class="controls">
                        <input type="text" value="<?=$this->input->cookie('user_logik_cookie');?>" id="email"  name="email"><br>
					<div id="error_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_email_require")?></div>
					<div id="error_valid_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_valide_require")?></div>
					<div id="error_email_not_exist" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_email_not_exist")?></div>
                      </div>
                    </div>
                   
                    <div class="control-group">
                      <div class="controls">
						
                        <br>
                        <input type="submit" class="btn" name="forget" value="enviar" onclick="return userSetting();">
                       
                      </div>
                    </div>
                  </form>
                </div>
                <div class="widget-foot">
                  <!-- Footer goes here -->
                </div>
              </div>
            </div>  
      </div>
    </div>
  </div> 
</div>
<script>
$(document).ready(function(){
	$("#form1").submit(function(){
		$.post("<?=$this->logik->setting("default_url")?>main/forgot_password_ajax", $("#form1").serialize(), function(msg)
		{
			if(msg.type==0)
			{
				hideAllErrorssignUser();
				document.getElementById("error_email_not_exist").style.display = "inline";
				document.getElementById("email").focus();
				return false;
			}
		},"json");
		return false;
	})
})
function userSetting()
{	
	var name=document.getElementById("email").value;
	if(name=="")
	{
		hideAllErrorssignUser();
		document.getElementById("error_email").style.display = "inline";
		document.getElementById("email").focus();
		return false;
	}
	filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(name)) {
		hideAllErrorssignUser();
		document.getElementById("error_valid_email").style.display = "inline";
		document.getElementById("email").focus();
		return false;
	}
	if(name!="")
	{
		//hideAllErrorssignUser();
		//document.getElementById("error_email_not_exist").style.display = "inline";
		//document.getElementById("email").focus();
		
		//return false;
		$.post("<?=$this->logik->setting("default_url")?>main/isEmailExists", "email="+name, function(msg)
		{
			if(msg.type==0)
			{
				hideAllErrorssignUser();
				document.getElementById("error_email_not_exist").style.display = "inline";
				document.getElementById("email").focus();
				return false;
			}
			else if(msg.type==1)
			{
			   $("#form1").submit();
			}
			},"json");
			
			return false;
	}

	return true;
}
function hideAllErrorssignUser()
{
	document.getElementById("error_email").style.display = "none";
	document.getElementById("error_valid_email").style.display = "none";
	document.getElementById("error_email_not_exist").style.display = "none";
}
</script>

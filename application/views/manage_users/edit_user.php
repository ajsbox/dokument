  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			  <h3><?=$this->lang->line("edit_user");?></h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
		  <form class="form-horizontal uni" action="<?php echo $this->logik->setting('default_url'); ?>manage_users/edit_in" method="post"  enctype="multipart/form-data" name="frm1" onSubmit="return validateUser()">
                           
                    <div class="control-group">
                    <div class="controls">
                      <label><h6><?=$this->lang->line("Username");?></h6></label>
                    <input type="text" name="username" id="username"  class="password" value="<?php echo $user['username']; ?>" >  				<br><div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_name_req");?></div> 
                     <div id="username_exists" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_name_exists");?></div>           
                    <div id="error_username_length" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("username_length");?></div>           
                                   
                    </div>
                    </div>
                    <div class="control-group">
                    <div class="controls">
                      <label><h6><?=$this->lang->line("fname");?></h6></label>
                    <input type="text" name="name"  id="fname" class="password" value="<?php echo $user['name']; ?>" >              <br>
                    <div id="error_fname" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_fname_req");?></div>
                    </div>
                    </div>                            
              
                      <div class="control-group">
                    <div class="controls">
                      <label><h6><?=$this->lang->line("lname");?></h6></label>
                    <input type="text" name="lname"  id="lname" class="password" value="<?php echo $user['lname']; ?>" >                        <br>
                    <div id="error_lname" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_lname_req");?></div>                        
                    </div>
                    </div>
                    
              <div class="control-group">
        		<div class="controls" id="select_modify">
                      <label><h6><?=$this->lang->line("Groups");?></h6></label>
					   <select name="groups[]" multiple="multiple">
                      <?php
					  	if(!empty($groups)) {
							$user_group=explode(",",$user["groups"]);
							foreach($groups as $val)
							{
								//echo "<label style='width: 100px;float:left;'><input type='checkbox' ";
								//if(in_array($val->id,$user_group)){echo" checked='checked'";}
								//echo"  name='groups[]' value='".$val->id."' />".ucfirst($val->name)."</label>";
						
								if(in_array($val->id, $user_group)) {
									echo '<option value="'.$val->id.'" selected>'.ucfirst($val->name).'</option>';
								} else {
									echo '<option value="'.$val->id.'">'.ucfirst($val->name).'</option>';
								}
							
							}
						} else {
							echo "<option value=''>No Groups</option>";
						}
                    ?>
					</select>
                  
                    <div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_group_req");?></div>
        		</div>
        	    </div>
			<?php
			if(!empty($groups)) {
				$userRoles = unserialize($user['roles']);
				foreach($groups as $val) {
					$display = "display:none;";
					if(array_key_exists($val->id, $userRoles)) {
						$display = "display:inline;";
					}
				?>
					<div class="control-group hide-roles" style="<?=$display?>" id="group-roles-<?=$val->id?>">
						<div class="controls" id="select_modify<?=$val->id?>">
						<label><h6><?=ucfirst($val->name).' '.$this->lang->line("rol");?></h6></label>
					
						 <select name="roles<?=$val->id?>[]" multiple="multiple">
							  <?php
								if(!empty($roles)) {
									foreach($roles as $rol)
									{
									$sel = '';
									if(in_array($rol->id, $userRoles[$val->id])) {
										$sel = "selected";
									}
									//echo "<label>";
									
										//echo "<input type='checkbox' value='".$val->id."' name='roles[]'>";
										
										//echo $val->name."</label>";
										echo '<option value="'.$rol->id.'" '.$sel.'>'.$rol->name.'</option>';
									
									}
								} else {
									echo "No Roles";
								}
							?>
						</select>
							<!--<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>-->
						</div>
					</div>
					
			<?php }
			}?>
			<div id="error_roles" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("doc_role_req");?></div>
			
			<div class="control-group">
				<div class="controls" id="select_modify">
                  <label><h6><?=$this->lang->line("user_loading_save");?></h6></label>
				   <div class="docSel">
					<select name="document_groups" class="option3" id="select_doc_group">
                      <?php
						if(!empty($groups)) {
							$doc_group=explode(",",$user["document_groups"]);
							foreach($groups as $val)
							{
								//echo "<label style='width: 100px;float:left;'><input type='checkbox'  name='groups[]' value='".$val->id."' />".ucfirst($val->name)."</label>";
								//echo '<option value="'.$val->id.'">'.ucfirst($val->name).'</option>';
								if(ucfirst($val->name)!='Admin') {
									if(in_array($val->id, $doc_group)) {
										echo '<option value="'.$val->id.'" selected>'.ucfirst($val->name).'</option>';
									} else {
										echo '<option value="'.$val->id.'">'.ucfirst($val->name).'</option>';
									}
								}
							}
						} else {
							echo "<option value=''>No Groups</option>";
						}
                    ?>
					</select>
				</div>
                    <div id="error_doc_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_doc_group_req");?></div>
        			<!--<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>-->
        		</div>
        	</div>
                <div class="control-group">
					<div class="controls">
						<label><h6><?=$this->lang->line("email");?></h6></label>
						<input type="text" name="email" id="email" class="password" value="<?php echo $user['email']; ?>" > <br>
						<div id="error_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_email_req");?></div> 
						<div id="error_valid_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_valid_email");?></div>                      
                    </div>
                    </div>
                    
                       <div class="control-group">
                    <div class="controls">
                      <label><h6><?=$this->lang->line("Telephone");?></h6></label>
                    <input type="text" name="telephone" placeholder="Telephone" id="telephone" class="password"value="<?php echo $user['telephone']; ?>" > <br>
                    <div id="error_telephone" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_telephone_req");?></div>                                            
                    </div>
                    </div>
                   <!--<div class="control-group">
                    <div class="controls">
                      <label style="font-size:14px; font-weight:bold;"><?$this->lang->line("Calender");?></label>
                    <!--<input type="text"  id="datepicker" name="calender" value=""  placeholder=""/>
                    <div class="input-append" id="datetimepicker1">
                        <input type="text" name="calender" data-format="yyyy-MM-dd" value="<?date('Y/m/d',strtotime($user['calender']))?>">
                        <span class="add-on">
                          <i data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar">
                          </i>
                        </span>
                      </div>
                                           
                    </div>
                    </div>-->
                    
                    <?php if($user['is_ldap']=='LDAP') {?>
						<div style="display:none;">
					<?php } else {?>
						<div>
					<?php }?>
                    <div class="control-group">
						<div class="controls">
						<label><h6><?=$this->lang->line("Password");?></h6></label>
						<input type="password" name="password" id="password"> <br>
						<div id="error_password" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_password_req");?></div>
						<div id="error_password_length" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_password_length");?></div>                        
						</div>
                    </div>
					
					<div class="control-group">
						<div class="controls">
						<label><h6><?=$this->lang->line("Password_confirm");?></h6></label>
						<input type="password" id="password_confirm"> <br>
						<div id="error_cnpassword" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_confirm_password_require");?></div>
						<div id="error_password_matched" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_password_matched");?></div>                        
						</div>
                    </div>
					</div>
                    <div class="control-group">
                    <div class="controls">
                    <label><h6><?=$this->lang->line("Status");?></h6></label>
                    <select name="activate" id="select" class="option3">

<option value="1" <?php if($user['activate']=='1'){ echo "selected";} ?>><?=$this->lang->line("Active");?></option>
<option value="0" <?php if($user['activate']=='0'){ echo "selected";} ?>><?=$this->lang->line("Inactive");?></option>

</select>
                                           
                    </div>
                    </div>
                    
                    
                      <div class="control-group">
                          <!-- 	<div class="form-actions">-->
                      <label><h6><?=$this->lang->line("Photo");?></h6></label>
                       <?php if($user['image']!='' && file_exists("./image_gallery/user/".$user['image'])){?>
                <img src="<?=$this->logik->setting('default_url')?>image_gallery/user/<?=$user['image']?>" height="110" width="110"  />
                <?php }else{ ?>
                <img src="<?=$this->logik->setting('default_url')?>image_gallery/user/blank.png" height="110" width="110"/>
                <?php } ?><br /><br />
<input type="file" name="file" size="20" style=" margin:5px 0 0 5px;">
<input type="hidden" name="image" value="<?=$user['image']?>" />
                     <!-- </div>-->
                    </div>
  
					   <input type="hidden" name="id" value="<?php echo $user['id']; ?>" id="user_id">
                        

                      <hr /> 
                         	<!--<div class="form-actions">-->
                      <button type="submit" name="submit" class="btn" ><?=$this->lang->line("edit");?></button>
                 <!-- </div>-->
                    </form><br>
				<input type="hidden" id="password_length" value="<?=$password_length?>">
	</div>
</div>
<script>
$(document).ready(function(){
setTimeout(function()
{
	$("#select_modify select").removeAttr("style")
	$("#select_modify #uniform-undefined span:first").remove()
	$("#select_modify #uniform-undefined").removeClass("selector")
	$(".controls .docSel span").remove();

},50)
 setTimeout(function()
{
$("#select_modifys select").removeAttr("style");
$("#select_modifys #uniform-undefined span:first").remove();
$("#select_modifys #uniform-undefined").removeClass("selector");
$("#uniform-select_doc_group").removeClass("selector");
$("#uniform-select span:first").remove();
$("#uniform-select").removeClass("selector");
$("#uniform-select #select").css({'opacity':'1'});
},50)

<?php
if(!empty($groups)) {
	foreach($groups as $val) {?>
		setTimeout(function()
		{
			$("#select_modify<?=$val->id?> select").removeAttr("style")
			$("#select_modify<?=$val->id?> #uniform-undefined span:first").remove()
			$("#select_modify<?=$val->id?> #uniform-undefined").removeClass("selector")
		},50)
<?php }
}?>
////for group and roles/////
$("#select_modify select").click(function() {
	var groups = $(this).val();
	if($.isArray(groups)) {
		$(".hide-roles").css("display","none");
		$("#select_modifys").css("display","none");
		$.each(groups, function( index, value ) {
			$("#group-roles-"+value).css("display","inline");
		});
	}
	//console.log(vale);
})
})
</script>
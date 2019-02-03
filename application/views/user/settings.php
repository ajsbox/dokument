  <div class="row-fluid">
	<?php $this->load->view('user/user_menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
              <!--<div class="pull-left">Configuracion General del Perfil<small> for pepe</small></div>-->
		<?php if(!isset($_POST['change_password']))  { echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); }?>
		<?php if(!empty($user_update)) { ?>
			<div class="alert alert-success user_update" style="margin-top:10px;"><strong>Exito!</strong> <?=$this->lang->line("yp");?></div>
			<?php } ?>
        <br>
       <h5 style="margin-left:0px;"><?=$this->lang->line("change_profile");?><?php //$this->lang->line("Hello");?></h5><br />
			<form action="update_profile" method="post" class="form-horizontal" enctype="multipart/form-data">
				<div style="float:left;">
                    <div class="control-group">
                        <div class="controls">
                        	<label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("fname");?>: </label>
                            <input type="text" name="name" value="<?php echo $this->auth_model->get_user()->name; ?>" class="password" id="fname"><br>
             <div id="error_fname" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_fname_require")?></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        <label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("lname");?>: </label>
                        <input type="text" name="lname" value="<?php echo $this->auth_model->get_user()->lname; ?>" class="password" id="lname"><br>
          <div id="error_lname" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_lname_require");?></div>
                        </div>
                    </div>
                    <div class="control-group">
                        
                        <div class="controls">
                        <label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("cn");?>: </label>
                        <input type="text" name="telephone" value="<?php echo $this->auth_model->get_user()->telephone; ?>" class="password" id="telephone"><br>
          <div id="error_contact" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_contact_require")?></div> 
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        <label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("Email");?> :</label>
                        <input type="text" name="email" value="<?php echo $this->auth_model->get_user()->email; ?>" class="password" id="email"><br>
          <div id="error_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_email_require")?></div>
          <div id="error_valid_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_valide_require")?></div>
                        </div>
                    </div>
                    <div class="form-actions" style="padding-left:4px;">
                        <input type="submit" class="btn" value="<?=$this->lang->line("user_update_button")?>" onClick="return userSetting()">
                    </div>
                </div>
                <div style="float:left; margin-left:80px;">
					<?php if($this->auth_model->get_user()->image) {
							$image = $this->auth_model->get_user()->image;
						  } else {
							$image = "blank.png";
						  }?>
                	<img src="<?=$this->logik->setting('default_url')?>image_gallery/user/<?=$image;?>" width="120px" height="150px" />
                   <br />
               <!--  <div class="control-group">
  
                    <div class="controls">-->
                       <input class='file' type='file' name="image"/>
            <!--        </div>
                  </div>-->
                </div>
                <div style="clear:both;"></div>
			</form>
			<hr>
		<?php if($this->auth_model->get_user()->is_ldap == "LOCAL") { ?>
				<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); ?>
				<h5 style="margin-left:0px;"><?=$this->lang->line("cp");?></h5><br />
				<?php if(!empty($password_update)) { ?>
				<div class="alert alert-success user_password"><strong>Exito!</strong> <?=$this->lang->line("aa");?></div><?php } ?>
				<?php if(!empty($password_error)) { ?>
				<div class="alert alert-error user_password"><strong>Error!</strong> <?=$this->lang->line("yo");?></div><?php } ?>
				<form action="update_password" method="post" class="form-horizontal">
					<div class="control-group">
						
						<div class="controls">
						<label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("op");?>:</label>
						<input type="password" name="old_password" class="password" id="old_password"><br>
						<div id="error_old_password" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_old_password_require")?></div>
							<span class="help-block"><?=$this->lang->line("pey");?></span>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("np");?> :</label>
							<input type="password" name="new_password1" class="password" id="new_password"><br>
							 <div id="error_new_password" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_new_password_require")?></div>
							<span class="help-block"><?=$this->lang->line("pey1");?></span>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
						<label style="font-size:12px; font-weight:bold;"><?=$this->lang->line("cnp");?>: </label>
						<input type="password" name="new_password2" class="password" id="confirm">
						<br>
							 <div id="error_confirm" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_confirm_password_require")?></div>
							 <div id="error_match_confirm" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_matched_confirm_require")?></div>
							<span class="help-block"><?=$this->lang->line("pcy");?></span>
						</div>
					</div>
					<div class="form-actions" style="padding-left:4px;">
						<input type="submit" name="change_password" class="btn" value="<?=$this->lang->line("user_change_password")?>" onClick="return userChangePassword()">
					</div>
				</form>
		<?php }?>
	</div>
</div>
<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<ul class="nav nav-pills" style="display:none;">
  			<li class="settingLink <?php if($current == 'general'){ echo 'active'; } ?>" data-tab="general"><a href="#"><?=$this->lang->line("General");?></a></li>
  			<li class="settingLink <?php if($current == 'social'){ echo 'active'; } ?>" data-tab="social" ><a href="#"><?=$this->lang->line("Social");?></a></li>
  			<li class="settingLink <?php if($current == 'captchaEdit'){ echo 'active'; } ?>" data-tab="captchaEdit"><a href="#"><?=$this->lang->line("Captcha");?></a></li>
		</ul>
		<div class="well1 show" id="generalSettings" style="display: none1;">
			<br>
			<?php if(!empty($update)) { echo '<div class="alert alert-success"> '.$this->lang->line("setting_success").'</div>'; } ?>
			<h3><?=$this->lang->line("gs");?></h3>
			<p><?=$this->lang->line("ym");?></p>
			<form action="<?php echo $this->logik->setting('default_url')."admin/settings"; ?>" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label1" for="site_title1"><b><?=$this->lang->line("wt");?></b></label>
					<div class="controls">
						<input type="text" name="site_title" value="<?php echo $this->logik->setting('site_title'); ?>">
						<span class="help-block"><?=$this->lang->line("ts");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label1" for="header_title1"><b><?=$this->lang->line("mh");?></b></label>
					<div class="controls">
						<input type="text" name="header_title" value="<?php echo $this->logik->setting('header_title'); ?>">
						<span class="help-block"><?=$this->lang->line("tsd");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label1" for=""><b><?=$this->lang->line("password_length");?></b></label>
					<div class="controls">
						<select name="password_length">
							<option <?php if($this->logik->setting('password_length') == '0') { echo "selected=\"selected\" "; } ?> value="0"><?=$this->lang->line("no");?></option>
							<option <?php if($this->logik->setting('password_length') == '1') { echo "selected=\"selected\" "; } ?> value="1"><?=$this->lang->line("yes");?></option>
						</select>
					</div>
				</div>
				<!--
				<div class="control-group">
					<label class="control-label" for="default_url"><?=$this->lang->line("dw");?></label>
					<div class="controls">
						<input type="text" name="default_url" value="<?php echo $this->logik->setting('default_url'); ?>">
						<span class="help-block"><?=$this->lang->line("td");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="admin_email"><?=$this->lang->line("dc");?></label>
					<div class="controls">
						<input type="text" name="admin_email" value="<?php echo $this->logik->setting('admin_email'); ?>">
						<span class="help-block"><?=$this->lang->line("ti");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="registration"><?=$this->lang->line("ar");?></label>
					<div class="controls">
						<select id="registration" name="registration">
							<option <?php if($this->logik->setting('registration') == '0'){ echo "selected=\"selected\" "; } ?> value="0"><?=$this->lang->line("no");?></option>
							<option <?php if($this->logik->setting('registration') == '1'){ echo "selected=\"selected\" "; } ?> value="1"><?=$this->lang->line("yes");?></option>
						</select>
						<span class="help-block"><?=$this->lang->line("dy");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="login"><?=$this->lang->line("au");?></label>
					<div class="controls">
						<select name="login">
							<option <?php if($this->logik->setting('login') == '0'){ echo "selected=\"selected\" "; } ?> value="0"><?=$this->lang->line("no");?></option>
							<option <?php if($this->logik->setting('login') == '1'){ echo "selected=\"selected\" "; } ?> value="1"><?=$this->lang->line("yes");?></option>
						</select>
						<span class="help-block"><?=$this->lang->line("cr");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email_activate"><?=$this->lang->line("ev");?></label>
					<div class="controls">
						<select name="email_activate">
							<option <?php if($this->logik->setting('email_activate') == '0'){ echo "selected=\"selected\" "; } ?> value="0"><?=$this->lang->line("no");?></option>
							<option <?php if($this->logik->setting('email_activate') == '1'){ echo "selected=\"selected\" "; } ?> value="1"><?=$this->lang->line("yes");?></option>
						</select>
						<span class="help-block"><?=$this->lang->line("su");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="welcome_email"><?=$this->lang->line("sa");?></label>
					<div class="controls">
						<select name="welcome_email">
							<option <?php if($this->logik->setting('welcome_email') == '0'){ echo "selected=\"selected\" "; } ?> value="0"><?=$this->lang->line("no");?></option>
							<option <?php if($this->logik->setting('welcome_email') == '1'){ echo "selected=\"selected\" "; } ?> value="1"><?=$this->lang->line("yes");?></option>
						</select>
						<span class="help-block"><?=$this->lang->line("sur");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="default_page"><?=$this->lang->line("dw");?></label>
					<div class="controls">
						<select name="default_page">
							<?php foreach($pages as $p): ?>
							<option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="help-block"><?=$this->lang->line("td");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for=""><?=$this->lang->line("du");?></label>
					<div class="controls">
						<select name="default_level">
							<?php foreach($levels as $l): ?>
							<option value="<?php echo $l['id']; ?>"><?php echo $l['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="help-block"><?=$this->lang->line("wu");?></span>
					</div>
				</div>
				-->
				<div class="form-actions1">
					<input type="submit" name="update_settings" class="btn" value="<?=$this->lang->line("admin_setting_button");?>">
				</div>
			</form>
			<br/><br/>
			<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); ?>
				<h3 style="margin-left:0px;"><?=$this->lang->line("cp");?></h3><br />
				<?php if(!empty($password_update)) { ?>
				<div class="alert alert-success user_password"><strong>Success!</strong> <?=$this->lang->line("aa");?></div><?php } ?>
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
		</div>

		<div class="well" id="socialSettings" style="display: none;">
			<h1><?=$this->lang->line("ss");?></h1>
			<p>You may edit your social website settings below.<?=$this->lang->line("ad");?></p>
			<?php if(!empty($update_social)) { echo '<div class="alert alert-success"><strong>Success!</strong> The settings have been updated!</div>'; } ?>
			<form action="<?php echo $this->logik->setting('default_url')."admin/social_settings"; ?>" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="fb_appid"><?=$this->lang->line("fa");?> </label>
					<div class="controls">
						<input type="text" name="fb_appid" value="<?php echo $this->logik->setting('fb_appid'); ?>">
						<span class="help-block"><?=$this->lang->line("fe");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fb_secret"><?=$this->lang->line("fc");?></label>
					<div class="controls">
						<input type="text" name="fb_secret" value="<?php echo $this->logik->setting('fb_secret'); ?>">
						<span class="help-block"><?=$this->lang->line("pe1");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tw_consumer_key"><?=$this->lang->line("tc");?></label>
					<div class="controls">
						<input type="text" name="tw_consumer_key" value="<?php echo $this->logik->setting('consumer_key'); ?>">
						<span class="help-block"><?=$this->lang->line("pe2");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tw_consumer_secret"><?=$this->lang->line("tcs");?></label>
					<div class="controls">
						<input type="text" name="tw_consumer_secret" value="<?php echo $this->logik->setting('consumer_secret'); ?>">
						<span class="help-block"><?=$this->lang->line("peu");?></span>
					</div>
				</div>
				<div class="form-actions">
					<input type="submit" name="social_settings" class="btn btn-primary" value="Update">
				</div>
			</form>
		</div>

		<div class="well" id="captchaEditSettings" style="display: none;">
			<h1><?=$this->lang->line("cs1");?></h1>
			<p><?=$this->lang->line("yme");?></p>
			<?php if(!empty($update_captcha)) { echo '<div class="alert alert-success"><strong>Success!</strong> The settings have been updated!</div>'; } ?>
			<form action="<?php echo $this->logik->setting('default_url')."admin/captcha_settings"; ?>" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="recaptcha_public"><?=$this->lang->line("rp");?></label>
					<div class="controls">
						<input type="text" name="recaptcha_public" value="<?php echo $this->logik->setting('recaptcha_public'); ?>">
						<span class="help-block"><?=$this->lang->line("fi");?></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="recaptcha_private"><?=$this->lang->line("rpk");?></label>
					<div class="controls">
						<input type="text" name="recaptcha_private" value="<?php echo $this->logik->setting('recaptcha_private'); ?>">
						<span class="help-block"><?=$this->lang->line("fit");?></span>
					</div>
				</div>
				<div class="form-actions">
					<input type="submit" name="captcha_settings" class="btn btn-primary" value="Update">
				</div>
			</form>
		</div>


	</div>
</div>
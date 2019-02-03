<div class="span6 offset3 gallery" style="margin-top: 40px; margin-bottom: 58px;">
<h3 style="padding-left: 25px;">Sign Up:</h3>
<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>');
if(!empty($captcha_error)){
    echo '<div class="alert alert-error"><strong>Error!</strong> You did not enter the correct words from the image, please try again!</div>';
} 
if(!empty($success)){ 
	if($this->logik->setting('email_activate') == '0') { ?>
<div class="alert alert-success"><strong>Success!</strong> <?=$this->lang->line("you");?></div>
<?php } else { ?>
<div class="alert alert-info"><strong>Almost Done!</strong> <?=$this->lang->line("yhv");?></div>
<?php }} else { ?>
<form class="form-horizontal form-search well" action="<?php echo $this->logik->setting('default_url'); ?>register" method="post">
	<div class="control-group">
        <label class="control-label" for="full_name"><?=$this->lang->line("Name");?>:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-info-sign"></i></span>
        <input type="text" name="full_name" placeholder="Enter your name." class="search-query">
        </div></div></div>
        <div class="control-group username_control">
        <label class="control-label" for="username"><?=$this->lang->line("Username");?>:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-user"></i></span>
        <input type="text" name="r_username" placeholder="Pick a username." class="search-query" id="modal_unique">
        </div>
        <span class="help-block" id="modal_span" style="padding-left: 25px;"></span>
        </div></div>
        <div class="control-group">
        <label class="control-label" for="password1"><?=$this->lang->line("Password");?>:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-lock"></i></span>
        <input type="password" name="password1" class="search-query">
        </div></div></div>
        <div class="control-group">
        <label class="control-label" for="password2"><?=$this->lang->line("pc");?>:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-lock"></i></span>
        <input type="password" name="password2" class="search-query">
        </div></div></div>
        <div class="control-group">
        <label class="control-label" for="email"><?=$this->lang->line("Email");?>:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-envelope"></i></span>
        <input type="text" name="email" placeholder="Enter your email." class="search-query">
        </div></div></div>
        <?php if($this->logik->setting('recaptcha_public') != '0'): ?>
        <div class="control-group">
            <label class="control-label"><?=$this->lang->line("are");?></label>
            <div class="controls">
            <?php
          $publickey = $this->logik->setting('recaptcha_public');
          echo recaptcha_get_html($publickey);
        ?>
        </div></div><?php endif; ?>

        <div class="form-actions" style="margin-bottom: 0px; padding-bottom: 0px;">
        <input type="submit" class="btn btn-primary search-query" name="register" value="Register!" id="registerModalsubmit">
        </div>
</form>
<?php if($this->logik->setting('fb_appid') != '0' AND $this->logik->setting('consumer_key') != '0'): ?>
<div class="row" style="text-align: center; padding-bottom: 10px;">
        <a href="<?php echo $this->auth->fb_login_url(); ?>"><img src="<?php echo $this->logik->setting('default_url'); ?>/assets/img/facebook.png" height="35%" width="35%" border="0"></a>
        <a href="<?php echo $this->logik->setting('default_url')."main/twitter_redirect"; ?>"><img src="<?php echo $this->logik->setting('default_url'); ?>/assets/img/twitter.png" height="35%" width="35%" border="0"></a>
</div>
<?php endif; ?>
<?php } ?>
</div>
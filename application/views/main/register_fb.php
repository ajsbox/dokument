<div class="span5 offset3">
<h3>Finish Registration:</h3>
<?php $user_info = $this->auth->fb_user_info(); ?>
<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
if(!empty($success)){ 
	if($this->logik->setting('email_activate') == '0') { ?>
<div class="alert alert-success"><strong>Success!</strong> You have been registered!</div>
<?php } else { ?>
<div class="alert alert-info"><strong>Almost Done!</strong> You have been registered, but you need to activate your account before you can login. Please check your email and click on the provided link to activate your account!</div>
<?php }} else { ?>
<p>Your registration is almost complete, please finish filling in the form below. We took the liberty of prefilling some of the data based on your Facebook profile.</p>
<form class="form-horizontal form-search well" action="<?php echo $this->logik->setting('default_url'); ?>main/register_fb" method="post">
	<div class="control-group">
        <label class="control-label" for="full_name">Name:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-info-sign"></i></span>
        <input type="text" name="full_name" value="<?php echo $user_info['name']; ?>" class="search-query">
        </div></div></div>
        <div class="control-group">
        <label class="control-label" for="username">Username:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-user"></i></span>
        <input type="text" name="r_username" value="<?php echo $user_info['username']; ?>" class="search-query">
        </div></div></div>
        <div class="control-group">
        <label class="control-label" for="password1">Password:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-lock"></i></span>
        <input type="password" name="password1" class="search-query">
        </div></div></div>
        <div class="control-group">
        <label class="control-label" for="password2">Password Confirmation:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-lock"></i></span>
        <input type="password" name="password2" class="search-query">
        </div></div></div>
        <div class="control-group">
        <label class="control-label" for="email">Email:</label>
        <div class="controls">
            <div class="input-prepend">
      <span class="add-on"><i class="icon-envelope"></i></span>
        <input type="text" name="email" value="<?php echo $user_info['email']; ?>" class="search-query">
        </div></div></div>
        <div class="form-actions" style="margin-bottom: 0px; padding-bottom: 0px;">
        <input type="submit" class="btn btn-primary search-query" name="register" value="Register!">
        </div>
</form>
<?php } ?>
</div>
<style>
.control-label{margin-right:20px;margin-left:20px;}
.controls1{margin-left:130px;}
</style>
<style type="text/css">

body{background: #FFF}
html,body{
    position: relative;
    height: 100%;
}
.card-container.card {
    max-width: 280px;
    padding: 40px 40px;
}

.btn {
    font-weight: 700;
    height: 36px;
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    cursor: default;
}
#output2{
    position: absolute;
    width: 300px;
    top: -75px;
    left: 0;
    color: #fff;
}

#output2.alert-success{
    background: rgb(25, 204, 25);
}

#output2.alert-danger{
    background: rgb(228, 105, 105);
}
/*
 * Card component
 */
.card {
    background-color: #F7F7F7;
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}

/*
 * Form styles
 */
.profile-name-card {
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin: 10px 0 0;
    min-height: 1em;
}

.reauth-email {
    display: block;
    color: #404040;
    line-height: 2;
    margin-bottom: 10px;
    font-size: 14px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin #inputEmail,
.form-signin #inputPassword {
    direction: ltr;
    height: 44px;
    font-size: 16px;
}

.form-signin input[type=email],
.form-signin input[type=password],
.form-signin input[type=text],
.form-signin button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    z-index: 1;
    position: relative;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    border-color: rgb(104, 145, 162);
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
}

.forgot-password {
    color: rgb(104, 145, 162);
}

.forgot-password:hover,
.forgot-password:active,
.forgot-password:focus{
    color: rgb(12, 97, 33);
}

input:focus:invalid:focus, textarea:focus:invalid:focus, select:focus:invalid:focus {
    border-color: #2297E1;
    box-shadow: 0px 0px 6px #35CFF9;
}
input:focus:invalid, textarea:focus:invalid, select:focus:invalid {
    color: #2297E1;
    border-color: #35CFF9;
}
</style>
<div class="containers">
    <div class="card card-container"> 
    <?php    
    if(!empty($error)){        
      echo "<div id=\"output\" class=\"alert alert-danger animated fadeInUp\">";
      //echo"Error: ";
      if ($error ==2) {
        echo $this->lang->line("upe");
      }elseif(!empty($error) && $error ==3) {
        echo $this->lang->line("user_not_activated");
      }elseif(!empty($error) && $error=='ldap_user') {
        echo $this->lang->line("ldap_user_not_exists");
      }
      echo"</div>";
    }
    ?>                
        <p id="profile-name" class="profile-name-card"><?=$this->lang->line("star_sesion_text");?></p>        
        <form class="form-signin" method="post" action="<?=$this->logik->setting("default_url");?>login"> 
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" value="<?=$this->input->cookie('user_logik_cookie');?>" id="inputEmail" name="username" class="form-control" placeholder="<?=$this->lang->line("login_user_name");?>" required autofocus>
            <input type="password" value="<?=$this->input->cookie('password');?>" id="inputPassword" name="password" class="form-control" placeholder="<?=$this->lang->line("Password");?>" required>
            <div id="remember" class="checkbox">
                
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="login"><?=$this->lang->line("Login");?></button>
        </form><!-- /form -->
        <a href="<?=SERVER?>main/forgot_password"><?=$this->lang->line("forgote_password");?></a>
    </div><!-- /card-container -->
</div><!-- /container -->
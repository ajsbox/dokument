<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$this->lang->line("title");?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
<div class="container">
<div class="row-fluid">
	<div class="span6 offset3">
		<h3 style="margin-top:20px; text-align:center; margin-bottom:30px;"><!--<span class="bold"> </span>-->
			<img src="assets/img/logo_dokument.png">
		</h3>
		<h2><?=$this->lang->line("Installation");?></h2>
		<?php if($install != '0'){ ?>
		<div class="alert alert-success"><?=$this->lang->line("The");?></div>
        <a class="btn btn-success btn-large" href="login"><?=$this->lang->line("go");?></a>
		<?php } else { ?>
		<p class="lead"><?=$this->lang->line("Welcome");?> 
        </p>
		<form class="form-horizontal" action="" method="post">
			<div class="control-group">
            	<label class="control-label" for="site_url"><?=$this->lang->line("Website");?></label>
            	<div class="controls">
                	<input type="text" name="site_url"  required="required">
                	<span class="help-block"><?=$this->lang->line("http");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="site_title"><?=$this->lang->line("wt");?></label>
            	<div class="controls">
                	<input type="text" name="site_title" required>
                	<span class="help-block"><?=$this->lang->line("te");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="header_title"><?=$this->lang->line("ht");?></label>
            	<div class="controls">
                	<input type="text" name="header_title" required>
                	<span class="help-block"><?=$this->lang->line("te1");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="admin_name"><?=$this->lang->line("an");?></label>
            	<div class="controls">
                	<input type="text" name="admin_name" required>
                	<span class="help-block"><?=$this->lang->line("pe");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="admin_username"><?=$this->lang->line("au");?></label>
            	<div class="controls">
                	<input type="text" name="admin_username" required>
                	<span class="help-block"><?=$this->lang->line("pp");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="admin_password" required="required"><?=$this->lang->line("ap");?></label>
            	<div class="controls">
                	<input type="text" name="admin_password" required>
                	<span class="help-block"><?=$this->lang->line("ppp");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="admin_email"><?=$this->lang->line("ae");?></label>
            	<div class="controls">
                	<input type="email" name="admin_email" required email>
                	<span class="help-block"><?=$this->lang->line("tw");?></span>
            	</div>
        	</div>
            <div class="control-group">
            	<label class="control-label" for="admin_email"><?=$this->lang->line("ul");?></label>
            	<div class="controls">
                	<input type="text" name="banned_attempt" required>
                	<span class="help-block"><?=$this->lang->line("install_dms_userlogin");?></span>
            	</div>
        	</div>
            <div class="control-group">
            	<label class="control-label" for="admin_email"><?=$this->lang->line("ub");?></label>
            	<div class="controls">
                	<!--<input type="text" name="time_banned" required>-->
					<select name="hour" style="width:100px;">
						<option value="0"><?=$this->lang->line("install_hour");?></option>
					<?php for($i=1;$i<=50;$i++) {?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php }?>
					</select>
					<select name="minute" style="width:100px;">
						<option value="0"><?=$this->lang->line("install_minute");?></option>
					<?php for($i=1;$i<=59;$i++) {?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php }?>
					</select>
					<select name="second" style="width:105px;">
						<option value="0"><?=$this->lang->line("install_second");?></option>
					<?php for($i=1;$i<=59;$i++) {?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php }?>
					</select>
                	<span class="help-block"><?=$this->lang->line("install_dms_banned_time");?></span>
            	</div>
        	</div>
           <div class="control-group" style="display:none;">
            	<label class="control-label" for="admin_email"><?=$this->lang->line("sl");?></label>
            	<div class="controls">
                	<select name="language">
					 <option value="spanish">Spanish</option>
					 <option value="english">English</option>
                    </select>
                	<span class="help-block"><?=$this->lang->line("tw2");?></span>
            	</div>
        	</div>
        	<div class="form-actions">
        		<input type="submit" name="install" value="<?=$this->lang->line("install_btn");?>" class="btn btn-large btn-primary">
        	</div>
		</form>
		<?php } ?>
	</div>
</div>
</div>
</body>
</html>
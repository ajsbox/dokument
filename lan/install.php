<?php

session_start();
if(isset($_GET['lang']) and ($_GET['lang']=='english' || $_GET['lang']=='spanish')) {
	$_SESSION['lan'] = $_GET['lang'];
} else {
	unset($_SESSION['lan']);
}
   if(isset($_SESSION['lan']))
   {
	   require_once("lan/".$_SESSION['lan'].'/'.$_SESSION['lan'].".php");
   }
   else
   {
	   require_once("lan/spanish/spanish.php");
   }
   
function lang($key)
{
	global $lan;
	return $lan['install'][$key];
}

if(isset($_POST['type']))
{
	extract($_POST);
	if(@mysql_connect($host,$user,$password))
	{
		@mysql_query("CREATE DATABASE IF NOT EXISTS ".$dbname);
		if(@mysql_select_db($dbname))
		{
			$file="application/config/database.php";
			$file_con=file_get_contents($file);
			if($_POST['type']=="mysqli")
			$port="3306";
			else
			$port="5432";
			$file_get=str_replace(array("[host]","[user]","[pass]","[db]","[type]","[port]"),array($host,$user,$password,$dbname,$type,$port),$file_con);
			file_put_contents($file,$file_get);
			
			///////set config file/////
			
			$file = "application/config/config.php";
			
			$file_con=file_get_contents($file);
			$file_get=str_replace(array("[change_lan]"), array($language),$file_con);
			file_put_contents($file,$file_get);
			
			$file = "assets/app/file_upload/uploads/scaner/SaveToFile.php";
			
			$file_con=file_get_contents($file);
			$file_get=str_replace(array("[host]","[user]","[pass]","[db]"),array($host,$user,$password,$dbname),$file_con);
			file_put_contents($file,$file_get);
			
			$file = "assets/app/file_upload/uploads/create_scaner/SaveToFile.php";
			
			$file_con=file_get_contents($file);
			$file_get=str_replace(array("[host]","[user]","[pass]","[db]"),array($host,$user,$password,$dbname),$file_con);
			file_put_contents($file,$file_get);
			
			$dara['type']=1;
		    $dara["display"]="Realizando conexion con la base de datos!: por favor espere, aparecerá el paso siguiente";
			unlink("install.php");
		}
		else
		{
		 $dara['type']=0;
		 $dara["display"]="Error Connect phpmyadmin : ".mysql_error();
		}
	}
	else
	{
		$dara['type']=0;
		$dara["display"]="Error Connect phpmyadmin : ".mysql_error();
	}
	echo json_encode($dara);
	
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=lang("title");?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/userlogik.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
  	<div class="container">
	<div class="row-fluid">
	
	<div class="span12">
		<!--<div class="home-box" style="padding: 15px; border-radius: 10px;">
		<h1 style="text-align: center; margin-bottom: 20px;"><?=lang("a1");?></h1>
		<p class="lead"><?=lang("a2");?></p>
		</div>
		<hr>
        <?php?>
        <div class="doc-section" id="installation">
        </div>-->
		<h3 style="margin-top:20px; text-align:center; margin-bottom:30px;"><!--<span class="bold"> </span>-->
			<img src="assets/img/logo_dokument.png">
		</h3>
		<form class="form-horizontal" id="gofrom" action="" method="post">
			<div class="control-group">
				<?=lang("lang");?>:
				<select  name="language" id="lang">
					<option value="spanish" <?php if(isset($_GET['lang']) and $_GET['lang']=='spanish') echo "selected";?>>Spanish</option>
				   <option value="english"<?php if(isset($_GET['lang']) and $_GET['lang']=='english') echo "selected";?>>English</option>
				</select>
				<br><br>
				<!--<span class="help-block"><?=lang("ppd");?></span>-->
		<div class="doc-section" id="installation">
			<h3><?=lang("Installation");?>:</h3>
			<p><?=lang("an");?>
			<h4><?=lang("step");?></h4>
		   
			<h4><?=lang("Optional");?>:</h4>
			<p><?=lang("if");?>:</p>
				<pre>
RewriteEngine on
RewriteCond $1 !^(index\.php|img|assets|js|css|robots\.txt)
RewriteRule ^(.*)$ /SUB-DIRECTORY-NAME-HERE/index.php/$1 [L]</pre>

			<p><strong>Note:</strong> If you are a godaddy customer, your .htaccess file should contain this instead:</p>
			<pre>
RewriteEngine on
RewriteCond $1 !^(index\.php|img|assets|js|css|robots\.txt)
RewriteRule ^(.*)$ /SUB-DIRECTORY-NAME-HERE/index.php?/$1 [L]</pre>
			
					<p class="lead"><?=lang("wl");?></p>
		
			<div class="control-group">
            	<label class="control-label" for="host"> <?=lang("dbh");?>:</label>
            	<div class="controls">
                	<input type="text" name="host" id="host">
                	<span class="help-block"><?=lang("ex");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="user"> :<?=lang("dbu");?></label>
            	<div class="controls">
                	<input type="text" name="user" id="user">
                	<span class="help-block"><?=lang("exr");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="password"><?=lang("dbp");?></label>
            	<div class="controls">
                	<input type="text" name="password" id="password">
                	<span class="help-block"><?=lang("exp1");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="dbname">  <?=lang("dbname");?>:</label>
            	<div class="controls">
                	<input type="text" name="dbname" id="dbname">
                	<span class="help-block"><?=lang("pea");?></span>
            	</div>
        	</div>
        	<div class="control-group">
            	<label class="control-label" for="type"> <?=lang("dbm");?>:</label>
            	<div class="controls">
                	<select  name="type" id="type">
                       <option value="mysqli"><?=lang("mysqli");?></option>
                      <!-- <option value="postgre"><?=lang("postgre");?></option>-->
                    </select>
                	<span class="help-block"><?=lang("ppd");?></span>
            	</div>
        	</div>
        	
        	<div class="form-actions">
              <div class="row">
                <div class="span4">
        		   <input type="submit" name="install" value="<?=lang("install_btn")?>" class="btn btn-large btn-primary">
                </div>
                <div class="span5 hide" id="notice">
                  <div class="alert"></div>
                </div>
              </div>
        	</div>
		</form>
		</div>
	</div>
</div>
	</div>
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript">
	    $(document).ready(function()
		{
			$("#gofrom").submit(function()
			{
				
				  var pass=$("#gofrom").serialize();
				  $("#notice").fadeIn().find("div").removeClass("alert-sucess").removeClass("alert-danger").addClass("alert-info").html("Try Connect Database");
				  $.post("install.php",pass,function(msg)
				  {
						    if(msg.type==1)
							{
								$("#notice").fadeIn().find("div").removeClass("alert-danger").removeClass("alert-info").addClass("alert-success").html(msg.display);
								setTimeout(function()
								{
									window.location.href="install";
								},2000)
							}
							else
							{
								alert(msg.display);
								$("#notice").fadeIn().find("div").removeClass("alert-sucess").removeClass("alert-info").addClass("alert-danger").html(msg.display);
							}
						 
				  },"json");
				  
				  return false;
			})
		})
		$("#lang").live('change', function(){
			var lang = $(this).val();
			var url = window.location.href;
			url = url.split('?');
			window.location = url[0]+'?lang='+lang;
		})
		
		
	</script>
</body>
</html>
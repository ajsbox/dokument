<!DOCTYPE html>
<?php //date_default_timezone_set('Asia/Calcutta');?>
<html <?=$this->lang->line="en";?>>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title><?=$this->lang->line("header_title");?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <!-- Stylesheets -->
  
  <span id="bootstrap_css">
	<link href="<?=$this->logik->setting("default_url")?>assets/app/style/bootstrap.css" rel="stylesheet">
  </span>
  <!-- Font awesome icon -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/font-awesome.css"> 
  <!-- jQuery UI -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/jquery-ui.css"> 
  <!-- Calendar -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/fullcalendar.css">
  <!-- prettyPhoto -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/prettyPhoto.css">   
  <!-- Star rating -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/rateit.css">
  <!-- Date picker -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/bootstrap-datetimepicker.min.css">
  <!-- CLEditor -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/jquery.cleditor.css"> 
  <!-- Uniform -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/uniform.default.css"> 
  <!-- Bootstrap toggle -->
  <link rel="stylesheet" href="<?=$this->logik->setting("default_url")?>assets/app/style/bootstrap-toggle-buttons.css">
  <!-- Main stylesheet -->
  <link href="<?=$this->logik->setting("default_url")?>assets/app/style/style.css" rel="stylesheet">
  <!-- Widgets stylesheet -->
  <link href="<?=$this->logik->setting("default_url")?>assets/app/style/widgets.css" rel="stylesheet">   
  
  
    
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>-->
<script src="<?=$this->logik->setting("default_url")?>assets/js/dataTable-jquery.js"></script>

  <!--for dynamic dataTable-->
   <link href="<?=$this->logik->setting("default_url")?>assets/css/dataTables.jqueryui.css" rel="stylesheet" type="text/css" />
  <link href="<?=$this->logik->setting("default_url")?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>-->
   <link href="<?=$this->logik->setting("default_url")?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
 <!-- for dynamic data table-->
<script  type="text/javascript" language="javascript" src="<?=$this->logik->setting("default_url")?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?=$this->logik->setting("default_url")?>assets/js/jquery-ui.js"></script>


 
  <!-- Responsive style (from Bootstrap) -->
  <link href="<?=$this->logik->setting("default_url")?>assets/app/style/bootstrap-responsive.css" rel="stylesheet">
  <!--<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->


  <!-- HTML5 Support for IE -->
  <!--[if lt IE 9]>
  <script src="js/html5shim.js"></script>
  <![endif]-->

  <!-- Favicon -->
  <link rel="shortcut icon" href="img/favicon/favicon.png">
  <script type="text/javascript">
     var server_path="<?=$this->logik->setting("default_url")?>";
	 var server_from_path=server_path+"assets/form/";
  </script>
</head>

<body>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
     <?php
		  if($this->session->userdata("username")){ ?>
      <!-- Menu button for smallar screens -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span>Menu</span>
      </a>
      <!-- Site name for smallar screens -->
     <!-- <a href="index.html" class="brand hidden-desktop"><?=$this->logik->setting("site_title");?></a>-->

      <!-- Navigation starts -->
      <div class="nav-collapse collapse">        

       

          <!-- Upload to server link. Class "dropdown-big" creates big dropdown -->
         
          

        <!-- Links -->
		
        <ul class="nav pull-right">
          <li class="dropdown pull-right">            
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <i class="icon-user"></i> <?=$this->session->userdata("username")?> <b class="caret"></b>              
            </a>
          
            <!-- Dropdown menu -->
            <ul class="dropdown-menu">
             <!--- <li><a href="<?=$this->logik->setting("default_url")?>#"><i class="icon-user"></i> Profile</a></li>
              <li><a href="<?=$this->logik->setting("default_url")?>#"><i class="icon-cogs"></i> Settings</a></li> -->			  
              <li><a href="<?=$this->logik->setting("default_url")?>logout"><i class="icon-off"></i>Cerrar Sesion</a></li>
            </ul>
          </li>
        </ul>
      </div>
    <?php } ?>
    </div>
  </div>
</div>

<!-- Header starts -->
  <header>
    <div class="container-fluid">
      <div class="row-fluid">
        <!-- Logo section -->
        <div class="span4">
          <!-- Logo. -->
          <div class="logo">
		  <?php //print_r(strtolower($this->session->userdata("username")));exit; 
		  if(isset($css_prop) and $css_prop==1) {
			$top = "margin-top:15px;";
		  } else {
			$top = "margin-top:48px;";
		  }
		  if(strtolower($this->session->userdata("username"))=="admin") {?>
            <h3 style="<?=$top?>"><a href="<?=$this->logik->setting("default_url")?>admin/userDocuments"><!--<span class="bold"><?=strtoupper($this->session->userdata("username"))?> </span>-->
			<img src="<?=$this->logik->setting("default_url")?>assets/img/logo_dokument.png">
			</a></h3>
			<?php } else {?>
			  <h3 style="<?=$top?>"><a href="<?=$this->logik->setting("default_url")?>user/my_documents"><!--<span class="bold"><?=strtoupper($this->session->userdata("username"))?> </span>-->
			<img src="<?=$this->logik->setting("default_url")?>assets/img/logo_dokument.png">
			</a></h3>
			<?php }?>
            <p class="meta" style="color:#333;"><!--SISTEMA DE GESTION DE DOCUMENTOS--></p>
          </div>
          <!-- Logo ends -->
        </div>
      <?php 
       if(USER_LEVEL==1){ ?>
        <!-- Button section -->
        <div class="span4">
 
          
        </div>                        
       <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </header>

<!-- Header ends -->

<!-- Main content starts -->
<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> 


<footer>
<!-- for popup-->
<link href="<?=$this->logik->setting("default_url")?>assets/app/style/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?=SERVER?>assets/app/jquery.fancybox/fancybox/jquery.fancybox-1.3.2.css" media="screen" />
<link rel="stylesheet" href="<?=SERVER?>assets/app/jquery.fancybox/style.css" />
<!---->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
            <!-- Copyright info -->
            <p class="copy"><?=$this->lang->line("Copyright");?> &copy; <?php echo date('Y', time())?> | <a href="<?=$this->logik->setting("default_url").'main/getCopyright'?>" class="pdfViewcopy"><?=$this->logik->setting("site_title");?></a> </p>
      </div>
    </div>
  </div>
</footer>
<!-- JS -->

<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.js"></script> <!-- jQuery -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/bootstrap.js"></script> <!-- Bootstrap -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery-ui-1.9.2.custom.min.js"></script> <!-- jQuery UI -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.rateit.min.js"></script> <!-- RateIt - Star rating -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.prettyPhoto.js"></script> <!-- prettyPhoto -->

<!-- jQuery Flot -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/excanvas.min.js"></script>
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.flot.js"></script>
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.flot.resize.js"></script>
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.flot.pie.js"></script>
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.flot.stack.js"></script>

<!-- jQuery Notification - Noty -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.noty.js"></script> <!-- jQuery Notify -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/themes/default.js"></script> <!-- jQuery Notify -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/layouts/bottom.js"></script> <!-- jQuery Notify -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/layouts/topRight.js"></script> <!-- jQuery Notify -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/layouts/top.js"></script> <!-- jQuery Notify -->
<!-- jQuery Notification ends -->

<script src="<?=$this->logik->setting("default_url")?>assets/app/js/sparklines.js"></script> <!-- Sparklines -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.cleditor.min.js"></script> <!-- CLEditor -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/bootstrap-datetimepicker.min.js"></script> <!-- Date picker -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.uniform.min.js"></script> <!-- jQuery Uniform -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/jquery.toggle.buttons.js"></script> <!-- Bootstrap Toggle -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/filter.js"></script> <!-- Filter for support page -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/custom.js"></script> <!-- Custom codes -->
<script src="<?=$this->logik->setting("default_url")?>assets/app/js/charts.js"></script> <!-- Custom codes -->


<script src="<?=$this->logik->setting("default_url")?>assets/app/jquery.fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script src="<?=$this->logik->setting("default_url")?>assets/app/jquery.fancybox/fancybox/jquery.fancybox-1.3.2.js"></script>


<?php
$this->setting_model->include_js();
$this->setting_model->include_css();
?>
<script type="text/javascript">
  $(".group_over").hover(function()
  {
	  $(this).find(".over_group").fadeIn();
  },function(){ $(this).find(".over_group").fadeOut();});
  
//alert(USER_LEVEL."USER");
$(document).ready(function() {
	$(".pdfViewcopy").fancybox({
		'width'				: '39%',
		'height'			: '43%',
		'autoScale'			: false,
		'transitionIn'		: '10',
		'transitionOut'		: '30',
		'type'				: 'iframe'
	});
});
</script>
</html>
</body>
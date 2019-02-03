<style>
	th{background-color:#EAEAEA;}
</style>
<link href="<?=SERVER?>assets/app/js/graph/jquery.jqplot.min.css" rel="stylesheet" type="text/css" />
<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu');  ?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
	<form action="graph" method="post">
		<div id="tableMessage" style="display: none;"></div>
		<form action="graph" method="post" >
        <div style="text-align:left; margin-top:10px;"><h5><?=$this->lang->line("graph_by_document_type");?>:</h5></div>
		
		<div id="form1">
			<div style="float:left; width:50px; font-size:14px; margin-top:17px;"><?=$this->lang->line("statistics_from");?></div>
			<div id="datetimepicker1" class="input-append" style="float:left; margin-top:10px;">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left; width:50px; font-size:14px; margin-top:17px;margin-left:5px;"><?=$this->lang->line("statistics_to");?></div>
			<div id="datetimepicker3" class="input-append" style="float:left; margin-top:10px;">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left;margin-top:10px; margin-left:5px;">
				<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" name="document" class="btn">
			</div>
		</div>
		<div id="chart1" style="width:70%; float:left;"></div>
		<div style="clear:both;"></div>
		</form>
		<form action="graph" method="post">
		<div style="text-align:left; margin-top:10px;"><h5><?=$this->lang->line("graph_by_user")?>:</h5></div>
		
		<div id="form2">
			<div style="float:left; width:50px; font-size:14px; margin-top:17px;"><?=$this->lang->line("statistics_from");?></div>
			<div id="datetimepicker4" class="input-append" style="float:left; margin-top:10px;">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left; width:50px; font-size:14px; margin-top:17px; margin-left:5px;"><?=$this->lang->line("statistics_to");?></div>
			<div id="datetimepicker5" class="input-append" style="float:left; margin-top:10px;">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left;margin-top:10px; margin-left:5px;">
				<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" name="user" class="btn">
			</div>
		</div>
		<div id="chart2" style="width:70%; margin-left:25px; float:left;"></div>
		<div style="clear:both;"></div>
		</form>
		<form action="graph" method="post">
		<div style="text-align:left; margin-top:10px;"><h5><?=$this->lang->line("graph_by_group")?>:</h5></div>
		
		<div id="form3">
			<div style="float:left; width:50px; font-size:14px; margin-top:17px;"><?=$this->lang->line("statistics_from");?></div>
			<div id="datetimepicker6" class="input-append" style="float:left; margin-top:10px;">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;">
			</div>

			<div style="float:left; width:50px; font-size:14px; margin-top:17px; margin-left:5px;"><?=$this->lang->line("statistics_to");?></div>
			<div id="datetimepicker7" class="input-append" style="float:left; margin-top:10px;">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left; width:50px; font-size:14px; margin-top:10px; margin-left:5px;">
				<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" name="group" class="btn">
			</div>
		</div>
		<div id="chart3" style="width:70%; margin-left:25px; float:left;"></div>
		<div style="clear:both;"></div>
	</form>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
  
      <div class="pull-right"><?php //echo $this->pagination->create_links(); ?></div>
	
	</div>
</div>

<?php //print_r($users);exit;?>

<!-- <script src="//datatables.net/download/build/nightly/jquery.dataTables.js"></script>
 <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
-->
 <script type="text/javascript">
 $(document).ready(function(){
    // For horizontal bar charts, x an y values must will be "flipped"
    // from their vertical bar counterpart.
	<?php  if(!empty($documents)) { ?>
    var plot1 = $.jqplot('chart1', [
		 <?php $i=0; //for($j=0; $j<count($documents); $j += 1) {?>
			[<?php if(!empty($documents)) { foreach($documents as $key=>$doc) { if($i!=0) echo ",";?> [<?=$doc['total_doc']?>,"<?=$doc['name']?>"]<?php $i=$i+20;} }?>],
		<?php //}?>], {
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
            pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
            // Rotate the bar shadow as if bar is lit from top right.
            shadowAngle: 135,
            // Here's where we tell the chart it is oriented horizontally.
            rendererOptions: {
                barDirection: 'horizontal'
            }
        },
        axes: {
            yaxis: {
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });
	<?php } else {?>
		$("#chart1").html("<?=$this->lang->line("statistics_no_data");?>");
		$("#form1").css("display","none");
	<?php }?>
	////second graph////
	<?php  if(!empty($users)) { ?>
	var plot2 = $.jqplot('chart2', [
		 <?php $i=0; //for($j=0; $j<count($users); $j += 1) {?>
			[<?php if(!empty($users)) { foreach($users as $key=>$doc) { if($i!=0) echo ",";?> [<?=$doc['total_doc']?>,"<?=$doc['username']?>"]<?php $i=$i+20;} }?>],
		<?php //}?>], {
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
            pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
            // Rotate the bar shadow as if bar is lit from top right.
            shadowAngle: 135,
            // Here's where we tell the chart it is oriented horizontally.
            rendererOptions: {
                barDirection: 'horizontal'
            }
        },
        axes: {
            yaxis: {
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });
	<?php } else {?>
		$("#chart2").html("<?=$this->lang->line("statistics_no_data");?>");
		$("#form2").css("display","none");
	<?php }?>
	////second graph////
	<?php if(!empty($groups)) { ?>
	var plot3 = $.jqplot('chart3', [
		 <?php $i=0; //for($j=0; $j<count($groups); $j += 1) {?>
			[<?php if(!empty($groups)) { foreach($groups as $key=>$doc) { if($i!=0) echo ",";?> [<?=$doc['total_doc']?>,"<?=$doc['name']?>"]<?php $i=$i+20;} }?>],
		<?php //}?>], {
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
            pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
            // Rotate the bar shadow as if bar is lit from top right.
            shadowAngle: 135,
            // Here's where we tell the chart it is oriented horizontally.
            rendererOptions: {
                barDirection: 'horizontal'
            }
        },
        axes: {
            yaxis: {
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });
	<?php } else {?>
		$("#chart3").html("<?=$this->lang->line("statistics_no_data");?>");
		$("#form3").css("display","none");
	<?php }?>
});
  </script>
<style>
	th{background-color:#EAEAEA;}
</style>
<div class="row-fluid">
<?php $this->load->view('user/user_menu');?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		<div id="tableMessage" style="display: none;"></div>
        <div style="text-align:left; margin-top:10px;"><h5><?=$this->lang->line("statistics_by_document_type");?></h5></div>
		<div style="float:left; width:60%">
			<table cellspacing="5px" cellpadding="5px" border="1px" width="100%">
				<tr>
					<th width="65%" align="left"><?=$this->lang->line("statistics_type");?></th>
					<th width="35%" align="left"><?=$this->lang->line("statistics_number");?></th>
				</tr>
				<?php if(!empty($documents)) {
						foreach($documents as $doc) {?>
							<tr bgcolor="#FFF"><td><?=$doc['name']?></td><td><?=$doc['total_doc']?></td></tr>
				<?php 	} 
					  } else {?>
					<tr><td align="center" colspan="2"><?=$this->lang->line("statistics_no_data");?></td></tr>
				<?php }?>
			</table>
		</div>
		<div style="float:left; margin-left:10px; width:300px;">
		<form name="by_document" action="statistics" method="post">
			<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
			<div id="datetimepicker1" class="input-append">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left; width:50px;font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_to");?></div>
			<div id="datetimepicker3" class="input-append">
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:right;">
			<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" name="document" class="btn">
			</div>
		</form>
		</div>
		<div style="clear:both;"></div>
		<div style="text-align:left; margin-top:10px;"><h5><?=$this->lang->line("statistics_by_user")?></h5></div>
		<div style="float:left; width:60%">
			<table cellspacing="5px" cellpadding="5px" border="1px" width="100%">
				<tr>
					<th width="65%" align="left"><?=$this->lang->line("statistics_by_user")?></th>
					<th width="35%" align="left"><?=$this->lang->line("statistics_number");?></th>
				</tr>
				<?php if(!empty($users)) {
						foreach($users as $userDocs) {?>
							<tr bgcolor="#FFF"><td><?=$userDocs['username']?></td><td><?=$userDocs['total_doc']?></td></tr>
				<?php 	} 
					  } else {?>
					<tr><td align="center" colspan="2"><?=$this->lang->line("statistics_no_data");?></td></tr>
				<?php }?>
			</table>
		</div>
		<div style="float:left; margin-left:10px; width:300px;">
		<form name="by_user" action="statistics" method="post">
			<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
			<div id="datetimepicker4" class="input-append">
				
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left; width:50px;font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_to");?></div>
			<div id="datetimepicker5" class="input-append">
				
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:right;">
			<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" name="user" class="btn">
			</div>
		</form>
		</div>
		<div style="clear:both;"></div>
		<div style="text-align:left; margin-top:10px;"><h5><?=$this->lang->line("statistics_by_group")?></h5></div>
		<div style="float:left; width:60%">
			<table cellspacing="5px" cellpadding="5px" border="1px" width="100%">
				<tr>
					<th width="65%" align="left"><?=$this->lang->line("statistics_group")?></th>
					<th width="35%" align="left"><?=$this->lang->line("statistics_number");?></th>
				</tr>
				<?php if(!empty($groups)) {
						foreach($groups as $groupDocs) {?>
							<tr bgcolor="#FFF"><td><?=ucfirst($groupDocs['name'])?></td><td><?=$groupDocs['total_doc']?></td></tr>
				<?php 	} 
					  } else {?>
					<tr><td align="center" colspan="2"><?=$this->lang->line("statistics_no_data");?></td></tr>
				<?php }?>
			</table>
		</div>
		<div style="float:left; margin-left:10px; width:300px; color:#000;">
		<form name="by_user" action="statistics" method="post">
			<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
			<div id="datetimepicker6" class="input-append">
				
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:left; width:50px;font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_to");?></div>
			<div id="datetimepicker7" class="input-append">
				
				<span class="add-on" style="border-radius:5px 0px 0px 5px;">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				  </i>
				</span>
				<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;">
			</div>
			<div style="float:right;">
			<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" name="group" class="btn">
			</div>
		</form>
		</div>
		<div style="clear:both;"></div>
	<br />
	<br />
	<br />
	<br />
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



<!-- <script src="//datatables.net/download/build/nightly/jquery.dataTables.js"></script>
 <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
-->
 <script type="text/javascript">
         /* var table = $('#example').DataTable({
	    "order": [[ 0, "desc" ]],
	    "language": {
            "sSearch": 'Buscar',
            "zeroRecords": "No hay registros disponibles",
            "info": "Mostrando _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"sLengthMenu":     "Mostrar _MENU_ Entradas",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			}
        }
		   });*/
  //var str=$(".dataTables_filter label").html();
  //var gh=str.replace("Search", "Buscar");
 // $(".dataTables_filter label").html(gh);
  </script>
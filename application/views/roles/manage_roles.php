<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		<div id="tableMessage" style="display: none;"></div>
        <div style="margin-top:40px;"><h3 style="margin-left:450px;"><?=$this->lang->line("manage_role");?></h3><!--<a href="add_role"><button class="btn btn-success"><i class="icon-book"></i>  <?$this->lang->line("add_role");?></button></a> --></div>
  
			<table class="display" cellspacing="0" width="100%" id="example" style="padding-top:20px;">
  			<thead>
    			<tr>
      				<!--<th><?php //echo "ID"; //$this->lang->line("ui");?></th>-->
      				<th><?=$this->lang->line("Name");?></th>
      				<th><?=$this->lang->line("Owner");?></th>
      				<th><?=$this->lang->line("Action");?></th>
                    <th><?=$this->lang->line("cd");?></th>
      				<!--<th><?=$this->lang->line("action");?></th>-->
                   <!-- <th><a class="btn btn-success" href="add_role"><?php // $this->lang->line("ar");?></a>&nbsp;</th>-->
    			</tr>
  			</thead>
  			<tbody>
  				<?php foreach($roles as $u): ?>
    			<tr style="text-align:center;" id="<?php echo $u->id; ?>">
      				<!--<td><?php //echo $u->id; ?></td>-->
      				<td><?php echo $u->name; ?></td>
      				<td><?php echo $u->owner; ?></td>
      				<td>
					<?php 	if($u->action==1) 
								echo $this->lang->line("Cargar_action");
							elseif($u->action==2)
								echo $this->lang->line("Modificar_action");
							elseif($u->action==3)
								echo $this->lang->line("Borrar_action");
							elseif($u->action==4)
								echo $this->lang->line("Estadisticas_action");
							elseif($u->action==5)
								echo $this->lang->line("Historial_action");
							elseif($u->action==6)
								echo $this->lang->line("Graficos_action");
							?>
                    </td>
      				<td><?php echo date('d, M Y', $u->create_date); ?></td>
      				<!--<td><?php //if($u->activate == '1') { ?><span class="label label-success activeIn" data-id='<?$u->id?>' data-act='0' style="cursor:pointer;" id="active-inactive<?=$u->id?>" data-tbl='roles'><?$this->lang->line("Active");?> </span><?php //} else { ?>
                    <span class="label label-important activeIn" data-id='<?=$u->id?>' data-act='1' style="cursor:pointer;" id="active-inactive<?$u->id?>" data-tbl='roles'><?$this->lang->line("Inactive");?> </span><?php //} ?></td>-->
      				<!--<td>
      					<div class="btn-group">
                        <td>
-->
                          
                              <!--<a class="edit_general" href="edit_role/<?php echo $u->id; ?>" data-uid="<?php echo $u->id; ?>">
                              <button class="btn btn-mini btn-warning"> <i class="icon-pencil"></i> </button></a>
                             
                              <a class="edit_general" href="manage_roles?id=<?php echo $u->id; ?>" data-uid="<?php echo $u->id; ?>">
                              <button class="btn btn-mini btn-danger"><i class="icon-remove"></i> </button></a>
                          -->
                      <!--  </td>-->
      						<!--<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-pencil"></i> Action <span class="caret"></span></a>
      						<ul class="dropdown-menu">
      							<li><a class="edit_general" href="#" data-uid="<?php echo $u->id; ?>"><i class="icon-edit"></i> Active</a></li>
      							<li><a class="edit_pass" data-uid="<?php echo $u->id; ?>" href="#"><i class="icon-edit"></i> Deactive</a></li>-->
                                <td>
      							<!--<a class="edit_general" href="edit_role/<?php echo $u->id; ?>" data-uid="<?php echo $u->id; ?>">
                              <button class="btn btn-mini btn-warning"> <i class="icon-pencil"></i> </button></a>-->
      				<!--	</div>-->
      				</td>
    			</tr>
    			<?php endforeach; ?>
  			</tbody>
			</table>
      <div class="pull-right"><?php echo $this->pagination->create_links(); ?></div>
	</div>
</div>
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
<br />
<br />
<br />
<br />
<script type="text/javascript">  
 
        var table = $('#example').DataTable({
	    "order": [[ 0, "desc" ]],
	    "language": {
            "sSearch": '<?=$this->lang->line("datatable_search")?>',
            "zeroRecords": "<?=$this->lang->line("datatable_no_record")?>",
            "info": "<?=$this->lang->line("datatable_showing")?> _PAGE_ <?=$this->lang->line("datatable_of")?> _PAGES_",
			"sLengthMenu":     "<?=$this->lang->line("datatable_show")?> _MENU_ <?=$this->lang->line("datatable_entry")?>",
            "infoFiltered": "(<?=$this->lang->line("datatable_filter")?> <?=$this->lang->line("datatable_of")?> _MAX_ total <?=$this->lang->line("datatable_of")?> <?=$this->lang->line("datatable_record")?>)",
			"oPaginate": {
				"sFirst":    "<?=$this->lang->line("datatable_first")?>",
				"sLast":     "<?=$this->lang->line("datatable_last")?>",
				"sNext":     "<?=$this->lang->line("datatable_next")?>",
				"sPrevious": "<?=$this->lang->line("datatable_previous")?>"
			}
        }
		   });
		   
		   
</script>
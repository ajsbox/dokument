<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span6">
		<table class="table table-hover">
  			<h3>Manage Your Modules</h3>
  			<thead>
  				<tr>
  					<th>Module ID</th>
  					<th>Module Name</th>
  					<th>Status</th>
  					<th></th>
  				</tr>
  			</tdhead>
  			<tbody>
  				<?php foreach($this->admin_model->get_modules() as $m): ?>
  				<tr id="<?php echo $m->id; ?>">
  					<td><?php echo $m->id; ?></td>
  					<td><?php echo $m->module; ?></td>
  					<td><?php if($m->active == '1'){ ?><span class="label label-success <?php echo $m->id; ?>">Active</span><?php } else { ?><span class="label label-important">Not Active</span><?php } ?></td>
  					<td style="text-align: center;">
            <?php if(file_exists("./application/controllers/".$m->module.".php")){?>
          <?php if($m->active == '0'){ ?><a href="#" class="btn btn-small btn-success activate_module" data-mid="<?php echo $m->id; ?>">Activate</a><?php } else { ?><a href="#" class="btn btn-small btn-danger deactivate_module" data-mid="<?php echo $m->id; ?>">Deactivate</a><?php } ?>
          <?php } else {?>
            Plugin Not Found
            <?php } ?>
          </td>
  				</tr>
  				<?php endforeach; ?>
  			</tbody>
  		</table>
  </div>
</div>
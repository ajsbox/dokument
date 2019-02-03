<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<table class="table table-hover">
  			<h3>Manage Your Pages <a class="btn btn-medium btn-inverse pull-left" style="margin-right: 25px; margin-top: 8px;" href="<?php echo $this->logik->setting('default_url'); ?>admin/add_page"><i class="icon-plus-sign icon-white"></i> Create a Page</a></h3>
  			<thead>
  				<tr>
  					<th>Page ID</th>
  					<th>Page Name</th>
  					<th>Page Slug</th>
  					<th>Allowed Levels</th>
  					<th></th>
  				</tr>
  			</tdhead>
  			<tbody>
  				<?php foreach($this->logik->all_pages() as $p): ?>
  				<tr id="<?php echo $p->id; ?>">
  					<td><?php echo $p->id; ?></td>
  					<td><?php echo $p->name; ?></td>
  					<td><?php echo $p->slug; ?></td>
  					<td><?php echo $this->logik->get_level_names($p->levels); ?></td>
  					<td><a href="<?php echo $this->logik->setting('default_url')."admin/edit_page/".$p->id; ?>" class="btn btn-warning"><i class="icon-edit icon-white"></i> Edit Page</a> 
              <a href="" class="btn btn-danger delete_page" data-pid="<?php echo $p->id; ?>"><i class="icon-trash icon-white"></i> Delete</a></td>
  				</tr>
  				<?php endforeach; ?>
  			</tbody>
  		</table>
  </div>
</div>
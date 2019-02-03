<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span6" id="manage-menu">
		<h2>Manage Menu Items <a href="#" class="btn btn-primary pull-left" style="margin-right: 25px; margin-top: 8px;" id="new-item-btn"><i class="icon-plus-sign icon-white"></i> Add Menu Item</a></h2>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Item Name</th>
					<th>Item Link</th>
					<th>Order</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->logik->get_menu() as $m): ?>
				<tr id="<?php echo $m->id; ?>">
					<td><?php echo $m->id; ?></td>
					<td><?php echo $m->name; ?></td>
					<td><?php echo $m->link; ?></td>
					<td><?php echo $m->order; ?></td>
					<td style="text-align: center;"><a href="#" data-mid="<?php echo $m->id; ?>" class="btn btn-warning edit-menu-btn"><i class="icon-pencil icon-white"></i> Edit</a>  
                                                <a href="#" data-mid="<?php echo $m->id; ?>" class="btn btn-danger delete-menu-btn"><i class="icon-trash icon-white"></i> Delete</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div class="span5" style="display: none;" id="edit-menu">
		<h2>Edit Menu Item</h2>
		<div class="alert alert-success alert_edit" style="dislay: none;"><strong>Success!</strong> The menu item has been editted!</div>
		<form action="" method="" id="edit-menu-form">
			<input type="hidden" name="mid" value="">
			<div class="control-group">
        		<label class="control-label" for="e_item_name">Item Name: </label>
        		<div class="controls">
        			<input type="text" name="e_item_name">
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="e_item_name">Item Link: </label>
        		<div class="controls">
        			<input type="text" name="e_item_link">
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="e_item_order">Item Order: </label>
        		<div class="controls">
        			<input type="text" name="e_item_order">
        		</div>
        	</div>
        	<div class="form-actions">
        		<input type="submit" name="edit_menu_item" class="btn btn-primary" value="Edit Menu Item">
        		<a href="#" class="btn btn-danger cancel_edit_item">Go Back</a>
        	</div>
		</form>
	</div>

	<div class="span5" style="display: none;" id="add-menu">
		<h2>Add Menu Item</h2>
		<div class="alert alert-success alert_new" style="display: none;"><strong>Success!</strong> The menu item has been created!</div>
		<form action="" method="" id="add-menu-form">
			<div class="control-group">
        		<label class="control-label" for="n_item_name">Item Name: </label>
        		<div class="controls">
        			<input type="text" name="n_item_name">
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="n_item_name">Item Link: </label>
        		<div class="controls">
        			<input type="text" name="n_item_link">
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="n_item_order">Item Order: </label>
        		<div class="controls">
        			<input type="text" name="n_item_order">
        		</div>
        	</div>
        	<div class="form-actions">
        		<input type="submit" name="new_menu_item" class="btn btn-primary" value="Add Menu Item">
        		<a href="#" class="btn btn-danger cancel_new_item">Go Back</a>
        	</div>
		</form>
	</div>
</div>
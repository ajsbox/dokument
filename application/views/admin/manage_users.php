<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			<table class="table table-hover">
  			<caption><h3>Manage Your Users</h3></caption>
  			<thead>
    			<tr>
      				<th>User ID</th>
      				<th>Name</th>
      				<th>Username</th>
      				<th>Email</th>
      				<th>Level</th>
      				<th>Account Status</th>
      				<th>Date Joined</th>
      				<th></th>
    			</tr>
  			</thead>
  			<tbody>
  				<?php foreach($users as $u): ?>
    			<tr id="<?php echo $u->id; ?>">
      				<td><?php echo $u->id; ?></td>
      				<td><?php echo $u->name; ?></td>
      				<td><?php echo $u->username; ?></td>
      				<td><?php echo $u->email; ?></td>
      				<td><?php echo $this->admin_model->level_name($u->level); ?></td>
      				<td><?php if($u->activate == '0'){ ?><span class="label label-success">Activated</span><?php } else { ?><span class="label label-important">Not Activated</span><?php } ?></td>
      				<td><?php echo date('M j, Y', $u->date_joined); ?></td>
      				<td>
      					<div class="btn-group">
      						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-pencil"></i> Action <span class="caret"></span></a>
      						<ul class="dropdown-menu">
      							<li><a class="edit_general" href="#" data-uid="<?php echo $u->id; ?>"><i class="icon-edit"></i> Edit General</a></li>
      							<li><a class="edit_pass" data-uid="<?php echo $u->id; ?>" href="#"><i class="icon-edit"></i> Edit Password</a></li>
      							<li><a class="delete_user" href="#" data-uid="<?php echo $u->id; ?>"><i class="icon-remove"></i> Delete</a></li>
      						</ul>
      					</div>
      				</td>
    			</tr>
    			<?php endforeach; ?>
  			</tbody>
			</table>
      <div class="pull-right"><?php echo $this->pagination->create_links(); ?></div>
	</div>
</div>

<div id="passModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h2>Edit User Password:</h2>
  </div>
  <div class="modal-body">
    <div id="passModalerror" style="display: none;"></div>
    <form action="edit_user_pass_ajax" method="post" class="form-horizontal well well-small passForm" id="passModalform">
        <div class="control-group">
        <label class="control-label" for="password1">Password:</label>
        <div class="controls">
        <input type="password" name="password1" value="">
        </div></div>
        <div class="control-group">
        <label class="control-label" for="password2">Password Confirmation:</label>
        <div class="controls">
        <input type="password" name="password2" value="">
        </div></div>
        <input type="hidden" name="uid" value="">
        <div class="form-actions">
        <input type="submit" class="btn btn-primary user_pass_update" name="edit_user" value="Edit User" id="passModalsubmit">
        </div>
  </div>
  </form>
</div>

<div id="editModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h2>Edit User:</h2>
  </div>
  <div class="modal-body">
    <div id="editModalerror" style="display: none;"></div>
    <form action="edit_user_ajax" method="post" class="form-horizontal well well-small editForm" id="editModalform">
        <div class="control-group">
        <label class="control-label" for="full_name">Name:</label>
        <div class="controls">
        <input type="text" name="full_name" value="">
        </div></div>
        <div class="control-group">
        <label class="control-label" for="e_username">Username:</label>
        <div class="controls">
        <input type="text" name="username" value="">
        </div></div>
        <div class="control-group">
        <label class="control-label" for="email">Email:</label>
        <div class="controls">
        <input type="text" name="email" value="">
        </div></div>
        <div class="control-group">
        <label class="control-label" for="level">User Level:</label>
        <div class="controls">
        <select name="user_level" id="user_level">
        </select>
        </div></div>
        <div class="form-actions">
        <input type="submit" class="btn btn-primary user_update" name="edit_user" value="Edit User" id="editModalsubmit">
        </div>
  </div>
  </form>
</div>
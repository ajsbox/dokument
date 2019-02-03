<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<table class="table table-hover">
  			<h3>Manage Your User Levels <a href="#" class="btn btn-medium btn-primary pull-left" style="margin-right: 25px; margin-top: 8px;" id="newLevelbtn">Add New User Level</a></h3>
  			<thead>
  				<tr>
  					<th>Level ID</th>
  					<th>Level Name</th>
  					<th>Level Redirect To</th>
  					<th>Users in Level</th>
  					<th></th>
  				</tr>
  			</tdhead>
  			<tbody>
  				<?php foreach($this->logik->all_levels() as $l): ?>
  				<tr>
  					<td><?php echo $l->id; ?></td>
  					<td><?php echo $l->name; ?></td>
  					<td><?php echo $l->redirect; ?></td>
  					<td><?php echo $this->logik->num_users_in_level($l->id); ?></td>
  					<td><a href="#" class="btn btn-warning editLevelbtn" data-lid="<?php echo $l->id; ?>">Edit Level</a></td>
  				</tr>
  				<?php endforeach; ?>
  			</tbody>
  		</table>
    </div>
  </div>
    <div class="row-fluid">
      <div class="span4 offset3">
  		<div id="newUserLevel" style="display: none">
  			<div id="message" style="display: none"></div>
  			<form action="" method="post" id="newLevelForm">
          <input type="hidden" name="lid" value="">
  				<div class="control-group">
        			<label class="control-label" for="level_name">Level Name:</label>
        			<div class="controls">
        				<input type="text" name="level_name">
        			</div>
        		</div>
        		<div class="control-group">
        			<label class="control-label" for="level_redirect">Level Redirect:</label>
        			<div class="controls">
        				<input type="text" name="level_redirect">
        				<span class="help-block">This is the page where users of this level get redirected to after they have logged in.</span>
        			</div>
        		</div>
        		<div class="form-actions">
        			<input type="submit" name="new_level" value="Add Level" class="btn btn-primary newLevel">
        		</div>
  			</form>
  		</div>
	</div>
  <div class="span4" id="editLeveldiv" style="display: none">
    <div id="editMessage" style="display: none"></div>
    <form action="" method="post" id="editLevelForm">
          <div class="control-group">
              <label class="control-label" for="e_level_name">Level Name:</label>
              <div class="controls">
                <input type="text" name="e_level_name">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="e_level_redirect">Level Redirect:</label>
              <div class="controls">
                <input type="text" name="e_level_redirect">
                <span class="help-block">This is the page where users of this level get redirected to after they have logged in.</span>
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="edit_level" value="Edit Level" class="btn btn-primary editLevel">
            </div>
        </form>
  </div>
</div>
<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span8 email_temp">
		<?php if($this->session->flashdata('new_temp') == '1'){ ?><div class="alert alert-success"><strong>Success!</strong> The template has been created!</div><?php } ?>
		<?php if($this->session->flashdata('edit_temp') == '1'){ ?><div class="alert alert-success"><strong>Success!</strong> The template has been editted!</div><?php } ?>
		<h2>Email Templates <a href="#new" class="btn btn-medium btn-primary new_email_temp pull-left" style="margin-right: 25px; margin-top: 8px;"><i class="icon-plus-sign icon-white"></i> Create a Template</a></h2>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Template Name</th>
					<th>File Name</th>
					<th>Email Subject</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->admin_model->get_email_templates() as $et): ?>
				<tr id="<?php echo $et->id; ?>">
					<td><?php echo $et->id; ?></td>
					<td><?php echo $et->name; ?></td>
					<td><?php echo $et->file_name; ?>.php</td>
					<td><?php echo $et->subject; ?></td>
					<td style="text-align: center;"><a href="#" data-tid="<?php echo $et->id; ?>" class="btn btn-medium btn-inverse edit_tmp"><i class="icon-pencil icon-white"></i> Edit Template</a> 
					<a href="#" class="btn btn-danger delete_tmp" data-tid="<?php echo $et->id; ?>"><i class="icon-trash icon-white"></i> Delete</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span9" id="new_email_temp" style="display: none;">
		<div class="row-fluid">
			<h2>New Email Template</h2>
			<div class="span6">
				<form action="new_email_temp" method="post" class="form-horizontal">
					<div class="control-group">
        				<label class="control-label" for="temp_name">Template Name: </label>
        				<div class="controls">
        					<input type="text" name="n_temp_name">
        				</div>
        			</div>
        			<div class="control-group">
        				<label class="control-label" for="file_name">File Name: </label>
        				<div class="controls">
        					<input type="text" name="n_file_name">
        				</div>
        			</div>
        			<div class="control-group">
        				<label class="control-label" for="e_subject">Email Subject: </label>
        				<div class="controls">
        					<input type="text" name="n_subject" value="">
        				</div>
        			</div>
        			<div class="control-group">
        				<label class="control-label" for="n_temp_body">Template Body: </label>
        				<div class="controls">
        					<textarea name="temp_body" rows="8"></textarea>
        				</div>
        			</div>
        			<div class="form-actions">
        				<input type="submit" name="new_email_temp" class="btn btn-primary" value="Create Template">
        				<a href="#" class="btn btn-danger cancel_new">Cancel</a>
        			</div>
				</form>
			</div>
			<div class="span3">
				<div class="well well-small">
					<h4>Template Variables</h4>
					<p><strong>{name}</strong> - Users full name.</p>
					<p><strong>{site_url}</strong> - Your website URL.</p>
					<p><strong>{site_title}</strong> - Your website tittle.</p>
					<p><strong>{email}</strong> - The users email address.</p>
					<p><strong>{username}</strong> - The users username.</p>
					<p><strong>{user_level}</strong> - Your users level.</p>
				</div>
			</div>
		</div>
	</div>

	<div class="span9" id="edit_email_temp" style="display: none;">
		<div class="row-fluid">
			<h2>Edit Email Template</h2>
			<div class="span6">
				<form action="edit_email_temp" method="post" class="form-horizontal">
					<div class="control-group">
						<input type="hidden" name="tid" value="">
        				<label class="control-label" for="temp_name">Template Name: </label>
        				<div class="controls">
        					<input type="text" name="e_temp_name" value="" class="e_temp_name">
        				</div>
        			</div>
        			<div class="control-group">
        				<label class="control-label" for="file_name">File Name: </label>
        				<div class="controls">
        					<input type="text" name="e_file_name" value="" class="e_file_name">
        				</div>
        			</div>
        			<div class="control-group">
        				<label class="control-label" for="e_subject">Email Subject: </label>
        				<div class="controls">
        					<input type="text" name="e_subject" value="" id="e_subject">
        				</div>
        			</div>
        			<div class="control-group">
        				<label class="control-label" for="temp_body">Template Body: </label>
        				<div class="controls">
        					<textarea name="e_temp_body" class="e_temp_body" rows="8"></textarea>
        				</div>
        			</div>
        			<div class="form-actions">
        				<input type="submit" name="new_email_temp" class="btn btn-primary" value="Edit Template">
        				<a href="#" class="btn btn-danger cancel_edit">Cancel</a>
        			</div>
				</form>
			</div>
			<div class="span3">
				<div class="well well-small">
					<h4>Template Variables</h4>
					<p><strong>{name}</strong> - Users full name.</p>
					<p><strong>{site_url}</strong> - Your website URL.</p>
					<p><strong>{site_title}</strong> - Your website tittle.</p>
					<p><strong>{email}</strong> - The users email address.</p>
					<p><strong>{username}</strong> - The users username.</p>
					<p><strong>{user_level}</strong> - Your users level.</p>
				</div>
			</div>
		</div>
	</div>
</div>
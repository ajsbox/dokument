<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<h2>Create a Page</h2>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); ?>
		<form action="add_page" method="post" class="form-horizontal">
			<div class="control-group">
        		<label class="control-label" for="page_name">Page Name:</label>
        		<div class="controls">
        			<input type="text" name="page_name" value="">
        			<span class="help-block">This is the name of your page.</span>
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="page_slug">Page Slug:</label>
        		<div class="controls">
        			<input type="text" name="page_slug" value="">
        			<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="levels">Levels:</label>
        		<div class="controls">
        			<select multiple="multiple" name="levels[]" id="levels" data-placeholder="Select levels for your page..." tabindex="4">
        				<option value=""></option>
        				<?php foreach($this->logik->all_levels() as $l): ?>
        				<option value="<?php echo $l->id; ?>"><?php echo $l->name; ?></option>
        				<?php endforeach; ?>
        			</select>
        			<span class="help-block">All the levels that you select will be able to access this page.</span>
        		</div>
        	</div>
                <label>Page Contents:</label>
        			<textarea class="tinymce" name="page_content"></textarea>
        			<span class="help-block">You can use this, or manually edit your page files located in your view/page folder.</span>
        	<div class="form-actions">
        		<input type="submit" name="add_page" class="btn btn-primary" value="Create">
        	</div>
		</form>
	</div>
</div>
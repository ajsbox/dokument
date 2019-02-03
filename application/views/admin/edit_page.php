<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<h2>Edit a Page</h2>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); ?>
		<form action="<?php echo $this->logik->setting('default_url')."admin/edit_page/".$page->id; ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="old_slug" value="<?php echo $page->slug; ?>">
			<div class="control-group">
        		<label class="control-label" for="page_name">Page Name:</label>
        		<div class="controls">
        			<input type="text" name="page_name" value="<?php echo $page->name; ?>">
        			<span class="help-block">This is the name of your page.</span>
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="page_slug">Page Slug:</label>
        		<div class="controls">
        			<input type="text" name="page_slug" value="<?php echo $page->slug; ?>">
        			<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>
        		</div>
        	</div>
        	<div class="control-group">
        		<label class="control-label" for="levels">Levels:</label>
        		<div class="controls">
        			<select multiple="multiple" name="levels[]" id="levels" data-placeholder="Select levels for your page..." tabindex="4">
        				<option value=""></option>
                                        <?php foreach($levels as $level): ?>
                                        <option selected="selected" value="<?php echo $level; ?>"><?php echo $this->admin_model->level_name($level); ?></option>
                                        <?php endforeach; ?>
        				<?php foreach($this->logik->all_levels() as $l): ?>
        				<option value="<?php echo $l->id; ?>"><?php echo $l->name; ?></option>
        				<?php endforeach; ?>
        			</select>
        			<span class="help-block">All the levels that you select will be able to access this page.</span>
        		</div>
        	</div>
        	<div class="control-group">
        		<label>Page Template:</label>
        			<textarea class="tinymce" name="page_content" rows="15" cols="80"><?php echo $this->logik->page_content($page->slug); ?></textarea>
        			<span class="help-block">You can use this, or manually edit your page files located in your views/page/*slug_name*.php folder.</span>
        	</div>
        	<div class="form-actions">
        		<input type="submit" name="edit_page" class="btn btn-primary" value="Edit">
        	</div>
		</form>
	</div>
</div>
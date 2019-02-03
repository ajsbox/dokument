<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span4">
		<h2>Email Users</h2>
		<div class="alert alert-success" style="display: none;"><strong>Success!</strong> The email(s) have been sent!</div>
		<form action="send_emails" method="post" class="form-horizontal" id="send_emails_form">
			<div class="control-group">
        		<label class="control-label" for="send_to">Send to Level(s): </label>
        		<div class="controls">
        			<select name="send_to[]" multiple="multiple" id="email_level_select">
        				<?php foreach($this->logik->all_levels() as $l): ?>
        				<option value="<?php echo $l->id; ?>"><?php echo $l->name." (".$this->logik->num_users_in_level($l->id).")"; ?></option>
        				<?php endforeach; ?>
        			</select>
        		</div>
      		</div>
      		<div class="control-group">
        		<label class="control-label" for="template">Email Template: </label>
        		<div class="controls">
        			<select name="template">
        				<?php foreach($this->admin_model->get_email_templates() as $et): ?>
        				<option value="<?php echo $et->file_name; ?>"><?php echo $et->name; ?></option>
        				<?php endforeach; ?>
        			</select>
        		</div>
      		</div>
      		<div class="form-actions">
      			<input type="submit" name="send_emails" class="btn btn-large btn-primary" value="Send">
      		</div>
		</form>
	</div>
  <div class="span4">
    <h2>Email a User:</h2>
    <?php if(!empty($error)){ ?>
    <div class="alert alert-error"><strong>Error!</strong> An error occured, please try again!</div>
    <?php }
    if(!empty($success)){ ?>
    <div class="alert alert-success"><strong>Success!</strong> The email has been sent!</div>
    <?php } ?>
    <form style="padding-top: 45px;" action="send_user_email" method="post" class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="send_to_username">Send To (Username): </label>
            <div class="controls">
              <input type="text" name="send_to_username">
            </div>
      </div>
      <div class="control-group">
            <label class="control-label" for="template">Email Template: </label>
            <div class="controls">
              <select name="single_template">
                <?php foreach($this->admin_model->get_email_templates() as $et): ?>
                <option value="<?php echo $et->file_name; ?>"><?php echo $et->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
      </div>
      <div class="form-actions">
        <input type="submit" name="send_user_email" value="Send" class="btn btn-large btn-primary">
      </div>
    </form>
  </div>
</div>
  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			  <h3>External Database Connection</h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>');?> 
	<form action="dbconnection" method="post" class="form-horizontal uni" name="frm1" onSubmit="return validate()">
			<div class="control-group">
            	<div class="controls">
        			 <label><h6>Host name</h6></label>
        			<input type="text" name="hostname" value="<?=@$_POST['hostname']?>"  class="password" id="name">
        		</div>
        	</div>
       		<div class="control-group">
        		
        		<div class="controls" id="select_modify">
                    <label><h6>Username</h6></label>
						<input type="text" name="username" value="<?=@$_POST['username']?>"  class="password" id="name">
        		</div>
			</div>
            <div class="control-group">
                    <div class="controls">
                    	<label><h6>Password</h6></label>
                        <input type="password" name="password" value=""  class="password" id="name"><br>
                    </div>
             </div>
			 <div class="control-group">
                    <div class="controls">
                    	<label><h6>Database name</h6></label>
                        <input type="text" name="dbname" value="<?=@$_POST['dbname']?>"  class="password" id="name"><br>
                    </div>
             </div>
        	<!--<div class="form-actions">-->
  				<button type="submit" name="db_con" class="btn " value="create"><?=$this->lang->line("create");?></button>
        	<!--</div>-->
		</form>
	</div>
</div>
<br />
<br />
<br />
<br />
<br />



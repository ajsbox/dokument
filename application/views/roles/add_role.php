<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<h2><?=$this->lang->line("add_role");?></h2>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); ?>
		<form action="<?php echo $this->logik->setting('default_url'); ?>roles/creaet_role" method="post" class="form-horizontal" onSubmit="return validateRole()">
			<div class="control-group">
        		<div class="controls">
                 <label style="font-size:14px; font-weight:bold;"><?=$this->lang->line("rn");?></label>
        			<input type="text" name="name" value="" id="name"><br>
                    <div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("role_name_req");?></div>
        			<span class="help-block"><?=$this->lang->line("tit");?></span>
        		</div>
        	</div>
        	<!--<div class="control-group">
        		<label class="control-label" for="page_slug">Page Slug:</label>
        		<div class="controls">
        			<input type="text" name="page_slug" value="">
        			<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>
        		</div>
        	</div>-->
                <div class="control-group">
                     <div class="controls">   
                         <label style="font-size:14px; font-weight:bold;"><?=$this->lang->line("aa");?></label>
                            <select name="action" id="action">
                            <option value="">- <?=$this->lang->line("ca");?> -</option>
                              <option value="1"><?=$this->lang->line("Scan");?></option>
                                 <option value="2"><?=$this->lang->line("Download");?></option>
                                    <option value="3"><?=$this->lang->line("View");?></option>
                                       <option value="4"><?=$this->lang->line("Report");?></option>
                                          <option value="5"><?=$this->lang->line("Statistics");?></option>
                             
                                </select><br>  
                                <div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("role_action_req");?></div> 
                            </div>
                          </div>
                                          
                                          
                          <div class="control-group">
                            <div class="controls">   
                             <label style="font-size:14px; font-weight:bold;"><?=$this->lang->line("Status");?></label>                            
                                <select name="activate">
                                
                                  <option value="1"><?=$this->lang->line("Active");?></option>
                                  <option value="2"><?=$this->lang->line("Inactive");?></option>
                                 
                                 
                                </select>  
                            </div>
                          </div>
            
            
        	
        	<div class="form-actions">
        		<input type="submit" name="add_page" class="btn btn-primary" value="<?=$this->lang->line("create");?>">
        	</div>
		</form>
	</div>
</div>
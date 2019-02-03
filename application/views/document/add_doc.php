  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			  <h3><?=$this->lang->line("add_document");?></h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
       
        

	<form action="add" method="post" class="form-horizontal uni" name="frm1" onSubmit="return validate()">
			<div class="control-group">
            	<div class="controls">
        			 <label><h6><?=$this->lang->line("dn");?></h6></label>
        			<input type="text" name="name" value=""  class="password" id="name"><br>
                    <div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("doc_name_req");?></div>
        			<span class="help-block"><?=$this->lang->line("ti");?></span>
        		</div>
        	</div>
       		<div class="control-group">
        		
        		<div class="controls" id="select_modify">
                    <label><h6><?=$this->lang->line("Groups");?></h6></label>
					<select name="groups[]" multiple="multiple">
                      <?php
					  	if(!empty($groups)) {
							foreach($groups as $val)
							{
								 if(ucfirst($val->name)!='Admin'){								//echo "<label style='width: 100px;float:left;'><input type='checkbox'  name='groups[]' value='".$val->id."' />".ucfirst($val->name)."</label>";
								echo '<option value="'.$val->id.'">'.ucfirst($val->name).'</option>';
								 }
							}
						} else {
							echo "<option value=''>No Groups</option>";
						}
                    ?>
					</select>
			
                    <div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_group_req");?></div>
        			<!--<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>-->
        		</div>
     	</div>
            <div class="control-group">
                    <div class="controls">
                    	<label><h6><?=$this->lang->line("Status");?></h6></label>
                        <select name="activate">
                         	<option value="1" selected><?=$this->lang->line("Active");?></option>
                            <option value="0"><?=$this->lang->line("Inactive");?></option>
                        </select>
                    </div>
             </div>
        	<!--<div class="form-actions">-->
  				<button type="submit" name="add_doc" class="btn " value="create"><?=$this->lang->line("create");?></button>
        	<!--</div>-->
		</form>
	</div>
</div>
<br />
<br />
<br />
<br />
<br />
<script>
$(document).ready(function(){
 setTimeout(function()
 {
$("#select_modify select").removeAttr("style")
$("#select_modify #uniform-undefined span:first").remove()
$("#select_modify #uniform-undefined").removeClass("selector")
},50)
})
</script>



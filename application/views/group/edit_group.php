  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
    <h3><?=$this->lang->line("eg");?></h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
	<form action="<?=$group->id?>" method="post" class="form-horizontal uni" name="frm1" onSubmit="return validateGroup()">
	
        	<input type="hidden" name="id" value="<?php if($this->input->post('id')) echo $this->input->post('id'); elseif(!empty($group->id)) echo $group->id?>" />
			<!--<div class="control-group">
				<div class="controls">
					<label><h6><?=$this->lang->line("parent_group");?></h6></label>
					<select name="parent_id">
						<option value="0" selected><?=$this->lang->line("no_groups");?></option>
						<?php //if(!empty($parentGroups)) {
							//foreach($parentGroups as $key=>$parents) {?>
							<option value="<?=$parents['id']?>" <?php //if($group->parent_id==$parents['id']) echo "selected";?>><?=$parents['name']?></option>
						<?php //} }?>
					</select>
				</div>
            </div>-->
			<div class="control-group">
        		<div class="controls">
                	<label><h6><?=$this->lang->line("gn");?></h6></label>
        			<input type="text" name="name" value="<?php if($this->input->post('name')) echo $this->input->post('name'); elseif(!empty($group->name)) echo $group->name?>"  class="password" id="name"><br>
                    <div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("group_name_req");?></div>
        			<span class="help-block"><?=$this->lang->line("group_tit");?></span>
        		</div>
        	</div>
       		<!--<div class="control-group">
        		<div class="controls" id="select_modify">
                <label><h6><?=$this->lang->line("rol");?></h6></label>
                     <select name="roles[]" multiple="multiple">
                      <?php
					  	/*if(!empty($roles)) {
							$rol = explode(',', $group->roles); 
							foreach($roles as $val)
							{	
							//echo "<label>";
							
								//echo "<input type='checkbox' value='".$val->id."' name='roles[]'>";
								
								//echo $val->name."</label>";
								if(in_array($val->id, $rol)) {
									echo '<option value="'.$val->id.'" selected>'.$val->name.'</option>';
								} else {
									echo '<option value="'.$val->id.'">'.$val->name.'</option>';
								}
							
					 		}
						} else {
							echo "No Roles";
						}*/
                    ?>
				</select>
                    <div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("doc_role_req");?></div>
        			<!--<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>
        		</div>
     	</div>-->
		<div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("doc_role_req");?></div>
            <div class="control-group" style="display:none;">
                    <div class="controls">
                    <label><h6><?=$this->lang->line("Status");?></h6></label>
                        <select name="activate">
                         	<option value="1" <?php if($group->activate == 1 ) echo "selected";?>><?=$this->lang->line("Active");?></option>
                            <option value="0" <?php if($group->activate == 0 ) echo "selected";?>><?=$this->lang->line("Inactive");?></option>
                        </select>
                    </div>
             </div>
       	<!--<div class="form-actions">-->
  				<button type="submit" name="edit_group" class="btn" value="update"><?=$this->lang->line("edit")?></button>
        		
       	<!--</div>-->
		</form>
	</div>
</div>
<br />
<br />
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



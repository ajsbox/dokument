  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
		
       
    <h3><?=$this->lang->line("ag");?></h6>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
       
		<form action="add" method="post" class="form-horizontal uni" name="frm1" onSubmit="return validateGroup()">
			<!--<div class="control-group">
                    <div class="controls">
                   		<label><h6><?=$this->lang->line("parent_group");?></h6></label>
                        <select name="parent_id">
                         	<option value="0" selected><?=$this->lang->line("no_groups");?></option>
							<?php if(!empty($parentGroups)) {
								foreach($parentGroups as $key=>$parents) {?>
								<option value="<?=$parents['id']?>"><?=$parents['name']?></option>
							<?php } }?>
                        </select>
                    </div>
             </div>-->
			<div class="control-group">
        		<div class="controls">
                <label><h6><?=$this->lang->line("gn");?></h6></label>
        			<input type="text" name="name" value=""  class="password" id="name"><br>
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
							foreach($roles as $val)
							{	
							//echo "<label>";
							
								//echo "<input type='checkbox' value='".$val->id."' name='roles[]'>";
								
								//echo $val->name."</label>";
								echo '<option value="'.$val->id.'">'.$val->name.'</option>';
							
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
                         	<option value="1" selected><?=$this->lang->line("Active");?></option>
                            <option value="0"><?=$this->lang->line("Inactive");?></option>
                        </select>
                    </div>
             </div>
     <!--	<div class="form-actions">-->
  				<button type="submit" name="add_group" class="btn" value="create" ><?=$this->lang->line("create")?></button>
        		
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



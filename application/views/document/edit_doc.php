  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			  <h3><?php echo $this->lang->line("ed");?></h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
       
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
       
        
        
		<form action="<?=$docs->id?>" method="post" class="form-horizontal uni" name="frm1" onSubmit="return validate()">
        	<input type="hidden" name="id" value="<?php if($this->input->post('id')) echo $this->input->post('id'); elseif(!empty($docs->id)) echo $docs->id?>" />
			<div class="control-group">
        		<div class="controls">
                	<label><h6><?=$this->lang->line("dn");?></h6></label>
        			<input type="text" name="name" value="<?php if($this->input->post('name')) echo $this->input->post('name'); elseif(!empty($docs->name)) echo $docs->name?>" class="password" id="name" readonly><br>
                    <div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("doc_name_req");?></div>
        			<span class="help-block"><?=$this->lang->line("ti");?></span>
        		</div>
        	</div>
       <div class="control-group">
       
        	<!--	<div class="controls">
                <label style="font-size:14px; font-weight:bold;"><?=$this->lang->line("Groups");?></label>
                      <?php
					  	/*if(!empty($groups)) {
							$rol = explode(',', $docs->groups); 
							foreach($groups as $val)
							{	
								echo "<label>";
								if(in_array($val->id, $rol)) {
									echo "<input type='checkbox' value='".$val->id."' name='groups[]' checked='checked' >";
								} else {
									echo "<input type='checkbox' value='".$val->id."' name='groups[]'>";
								}
								echo ucfirst($val->name)."</label>";
							}
						} else {
							echo "No Groups";
						}*/
                    ?>
                     <div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("doc_group_req");?></div>
        			<span class="help-block">This determines how your page will look in your urls. <strong>Do not use spaces!</strong></span>
        		</div>-->
				<div class="controls" id="select_modify">
                      <label><h6><?=$this->lang->line("Groups");?></h6></label>
					   <select name="groups[]" multiple="multiple">
                      <?php
					  	if(!empty($groups)) {
							$user_group=explode(",",$docs->groups);
							foreach($groups as $val)
							{
								//echo "<label style='width: 100px;float:left;'><input type='checkbox' ";
								//if(in_array($val->id,$user_group)){echo" checked='checked'";}
								//echo"  name='groups[]' value='".$val->id."' />".ucfirst($val->name)."</label>";
								if(ucfirst($val->name)!='Admin') {
									if(in_array($val->id, $user_group)) {
										echo '<option value="'.$val->id.'" selected>'.ucfirst($val->name).'</option>';
									} else {
										echo '<option value="'.$val->id.'">'.ucfirst($val->name).'</option>';
									}
								}
							}
						} else {
							echo "<option value=''>No Groups</option>";
						}
                    ?>
					</select>
                    <div id="error_group" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_group_req");?></div>
        			
        		</div>
     	</div>
            
            <div class="control-group">
              
                    <div class="controls">
                  <label><h6><?=$this->lang->line("Status");?></h6></label>
                        <select name="activate">
                        <option value="1" <?php if($docs->activate == 1 ) echo "selected";?>><?=$this->lang->line("Active");?></option>
                       <option value="0" <?php if($docs->activate == 0 ) echo "selected";?>><?=$this->lang->line("Inactive");?></option>
                        </select>
                    </div>
             </div>
     <!--	<div class="form-actions">-->
  				<button type="submit" name="edit_doc" class="btn " value="update"><?=$this->lang->line("edit")?></button>
     <!-- 	</div>-->
		</form>
        <br>
	</div>
</div>
<br />
<br /><br />
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


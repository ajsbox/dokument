  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			  <h3><?=$this->lang->line("edit_user");?></h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>'); 
		if(!empty($error)) {
			echo '<div class="alert alert-error"><strong>Error!</strong> '.$error.'</div>';
		}?>
		  <form class="form-horizontal uni" action="<?php echo $this->logik->setting('default_url'); ?>external_users/edit_in" method="post"  enctype="multipart/form-data" name="frm1" onSubmit="return validateUser()">
                           
                    <div class="control-group">
                    <div class="controls">
                      <label><h6><?=$this->lang->line("Name");?></h6></label>
                    <input type="text" name="name" id="name"  class="password" value="<?php echo $user['name']; ?>" > <br><div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_name_req");?></div> 
                    <div id="error_name" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_name_req");?></div> 
                            <div id="username_exists" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_name_exists");?></div>
							<div id="error_username_length" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("username_length");?></div>  
                    
                    
                      <div class="control-group">
                    <div class="controls">
                      <label><h6><?=$this->lang->line("e_mail");?></h6></label>
                    <input type="text" name="email" id="email"  class="password" value="<?php echo $user['email']; ?>" > <br> 
                     <div id="error_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_email_req");?></div> 
                    <div id="error_valid_email" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("user_valid_email");?></div> 
                    
                    
                      <div class="control-group">
                        <div class="controls">
                        <label><h6><?=$this->lang->line("Description");?></h6></label>
                        <textarea name="description" id="description"  class="password"><?php echo $user['description']; ?></textarea>             
                        
                           
                     </div>
                    </div>                                
                    
  
					   <input type="hidden" name="id" value="<?php echo $user['id']; ?>" id="id">                    

                      <hr /> 
                         	<!--<div class="form-actions">-->
                      <button type="submit" name="submit" class="btn" ><?=$this->lang->line("edit");?></button>
                 <!-- </div>-->
                    </form><br>
				
	</div>
</div>
<script>
$(document).ready(function(){
setTimeout(function()
{
	$("#select_modify select").removeAttr("style")
	$("#select_modify #uniform-undefined span:first").remove()
	$("#select_modify #uniform-undefined").removeClass("selector")
	$(".controls .docSel span").remove();

},50)
 setTimeout(function()
{
$("#select_modifys select").removeAttr("style");
$("#select_modifys #uniform-undefined span:first").remove();
$("#select_modifys #uniform-undefined").removeClass("selector");
$("#uniform-select_doc_group").removeClass("selector");
$("#uniform-select span:first").remove();
$("#uniform-select").removeClass("selector");
$("#uniform-select #select").css({'opacity':'1'});
},50)

<?php
if(!empty($groups)) {
	foreach($groups as $val) {?>
		setTimeout(function()
		{
			$("#select_modify<?=$val->id?> select").removeAttr("style")
			$("#select_modify<?=$val->id?> #uniform-undefined span:first").remove()
			$("#select_modify<?=$val->id?> #uniform-undefined").removeClass("selector")
		},50)
<?php }
}?>
////for group and roles/////
$("#select_modify select").click(function() {
	var groups = $(this).val();
	if($.isArray(groups)) {
		$(".hide-roles").css("display","none");
		$("#select_modifys").css("display","none");
		$.each(groups, function( index, value ) {
			$("#group-roles-"+value).css("display","inline");
		});
	}
	//console.log(vale);
})
})
</script>
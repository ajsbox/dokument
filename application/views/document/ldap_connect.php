  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div id="tableMessage" style="display: none;"></div>
			<h3><?=$this->lang->line("admin_ldap_config");?></h3>
		<?php echo validation_errors('<div class="alert alert-error"><strong>Error!</strong> ', '</div>');?>
		<?php if(@$isSaved) {?>
			<div class="alert alert-success user_update" style="margin-top:8px;"><?=$this->lang->line("admin_ldap_success");?></div>
		<?php }?>
		<?php if($isConnect==1) {?>
			<div class="alert alert-success user_update" style="margin-top:8px;"><?=$this->lang->line("connected_to_ldap");?></div>
		<?php } elseif($isConnect==2) {?>
			<div class="alert alert-error user_update" style="margin-top:8px;"><?=$this->lang->line("can_not_connect_to_ldap");?></div>
		<?php }?>
		<?php if($isBind==1) {?>
			<div class="alert alert-success user_update" style="margin-top:8px;"><?=$this->lang->line("bind_with_ldap");?></div>
		<?php } elseif($isBind == 2) {?>
			<div class="alert alert-error user_update" style="margin-top:8px;"><?=$this->lang->line("can_not_bind_ldap");?></div>
		<?php }?>
	<form action="" method="post" class="form-horizontal uni" name="frm1">
			<div style="width:21%; float:left;">
				<h5 style="font-size:15px;"><?=$this->lang->line("admin_network_parameter");?></h5>
				<hr style="border:1px solid; width:100%;">
				<div class="control-group">
					<div class="controls">
						 <label><h6><?=$this->lang->line("admin_ldap_host");?></h6></label>
						<input type="text" name="hostname" value="<?php if(isset($_POST['hostname'])) { echo $_POST['hostname']; } else { echo @$ldapConfig['hostname']; }?>" placeholder="server.ldapserver.com" class="password" id="hostname"><br>
						<div id="hostname_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_ldap_host");?></div>
					</div>
				</div>
				<div class="control-group">
					
					<div class="controls" id="select_modify">
						<label><h6><?=$this->lang->line("admin_ldap_port");?></h6></label>
							<input type="text" name="portname" value="<?php if(isset($_POST['portname'])) { echo $_POST['portname']; } else { echo @$ldapConfig['portname']; }?>" placeholder="389" class="password" id="portname"><br>
							<div id="portname_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_port_number");?></div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label><h6>Encryption Method</h6></label>
						<select name="encryption_method"  class="password" id="encryption_method">
							<option value="No Encryption" <?php if(@$ldapConfig['encryption_method']=="No Encryption") { echo "selected";}?>>No Encryption</option>
							<option value="SSL Encryption" <?php if(@$ldapConfig['encryption_method']=="SSL Encryption") { echo "selected";}?>>SSL Encryption</option>
							<option value="Start TSL Station" <?php if(@$ldapConfig['encryption_method']=="Start TSL Station") { echo "selected";}?>>Start TSL Station</option>
						</select><br>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button type="submit" name="check_network" class="btn " value="Check Network Parameters" style="float:right;" id="check_network"><?=$this->lang->line("admin_btn_network");?></button>
					</div>
				</div>
			</div>
			<div style="float:left; margin-left:100px; width:21%">
				<h5 style="font-size:15px;"><?=$this->lang->line("admin_search_parameter");?></h5>
				<hr style="border:1px solid; width:100%;">
				<div class="control-group">
					<div class="controls">
						 <label><h6><?=$this->lang->line("admin_base_dn");?></h6></label>
						<input type="text" name="base_dn" value="<?php if(isset($_POST['base_dn'])) { echo $_POST['base_dn']; } else { echo @$ldapConfig['base_dn']; }?>" placeholder="DC=myserver,DC=com" class="password" id="base_dn"><br>
							<div id="base_dn_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_base_dn");?></div>
					</div>
				</div>
				
				<div class="control-group">
					
					<div class="controls" id="select_modify">
						<label><h6><?=$this->lang->line("admin_filter");?></h6></label>
							<input type="text" name="filter" value="<?php if(isset($_POST['filter'])) { echo $_POST['filter']; } else { echo @$ldapConfig['filter']; }?>" placeholder="(objectClass=*)" class="password" id="filter"><br>
							<div id="filter_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_ldap_filter");?></div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label><h6><?=$this->lang->line("admin_attributs");?></h6></label>
						<input type="text" name="attributes" value="<?php if(isset($_POST['attributes'])) { echo $_POST['attributes']; } else { echo @$ldapConfig['attributes']; }?>" class="password" placeholder="cn,givenName" id="attributes"><br>
						<div style="color:#9e9e9e;"><?=$this->lang->line("ldap_attributes_notes");?></div>
							<div id="attributes_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_ldap_attributes");?></div>
					</div>
				</div>
			</div>
			<div style="float:left; margin-left:100px; width:21%">
				<h5 style="font-size:15px;"><?=$this->lang->line("admin_group_search_parameter");?></h5>
				<hr style="border:1px solid; width:100%;">
				<div class="control-group">
					<div class="controls">
						 <label><h6><?=$this->lang->line("admin_group_base_dn");?></h6></label>
						<input type="text" name="base_group_dn" value="<?php if(isset($_POST['base_group_dn'])) { echo $_POST['base_group_dn']; } else { echo @$ldapConfig['base_group_dn']; }?>" placeholder="DC=myserver,DC=com" class="password" id="base_group_dn"><br>
						<div id="base_group_dn_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_group_base_dn");?></div>
					</div>
				</div>
				
				<div class="control-group">	
					<div class="controls" id="select_modify">
						<label><h6><?=$this->lang->line("admin_group_filter");?></h6></label>
							<input type="text" name="group_filter" value="<?php if(isset($_POST['group_filter'])) { echo $_POST['group_filter']; } else { echo @$ldapConfig['group_filter']; }?>" placeholder="(objectClass=*)" class="password" id="group_filter"><br>
							<div id="group_filter_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_ldap_group_filter");?></div>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<label><h6><?=$this->lang->line("admin_group_attributs");?></h6></label>
						<input type="text" name="group_attributes" value="<?php if(isset($_POST['group_attributes'])) { echo $_POST['group_attributes']; } else { echo @$ldapConfig['group_attributes']; }?>" class="password" placeholder="cn,groupName" id="group_attributes"><br>
						<div style="color:#9e9e9e;"><?=$this->lang->line("ldap_group_attributes_notes");?></div>
						<div id="group_attributes_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_ldap_group_attributes");?></div>
					</div>
				</div>
			</div>	
			
			<div style="clear:both;"></div>
			
			<div style="width:20%;">
				<h5 style="font-size:15px;"><?=$this->lang->line("ldap_authentication");?></h5>
				<hr style="border:1px solid;">
				<div class="control-group">
					<div class="controls">
						<label><h6><?=$this->lang->line("error_ldap_parameters");?></h6></label>
						<select name="method_parameters"  class="password" id="encryption_method">
							<option value="Digest MS5(SASL)" <?php if(@$ldapConfig['method_parameters']=="Digest MS5(SASL)") { echo "selected";}?>>Digest MS5(SASL)</option>
							<option value="CRAM-MD5(SASL)" <?php if(@$ldapConfig['method_parameters']=="CRAM-MD5(SASL)") { echo "selected";}?>>CRAM-MD5(SASL)</option>
							<option value="GSSAPI(kerberos)" <?php if(@$ldapConfig['method_parameters']=="GSSAPI(kerberos)") { echo "selected";}?>>GSSAPI(kerberos)</option>
						</select><br>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label><h6><?=$this->lang->line("error_ldap_bind_dn");?></h6></label>
						<input type="text" name="bind_user"  value="<?php if(isset($_POST['bind_user'])) { echo $_POST['bind_user']; } else { echo @$ldapConfig['bind_user']; }?>" placeholder="User" class="password" id="bind_user"><br>
						<div id="bind_user_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_ldap_bind_user");?></div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label><h6><?=$this->lang->line("label_bind_password");?></h6></label>
						<input type="text" name="bind_password" placeholder="Password" class="password" id="bind_password" value="<?php if(isset($_POST['bind_password'])) { echo $_POST['bind_password']; } else { echo @$ldapConfig['bind_password']; }?>"><br>
						<div id="bind_password_error" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("error_bind_password");?></div>
					</div>
				</div>
				<!--<div class="form-actions">-->
					<button type="submit" name="authentication" class="btn " value="create" style="float:right;" id="authentication"><?=$this->lang->line("check_authentication");?></button>
				<!--</div>-->
			</div>
				<div class="control-group">
					<div class="controls">
						<button name="create_config" class="btn " value="create" style="float:left;" id="create_config"><?=$this->lang->line("create");?></button>
					</div>
				</div>
		</form>
	</div>
</div>
<br />
<br />
<br />
<br />
<br />

<script>
$("#check_network").click(function(){
	if($("#hostname").val()=='') {
		hideDiv();
		$("#hostname_error").css("display", "inline");
		return false;
	}
	
	if($("#portname").val()=='') {
		hideDiv();
		$("#portname_error").css("display", "inline");
		return false;
	}
});
$("#authentication").click(function(){
	if($("#bind_user").val()=='') {
		hideDiv();
		$("#bind_user_error").css("display", "inline");
		return false;
	}
	
	if($("#bind_password").val()=='') {
		hideDiv();
		$("#bind_password_error").css("display", "inline");
		return false;
	}
});

$("#create_config").click(function(){
	
	if($("#hostname").val()=='') {
		hideDiv();
		$("#hostname_error").css("display", "inline");
		return false;
	}
	
	if($("#portname").val()=='') {
		hideDiv();
		$("#portname_error").css("display", "inline");
		return false;
	}
	
	if($("#base_dn").val()=='') {
		hideDiv();
		$("#base_dn_error").css("display", "inline");
		return false;
	}
	
	if($("#filter").val()=='') {
		hideDiv();
		$("#filter_error").css("display", "inline");
		return false;
	}
	
	if($("#attributes").val()=='') {
		hideDiv();
		$("#attributes_error").css("display", "inline");
		return false;
	}

	if($("#base_group_dn").val()=='') {
		hideDiv();
		$("#base_group_dn_error").css("display", "inline");
		return false;
	}
	
	if($("#group_filter").val()=='') {
		hideDiv();
		$("#group_filter_error").css("display", "inline");
		return false;
	}
	
	if($("#group_attributes").val()=='') {
		hideDiv();
		$("#group_attributes_error").css("display", "inline");
		return false;
	}
	
	if($("#bind_user").val()=='') {
		hideDiv();
		$("#bind_user_error").css("display", "inline");
		return false;
	}
	
	if($("#bind_password").val()=='') {
		hideDiv();
		$("#bind_password_error").css("display", "inline");
		return false;
	}
	
});

function hideDiv() {
	$("#hostname_error").css("display", "none");
	$("#portname_error").css("display", "none");
	$("#base_dn_error").css("display", "none");
	$("#filter_error").css("display", "none");
	$("#attributes_error").css("display", "none");
	$("#group_attributes_error").css("display", "none");
	$("#bind_user_error").css("display", "none");
	$("#bind_password_error").css("display", "none");
	$("#base_group_dn_error").css("display", "none");
	$("#group_filter_error").css("display", "none");
}

</script>

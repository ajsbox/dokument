// JavaScript Document
function validate()
{	
	var name=document.getElementById("name").value;
	if(name=="")
	{
		hideAllErrorssign();
		document.getElementById("error_name").style.display = "inline";
		document.getElementById("name").focus();
		return false;
	}
	
	var flag = 0;
	
	for (var i = 0; i< document.frm1["groups[]"].length; i++) {
		if(document.frm1["groups[]"][i].selected){
			flag ++;
		}
	}
	if (flag == 0) {
		hideAllErrorssign();
		document.getElementById("error_group").style.display = "inline";
		//document.getElementById("name").focus();
		return false;
	}
}

function validateGroup()
{	
	var name=document.getElementById("name").value;
	if(name=="")
	{
		hideAllErrorssign();
		document.getElementById("error_name").style.display = "inline";
		document.getElementById("name").focus();
		return false;
	}
	
	/*var name=document.getElementById("selRoll").value;
	if(name=="")
	{
		hideAllErrorssign();
		document.getElementById("error_group").style.display = "inline";
		//document.getElementById("name").focus();
		return false;
	}
	var flag = 0;
	
	for (var i = 0; i< document.frm1["roles[]"].length; i++) {
		if(document.frm1["roles[]"][i].selected){
			flag ++;
		}
	}
	if (flag == 0) {
		hideAllErrorssign();
		document.getElementById("error_group").style.display = "inline";
		//document.getElementById("name").focus();
		return false;
	}*/

}
function validateRole()
{	
	var name=document.getElementById("name").value;
	if(name=="")
	{
		hideAllErrorssign();
		document.getElementById("error_name").style.display = "inline";
		document.getElementById("name").focus();
		return false;
	}
	var name=document.getElementById("action").value;
	if(name=="")
	{
		hideAllErrorssign();
		document.getElementById("error_group").style.display = "inline";
		document.getElementById("action").focus();
		return false;
	}

}

function validateUser()
{
	var name=document.getElementById("username").value;
	if(name=="")
	{
		hideAllErrorssign1();
		document.getElementById("error_name").style.display = "inline";
		document.getElementById("username").focus();
		return false;
	}
	if(name.length<4)
	{
		hideAllErrorssign1();
		document.getElementById("error_username_length").style.display = "inline";
		document.getElementById("username").focus();
		return false;
	}
	if(name!='') {
		var id = document.getElementById("user_id").value;
		
		$.ajax({
			url:server_path+'manage_users/isUniqueUsername',
			type:'POST',
			data:'username='+name+'&id='+id,
			success:function(res) {
				if(res) {
					if(res==1) {
						hideAllErrorssign1();
						document.getElementById("username_exists").style.display = "inline";
						document.getElementById("username").focus();
						return false;
					}
				}
			}
		});
	}
	var fname=document.getElementById("fname").value;
	if(fname=="")
	{
		hideAllErrorssign1();
		document.getElementById("error_fname").style.display = "inline";
		document.getElementById("fname").focus();
		return false;
	}
	var lname=document.getElementById("lname").value;
	/*if(lname=="")
	{
		hideAllErrorssign1();
		document.getElementById("error_lname").style.display = "inline";
		document.getElementById("lname").focus();
		return false;
	}*/
	
	var flag = 0;
	
	for (var i = 0; i< document.frm1["groups[]"].length; i++) {
		if(document.frm1["groups[]"][i].selected){
			flag ++;
		}
	}
	if (flag == 0) {
		hideAllErrorssign1();
		document.getElementById("error_group").style.display = "inline";
		//document.getElementById("name").focus();
		return false;
	}
	
	var flag = 0;
	
	for (var i = 0; i< document.frm1["groups[]"].length; i++) {
		var group_id = document.frm1["groups[]"][i].value;
		//console.log(group_id);
		for (var j = 0; j< document.frm1["roles"+group_id+"[]"].length; j++) {
			if(document.frm1["roles"+group_id+"[]"][j].selected){
				flag ++;
			}
		}
	}
	if (flag == 0) {
		hideAllErrorssign1();
		document.getElementById("error_roles").style.display = "inline";
		//document.getElementById("name").focus();
		return false;
	}
	
	var select_doc_group=document.getElementById("select_doc_group").value;
	if(select_doc_group=="")
	{
		hideAllErrorssign1();
		document.getElementById("error_doc_group").style.display = "inline";
		document.getElementById("select_doc_group").focus();
		return false;
	}
	
	var email=document.getElementById("email").value;
	if(email=="")
	{
		hideAllErrorssign1();
		document.getElementById("error_email").style.display = "inline";
		document.getElementById("email").focus();
		return false;
	}
	
	filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email)) {
		hideAllErrorssign1();
		document.getElementById("error_valid_email").style.display = "inline";
		document.getElementById("email").focus();
		return false;
	}
	
	/*if(email!='') {
		var id = document.getElementById("user_id").value;
		$.ajax({
			url:server_path+'manage_users/isUniqueEmail',
			type:'POST',
			data:'email='+email+'&id='+id,
			success:function(res) {
				if(res) {
					if(res==1) {
						hideAllErrorssign1();
						document.getElementById("username_exists").style.display = "inline";
						document.getElementById("username").focus();
						return false;
					}
				}
			}
		})
	}*/
	
	var telephone=document.getElementById("telephone").value;
	if(telephone=="")
	{
		hideAllErrorssign1();
		document.getElementById("error_telephone").style.display = "inline";
		document.getElementById("telephone").focus();
		return false;
	}
	
	var id = document.getElementById("user_id").value;
	var password=document.getElementById("password").value;
	if(password=="" && id=='')
	{
		hideAllErrorssign1();
		document.getElementById("error_password").style.display = "inline";
		document.getElementById("password").focus();
		return false;
	}
	
	var password_length = document.getElementById("password_length").value;
	if(password!="" && password.length<8 && password_length==1)
	{
		hideAllErrorssign1();
		document.getElementById("error_password_length").style.display = "inline";
		document.getElementById("password").focus();
		return false;
	}
	
	var password_conf=document.getElementById("password_confirm").value;
	if(password_conf=="" && id=='')
	{
		hideAllErrorssign1();
		document.getElementById("error_cnpassword").style.display = "inline";
		document.getElementById("password_confirm").focus();
		return false;
	}
	
	if(password_conf!=password)
	{
		hideAllErrorssign1();
		document.getElementById("error_password_matched").style.display = "inline";
		document.getElementById("password_confirm").focus();
		return false;
	}

/*var photo=document.getElementById("photo").value;
	if(photo=="" && id=='')
	{
		hideAllErrorssign1();
		document.getElementById("error_photo").style.display = "inline";
		//document.getElementById("photo").focus();
		return false;
	}*/
}

function userSetting()
{	
	var name=document.getElementById("fname").value;
	if(name=="")
	{
		hideAllErrorssignUser();
		document.getElementById("error_fname").style.display = "inline";
		document.getElementById("fname").focus();
		return false;
	}
	
	var name=document.getElementById("lname").value;
	if(name=="")
	{
		hideAllErrorssignUser();
		document.getElementById("error_lname").style.display = "inline";
		document.getElementById("lname").focus();
		return false;
	}
	
	var name=document.getElementById("telephone").value;
	if(name=="")
	{
		hideAllErrorssignUser();
		document.getElementById("error_contact").style.display = "inline";
		document.getElementById("telephone").focus();
		return false;
	}
	
	var name=document.getElementById("email").value;
	if(name=="")
	{
		hideAllErrorssignUser();
		document.getElementById("error_email").style.display = "inline";
		document.getElementById("email").focus();
		return false;
	}
	filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(name)) {
		hideAllErrorssignUser();
		document.getElementById("error_valid_email").style.display = "inline";
		document.getElementById("email").focus();
		return false;
	}

}
function hideAllErrorssignUser()
{
	document.getElementById("error_fname").style.display = "none";
	document.getElementById("error_lname").style.display = "none";
	document.getElementById("error_contact").style.display = "none";	
	document.getElementById("error_email").style.display = "none";	
	document.getElementById("error_valid_email").style.display = "none";	
}
function userChangePassword()
{	
	var pass=document.getElementById("old_password").value;
	if(pass=="")
	{
		hideAllErrorssignUPassword();
		document.getElementById("error_old_password").style.display = "inline";
		document.getElementById("old_password").focus();
		return false;
	}
	
	var newpass=document.getElementById("new_password").value;
	if(newpass=="")
	{
		hideAllErrorssignUPassword();
		document.getElementById("error_new_password").style.display = "inline";
		document.getElementById("new_password").focus();
		return false;
	}
	
	var cpass=document.getElementById("confirm").value;
	if(cpass=="")
	{
		hideAllErrorssignUPassword();
		document.getElementById("error_confirm").style.display = "inline";
		document.getElementById("confirm").focus();
		return false;
	}
	
	if(newpass!=cpass)
	{
		hideAllErrorssignUPassword();
		document.getElementById("error_match_confirm").style.display = "inline";
		document.getElementById("confirm").focus();
		return false;
	}
}

function hideAllErrorssignUPassword()
{
	document.getElementById("error_old_password").style.display = "none";
	document.getElementById("error_new_password").style.display = "none";
	document.getElementById("error_confirm").style.display = "none";
	document.getElementById("error_match_confirm").style.display = "none";	
}

function hideAllErrorssign1()
{
	document.getElementById("error_name").style.display = "none";
	document.getElementById("error_group").style.display = "none";	
	document.getElementById("error_fname").style.display = "none";
	document.getElementById("error_lname").style.display = "none";
	document.getElementById("error_email").style.display = "none";
	document.getElementById("error_roles").style.display = "none";
	document.getElementById("error_username_length").style.display = "none";
	document.getElementById("error_doc_group").style.display = "none";
	
	document.getElementById("error_telephone").style.display = "none";
	document.getElementById("username_exists").style.display = "none";
	document.getElementById("error_valid_email").style.display = "none";
	
	document.getElementById("error_password").style.display = "none";
	document.getElementById("error_password_length").style.display = "none";
	document.getElementById("error_cnpassword").style.display = "none";
	document.getElementById("error_password_matched").style.display = "none";
	var id = document.getElementById("user_id").value;
	if(!id) {
		document.getElementById("error_photo").style.display = "none";
	}
	//document.getElementById("error_exists_email").style.display = "none";
}

function hideAllErrorssign()
{
	document.getElementById("error_name").style.display = "none";
	document.getElementById("error_group").style.display = "none";	
}
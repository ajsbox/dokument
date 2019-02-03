$(document).ready(function() {
	$('.dropdown-toggle').dropdown();
	$('.login-modal').click(function(){
		$('#loginModal').modal('toggle');
	});
	$('.register-modal').click(function(){
		$('#registerModal').modal('toggle');
	});
	$('#loginModalform').submit(modalLogin);
	$('#registerModalform').submit(modalRegister);
	$('#activationModalForm').submit(resendActivation);
	$('#forgotPasswordModalForm').submit(forgotPassword);
	$('.edit_general').on("click", editModal);
	$('.edit_pass').on("click", passModal);
	$('#newLevelbtn').click(function() {
		$(this).hide('fast');
		$('#newUserLevel').slideDown();
	});
	$('#newLevelForm').submit(newLevel);
	$('#editModalform').submit(editUser);
	$('#passModalform').submit(editUserpass);
	$('.delete_user').on("click", deleteUser);
	$('#levels').chosen();

	$('.editLevelbtn').click(editLeveldiv);

	$('#editLevelForm').submit(editLevel);

	$('.new_email_temp').click(function(){
		$('.email_temp').slideUp("fast");
		$('#new_email_temp').slideDown("slow");
		$('.cancel_new').click(function(event){
			event.preventDefault();
			$('#new_email_temp').slideUp("fast");
			$('.email_temp').slideDown("slow");
		})
	});

	$("#send_emails_form").submit(sendEmails);

	$('.edit_tmp').click(edit_email_temp);

	$('#new-item-btn').click(function(){
		$('#manage-menu').slideUp('fast');
		$('#add-menu').slideDown('slow');
		$('.cancel_new_item').click(function(event){
			event.preventDefault();
			$('#add-menu').slideUp('fast');
			$('#manage-menu').slideDown('slow');
		});
		$('#add-menu-form').submit(newMenuItem);
	});

	$('.edit-menu-btn').click(editMenuData);

	$('#edit-menu-form').submit(editMenuItem);

	settingMenu();

	statsDate();

	$('#dateForm').submit(dateForm);

	$('.delete_page').click(deletePage);

	$('.delete_tmp').click(deleteTmp);

	$('.delete-menu-btn').click(deleteMenu);

	$('#contact_form').submit(contactForm);

	$("#modal_unique").keyup(modal_unique);

	$('#newTicketModalForm').submit(newTicket);

	$('#newTicketReply').submit(replyTicket);

	$("#forgotPassLink").click(function(){
		$('.loginModal').modal('toggle');
	});

	$("#resendLink").click(function(){
		$('.loginModal').modal('toggle');
	});

	$('.close_ticket').live('click', closeTicket);
	$('.hold_ticket').live('click', holdTicket);
	$('.unhold_ticket').live('click', unholdTicket);
	$('.open_ticket').live('click', openTicket);
	$('.activate_module').live('click', activateModule);
	$('.deactivate_module').live('click', deactivateModule);

	init_editor();
});

function init_editor()
{
	$('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url : default_url+'assets/js/tiny_mce/tiny_mce.js',
                        content_css : default_url+'assets/css/userlogik.css',
                        content_css : default_url+'assets/css/bootstrap.css',

                        // General options
                        theme : "advanced",
                        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

                        // Theme options
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,

                        // Drop lists for link/image/media/template dialogs
                        template_external_list_url : "lists/template_list.js",
                        external_link_list_url : "lists/link_list.js",
                        external_image_list_url : "lists/image_list.js",
                        media_external_list_url : "lists/media_list.js",
                });
}

function activateModule(event)
{
	event.preventDefault();

	var form_data = {
		mid : $(this).data('mid'),
		type : 'activate'
	}

	$.ajax({
		url: default_url+"admin/update_module_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.activate_module').addClass('deactivate_module').addClass('btn-danger').removeClass('btn-success').removeClass('activate_module').html("Deactivate");
			$('.'+form_data.mid).addClass('label-success').removeClass('label-important').html("Active");
		}
	});
}

function deactivateModule(event)
{
	event.preventDefault();

	var form_data = {
		mid : $(this).data('mid'),
		type : 'deactivate'
	}

	$.ajax({
		url: default_url+"admin/update_module_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.deactivate_module').addClass('activate_module').addClass('btn-success').removeClass('deactivate_module').removeClass('btn-danger').html("Activate");
			$('.'+form_data.mid).addClass('label-important').removeClass('label-success').html("Not Active");
		}
	});
}

function closeTicket(event)
{
	event.preventDefault();

	var form_data = {
		tid : $(this).data('tid'),
		type : 'closed'
	}

	$.ajax({
		url: default_url+"support/update_ticket_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.close_ticket').removeClass('btn-danger').removeClass('close_ticket').addClass('btn-success').addClass('open_ticket').html("Open Ticket");
			$('.hold_ticket').hide();
			$('.unhold_ticket').hide();	
			$('.top-status').html("Closed").removeClass('label-success').removeClass('label-important').addClass('btn-danger');	
		}
	});
}

function holdTicket(event)
{
	event.preventDefault();

	var form_data = {
		tid : $(this).data('tid'),
		type : 'hold'
	}

	$.ajax({
		url: default_url+"support/update_ticket_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.hold_ticket').removeClass('hold_ticket').removeClass('btn-warning').addClass('unhold_ticket').addClass('btn-success').html("Take Hold Off");
			$('.top-status').removeClass('btn-success').addClass('btn-warning').html("On Hold");		
		}
	});
}

function unholdTicket(event)
{
	event.preventDefault();

	var form_data = {
		tid : $(this).data('tid'),
		type : 'open'
	}

	$.ajax({
		url: default_url+"support/update_ticket_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.unhold_ticket').removeClass('unhold_ticket').removeClass('btn-success').addClass('btn-warning').addClass('hold_ticket').html('Put on Hold');
			$('.top-status').removeClass('btn-warning').addClass('btn-success').html("Open");
		}
	});
}

function openTicket(event)
{
	event.preventDefault();

	var form_data = {
		tid : $(this).data('tid'),
		type : 'open'
	}

	$.ajax({
		url: default_url+"support/update_ticket_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.open_ticket').addClass('close_ticket').addClass('btn-danger').removeClass('open_ticket').removeClass('btn-success').html('Close Ticket');
			$('.hold_ticket').show();
			$('.unhold_ticket').show();
			$('.top-status').removeClass('btn-danger').addClass('btn-success').html("Open")
		}
	});
}

function modal_unique()
{
	var username = $(this).val();
		span = $("#modal_span");
		control = $(".username_control");

	span.html("Validating username...");

	var form_data = {
		user : username
	}

	if(form_data.user.length < 4)
	{
		control.removeClass("success").addClass("error");
		span.html("Must be at least 4 characters!");
		return false;
	}

	$.ajax({
		url: default_url+"main/unique_username_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			if(json.error==1)
			{
				control.removeClass("success").addClass("error");
				span.html("This username is taken!");
			}else{
				control.removeClass("error").addClass("success");
				span.html("This username is available!");
			}		
		}
	});
}

function replyTicket(event)
{
	event.preventDefault();

	var form_data = {
		t_body : $("[name='ticket_reply']").val(),
		t_id: $("[name='t_id']").val()
	};

	if(form_data.t_body.length < 1)
	{
		alert("You cannot leave the reply blank!");
		return false;
	}

	$("[name='new_reply']").attr('value', 'Posting...');

	$.ajax({
		url: default_url+"support/new_ticket_reply_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			if(json.staff==1)
			{
				$("#reply_header").addClass('staff-reply');
				$("#reply_text").html("Staff Reply:");
			} else {
				$("#reply_header").addClass('user-reply');
				$("#reply_text").html("User Reply");
			}
			$("#reply_body").html(form_data.t_body);
			$("#reply_date").html("Posted: 1 Minute Ago.");
			$("#new_reply").slideDown('slow');
			$("[name='new_reply']").attr('value', 'Posted').html("");
		}
	});


}

function newTicket(event)
{
	event.preventDefault();

	var form_data = {
		subject : $("[name='ticket_subject']").val(),
		department : $("[name='ticket_department']").val(),
		priority : $("[name='ticket_priority']").val(),
		body : $("[name='ticket_body']").val()
	};

	if(form_data.subject.length < 1)
	{
		alert("Please fill in your name!");
		return false;
	}else if(form_data.body.length < 10)
	{
		alert("The ticket body should be at least 10 characters long!");
		return false;
	}
	
	$("[name='new_ticket_submit']").attr('value', 'Submitting...');

	$.ajax({
		url: "new_ticket_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('#newTicketModalForm').slideUp('slow', function() {
				$('.new_ticket_success').slideDown();
				setTimeout(function(){
				window.location = default_url+'support/view';
			}, 2000);
			});
		}
	});


}

function contactForm(event)
{
	event.preventDefault();

	var form_data = {
		name : $("[name='contact_name']").val(),
		email : $("[name='contact_email']").val(),
		subject : $("[name='contact_subject']").val(),
		body : $("[name='contact_body']").val()
	};

	if(form_data.name.length < 1)
	{
		alert("Please fill in your name!");
		return false;
	}else if(form_data.email.length < 1)
	{
		alert("Please fill in your email!");
		return false;
	}else if(form_data.subject.length < 1)
	{
		alert("Please fill in a subject!");
		return false;
	}else if(form_data.body.length < 10)
	{
		alert("Your message has to be at least 10 characters long!");
		return false;
	}

	$("[name='contact_send']").attr('value', 'Sending...');

	$.ajax({
		url: "send_contact_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			if(json.error==1)
			{
				alert("An error occured, please try again!");
			}else{
				$('#contact_form').slideUp('slow', function(){
					$('.contact_send').slideDown('fast');
				});
			}
		}
	});
}

function deleteMenu(event)
{
	event.preventDefault();

	var m_id = $(this).data('mid');
	var form_data = {
		mid : m_id
	};

	$.ajax({
		url: "delete_menu_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$("#"+m_id).slideUp("slow");
		}
	});
}

function deleteTmp(event)
{
	event.preventDefault();

	var t_id = $(this).data('tid');
	var form_data = {
		tid : t_id
	};

	$.ajax({
		url: "delete_tmp_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$("#"+t_id).slideUp("slow");
		}
	});
}

function deletePage(event)
{
	event.preventDefault();

	var p_id = $(this).data('pid');
	var form_data = {
		pid : p_id
	};

	$.ajax({
		url: "delete_page_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$("#"+p_id).slideUp("slow");
		}
	});
}

function dateForm(event)
{
	event.preventDefault();

	$('#datebtn').attr('value', 'Loading');

	var form_data = {
		start_date : $("[name='start_date']").val(),
		end_date : $("[name='end_date']").val()
	};

	$.ajax({
		url: "date_stats_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,
		success: function(json)
		{
			$('.emptyDate').hide();
			$('#total_users').html(json.total_users);
			$('#total_hits').html(json.total_hits);
			$('#total_fb').html(json.total_fb);
			$('#total_tw').html(json.total_tw);

			$.each(json.top_users, function(key, value){
            		$('#top_users').append("<p><strong>"+value.username+" :</strong> "+value.num_logins+" Logins</p>");
            	});
			$.each(json.top_pages, function(key, value){
            		$('#top_pages').append("<p><strong>"+value.name+" :</strong> "+value.views+" Views</p>");
            	});

			$('#datebtn').attr('value', 'Load Stats');
		}
	});
}

function statsDate()
{
	$('#startDate').Zebra_DatePicker({
  		pair: $('#endDate')
	});

	$('#endDate').Zebra_DatePicker({
  		direction: 1
	});
}

function settingMenu(event)
{
	var active = $('.active.settingLink').data('tab');

	$('#'+active+'Settings').show();

	$('.settingLink').bind('click', function(){
		//The tab value of the currently clicked element
		var tab = $(this).data('tab');
		//Current active element
		var current = $('.active.settingLink').data('tab');

		//Slide the old div up
		$('#'+current+'Settings').hide('slide', function(){
			//Slide the new div down
			$('#'+tab+'Settings').show('fold', 1000);
		});

		//Remove active class from current link
		$('.active, .settingLink').removeClass('active');
		//Add active class to new link
		$(this).addClass('active');

	});
}

function resendActivation(event)
{
	event.preventDefault();

	var form_data = {
		email : $("[name='activation_email']").val()
	};

	$("[name='resend_activation_submit']").attr('value', 'Processing...');

	$.ajax({
		url: default_url+"main/resend_activation_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			if(json.error==0){
				$('.resend_activation_success').slideDown("slow");
				$("[name='resend_activation_submit']").attr('value', 'Sent!').attr('disabled', 'disabled');
			}else{
				alert("An error occured, please try again!");
			}
		}
	});
}

function forgotPassword(event)
{
	event.preventDefault();

	var form_data = {
		email : $("[name='forgot_email']").val()
	};

	$("[name='forgot_password_submit']").attr('value', 'Processing...');

	$.ajax({
		url: default_url+"main/forgot_password_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$('.forgot_password_success').slideDown();
			$("[name='forgot_password_submit']").attr('value', 'Done').attr('disabled', 'disabled');
		}
	});
}

function editMenuItem(event)
{
	event.preventDefault();

	$('.alert_edit').hide();

	var form_data = {
		item_name: $("[name='e_item_name']").val(),
		item_link: $("[name='e_item_link']").val(),
		item_order: $("[name='e_item_order']").val(),
		mid: $("[name='mid']").val()
	};

	$.ajax({
		url: "edit_menu_item_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$('.alert_edit').show();
		}
	});
}

function editMenuData(event)
{
	event.preventDefault();

	$('.cancel_edit_item').click(function(event){
		event.preventDefault();
		$('#edit-menu').slideUp('fast');
		$('#manage-menu').slideDown('slow');
	});

	$('#manage-menu').slideUp();

	var form_data = {
		mid: $(this).data('mid')
	};

	$.ajax({
		url: "edit_menu_item_data_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$("[name='mid']").attr('value', json.mid);
			$("[name='e_item_name']").attr('value', json.name);
			$("[name='e_item_link']").attr('value', json.link);
			$("[name='e_item_order']").attr('value', json.order);
			$('#edit-menu').slideDown();
		}
	});
}

function newMenuItem(event)
{
	event.preventDefault();

	var form_data = {
		item_name: $("[name='n_item_name']").val(),
		item_link: $("[name='n_item_link']").val(),
		item_order: $("[name='n_item_order']").val()
	};

	$.ajax({
		url: "new_menu_item_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$('.alert_new').slideDown('fast');
			setTimeout(function(){
				window.location = 'manage_menus';
			}, 2000);
		}
	});
}

function sendEmails(event)
{
	event.preventDefault();

	$("[name='send_emails']").attr('value', 'Sending...');

	var form_data = {
		send_to : $("#email_level_select").val(),
		template : $("[name='template']").val()
	};

	$.ajax({
		url: "send_emails_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$("[name='send_emails']").attr('value', 'Send');
			$('.alert').slideDown();
		}
	});
}

function edit_email_temp(event)
{
	event.preventDefault();

	$('.cancel_edit').click(function(event){
		event.preventDefault();
		$('#edit_email_temp').slideUp("fast");
		$('.email_temp').slideDown("slow");
	})

	var form_data = {
		tid: $(this).data('tid')
	};

	$('.email_temp').slideUp("fast");

	$.ajax({
		url: "get_email_temp_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$("[name='tid']").attr('value', form_data.tid);
			$('.e_temp_name').attr('value', json.name);
			$('.e_file_name').attr('value', json.file_name);
			$('#e_subject').attr('value', json.email_subject);
			$('.e_temp_body').html(json.temp_body);
			$('#edit_email_temp').slideDown("slow");
		}
	});

}

function editLevel()
{
	event.preventDefault();

	var form_data = {
		level_name : $("[name='e_level_name']").val(),
		level_redirect : $("[name='e_level_redirect']").val(),
		lid: $("[name='lid']").val()
	};

	var btn = $('.editLevel');

	$('#editMessage').html('').hide();

	btn.attr('value', 'Editting...');

	$.ajax({
		url: "edit_level_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json) {
			$('#editLevelForm').hide();
				$('#editMessage').html(json.message).slideDown();
				setTimeout(function(){
					window.location = 'manage_levels';
				}, 2000);
		}
	});
}

function editLeveldiv(event)
{
	event.preventDefault();

	$("#editLeveldiv").slideUp();

	var form_data = {
		lid: $(this).data('lid')
	};

	$.ajax({
		url: "get_level_data",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json)
		{
			$("[name='e_level_name']").attr('value', json.level_name);
			$("[name='e_level_redirect']").attr('value', json.level_redirect);
			$("[name='lid']").attr('value', json.lid);
			$("#editLeveldiv").slideDown();
		}
	});
}

function deleteUser(event)
{
	event.preventDefault();

	var form_data = {
		uid : $(this).data('uid')
	}


	var c =confirm("Are you sure you want to delete this user?\n This cannot be undone!");
	if (c==true)
  	{
  		$.ajax({
  			url: "delete_user_ajax",
			type: "POST",
			data: form_data,
			dataType: "json",
			cache: false,

			success: function(json)
			{
				$(".span9").prepend('<div class="alert alert-success"><strong>Success!</strong> The user has been deleted!</div>');
				$("#"+form_data.uid).slideUp("slow");
				setTimeout(function(){
					$('.alert').slideUp("slow");
				}, 2000);
			}
  		});
  	}
}

function passModal(event)
{
	event.preventDefault();
	var uid = $(this).data('uid');

	$("[name='uid']").attr('value', uid);

	$('#passModal').modal({ show: true });
}

function editUserpass(event)
{
	event.preventDefault();

	$('.alert').hide();

	$('.user_pass_update').attr('value', 'Updating...');

	var form_data = {
		password1: $("[name='password1']").val(),
		password2: $("[name='password2']").val(),
		uid: $("[name='uid']").val()
	};

	if(form_data.password1 != form_data.password2)
	{
		alert("The passwords must match!");
		$('.user_pass_update').attr('value', 'Update');
		return false;
	}
	if(form_data.password1.length < 6)
	{
		alert("The password must be at least 6 characters long!");
		$('.user_pass_update').attr('value', 'Update');
		return false;
	}

	$.ajax({
		url: "edit_user_pass_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json){
			if(json.update==1){
				$('.modal-body').prepend('<div class="alert alert-success"><strong>Success!</strong> The password has been edited!</div>');
				$('.user_pass_update').attr('value', 'Update');
			}
		}
	});
}

function editUser(event)
{
	event.preventDefault();

	$('.alert').hide();

	$('.user_update').attr('value', 'Updating...');

	var form_data = {
		full_name : $("[name='full_name']").val(),
		uid : $("[name='uid']").val(),
		username : $("[name='username']").val(),
		email : $("[name='email']").val(),
		level : $("#user_level").val()
	};

	$.ajax({
		url: "edit_user_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json){
			if(json.update==1){
				$('.modal-body').prepend('<div class="alert alert-success"><strong>Success!</strong> The user has been edited!</div>');
				$('.user_update').attr('value', 'Update');
				setTimeout(function(){
					window.location = 'manage_users';
				}, 2000);
			}
		}
	});
}

function newLevel(event)
{
	event.preventDefault();

	var form_data = {
		level_name : $("[name='level_name']").val(),
		level_redirect : $("[name='level_redirect']").val()
	};

	var btn = $('.newLevel');

	$('#message').html('').hide();

	btn.attr('value', 'Adding...');

	$.ajax({
		url: "new_level_ajax",
		type: "POST",
		data: form_data,
		dataType: "json",
		cache: false,

		success: function(json) {
			if(json.error==1)
			{
				btn.attr('value', 'Add Level');
				$('#message').html(json.message).show();
			}else{
				$('#newLevelForm').hide();
				$('#message').html(json.message).slideDown();
				setTimeout(function(){
					window.location = 'manage_levels';
				}, 2000);
			}
		}
	});
}

function editModal(event)
{
	var form_data = {
		uid : $(this).data('uid')
	}
	
	$.ajax({
            url: "user_data_ajax", 
            type: "POST",       
            data: form_data,
            dataType: "json",     
            cache: false,
             
            success: function (json) {
            	$("[name='full_name']").attr('value', json.full_name);
            	$("[name='username']").attr('value', json.username);
            	$("[name='email']").attr('value', json.email);
            	$('#user_level').empty();
            	$.each(json.levels, function(key, value){
            		$('#user_level').append("<option value='"+ key +"'>"+ value +"</option>");
            	});
            	$('#user_level').val(json.current);
            	$('.uid').remove();
            	$('.editForm').prepend('<input type="hidden" class="uid" name="uid" value="'+ form_data.uid +'">');

            	$('#editModal').modal({ show: true });
            }
        });
}

function modalRegister(event) {
	event.preventDefault();

	$('#registerModalsubmit').attr('value', 'Signing you up...');

	var form_data = {
		r_username : $("[name='r_username']").val(),
		password1 : $("[name='password1']").val(),
		password2 : $("[name='password2']").val(),
		email : $("[name='email']").val(),
		full_name : $("[name='full_name']").val(),
		recaptcha_challenge_field : $("[name='recaptcha_challenge_field']").val(),
		recaptcha_response_field : $("[name='recaptcha_response_field']").val()
	};

	$.ajax({
            url: "main/register_ajax",
            type: "POST",      
            data: form_data,
            dataType: "json",
            cache: false,
             
            success: function (json) {              
                if (json.error==1) { 
                	if(json.captcha_error==1)
                	{
                		$('#registerModalsubmit').attr('value', 'Register!');
                		$('#registerModalerror').html('<div class="alert alert-error"><strong>Error!</strong> You did not enter the correct words from the image, please try again!</div>').show();
                	} else {        
                		$('#registerModalsubmit').attr('value', 'Register!');
                    	$('#registerModalerror').html(json.message).show();
                	}
                } else {
                	$('#registerModalsubmit').attr('value', 'Done!').attr('disabled', 'disabled');
                	$('#registerModalform').slideUp();
                	$('#registerModalerror').html(json.message).show();
                }              
            }
        });
}

function modalLogin(event) {
	event.preventDefault();

	$('#loginModalsubmit').attr('value', 'Loggin you in!');

	var checkBox = '';

	if($("[name='remember_me']").is(":checked"))
	{
		checkBox = 'remember';
	}


	var form_data = {
		username : $("[name='username']").val(),
		password : $("[name='password']").val(),
		remember_me : checkBox
	};

	$.ajax({
            url: "main/login_ajax",
            type: "POST",         
            data: form_data,
            dataType: "json",
            cache: false,
             
            //success
            success: function (json) {              
                if (json.error==1) {           
                	$('#loginModalsubmit').attr('value', 'Loggin!');
                    $('#loginModalerror').html(json.message).show();
                } else {
                	window.location = json.url;
                }              
            }
        });
}
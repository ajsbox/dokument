// JavaScript Document

$(document).ready(function(){
	$('.delete_group').live('click',function(){
		var group_id = $(this).data('gid');
		if(confirm('¿Seguro que quieres eliminar este grupo')) {
			$.ajax({
				url:server_path+'group/delete',
				type:'POST',
				data:'group_id='+group_id,
				success:function(res) {
					if(res) {
						$('#del'+res).hide('slow');
					}
				}
			})
		}
	})
	$('.delete_doc').live('click',function(){
		var doc_id = $(this).data('did');
		if(confirm('¿Seguro que quieres eliminar este documento')) {
			$.ajax({
				url:server_path+'document/delete',
				type:'POST',
				data:'doc_id='+doc_id,
				success:function(res) {
					if(res!=0) {
						$('#doc'+res).hide('slow');
					} else {
						alert('El tipo de documento que intenta borrar tiene archivos asociados');
					}
				}
			})
		}
	})
	
	$('#sel_document').live('change',function(){
		var doc_id = $(this).val();
		$.ajax({
			url:server_path+'user/loadDocumentForm',
			type:'POST',
			data:'doc_id='+doc_id,
			success:function(res) {
				if(res) {
					$('#frm_update').html(res);
					var head = $('#transfer_head').html();
					var table_name = $("#table").val();
					var doc_id = $("#document_id").val();
					if(res!=" ") {
						$("#showUploader").css({'display':'inline'});
						$('#header_top').html(head).css({'margin-bottom':'15px', 'margin-top':'17px'});
					} else {
						$("#showUploader").css({'display':'none'});
						$('#header_top').html(head).css('margin-top','0px');
					}
					//$('.file').prepend('<div class="file-wrapper">');
					$('.file').parent().append('<span class="button">Elija un archivo</span>').addClass("file-wrapper");
					//$(".scanView").attr("href", server_path+'user/createScan/'+doc_id);
					$(".alert").css({"display":"none"});
				}
			}
		})
	})
	
	$('.group_over').live('mouseover',function(){
		var doc_id = $(this).attr('id');
		$('#group_over'+doc_id).css({"display":"inline"});
		//document.getElementById('group_over'+doc_id).style.display = "inline";
		//alert(doc_id);
	})
})

function hideAllErrorssign()
{
	document.getElementById("valid_desc").style.display = "none";
	document.getElementById("valid_id").style.display = "none";
	document.getElementById("valid_group").style.display = "none";
	document.getElementById("valid_upload").style.display = "none";			
}

$("#attachImg").live('click', function() {
	/*var id = $(this).data('id');
	var file = $(this).data('file');
	var table = $(this).data('table');
	$("#file_table").attr('value', table);
	$("#file_id").attr('value', id);
	$("#file_name").attr('value', file);*/
	$("#upload_default").trigger("click");
})

   
 //////upload button design changed////////
					
	VIGET.fileInputs = function() {
	};
	//alert("ddd");
		$(document).ready(function() {
		$('.file-wrapper input[type=file]')
		.bind('change focus click', VIGET.fileInputs);
	});
   
   VIGET.fileInputs = function() {
	var $this = $(this),
	$val = $this.val(),
	valArray = $val.split('\\'),
	newVal = valArray[valArray.length-1],
	$button = $this.siblings('.button'),
	$fakeFile = $this.siblings('.file-holder');
	};
	 
	$(document).ready(function() {
	$('.file-wrapper input[type=file]')
	.bind('change focus click', VIGET.fileInputs);
	});
	
	VIGET.fileInputs = function() {
	var $this = $(this),
	$val = $this.val(),
	valArray = $val.split('\\'),
	newVal = valArray[valArray.length-1],
	$button = $this.siblings('.button'),
	$fakeFile = $this.siblings('.file-holder');
	if(newVal !== '') {
	$button.text('Photo Chosen');
	if($fakeFile.length === 0) {
	$button.after('' + newVal + '');
	} else {
	$fakeFile.text(newVal);
	}
	}
	};
	$(document).ready(function() {
	$('.file-wrapper input[type=file]')
	.bind('change focus click', VIGET.fileInputs);
	});
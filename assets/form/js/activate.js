/////active inactive for all pages//////////
$(document).ready(function(e) {
    $('.activeIn').live('click', function(){
		var id = $(this).data('id');
		var act = $(this).data('act');
		var tbl = $(this).data('tbl');
		$.ajax({url:server_path+"admin/activeInactiveUser",
		type:'POST',
		data:'id='+id+'&act='+act+'&table='+tbl,
		success: function(res) {
			var data = eval('(' + res + ')');
			//console.log(data['id']);
			if(data['act']==0) {
				$('#active-inactive'+data['id']).html('Inactive').data('act', 1).removeClass('label-success').addClass('label-important');
			} else {
				$('#active-inactive'+data['id']).html('Active').data('act', 0).removeClass('label-important').addClass('label-success');
			}
		}
			
		})
	})
});
  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu');?>
    <?php $sn = 1; $perpage = 15; $start=0;?>
	<div class="span10" style="padding-right:20px;">
    <?php if($this->session->flashdata('message')) {?>
    	<div class="alert alert-success user_update" style="margin-top:8px;">
	<?php //echo $this->session->flashdata('message'); ?><?=$this->lang->line("document_published");?></div>
    <?php }?>
		<div id="tableMessage" style="display: none;"></div>
         <div style="margin-top:10px;"><a href="add"><button class="btn btn-success"><i class="icon-file"></i>   <?=$this->lang->line("doc_ad");?></button></a><caption><h3 align="center"><?=$this->lang->line("doc_my");?></h3></caption></div>
			<table class="display" cellspacing="0" width="100%" id="example">
            <thead style="border-bottom:1px solid;">
    			<tr>
      				<th>ID<?php //$this->lang->line("di");?></th>
      				<th><?=$this->lang->line("Name");?></th>
      				<th><?=$this->lang->line("Owner");?></th>
                    <!--<th>< ?=$this->lang->line("Groups");?></th>-->
                    <th><?=$this->lang->line("cd");?></th>
      				<th><?php echo $this->lang->line("as");?></th>
                    <th><?php echo $this->lang->line("action");?></th><input type="text" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-right:0px;height:25px;"/>
    			</tr>
  			</thead>
            <!--<tbody>                 
                    <?php foreach($users as $u) {   if($u->level!=1) {?>
                    <tr style="text-align:center;">
						<td><?php echo $u->id ?></td>
						<td><?php echo $u->name.' '.$u->lname;?></td>
						<td><?php echo $u->username;?></td>
						<td><?php echo $u->email;?></td>
						<!--<td><?php //if (!empty($u->groups)) echo $this->manage_user_model->group_name($u->groups); ?></td>-->
						<!--<td class="group_over" style="position:relative" id="<?=$u->id?>">
						<?php /*$grps = explode(',', $u->groups); 
							if(count($grps)>1) {
								echo "Multiple";
								echo '<div style="background:#000;display:none;position:absolute;z-index:9999;top:-10px;padding:4px 5px;text-align:center;color:#FFF;" class="over_group" id="over_group'.$u->id.'">';
									foreach($grps as $grp) { echo "<p style='border-bottom:1px solid #fff;'>".@$this->user_model->getGroupNameById($grp)->name.'</p>';}	
								echo '</div>';
							} else {
								echo @$this->user_model->getGroupNameById($grps[0])->name;
							}*/ ?>
						</td>-->
						<!--<td><?php echo $u->is_ldap; ?></td>
						<td><?php if(!empty($u->date_joined)) echo date('d, M Y', $u->date_joined); ?></td>
						<td><?php if($u->activate == '1') { ?><span class="label label-success activeIn" data-id='<?=$u->id?>' data-act='0' style="cursor:pointer;" id="active-inactive<?=$u->id?>" data-tbl='accounts'><?=$this->lang->line("Active");?> </span><?php } else { ?>
						<span class="label label-important activeIn" data-id='<?=$u->id?>' data-act='1' style="cursor:pointer;" id="active-inactive<?=$u->id?>" data-tbl='accounts'><?=$this->lang->line("Inactive");?> </span><?php } ?></td>
						<td>
						  <!-- <button class="btn btn-mini btn-success"><i class="icon-ok"></i> </button>-->
							<!-- <a href="<?php echo $this->logik->setting('default_url'); ?>manage_users/edit_user/<?=$u->id;?>"><button class="btn btn-mini btn-warning"><i class="icon-pencil"></i> </button></a>
							  <!--
								  <a href="<?php echo $this->logik->setting('default_url'); ?>manage_users/delete/<?=$u->id;?>"onclick="if(!confirm('Sure want to delete this User')) return false;"><button class="btn btn-mini btn-danger delbutton"><i class="icon-remove"></i> </button></a>-->
					 <!--  </td>	
					</tr>
			<?php  } }?>
			  </tbody>-->
			  <tbody class="tb" style="border-bottom:1px solid;">
			</tbody>
    </table>
	
	<br>
    <div class="row clear-fix"  style="float:right; margin-right:0px;">
        <div class="col-md-4 pull-right">
            <button  id="previous" class="btn btn-sm btn-primary"><?=$this->lang->line("datatable_previous")?></button>
            <lable>Page <lable id="page_number"></lable> of <lable id="total_page"></lable></lable>
            <button  id="next" class="btn btn-sm btn-primary"><?=$this->lang->line("datatable_next")?></button>
        </div>
    </div>
	<div style="text-align: center">    
		<!--<img id="load_ajax_png" src="http://sanwebe.com/assets/ajax-load-more-results/ajax-loader.gif" alt="loading" style="display: none"/>-->
    </div>
      <!--<div class="pull-right"><?php //echo $this->pagination->create_links(); ?></div>-->
	</div>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<script type="text/javascript">   
    var page_number=0;
	 var total_page =null;
	 var sr =0;
	 var sr_no =0;

	var getReport = function(page_number){
		if($("#search").attr("value")!='') {
			search($("#search").attr("value"));
			return false;
		}
		if(page_number==0) {
			$("#previous").prop('disabled', true);
		} else {
			$("#previous").prop('disabled', false);
		}

		if(page_number==(total_page-1)) {
			$("#next").prop('disabled', true);
		} else {
			$("#next").prop('disabled', false);
		}


		 $("#page_number").text(page_number+1);
			 $.ajax({
				 url:"<?php echo $this->logik->setting('default_url'); ?>document/index",
				 type:"POST",
				 dataType: 'json',
				 data:'page_number='+page_number,
				 success:function(data){
					 window.mydata = data;
					  total_page= mydata[0].TotalRows;
					 $("#total_page").text(total_page);
		
					if(page_number==(total_page-1)) {
						$("#next").prop('disabled', true);
					} else {
						$("#next").prop('disabled', false);
					}
					 var record_par_page = mydata[0].Rows;
					$(".tb").html("");
					  $.each(record_par_page, function (key, data) {
						   //sr =(key+1);    
						   if(data.activate==1) {
							status = '<span class="label label-success activeIn" data-id="'+data.id+'" data-act="0" style="cursor:pointer;" id="active-inactive'+data.id+'" data-tbl="doc_types"><?=$this->lang->line("Active");?></span>';
						   } else {
							status = '<span class="label label-important activeIn" data-id="'+data.id+'" data-act="1" style="cursor:pointer;" id="active-inactive'+data.id+'" data-tbl="doc_types"><?=$this->lang->line("Inactive");?> </span>';
						   }
						   
						   
						   if(data.publish!=2) {
							path_plus = '<a href="<?=$this->logik->setting('default_url')?>document/create_form/'+data.id+'"><button class="btn btn-mini btn-info"><i class="icon-plus"></i></button></a>';
							
							path_ok = '<a href="<?=$this->logik->setting('default_url')?>document/publish/'+data.id+'"><button class="btn btn-mini btn-success"><i class="icon-ok"></i></button></a>';
							 
						   } else {
							path_plus = '<button class="btn btn-mini btn-info created"><i class="icon-plus"></i></button>';
							path_ok = '<button class="btn btn-mini btn-danger published"><i class="icon-ok"></i></button>';
						   }						   
						
							$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td>'+data.id+'</td><td style="text-align:left;">'+data.name+'</td><td>'+data.owner+'</td><td>'+data.create_date+'</td><td>'+status+'</td><td><a class="edit_general" href="<?=$this->logik->setting('default_url')?>document/edit/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i></button></a><button class="btn btn-mini btn-danger delbutton" data-uid="'+data.id+'"><i class="icon-remove"></i></button> '+path_plus+' '+path_ok+'</td></tr>');
					   });
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
					   $('.delbutton').live('click',function(){
							var user_id = $(this).data('uid');
							if(confirm("<?=$this->lang->line("delete_document_lang")?>")) {
								$.ajax({
									url:server_path+'document/delete',
									type:'POST',
									data:'del_id='+user_id,
									success:function(res) {
										if(res!=0) {
											$('#del'+res).hide('slow');
										} else {
											alert("<?=$this->lang->line("cant_del_document_lang")?>");
										}
									}
								})
							}
						})
						$(".published").click(function(){
								alert("<?=$this->lang->line("published_document_lang")?>");
						  })
						   $(".created").click(function(){
								alert("<?=$this->lang->line("created_document_lang")?>");
						  })
				  }
			 });
		   };
		   
				var search = function (str) {
					if(page_number==0){
						$("#previous").prop('disabled', true);}
						else{
							$("#previous").prop('disabled', false);}

					if(page_number==(total_page-1)){
						$("#next").prop('disabled', true);}
						else{
							$("#next").prop('disabled', false);}

					 $("#page_number").text(page_number+1);

					if(str!='') {
						   $.ajax({
							url:"<?php echo $this->logik->setting('default_url'); ?>document/index",
							 type:"POST",         
							 dataType: 'json',                                    
							 data:'search='+str+'&page_number='+page_number,
							 success:function(data){
								window.mydata = data;
								if(data) {
								total_page= mydata[0].TotalRows;
								}
								$("#total_page").text(total_page);
								if(page_number==(total_page-1)) {
									$("#next").prop('disabled', true);
								} else {
									$("#next").prop('disabled', false);
								}
								$(".tb").html('');
								if(data) {
								var record_par_page = mydata[0].Rows;
								
								$.each(record_par_page, function (key, data) {
							   //sr =(key+1);    
							   if(data.activate==1) {
								status = '<span class="label label-success activeIn" data-id="'+data.id+'" data-act="0" style="cursor:pointer;" id="active-inactive'+data.id+'" data-tbl="doc_types"><?=$this->lang->line("Active");?></span>';
							   } else {
								status = '<span class="label label-important activeIn" data-id="'+data.id+'" data-act="1" style="cursor:pointer;" id="active-inactive'+data.id+'" data-tbl="doc_types"><?=$this->lang->line("Inactive");?> </span>';
							   }
							   
							   
							   if(data.publish!=2) {
								path_plus = '<a href="<?=$this->logik->setting('default_url')?>document/create_form/'+data.id+'"><button class="btn btn-mini btn-info"><i class="icon-plus"></i></button></a>';
								
								path_ok = '<a href="<?=$this->logik->setting('default_url')?>document/publish/'+data.id+'"><button class="btn btn-mini btn-success"><i class="icon-ok"></i></button></a>';
								 
							   } else {
								path_plus = '<button class="btn btn-mini btn-info created"><i class="icon-plus"></i></button>';
								path_ok = '<button class="btn btn-mini btn-success published"><i class="icon-ok"></i></button>';
							   }						   
							
							$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td>'+data.id+'</td><td style="text-align:left;">'+data.name+'</td><td>'+data.owner+'</td><td>'+data.create_date+'</td><td>'+status+'</td><td><a class="edit_general" href="<?=$this->logik->setting('default_url')?>document/edit/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i></button></a><button class="btn btn-mini btn-danger delbutton" data-uid="'+data.id+'"><i class="icon-remove"></i></button> '+path_plus+' '+path_ok+'</td></tr>');
					   });
					   	 $(".published").click(function(){
								alert("<?=$this->lang->line("published_document_lang")?>");
						  })
						   $(".created").click(function(){
								alert("<?=$this->lang->line("created_document_lang")?>");
						  })
								} else {
									$(".tb").append('<tr style="text-align:center;border-bottom:0.5px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
								}
							
							 }
						
						});
					}
				};


   $(document).ready(function(e){
	  getReport(page_number);
	 // console.log(sr);
	   
	 $("#next").on("click", function(){
		   $(".tb").html("");
		   page_number = (page_number+1);
		   getReport(page_number);
		   console.log(sr);
		   
	 });
		
	 $("#previous").on("click", function(){
		  $(".tb").html("");
		  page_number = (page_number-1);
		  getReport(page_number);
	 });
	 
	 
	 $("#search").on('keyup', function(){
		 var str = $.trim($(this).val());
		if(str) { 
			search(str);
		} else {
			getReport(page_number);
		}
	 });
});
  
</script>
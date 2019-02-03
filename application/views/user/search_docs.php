<link href="<?=$this->logik->setting("default_url")?>assets/app/style/pagination.css" rel="stylesheet">
<div class="row-fluid">
	<?php $this->load->view('user/user_menu');?>
	<?php $post = ''; 
	foreach($_SESSION['POST'] as $key=>$field) {
		if(empty($field)) {
			$field = 0;
		}
		$post .= '&'.$key.'='.$field;
	}?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-top:15px;">
		<div id="tableMessage" style="display:none;"></div>
      <!--search option-->
		<div style="display:none;" id="advSearchFrm">
			<form action="searchDocuments" method="post" id="searchForm">
				<div><h5><?=$this->lang->line("search_documents");?></h5></div>
				<div>
				<?=$this->lang->line("select_documents");?><br>
				<select name="doc_type" multiple>
				<?php if(!empty($docTypes)) {
						foreach($docTypes as $doc) {?>
						<option value="<?=$doc['id']?>"><?=ucfirst($doc['name'])?></option>
				<?php }
					}  else {?>
						<option value=""><?=$this->lang->line("no_documents");?></option>
					<?php }?>
				</select>
				</div>
				<div>
					<h5><?=$this->lang->line("search_by_word");?></h5>
					<input type="text" name="search_by_word">
				</div>
				<div>
					<h5><?=$this->lang->line("search_by_any_word");?></h5>
					<input type="text" name="search_by_any_word">
				</div>
				<div>
					<h5><?=$this->lang->line("search_by_not_of_word");?></h5>
					<input type="text" name="search_by_not_of_word">
				</div>
					
				<div id="datetimepicker1" class="input-append" style="float:left;">
					<h5><?=$this->lang->line("statistics_from");?></h5>
					<input data-format="dd-MM-yyyy" type="text" name="from" placeholder="<?=$this->lang->line("statistics_from");?>" value="<?=@$_POST['from']?>" style="width:63px;">
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
				</div>
				
				<div id="datetimepicker3" class="input-append" style="float:left; margin-left:10px;">
					<h5><?=$this->lang->line("statistics_to");?></h5>
					<input data-format="dd-MM-yyyy" type="text" name="to" placeholder="<?=$this->lang->line("statistics_to");?>" value="<?=@$_POST['to']?>" style="width:63px;">
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
				</div>
				&nbsp;
			
				<!--<select name="groups">
				<option value=""><?=$this->lang->line("select_group");?></option>
				<?php //$groups = $this->auth_model->get_user()->groups;
						//$groups = explode(',', $groups);
						//foreach($groups as $group) {?>
						<option value="<?=$group?>"><?=ucfirst($this->user_model->getGroupNameById($group)->name)?></option>
				<?php //} ?>
				</select>-->
				<div style="clear:both;"></div>
				<br>
				<input type="submit" name="submit" value="Buscar" class="btn">
			</form>
		</div>
        <hr>
		<!--end search option-->

       <!-- <div style="float:right; margin-right:2px;display:none;" id="uploadFile">
        <form  action="editDocumentTypes" method="get" enctype="multipart/form-data" id="form2" name="form2">
        <input class="btn" type="file" id="file_upload" name="upload">
        <input type="hidden" class="document_id" name="document_id" id="document_id" value="" />
        </form></div>-->
      
 <div id="allDocs" style=" margin-right:16px;"><div style="float:left;"><h5><?=$this->lang->line("my_documents");?></h5></div>
		 <div style="float:right; margin-right:20px; cursor:pointer;"><h5 id="advanceSearch"><?=$this->lang->line("new_advance_search_label");?></h5></div><br style="clear:both;">
	<table class="display" cellspacing="0" width="100%" id="tabs1" style="border:1px solid #CCC;">
		  <thead style="border-bottom:1px solid;">
		  <tr style="background-color:#F5F5F5;"><td colspan="7" style="text-align:right;"><input type="text" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-bottom:0;" /></td></tr>
		  <tr style="background-color:#E6E6E6;height:35px;"> 
			<th style="display:none;"></th>
			<th style="width:10%;"><?=$this->lang->line("number")?></th>
			<th style="width:30%;"><?=$this->lang->line("description")?></th>
			<th style="width:10%;"><?=$this->lang->line("user")?></th>
			<th style="width:5%"><?=$this->lang->line("Groups")?></th>
			<th style="width:12%;"><?=$this->lang->line("date_of_load")?></th>
			<th style="width:13%; margin-right:10px;"><?=$this->lang->line("last_modified")?></th>
		</tr>
		</thead>        
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
 </div>
    
    
      <div class="pull-right"><?php //echo $this->pagination->create_links(); ?></div>
	</div>
</div>


 <script type="text/javascript">
   
$(".dataTables_info").remove();
//var str=$(".dataTables_empty").html();
//var gh=str.replace("Search", "Buscar");
//$(".dataTables_empty").html("No hay registros disponibles");

$(".latestProductsNav .test_span").removeClass("test_span");


$("#advanceSearch").click(function(){
	$("#advSearchFrm").slideToggle("slow");
})


////ajax pagination//////
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

		if(page_number==0) {
			$("#next").prop('disabled', true);
		} else {
			$("#next").prop('disabled', false);
		}


		$("#page_number").text(page_number+1);
			$.ajax({
				url:"<?php echo $this->logik->setting('default_url'); ?>user/searchByAjax",
				type:"POST",
				dataType: 'json',
				data:'page_number='+page_number+'<?=$post?>',
				success:function(data){
					//console.log(data);
					window.mydata = data;
					// console.log(mydata[0]['Rows']);
					 if(data!=null) {
						total_page= mydata[0].TotalRows;
					 } else {
						total_page = 0;
						$("#page_number").text(0);
					 }
					 $("#total_page").text(total_page);
		
					if(page_number>=(total_page-1)) {
						$("#next").prop('disabled', true);
					} else {
						$("#next").prop('disabled', false);
					}
					if(data!=null) { 
						 var record_par_page = mydata[0]['Rows'];
						 
						$(".tb").html("");
						var colr = 0;
						  $.each(record_par_page, function (key, rec) {
								$.each(rec, function (key1, data) {
									if(colr%2==0) {
										color = 'background-color:#F2F4F3;';
									} else {
										color = '';
									}
									if(data.modified==null) {
										data.modified = '----';
									}
									if(data.numero_de_documento) {
										data.document__id = data.numero_de_documento;
									}
									if(data.descripcion) {
										data.description = data.descripcion;
									}
									
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:left;"><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.document__id+'</a></td><td style="text-align:left;"><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.description+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.user_id+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.groups+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.created+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.modified+'</td></a></tr>');
									colr++;
								});
						   });
					    } else {
							$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
						}
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
							url:"<?php echo $this->logik->setting('default_url'); ?>user/searchByAjax",
							 type:"POST",         
							 dataType: 'json',                                    
							data:'search='+str+'&page_number='+page_number+'<?=$post?>',
							//data:'search='+str,
							success:function(data){
								window.mydata = data;
								if(data!=null) {
								total_page= mydata[0].TotalRows;
								} else {
									total_page = 0;
									$("#page_number").text(0);
								}
								$("#total_page").text(total_page);
								if(page_number>=(total_page-1)) {
									$("#next").prop('disabled', true);
								} else {
									$("#next").prop('disabled', false);
								}
								$(".tb").html('');
								if(data!=null) { 
								colr = 0;
								var record_par_page = mydata[0]['Rows'];
								
									$.each(record_par_page, function (key, rec) {
										$.each(rec, function (key1, data) {
											if(colr%2==0) {
												color = 'background-color:#F2F4F3;';
											} else {
												color = '';
											}
											if(data.modified==null) {
												data.modified = '----';
											}
											if(data.numero_de_documento) {
												data.document__id = data.numero_de_documento;
											}
											if(data.descripcion) {
												data.description = data.descripcion;
											}
											$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC; height:30px;'+color+'"><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.document__id+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.description+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.user_id+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.groups+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.created+'</a></td><td><a href="loadEditDocumentTypes/'+data.table+'/'+data.id+'">'+data.modified+'</td></a></tr>');
											colr++;
										});
									});
								} else {
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
								}
							 }
						});
					}
				};

   $(document).ready(function(e){
	  getReport(page_number);
	 // console.log(sr);
	   
	 $("#next").on("click", function(){
		 //  $(".tb").html("");
		   page_number = (page_number+1);
		   getReport(page_number);
		 //  console.log(sr);
		   
	 });
		
	 $("#previous").on("click", function(){
		//  $(".tb").html("");
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

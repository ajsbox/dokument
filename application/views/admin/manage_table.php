<link href="<?=$this->logik->setting("default_url")?>assets/app/style/pagination.css" rel="stylesheet">
  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu');  ?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		<div id="tableMessage" style="display: none;"></div>
         <div style="text-align:left; margin-top:40px;"><h3><?=$this->lang->line("user_documents");?></h3></div>
			 <div id="allDocs1" style=" margin-right:16px;">
				 <table class="display" cellspacing="0" width="100%" id="tabs1" style="border:1px solid #CCC;">
					  <thead style="border-bottom:1px solid;">
					  <tr style="background-color:#F5F5F5;"><td colspan="7" style="text-align:right;"><input type="text" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-bottom:0;" /></td></tr>
					  <tr style="background-color:#E6E6E6;height:35px;">
						  
						<th style="display:none;"></th>
						<th style="width:15%;"><?=$this->lang->line("number")?></th>
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

    <?php if(!empty($rec)) { ?>
          <!--	<tr><td align="center" colspan="6"><strong>No Records</strong></td></tr>-->
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
          <?php }?>

      <div class="pull-right"><?php //echo $this->pagination->create_links(); ?></div>
	</div>
</div>
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

		if(page_number==0) {
			$("#next").prop('disabled', true);
		} else {
			$("#next").prop('disabled', false);
		}


		$("#page_number").text(page_number+1);
			$.ajax({
				url:"<?php echo $this->logik->setting('default_url'); ?>admin/home_ajax",
				type:"POST",
				dataType: 'json',
				data:'page_number='+page_number,
				success:function(data){
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
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:left; padding-left:10px;">'+data.document__id+'</td><td style="text-align:left; padding-left:10px;">'+data.description+'</td><td>'+data.user_id+'</td><td>'+data.groups+'</td><td>'+data.created+'</td><td>'+data.modified+'</td></tr>');
									colr++;
								});
						   });
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
						url:"<?php echo $this->logik->setting('default_url'); ?>admin/home_ajax",
						 type:"POST",         
						 dataType: 'json',                                    
						 data:'search='+str+'&page_number='+page_number,
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
										$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:left; padding-left:10px;">'+data.document__id+'</td><td style="text-align:left; padding-left:10px;">'+data.description+'</td><td>'+data.user_id+'</td><td>'+data.groups+'</td><td>'+data.created+'</td><td>'+data.modified+'</td></tr>');
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
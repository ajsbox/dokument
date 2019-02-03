
<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu');  ?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		<div id="tableMessage" style="display: none;"></div>	
		<ul id="countrytabs" class="shadetabs"><br/>
		<li><a href="#" rel="country1" class="selected"><?=$this->lang->line("log_action_log");?></a></li>
		<li><a href="#" rel="country2"><?=$this->lang->line("log_document_log");?></a></li>
		</ul>
		<div style="border-top:1px solid gray; width:auto; margin-bottom: 1em; padding: 10px; padding-bottom:50px;">
			<div id="country1" class="tabcontent">
			<form action="log" method="post" style="padding:1px;">
				<!--<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
				<div id="datetimepicker4" class="input-append" style="float:left;">
					<span class="add-on" style="border-radius:5px 0px 0px 5px;">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
					<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;" value="<?=@$_POST['begin_time']?>">
				</div>
				<div style="float:left; width:40px;font-size:14px; margin-top:7px; margin-left:5px;"><?=$this->lang->line("statistics_to");?></div>
				<div id="datetimepicker5" class="input-append" style="float:left;">
					<span class="add-on" style="border-radius:5px 0px 0px 5px;">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
					<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;" value="<?=@$_POST['end_time']?>">
					
				</div>
				<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" class="btn" style="margin-left:5px;"  style="float:left;">
				<div style="clear:both;"></div>-->
				
			 </form>
			 <table class="display" cellspacing="0" width="100%" id="example">
				<thead style="border-bottom:1px solid;">
					<tr role="row">
						<!--<th style="width:10%"><?=$this->lang->line("number")?></th>
						<th style="width:30%"><?=$this->lang->line("description")?></th>-->
						<th style="width:20%"><?=$this->lang->line("action")?></th>
						<th style="width:15%"><?=$this->lang->line("user")?></th>
						<!--<th style="width:10%"><?=$this->lang->line("Groups")?></th>-->
						<th style="width:15%"><?=$this->lang->line("action_ip_address")?></th>
						<!--<th style="width:15%"><?=$this->lang->line("action_mac_address")?></th>-->
					   <!-- <th style="width:15%"><?=$this->lang->line("date_of_load")?></th>-->
					   <th style="width:10%"><?=$this->lang->line("log_date")?></th>
					   <th style="width:10%"><?=$this->lang->line("log_time")?></th><input type="text" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-right:0px;height:25px;"/>
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

			<div id="country2" class="tabcontent">
			<form action="log" method="post" style="padding:1px;">
				<!--<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
				<div id="datetimepicker6" class="input-append" style="float:left;">
					
					<span class="add-on" style="border-radius:5px 0px 0px 5px;">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
					<input data-format="yyyy-MM-dd" type="text" name="begin_time" style="border-radius:0px 5px 5px 0px;" value="<?=@$_POST['begin_time']?>">
				</div>
				<div style="float:left; width:40px;font-size:14px; margin-top:7px; margin-left:5px;"><?=$this->lang->line("statistics_to");?></div>
				<div id="datetimepicker7" class="input-append" style="float:left;">
					
					<span class="add-on" style="border-radius:5px 0px 0px 5px;">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					  </i>
					</span>
					<input data-format="yyyy-MM-dd" type="text" name="end_time" style="border-radius:0px 5px 5px 0px;" value="<?=@$_POST['end_time']?>">
				</div>
				<input type="submit" value="<?=$this->lang->line("statistics_submit");?>" class="btn" style="margin-left:5px;"  style="float:left;">
				<div style="clear:both;"></div>-->
			</form>
			 <table class="display" cellspacing="0" width="100%" id="example1">
                <thead style="border-bottom:1px solid;">
                    <tr role="row">
                 		<th style="width:20%"><?=$this->lang->line("number")?></th>
                        <!--<th style="width:30%"><?=$this->lang->line("description")?></th>-->
						<th style="width:20%"><?=$this->lang->line("action")?></th>
                        <th style="width:15%"><?=$this->lang->line("user")?></th>
                        <!--<th style="width:10%"><?=$this->lang->line("Groups")?></th>-->
						<th style="width:15%"><?=$this->lang->line("action_ip_address")?></th>
						<!--<th style="width:15%"><?=$this->lang->line("action_mac_address")?></th>-->
                       <!-- <th style="width:15%"><?=$this->lang->line("date_of_load")?></th>-->
					   <th style="width:10%"><?=$this->lang->line("log_date")?></th>
					   <th style="width:10%"><?=$this->lang->line("log_time")?></th><input type="text" name="search1" id="search1" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-right:0px;height:25px;"/>
					</tr>
				</thead>
				<tbody class="tb1" style="border-bottom:1px solid;">
				</tbody>
			</table>
			<br>
			<div class="row clear-fix"  style="float:right; margin-right:0px;">
				<div class="col-md-4 pull-right">
					<button  id="previous1" class="btn btn-sm btn-primary"><?=$this->lang->line("datatable_previous")?></button>
					<lable>Page <lable id="page_number1"></lable> of <lable id="total_page1"></lable></lable>
					<button  id="next1" class="btn btn-sm btn-primary"><?=$this->lang->line("datatable_next")?></button>
				</div>
			</div>	
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
  
      <div class="pull-right"><?php //echo $this->pagination->create_links(); ?></div>
	</div>
</div>
 
<script type="text/javascript" src="<?=SERVER?>assets/js/contentslider.js"> </script>
<link href="<?=SERVER?>assets/css/contentslider.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
/////for tab////
var countries=new ddtabcontent("countrytabs");
countries.setpersist(true);
countries.setselectedClassTarget("link"); //"link" or "linkparent"
countries.init();
</script>
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
				 url:"<?php echo $this->logik->setting('default_url'); ?>admin/log_ajax",
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
						if(data.mac_address) {
							mac = data.mac_address;
						} else {
							mac = '---';
						}
						$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;height:30px;"><td style="text-align:left;">'+data.action+'</td><td>'+data.user_id+'</td><td>'+data.ip_address+'</td><td>'+data.create_date+'</td><td>'+data.time+'</td></tr>');
					   });
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
							url:"<?php echo $this->logik->setting('default_url'); ?>admin/log_ajax",
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
									if(data.mac_address) {
										mac = data.mac_address;
									} else {
										mac = '---';
									}
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;height:30px;"><td>'+data.action+'</td><td>'+data.user_id+'</td><td>'+data.document_id+'</td><td>'+data.ip_address+'</td><td>'+data.create_date+'</td><td>'+data.time+'</td></tr>');
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
		   $(".tb").html("");
		   page_number = (page_number+1);
		   getReport(page_number);
		   //console.log(sr);
		   
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

<script type="text/javascript">   
    var page_number1=0;
	 var total_page1 =null;
	 var sr1 =0;
	 var sr_no =0;

	var getReport1 = function(page_number1){
		if($("#search1").attr("value")!='') {
			search1($("#search1").attr("value"));
			return false;
		}
		if(page_number1==0) {
			$("#previous1").prop('disabled', true);
		} else {
			$("#previous1").prop('disabled', false);
		}

		if(page_number1==(total_page1-1)) {
			$("#next1").prop('disabled', true);
		} else {
			$("#next1").prop('disabled', false);
		}

		
		 $("#page_number1").text(page_number1+1);
			 $.ajax({
				 url:"<?php echo $this->logik->setting('default_url'); ?>admin/doc_log_ajax",
				 type:"POST",
				 dataType: 'json',
				 data:'page_number='+page_number1,
				 success:function(data){
					 window.mydata = data;
					  total_page1= mydata[0].TotalRows;
					 $("#total_page1").text(total_page1);
		
					if(page_number1==(total_page1-1)) {
						$("#next1").prop('disabled', true);
					} else {
						$("#next1").prop('disabled', false);
					}
					 var record_par_page = mydata[0].Rows;
					$(".tb1").html("");
					  $.each(record_par_page, function (key, data) {
						if(data.mac_address) {
							mac = data.mac_address;
						} else {
							mac = '---';
						}
						$(".tb1").append('<tr style="text-align:center;border-bottom:1px solid #CCC;height:30px;"><td style="text-align:left;">'+data.document_id+'</td><td style="text-align:left;">'+data.action+'</td><td>'+data.user_id+'</td><td>'+data.ip_address+'</td><td>'+data.create_date+'</td><td>'+data.time+'</td></tr>');
					   });
				  }
			 });
		   };
		   
				var search1 = function (str) {
					if(page_number1==0){
						$("#previous1").prop('disabled', true);}
						else{
							$("#previous1").prop('disabled', false);}

					if(page_number1==(total_page1-1)){
						$("#next1").prop('disabled', true);}
						else{
							$("#next1").prop('disabled', false);}

					 $("#page_number1").text(page_number1+1);

					if(str!='') {
						   $.ajax({
							url:"<?php echo $this->logik->setting('default_url'); ?>admin/doc_log_ajax",
							 type:"POST",         
							 dataType: 'json',                                    
							 data:'search='+str+'&page_number='+page_number1,
							 success:function(data){
								window.mydata = data;
								if(data) {
								total_page1= mydata[0].TotalRows;
								}
								$("#total_page1").text(total_page1);
								if(page_number1==(total_page1-1)) {
									$("#next1").prop('disabled', true);
								} else {
									$("#next1").prop('disabled', false);
								}
								$(".tb1").html('');
								if(data) {
								var record_par_page = mydata[0].Rows;
								
								$.each(record_par_page, function (key, data) {
									if(data.mac_address) {
										mac = data.mac_address;
									} else {
										mac = '---';
									}
									$(".tb1").append('<tr style="text-align:center;border-bottom:1px solid #CCC;height:30px;"><td>'+data.document_id+'</td><td>'+data.action+'</td><td>'+data.user_id+'</td><td>'+data.ip_address+'</td><td>'+data.create_date+'</td><td>'+data.time+'</td></tr>');
								});
								} else {
									$(".tb1").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
								}
							 }
						});
					}
				};


   $(document).ready(function(e){
	 getReport1(page_number1);
	 
	 $("#next1").on("click", function(){
		   $(".tb1").html("");
		   page_number1 = (page_number1+1);
		   getReport1(page_number1);
		   //console.log(sr1);
	 });
		
	 $("#previous1").on("click", function(){
		  $(".tb1").html("");
		  page_number1 = (page_number1-1);
		  getReport1(page_number1);
	 });
	 
	 
	 $("#search1").on('keyup', function(){
		 var str = $.trim($(this).val());
		if(str) { 
			search1(str);
		} else {
			getReport1(page_number1);
		}
	 });
});
  
</script>  
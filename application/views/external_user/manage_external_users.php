  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
       <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		 <div id="tableMessage" style="display: none;"></div>
         <div style="margin-top:10px;"><a href="add_ex_users"><button class="btn btn-success"><i class="icon-user"></i>    <?=$this->lang->line("ex_ad_user");?></button></a><caption><h3 align="center"><?=$this->lang->line("manage_ex_user");?></h3></caption></div>
		  <?php if(isset($update) and $update=='bind') {?>
				<div class="alert alert-error"><?=$this->lang->line("ldap_bind_error");?></div>
		 <?php } elseif(isset($update) and $update=='config') {?>
				<div class="alert alert-error"><?=$this->lang->line("ldap_config_not_save");?></div>
		 <?php }?>
			<table class="display" cellspacing="0" width="100%" id="example">
  			<thead style="border-bottom:1px solid;">
    			<tr>
      				<th>ID<?php //$this->lang->line("gi");?></th>
					<th><?=$this->lang->line("Name");?></th>
      				<th>E-mail</th>
					<th><?=$this->lang->line("Description");?></th>
                    <th><?=$this->lang->line("joined_date");?></th>
      				<th><?php echo $this->lang->line("action");?></th><input type="text" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-right:0px;height:25px;"/>
    			</tr>
  			</thead>
  			<!--<tbody>
  				<?php foreach($users as $u): ?>
    			<tr style="text-align:center;" id="del<?php echo $u->id; ?>">
      				<td><?php echo $u->id; ?></td>
      				<td><?php echo $u->name; ?></td>
      				<td><?php echo $u->email; ?></td>                  
                    <td><?php echo date('d, M Y', $u->created); ?></td>
                    <td><?php echo date('d, M Y', $u->modify); ?></td>
                    
                    <td><?php echo ucfirst(substr($u->descrition,0,20)); if(strlen($u->descrition)>20){echo "....";}?>&nbsp;</td>
      				
      				<td>
                        <a class="edit_general" href="<?php echo $this->logik->setting('default_url'); ?>external_users/edit_user/<?=$u->id;?>"><button class="btn btn-mini btn-warning" data-uid="<?php echo $u->id; ?>"><i class="icon-pencil"></i> </button></a>                   
                       <button class="btn btn-mini btn-danger delete_user" data-did="<?php echo $u->id;?>" title="Delete"><i class="icon-remove"></i> </button>
      				</td>
    			</tr>
    			<?php endforeach; ?>
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
		if(page_number==0){
			$("#previous").prop('disabled', true);
			}
			else{
				$("#previous").prop('disabled', false);}

		if(page_number==(total_page-1)){
			$("#next").prop('disabled', true);}
			else{
				$("#next").prop('disabled', false);}


		 $("#page_number").text(page_number+1);

			 $.ajax({
				 url:"<?php echo $this->logik->setting('default_url'); ?>external_users/index",
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
							$(".tb").append('<tr style="text-align:left;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td style="text-align:center;">'+data.id+'</td><td style="text-align:left; padding-left:10px;">'+data.name+'</td><td style="text-align:left; padding-left:10px;">'+data.email+'</td><td style="text-align:left; padding-left:10px;">'+data.description+'</td><td style="text-align:center;">'+data.create_date+'</td><td style="text-align:center;"><a class="edit_general" href="<?=$this->logik->setting('default_url')?>external_users/edit_user/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i> </button></a><button class="btn btn-mini btn-danger delete_exuser" data-did="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-remove"></i> </button></td></tr>');
					   });
					   $('.delete_exuser').live('click',function(){
						var group_id = $(this).data('did');
						if(confirm('<?=$this->lang->line("delete_exuser_confirmation");?>')) {
							$.ajax({
								url:server_path+'external_users/delete',
								type:'POST',
								data:'user_id='+group_id,
								success:function(res) {
									if(res) {
										$('#del'+res).hide('slow');
									}
									}
								})
							}
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
							url:"<?php echo $this->logik->setting('default_url'); ?>external_users/index",
							 type:"POST",         
							 dataType: 'json',                                    
							 data:'search='+str+'&page_number='+page_number,
							 success:function(data){
								window.mydata = data;
								if(data) {
								total_page = mydata[0].TotalRows;
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
									  $(".tb").append('<tr style="text-align:left;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td style="text-align:center;">'+data.id+'</td><td style="text-align:left; padding-left:10px;">'+data.name+'</td><td style="text-align:left; padding-left:10px;">'+data.email+'</td><td style="text-align:left; padding-left:10px;">'+data.description+'</td><td style="text-align:center;">'+data.create_date+'</td><td style="text-align:center;"><a class="edit_general" href="<?=$this->logik->setting('default_url')?>external_users/edit_user/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i> </button></a><button class="btn btn-mini btn-danger delete_exuser" data-did="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-remove"></i> </button></td></tr>');
									//$(".tb").append('<tr style="text-align:left;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td style="text-align:center;">'+data.id+'</td><td style="text-align:left;">'+data.name+'</td><td style="text-align:left;">'+data.email+'</td><td style="text-align:left;">'+data.description+'</td><td style="text-align:center;">'+data.create_date+'</td><td style="text-align:center;"><a class="edit_general" href="<?=$this->logik->setting('default_url')?>external_users/edit_user/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i> </button></a><button class="btn btn-mini btn-danger delete_exuser" data-did="'+data.id+'"><i class="icon-remove"></i> </button></td></tr>');
								 });
								} else {
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="5"><?=$this->lang->line("datatable_no_record")?></td></tr>');
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
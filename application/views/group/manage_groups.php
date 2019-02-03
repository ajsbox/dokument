  <link rel="stylesheet" href="">
<!-- Latest compiled and minified JavaScript -->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->

  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
       <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		 <div id="tableMessage" style="display: none;"></div>
         <div style="margin-top:10px;"><a href="<?=$this->logik->setting('default_url')?>group/add"><button class="btn btn-success"><i class="icon-group"></i>    <?=$this->lang->line("ag");?></button></a>&nbsp;&nbsp;<a href="<?=$this->logik->setting('default_url')?>group/add_ldap_groups"><button class="btn btn-success"><i class="icon-group"></i>    <?=$this->lang->line("add_group_from_ldap");?></button></a><caption><h3 align="center"><?=$this->lang->line("mg");?></h3></caption></div>
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
      				<th><?=$this->lang->line("Owner");?></th>
                   <!-- <th><?=$this->lang->line("Roles");?></th>-->
                    <th><?=$this->lang->line("cd");?></th>
      				<!--<th><?php //echo $this->lang->line("as");?></th>-->
      				<th><?php echo $this->lang->line("action");?></th><input type="text" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-right:10px;height:25px;"/>
    			</tr>
  			</thead>
			
  			<!--<tbody>
  				<?php foreach($groups as $u): ?>
    			<tr style="text-align:center;" id="del<?php echo $u->id; ?>">
      				<td><?php echo $u->id; ?></td>
      				<td><?php echo $u->name; ?></td>
      				<td><?php echo $u->owner; ?></td>
                    <!-- <td class="group_over" style="position:relative" id="<?=$u->id?>">
                   <?php /*$rols = explode(',', $u->roles);
							if(count($rols)>1) {
								echo "Multiple";
								echo '<div style="background:#000;display:none;position:absolute;z-index:9999;top:-10px;padding:4px 5px;text-align:center;color:#FFF;" class="over_group" id="over_group'.$u->id.'">';
									foreach($rols as $rol) { echo "<p style='border-bottom:1px solid #fff;'>".$this->group_model->getRoleNameById($rol)->name.'</p>';}	
								echo '</div>';
							} else {
								echo $this->group_model->getRoleNameById($rols[0])->name;
							}*/ ?>
                     
                     </td>-->
                   <!-- <td><?php echo date('d, M Y', $u->create_date); ?></td>
      				<!-- <td><?php if($u->activate == '1') { ?><span class="label label-success activeIn" data-id='<?=$u->id?>' data-act='0' style="cursor:pointer;" id="active-inactive<?=$u->id?>" data-tbl='groups'><?=$this->lang->line("Active");?> </span><?php } else { ?>
                    <span class="label label-important activeIn" data-id='<?=$u->id?>' data-act='1' style="cursor:pointer;" id="active-inactive<?=$u->id?>" data-tbl='groups'><?=$this->lang->line("Inactive");?> </span><?php } ?></td>-->
      				<!--<td>
                        <a class="edit_general" href="<?=$this->logik->setting('default_url')?>group/edit/<?=$u->id?>"><button class="btn btn-mini btn-warning" data-uid="<?php echo $u->id; ?>"><i class="icon-pencil"></i> </button></a>
                        <!--<button class="btn btn-mini btn-danger delete_group" data-did="<?php echo $u->id;?>"><i class="icon-remove"></i> </button>-->
      			<!--	</td>
    			</tr>
    			<?php endforeach; ?>
  			</tbody>-->
			<tbody class="tb" style="border-bottom:1px solid;">
			</tbody>
		</table>
<br>
    <div class="row clear-fix"  style="float:right; margin-right:10px;">
        <div class="col-md-4 pull-right">
            <button  id="previous" class="btn btn-sm btn-primary"><?=$this->lang->line("datatable_previous")?></button>
            <lable>Page <lable id="page_number"></lable> of <lable id="total_page"></lable></lable>
            <button  id="next" class="btn btn-sm btn-primary"><?=$this->lang->line("datatable_next")?></button>
        </div>
    </div>
	<div style="text-align: center">    
		<!--<img id="load_ajax_png" src="http://sanwebe.com/assets/ajax-load-more-results/ajax-loader.gif" alt="loading" style="display: none"/>-->
    </div>
      <!--<div class="pull-right"><?php //echo$this->pagination->create_links(); ?></div>-->
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
   
      /*     var table = $('#example').DataTable({
	    "order": [[ 0, "desc" ]],
	    "language": {
            "sSearch": '<?=$this->lang->line("datatable_search")?>',
            "zeroRecords": "<?=$this->lang->line("datatable_no_record")?>",
            "info": "<?=$this->lang->line("datatable_showing")?> _PAGE_ <?=$this->lang->line("datatable_of")?> _PAGES_",
			"sLengthMenu":     "<?=$this->lang->line("datatable_show")?> _MENU_ <?=$this->lang->line("datatable_entry")?>",
            "infoFiltered": "(<?=$this->lang->line("datatable_filter")?> <?=$this->lang->line("datatable_of")?> _MAX_ total <?=$this->lang->line("datatable_of")?> <?=$this->lang->line("datatable_record")?>)",
			"oPaginate": {
				"sFirst":    "<?=$this->lang->line("datatable_first")?>",
				"sLast":     "<?=$this->lang->line("datatable_last")?>",
				"sNext":     "<?=$this->lang->line("datatable_next")?>",
				"sPrevious": "<?=$this->lang->line("datatable_previous")?>"
			}
        }
		   });
  /*var str=$(".dataTables_filter label").html();
  var gh=str.replace("Search", "Buscar");
  $(".dataTables_filter label").html(gh);*/

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
				 url:"<?php echo $this->logik->setting('default_url'); ?>group/index",
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
							$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td>'+data.id+'</td><td style="text-align:left;">'+data.name+'</td><td>'+data.owner+'</td><td>'+data.create_date+'</td><td><a class="edit_general" href="<?=$this->logik->setting('default_url')?>group/edit/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i> </button></a><button class="btn btn-mini btn-danger delete_group" data-did="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-remove"></i> </button></td></tr>');
					   });
					   $('.delete_group').live('click',function(){
						var group_id = $(this).data('did');
						if(confirm('<?=$this->lang->line("delete_group_confirmation");?>')) {
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
							url:"<?php echo $this->logik->setting('default_url'); ?>group/index",
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
									
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;" id="del'+data.id+'"><td>'+data.id+'</td><td style="text-align:left;">'+data.name+'</td><td>'+data.owner+'</td><td>'+data.create_date+'</td><td><a class="edit_general" href="<?=$this->logik->setting('default_url')?>group/edit/'+data.id+'"><button class="btn btn-mini btn-warning" data-uid="'+data.id+'" style="margin:3px;height:23px;width:22px;"><i class="icon-pencil"></i> </button></a><button class="btn btn-mini btn-danger delete_group" data-did="'+data.id+'"><i class="icon-remove"></i> </button></td></tr>');
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
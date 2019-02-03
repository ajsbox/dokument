
<div class="row-fluid">
<?php $this->load->view('user/user_menu');?>
    <?php $sn = 1; $perpage = 15; $start=0;	?>
	<div class="span10" style="padding-right:20px;">
		<div id="tableMessage" style="display: none;"></div>	
		<ul id="countrytabs" class="shadetabs">
		<li><a href="#" rel="country1" class="selected"><?=$this->lang->line("log_action_log");?></a></li>
		<li><a href="#" rel="country2"><?=$this->lang->line("log_document_log");?></a></li>
		
		</ul>
		<div style="border:1px solid gray; width:auto; margin-bottom: 1em; padding: 10px">
			<div id="country1" class="tabcontent">
			<form action="log" method="post">
				<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
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
				<div style="clear:both;"></div>
			</form>
			 <table class="display" cellspacing="0" width="100%" id="example">
                <thead>
                    <tr role="row">
                 		<!--<th style="width:10%"><?=$this->lang->line("number")?></th>
                        <th style="width:30%"><?=$this->lang->line("description")?></th>-->
                        <th style="width:15%"><?=$this->lang->line("user")?></th>
                        <th style="width:10%"><?=$this->lang->line("Groups")?></th>
						<th style="width:15%"><?=$this->lang->line("action")?></th>
                       <!-- <th style="width:15%"><?=$this->lang->line("date_of_load")?></th>-->
					   <th style="width:10%"><?=$this->lang->line("log_date")?></th>
					   <th style="width:10%"><?=$this->lang->line("log_time")?></th>
                      </tr>
                      </thead>
                  
                      <tbody>                      
                     <?php //foreach($rec as $key=>$u) {?>
						<?php //foreach($index as $i=>$ind) {   ?>
                        <!--<td><?php  //echo $u[$i];?></td>-->
                        <?php //print_r(count($rec));exit; //} ?>
                    
                         <?php $num =0;
						 	if(!empty($userLogs)) {
							 	foreach($userLogs as $key=>$v) {
								$num =1;
							$groups = $this->auth_model->getUserGroupsByUsername($v['username']);
							$groups = explode(',', $groups->groups);?>
                         	<tr style="text-align:center;" role="row">
                     			<td style="text-align:left;"><?php echo $v['username'] ?></td>
                               <td class="group_over" style="position:relative" id="<?=$v['id']?>"><?php /*foreach($groups as $group) {
									echo ucfirst($this->auth_model->getGroupNameById($group)).', ';
								}*/
								if(count($groups)>1) {
								echo "Multiple";
								echo '<div style="background:#000;display:none;position:absolute;z-index:9999;top:-10px;padding:4px 5px;text-align:center;color:#FFF;" class="over_group" id="over_group'.$v['id'].'">';
									foreach($groups as $grp) { if(!empty($grp)) echo "<p style='border-bottom:1px solid #fff;'>".ucfirst($this->auth_model->getGroupNameById($grp)).'</p>'; 
									}	
								echo '</div>';
							} elseif(!empty($groups[0])) {
								echo ucfirst($this->auth_model->getGroupNameById($groups[0]));
							} ?></td>
							<td style="text-align:left;">
							 <?php if(!empty($v['modified'])) {
								echo $this->lang->line("action_modify");
							} else {
								echo $this->lang->line("action_load");
							}?></td>
                                <td><?php if(!empty($v['modified'])) { echo date('d, M Y', $v['modified']); } else { echo date('d, M Y', $v['date_joined']);} ?></td>
                                <td><?php if(!empty($v['modified'])) { echo date('H:i:s', $v['modified']); } else { echo date('H:i:s', $v['date_joined']);} ?></td>
                            </tr>
                         <?php $sn++;?>
                            <?php 
						 }?>
    				<?php }?>
					
					<?php $num =0; 
						 	if(!empty($rec)) { 
							 	foreach($rec as $key=>$val) {?>
                         <!--	<tr>
                            	<td colspan="4">
                            	<?ucfirst($key)?>
                                <td>
                            </tr>-->
                            <?php foreach($val as $v) { 
							$num =1;
							$groups = $this->auth_model->getUserGroupsByUsername($v['user_id']);
							$groups = explode(',', $groups->groups);?>
                         	<tr style="text-align:center;" role="row">
                     			<td style="text-align:left;"><?php echo $v['user_id'] ?></td>
                                
							
                                
                               <td class="group_over" style="position:relative" id="<?=$v['id']?>"><?php /*foreach($groups as $group) {
									echo ucfirst($this->auth_model->getGroupNameById($group)).', ';
								}*/
								if(count($groups)>1) {
								echo "Multiple";
								echo '<div style="background:#000;display:none;position:absolute;z-index:9999;top:-10px;padding:4px 5px;text-align:center;color:#FFF;" class="over_group" id="over_group'.$v['id'].'">';
									foreach($groups as $grp) { if(!empty($grp)) echo "<p style='border-bottom:1px solid #fff;'>".ucfirst($this->auth_model->getGroupNameById($grp)).'</p>';}	
								echo '</div>';
							} elseif(!empty($groups[0])) {
								echo ucfirst($this->auth_model->getGroupNameById($groups[0]));
							} ?></td>
								<td style="text-align:left;">
							 <?php if($v['deleted']==1) {
									echo $this->lang->line("action_delete");
								} elseif(!empty($v['modified'])) {
									echo $this->lang->line("action_modify");
								} else {
									echo $this->lang->line("action_load");
								}?></td>
                                <td><?php if(!empty($v['modified'])) echo date('d, M Y', $v['modified']); else echo date('d, M Y', $v['created']);?></td>
                                <td><?php if(!empty($v['modified'])) echo date('H:i:s', $v['modified']); else echo date('H:i:s', $v['created']);?></td>
                            </tr>
                         <?php $sn++;}
						 }?>
    				<?php }?>
			</tbody>
			</table>
			</div>

			<div id="country2" class="tabcontent">
			<form action="log" method="post">
				<div style="float:left; width:50px; font-size:14px; margin-top:7px;"><?=$this->lang->line("statistics_from");?></div>
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
				<div style="clear:both;"></div>
			</form>
			 <table class="display" cellspacing="0" width="100%" id="example1">
                <thead>
                    <tr role="row">
                            
                 		<th style="width:10%"><?=$this->lang->line("number")?></th>
                        <th style="width:30%"><?=$this->lang->line("description")?></th>
						<th style="width:15%"><?=$this->lang->line("action")?></th>
                        <th style="width:15%"><?=$this->lang->line("user")?></th>
                        <th style="width:10%"><?=$this->lang->line("Groups")?></th>
                        <!-- <th style="width:10%"><?=$this->lang->line("date_of_load")?></th>
                       <th style="width:15%"><?=$this->lang->line("last_modified")?></th>-->
					   <th style="width:10%"><?=$this->lang->line("log_date")?></th>
					   <th style="width:10%"><?=$this->lang->line("log_time")?></th>
                      </tr>
                      </thead>
                  
                      <tbody>                      
                     <?php //foreach($rec as $key=>$u) {?>
                     
             
						<?php //foreach($index as $i=>$ind) {   ?>
                        <!--<td><?php  //echo $u[$i];?></td>-->
                        <?php //print_r(count($rec));exit; //} ?>
                    
                         <?php $num =0; 
						 	if(!empty($rec)) { 
							 	foreach($rec as $key=>$val) {?>
                         <!--	<tr>
                            	<td colspan="4">
                            	<?ucfirst($key)?>
                                <td>
                            </tr>-->
                            <?php foreach($val as $v) { 
							$num =1;
							$groups = $this->auth_model->getUserGroupsByUsername($v['user_id']);
							$groups = explode(',', $groups->groups);?>
                         	<tr style="text-align:center;" role="row">
                     			<td style="text-align:left;"><?php if(isset($v['numero_de_documento'])) echo $v['numero_de_documento']; else { echo $v['document__id']; } ?></td>
                                <td style="text-align:left;"><?php if(isset($v['descripcion'])) echo $v['descripcion']; else echo $v['description'];?></td>
								<td style="text-align:left;">
							 <?php if($v['deleted']==1) {
									echo $this->lang->line("action_delete");
								} elseif(!empty($v['modified'])) {
									echo $this->lang->line("action_modify");
								} else {
									echo $this->lang->line("action_load");
								}?></td>
                                <td><?=$v['user_id']?></td>
                               <td class="group_over" style="position:relative" id="<?=$v['id']?>"><?php /*foreach($groups as $group) {
									echo ucfirst($this->auth_model->getGroupNameById($group)).', ';
								}*/
								if(count($groups)>1) {
								echo "Multiple";
								echo '<div style="background:#000;display:none;position:absolute;z-index:9999;top:-10px;padding:4px 5px;text-align:center;color:#FFF;" class="over_group" id="over_group'.$v['id'].'">';
									foreach($groups as $grp) { if(!empty($grp)) echo "<p style='border-bottom:1px solid #fff;'>".ucfirst($this->auth_model->getGroupNameById($grp)).'</p>';}	
								echo '</div>';
							} elseif(!empty($groups[0])) {
								echo ucfirst($this->auth_model->getGroupNameById($groups[0]));
							} ?></td>
                                <td><?php if(!empty($v['modified'])) echo date('d, M Y', $v['modified']); else echo date('d, M Y', $v['created']);?></td>
                                <td><?php if(!empty($v['modified'])) echo date('H:i:s', $v['modified']); else echo date('H:i:s', $v['created']);?></td>
                            </tr>
                         <?php $sn++;}
						 }?>
    				<?php }?>
			    </tbody>
			</table>
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
      var table = $('#example').DataTable({
	    "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false,
        "jQueryUI": true,
		
		
		"order": [[ 3, "desc" ]],
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
		   var table = $('#example1').DataTable({
	    "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false,
        "jQueryUI": true,
		
		
		"order": [[ 5, "desc" ]],
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
		   $(".dataTables_info").remove();
 
 
/////for tab////
var countries=new ddtabcontent("countrytabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

  </script>
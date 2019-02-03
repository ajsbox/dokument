  <div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div style="font-size:16px; margin-top:10px;">External Tables</div>
		<div style="margin:10px 10px 10px 0px; border:1px solid; float:left;" class="span3">
		<?php 
		
		if(!empty($data)) {	
			$query = mysql_query("SHOW TABLES FROM ".$_POST['dbname']);
			//print_r($data);exit;
			while($table = mysql_fetch_assoc($query)) {
					$tbl = $table['Tables_in_'.$data["dbname"]];?>
				<div style="margin:10px; width:auto; cursor:pointer; font-weight:bold;" class="extTable" data-id="<?=$tbl?>">
					<?=$tbl?>
				</div>
				<div style="margin:5px; display:none" id="external-<?=$tbl?>">
					<?php $fields = mysql_query("SHOW COLUMNS FROM ".$tbl); 
					while($field = mysql_fetch_assoc($fields)) { ?>
						<div style="padding:3px; margin-left:35px;"><?=$field['Field']?></div>
				<?php }?>
				</div>
		<?php }
		}?>
		</div>
		<div style="float:left;" class="span6">
			<form action="makeQuery" method="post">
				<?php if(!empty($data)) {?>
					<label>Your query</label>
					<textarea name="query" style="width:430px;"></textarea>
					<input type="hidden" name="hostname" value="<?=$data["hostname"]?>">
					<input type="hidden" name="username" value="<?=$data["username"]?>">
					<input type="hidden" name="password" value="<?=$data["password"]?>">
					<input type="hidden" name="dbname" value="<?=$data["dbname"]?>">
					<input type="submit" name="submit" value="Submit" class="btn">
				<?php }?>
			</form>
			<div style="overflow:auto; margin:auto; margin-top:20px;" class="span11">
			<table cellpadding="4" border="1">
				<tr>
					<td colspan="<?=count(@$columns)?>">
						<b>Query result</b>
					</td>
				</tr>
				<?php if(!empty($columns)) { 
						echo "<tr>";
						foreach($columns as $column) {
							if($column != "id") {?>
						
							<th><?=$column?></th>
					<?php }
						}  echo "</tr>";
						}?>
				<?php if(!empty($tableValues)) {
						foreach($tableValues as $value) {?>
							<tr>
								<?php foreach($value as $key=>$val) {
								if($key != "id") {?>
								<td><?=$val?></td>
								<?php }
								}?>
							</tr>
				<?php } }?>
			</table>
		</div>
		</div>
		<div style="font-size:16px;">Import Tables</div>
		<div style="margin:10px; border:1px solid; float:left; margin-left:0px;" class="span3">
		<?php 
		
		if(!empty($ourTables)) {	
			//$query = mysql_query("SHOW TABLES FROM ".$_POST['dbname']);
			//print_r($data);exit;
			foreach($ourTables as $tbl) {?>
				<div style="margin:10px; width:auto; cursor:pointer; font-weight:bold;" class="tableName" data-id="<?=$tbl?>">
					<?=$tbl?>
				</div>
				<div style="margin:5px; display:none" id="table-<?=$tbl?>">
					<?php $fields = $this->db->field_data($tbl);
					foreach($fields as $field) {?>
						<div style="padding:3px; margin-left:35px;"><?=$field->name?></div>
				<?php }?>
				</div>
		<?php }
		}?>
		</div>
		<div style="clear:both;"></div>
	
	</div>
</div>
<br />
<br />
<br />
<br />
<br />
<script>
$(document).ready(function(){
	$(".tableName").click(function(){
		var id = $(this).data("id");
		$("#table-"+id).toggle();
	})
	$(".extTable").click(function(){
		var id = $(this).data("id");
		$("#external-"+id).toggle();
	})
})
</script>
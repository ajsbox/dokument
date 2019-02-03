<style>
.container-fluid{padding-top:35px;}
ul{padding-left:30px;}
input, textarea, .uneditable-input {
    width: 320px;
}
.file-wrapper {
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    position: relative;
}
.file-wrapper .button {
    background: #79130e;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
    font-size: 11px;
    font-weight: bold;
    padding: 4px 18px;
	color:#FFF;
    text-transform: uppercase;
}
.file-wrapper input {
    cursor: pointer;
    height: 100%;
    position: absolute;
    right: 0;
    top: 0;
}
.file-wrapper input {
    filter: alpha(opacity=50);
    -moz-opacity: 0.5;
    opacity: 0.5;
}
.file-wrapper input {
    filter: alpha(opacity=1);
    -moz-opacity: 0.01;
    opacity: 0.01;
}
</style>
<div class="row-fluid" style="background-color:white;">
	<?php $this->load->view('user/user_menu');?>
    <?php $sn = 1; $perpage = 15; $start=0;?>
	<div class="span10">
		<div id="tableMessage" style="display: none;"></div>
       <!-- <div style="font-size:16px; font-weight:bold;"><?=$this->lang->line("my_documents");?></div>-->
	   <br>
        <div style="float:right; margin-right:380px; margin-top:10px;" id="uploadFile">
        <!--
		<form  action="<?=SERVER?>user/addFiles" method="post" enctype="multipart/form-data" id="form2" name="form2">
		<label id="fileLabel1" data-up='0'><b><a href="<?=SERVER?>user/scan/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>" class="pdfView"><input type="button" value="Scan archivo" class="btn"></a></b></label>
		<?php if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Cargar')) {?>
			<label id="fileLabel" data-up='0'><b><input type="button" value="Subir archivo" class="btn"></b></label>
		<?php }?>
	
		<span style="display:none; position:absolute;" id="showUploader">
			<label>Descripción del archivo</label>
			<input type="text" name="description" id="fileDesc"><br>
			<div id="description_error" style="display:none;color:#FF0000;"><strong>Error ! </strong> <?=$this->lang->line("doc_desc_req");?></div>		 			
			<input class="btn" type="file" id="file_upload" name="upload" onclick="return false;">
			<input type="file" id="file_upload" name="upload">
			<div id="file_error" style="display:none;color:#FF0000;"><br><strong>Error ! </strong>por favor elija un archivo</div>
			<br><br>
			<input type="submit" value="Subir" class="btn" onclick="return uploadValidate();">
			<input type="hidden" name="document_id" value="<?=$this->uri->segment(4)?>" />
			<input type="hidden" name="table_name" value="<?=$this->uri->segment(3)?>" />
		</span>
        </form>-->
		<form action="<?=SERVER?>user/loadEditDocumentTypes/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>" method="post" id="form3" name="form3" enctype="multipart/form-data" style="display:none;">
			<input type="file" name="upload" id="updateFile" value="">
			<input type="hidden" name="file_id" value="" id="file_id">
			<input type="hidden" name="file_name" value="" id="file_name">
			<input type="hidden" name="file_table" value="" id="file_table">
			<input type="hidden" name="document_id" value="<?=$this->uri->segment(4)?>" id="document_id">
			<input type="submit" name="submitFile" value="Submit" id="submit1">
		</form>
		</div>
 
 <div style="margin-top:3px;">
 <form action="<?=SERVER?>user/editDocumentTypes" method="post" enctype="multipart/form-data" id="form1" name="form1">
 		<div style="margin-bottom:14px;">
			<?php if($this->uri->segment(5)=='sent') { //unset($this->uri->segment(5));?>
				<div class="alert alert-success"><?=$this->lang->line("send_docs_to_users");?></div>
			<?php }?>
			<?php if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
				<input type="submit" value="<?=$this->lang->line("document_save")?>" name="submit" onclick="return validateEditDoc()" class="btn">
			<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
			<a class="fileview" href="<?=SERVER?>user/sendDocuments/<?=$docs['id']?>/<?=$this->uri->segment(3)?>">
			<!--<input type="button" value="<?=$this->lang->line("document_send")?>" name="send" onclick="retrun userValidate()" class="btn">-->
			</a>
			<!--<a href="<?=SERVER?>user/sendDocumentsToExternal/<?=$docs['id']?>/<?=$this->uri->segment(3)?>">-->
			<input type="button" value="<?=$this->lang->line("external_document_send")?>" name="sendExternal" onclick="retrun userValidate()" class="btn" id="sendExternal">
			<!--</a>-->
			<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Borrar')) {?>
				<input type="submit" value="<?=$this->lang->line("document_delete")?>" name="delete" class="btn" id="delDoc" onclick=" if(!confirm('<?=$this->lang->line("delete_document_lang")?>')) return false;">
			<?php }?>
			<br><br>
			<?php $docTypes = $this->user_model->getUserDocumentById($docs['document_id']);
			echo '<b>'.$this->lang->line("md1").' : </b>'.$docTypes['name'].'';?>
		</div>
		<!-- <input type="submit" value="Cancel" name="cancel" class="btn">-->
		<div style="width:100%;height:auto; height:70px; overflow:auto;">
		<div style="margin-right:60px; float:left; max-width:300px;overflow: hidden; width:300px; display:none;">
		<?php //$oldGroups = $docs['groups'];
				//$oldGroups = explode(",", $oldGroups);
				//print_R($oldGroups);exit;?>
				<h6>Groups</h6>
		<select name="groups" id="groups">
			<?php
				$groups = $docs['groups'];
				//$groups = explode(",", $docs['groups']);
				//$oldGroups = $docs['groups'];
				//$oldGroups = $oldGroups;
				//foreach($groups as $key=>$option) {
					//$options[$option] = $this->user_model->getGroupNameById($option)->name;
				//	if(in_array($option, $oldGroups)) {
					//	echo "<option value='".$option."' selected>".$this->user_model->getGroupNameById($option)->name."</option>";
				//	} else {
						echo "<option value='".$groups."'>".$this->user_model->getGroupNameById($groups)->name."</option>";
				//	}
				//}
			?>
		</select><br>
<div id="valid_group" style="display:none;color:#FF0000;"><strong>Error ! </strong> * groep is een verplicht veld selecteert u !</div>	
		</div>
		
          <?php //$docTypes = $this->user_model->getUserDocumentById($docs['document_id']);
				$frmData = str_replace("\\", "", $docTypes['elements']);
				$frmData = json_decode($frmData);
				$br=0;
				$docFileId = 0;
				
				foreach($frmData->elements as $key=>$doc) {
					$title = strtolower(str_replace(" ", "_", $doc->title));
		
					//if($key!='id' and $key!='user_id' and $key!='created' and $key!='modified') {?>
					<?php
						//$string_parts = explode('.', $doc);
						//$ext = $string_parts[count($string_parts) - 1];
						//$ext = strtolower($ext);
						?>
                    	<div style="margin-top:12px; float:left; font-weight:bold; width:0%;">&nbsp;&nbsp;&nbsp;</div>
                        <?php //if(in_array('.'.$ext, $extensions)) {?>
							<!--<div style="margin:10px; float:left; width:35%;">
                            <img src="<?SERVER.'document_files/'.$this->uri->segment(3).'/'.$doc?>">
                            <input type="file" name="<?=$key?>">
                           
                       		</div>-->
				<?php //} else {?>
						
						<div style="margin-right:60px; float:left; max-width:500px;overflow: hidden; width:450px;">
						<?php if($doc->type!='file') {?>
						<h6><?=str_replace('__', ' ',$doc->title)?></h6>
						
						<?php } if($doc->type=='select') {?>
						
						<select name="<?=$title?>">
							<option value="">- Select -</option>
							<?php
							foreach($doc->options as $option) {?>
								<option value="<?=$option->option?>" <?php if($option->option==$docs[$title]) echo "selected";?> ><?=$option->option?></option>
						<?php }?>
						</select>
						<?php } elseif($doc->type=='textarea') {?>
							<textarea name="<?=$title?>"><?=$docs[$title]?></textarea>
						<?php } else {
									if($doc->type=='file') {?>
										<!--<input type="hidden" name="files[]" value="<?=$docs[$title]?>">-->
										<span class="file-wrapper">
								<?php }?>
								<?php if($title=='numero_de_documento' or $title=='document__id' or $title=='descripcion' or $title=='description') {?>
									<input type="<?=$doc->type?>" name="<?=$title?>" value="<?=$docs[$title]?>" id="<?=$title?>">
								<?php } else {?>
									<input type="<?=$doc->type?>" name="<?=$title?>" value="<?=$docs[$title]?>" id="<?=$title?>">
								<?php }?>
							<?php if($doc->type=='file') {?>
									<!-- <span class="button"><?=$this->lang->line("choose_file")?></span>-->
									</span>
						<?php } }?>
						</div>
						
                        <?php //}?>
                        <?php if($br%2==1)  {?>
                        	<div style="clear:both;"></div>
						
						<?php } ?>
						<?php if($title=='numero_de_documento' or $title=='document__id') { $docFileId = $docs[$title];?>
							<div id="valid_id" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("document_id_required")?></div>	
						<?php }?>
						<?php if($title=='descripcion' or $title=='description') {?>
							<div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong> <?=$this->lang->line("doc_desc_req");?></div>	 			
                     
						<?php  } ?>
				<?php $br++;//} elseif($key=='id') { $docId =$doc;?>
						<input type="hidden" name="id" value="<?=$docs['id']?>" id="document_id">
						<input type="hidden" name="table" value="<?=$this->uri->segment(3)?>" id="table">
				<?php //}
				}?>
                </div>
                <div style="clear:both;"></div><br>
                </form><hr>
			<form action="<?=$this->logik->setting("default_url")?>user/loadEditDocumentTypes/<?=$this->uri->segment(3)?>/<?=$docs['id']?>" method="post" id="sentEx" name="sentEx">
			<div style="display:none;" class="sentDocBox">
				<?php $this->load->view('user/send_external_docs');?>
			</div>
		<?php //if(!empty($docFiles)) {?>
			<div><h5><?php echo $this->lang->line("uploaded_files_main")?></h5></div>
              <div style="margin-bottom:25px; margin-right:2px;">
               <table class="display" cellspacing="0" width="100%" id="tabs1" style="border:1px solid #CCC;">
				  <thead style="border-bottom:1px solid;">
						<input type="hidden" name="search" id="search" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-bottom:0;" />
					  <tr style="background-color:#E6E6E6;height:35px;">
						<th style="width:5%">&nbsp;</th>
						<th style="width:50%"><?=$this->lang->line("description")?></th>
						<th style="width:15%"><?=$this->lang->line("user_name")?></th>
						<th style="width:15%"><?=$this->lang->line("created_date")?></th>
						<th style="width:10%"><?=$this->lang->line("action")?></th>
                      </tr>
                    </thead>     
                      <tbody class="tb" style="border-bottom:1px solid;">
					  </tbody>
				</table>
				<!--<br>-->
				<div class="row clear-fix"  style="float:right; margin-right:0px;">
					<div class="col-md-4 pull-right">
						<!--<input type="button" id="previous" class="btn btn-sm btn-primary" value="< ?=$this->lang->line("datatable_previous")?>">-->
						<!--<lable>Page <lable id="page_number"></lable> of <lable id="total_page"></lable></lable>-->
						<!--<input type="button" id="next" class="btn btn-sm btn-primary" value="< ?=$this->lang->line("datatable_next")?>">-->
					</div>
				</div>
              </div>
			  <?php //}?>
              <div><h5><?php echo $this->lang->line("uploaded_files")?></h5></div>
              <div style="margin-bottom:25px; margin-right:0px;"> 
              
              
               <table class="display" cellspacing="0" width="100%" style="border:1px solid #CCC;">
                      <thead style="border-bottom:1px solid;">
						<tr style="background-color:#F5F5F5;"><td>
						
						<?php if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
						
						<span><a href='<?=SERVER?>user/scan/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(3)?>' class='scanView' style='margin:0px 0px 0px 0px;'><img src='<?=SERVER?>assets/img/scanner.png'  style='margin:0px 0px 0px 0px; padding:0px;' title='<?=$this->lang->line("scan_title")?>' width='25px'></a></span><span><a href='<?=SERVER?>user/upload/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>' class='fileview' style='margin:0px 0px 0px 0px !important; padding:0px;'><img src='<?=SERVER?>assets/img/attach.png' style='cursor:pointer;margin:1px 1px 1px 1px; padding:0px;' title='<?=$this->lang->line("upload_title")?>' width='25px'></a></span>
						<?php }?>
						
						</td><td colspan="4" style="text-align:right;"><input type="text" name="search" id="search1" placeholder="<?=$this->lang->line("datatable_search")?>" class="pull-right" style="margin-bottom:0;" /></td></tr>
						<tr style="background-color:#E6E6E6;height:35px;">
						<th style="width:5%">&nbsp;</th>
						<th style="width:50%"><?=$this->lang->line("description")?></th>
						<th style="width:15%"><?=$this->lang->line("user_name")?></th>
						<th style="width:15%"><?=$this->lang->line("created_date")?></th>
						<th style="width:10%"><?=$this->lang->line("action")?></th>
                      </tr>
                    </thead>        
                      
                     <tbody class="tb1" style="border-bottom:1px solid;">
					 </tbody>
			  </table>
              	<br>
				<div class="row clear-fix"  style="float:right; margin-right:0px;">
					<div class="col-md-4 pull-right">
						<input type="button" id="previous1" class="btn btn-sm btn-primary" value="<?=$this->lang->line("datatable_previous")?>">
						<lable>P&aacute;gina <lable id="page_number1"></lable> de <lable id="total_page1"></lable></lable>
						<input type="button" id="next1" class="btn btn-sm btn-primary" value="<?=$this->lang->line("datatable_next")?>">
					</div>
				</div>
              </div>
			  </form>
            
         
 <input type="hidden" value="<?=count($docFiles)+count($files)?>" id="totalDocFiles">
<br />
<br />
<br />
<br /><br />

<br />
  </div>
  </div>  
  </div>

 <?php
 $file_url=$this->logik->setting("default_url")."assets/app/file_upload/";
 $timestamp = time();
 ?>
<script type="text/javascript">

/////sent document to external users////
$('#selAll').click(function(){
	var checked = $(this).attr('checked');
	if(checked) {
		var aSelect = document.sentEx.users;
		var aSelectLen = aSelect.length;
		for(i = 0; i < aSelectLen; i++) {
			aSelect.options[i].selected = true;
		}
	} else {
		var aSelect = document.sentEx.users;
		var aSelectLen = aSelect.length;
		for(i = 0; i < aSelectLen; i++) {
			aSelect.options[i].selected = false;
		}
	}
})
function verifyToSentExDoc() {
	var users = $("#users").attr("value");
	var files = $(".checkBox").attr("checked");
	if(!users) {
		alert("<?=$this->lang->line("send_docs_to_users");?>");
		return false;
	} else if(!files) {
		alert("<?=$this->lang->line("select_file_to_send");?>");
		return false;
	} else {
		return true;
	}
}

///end external users send docs///

function uploadValidate() {
	var desc=document.getElementById("fileDesc").value;
	
	if(desc=="")
	{
		hideAllErrorssigne();
		document.getElementById("description_error").style.display = "inline";
		document.getElementById("fileDesc").focus();
		return false;
	}
	var fname=document.getElementById("file_upload").value;
	if(fname=="")
	{
		hideAllErrorssigne();
		document.getElementById("file_error").style.display = "inline";
		//document.getElementById("file_upload").focus();
		return false;
	}
}
  
function validateEditDoc()
{	
	var group=document.getElementById("groups").value;
	if(group=="")
	{
		hideAllErrorssigne();
		document.getElementById("valid_group").style.display = "inline";
		document.getElementById("groups").focus();
		return false;
	} 
	var desc=document.getElementById("numero_de_documento").value;
	if(desc=="")
	{
		hideAllErrorssigne();
		document.getElementById("valid_id").style.display = "inline";
		document.getElementById("numero_de_documento").focus();
		return false;
	}  
	var desc=document.getElementById("descripcion").value;
	if(desc=="")
	{
		hideAllErrorssigne();
		document.getElementById("valid_desc").style.display = "inline";
		document.getElementById("descripcion").focus();
		return false;
	}  
}

function hideAllErrorssigne()
{
	document.getElementById("valid_desc").style.display = "none";
	document.getElementById("valid_id").style.display = "none";
	document.getElementById("valid_group").style.display = "none";
	document.getElementById("description_error").style.display = "none";
	document.getElementById("file_error").style.display = "none";
				
}
</script>
	
<link href="<?=$this->logik->setting("default_url")?>assets/app/style/bootstrap.css"></link>
<link rel="stylesheet" type="text/css" href="<?=SERVER?>assets/app/jquery.fancybox/fancybox/jquery.fancybox-1.3.2.css" media="screen" />
<link rel="stylesheet" href="<?=SERVER?>assets/app/jquery.fancybox/style.css" />
	<script type="text/javascript">
		$(document).ready(function() {
			$(".pdfView").fancybox({
				'width'				: '90%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: '40',
				'transitionOut'		: '30',
				'type'				: 'iframe'
			});
			$(".fileview").fancybox({
				'width'				: '30%',
				'height'			: '42%',
				'autoScale'			: false,
				'transitionIn'		: '40',
				'transitionOut'		: '30',
				'type'				: 'iframe'
				
		     })
			 $(".scanView").fancybox({
				'width'				: '90%',
				'height'			: '105%',
				'autoScale'			: false,
				'transitionIn'		: '40',
				'transitionOut'		: '30',
				'type'				: 'iframe'
				
		     })
			 $(".fileview1").fancybox({
				'width'				: '30%',
				'height'			: '42%',
				'autoScale'			: false,
				'transitionIn'		: '40',
				'transitionOut'		: '30',
				'type'				: 'iframe'
				
		     })
			 //upload files 
			$('#fileLabel').click(function(){
				if($(this).data('up')) {
					$('#showUploader').css('display', 'none');
					$(this).data('up', 0);
				} else {
					$('#showUploader').fadeIn();
					$(this).data('up',1);
				}
			})
			
			
	//////file attachment updating////////////////////////////
	
	$(".attachImg").live('click', function() {
		var id = $(this).data('id');
		var file = $(this).data('file');
		var table = $(this).data('table');
		$("#file_table").attr('value', table);
		$("#file_id").attr('value', id);
		$("#file_name").attr('value', file);
		$("#updateFile").trigger("click");
	})
	$("#updateFile").live('change', function() {
		
		$("#submit1").trigger("click");
		//$('#form3').submit();
	})
	});
	//$(".container-fluid").css('padding-top','100px !important');
	
	
	$( "#fancybox-close" ).live("click", function() {
		page_number = 0;
		getReport(page_number);
		getReport1(page_number);
	})
	
	$("#sendExternal").click(function(){
		//alert("ddd");
		//$(".sentDocBox").css({"display":"inline"});
		$(".sentDocBox").toggle("slow");
	});
	
	$('#selAll').click(function(){
	var checked = $(this).attr('checked');
	if(checked) {
		var aSelect = document.form1.users;
		var aSelectLen = aSelect.length;
		for(i = 0; i < aSelectLen; i++) {
			aSelect.options[i].selected = true;
		}
	} else {
		var aSelect = document.form1.users;
		var aSelectLen = aSelect.length;
		for(i = 0; i < aSelectLen; i++) {
			aSelect.options[i].selected = false;
		}
	}
})

$("#sentBtn").click(function()
{ 

$.post("<?=$this->logik->setting("default_url")?>user/editDocumentTypes", $("#form1").serialize(), function(msg)
{

    if(msg.type==1)
	{
	   $('#tableMessage').html("<h3><?=$this->lang->line("send_success")?></h3>");
	}
},"json");
return false;
})




//////upload button design changed////////
   
    VIGET.fileInputs = function() {
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
			$("#previous").attr('disabled', true);
		} else {
			$("#previous").attr('disabled', false);
		}

		if(page_number==0) {
			$("#next").attr('disabled', true);
		} else {
			$("#next").attr('disabled', false);
		}

		 $("#page_number").text(page_number+1);
			 $.ajax({
				 url:"<?php echo $this->logik->setting('default_url'); ?>user/viewDocFilesByAjax",
				 type:"POST",
				 dataType: 'json',
				 data:'page_number='+page_number+'&table_name='+"<?=$this->uri->segment(3)?>"+'&doc_id='+"<?=$this->uri->segment(4)?>",
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
						$("#next").attr('disabled', true);
					} else {
						$("#next").attr('disabled', false);
					}
					$(".tb").html("");
					if(data!=null) { 
						 var record_par_page = mydata[0]['Rows'];
						
						var colr = 0;
						  $.each(record_par_page, function (key, data) {
								//$.each(rec, function (key1, data) {
									if(colr%2==0) {
										color = 'background-color:#F2F4F3;';
									} else {
										color = '';
									}
									var action = '';
									<?php
									if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<span style="cursor:pointer;float:left;"><a href="<?=SERVER?>user/scan/'+data.id+'" class="scanView"><img src="<?=SERVER?>assets/img/scanner.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("scan_title")?>" width="25px"></a></span>';
										action += '<span style="cursor:pointer;float:center;"><a href="<?=SERVER?>user/editScan/'+data.id+'/'+data.table_name+'/'+data.file_name+'/'+data.description+'/1" class="scanView"><img src="<?=SERVER?>assets/img/edit.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("edit_title")?>" width="15px">&nbsp;&nbsp;</a></span>';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<img src="<?=SERVER?>assets/img/attach.png" style="cursor:pointer; float:left;" width="25px" title="<?=$this->lang->line("upload_title")?>" class="attachImg" data-id="'+data.id+'" data-file="'+data.file_name+'" data-table="'+data.table_name+'">';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Borrar')) {?>
										action += '<span class="btn btn-mini btn-danger delete_doc" style="float:center;" data-did="'+data.id+'" title="<?=$this->lang->line("delete_title")?>"><i class="icon-remove"></i> </span>';
									<?php }?>
									
									$(".tb").append('<tr id="doc'+data.id+'" style="border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:center;"><input type="checkbox" name="sentFile[]" value="/assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="checkBox"></td><td style="text-align:left;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.description+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.user+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.created+'</a></td><td style="text-align:center;">'+action+'</td></tr>');
									colr++;
								//});
						   });
					   } else {
							$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
						}
					   $(".pdfView").fancybox({
							'width'				: '90%',
							'height'			: '100%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
						});
						$(".fileview").fancybox({
							'width'				: '30%',
							'height'			: '42%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
							
						 })
						 $(".scanView").fancybox({
							'width'				: '90%',
							'height'			: '105%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
							
						 })
						 $(".fileview1").fancybox({
							'width'				: '30%',
							'height'			: '42%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
						 })
						$('.delete_doc').click(function(){
							var doc_id = $(this).data('did');
							//alert(doc_id);
							con = confirm('<?=$this->lang->line("delete_confirmation")?>');
							if(con) {
								$.ajax({
									url:server_path+'user/deleteFile',
									type:'POST',
									data:'file_id='+doc_id,
									success:function(res) {
										if(res) {
											$('#doc'+res).hide('slow');
											$("#totalDocFiles").attr("value", parseInt($("#totalDocFiles").val())-1);
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
						$("#previous").attr('disabled', true);}
						else{
							$("#previous").attr('disabled', false);}

					if(page_number==(total_page-1)){
						$("#next").attr('disabled', true);}
						else{
							$("#next").attr('disabled', false);}

					 $("#page_number").text(page_number+1);

					if(str!='') {
						   $.ajax({
							url:"<?php echo $this->logik->setting('default_url'); ?>user/viewDocFilesByAjax",
							 type:"POST",         
							 dataType: 'json',                                    
							 data:'search='+str+'&page_number='+page_number+'&table_name='+"<?=$this->uri->segment(3)?>"+'&doc_id='+"<?=$this->uri->segment(4)?>",
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
									$("#next").attr('disabled', true);
								} else {
									$("#next").attr('disabled', false);
								}
								$(".tb").html('');
								if(data!=null) { 
								colr = 0;
								var record_par_page = mydata[0]['Rows'];
								 $.each(record_par_page, function (key, data) {
								//$.each(rec, function (key1, data) {
									if(colr%2==0) {
										color = 'background-color:#F2F4F3;';
									} else {
										color = '';
									}
									var action = '';
									<?php
									if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										action += '<span style="cursor:pointer;float:left;"><a href="<?=SERVER?>user/editScan/'+data.id+'/'+data.table_name+'/'+data.file_name+'/'+data.description+'/1" class="scanView"><img src="<?=SERVER?>assets/img/edit.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("edit_title")?>" width="15px">&nbsp;&nbsp;</a></span>';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<img src="<?=SERVER?>assets/img/attach.png" style="cursor:pointer; float:left;" width="25px" title="<?=$this->lang->line("upload_title")?>" class="attachImg" data-id="'+data.id+'" data-file="'+data.file_name+'" data-table="'+data.table_name+'">';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Borrar')) {?>
										action += '<span class="btn btn-mini btn-danger delete_doc" style="float:left;" data-did="'+data.id+'" title="<?=$this->lang->line("delete_title")?>"><i class="icon-remove"></i> </span>';
									<?php }?>
									
									$(".tb").append('<tr id="doc'+data.id+'" style="border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:center;"><input type="checkbox" name="sentFile[]" value="/assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="checkBox"></td><td style="text-align:left;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.description+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.user+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.created+'</a></td><td style="text-align:center;">'+action+'</td></tr>');
									colr++;
								//});
						   });
									
								} else {
									$(".tb").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
								}
								
								$(".pdfView").fancybox({
									'width'				: '90%',
									'height'			: '100%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
								});
								$(".fileview").fancybox({
									'width'				: '30%',
									'height'			: '42%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
									
								 })
								 $(".scanView").fancybox({
									'width'				: '90%',
									'height'			: '105%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
									
								 })
								 $(".fileview1").fancybox({
									'width'				: '30%',
									'height'			: '42%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
								 })
								 $('.delete_doc').click(function(){
									var doc_id = $(this).data('did');
									//alert(doc_id);
									con = confirm('<?=$this->lang->line("delete_confirmation")?>');
									if(con) {
										$.ajax({
											url:server_path+'user/deleteFile',
											type:'POST',
											data:'file_id='+doc_id,
											success:function(res) {
												if(res) {
													$('#doc'+res).hide('slow');
													$("#totalDocFiles").attr("value", parseInt($("#totalDocFiles").val())-1);
												}
											}
										})
									}
								})
							 }
						});
					}
				};

   $(document).ready(function(e){
	  getReport(page_number);
	 // console.log(sr);
	   
	 $("#next").click(function(){
		 //  $(".tb").html("");
		   page_number = (page_number+1);
		   getReport(page_number);
		 //  console.log(sr);
		   
	 });
		
	 $("#previous").click(function(){
		//  $(".tb").html("");
		  page_number = (page_number-1);
		  getReport(page_number);
	 });
	 
	 
	 $("#search").keyup(function(){
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
	var page_number=0;
	 var total_page =null;
	 var sr =0;
	 var sr_no =0;

	var getReport1 = function(page_number){
		if($("#search1").attr("value")!='') {
			search1($("#search1").attr("value"));
			return false;
		}
		if(page_number==0) {
			$("#previous1").attr('disabled', true);
		} else {
			$("#previous1").attr('disabled', false);
		}

		if(page_number==0) {
			$("#next1").attr('disabled', true);
		} else {
			$("#next1").attr('disabled', false);
		}

		 $("#page_number1").text(page_number+1);
			 $.ajax({
				 url:"<?php echo $this->logik->setting('default_url'); ?>user/viewDocFilesByAjax1",
				 type:"POST",
				 dataType: 'json',
				 data:'page_number='+page_number+'&table_name='+"<?=$this->uri->segment(3)?>"+'&doc_id='+"<?=$this->uri->segment(4)?>",
				 success:function(data){
					 window.mydata = data;
					// console.log(mydata[0]['Rows']);
					 if(data!=null) {
						total_page= mydata[0].TotalRows;
					 } else {
						total_page = 0;
						$("#page_number1").text(0);
					 }
					 $("#total_page1").text(total_page);
		
					if(page_number>=(total_page-1)) {
						$("#next1").attr('disabled', true);
					} else {
						$("#next1").attr('disabled', false);
					}
					$(".tb1").html("");
					if(data!=null) { 
						 var record_par_page = mydata[0]['Rows'];
						
						var colr = 0;
						  $.each(record_par_page, function (key, data) {
								//$.each(rec, function (key1, data) {
									if(colr%2==0) {
										color = 'background-color:#F2F4F3;';
									} else {
										color = '';
									}
									var action = '';
									<?php
									if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<span style="cursor:pointer;float:left;"><a href="<?=SERVER?>user/scan/'+data.id+'" class="scanView"><img src="<?=SERVER?>assets/img/scanner.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("scan_title")?>" width="25px"></a></span>';
										action += '<span style="cursor:pointer;float:center;"><a href="<?=SERVER?>user/editScan/'+data.id+'/'+data.table_name+'/'+data.file_name+'/'+data.description+'" class="scanView"><img src="<?=SERVER?>assets/img/edit.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("edit_title")?>" width="15px">&nbsp;&nbsp;</a></span>';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<img src="<?=SERVER?>assets/img/attach.png" style="cursor:pointer; float:left;" width="25px" title="<?=$this->lang->line("upload_title")?>" class="attachImg" data-id="'+data.id+'" data-file="'+data.file_name+'" data-table="'+data.table_name+'">';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Borrar')) {?>
										action += '<span class="btn btn-mini btn-danger delete_doc" style="float:center;" data-did="'+data.id+'" title="<?=$this->lang->line("delete_title")?>"><i class="icon-remove"></i> </span>';
									<?php }?>
									
									$(".tb1").append('<tr id="doc'+data.id+'" style="border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:center;"><input type="checkbox" name="sentFile[]" value="/assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="checkBox"></td><td style="text-align:left;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.description+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.user+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.created+'</a></td><td style="text-align:center;">'+action+'</td></tr>');
									colr++;
								//});
						   });
					   } else {
							$(".tb1").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
						}
					   $(".pdfView").fancybox({
							'width'				: '90%',
							'height'			: '100%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
						});
						$(".fileview").fancybox({
							'width'				: '30%',
							'height'			: '42%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
							
						 })
						 $(".scanView").fancybox({
							'width'				: '90%',
							'height'			: '105%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
							
						 })
						 $(".fileview1").fancybox({
							'width'				: '30%',
							'height'			: '42%',
							'autoScale'			: false,
							'transitionIn'		: '40',
							'transitionOut'		: '30',
							'type'				: 'iframe'
						 })
						 $('.delete_doc').click(function(){
							var doc_id = $(this).data('did');
							//alert(doc_id);
							con = confirm('<?=$this->lang->line("delete_confirmation")?>');
							if(con) {
								$.ajax({
									url:server_path+'user/deleteFile',
									type:'POST',
									data:'file_id='+doc_id,
									success:function(res) {
										if(res) {
											$('#doc'+res).hide('slow');
											$("#totalDocFiles").attr("value", parseInt($("#totalDocFiles").val())-1);
										}
									}
								})
							}
						})
				  }
			 });
		   };
		   
				var search1 = function (str) {
					if(page_number==0){
						$("#previous1").attr('disabled', true);}
						else{
							$("#previous1").attr('disabled', false);}

					if(page_number==(total_page-1)){
						$("#next1").attr('disabled', true);}
						else{
							$("#next1").attr('disabled', false);}

					 $("#page_number1").text(page_number+1);

					if(str!='') {
						   $.ajax({
							url:"<?php echo $this->logik->setting('default_url'); ?>user/viewDocFilesByAjax1",
							 type:"POST",         
							 dataType: 'json',                                    
							 data:'search='+str+'&page_number='+page_number+'&table_name='+"<?=$this->uri->segment(3)?>"+'&doc_id='+"<?=$this->uri->segment(4)?>",
							 success:function(data){
								window.mydata = data;
								if(data!=null) {
								total_page= mydata[0].TotalRows;
								} else {
									total_page = 0;
									$("#page_number1").text(0);
								}
								$("#total_page1").text(total_page);
								if(page_number>=(total_page-1)) {
									$("#next1").attr('disabled', true);
								} else {
									$("#next1").attr('disabled', false);
								}
								$(".tb1").html('');
								if(data!=null) { 
								colr = 0;
								var record_par_page = mydata[0]['Rows'];
								 $.each(record_par_page, function (key, data) {
								//$.each(rec, function (key1, data) {
									if(colr%2==0) {
										color = 'background-color:#F2F4F3;';
									} else {
										color = '';
									}
									var action = '';
									<?php
									if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<span style="cursor:pointer;float:left;"><a href="<?=SERVER?>user/scan/'+data.id+'" class="scanView"><img src="<?=SERVER?>assets/img/scanner.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("scan_title")?>" width="25px"></a></span>';
										action += '<span style="cursor:pointer;float:left;"><a href="<?=SERVER?>user/editScan/'+data.id+'/'+data.table_name+'/'+data.file_name+'/'+data.description+'" class="scanView"><img src="<?=SERVER?>assets/img/edit.png" style="margin:0px 0px 0px 0px; padding:0px;" title="<?=$this->lang->line("edit_title")?>" width="15px">&nbsp;&nbsp;</a></span>';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Modificar')) {?>
										//action += '<img src="<?=SERVER?>assets/img/attach.png" style="cursor:pointer; float:left;" width="25px" title="<?=$this->lang->line("upload_title")?>" class="attachImg" data-id="'+data.id+'" data-file="'+data.file_name+'" data-table="'+data.table_name+'">';
									<?php } if($this->user_model->checkValidRolesWithGroup($docs['groups'], 'Borrar')) {?>
										action += '<span class="btn btn-mini btn-danger delete_doc" style="float:left;" data-did="'+data.id+'" title="<?=$this->lang->line("delete_title")?>"><i class="icon-remove"></i> </span>';
									<?php }?>
									
									$(".tb1").append('<tr id="doc'+data.id+'" style="border-bottom:1px solid #CCC; height:30px; '+color+'"><td style="text-align:center;"><input type="checkbox" name="sentFile[]" value="/assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="checkBox"></td><td style="text-align:left;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.description+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.user+'</a></td><td style="text-align:center;"><a href="<?=SERVER?>assets/app/file_upload/uploads/'+data.table_name+'/'+data.file_name+'" class="pdfView">'+data.created+'</a></td><td style="text-align:center;">'+action+'</td></tr>');
									colr++;
								//});
						   });
									
								} else {
									$(".tb1").append('<tr style="text-align:center;border-bottom:1px solid #CCC;"><td colspan="7"><?=$this->lang->line("datatable_no_record")?></td></tr>');
								}
								
								$(".pdfView").fancybox({
									'width'				: '90%',
									'height'			: '100%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
								});
								$(".fileview").fancybox({
									'width'				: '30%',
									'height'			: '42%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
									
								 })
								 $(".scanView").fancybox({
									'width'				: '90%',
									'height'			: '105%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
									
								 })
								 $(".fileview1").fancybox({
									'width'				: '30%',
									'height'			: '42%',
									'autoScale'			: false,
									'transitionIn'		: '40',
									'transitionOut'		: '30',
									'type'				: 'iframe'
								 })
								 $('.delete_doc').click(function(){
									var doc_id = $(this).data('did');
									//alert(doc_id);
									con = confirm('<?=$this->lang->line("delete_confirmation")?>');
									if(con) {
										$.ajax({
											url:server_path+'user/deleteFile',
											type:'POST',
											data:'file_id='+doc_id,
											success:function(res) {
												if(res) {
													$('#doc'+res).hide('slow');
													$("#totalDocFiles").attr("value", parseInt($("#totalDocFiles").val())-1);
												}
											}
										})
									}
								})
							 }
						});
					}
				};

   $(document).ready(function(e){
	  getReport1(page_number);
	 // console.log(sr);
	   
	 $("#next1").click(function(){
		 //  $(".tb").html("");
		   page_number = (page_number+1);
		   getReport1(page_number);
		 //  console.log(sr);
		   
	 });
		
	 $("#previous1").click(function(){
		//  $(".tb").html("");
		  page_number = (page_number-1);
		  getReport1(page_number);
	 });
	 
	 
	 $("#search1").keyup(function(){
		 var str = $.trim($(this).val());
		if(str) { 
			search1(str);
		} else {
			getReport1(page_number);
		}
	 });
});
</script>
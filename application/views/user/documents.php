<!--<link rel="stylesheet" type="text/css" href="<?=SERVER?>assets/app/jquery.fancybox/fancybox/jquery.fancybox-1.3.2.css" media="screen" />
<link rel="stylesheet" href="<?=SERVER?>assets/app/jquery.fancybox/style.css" />-->
<style>
.row{margin-left:-30px;padding-top:10px;}
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
  <div class="row-fluid">
	<?php $this->load->view('user/user_menu');
	$this->load->view('jqueryform/Zebra_Form');?>
	<div class="span9">
	<div id="tableMessage" style="display:none;"></div>
	<!--	<h4><?$this->lang->line("Documents")?><small> for <?php //echo $this->auth_model->get_user()->username; ?></small></h4>-->
		 <?php if(!empty($update) and $update==1) { ?>
			<div class="alert alert-success user_update" style="margin-top:8px;"><?=$this->lang->line("success_message")?> </div><?php } else if($update==2) { ?>
			<div class="alert alert-error user_update" style="margin-top:8px;"><?=$this->lang->line("document_upload_file")?> </div>
			<?php }?>
	 <h5 id="header_top" style="margin-top:17px;"><?php //if(!empty($docs[0]['form_data'])) {
							//$frm = str_replace("\\", "", $docs[0]['form_data']);
							//$frm = json_decode($frm);
							//echo ucwords($frm->name);//open if want to default doc
						//}?></h5><br />
	
                  <div style="margin-left:0px; margin-top:-21px;" >
                   <?=$this->lang->line("select_document")?><br><br>
                         <select name="documents" id="sel_document">
							<option value=""><?=$this->lang->line("document_select")?></option>
                         	<?php $defoult = 0;
								if(!empty($docs)) {
									foreach($docs as $key=>$doc) { 
										if($key == 0) $defoult = $doc['elements'];?>
                         	<option value="<?=$doc['id']?>"><?=$doc['name'];?></option>
									<?php }
								  } else {?>
                                  <option value=""><?=$this->lang->line("document_no_data")?></option>
                            <?php }?>
                        </select>
                     </div>
                    <?php if(!empty($docs)) {?>
				
                    <div style="margin-left:0px; float:left;" id="frm_update">
                    <div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong><?=$this->lang->line("dynamic_description_field")?></div>
				
           <!-- <form action="" method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return validate();">-->
                   <?php 
				   		/*if($defoult) {
							$form = new Zebra_Form('form', 'post', '', array('autocomplete' => 'off'));
							$defoult = str_replace("\\", "", $defoult); 
							$defoult = json_decode($defoult); //print_r($defoult->elements);exit;
							
							foreach($defoult->elements as $def) {
								$title = strtolower(str_replace(" ", "_", $def->title));
								$form->add('label', 'label_email'.$title, 'email'.$title, $def->title);
								$obj = $form->add($def->type, $title);
								 // $form->add('hidden', 'table', $def->name);
								//$obj = $form->add('text', $title);
								///*$obj->set_rule(array(
									//'required'  =>  array('error', ' is required!'),
									
								//));
								 $obj->set_rule(array(
									'required'  =>  array('error', 'A Microsoft Word document is required!'),
									'upload'    =>  array('tmp', ZEBRA_FORM_UPLOAD_RANDOM_NAMES, 'error', 'Could not upload file!<br>Check that the "tmp" folder exists inside the "examples" folder and that it is writable'),
									'filetype'  =>  array('doc, docx', 'error', 'File must be a Microsoft Word document!'),
									'filesize'  =>  array(102400, 'error', 'File size must not exceed 100Kb!'),
							
								));
							}
						}
						if(isset($docs[0]['table_name'])) {
							$form->add('hidden', 'table', $docs[0]['table_name']);
						}
						if(!empty($docs[0]['id'])) {
							$form->add('hidden', 'doc_id', $docs[0]['id']);
						}
						$form->add('submit', 'btnsubmit', 'Guardar');
						if ($form->validate()) {
							show_results();
						} else {
							$form->render();
						}*/
				   ?>
               <!--	</form>-->
               </div>
			   <div style='float:left; display:none; margin-left:0px; margin-top:-55px;' id="showUploader">
			   <!--<span style='float:left; margin:0px;'><a href='' class='scanView' style='margin:0px 0px 0px 0px;'><img src='<?=$this->logik->setting("default_url")?>assets/img/scanner.png' width="40px" style='margin:0px 0px 0px 0px; padding:0px;' title='Scan bestand'></a></span>-->
			  <!--<span style='float:left; margin:0px;'><img src='<?=$this->logik->setting("default_url")?>assets/img/attach.png' width="35px" style='cursor:pointer;margin:0px 0px 0px 0px; padding:0px;' title='<?=$this->lang->line("upload_title")?>' id='attachImg'></span>-->
				<span style="float:left;">
			 <iframe src="<?=$this->logik->setting("default_url")?>assets/app/file_upload/uploads/create_scaner/online_demo_scan.php?doc_id=5&url=<?=$this->logik->setting("default_url")?>" width="295%" style="height:950px !important;" frameborder="0" scrolling="NO"></iframe>
			   </span>
			   </div>
			     <div style="clear:both;">
			   </div>
		<?php }?>
        <br><br>
	</div>
</div>
<br />
<br />


<script>
function validate()
{
	/*var group=document.getElementById("groups").value;
	if(group=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_group").style.display = "inline";
		document.getElementById("groups").focus();
		return false;
	}*/

	var id=document.getElementById("numero_de_documento").value;
	if(id=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_id").style.display = "inline";
		document.getElementById("numero_de_documento").focus();
		return false;
	}
	
	var desc=document.getElementById("descripcion").value;
	if(desc=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_desc").style.display = "inline";
		document.getElementById("descripcion").focus();
		return false;
	}
	/*var scaned=0;
	var upload=document.getElementById("upload_default").value;
	if(upload=="")
	{	
		//path =server_path+"assets/app/file_upload/uploads/scan_cache";
		/*$.ajax({
			url:server_path+'user/isFileScaned',
			type:'POST',
			data:'username='+'dhiru',
			success:function(res) {
				if(res=='0') {
					//hideAllErrorssign();
					//document.getElementById("valid_upload").style.display = "inline";
					//document.getElementById("description").focus();
					alert('hi dhir');
					return false;
				}
			}
		})
		return false;
		
		hideAllErrorssign();
		document.getElementById("valid_upload").style.display = "inline";
		//document.getElementById("description").focus();
		return false;
	}*/
}

function validate1()
{
	/*var group=document.getElementById("groups").value;
	if(group=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_group").style.display = "inline";
		document.getElementById("groups").focus();
		return false;
	}*/

	var id=document.getElementById("document__id").value;
	if(id=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_id").style.display = "inline";
		document.getElementById("document__id").focus();
		return false;
	}
	
	var desc=document.getElementById("description").value;
	if(desc=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_desc").style.display = "inline";
		document.getElementById("description").focus();
		return false;
	}
	
	/*var upload=document.getElementById("upload_default").value;
	if(upload=="")
	{
		hideAllErrorssign();
		document.getElementById("valid_upload").style.display = "inline";
		//document.getElementById("description").focus();
		return false;
	}*/
}


</script>
<style>
.container-fluid{padding-top:35px;}
ul{padding-left:0px !important;}
</style>
<?php
//$extensions = array(".c",".m",".7z",".ai",".cs",".db",".gz",".js",".pl",".ps",".py",".rm",".ra",".3dm",".3g2",".3gp",".8bi",".aif",".app",".asf",".asx",".avi",".bak",".bat",".bin",".bmp",".cab",".cer",".cfg",".cgi",".com",".cpl",".cpp",".dbf",".dbx",".deb",".dll",".dmg",".dmp",".doc",".csr",".css",".csv",".cur",".dat",".drv",".drw",".dtd",".dwg",".dxf",".efx",".eps",".exe",".fla",".flv",".fnt",".fon",".gam",".gho",".gif",".gpx",".hqx",".iff",".ini",".iso",".jar",".jpg",".m3u",".m4a",".max",".mdb",".mid",".mim",".mov",".mp3",".mp4",".mpa",".mpg",".msg",".msi",".nes",".ori",".otf",".jsp",".key",".kml",".lnk",".log",".pct",".pdb",".pdf",".pif",".pkg",".png",".pps",".ppt",".prf",".psd",".qxd",".qxp",".rar",".rels",".rom",".rpm",".rss",".rtf",".sav",".sdf",".sit",".sql",".svg",".swf",".sys",".thm",".tif",".tmp",".ttf",".txt",".uue",".vb",".vcd",".vcf",".vob",".wav",".wks",".wma",".wmv",".wpd",".wps",".wsf",".xll",".xls",".xml",".yuv",".zip",".docx",".indd",".java",".part",".pptx",".sitx",".zipx",".xlsx",".pages",".accdb",".class",".toast",".plugin",".gadget",".tar.gz",".torrent",".keychain",".pspimage");
?>
<div class="row-fluid" style="background-color:white;">
	<?php $this->load->view('user/user_menu');?>
    <?php $sn = 1; $perpage = 15; $start=0;?>
     
	<div class="span10">
		<div id="tableMessage" style="display: none;"></div>
       <!-- <div style="font-size:16px; font-weight:bold;"><?=$this->lang->line("my_documents");?></div>
	   <br>
        <div style="float:right; margin-right:380px; margin-top:10px;" id="uploadFile">
        <form  action="<?=SERVER?>user/addFiles" method="post" enctype="multipart/form-data" id="form2" name="form2">
		<label id="fileLabel" data-up='0'><b><input type="button" value="Subir archivo" class="btn"></b></label>
		<span style="display:none; position:absolute;" id="showUploader">
			<label>Descripción del archivo</label>
			<input type="text" name="description" id="fileDesc"><br>
			<div id="description_error" style="display:none;color:#FF0000;"><strong>Error ! </strong> <?=$this->lang->line("doc_desc_req");?></div>		 			
			<!--<input class="btn" type="file" id="file_upload" name="upload" onclick="return false;">->
			<input type="file" id="file_upload" name="upload">
			<div id="file_error" style="display:none;color:#FF0000;"><br><strong>Error ! </strong>por favor elija un archivo</div>
			<br><br>
			<input type="submit" value="Subir" class="btn" onclick="return uploadValidate();">
			<input type="hidden" name="document_id" value="<?=$this->uri->segment(4)?>" />
			<input type="hidden" name="table_name" value="<?=$this->uri->segment(3)?>" />
		</span>
        </form>
		</div>-->
        
 <div style="margin-top:3px;">
<!-- <form action="<?=SERVER?>user/editDocumentTypes" method="post" enctype="multipart/form-data" id="form1" name="form1">
 		<div style="margin-bottom:14px;">
			<input type="submit" value="Guardar" name="submit" onclick="return validateEditDoc()" class="btn">
			<a class="fileview" href="<?=SERVER?>user/sendDocuments/<?=$docs['id']?>/<?=$this->uri->segment(3)?>">
			<input type="button" value="Enviar" name="send" onclick="retrun userValidate()" class="btn">
			</a>
			<?php //if($docs['user_id'] == $this->session->userdata("username")) {?>
				<input type="submit" value="Borrar" name="delete" class="btn" id="delDoc">
			<?php //}?>
		</div>
		<!-- <input type="submit" value="Cancel" name="cancel" class="btn">->
		<div style="width:100%;height:auto;">
          <?php /*$docTypes = $this->user_model->getUserDocumentById($docs['document_id']);
				$frmData = str_replace("\\", "", $docTypes['elements']);
				$frmData = json_decode($frmData);
				$br=1;
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
						
						<div style="margin-right:60px; float:left; max-width:220px;overflow: hidden;">
						<h6><?=$doc->title?></h6>
						<?php if($doc->type=='select') {?>
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
										<input type="hidden" name="files[]" value="<?=$docs[$title]?>">
								<?php }?>
							<input type="<?=$doc->type?>" name="<?=$title?>" value="<?=$docs[$title]?>" id="<?=$title?>">
						<?php }?>
						</div>
                        <?php //}?>
                        <?php if($br%2==0)  {?>
                        	<div style="clear:both;"></div>
						<?php }
						if($title=='descripcion') {?>
         <div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong> <?=$this->lang->line("doc_desc_req");?></div>		 			
                     
				<?php  }?>
				<?php $br++;//} elseif($key=='id') { $docId =$doc;?>
						<input type="hidden" name="id" value="<?=$docs['id']?>" id="document_id">
						<input type="hidden" name="table" value="<?=$this->uri->segment(3)?>" id="table">
				<?php //}
				}*/?>
                </div>
                <div style="clear:both;"></div><br>
                
				
                

                </form><hr>-->
			<?php
			 if(!empty($docFiles)) {?>
				<div><h4><?=$this->lang->line("uploaded_files")?></h4></div>
              <div style="margin-bottom:25px; margin-right:25px;"> 
              
              
               <table class="display" cellspacing="0" width="100%" id="tabs">
                      <thead>
                      <tr id="tHead">
                      <?php //$index = array();
					  // if(!empty($rec)) {
					  //foreach($rec as $key=>$value){
						// echo "<th>";
						 //	echo ucfirst($key); 
						// echo "</th>"; 829424 02/07/1996
						// } 
						// $index=$rec[0];
					  //<?=$this->lang->line("file_name")}?>
						<th style="width:10%">Número</th>
						<th style="width:50%">Descripción</th>
						<th style="width:15%"><?=$this->lang->line("user_name")?></th>
						<th style="width:15%"><?=$this->lang->line("created_date")?></th>
						<th style="width:10%">Acción</th>
                      </tr>
                      </thead>     
                      
                      <tbody>
                     
            
            <?php
				$clr = 0;
				foreach($docFiles as $file) {
					//if($clr%2==0)
					?>
                      <tr id="doc<?=$file['id']?>">
					  <td style="text-align:center;"><?=$file['id']?></td>
                      <td><a href="<?=SERVER?>assets/app/file_upload/uploads/<?=$this->uri->segment(3)?>/<?=$file['file_name']?>" target="_blank" class="pdfView"><?=$file['description']?></a></td>
                      <td style="text-align:center;"><?=$file['user']?></td>
                      <td style="text-align:center;"><?=date('d, M Y', $file['created'])?></td>
					  <td style="text-align:center;">
						<?php $isValid = $this->user_model->checkValidRoles('Modificar');
						if($file['user']==$this->session->userdata("username") or $isValid) {?>
							<button class="btn btn-mini btn-danger delete_doc" data-did="<?php echo $file['id'];?>" title="Eliminar archivo"><i class="icon-remove"></i> </button>
						<?php }?>
					  </td>
                      </tr>
					  <?php //$clr++;
				}?>
			
                     
					   </tbody>  
                      </table>
              
              </div>
			  <?php }?>
              <div><h4><?=$this->lang->line("uploaded_files")?></h4></div>
              <div style="margin-bottom:25px; margin-right:25px;"> 
              
              
               <table class="display" cellspacing="0" width="100%" id="tabs1">
                      <thead>
                      <tr id="tHead">
                      <?php //$index = array();
					  // if(!empty($rec)) {
					  //foreach($rec as $key=>$value){
						// echo "<th>";
						 //	echo ucfirst($key); 
						// echo "</th>"; 829424 02/07/1996
						// } 
						// $index=$rec[0];
					  //<?=$this->lang->line("file_name")}?>
						<th style="width:10%">Número</th>
						<th style="width:50%">Descripción</th>
						<th style="width:15%"><?=$this->lang->line("user_name")?></th>
						<th style="width:15%"><?=$this->lang->line("created_date")?></th>
						<th style="width:10%">Acción</th>
                      </tr>
                      </thead>     
                      
                      <tbody>
                        	<?php
			 if(!empty($files)) {?>
            
            <?php
				$clr = 0;
				foreach($files as $file) {
					//if($clr%2==0)
					?>
                      <tr id="doc<?=$file['id']?>">
					  <td style="text-align:center;"><?=$file['id']?></td>
                      <td><a href="<?=SERVER?>assets/app/file_upload/uploads/<?=$this->uri->segment(3)?>/<?=$file['file_name']?>" target="_blank" class="pdfView"><?=$file['description']?></a></td>
                      <td style="text-align:center;"><?=$file['user']?></td>
                      <td style="text-align:center;"><?=date('d, M Y', $file['created'])?></td>
					  <td style="text-align:center;">
						<?php $isValid = $this->user_model->checkValidRoles('Modificar');
						if($file['user']==$this->session->userdata("username") or $isValid) {?>
							<button class="btn btn-mini btn-danger delete_doc" data-did="<?php echo $file['id'];?>" title="Eliminar archivo"><i class="icon-remove"></i> </button>
						<?php }?>
					  </td>
                      </tr>
					  <?php //$clr++;
				}
			} else {?>
                     
                      <?php }?> 
					   </tbody>  
                      </table>
              
              </div>
              
              
              
			
		<!--<div style="background:#96C2D4; width:100%; padding:5px;">
            <div style="float:left; width:40%; font-weight:bold;"><?=$this->lang->line("file_name")?></div><div style="float:left; width:30%; font-weight:bold;"><?=$this->lang->line("user_name")?></div><div style="float:left; width:30%; font-weight:bold;"><?=$this->lang->line("created_date")?></div><div style="clear:both;"></div></div>
            <div style="margin-bottom:15px;" id="appendFile"> 
            	<?php
			 if(!empty($files)) {?>
            
            <?php
				$clr = 0;
				foreach($files as $file) {
					if($clr%2==0)
						$color = '#EEF4F4';
					else
						$color = '#AFDBED';
					?>
					<div style="background:<?=$color?>; width:100%; padding:5px;"><div style="float:left; width:40%"><a href="<?=SERVER?>assets/app/file_upload/uploads/<?=$this->uri->segment(3)?>/<?=$file['file_name']?>" target="_blank" class="pdfView"><?=$file['original_file_name']?></a></div><div style="float:left; width:30%"><?=$file['user']?></div><div style="float:left; width:30%;"><?=date('d, M Y', $file['created'])?></div>
                    <div style="clear:both;"></div></div>
			<?php $clr++;}
			} else {?>
				<div id="remTR"><?=$this->lang->line("no_file_uploaded")?></div>
		<?php }?>
       </div>
 </div>-->
<br />
<br />
<br />
<br /><br />
<br /><br />
<br /><br />
<br />
  </div>
  </div>  
  </div>


<!--<script src="//datatables.net/download/build/nightly/jquery.dataTables.js"></script>-->
<!--<script  type="text/javascript" language="javascript" src="<?=SERVER?>assets/js/jquery.dataTables.js"></script>-->
<!-- <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">-->
	<!--<link rel="stylesheet" type="text/css" href=
	"//cdn.datatables.net/plug-ins/e9421181788/integration/jqueryui/dataTables.jqueryui.css">-->
     <link href="<?=SERVER?>assets/css/dataTables.jqueryui.css" rel="stylesheet" type="text/css" />
 <link href="<?=SERVER?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
 <link href="<?=SERVER?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->logik->setting("default_url")?>assets/app/datepicker/css/datepicker.css" />
<script src="<?=$this->logik->setting("default_url")?>assets/app/datepicker/js/bootstrap-datepicker.js"></script>

 <?php
 $file_url=$this->logik->setting("default_url")."assets/app/file_upload/";
 $timestamp = time();
 ?>
  <script src="<?=$file_url?>jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=$file_url?>uploadify.css">
<script type="text/javascript">

$('#tabs').dataTable({
        "scrollY": "250px",
        "scrollCollapse": true,
        "paging": false,
        "jQueryUI": true,
		 "order": [[ 0, "desc" ]],
		  "language": {
            "sSearch": 'Buscar',
            "zeroRecords": "No hay registros disponibles",
            "info": "demostración _PAGE_ of _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"sLengthMenu":     "Show _MENU_ entradas",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
			"oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
         }
            }
    } );
	
$('#tabs1').dataTable({
        "scrollY": "250px",
        "scrollCollapse": true,
        "paging": false,
        "jQueryUI": true,
		 "order": [[ 0, "desc" ]],
		  "language": {
            "sSearch": 'Buscar',
            "zeroRecords": "No hay registros disponibles",
            "info": "demostración _PAGE_ of _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"sLengthMenu":     "Show _MENU_ entradas",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
			"oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
         }
            }
    } );
	
$(".dataTables_info").remove();	
$("#delDoc").click(function(){
	if(!confirm("¿estás seguro de que quieres eliminar este documento")) {
		return false;
	}
	
})

$('.delete_doc').live('click',function(){
		var doc_id = $(this).data('did');
		if(confirm('¿Seguro que quieres eliminar este archivo')) {
			$.ajax({
				url:server_path+'user/deleteFile',
				type:'POST',
				data:'file_id='+doc_id,
				success:function(res) {
					if(res) {
						$('#doc'+res).hide('slow');
					}
				}
			})
		}
	})
/*$(document).ready(function(e) {
    $(".editRow").live('click', function(){
		var id = $(this).data('id');
		var table = $(this).data('table');
		$(".document_id").val(id);
		$.ajax({
			url:server_path+'user/loadEditDocumentTypes',
			type:'POST',
			data:'doc_id='+id+'&table='+table,
			success:function(res) {
				if(res) {
					
					$('#tabs').html(res);
					$('#tHead').html('<th></th><th></th>');
					$('#recieveDocuments').hide();
					$('#sentDocuments').hide();
					$('#tabs_filter').hide();
					$('#tabs_info').hide();
					$('#uploadFile').fadeIn();
					
				}
			}
		})
	})
});*/

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
/*$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
					'document_id':'<?=$this->uri->segment(4)?>',
					'table_name':'<?=$this->uri->segment(3)?>',
					'user'      :'<?=$this->session->userdata("username");?>'
				},
				'swf'      : '<?=$file_url?>uploadify.swf',
				'uploader' : '<?=$file_url?>uploadify.php',    
			   'onUploadSuccess' : function(file, data, response) {
				   //alert(data);
				   var data=jQuery.parseJSON(data);
                 
					    //alert(data.id+" "+$(".document_id").val());
						$('#appendFile').prepend('<div style="background:#AFDBED; width:100%;"><div style="float:left; width:40%"><a href="<?=SERVER?>assets/app/file_upload/uploads/<?=$this->uri->segment(3)?>/'+data.file_name+'" target="_blank">'+data.original_file_name+'</a></div><div style="float:left; width:30%">'+data.user+'</div><div style="float:left; width:30%">'+data.created+'</div></div><div style="clear:both;"></div>');
						$('#remTR').hide();
				   
               } 
   });*/
   
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
		});
	//$(".container-fluid").css('padding-top','100px !important');
	</script>

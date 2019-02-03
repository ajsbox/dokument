<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
$host = gethostname();
$ip = gethostbyname($host);
//$ip = $_SERVER['SERVER_ADDR'];
$path1 = str_replace("scaner", "",getcwd());
$path2 = str_replace("C:\\xampp\\htdocs", "", $path1);
$dokumentpath = str_replace('/var/www', '', $path2);
if(!empty($_GET['table_name'])) {
		$path = str_replace("\\", "/",$dokumentpath.$_GET['table_name'].'/'.$_GET['file_name']);
}

?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head  runat="server">
    <title>Escanea documentos</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Language" content="en-us"/>
    <meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
    <link href="Styles/style.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript">
        window.history.forward();
        function noBack() { window.history.forward(); }
</script>
<script type="text/javascript" language="javascript" src="Scripts/online_demo_initpage.js"></script>
<script>
var docId = '<?=@$_GET['doc_id']?>';
var table = '<?=@$_GET['table']?>';

</script>
</head>

<body onpageshow="if (event.persisted) noBack();" onunload="">
<div class="D-dailog" id="J_waiting">
    <div id = "InstallBody">       
    </div>
</div>

    
<div id="container" class="body_Broad_width" style="margin:0 auto;">

<div class="DWTHeader">
    <!-- header.aspx is used to initiate the head of the sample page. Not necessary!-->
    <!-- #include file=includes/PageHead.aspx -->
</div>

<div id="DWTcontainer" class="body_Broad_width" style="background-color:#ffffff; height:900px; border:0;">

<div id="dwtcontrolContainer" style="height:605px;"></div>
<div id="DWTNonInstallContainerID" style="width:580px"></div>
<div id="DWTemessageContainer" style="margin-left:50px;width:580px"></div>

<div id="ScanWrapper">
<div id="divScanner" class="divinput">
    <ul class="PCollapse">
        <li>
        <div class="divType"></div>
            <div id="div_ScanImage" class="divTableStyle">
                <ul id="ulScaneImageHIDE" >
                    <li style="padding-left: 15px;">
                        <label for="source">Seleccionar origen:</label>
                        <select size="1" id="source" style="position:relative;width: 220px;" onchange="source_onchange()">
                            <option value = ""></option>    
                        </select></li>
                         <li style="display:none;" id="pNoScanner">
                            <a href="javascript: void(0)" class="ShowtblLoadImage" style="font-size: 11px; background-color:#f0f0f0; position:relative" id="aNoScanner"><b>What if I don't have a scanner/webcam connected?</b>
                        </a></li>
                        <li id="divProductDetail"></li>
                    <li style="text-align:center;">
                        <!--<input id="btnScan" class="bigbutton" style="color:#C0C0C0;" disabled="disabled" type="button" value="Scan" onclick ="acquireImage();"/></li>-->
                </ul>
            </div>
        </li>  
        <li>
        <!--<div class="divType"><div class="mark_arrow collapsed"></div>Load the Sample Images</div>-->
        <div id="div_SampleImage" style="display: none" class="divTableStyle">
            <ul>
                <li><b>Muestras:</b></li>
                <li style="text-align: center;">
                                   
                </li>
            </ul>
        </div>
    </li>
    <li>
       <!--<div class="divType"><div class="mark_arrow"></div>Load a Local Image</div>-->
        <div id="div_LoadLocalImage" style="display: none" class="divTableStyle">
            <ul>
                <li style="text-align: center; height:35px; padding-top:8px;">
                    <input type="button" value="Abrir Documento" style="width: 164px; height:30px; font-size:medium;" onclick="return autoLoadImage('<?=$path?>','<?=$path?>')" id="autoloadimage" />
					
					
                </li>
            </ul>
        </div>
    </li>
    </ul>
</div>
<div id="divBlank" style="height:20px">
<ul>
    <li></li>
</ul>
</div>

<div id="tblLoadImage" style="visibility:hidden;height:80px">
<ul>
    <li><b>You can:</b><a href="javascript: void(0)" style="text-decoration:none; padding-left:200px" class="ClosetblLoadImage">X</a></li>
</ul>
<div id="notformac1" style="background-color:#f0f0f0; padding:5px;">
<ul>
    <li><img alt="arrow" src="Images/arrow.gif" width="9" height="12"/><b>Install a Virtual Scanner:</b></li>
    <li style="text-align:center;"><a id="samplesource32bit" href="http://www.dynamsoft.com/demo/DWT/Sources/twainds.win32.installer.2.1.3.msi">32-bit Sample Source</a>
        <a id="samplesource64bit" style="display:none;" href="http://www.dynamsoft.com/demo/DWT/Sources/twainds.win64.installer.2.1.3.msi">64-bit Sample Source</a>
        from <a href="http://www.twain.org">TWG</a></li>
</ul>
</div>
</div>

<div id ="divEdit" class="divinput" style="position:relative">
<ul>
    <li></li>
	<img src="<?=$_GET['url']?>assets/img/scanner_big.png" title="Escanear" alt="Escanear" id="btnScan" class="bigbutton" style="color:#C0C0C0; cursor:pointer;" disabled="disabled" type="button" value="Scan" onclick ="acquireImage();" style="cursor:pointer;"/>&nbsp;
    <!--<li style="padding-left:9px;"><img src="Images/ShowEditor.png" title= "Show Image Editor" alt="Show Image Editor" id="btnEditor" onclick="btnShowImageEditor_onclick()"/>-->
    <img src="<?=$_GET['url']?>assets/img/save.png" id="btnUpload" title="Subir" alt="Subir" type="button" value="Subir imagen" style="cursor:pointer;">
	<img src="Images/RotateLeft.png" title="Girar a la Izquierda" alt="Girar a la Izquierda" id="btnRotateL"  onclick="btnRotateLeft_onclick()" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/rotateright.png" title="Girar a la Derecha" alt="Girar a la Derecha" id="btnRotateR"  onclick="btnRotateRight_onclick()" style="cursor:pointer;"/>&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/remove2.png" width="30px" title="Borrar Imagenes Seleccionadas" alt="Borrar Imagenes Seleccionadas" id="ZoomOt" onclick="btnRemoveCurrentImage_onclick();" style="cursor:pointer;"/>&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/crop.png" title="Cortar" alt="Cortar" id="btnCrop" onclick="btnCrop_onclick()" style="cursor:pointer;"/>&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/hand.png" title="Mover" alt="Mover" id="btnShape" onclick="changeMouseShape(true)" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/zoomin.png" width="30px" title="Aumentar" alt="Aumentar" id="ZoomIn" onclick="btnZoomIn_onclick();" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/zoomout.png" width="30px" title="Disminuir" alt="Disminuir" id="ZoomOt" onclick="btnZoomOt_onclick();" style="cursor:pointer;"/>&nbsp;
    <img src="Images/Rotate180.png" alt="Girar 180" title="Girar 180" onclick="btnRotate180_onclick()" style="cursor:pointer;"/>
    <img src="Images/Mirror.png" title="Mirror" alt="Mirror" id="btnMirror"  onclick="btnMirror_onclick()" style="cursor:pointer;"/>
    <!--<img src="Images/Flip.png" title="Flip" alt="Flip" id="btnFlip" onclick="btnFlip_onclick()"/> -->
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/previous.png" width="30px" title="Anterior" alt="Anterior" id="ZoomOt" onclick="btnPreImage_onclick();" style="cursor:pointer;"/>
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/next.png" width="30px" title="Siguiente" alt="Siguiente" id="ZoomOt" onclick="btnNextImage_onclick();" style="cursor:pointer;"/>
   <!--<img src="Images/ChangeSize.png" title="Change Image Size" alt="Change Image Size" id="btnChangeImageSize" onclick="btnChangeImageSize_onclick();"/>-->
    <!--<img src="Images/Crop.png" title="Crop" alt="Crop" id="btnCrop" onclick="btnCrop_onclick();"/>-->
    </li>
</ul>

</div>

<?php if(!empty($_GET['table'])) {?>
<div id="divUpload" class="divinput" style="position:relative">
<label for="imgTypejpeg2"><b>Descripción</b></label><br><textarea id="description" style="width: 270px;"></textarea><br>
<div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong> * Debe ingresar una descripción!</div>
</div>
<?php }?>

<?php if(isset($_GET['desc']) and empty($_GET['main'])) {?>
<div id="divUpload" class="divinput" style="position:relative">
<label for="imgTypejpeg2"><b>Descripción</b></label><br><textarea id="description" style="width: 270px;"><?=$_GET['desc']?></textarea><br>
<div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong> * Debe ingresar una descripción!</div>
</div>
<?php }?>

<!--<div id="divUpload" class="divinput" style="position:relative;">-->
<ul>
    <!--<li><img alt="arrow" src="Images/arrow.gif" width="9" height="12"/><b>Subir archivo</b></li>-->
    <li style="padding-left:9px; display:none;">
        <label for="txt_fileName">File Name: <input type="text" size="20" id="txt_fileName" /><input type="text" size="20" id="temp_holder" /></label></li>
    <li style="padding-left:9px; display:none;">
	    <label for="imgTypejpeg2">
		    <input type="radio" value="jpg" name="ImageType" id="imgTypejpeg2" onclick ="rd_onclick();"/>JPEG</label>
	    <label for="imgTypetiff2">
		    <input type="radio" value="tif" name="ImageType" id="imgTypetiff2" onclick ="rdTIFF_onclick();"/>TIFF</label>
	    <label for="imgTypepng2">
		    <input type="radio" value="png" name="ImageType" id="imgTypepng2" onclick ="rd_onclick();"/>PNG</label>
	    <label for="imgTypepdf2">
		    <input type="radio" value="pdf" name="ImageType" id="imgTypepdf2" onclick ="rdPDF_onclick();">PDF</label></li>
    <li style="padding-left:9px; display:none;">
        <label for="MultiPageTIFF"><input type="checkbox" id="MultiPageTIFF"/>Multi-Page TIFF</label>
        <label for="MultiPagePDF"><input type="checkbox" id="MultiPagePDF"/>Multi-Page PDF </label></li>
	<li style="text-align: center">
	<?php if(!empty($_GET['table'])) {?>
        <!--<input id="btnUpload" type="button" value="Subir imagen"/>-->
	<?php } else {?>
		<!--<input id="btnUpload" type="button" value="Subir imagen" onclick="btnUpload_onclick()"/>-->
	<?php }?>
	</li>
</ul>
</div>

<div id="divSave" class="divinput" style="position:relative; display:none;">
<ul>
    <li><img alt="arrow" src="Images/arrow.gif" width="9" height="12"/><b>Save Image</b></li>
    <li style="padding-left:15px;">
        <label for="txt_fileNameforSave">File Name:<input type="text" size="20" id="txt_fileNameforSave"/></label></li>
    <li style="padding-left:12px;">
        <label for="imgTypebmp">
            <input type="radio" value="bmp" name="imgType_save" id="imgTypebmp" onclick ="rdsave_onclick();"/>BMP</label>
	    <label for="imgTypejpeg">
		    <input type="radio" value="jpg" name="imgType_save" id="imgTypejpeg" onclick ="rdsave_onclick();"/>JPEG</label>
	    <label for="imgTypetiff">
		    <input type="radio" value="tif" name="imgType_save" id="imgTypetiff" onclick ="rdTIFFsave_onclick();"/>TIFF</label>
	    <label for="imgTypepng">
		    <input type="radio" value="png" name="imgType_save" id="imgTypepng" onclick ="rdsave_onclick();"/>PNG</label>
	    <label for="imgTypepdf">
		    <input type="radio" value="pdf" name="imgType_save" id="imgTypepdf" onclick ="rdPDFsave_onclick();"/>PDF</label></li>
    <li style="padding-left:12px;">
        <label for="MultiPageTIFF_save"><input type="checkbox" id="MultiPageTIFF_save"/>Multi-Page TIFF</label>
        <label for="MultiPagePDF_save"><input type="checkbox" id="MultiPagePDF_save"/>Multi-Page PDF </label></li>
    <li style="text-align: center">
        <input id="btnSave" type="button" value="Save Image" onclick ="btnSave_onclick()"/></li>
</ul>
</div>

<div id="divNoteMessage"  >
</div>

</div>

</div>

 <div class="DWTTail">
    <!-- #include file=includes/PageTail.aspx -->
</div>



</div>

<div id="ImgSizeEditor" style="visibility:hidden; text-align:left;">	
<ul>
    <li><label for="img_height"><b>New Height :</b>
        <input type="text" id="img_height" style="width:50%;" size="10"/>pixel</label></li>
    <li><label for="img_width"><b>New Width :</b>&nbsp;
        <input type="text" id="img_width" style="width:50%;" size="10"/>pixel</label></li>
    <li>Interpolation method:
        <select size="1" id="InterpolationMethod"><option value = ""></option></select></li>
    <li style="text-align:center;">
        <input type="button" value="   OK   " id="btnChangeImageSizeOK" onclick ="btnChangeImageSizeOK_onclick();"/>
        <input type="button" value=" Cancel " id="btnCancelChange" onclick ="btnCancelChange_onclick();"/></li>
</ul>
</div>
<script type="text/javascript" language="javascript" src="Scripts/jquery.js"></script>
<script>
<?php if(!empty($path)) {?>

	setTimeout(function() {
		$("#autoloadimage").trigger( "click" );
	}, 1000);
	
	
<?php }?>

	<?php if(!empty($_GET['table'])) {?>
	$("#btnUpload").click(function() {
		var desc = $("#description").attr("value");
		if(desc) {
			var text1 = $("#temp_holder").attr("value");
			desc = desc.replace("   "," ");
			desc = desc.replace("  "," ");
			desc = desc.replace(" ","_");
			desc = desc.trim().replace(/[^a-z0-9]+/gi, ' ');
			desc = desc.replace("  ", " ");
			$("#txt_fileName").attr("value", desc+text1);
			$("#valid_desc").css({"display":"none"});
			btnUpload_onclick();
			$("#description").attr("value", '');
		} else {
			$("#valid_desc").css({"display":"inline"});
		}
	})
	<?php } else if(empty($_GET['main'])) {?>
		$("#btnUpload").click(function() {
			var desc = $("#description").attr("value");
			if(desc) {
				var text1 = $("#temp_holder").attr("value");
				desc = desc.replace("   "," ");
				desc = desc.replace("  "," ");
				desc = desc.replace(" ","_");
				desc = desc.trim().replace(/[^a-z0-9]+/gi, ' ');
				desc = desc.replace("  ", " ");
				$("#txt_fileName").attr("value", desc+text1);
				$("#valid_desc").css({"display":"none"});
				btnUpload_onclick();
				//$("#description").attr("value", '');
			} else {
				$("#valid_desc").css({"display":"inline"});
			}
		})
	<?php } else {?>
		$("#btnUpload").click(function() {
			btnUpload_onclick();
		})
	<?php }?>
</script>

<script type="text/javascript" language="javascript" src="Resources/dynamsoft.webtwain.initiate.js"></script>
<script type="text/javascript" language="javascript" src="Resources/dynamsoft.webtwain.config.js"></script>
<script type="text/javascript" language="javascript" src="Scripts/online_demo_operation.js"></script>
<script type="text/javascript" language="javascript" src="Scripts/online_demo_initpage.js"></script>

<script type="text/javascript"> 
    $("ul.PCollapse li>div").click(function() {
        if ($(this).next().css("display") == "none") {
            $(".divType").next().hide("normal");
            $(".divType").children(".mark_arrow").removeClass("expanded");
            $(".divType").children(".mark_arrow").addClass("collapsed");
            $(this).next().show("normal");
            $(this).children(".mark_arrow").removeClass("collapsed");
            $(this).children(".mark_arrow").addClass("expanded");
        }
    });
</script>
<script type="text/javascript" language="javascript">
    // Assign the page onload fucntion.
    $(function() {
        pageonload();
    });

    $('#DWTcontainer').hover(function() {
        $(document).bind('mousewheel DOMMouseScroll', function(event) {
            stopWheel(event);
        });
    }, function() {
        $(document).unbind('mousewheel DOMMouseScroll');
    });
</script>
<script type="text/javascript" language="javascript">
    // Assign the page onload fucntion.
    S.ready(function() {
        pageonload();
    });
</script>
</body>
</html>


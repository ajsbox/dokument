<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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
<script>
var docId = '<?=$_GET['doc_id']?>';
</script>
</head>

<body onpageshow="if (event.persisted) noBack();" onunload="">
<div class="D-dailog" id="J_waiting">
    <div id = "InstallBody">      
    </div>
</div>

    <br>
<div id="container" class="body_Broad_width1" style="margin:0 auto;">

<div class="DWTHeader">
    <!-- header.aspx is used to initiate the head of the sample page. Not necessary!-->
    <!-- #include file=includes/PageHead.aspx -->
</div>

<div id="DWTcontainer" class="body_Broad_width1" style="background-color:#ffffff; height:828px; border:0;">

<div style="float:left;">
&nbsp;&nbsp;&nbsp;&nbsp;
 <!--<input id="btnScan" class="bigbutton" style="color:#C0C0C0;" disabled="disabled" type="button" value="Scan" onclick ="acquireImage();"/>-->
 <img src="<?=$_GET['url']?>assets/img/scanner_big.png" id="btnScan" title="Escanear" alt="Escanear" class="bigbutton" style="color:#C0C0C0; cursor:pointer;" disabled="disabled" type="button" value="Scan" onclick ="acquireImage();">
</div>
<div style="float:left;margin-left:10px;">
<!--<input id="btnUpload" type="button" value="Subir imagen" onclick ="btnUpload_onclick()"/>-->

    <img src="<?=$_GET['url']?>assets/img/save.png" id="btnUpload" title="Subir" alt="Subir" type="button" value="Subir imagen" onclick ="btnUpload_onclick()" style="cursor:pointer;">&nbsp;
    <img src="<?= $_GET['url']?>assets/img/attached.png" type="button" value="Load Image" onclick ="return btnLoad_onclick()" style="cursor:pointer;">&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/remove.png" width="30px" title="Borrar Imagenes Seleccionadas" alt="Borrar Imagenes Seleccionadas" id="ZoomOt" onclick="btnRemoveCurrentImage_onclick();" style="cursor:pointer;"/>&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/rotateleft.png" title="Girar a la Izquierda" alt="Girar a la Izquierda" id="btnRotateL"  onclick="btnRotateLeft_onclick()" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/rotateright.png" title="Girar a la Derecha" alt="Girar a la Derecha" id="btnRotateR"  onclick="btnRotateRight_onclick()" style="cursor:pointer;"/>&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/crop.png" title="Cortar" alt="Cortar" id="btnCrop" onclick="btnCrop_onclick()" style="cursor:pointer;"/>&nbsp;
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/hand.png" title="Mover" alt="Mover" id="btnShape" onclick="changeMouseShape(true)" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/mirror.png" title="Voltear" alt="Voltear" id="btnMirror"  onclick="btnMirror_onclick()" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/zoomin.png" width="30px" title="Aumentar" alt="Aumentar" id="ZoomIn" onclick="btnZoomIn_onclick();" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/zoomout.png" width="30px" title="Disminuir" alt="Disminuir" id="ZoomOt" onclick="btnZoomOt_onclick();" style="cursor:pointer;"/>&nbsp;
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/previous.png" width="30px" title="Anterior" alt="Anterior" id="ZoomOt" onclick="btnPreImage_onclick();" style="cursor:pointer;"/>&nbsp;
	<input type="text" size="2" id="DW_CurrentImage" readonly="readonly" value="0" style="height: 28px !important; border: 1px solid #ABADB3; margin-top: -18px; padding: 2; vertical-align: middle;"/>
            /
    <input type="text" size="2" id="DW_TotalImage" readonly="readonly" value="0" style="height: 27px !important; border: 1px solid #ABADB3; margin-top: -18px; padding: 2; vertical-align: middle;"/>
	<img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Resources/reference/imgs/next.png" width="30px" title="Siguiente" alt="Siguiente" id="ZoomOt" onclick="btnNextImage_onclick();" style="cursor:pointer;"/>
</div>

<div style="float:left;margin-left:2px; margin-top:8px;">
<select id="colorSel"  style="height: 27px !important; border: 1px solid #ABADB3; margin: 0; font-size: 12px; padding: 2; vertical-align: middle;" >
	<option value="bw">B&N</option>
	<option value="gray">Gris</option>
	<option value="color">Color</option>
</select>
 <select size="1" id="DW_PreviewMode" style="height: 27px !important; border: 1px solid #ABADB3; margin: 0; font-size: 12px; padding: 2; vertical-align: middle;" onchange="setlPreviewMode();">
                <option value="0">1X1</option>
                <option value="1">2X2</option>
                <option value="2">3X3</option>
                <option value="3">4X4</option>
                <option value="4">5X5</option>
            </select>
	<select size="1" id="source" style="position:relative;width: 144px;font-size: 12px; height: 28px !important; border: 1px solid #ABADB3; margin: 0; padding: 2; vertical-align: middle;" onchange="source_onchange()">
      <option value = ""></option>    
    </select>
</div>
<div style="clear:both;"></div>



<div id="ScanWrapper" style="float:left;margin-top:0px; display:none;">
<div id="divScanner" class="divinput">
    <ul class="PCollapse">
        <li>
        <div class="divType"><div class="mark_arrow expanded"></div>Análisis personalizado</div>
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
                        <input id="btnScan" class="bigbutton" style="color:#C0C0C0;" disabled="disabled" type="button" value="Scan" onclick ="acquireImage();"/></li>
                </ul>
            </div>
        </li>  
        <li>
        <!--<div class="divType"><div class="mark_arrow collapsed"></div>Load the Sample Images</div>-->
        <div id="div_SampleImage" style="display: none" class="divTableStyle">
            <ul>
                <li><b>Muestras:</b></li>
                <li style="text-align: center;">
                    <table style="border-spacing: 2px; width: 100%;">
                        <tr>
                           <td style="width: 33%">
                                <input name="SampleImage3" type="image" src="Images/icon_associate3.png" style="width: 50px;
                                    height: 50px" onclick="loadSampleImage(3);" onmouseover="Over_Out_DemoImage(this,'Images/icon_associate3.png');"
                                    onmouseout="Over_Out_DemoImage(this,'Images/icon_associate3.png');" />
                            </td>
                            <td style="width: 33%">
                                <input name="SampleImage2" type="image" src="Images/icon_associate2.png" style="width: 50px;
                                    height: 50px" onclick="loadSampleImage(2);" onmouseover="Over_Out_DemoImage(this,'Images/icon_associate2.png');"
                                    onmouseout="Over_Out_DemoImage(this,'Images/icon_associate2.png');" />
                            </td>
                             <td style="width: 33%">
                                <input name="SampleImage1" type="image" src="Images/icon_associate1.png" style="width: 50px;
                                    height: 50px" onclick="loadSampleImage(1);" onmouseover="Over_Out_DemoImage(this,'Images/icon_associate1.png');"
                                    onmouseout="Over_Out_DemoImage(this,'Images/icon_associate1.png');" />
                            </td>                 
                        </tr>
                        <tr>
                           <td>
                                B&W Image
                            </td>
                            <td>
                                Grey Image
                            </td>
                             <td>
                                Color Image
                            </td>
                            
                        </tr>
                    </table>                 
                </li>
            </ul>
        </div>
    </li>
    <li>
       <!-- <div class="divType"><div class="mark_arrow collapsed"></div>Load a Local Image</div>-->
        <div id="div_LoadLocalImage" style="display: none" class="divTableStyle">
            <ul>
                <li style="text-align: center; height:35px; padding-top:8px;">
                    <input type="button" value="Load Image" style="width: 130px; height:30px; font-size:medium;" onclick="return btnLoad_onclick()" />
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
    <li><img alt="arrow" src="Images/arrow.gif" width="9" height="12"/><b>Edit Image</b></li>
    <li style="padding-left:9px;"><img src="Images/ShowEditor.png" title= "Show Image Editor" alt="Show Image Editor" id="btnEditor" onclick="btnShowImageEditor_onclick()"/>
    <img src="Images/RotateLeft.png" title="Girar a la Izquierda" alt="Rotate Left" id="btnRotateL"  onclick="btnRotateLeft_onclick()"/>
    <img src="Images/RotateRight.png" title="Girar a la Derecha" alt="Rotate Right" id="btnRotateR"  onclick="btnRotateRight_onclick()"/>
    <img src="Images/Rotate180.png" alt="Girar 180" title="Girar 180" onclick="btnRotate180_onclick()" />
    <img src="Images/Mirror.png" title="Mirror" alt="Mirror" id="btnMirror"  onclick="btnMirror_onclick()"/>
    <img src="Images/Flip.png" title="Flip" alt="Flip" id="btnFlip" onclick="btnFlip_onclick()"/> 
    <img src="Images/ChangeSize.png" title="Change Image Size" alt="Change Image Size" id="btnChangeImageSize" onclick="btnChangeImageSize_onclick();"/>
    <img src="Images/Crop.png" title="Crop" alt="Crop" id="btnCrop" onclick="btnCrop_onclick();"/>
    </li>
</ul>

</div>

<div id="divUpload" class="divinput" style="position:relative;">
<ul>
    <li><img alt="arrow" src="Images/arrow.gif" width="9" height="12"/><b>Upload Image</b></li>
    <li style="padding-left:9px; display:none;">
        <label for="txt_fileName">File Name: <input type="text" size="20" id="txt_fileName" /></label></li>
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

		<input id="btnUpload" type="button" value="Subir imagen" onclick="btnUpload_onclick()"/>
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

<div id="dwtcontrolContainer" style="width:500px;float:left;"></div>
<div id="DWTNonInstallContainerID" style="width:500px;float:left;"></div>
<div id="DWTemessageContainer" style="margin-left:50px;width:500px;float:left;"></div>
</div>

 <div class="DWTTail">
    <!-- #include file=includes/PageTail.aspx -->
</div>



</div>

<div id="ImgSizeEditor" style="display:none;text-align:left;">	
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
	
	$("#colorSel").live("change", function(){
		var color = $(this).val();
		if(color=='bw') {
			$("#BW").trigger("click");
		} else if(color=="gray") {
			$("#Gray").trigger("click");
		} else if(color=="color") {	
			$("#RGB").trigger("click");
		}
	})
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
    // Assign the page onload function.
    S.ready(function() {
        pageonload();
    });
</script>
</body>
</html>


<!--<iframe src="<?=$url?>assets/app/file_upload/uploads/create_scaner/online_demo_scan.php?doc_id=<?=$docId?>&url=<?=$url?>" height="200%;" width="50%"></iframe>-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head  runat="server">
    <title>Escanea documentos</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Language" content="en-us"/>
    <meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
    <meta name="description" content="Dynamic Web TWAIN is a TWAIN scanning SDK specifically optimized for web applications. You can control any TWAIN compatible device drivers - scanner, digital camera or capture card - in a web page to acquire images, edit and then upload to web servers using the TWAIN control." />
    <meta name="keyword" content="Dynamsoft, TWAIN, Scanners, SDK, Scanning"/>
    <link href="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Styles/style.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" language="javascript" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Scripts/kissy-min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script>
var docId = '<?=$_GET['doc_id']?>';
</script>
</head>

<body>
<div class="D-dailog" id="J_waiting">
    <div id = "InstallBody">       
    </div>
</div>

    
<div id="container" class="body_Broad_width" style="margin:0 auto;">

<div class="DWTHeader">
    <!--<div class="body_Broad_width" style="background-image:url(Images/adtopbackground.gif); height:88px; width:987px; ">
    <div style="float:left; padding-top:15px; width:525px; margin-left:25px;">
       <span>
            <a href="http://www.dynamsoft.com/"><img src="Images/logo.gif" alt="Dynamsoft: provider of version control solution and TWAIN SDK" style="padding: 12px 0 0;" name="logo" border="0" align="left" id="logo" title="Dynamsoft: provider of version control solution and TWAIN SDK" /></a>
        </span>-->
       <!-- <span style="border-left:1px solid #CCC;margin: 0 0 0 10px;padding: 40px 0 0 10px;">
            <a href="http://www.dynamsoft.com/Products/WebTWAIN_Overview.aspx"> <img alt = "DynamicWebTWAIN logo" style="border:none; " src="Images/DWT icon logo.png"/></a>
        </span>
    </div>
   </div>-->
   <div id="menu">
<!--   <ul>
   <li style="float:left; width:30px; height:40px; line-height:40px; color:#FFF;"></li>
   <li class="D_menu_item" style="width:280px">
   <div class="menubar_split" ></div>
   <div class="menubar_split_last"></div>
   <a class="nohref" href="http://www.dynamsoft.com/demo/DWT/online_demo_scan.aspx">Dynamic Web TWAIN Demo</a>
   </li>
   <li style="float:left; width:420px;color:#FFF;"></li>
   <li class="D_menu_item" style="width:220px;" title="Includes Source Code of Current Page">
   <div class="menubar_split" ></div>
   <div class="menubar_split_last"></div>
   <a class="nohref" href="https://www.dynamsoft.com/Secure/Register_ClientInfo.aspx?productName=WebTWAIN&from=FromDownload"> Download Free Trial</a>
   </li>
   </ul>-->
   </div>
</div>

<div id="DWTcontainer" class="body_Broad_width" style="background-color:#ffffff; height:800px; border:0;">

<div id="dwtcontrolContainer" style="width:500px;"></div>
<div id="DWTNonInstallContainerID" style="width:500px;"></div>
<div id="DWTemessageContainer" style="margin-left:50px;width:500px;"></div>

<div id="ScanWrapper">
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
                            <a href="javascript: void(0)" class="ShowtblLoadImage" style="font-size: 11px; background-color:#f0f0f0; position:relative" id="aNoScanner"><b>¿Qué pasa si no tengo un escáner / cámara web conectada?</b>
                        </a></li>
                        <li id="divProductDetail"></li>
                    <li style="text-align:center;">
                        <input id="btnScan" class="bigbutton" style="color:#C0C0C0;" disabled="disabled" type="button" value="Scan" onclick ="acquireImage();"/></li>
                </ul>
            </div>
        </li>  
        <li>
       <!-- <div class="divType"><div class="mark_arrow collapsed"></div>Load the Sample Images</div>-->
        <div id="div_SampleImage" style="display: none" class="divTableStyle">
            <ul>
                <li><b>Muestras:</b></li>
                <li style="text-align: center;">
                    <table style="border-spacing: 2px; width: 100%;">
                        <tr>
                             <td style="width: 33%">
                                <input name="SampleImage3" type="image" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate3.png" style="width: 50px;
                                    height: 50px" onclick="loadSampleImage(3);" onmouseover="Over_Out_DemoImage(this,'<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate3.png');"
                                    onmouseout="Over_Out_DemoImage(this,'<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate3.png');" />
                            </td>
                            <td style="width: 33%">
                                <input name="SampleImage2" type="image" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate2.png" style="width: 50px;
                                    height: 50px" onclick="loadSampleImage(2);" onmouseover="Over_Out_DemoImage(this,'<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate2.png');"
                                    onmouseout="Over_Out_DemoImage(this,'<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate2.png');" />
                            </td>
                            <td style="width: 33%">
                                <input name="SampleImage1" type="image" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate1.png" style="width: 50px;
                                    height: 50px" onclick="loadSampleImage(1);" onmouseover="Over_Out_DemoImage(this,'<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate1.png');"
                                    onmouseout="Over_Out_DemoImage(this,'<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/icon_associate1.png');" />
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
        <div class="divType"><div class="mark_arrow collapsed"></div>Cargue una imagen local</div>
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
    <li><b>Ysted puede:</b><a href="javascript: void(0)" style="text-decoration:none; padding-left:200px" class="ClosetblLoadImage">X</a></li>
</ul>
<div id="notformac1" style="background-color:#f0f0f0; padding:5px;">
<ul>
    <li><img alt="arrow" src="Images/arrow.gif" width="9" height="12"/><b>Instale un escáner virtual:</b></li>
    <li style="text-align:center;"><a id="samplesource32bit" href="http://www.dynamsoft.com/demo/DWT/Sources/twainds.win32.installer.2.1.3.msi">32-bit fuente de ejemplo</a>
        <a id="samplesource64bit" style="display:none;" href="http://www.dynamsoft.com/demo/DWT/Sources/twainds.win64.installer.2.1.3.msi">64-bit fuente de ejemplo</a>
        desde <a href="http://www.twain.org">TWG</a></li>
</ul>
</div>
</div>

<div id ="divEdit" class="divinput" style="position:relative">
<ul>
    <li><img alt="arrow" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/arrow.gif" width="9" height="12"/><b>Editar imagen</b></li>
    <li style="padding-left:9px;"><img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/ShowEditor.png" title= "Show Image Editor" alt="Show Image Editor" id="btnEditor" onclick="btnShowImageEditor_onclick()"/>
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/RotateLeft.png" title="Rotate Left" alt="Rotate Left" id="btnRotateL"  onclick="btnRotateLeft_onclick()"/>
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/RotateRight.png" title="Rotate Right" alt="Rotate Right" id="btnRotateR"  onclick="btnRotateRight_onclick()"/>
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/Mirror.png" title="Mirror" alt="Mirror" id="btnMirror"  onclick="btnMirror_onclick()"/>
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/Flip.png" title="Flip" alt="Flip" id="btnFlip" onclick="btnFlip_onclick()"/>
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/Crop.png" title="Crop" alt="Crop" id="btnCrop" onclick="btnCrop_onclick();"/>
    <img src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/ChangeSize.png" title="Change Image Size" alt="Change Image Size" id="btnChangeImageSize" onclick="btnChangeImageSize_onclick();"/></li>
</ul>

</div>

<div id="divSave" class="divinput" style="position:relative; display:none;">
<ul>
    <li><img alt="arrow" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/arrow.gif" width="9" height="12"/><b>Save Image</b></li>
    <li style="padding-left:15px;">
        <label for="txt_fileNameforSave">Nombre del archivo: <input type="text" size="20" id="txt_fileNameforSave" readonly /></label></li>
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
        <label for="MultiPageTIFF_save"><input type="checkbox" id="MultiPageTIFF_save"/>Multi-Página TIFF</label>
        <label for="MultiPagePDF_save"><input type="checkbox" id="MultiPagePDF_save"/>Multi-Página PDF </label></li>
    <li style="text-align: center">
        <input id="btnSave" type="button" value="Guardar imagen" onclick ="btnSave_onclick()"/></li>
</ul>
</div>

<div id="divUpload" class="divinput" style="position:relative">

<ul>
    <li><img alt="arrow" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Images/arrow.gif" width="9" height="12"/><b>Subir imagen</b></li>
    <li style="padding-left:9px; display:none;">
        <label for="txt_fileName">Nombre del archivo: <input type="text" size="20" id="txt_fileName" readonly /></label></li>
    <li style="padding-left:9px; display:none;">
	    <label for="imgTypejpeg2">
		    <input type="radio" value="jpg" name="ImageType" id="imgTypejpeg2" onclick ="rd_onclick();"/>JPEG</label>
	    <label for="imgTypetiff2">
		    <input type="radio" value="tif" name="ImageType" id="imgTypetiff2" onclick ="rdTIFF_onclick();"/>TIFF</label>
	    <label for="imgTypepng2">
		    <input type="radio" value="png" name="ImageType" id="imgTypepng2" onclick ="rd_onclick();"/>PNG</label>
	    <label for="imgTypepdf2">
		    <input type="radio" value="pdf" name="ImageType" id="imgTypepdf2" onclick ="rdPDF_onclick();"/>PDF</label></li>
    <li style="padding-left:9px; display:none;">
        <label for="MultiPageTIFF"><input type="checkbox" id="MultiPageTIFF"/>Multi-Página  TIFF</label>
        <label for="MultiPagePDF"><input type="checkbox" id="MultiPagePDF"/>Multi-Página  PDF </label></li>
    <li style="text-align: center">
        <input id="btnUpload" type="button" value="Subir imagen" onclick ="btnUpload_onclick()"/></li>
</ul>
</div>

<div id="divUpgrade">
</div>

</div>

</div>

 <div class="DWTTail">
    <script src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Scripts/DWT_PageTail.js"></script>
</div>
</div>

<div id="ImgSizeEditor" style="visibility:hidden; text-align:left;">	
<ul>
    <li><label for="img_height"><b>Nueva Altura :</b>
        <input type="text" id="img_height" style="width:50%;" size="10"/>pixel</label></li>
    <li><label for="img_width"><b>Nueva Altura :</b>&nbsp;
        <input type="text" id="img_width" style="width:50%;" size="10"/>pixel</label></li>
    <li>método de interpolación:
        <select size="1" id="InterpolationMethod"><option value = ""></option></select></li>
    <li style="text-align:center;">
        <input type="button" value="   OK   " id="btnChangeImageSizeOK" onclick ="btnChangeImageSizeOK_onclick();"/>
        <input type="button" value=" Cancel " id="btnCancelChange" onclick ="btnCancelChange_onclick();"/></li>
</ul>
</div>
<div id="Crop" style="visibility:hidden ;">	
<div style="width:50%; height:100%; float:left; text-align:left;">
<ul>
    <li><label for="img_left"><b>izquierda: </b>
        <input type="text" id="img_left" style="width:50%;" size="4"/></label></li>
    <li><label for="img_top"><b>superior: </b>
        <input type="text" id="img_top" style="width:50%;" size="4"/></label></li>
    <li style="text-align:center;">
        <input type="button" value="  OK  " id="btnCropOK" onclick ="btnCropOK_onclick()"/></li>
</ul>
</div>
<div style="width:50%; height:100%; float:left; text-align:right;">
<ul>
    <li><label for="img_right"><b>derecho : </b>
        <input type="text" id="img_right" style="width:50%;" size="4"/></label></li>
    <li>
		<label for="img_bottom"><b>inferior:</b>
        <input type="text" id="img_bottom" style="width:50%;" size="4"/></label>
	</li>
    <li style=" text-align:center;">
        <input type="button" value="Cancel" id="cancelcrop" onclick ="btnCropCancel_onclick()"/></li>
</ul>
</div>
</div>
<script type="text/javascript" language="javascript" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Scripts/dynamsoft.webtwain.initiate.js"></script>
<script type="text/javascript" language="javascript" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Scripts/online_demo_operation.js"></script>
<script type="text/javascript" language="javascript" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Scripts/online_demo_initpage.js"></script>
<script type="text/javascript" language="javascript" src="<?=$_GET['url']?>assets/app/file_upload/uploads/create_scaner/Scripts/jquery.js"></script>
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
    S.ready(function() {
        pageonload();
    });
</script>
</body>
</html>
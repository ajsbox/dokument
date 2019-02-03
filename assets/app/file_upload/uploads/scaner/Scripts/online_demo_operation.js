//--------------------------------------------------------------------------------------
//************************** Import Image*****************************
//--------------------------------------------------------------------------------------
/*-----------------select source---------------------*/
function source_onchange() {
    if (document.getElementById("divTwainType"))
        document.getElementById("divTwainType").style.display = "";
    if (document.getElementById("btnScan"))
        document.getElementById("btnScan").value = "Scan";

    if (document.getElementById("source"))
        DWObject.SelectSourceByIndex(document.getElementById("source").selectedIndex);
}


/*-----------------Acquire Image---------------------*/
function acquireImage() {
    DWObject.SelectSourceByIndex(document.getElementById("source").selectedIndex);
    DWObject.CloseSource();
    DWObject.OpenSource();
    DWObject.IfShowUI = document.getElementById("ShowUI").checked;
	
	// Remove black pages
	DWObject.IfAutoDiscardBlankpages = true;
	DWObject.Capability = EnumDWT_Cap.ICAP_PIXELTYPE;
	DWObject.Capability = 0x1134;
	DWObject.CapType = 5;  
	DWObject.CapValue = -1;  

    var i;
    for (i = 0; i < 3; i++) {
        if (document.getElementsByName("PixelType").item(i).checked == true)
            DWObject.PixelType = i;
    }
    DWObject.Resolution = document.getElementById("Resolution").value;
    DWObject.IfFeederEnabled = document.getElementById("ADF").checked;
    DWObject.IfDuplexEnabled = document.getElementById("Duplex").checked;
    if (Dynamsoft.Lib.env.bWin || (!Dynamsoft.Lib.env.bWin && DWObject.ImageCaptureDriverType == 0))
        appendMessage("Tipo de Pixel: " + DWObject.PixelType + "<br />Resolución: " + DWObject.Resolution + "<br />");

    DWObject.IfDisableSourceAfterAcquire = true;
    DWObject.AcquireImage();
}

/*-----------------Load Image---------------------*/
function btnLoad_onclick() {
    var OnSuccess = function() {
        appendMessage("La imagen se cargo de forma exitosa.<br/>");
        updatePageInfo();
    };

    var OnFailure = function(errorCode, errorString) {
        checkErrorStringWithErrorCode(errorCode, errorString);
    };
    
    DWObject.IfShowFileDialog = true;
    DWObject.LoadImageEx("", 5, OnSuccess, OnFailure);
}

function loadSampleImage(nIndex) {
    var ImgArr;

    switch (nIndex) {
        case 1:
            ImgArr = "/Images/twain_associate1.png";
            break;
        case 2:
            ImgArr = "/Images/twain_associate2.png";
            break;
        case 3:
            ImgArr = "/Images/twain_associate3.png";
            break;
    }

    if (location.hostname != '') {

        var OnSuccess = function() {
            appendMessage('Se cargo la imagen de forma exitosa. (Http Download)<br/>');
            updatePageInfo();
        };

        var OnFailure = function(errorCode, errorString) {
            checkErrorStringWithErrorCode(errorCode, errorString);
        };
        
        DWObject.IfSSL = DynamLib.detect.ssl;
        var _strPort = location.port == "" ? 80 : location.port;
        if (DynamLib.detect.ssl == true)
            _strPort = location.port == "" ? 443 : location.port;
        DWObject.HTTPPort = _strPort;

        DWObject.HTTPDownload(location.hostname, DynamLib.getRealPath(ImgArr), OnSuccess, OnFailure);
    }
    else {
        var OnSuccess = function() {
            DWObject.IfShowFileDialog = true;

            appendMessage('Se cargo la imagen de forma exitosa.');
            updatePageInfo();
        };

        var OnFailure = function(errorCode, errorString) {
            DWObject.IfShowFileDialog = true;
            checkErrorStringWithErrorCode(errorCode, errorString);
        };
        
        DWObject.IfShowFileDialog = false;
        DWObject.LoadImage(DynamLib.getRealPath(ImgArr), OnSuccess, OnFailure);
    }
}

//--------------------------------------------------------------------------------------
//************************** Edit Image ******************************

//--------------------------------------------------------------------------------------
function btnShowImageEditor_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.ShowImageEditor();
}

function btnRotateRight_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.RotateRight(DWObject.CurrentImageIndexInBuffer);
    appendMessage('<b>Girar a la derecha: </b>');
    if (checkErrorString()) {
        return;
    }
}
function btnRotateLeft_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.RotateLeft(DWObject.CurrentImageIndexInBuffer);
    appendMessage('<b>Girar a la izquierda: </b>');
    if (checkErrorString()) {
        return;
    }
}

function btnRotate180_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.Rotate(DWObject.CurrentImageIndexInBuffer, 180, true);
    appendMessage('<b>Girar 180: </b>');
    if (checkErrorString()) {
        return;
    }
}

function btnMirror_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.Mirror(DWObject.CurrentImageIndexInBuffer);
    appendMessage('<b>Voltear: </b>');
    if (checkErrorString()) {
        return;
    }
}
function btnFlip_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.Flip(DWObject.CurrentImageIndexInBuffer);
    appendMessage('<b>Girar: </b>');
    if (checkErrorString()) {
        return;
    }
}

/*----------------------Crop Method---------------------*/
function btnCrop_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    if (_iLeft != 0 || _iTop != 0 || _iRight != 0 || _iBottom != 0) {
        DWObject.Erase(
            DWObject.CurrentImageIndexInBuffer,
            _iLeft, _iTop, _iRight, _iBottom
        );
        _iLeft = 0;
        _iTop = 0;
        _iRight = 0;
        _iBottom = 0;
        appendMessage('<b>Cortar: </b>');
        if (checkErrorString()) {
            return;
        }
        return;
    } else {
    appendMessage("<b>Cortar: </b>fallo. Por favor seleccione el area que desea cortar.<br />");
    }
	DWObject.MouseShape = false;
}

/*----------------------Change Mouse Shape--------------------*/
function changeMouseShape(newShape){
	if(DWObject){ 
		DWObject.MouseShape = newShape;
		}
		return;
}

/*----------------Change Image Size--------------------*/
function btnChangeImageSize_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    switch (document.getElementById("ImgSizeEditor").style.visibility) {
        case "visible": document.getElementById("ImgSizeEditor").style.visibility = "hidden"; break;
        case "hidden": document.getElementById("ImgSizeEditor").style.visibility = "visible"; break;
        default: break;
    }
    document.getElementById("ImgSizeEditor").style.top = ds_gettop(document.getElementById("btnChangeImageSize")) + document.getElementById("btnChangeImageSize").offsetHeight + "px";
    document.getElementById("ImgSizeEditor").style.left = ds_getleft(document.getElementById("btnChangeImageSize")) - 30 + "px";

    var iWidth = DWObject.GetImageWidth(DWObject.CurrentImageIndexInBuffer);
    if (iWidth != -1)
        document.getElementById("img_width").value = iWidth;
    var iHeight = DWObject.GetImageHeight(DWObject.CurrentImageIndexInBuffer);
    if (iHeight != -1)
        document.getElementById("img_height").value = iHeight;
}
function btnCancelChange_onclick() {
    document.getElementById("ImgSizeEditor").style.visibility = "hidden";
}

function btnChangeImageSizeOK_onclick() {
    document.getElementById("img_height").className = "";
    document.getElementById("img_width").className = "";
    if (!re.test(document.getElementById("img_height").value)) {
        document.getElementById("img_height").className += " invalid";
        document.getElementById("img_height").focus();
        appendMessage("Por favor ingrese una <b>altura</b> valida.<br />");
        return;
    }
    if (!re.test(document.getElementById("img_width").value)) {
        document.getElementById("img_width").className += " invalid";
        document.getElementById("img_width").focus();
        appendMessage("Por favor ingrese un <b>ancho</b> valido.<br />");
        return;
    }
    DWObject.ChangeImageSize(
        DWObject.CurrentImageIndexInBuffer,
        document.getElementById("img_width").value,
        document.getElementById("img_height").value,
        document.getElementById("InterpolationMethod").selectedIndex + 1
    );
    appendMessage('<b>Cambiar tamaño de la imagen: </b>');
    if (checkErrorString()) {
        document.getElementById("ImgSizeEditor").style.visibility = "hidden";
        return;
    }
}
//--------------------------------------------------------------------------------------
//************************** Save Image***********************************
//--------------------------------------------------------------------------------------
function btnSave_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    var i, strimgType_save;
    var NM_imgType_save = document.getElementsByName("imgType_save");
    for (i = 0; i < 5; i++) {
        if (NM_imgType_save.item(i).checked == true) {
            strimgType_save = NM_imgType_save.item(i).value;
            break;
        }
    }
    DWObject.IfShowFileDialog = true;
    var _txtFileNameforSave = document.getElementById("txt_fileNameforSave");
    _txtFileNameforSave.className = "";
    var bSave = false;

    var strFilePath = "C:\\" + _txtFileNameforSave.value + "." + strimgType_save;

    var OnSuccess = function() {
        appendMessage('<b>Guardar Imagen: </b>');
        checkErrorStringWithErrorCode(0, "Exitoso.");
    };

    var OnFailure = function(errorCode, errorString) {
        checkErrorStringWithErrorCode(errorCode, errorString);
    };

    var _chkMultiPageTIFF_save = document.getElementById("MultiPageTIFF_save");
    var vAsyn = false;
    if (strimgType_save == "tif" && _chkMultiPageTIFF_save.checked) {
        vAsyn = true;
        if ((DWObject.SelectedImagesCount == 1) || (DWObject.SelectedImagesCount == DWObject.HowManyImagesInBuffer)) {
            bSave = DWObject.SaveAllAsMultiPageTIFF(strFilePath, OnSuccess, OnFailure);
        }
        else {
            bSave = DWObject.SaveSelectedImagesAsMultiPageTIFF(strFilePath, OnSuccess, OnFailure);
        }
    }
    else if (strimgType_save == "pdf" && document.getElementById("MultiPagePDF_save").checked) {
        vAsyn = true;
        if ((DWObject.SelectedImagesCount == 1) || (DWObject.SelectedImagesCount == DWObject.HowManyImagesInBuffer)) {
            bSave = DWObject.SaveAllAsPDF(strFilePath, OnSuccess, OnFailure);
        }
        else {
            bSave = DWObject.SaveSelectedImagesAsMultiPagePDF(strFilePath, OnSuccess, OnFailure);
        }
    }
    else {
        switch (i) {
            case 0: bSave = DWObject.SaveAsBMP(strFilePath, DWObject.CurrentImageIndexInBuffer); break;
            case 1: bSave = DWObject.SaveAsJPEG(strFilePath, DWObject.CurrentImageIndexInBuffer); break;
            case 2: bSave = DWObject.SaveAsTIFF(strFilePath, DWObject.CurrentImageIndexInBuffer); break;
            case 3: bSave = DWObject.SaveAsPNG(strFilePath, DWObject.CurrentImageIndexInBuffer); break;
            case 4: bSave = DWObject.SaveAsPDF(strFilePath, DWObject.CurrentImageIndexInBuffer); break;
        }
    }

    if (vAsyn == false) {
        if (bSave)
            appendMessage('<b>Guardar Imagen: </b>');
        if (checkErrorString()) {
            return;
        }
    }
}


/*----------------------Zoom Method---------------------*/
function btnZoomIn_onclick(){
	DWObject.SetViewMode(-1,-1);
	var temp = DWObject.Zoom;
	DWObject.IfFitWindow = false;
	DWObject.Zoom = temp * 1.5;
}

function btnZoomOt_onclick(){
	DWObject.SetViewMode(-1,-1);
	var temp = DWObject.Zoom;
	DWObject.IfFitWindow = false;
	DWObject.Zoom = temp * 0.5;
}

/*----------------------- Move Method -------------------------*/
var flag = 0;
var iCurrent, iTarget;
        function moveImage() {
            if (flag == 0) {
                iCurrent = DWObject.CurrentImageIndexInBuffer;
                flag = 1;
            }
            else if (flag == 1) {
                iTarget = DWObject.CurrentImageIndexInBuffer;
                DWObject.MoveImage(iCurrent, iTarget);
                flag = 0;
            }
            updatePageInfo();
        }

//--------------------------------------------------------------------------------------
//************************** Upload Image***********************************
//--------------------------------------------------------------------------------------
function btnUpload_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    var i, strHTTPServer, strActionPage, strImageType;

    var _txtFileName = document.getElementById("txt_fileName");
    _txtFileName.className = "";
  
    //DWObject.MaxInternetTransferThreads = 5;
    strHTTPServer = location.hostname;
    DWObject.IfSSL = DynamLib.detect.ssl;
    var _strPort = location.port == "" ? 80 : location.port;
    if (DynamLib.detect.ssl == true)
        _strPort = location.port == "" ? 443 : location.port;
    DWObject.HTTPPort = _strPort;
    
    
    var CurrentPathName = unescape(location.pathname); // get current PathName in plain ASCII	
    var CurrentPath = CurrentPathName.substring(0, CurrentPathName.lastIndexOf("/") + 1);
    strActionPage = CurrentPath + "SaveToFile.php";
    var redirectURLifOK = CurrentPath + "online_demo_list.php";
    for (i = 0; i < 4; i++) {
        if (document.getElementsByName("ImageType").item(i).checked == true) {
            strImageType = i + 1;
            break;
        }
    }

    var nUploadType = -1;
    var uploadfilename = _txtFileName.value + "." + document.getElementsByName("ImageType").item(i).value;

    var OnSuccess = function(httpResponse) {
        appendMessage('<b>Upload: </b>');
        checkErrorStringWithErrorCode(0, "Exitoso.");
        if (strActionPage.indexOf("SaveToFile") != -1) {
            alert("La imagen fue enviada al servidor")//if save to file.
        }// else {
        //    window.location.href = redirectURLifOK;
        //}
    };

    var OnFailure = function(errorCode, errorString, httpResponse) {
        checkErrorStringWithErrorCode(errorCode, errorString, httpResponse);
    };
    
    if (strImageType == 2 && document.getElementById("MultiPageTIFF").checked) {
        if ((DWObject.SelectedImagesCount == 1) || (DWObject.SelectedImagesCount == DWObject.HowManyImagesInBuffer)) {
            nUploadType = 4;
            DWObject.HTTPUploadAllThroughPostAsMultiPageTIFF(
                strHTTPServer,
                strActionPage,
                uploadfilename,
                OnSuccess, OnFailure
            );
        }
        else {
            nUploadType = 5;
            DWObject.HTTPUploadThroughPostAsMultiPageTIFF(
                strHTTPServer,
                strActionPage,
                uploadfilename,
                OnSuccess, OnFailure
            );
        }
    }
    else if (strImageType == 4 && document.getElementById("MultiPagePDF").checked) {
    if ((DWObject.SelectedImagesCount == 1) || (DWObject.SelectedImagesCount == DWObject.HowManyImagesInBuffer)) {
        nUploadType = 6;
            DWObject.HTTPUploadAllThroughPostAsPDF(
                strHTTPServer,
                strActionPage,
                uploadfilename,
                OnSuccess, OnFailure
            );
        }
        else {
            nUploadType = 7;
            DWObject.HTTPUploadThroughPostAsMultiPagePDF(
                strHTTPServer,
                strActionPage,
                uploadfilename,
                OnSuccess, OnFailure
            );
        }
    }
    else {
        nUploadType = strImageType;
        DWObject.HTTPUploadThroughPostEx(
            strHTTPServer,
            DWObject.CurrentImageIndexInBuffer,
            strActionPage,
            uploadfilename,
            strImageType,
            OnSuccess, OnFailure
        );
    }
}

//--------------------------------------------------------------------------------------
//************************** Navigator functions***********************************
//--------------------------------------------------------------------------------------

function btnFirstImage_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.CurrentImageIndexInBuffer = 0;
    updatePageInfo();
}

function btnPreImage_wheel() {
    if (DWObject.HowManyImagesInBuffer != 0)
        btnPreImage_onclick()
}

function btnNextImage_wheel() {
    if (DWObject.HowManyImagesInBuffer != 0)
        btnNextImage_onclick()
}

function btnPreImage_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    else if (DWObject.CurrentImageIndexInBuffer == 0) {
        return;
    }
    DWObject.CurrentImageIndexInBuffer = DWObject.CurrentImageIndexInBuffer - 1;
    updatePageInfo();
}
function btnNextImage_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    else if (DWObject.CurrentImageIndexInBuffer == DWObject.HowManyImagesInBuffer - 1) {
        return;
    }
    DWObject.CurrentImageIndexInBuffer = DWObject.CurrentImageIndexInBuffer + 1;
    updatePageInfo();
}


function btnLastImage_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.CurrentImageIndexInBuffer = DWObject.HowManyImagesInBuffer - 1;
    updatePageInfo();
}

function btnRemoveCurrentImage_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.RemoveAllSelectedImages();
    if (DWObject.HowManyImagesInBuffer == 0) {
        document.getElementById("DW_TotalImage").value = DWObject.HowManyImagesInBuffer;
        document.getElementById("DW_CurrentImage").value = "";
        return;
    }
    else {
        updatePageInfo();
    }
}


function btnRemoveAllImages_onclick() {
    if (!checkIfImagesInBuffer()) {
        return;
    }
    DWObject.RemoveAllImages();
    document.getElementById("DW_TotalImage").value = "0";
    document.getElementById("DW_CurrentImage").value = "";
}
function setlPreviewMode() {
    var varNum = parseInt(document.getElementById("DW_PreviewMode").selectedIndex + 1);
    var btnCrop = document.getElementById("btnCrop");
    if (btnCrop) {
        var tmpstr = btnCrop.src;
        if (varNum > 1) {
            tmpstr = tmpstr.replace('Crop.', 'Crop.');
            btnCrop.src = tmpstr;
            btnCrop.onclick = function() { };
        }
        else {
            tmpstr = tmpstr.replace('Crop.', 'Crop.');
            btnCrop.src = tmpstr;
            btnCrop.onclick = function() { btnCrop_onclick(); };
        }
    }

    DWObject.SetViewMode(varNum, varNum);
    if (Dynamsoft.Lib.env.bMac) {
        return;
    }
    else if (document.getElementById("DW_PreviewMode").selectedIndex != 0) {
        DWObject.MouseShape = true;
    }
    else {
        DWObject.MouseShape = false;
    }
}

//--------------------------------------------------------------------------------------
//*********************************radio response***************************************
//--------------------------------------------------------------------------------------
function rdTIFFsave_onclick() {
    var _chkMultiPageTIFF_save = document.getElementById("MultiPageTIFF_save");
    _chkMultiPageTIFF_save.disabled = false;
    _chkMultiPageTIFF_save.checked = false;

    var _chkMultiPagePDF_save = document.getElementById("MultiPagePDF_save");
    _chkMultiPagePDF_save.checked = false;
    _chkMultiPagePDF_save.disabled = true;
}
function rdPDFsave_onclick() {
    var _chkMultiPageTIFF_save = document.getElementById("MultiPageTIFF_save");
    _chkMultiPageTIFF_save.checked = false;
    _chkMultiPageTIFF_save.disabled = true;

    var _chkMultiPagePDF_save = document.getElementById("MultiPagePDF_save");
    _chkMultiPagePDF_save.disabled = false;
    _chkMultiPagePDF_save.checked = false;
}
function rdsave_onclick() {
    var _chkMultiPageTIFF_save = document.getElementById("MultiPageTIFF_save");
    _chkMultiPageTIFF_save.checked = false;
    _chkMultiPageTIFF_save.disabled = true;

    var _chkMultiPagePDF_save = document.getElementById("MultiPagePDF_save");
    _chkMultiPagePDF_save.checked = false;
    _chkMultiPagePDF_save.disabled = true;
}
function rdTIFF_onclick() {
    var _chkMultiPageTIFF = document.getElementById("MultiPageTIFF");
    _chkMultiPageTIFF.disabled = false;
    _chkMultiPageTIFF.checked = false;

    var _chkMultiPagePDF = document.getElementById("MultiPagePDF");
    _chkMultiPagePDF.checked = false;
    _chkMultiPagePDF.disabled = true;
}
function rdPDF_onclick() {
    var _chkMultiPageTIFF = document.getElementById("MultiPageTIFF");
    _chkMultiPageTIFF.checked = false;
    _chkMultiPageTIFF.disabled = true;
    
    var _chkMultiPagePDF = document.getElementById("MultiPagePDF");
    _chkMultiPagePDF.disabled = false;
    _chkMultiPagePDF.checked = false;

}
function rd_onclick() {
    var _chkMultiPageTIFF = document.getElementById("MultiPageTIFF");
    _chkMultiPageTIFF.checked = false;
    _chkMultiPageTIFF.disabled = true;
    
    var _chkMultiPagePDF = document.getElementById("MultiPagePDF");
    _chkMultiPagePDF.checked = false;
    _chkMultiPagePDF.disabled = true;
}



//--------------------------------------------------------------------------------------
//************************** Dynamic Web TWAIN Events***********************************
//--------------------------------------------------------------------------------------

function Dynamsoft_OnPostTransfer() {
	var currentIndex = DWObject.CurrentImageIndexInBuffer;
	var MARGIN = 6;
	DWObject.BlankImageMaxStdDev = 20;
	DWObject.Crop(currentIndex,MARGIN,MARGIN,DWObject.GetImageWidth(currentIndex),DWObject.GetImageHeight(currentIndex)-MARGIN);
	if(DWObject.IsBlankImageExpress(currentIndex)){
		DWObject.RemoveImage(currentIndex);
	}
    updatePageInfo();
}

/*function Dynamsoft_OnPostTransfer() {
    updatePageInfo();
}*/

function Dynamsoft_OnPostLoadfunction(path, name, type) {
    updatePageInfo();
}

function Dynamsoft_OnPostAllTransfers() {
    updatePageInfo();
    checkErrorString();
}

function Dynamsoft_OnMouseClick(index) {
    updatePageInfo();
}

function Dynamsoft_OnMouseRightClick(index) {
    // To add
}


function Dynamsoft_OnImageAreaSelected(index, left, top, right, bottom) {
    _iLeft = left;
    _iTop = top;
    _iRight = right;
    _iBottom = bottom;
	DWObject.MouseShape = false;
}

function Dynamsoft_OnImageAreaDeselected(index) {
    _iLeft = 0;
    _iTop = 0;
    _iRight = 0;
    _iBottom = 0;
}

function Dynamsoft_OnMouseDoubleClick() {
    return;
}


function Dynamsoft_OnTopImageInTheViewChanged(index) {
    DWObject.CurrentImageIndexInBuffer = index;
    updatePageInfo();
}

function Dynamsoft_OnGetFilePath(bSave, count, index, path, name) {
}

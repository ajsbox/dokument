
function OnWebTwainNotFoundOnWindowsCallback(ProductName, InstallerUrl) {
    var ObjString = [
		'<div class="dwt-box-title">',
		' El Plug-in no ha sido instalado</div>',
		'<ul>',
		'<li>Si ya instalo el plug-in, por favor espere unos segundos para iniciarlo.</li>',
		'<li>Si no ha instalado el plug-in, por favor haga clic en el boton para descargarlo. ',
		'Usted debe instalar el plugin manualmente una vez descargado.</li>',
		'</ul>',
		'<p class="dwt-red">Si aun visualiza este dialogo despues de instalar el plugin, reinicie su navegador.</p>',
		'<a id="dwt-btn-install" target="_blank" href="',
		InstallerUrl,
		'" onclick="Dynamsoft_OnClickInstallButton()"><div class="dwt-button"></div></a>',
		];

	Dynamsoft.WebTwainEnv.ShowDialog(392, 310, ObjString.join(''));
}

function OnWebTwainNotFoundOnMacCallback(ProductName, InstallerUrl) {
    var ObjString =
        [
		'<div class="dwt-box-title">',
		' El Plug-in no ha sido instalado</div>',
		'<ul>',
		'<li>Por favor haga clic en el boton para descargarlo e instalarlo.</li>',
		'</ul>',
		'<p class="dwt-red">Si aun visualiza este dialogo despues de instalar el plugin, reinicie su navegador.</p>',
		'Si esta usando Safari 5.0, contactenos</a>.',
		'<a id="dwt-btn-install" target="_blank" href="',
		InstallerUrl,
		'" onclick="Dynamsoft_OnClickInstallButton()"><div class="dwt-button"></div></a>',
		];

	Dynamsoft.WebTwainEnv.ShowDialog(392, 277, ObjString.join(''));
}

function OnWebTwainOldPluginNotAllowedCallback(ProductName) {
    var ObjString = [
		'<div class="dwt-box-title">',
		' El Plug-in no se puede ejecutar en este sitio.</div>',
		'<ul>',
		'<li>Por favor haga clic en "<b>Siempre ejecutar en este sitio</b>" cuando el browser le pregunte "',
		ProductName,
		' El Plugin necesita su permiso para ejecutarse", luego <a href="javascript:void(0);" style="color:blue" class="ClosetblCanNotScan">ciarre</a> este dialogo ò reinicie el navegador y vuelva a intentarlo.</li>',
		'</ul>'];

	Dynamsoft.WebTwainEnv.ShowDialog(392, 227, ObjString.join(''));
}

function OnWebTwainNeedUpgradeCallback(ProductName, InstallerUrl){
	var ObjString = ['<div class="dwt-box-title"></div>',
		'<div style="font-size: 15px;">',
		'Esta aplicacion esta usando una version mas actualizada que su copia local. Por favor descargue y actualice el plugin.',
		'</div>',
		'<a id="dwt-btn-install" target="_blank" href="',
		InstallerUrl,
		'" onclick="Dynamsoft_OnClickInstallButton()"><div class="dwt-button"></div></a>',
		'<p class="dwt-red">Por favor reinicie su navegador despues de instalar el plugin.</p>'];

	Dynamsoft.WebTwainEnv.ShowDialog(392, 227, ObjString.join(''));
}

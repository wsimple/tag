<?php
if(!isset($_GET['minify'])){
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-Type: text/javascript');
	// echo str_repeat("\n",7);
}
if(false){ ?><script><?php } ?>

(function($){
	var opc={
		type:'POST',
		dataType:'json',
		xhrFields:{withCredentials:true},
		data:{'CROSSDOMAIN':'1'}
	};
	// if(LOCAL||location.host.match(/localhost/)){
	// 	opc.xhrFields={withCredentials:true};
	// 	opc.data={'CROSSDOMAIN':'1'};
	// }else
	// 	opc.headers={'SOURCEFORMAT':'mobile'};
	$.ajaxSetup(opc);
})(jQuery);

<?php if(isset($_GET['minify'])){ ?>
CORDOVA='2.7.0';

(function(document,window,$){
	document.addEventListener('deviceready',function(){
		document.addEventListener('online',function(){
			loginState();
			if(is.app=='steroids') openVideo=function(url){
				window.open(url,'_blank','location=yes');
			};
		},false);
	},false);
	//iOS
	if(is.iOS){
		if(is.app!='steroids') openVideo=function(url,layer){
			window.open(url,'_blank','location=yes');
//			console.log('video='+url);
//			$(layer).html(
//				'<iframe src="'+url+'" width="250" seamless></iframe>'
//			).popup('open');
		};
	}
	//android
	if(is.android){
		if(is.app!='steroids') openVideo=function(url){
			navigator.app.loadUrl(url, { openExternal:true });
		};
		document.addEventListener('deviceready',function(){
			var num=0,timer;
			$(document).on('pageshow',function(){ num=0; });
			document.addEventListener('backbutton',function(){
				//se cierra la aplicacion al hacer mas de 3 toques rapidos al boton de regreso
				clearTimeout(timer);
				timer=setTimeout(function(){num=0;},3000);
				if(++num>3||window.location.href.match(/[\/=](?:index|timeline)|\/app\/(?:\?|$)/i))
					navigator.app.exitApp();
				else if(offline){
					myDialog('#errorDialog',lang.noConnection);
				}else goBack();
			},false);
			//boton de menu
			document.addEventListener('menubutton',function(){
				if(window.menuVisible())
					window.hideMenu();
				else
					window.showMenu();
			},false);
			//se ha perdido la conexion a internet
			document.addEventListener('offline',function(){
				offline=true;
			},false);
			//conexion a internet restaurada
			document.addEventListener('online',function(){
				offline=false;
				loginState();
			},false);
			//bateria baja (nivel critico)
			window.addEventListener('batterycritical',function(info){
				if(info.isPlugged) return;
				myDialog('#errorDialog',lang.batterylow);
				//navigator.app.exitApp();
			},false);
		},false);
		App=function(){};
		/**
		 * Load the url into the webview or into new browser instance.
		 *
		 * @param url           The URL to load
		 * @param props         Properties that can be passed in to the activity:
		 *      wait: int                           => wait msec before loading URL
		 *      loadingDialog: "Title,Message"      => display a native loading dialog
		 *      loadUrlTimeoutValue: int            => time in msec to wait before triggering a timeout error
		 *      clearHistory: boolean              => clear webview history (default=false)
		 *      openExternal: boolean              => open in a new browser (default=false)
		 *
		 * Example:
		 *      navigator.app.loadUrl("http://server/myapp/index.html", {wait:2000, loadingDialog:"Wait,Loading App", loadUrlTimeoutValue: 60000});
		 */
		App.prototype.loadUrl = function(url, props) {
			window.PhoneGap.exec(null, null, "App", "loadUrl", [url, props]);
		};

		/**
		 * Cancel loadUrl that is waiting to be loaded.
		 */
		App.prototype.cancelLoadUrl = function() {
			window.PhoneGap.exec(null, null, "App", "cancelLoadUrl", []);
		};

		/**
		 * Go to previous page displayed.
		 * This is the same as pressing the backbutton on Android device.
		 */
		App.prototype.backHistory = function() {
			window.PhoneGap.exec(null, null, "App", "backHistory", []);
		};

		/**
		 * Exit and terminate the application.
		 */
		App.prototype.exitApp = function() {
			return window.PhoneGap.exec(null, null, "App", "exitApp", []);
		};

		App.prototype.getPhoto = function(device,onSuccess,onFail) {
			switch(device) {
				// camera
				case 1:
					navigator.camera.getPicture(onSuccess, onFail,
						{quality: 60, destinationType: navigator.camera.DestinationType.DATA_URL} );
				break;
				// camera edit
				case 2:
					try {
						navigator.camera.getPicture(onSuccess, onFail,
						{quality: 60, destinationType: navigator.camera.DestinationType.DATA_URL,
						allowEdit: true});
					} catch(e){
						myDialog("#singleDialog", 'Error: '+e);
					}
				break;
				// photo libary
				case 3:
					navigator.camera.getPicture(onSuccess, onFail,
						{quality: 60, destinationType: navigator.camera.DestinationType.DATA_URL,
						sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY});
				break;
				// photo album
				case 4:
					navigator.camera.getPicture(onSuccess, onFail,
						{quality: 60, destinationType: navigator.camera.DestinationType.FILE_URI,
						sourceType: navigator.camera.PictureSourceType.SAVEDPHOTOALBUM});
				break;
			}
		};
		navigator.app=new App();
		history.defaultBack=history.back;
		history.back=function(num){
			navigator.app.backHistory(num||-1);
		};
	}
})(document,window,jQuery);
<?php }

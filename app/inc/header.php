<?php
	include '../includes/config.php';
	include RELPATH.'includes/session.php';
	include RELPATH.'includes/functions.php';
if(!( #validamos si el usuario tiene permitido ingresar a la app
	preg_match('/ipad|android|ipod|iphone/i',$_SERVER['HTTP_USER_AGENT'])||
	$_SERVER['SERVER_NAME']=='localhost'||
	isset($_GET['minify'])||
	is_debug()
)){
	header('Location: ..');
	die();
}
	include RELPATH.'class/wconecta.class.php';
	include RELPATH.'includes/languages.config.php';
	//<meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,width=device-width,height=device-height,target-densitydpi=device-dpi" />
?><!DOCTYPE html>
<html><head>
	<link rel="apple-touch-startup-image" href="css/smt/bg.png"/>
	<link rel="apple-touch-icon" href="css/smt/screen-icon.png"/>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=0"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/><meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<title>Tagbum Mobile</title>
	<link rel="icon" href="css/smt/favicon.ico" type="image/png"/>
	<link rel="stylesheet" href="css/jquery.mobile.custom.css"/>
	<link rel="stylesheet" href="css/jquery.mobile-1.3.2.css"/>
	<link rel="stylesheet" href="css/jquery.Jcrop.css"/>
	<link rel="stylesheet" href="css/iScroll.css"/>
	<link rel="stylesheet" href="css/ptrScroll.css"/>
	<link rel="stylesheet" href="css/farbtastic.css"/>
	<link rel="stylesheet" href="css/seemytag.css"/>
	<link rel="stylesheet" href="css/colorPicker.css"/>
<?php if(isset($_GET['minify'])){
?>	<script src="<?=isset($_GET['steroids'])?'http://localhost/cordova.js':'cordova.js'?>"></script>
	<!--<script src="http://debug.build.phonegap.com/target/target-script-min.js#82ad4bcc-195f-11e3-af04-22000a98b3d6"></script><!-- -->
<?php } ?>
	<script src="js/core/const.js"></script>
	<script src="js/core/md5.js"></script>
	<script src="js/core/jquery-1.10.2.min.js"></script>
	<script src="js/core/jquery.cookie.js"></script>
	<script src="js/core/jquery.local.js"></script>
	<script src="js/core/session.js"></script>
	<script src="js/core/jquery.mobile-1.3.2.js"></script>
	<script src="js/core/jquery.form.js"></script>
	<script src="js/core/jquery.textCounter.js"></script>
	<script src="js/core/jquery.Jcrop.js"></script>
	<script src="js/core/iScroll.js"></script>
	<script src="js/core/jScroll.js"></script>
	<script src="js/core/farbtastic.js"></script>
	<script src="js/core/colorPicker.js"></script>
<?php if(isset($_GET['minify'])){
?>	<script src="js/min.js"></script>
<?php }else{
?>	<script src="js/path.js"></script>
	<script src="js/console.js"></script>
	<script src="js/device.js"></script>
	<script src="js/base.js"></script>
	<script src="js/funciones.js"></script>
<?php } ?>
<!-- Facebook Conversion Code for Tagbum -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6018767308743', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6018767308743&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
<!-----------------------------End facebook ---------------------------->
<meta name="alexaVerifyID" content="8YYp0pS3o8YkprRdkaeFqitio5Q"/>
</head><body><?php if(!isset($_GET['minify']))include_once("analyticstracking.php"); ?>
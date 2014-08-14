<?php
	include '../includes/config.php';
	include RELPATH.'includes/session.php';
	include RELPATH.'includes/functions.php';
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
?>	<script src="js/app.js"></script>
	<script src="js/min.js"></script>
<?php }else{
?>	<script src="js/path.js"></script>
	<script src="js/console.js"></script>
	<script src="js/device.js"></script>
	<script src="js/base.js"></script>
	<script src="js/funciones.js"></script>
<?php } ?>
</head><body>
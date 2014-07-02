<?php
session_start();
if($_SESSION['ws-tags']['ws-user']['id']!=''&&$_COOKIE['__LOGGED__']==''){
	setcookie('__logged__',md5($_SESSION['ws-tags']['ws-user']['time']),time()+60*60*24*30,'/');
}
if($_SESSION['ws-tags']['ws-user']['id']==''&&$_COOKIE['__LOGGED__']!=''){
	setcookie('__logged__',NULL,time()-3600,'/');
}
if(	!strpos($_SERVER['PHP_SELF'],'carouselTags.view.php')	&&	!strpos($_SERVER['PHP_SELF'],'registerTabs.view.php') &&
	!strpos($_SERVER['PHP_SELF'],'resendPassword.view.php')	&&	!$_SESSION['ws-tags']['ws-user']['id'] &&
	$_POST['asyn']=='1' ){
		die('1');
}
?>
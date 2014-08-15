<?php
session_start();
if($_SESSION['ws-tags']['ws-user']['id']!=''&&$_COOKIE['__logged__']==''){
	setcookie('__logged__',md5($_SESSION['ws-tags']['ws-user']['time']),time()+60*60*24*30,'/');
	if($_SERVER['SERVER_NAME'])setcookie('__logged__',md5($_SESSION['ws-tags']['ws-user']['time']),time()+60*60*24*30,'/');
}
if($_SESSION['ws-tags']['ws-user']['id']==''&&$_COOKIE['__logged__']!=''){
	setcookie('__logged__',NULL,time()-3600,'/');
}
#guardar id en las cookies para uso en subdominios. Solo en el dominio especificado.
$__dominio='tagbum.com';
if(isset($_SESSION['ws-tags'])&&strpos($_SERVER['SERVER_NAME'],$__dominio)!==FALSE){
	#regex dominio: /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/
	$__dominio='.'.$__dominio;
	if($_SESSION['ws-tags']['ws-user']['id']!=''&&$_COOKIE['__uid__']=='')
		setcookie('__uid__',md5($_SESSION['ws-tags']['ws-user']['id']),time()+60*30,'/',$__dominio);
	if($_SESSION['ws-tags']['ws-user']['id']==''&&$_COOKIE['__uid__']!='')
		setcookie('__uid__',NULL,time()-3600,'/',$__dominio);
}
unset($__dominio);

if(	!strpos($_SERVER['PHP_SELF'],'carouselTags.view.php')	&&	!strpos($_SERVER['PHP_SELF'],'registerTabs.view.php') &&
	!strpos($_SERVER['PHP_SELF'],'resendPassword.view.php')	&&	!$_SESSION['ws-tags']['ws-user']['id'] &&
	$_POST['asyn']=='1' ){
		die('1');
}
?>
<?php
session_start();
$__val=$_SESSION['ws-tags']['ws-user']['id']!=''?md5($_SESSION['ws-tags']['ws-user']['id']):NULL;
$__code=$_SESSION['ws-tags']['ws-user']['code']!=''?$_SESSION['ws-tags']['ws-user']['code']:NULL;
$__t=$__val?60*30:-3600;
$__time=time()+$__t;
if( $_SESSION['ws-tags']['ws-user']['id']=='' xor $_COOKIE['__logged__']=='' ){
	setcookie('__logged__',$__val?md5($_SESSION['ws-tags']['ws-user']['time']):NULL,$__time,'/');
}
#guardar cookies para subdominios. Solo en el dominio principal.
$__dominio='tagbum.com';
if(isset($_SESSION['ws-tags'])&&strpos($_SERVER['SERVER_NAME'],$__dominio)!==FALSE){
	$__dominio='.'.$__dominio;
}else{
	$__dominio='';
}
setcookie('__uid__',$__val?$__val:NULL,$__time,'/',$__dominio);
setcookie('__code__',$__code?$__code:NULL,$__time,'/',$__dominio);
unset($__dominio,$__val,$__code,$__t,$__time);

if(	!strpos($_SERVER['PHP_SELF'],'carouselTags.view.php')	&&	!strpos($_SERVER['PHP_SELF'],'registerTabs.view.php') &&
	!strpos($_SERVER['PHP_SELF'],'resendPassword.view.php')	&&	!$_SESSION['ws-tags']['ws-user']['id'] &&
	$_POST['asyn']=='1' ){
		die('1');
}
#regex dominios: /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/
session_write_close();
?>
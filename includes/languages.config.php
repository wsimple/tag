<?php
$actual='';
if($_GET['lang']!=''){
	$actual=$_GET['lang'];
}else{
	//si llego el lenguaje y el usuario esta logueado
	if ($_SESSION['ws-tags']['ws-user']['language']!=''){
		$_SESSION['ws-tags']['language']=$_SESSION['ws-tags']['ws-user']['language'];
	}elseif($_POST['lang']!=''){
		$_SESSION['ws-tags']['language']=$_POST['lang'];
		@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
	}
	//detecta el idioma segun la ip del usuario si no esta logeado
	if($_GET['lang']==''&&empty($_SESSION['ws-tags']['language'])){
		if(preg_match('/^(localhost|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){
			$_SESSION['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
		}else{
			$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
			$locale=CON::getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
			$_SESSION['ws-tags']['language']=$locale;
		}
		$actual=$_SESSION['ws-tags']['language'];
	}
}
if(!$actual) $actual='en';
$lang=array();
include(RELPATH."language/$actual.php");
foreach ($lang as $key => $value){
	define($key, $value);
}
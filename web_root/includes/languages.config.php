<?php
$actual='';
if(!empty($_GET['lang'])){
	$actual=$_GET['lang'];
}else{
	//si llego el lenguaje y el usuario esta logueado
	if(!empty($_SESSION['ws-tags']['ws-user']['language'])){
		$_SESSION['ws-tags']['language']=$_SESSION['ws-tags']['ws-user']['language'];
	}elseif(!empty($_POST['lang'])){
		$_SESSION['ws-tags']['language']=$_POST['lang'];
		@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
	}
	//detecta el idioma segun la ip del usuario si no esta logeado
	if(empty($_GET['lang'])&&empty($_SESSION['ws-tags']['language'])){
		if(preg_match('/^(local\.|localhost|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){
			$_SESSION['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
		}else{
			$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
			$locale=CON::getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
			$_SESSION['ws-tags']['language']=$locale;
		}
	}
	$actual=$_SESSION['ws-tags']['language'];
}
if(!$actual) $actual='en';

include($config->relpath."language/en.php");
$_tmp=$lang;
include($config->relpath."main/lang/en.php");
$_tmp=array_merge($_tmp,$lang);
if($actual!='en'){
	include($config->relpath."language/$actual.php");
	$_tmp=array_merge($_tmp,$lang);
	include($config->relpath."main/lang/$actual.php");
	$_tmp=array_merge($_tmp,$lang);
}
$lang=$_tmp;
unset($_tmp);
foreach ($lang as $key => $value){
	define($key, $value);
}
#guardar cookies para lenguaje de cometchat
$__dominio='tagbum.com';
if(isset($_SESSION['ws-tags'])&&strpos($_SERVER['SERVER_NAME'],$__dominio)!==FALSE){
	$__dominio='.'.$__dominio;
}else{
	$__dominio='';
}
setcookie('cc_lang',$actual,time()+60*30,'/',$__dominio);
unset($__dominio);

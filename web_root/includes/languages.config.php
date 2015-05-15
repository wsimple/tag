<?php
include_once('session.php');
$actual='';
if(!empty($_GET['lang'])){
	$actual=$_GET['lang'];
}else{
	with_session(function(&$sesion){
		//si llego el lenguaje y el usuario esta logueado
		if(!empty($sesion['ws-tags']['ws-user']['language'])){
			$sesion['ws-tags']['language']=$sesion['ws-tags']['ws-user']['language'];
		}elseif(!empty($_POST['lang'])){
			$sesion['ws-tags']['language']=$_POST['lang'];
			@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
		}
		//detecta el idioma segun la ip del usuario si no esta logeado
		if(empty($_GET['lang'])&&empty($sesion['ws-tags']['language'])){
			if(preg_match('/^(local\.|localhost|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){
				$sesion['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
			}else{
				$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
				$locale=CON::getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
				$sesion['ws-tags']['language']=$locale;
			}
		}
		$actual=$sesion['ws-tags']['language'];
	});
}
if(!$actual) $actual='en';

include(RELPATH."language/en.php");
$_tmp=$lang;
include(RELPATH."main/lang/en.php");
$_tmp=array_merge($_tmp,$lang);
if($actual!='en'){
	include(RELPATH."language/$actual.php");
	$_tmp=array_merge($_tmp,$lang);
	include(RELPATH."main/lang/$actual.php");
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

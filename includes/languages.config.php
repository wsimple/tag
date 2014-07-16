<?php
	//si llego el lenguaje y el usuario esta logueado
	if ($_SESSION['ws-tags']['ws-user']['language']!=''){
		$_SESSION['ws-tags']['language']=$_SESSION['ws-tags']['ws-user']['language'];
	}elseif($_POST['lang']!=''){
		$_SESSION['ws-tags']['language']=$_POST['lang'];
		@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
	}
	$lang=array();
	//detecta el idioma segun la ip del usuario si no esta logeado
	if($_GET['lang']==''&&empty($_SESSION['ws-tags']['language'])){
		if(LOCAL){
			$_SESSION['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}else{
			$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
			$locale=CON::getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
			$_SESSION['ws-tags']['language']=$locale;
		}
		if($_SESSION['ws-tags']['language']=='') $_SESSION['ws-tags']['language']='en';
	}
	include(RELPATH.'language/'.$_SESSION['ws-tags']['language'].'.php');
	foreach ($lang as $key => $value) {
		define($key, $value);
	}
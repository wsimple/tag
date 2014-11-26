<?php
#mientras se este migrando a modelo-vista-controlador, se trabaja paralelo con la interfaz antigua. desactivar esta variable para trabajar unicamente con MVC
$migrating=TRUE;

#si la web se llama con "www." se remueve el subdominio
if(substr($_SERVER['SERVER_NAME'],0,4)=='www.'){
	header('Location: http://'.substr($_SERVER['SERVER_NAME'],4).$_SERVER['REQUEST_URI']);
	die();
}
if(isset($_COOKIE['_DEBUG_']))
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
else
	error_reporting(0);
#validamos la existencia del archivo de seguridad
if(!is_file('.security/security.php')){ include 'security.php'; }
include('.security/security.php');

#carga automatica de clases permitidas
function __autoload($classname){
	$path='main';
	$folder='controllers';
	$filename=strtolower($classname);
	if(strpos($classname,'_model')){ $folder='models'; $filename=str_replace('_model','',$filename); }
	if(strpos($classname,'_lib')){ $folder='libraries'; $filename=str_replace('_lib','',$filename); }
	$file="$path/$folder/$filename.php";
	if(is_file($file)) include_once $file;
	elseif(is_file("$path/core/$classname.php")) include_once("$path/core/$classname.php");
	elseif(TAG_functions::is_debug()) die("No existe la clase '$classname' ($folder).");
	else die('Page not found.');
}

#mobile detection
$detect=new Mobile_Detect;
if($detect->isMobile()){
	#cambiar entre version full y mobile
	if(isset($_GET['mobileVersion'])){
		setcookie('__FV__',NULL,NULL,'/',NULL,false,false);
		@header('Location:app/');
	}
	if(isset($_GET['fullVersion'])){
		setcookie('__FV__','1',time()+60*60*24*30,'/',NULL,false,false);
		@header('Location:.');
	}
	if($detect->isTablet()){
		if(!$_COOKIE['__FV__']){
			header('Location:app/');
			die();
		}
	}else{
		header('Location:app/');
		die();
	}
}

if($migrating){
	include('includes/config.php');
	if(!is_file('main/controllers/'.$section.'.php')){
		include('index_old.php');
		die();
	}
}

include 'main/core/globals.php';

global $section,$params,$control;
$control=new $section($params);
if(method_exists($control,'__onload')) $control->__onload($params);
$function='index';
if($control->use_methods()&&count($params)>0){
	if(method_exists($control,$params[0])) $function=array_shift($params);
	elseif(method_exists($control,'error')) $function='error';
	elseif(TAG_functions::is_debug()) die("No existe el metodo '{$params[0]}' ($section).");
	else die('Page not found.');
}
TAG_functions::call_method($control,$function,$params);

<?php
#//probando commit mientras se este migrando a modelo-vista-controlador, se trabaja paralelo con la interfaz antigua. desactivar esta variable para trabajar unicamente con MVC
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
	elseif(is_file("$path/plugins/$classname.php")) include_once("$path/plugins/$classname.php");
	elseif(TAG_functions::is_debug()) die("No existe la clase '$classname' ($folder).");
	else die('Page not found.');
}

include 'main/core/globals.php';

global $control;
$section=URI::section();
$params=URI::params();
$control=new $section($params);
if(method_exists($control,'__onload')) $control->__onload($params);
$function='index';
if($control->use_methods()&&count($params)>0&&method_exists($control,$params[0]))
	$function=array_shift($params);
if(!method_exists($control,$function)){
	if(method_exists($control,'error'))
		$function='error';
	else{
		if(TAG_functions::is_debug()) die("No existe el metodo '{$params[0]}' (".$section.")");
		else die('Page not found.');
	}
}
TAG_functions::call_method($control,$function,$params);

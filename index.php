<?php
#si la web se llama con "www." se remueve el subdominio
if(substr($_SERVER['SERVER_NAME'],0,4)=='www.'){
	header('Location: http://'.substr($_SERVER['SERVER_NAME'],4).$_SERVER['REQUEST_URI']);
	die();
}
#validamos la existencia del archivo de seguridad
if(!is_file('.security/security.php')){ include 'security.php'; }
include('.security/security.php');

#mientras se este migrando a modelo-vista-controlador, se trabaja paralelo con la interfaz antigua
$migrating=TRUE;
if($migrating){
	include('includes/config.php');
	if(!is_file('main/controllers/'.$section.'.php')){
		include('index_old.php');
		die();
	}
}

include 'main/core/globals.php';

function __autoload($classname){
	#carga automatica de clases permitidas
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

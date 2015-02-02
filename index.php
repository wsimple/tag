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
#precarga de mvc
include('autoload.php');
#mobile detection
APP::detect();

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

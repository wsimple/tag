<?php
if(str_replace(DIRECTORY_SEPARATOR,'/',__FILE__)==str_replace(DIRECTORY_SEPARATOR,'/',$_SERVER['SCRIPT_FILENAME'])){
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
$__tmp__=substr($_SERVER['SCRIPT_FILENAME'],strlen(preg_replace('/[^\/]*$/','',str_replace(DIRECTORY_SEPARATOR,'/',__FILE__))));
$__tmp__=substr_count($__tmp__,'/');
$__tmp__=!$__tmp__?'./':str_repeat('../',$__tmp__);
if(!defined('RELPATH')) define('RELPATH',$__tmp__);
unset($__tmp__);

#validamos la existencia del archivo de seguridad
if(!is_file(RELPATH.'.security/security.php')){ include RELPATH.'security.php'; }
include(RELPATH.'.security/security.php');

#carga automatica de clases permitidas
function __autoload($classname){
	$path=RELPATH.'main';
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

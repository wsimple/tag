<?php
include 'includes/config.php';
$migrating=TRUE;#mientras este en migracion, trabaja paralelo con la interfaz antigua
// $migrating=FALSE;#activar para forzar solo interfaz nueva
if(!$migrating||is_file($config->relpath.'main/controllers/'.$section.'.php')){
	#temporales (transicion)
	include('includes/session.php');
	include('includes/functions.php');
	include('includes/languages.config.php');
	include('class/forms.class.php'); 
	#fin temporales (transicion)
	function __autoload($classname){
		$path=$config->relpath.'main';
		$folder='controllers';
		$filename=strtolower($classname);
		if(strpos($classname,'_model')){ $folder='models'; $filename=str_replace('_model','',$filename); }
		if(strpos($classname,'_lib')){ $folder='libraries'; $filename=str_replace('_lib','',$filename); }
		$file="$path/$folder/$filename.php";
		if(is_file($file)) include_once $file;
		elseif(is_file("$path/core/$classname.php")) include_once "$path/core/$classname.php";
		elseif(is_debug()) die("No existe la clase '$classname' ($folder).");
		else die('Page not found.');
	}
	global $control;
	$control=new $section();//TAG_functions::class_loader('controls',$section);
	if(method_exists($control,'__onload')) TAG_functions::call_method($control,'__onload');
	$function='index';
	if(count($params)>0) $function=array_shift($params);
	TAG_functions::call_method($control,$function,$params);
	die();
}

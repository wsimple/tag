<?php
require 'includes/functions.php';

$main='.';
$formats='/\.(mp4)$/i';

$uri=$_SERVER['REQUEST_URI'];
if(strpos($uri,$_SERVER['SCRIPT_NAME'])!==FALSE) $uri=end(split($_SERVER['SCRIPT_NAME'],$uri));
if($_GET['path']||preg_match('/^\/([\-0-9a-zA-Z_]+).*/',$uri)){
	$usrpath=$_COOKIE['__code__']?$_COOKIE['__code__'].'/':'';
	$type=$_GET['path']?$_GET['path']:preg_replace('/^\/([\-0-9a-zA-Z_]+).*/','$1',$uri);
	$path=array();
	switch($type){
		case 'videos': if($_COOKIE['__uid__']) $path[]="videos/$usrpath";
		case 'pending': $path[]='pending/';break;
	}
	$imgs=array();
	// foreach($path as $folder){
	for($i=0;$i<count($path);$i++){
		$folder=$main.'/'.$path[$i];
		if(($dir=@opendir($folder))){
			while(($file=readdir($dir))!==false){
				if(is_dir("$folder/$file")){ if($file!='.'&&$file!='..') $path[]=$path[$i].$file.'/'; }
				elseif(preg_match($formats,$file)) $imgs[$folder][]=$file;
			}
			closedir($dir);
		}
	}
	json_headers();
	die(jsonp($imgs));
}

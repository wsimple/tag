<?php
require 'inc/functions.php';

$formats='/\.(jpe?g|gif|png)$/i';

if($_GET['list']||preg_match('/list_/',$_SERVER['REQUEST_URI'])){
	$usrpath=$_COOKIE['__code__']?$_COOKIE['__code__'].'/':'';
	$type=$_GET['list']?$_GET['list']:preg_replace('/.*list_([\-0-9a-zA-Z_]+).*/','$1',$_SERVER['REQUEST_URI']);
	$path=array();
	switch($type){
		case 'templates': $path=array('templates/defaults/'); if($_COOKIE['__uid__']) $path[]="templates/$usrpath";break;
	}
	$imgs=array();
	// foreach($path as $folder){
	for($i=0;$i<count($path);$i++){
		$folder='img/'.$path[$i];
		if(($dir=opendir($folder))){
			while(($file=readdir($dir))!==false){
				if(is_dir("$folder/$file")){ if($file[0]!='.') $path[]=$path[$i]."/$file"; }
				elseif(preg_match($formats,$file)) $imgs[$folder][]=$file;
			}
			closedir($dir);
		}
	}
	json_headers();
	die(jsonp($imgs));
}

<?php
$formats='/\.(gif|png|jpe?g)$/';
$url='.'.array_shift(explode('?',$_SERVER['REQUEST_URI']));
// if(!preg_match($formats,$url)) die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI'].', '.$url);
if(!preg_match($formats,$url)) die();
$file='not-found.jpg';
if(file_exists($url)&&is_file($url))
	$file=$url;
$finfo=finfo_open(FILEINFO_MIME_TYPE);
header('Content-Type: '.finfo_file($finfo,$file));
include($file);

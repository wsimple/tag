<?php
//die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI']);
$url=array_shift(split('?',$_SERVER['REQUEST_URI']));
if(!preg_match('/\.[a-z0-9]{3,}$/',$url)) die();
$img='img/not-found.jpg';
if(file_exists('img/'.$url)&&is_file('img/'.$url))
	$img='img/'.$url;
header('Content-Type: '.image_type_to_mime_type(exif_imagetype($img)));
include($img);

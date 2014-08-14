<?php
//die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI']);
if(!preg_match('/\.[a-z0-9]{3,}$/',$_SERVER['REQUEST_URI'])) die();
$img='img/not-found.jpg';
if(file_exists('img/'.$_SERVER['REQUEST_URI'])&&is_file('img/'.$_SERVER['REQUEST_URI']))
	$img='img/'.$_SERVER['REQUEST_URI'];
header('Content-Type: '.image_type_to_mime_type(exif_imagetype($img)));
include($img);

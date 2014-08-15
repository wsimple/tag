<?php
$formats='/\.(gif|png|jpe?g)$/';
$url=array_shift(explode('?',$_SERVER['REQUEST_URI']));
// if(!preg_match('/\.[a-z0-9]{3,}$/',$url)) die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI'].', '.$url);
if(!preg_match($formats,$url)) die();
$file='not-found.jpg';
$finfo=finfo_open(FILEINFO_MIME_TYPE);
header('Content-Type: '.finfo_file($finfo,$file));
// header('Content-Type: '.image_type_to_mime_type(exif_imagetype($file)));
include($file);

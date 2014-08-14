<?php
//die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI']);
$url=array_shift(split('?',$_SERVER['REQUEST_URI']));
if(!preg_match('/\.[a-z0-9]{3,}$/',$url)) die();
$img='not-found.jpg';
header('Content-Type: '.image_type_to_mime_type(exif_imagetype($img)));
include($img);

<?php
//die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI']);
$img='not-found.jpg';
header('Content-Type: '.image_type_to_mime_type(exif_imagetype($img)));
include($img);

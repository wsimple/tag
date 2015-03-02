<?php

$photo = '0d631032b9e751accbd6b85aa848b2bc/62f28d4555f3e012e1b6066486a1ccf0.jpg';

$path  = "http://68.109.244.201/img/publicity/0d631032b9e751accbd6b85aa848b2bc/";       //ruta para crear dir
//$photo = $_SESSION['ws-tags']['ws-user'][code].'/'.md5(str_replace(' ', '', $_FILES[publi_img][name])).'.jpg';
//$photo_= md5(str_replace(' ', '', $_FILES[publi_img][name])).'.jpg';

// //existencia de la folder
// if( !is_dir ($path) ) {
// 	$old = umask(0);
// 	mkdir($path,0777);
// 	umask($old);
// 	$fp=fopen($path.'index.html',"w");
// 	fclose($fp);
// }// is_dir


FTPupload('publicity/'.$photo);


?>
<?php
include_once('config.php');
include_once('resizeimage.inc.php');
function relative_path($url){
	global $config;
	return str_replace($config->dominio,$config->relpath,$url);
}
$tipo=$_GET['tipo'];
$porc=$_GET['porc'];
if(!$_GET['tipo']){$tipo=1;$porc=100;}
$img='';
if($section=='image'&&count($params)>0) $img=$config->imgserver.'/img/'.implode('/',$params);
if(isset($_GET['img'])) $img=$_GET['img'];
$img=relative_path($img);

$rimg=new RESIZEIMAGE($img);
switch($tipo){
	case 1:	$rimg->resize_percentage($porc);break;
	case 2: $rimg->resize($_GET['ancho'], $_GET['alto']);break;
	case 3: $rimg->resize_limitwh($_GET['ancho'], 0);
}
header('Content-Type: image/jpeg');
$rimg->close();
die();

/*
<!--
	+-----------------------------------------------------------+
	|															|
	| 	Desarrollado por: Gustavo A. Ocanto C.					|
	| 	Modificado por: Willem F. Franco C.						|
	| 	Email: gustavoocanto@gmail.com / info@websarrollo.com	|
	| 	Telefono: 0414-428.42.30 / 0245-511.38.40				|
	| 	Web: http://www.gustavoocanto.com						|
	|        http://www.websarrollo.com							|
	| 	Valencia, Edo. Carabobo - Venezuela						|
	|															|
	+-----------------------------------------------------------+
-->
*/

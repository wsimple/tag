<?php
include 'header.json.php';
$myId=$_SESSION['ws-tags']['ws-user']['id'];
// if(!$myId) die('{}');

if(count($_FILES)){
	$files=array();
	foreach($_FILES as $file){
		if($file['error']==0&&rename($file['tmp_name'],"../tmp/$myId-".$file['name'])){
			$files[]="/tmp/$myId-".$file['name'];
		}
	}
}

#### control de pruebas - solamente devuelve el formato json todos los datos que recibe
die(jsonp(array(
	'urls'=>$files,
	'get'=>$_GET,
	'post'=>$_POST,
	'cookies'=>$_COOKIE,
	'FILES'=>$_FILES,
)));

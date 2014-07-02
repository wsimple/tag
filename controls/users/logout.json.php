<?php
include '../header.json.php';
logout();
$res=array(
	'logout'=>true,
	'nocookies'=>isset($_GET['nocookies']),
	'msg'=>'logged out'
);
die(jsonp($res));
?>

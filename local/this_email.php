<?php  
	session_start();
	$path='../web_root';
	if(isset($_GET['clear'])) unset($_SESSION['ws-tags']['email']);
	if(isset($_GET['type'])){
		include_once("$path/includes/config.php");
		include_once("$path/class/wconecta.class.php");
		include_once("$path/includes/functions.php");
		include_once("$path/includes/languages.config.php");
		notifications($_GET['friend'],$_GET['source'],$_GET['type']);
	}
	if(empty($_SESSION['ws-tags']['email'])) die('No Email');
	echo 'TEST:<hr>'.$_SESSION['ws-tags']['email'];

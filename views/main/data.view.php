<?php
	session_start();
	include ("../../includes/functions.php");
	include ("../../includes/config.php");
	include ("../../class/wconecta.class.php");
	include ("../../includes/languages.config.php");
	include ("../../class/class.phpmailer.php");
		
	$query = mysql_query("SELECT ".$_GET[xs]." AS dato FROM dialogs WHERE id = '1'") or die (mysql_error());
	$array = mysql_fetch_assoc($query);
//	if ($_GET['mo'])
//		$array['dato']= json_encode ($array['dato']);
	
	constant($array['dato']);
	echo $array['dato'];
?>

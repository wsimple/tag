<?php
	session_start();
	include ('../../includes/functions.php');
	if(quitar_inyect()){	
		include ('../../includes/config.php');
		include ('../../class/class.phpmailer.php');
		include ('../../class/wconecta.class.php');
		include ('../../includes/languages.config.php');
		include ('../../class/validation.class.php');
		if ($_GET['c']!=''){
		    $GLOBALS['cn']->query('DELETE FROM comments WHERE id = "'.$_GET['c'].'"');
		}
	}//if quitar inyect
?>

<?php
	session_start();
	include ("../../includes/functions.php");
	include ("../../includes/config.php");
	include ("../../class/wconecta.class.php");
	include ("../../includes/languages.config.php");
	
	switch ($_GET['type']){
		case '1': 
			$body = '
				<div class="font_size5">
				<div>'.MAINMENU_POINTS_1.'</div>
				</div>
			';
		break;
	
		case '2':
			$body = '
				<div class="font_size5"><div>'.MAINMENU_POINTS_2.'</div></div>
			';
		break;
	}
	echo $body;
?>

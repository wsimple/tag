<?php
	session_start();

	include "../../includes/config.php";
	include "../../class/wconecta.class.php";
	include '../../includes/functions.php';

	switch ($_GET[action]) {
		case 'showBuyedClicks':
			echo factorPublicity(2, $_GET[investment]);
			break;
		case 'showedClicks':
			echo factorPublicityPoints(2, $_GET[investment]);
			break;
	}
?>

<?php

//Seleccion del menu Groups
$sc = $_GET['sc'];

	switch ($sc) {
	case 1:
		include("groups/myGroups.php");
		break;
	default:
		include("groups/allGroups.php");
		break;
	}
?>

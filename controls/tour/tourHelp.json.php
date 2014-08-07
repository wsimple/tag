<?php
	include '../header.json.php';
	$tourHelp=$GLOBALS['cn']->query('
		SELECT id FROM tour_section WHERE sectionTour="'.$_GET['section'].'" AND active = 1'
	);

	$r = (mysql_num_rows($tourHelp)!=0)?'si':'no';

	die(jsonp($r));
?>

<?php
	include ('../../includes/session.php');
	include ('../../includes/config.php');
	include ('../../includes/functions.php');
	include ('../../class/wconecta.class.php');

	$vector = isset($_GET['normal']) ? 0 : 1;
	$GLOBALS['cn']->query('
		UPDATE users SET
			view_type_timeline = "'.$vector.'"
		WHERE id = "'.$_SESSION['ws-tags']['ws-user']['id'].'"
	');
	$_SESSION['ws-tags']['ws-user']['view_type_timeline'] = $vector;
?>
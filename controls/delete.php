<?php
	include '../includes/session.php';
	include '../includes/config.php';
	include '../class/wconecta.class.php';
	include '../class/validation.class.php';
	include '../includes/functions.php';
	include '../includes/languages.config.php';

	switch ($_GET['type']) {
		case 'bc':
			$GLOBALS['cn']->query('DELETE FROM business_card WHERE md5(id)="'.$_GET['id'].'"');
			$GLOBALS['cn']->query('UPDATE users SET pay_bussines_card=pay_bussines_card-1 WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
			$GLOBALS['cn']->query('UPDATE tags SET id_business_card="" WHERE md5(id_business_card)="'.$_GET['id'].'"');
		break;
	}

	echo 'ok';


?>
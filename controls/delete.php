<?php
	
	include '../includes/config.php';
	include '../includes/functions.php';
	include '../includes/session.php';
	include '../class/wconecta.class.php';
	include '../class/validation.class.php';
	include '../includes/languages.config.php';

	// echo $_GET['id'].'<br>';
	// echo $_GET['type'].'<br>';
	// echo $_GET['opc'];

	switch ($_GET['type']) {
		case 'bc':
			$GLOBALS['cn']->query('DELETE FROM business_card WHERE md5(id)="'.$_GET['id'].'"');
			$GLOBALS['cn']->query('UPDATE users SET pay_bussines_card=pay_bussines_card-1 WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
			$GLOBALS['cn']->query('UPDATE tags SET id_business_card="" WHERE md5(id_business_card)="'.$_GET['id'].'"');
		break;
	}

	if ($_GET['opc']=='dp') {
		echo 'ok';
		$GLOBALS['cn']->query('DELETE FROM users_publicity WHERE md5(id)="'.$_GET['id'].'" and id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');

		$id_banner = campo('banners','md5(id_publi)',$_GET['id'],'id');

		if ($id_banner!='') {
			$GLOBALS['cn']->query('DELETE FROM banners WHERE id ="'.$id_banner.'"');
			$GLOBALS['cn']->query('DELETE FROM banners_picture WHERE id_banner ="'.$id_banner.'"');
		}
		


	}else{
		echo 'A error occurred. Try again later';
	}

	
// }


?>
<?php
	include '../../includes/session.php';
	include ("../../includes/functions.php");

	if (quitar_inyect())
	{
		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");

		switch( $_GET[action] ) {

			case "play":
				$GLOBALS['cn']->query("	UPDATE users_publicity
										SET status = '1'
										WHERE md5(id) = '".$_GET[id_publicity]."';");
			break;

			case "pause":
				$GLOBALS['cn']->query("	UPDATE users_publicity
										SET status = '5'
										WHERE md5(id) = '".$_GET[id_publicity]."';");
			break;
		}
	}
?>
<?php

	if( $_GET[idPubli]!='' ) {

		include ("../../includes/config.php");
		include ("../../includes/functions.php");
		include ("../../class/wconecta.class.php");

		//borramos la foto de la publicidad
		$result = $GLOBALS['cn']->query("SELECT picture FROM users_publicity WHERE md5(id) = '".$_GET[idPubli]."'");
		$result = mysql_fetch_assoc($result);
		deleteFTP($dato[picture], 'publicity');

		//borramos el dato de la tabla
		$GLOBALS['cn']->query("DELETE FROM users_publicity WHERE md5(id) = '".$_GET[idPubli]."'");
	}
?>
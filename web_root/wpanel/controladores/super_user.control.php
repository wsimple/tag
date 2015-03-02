<?php

	session_start();
	include ('../../includes/config.php');
	include ('../../includes/conexion.php');

	if( isset($_GET['make']) )
		mysql_query("UPDATE users SET super_user='1' WHERE md5(id) = '".$_GET['id']."';");
	else
		mysql_query("UPDATE users SET super_user='0' WHERE md5(id) = '".$_GET['id']."';");

	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../index.php?url=vistas/super_users.view.php">';
?>

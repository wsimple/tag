<?php
	include ('../../../includes/config.php');
	include ('../../../class/wconecta.class.php');
	include ('../../../includes/conexion.php');
	include ('../../../includes/functions.php');
	include ('../../../class/class.phpmailer.php');

	$query = mysql_query("SELECT * FROM ".$_GET[tabla]." WHERE sent = '0'") or die (mysql_error());

	while ($array = mysql_fetch_assoc($query)){

		if (sendMail(formatMail('Prueba',600), EMAIL_NO_RESPONDA, 'Tagbum.com', 'Asunto', $array[email], '../../../'))
			$query = mysql_query('UPDATE '.$_GET[tabla].' SET sent = "1" WHERE id = "'.$array[id].'"') or die (mysql_error());

	}

?>
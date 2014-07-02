<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

	include('../../includes/session.php');
	include('../../includes/functions.php');
	include('../../includes/funciones_images.php');
	include('../../includes/functions.json.php');

	if(quitar_inyect()){

		include ('../../includes/config.php');
		include ('../../class/wconecta.class.php');
		include('../../includes/languages.config.php');

		$preferences=$GLOBALS['cn']->query("SELECT id, id_preference, detail FROM preference_details WHERE id = '".$_GET[p]."'");
		$prefe=mysql_fetch_assoc($preferences);

		die(jsonp(array(
			'id' => $prefe['id'],
			'id_prefe' => $prefe['id_preference'], 
			'detail' => htmlentities(formatoCadena($prefe['detail']))
		)));
	}//quitar_inyect
?>
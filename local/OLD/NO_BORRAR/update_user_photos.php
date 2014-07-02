<?php
	include 'class/validation.class.php';
	include 'includes/functions.php';
	include 'includes/config.php';
	include 'class/wconecta.class.php';

	$result = $GLOBALS['cn']->query('SELECT	profile_image_url,
											md5(CONCAT(id,"_",email,"_",id)) AS code
									 FROM	users');

	while( $user = mysql_fetch_assoc($result) ) {

		copyFTP( $user[profile_image_url], 'users', 'users', '', generateThumbPath($user[profile_image_url]), $user[code] );
	}
?>

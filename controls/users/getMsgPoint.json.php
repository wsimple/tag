<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

	include '../../includes/session.php';
	include '../../includes/functions.php';
	include '../../includes/config.php';
	include '../../class/wconecta.class.php';
	include '../../includes/languages.config.php';

	$poins1="You can get more points: sharing tags by publishing, redistributing or sending email.
			Accumulate at least 5000 points before December 31 and you can participate in the draw for gift cards of $ 500.";

	$poins1="You will be able change your points by services and products at Tagbum, the more points you earn, the more things you can get.";

	$res=$poins1.'|'.$poins1;

	die(jsonp($res));
?>

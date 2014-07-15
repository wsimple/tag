<?php
	include 'includes/config.php';
	include 'includes/session.php';
	include 'includes/functions.php';
	logout();
?>
<html>
	<head>
		<title><?=TITLE?></title>
		<script>if('localStorage' in window && window['localStorage']!==null) localStorage.removeItem('logged');</script>
	</head>
	<body onload="document.location='.';">
	</body>
</html>
<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
   	include('includes/session.php');
   	include('includes/functions.php');
	$url=!$_SESSION['ws-tags']['ws-user']||$_SESSION['ws-tags']['ws-user']['logins_count']>1?base_url():base_url('welcome');
	@header("Location:$url");

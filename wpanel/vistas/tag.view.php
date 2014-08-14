<?php
	$action=$_GET['action'];
	$tag=$_GET['tag'];
	if($_SESSION['ws-tags']['ws-user']['email']!='wpanel@tagbum.com')
		$user=$GLOBALS['cn']->queryRow('SELECT * FROM users WHERE email="wpanel@tagbum.com"');
	if(count($user)==0&&$_SESSION['ws-tags']['ws-user']['email']!='wpanel@tagbum.com'){
		$user=$GLOBALS['cn']->queryRow('SELECT * FROM users WHERE email="wpanel@tagbum.com"');
	}
	if(count($user)>0) createSession($user);
	header("Location: ../#$action?tag=$tag&wpanel");
?>

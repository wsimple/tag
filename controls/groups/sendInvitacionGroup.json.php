<?php
include '../header.json.php';

if((isset($_GET[idUser]))&&!existe('users_groups', 'id_user', " WHERE md5(id_user) = '".$_GET[idUser]."' AND md5(id_group) = '".$_GET[idGroup]."'")){
	$id_group = campo('groups', 'md5(id)', $_GET[idGroup], 'id');
	$id_user = campo('users', 'md5(id)', $_GET[idUser], 'id');
	$GLOBALS['cn']->query("
		INSERT INTO users_groups SET
			id_group = '".$id_group."',
			id_user  = '".$id_user."',
			date_update = now()
    ");
	notifications($id_user,$id_group,6);
	$out = '1';
	die(jsonp($out));
}else{
	$out = '0';
	die(jsonp($out));
}
?>

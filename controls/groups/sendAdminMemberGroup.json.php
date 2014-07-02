<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

	include '../../includes/session.php';
	include '../../includes/functions.php';
	include '../../includes/config.php';
	include '../../class/wconecta.class.php';


	$users = $GLOBALS['cn']->query("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id)) = '".$_GET['code']."'");
	$user  = mysql_fetch_assoc($users);

	$mnUseGrp = $user[id];



if((isset($_GET[idUser]))&&existe('users_groups', 'id_user', " WHERE md5(id_user) = '".$_GET[idUser]."' AND md5(id_group) = '".$_GET[idGroup]."'")){

	$id_group = campo('groups', 'md5(id)', $_GET[idGroup], 'id');
	$id_user = campo('users', 'md5(id)', $_GET[idUser], 'id');

	$GLOBALS['cn']->query("UPDATE users_groups SET is_admin = '1', date_update = now() WHERE id_group = '".$id_group."' AND id_user = '".$id_user."'");


	$idCreator = $GLOBALS['cn']->query("SELECT id_creator FROM groups WHERE id_creator = '".$mnUseGrp."'");
	$idCreatorGroup = mysql_num_rows($idCreator);

	if ($idCreatorGroup!=0){

		$adminUserGrp = $GLOBALS['cn']->query('
				SELECT id_user
				FROM users_groups
				WHERE id_group = "'.$id_group.'" AND is_admin = "1"

		');
		 $adminUserGrps = mysql_fetch_assoc($adminUserGrp);
		 $GLOBALS['cn']->query("UPDATE groups SET id_creator = '".$adminUserGrps['id_user']."' WHERE id = '".$id_group."'");
	}
	$GLOBALS['cn']->query("DELETE FROM users_groups WHERE id_group = '".$id_group."' AND id_user = '".$mnUseGrp."'");
	$out = '1';
	die(jsonp($out));
}else{
	$out = '0';
	die(jsonp($out));
}


?>

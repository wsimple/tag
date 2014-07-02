<?php
include '../header.json.php';

	$user=$GLOBALS['cn']->queryRow('SELECT id FROM users WHERE md5(concat(id,"_",email,"_",id)) = "'.$_GET['code'].'"');
	$uid = $user['id'];
	//es o no admin
	$query = $GLOBALS['cn']->queryRow('
		SELECT
			g.id_group AS id_group,
			g.id_user AS id_user,
			g.is_admin AS is_admin
		FROM users_groups g
		WHERE md5(g.id_group)="'.$_GET['idGroup'].'" AND g.id_user="'.$uid.'"
	');
	$isAdmin = ($query['is_admin']!='0');
	//cantidad de admin
	$query = $GLOBALS['cn']->queryRow('
		SELECT COUNT(id) AS num
		FROM users_groups
		WHERE md5(id_group)="'.$_GET['idGroup'].'" AND is_admin = 1
	');
	$admins=$query['num'];
	//si es admin y es el unico admin, se borra todo
	if($isAdmin&&$admins==1&&isset($_GET['act'])){
		$GLOBALS['cn']->query('DELETE FROM users_groups WHERE md5(id_group) = "'.$_GET['idGroup'].'"'); //se borran las miembros
		$GLOBALS['cn']->query('DELETE FROM groups WHERE md5(id) = "'.$_GET['idGroup'].'"'); //se borra el grupo
		$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE md5(id_source) = "'.$_GET['idGroup'].'" AND id_type = "6"'); //se borran las notificaciones tipo grupos
		$tagsErases = $GLOBALS['cn']->query('SELECT id FROM tags WHERE md5(id_group) ="'.$_GET['idGroup'].'"'); //se consultan las tags del grupo
		while ($tagsErase = mysql_fetch_assoc($tagsErases)){//se borran las notificaciones del tags del grupo en cuestion
			$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE id_type = "10" AND id_source = "'.$tagsErase['id'].'"');
		}
		$GLOBALS['cn']->query('DELETE FROM tags WHERE md5(id_group)="'.$_GET['idGroup'].'"');//se borran las tags del grupo
	}
	//si es admin y hay otros, se borra toda la informacion del usuario en el grupo
	if($isAdmin&&$admins>1){
		$GLOBALS['cn']->query('DELETE FROM users_groups WHERE md5(id_group)="'.$_GET['idGroup'].'" AND id_user="'.$uid.'"');
		//se borran las notificaciones tipo grupo (grupo en cuestion) del miembro borrado
		$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE md5(id_source)="'.$_GET['idGroup'].'" AND id_friend="'.$uid.'" AND id_type = "6"');
		//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion) del miembro borrado
		$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE md5(id_source)="'.$_GET['idGroup'].'" AND id_friend="'.$uid.'" AND id_type="10"');
		$idCreator=$GLOBALS['cn']->query('SELECT id_creator FROM groups WHERE id_creator="'.$uid.'"');
		$idCreatorGroup=mysql_num_rows($idCreator);
		if($idCreatorGroup!=0){
			$adminUserGrp=$GLOBALS['cn']->query('
				SELECT id_user
				FROM users_groups
				WHERE id_group="'.$_GET['idGroup'].'" AND is_admin="1"
			');
			$adminUserGrps = mysql_fetch_assoc($adminUserGrp);
			$GLOBALS['cn']->query('UPDATE groups SET id_creator="'.$adminUserGrps['id_user'].'" WHERE id="'.$_GET['idGroup'].'"');
		}
	}
	//si no es admin
	if(!$isAdmin){
		$GLOBALS['cn']->query('DELETE FROM users_groups WHERE md5(id_group)="'.$_GET['idGroup'].'" AND id_user="'.$uid.'"');
		//se borran las notificaciones tipo grupo (grupo en cuestion) del miembro borrado
		$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE md5(id_source)="'.$_GET['idGroup'].'" AND id_friend="'.$uid.'" AND id_type="6"');
		//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion) del miembro borrado
		$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE md5(id_source)="'.$_GET['idGroup'].'" AND id_friend="'.$uid.'" AND id_type="10"');
	}
	die(jsonp(array(
		'verifyAdmin'	=> $isAdmin?'1':'0',//1 si es admin
		'onlyAdmin'		=> $admins>1?'0':'1',//1 si no hay mas de un admin
		'isAdmin'		=> $isAdmin,
		'admins'		=> $admins
	)));
?>

<?php
include '../header.json.php';
	if($_GET['idGroup']!=''){
		$res	= array();
		$users = $GLOBALS['cn']->query("SELECT id FROM users WHERE CONCAT(id,'_',email,'_',id) = '".$_GET['id']."'");
		$user  = mysql_fetch_array($users);
		$lstUsrs = $GLOBALS['cn']->query('
			SELECT id_user
			FROM users_groups
			WHERE md5(id_group)="'.$_GET['idGroup'].'" AND id_user != "'.$user['id'].'"
			GROUP BY id_user
		');
		$arrayMembersGroup = mysqlFetchAssocToArray($lstUsrs, 'id_user'); //array de miembros del grupo
		//_imprimir($arrayMembersGroup);
		if (count($arrayMembersGroup)>0){
			$idsNotIn='';
			foreach ($arrayMembersGroup as $id_menber) $idsNotIn .= "'".$id_menber."',";
			$friends=view_friends($user['id'],$_GET['like']," AND f.id_friend NOT IN (".rtrim($idsNotIn,',').")");
		}else{
			$friends=view_friends($user['id'],$_GET['like']);
		}
		while( $friend=mysql_fetch_assoc($friends) ) {
			$res[]=array(
				'photo'				=>FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend']),
				'name'				=>utf8_encode($friend['name_user']),
				'email'				=>$friend['email'],
				'followers_count'	=>$friend['followers_count'],
				'friends_count'		=>$friend['friends_count'],
				'country'			=>$friend['country'],
				'id'				=>$friend['id_friend']
			);
		}
		die(jsonp($res));
	}else{

		$res=array();
		$users=$GLOBALS['cn']->query("SELECT id FROM users WHERE CONCAT(id,'_',email,'_',id) = '".$_GET['id']."'");
		$user=mysql_fetch_array($users);
		$friends=view_friends($user['id'],$_GET['like']);
		while( $friend=mysql_fetch_assoc($friends) ) {
			$res[]=array(
				'photo'				=>getUserPicture($friend['code_friend'].'/'.$friend['photo_friend']),
				'name'				=>utf8_encode($friend['name_user']),
				'email'				=>$friend['email'],
				'followers_count'	=>$friend['followers_count'],
				'friends_count'		=>$friend['friends_count'],
				'country'			=>$friend['country'],
				'id'				=>$friend['id_friend']
			);
		}
		die(jsonp($res));
	}
?>

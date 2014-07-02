<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	include '../../includes/session.php';
	include '../../includes/functions.php';
	include '../../includes/config.php';
	include '../../class/wconecta.class.php';
	$users=$GLOBALS['cn']->query("SELECT id FROM users WHERE md5(CONCAT(id,'_',email,'_',id)) = '".$_GET['id']."'");
	$user=mysql_fetch_array($users);
	if($_GET['like']==''){
		$memberGroup = $GLOBALS['cn']->query("
			SELECT
				   g.id AS id,
				   CONCAT( u.name,  ' ', u.last_name ) AS name,
				   u.profile_image_url AS photo,
				   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code,
				   u.id AS id_user,
				   u.email,
				   u.followers_count,
				   u.friends_count,
				  (SELECT c.name FROM countries c WHERE c.id=u.country) AS country

			FROM  users_groups g
			INNER JOIN users u ON g.id_user = u.id
			WHERE md5(g.id_group) = '".$_GET['idGroup']."' AND u.id != '".$user['id']."'
			ORDER BY g.date DESC
		");
		$res=array();
		while( $friend = mysql_fetch_assoc($memberGroup) ) {
			$res[]=array(
				'photo'=>FILESERVER.getUserPicture($friend['code'].'/'.$friend['photo']),
				'name'=>utf8_encode($friend['name']),
				'email'=>$friend['email'],
				'followers_count'=>$friend['followers_count'],
				'friends_count'=>$friend['friends_count'],
				'country'=>$friend['country'],
				'id_user'=>$friend['id_user'],
				'id'=>$friend['id']
			);
		}
		die(jsonp($res));
	}else{
		$memberGroup = $GLOBALS['cn']->query("
			SELECT
			   g.id AS id,
			   CONCAT( u.name,  ' ', u.last_name ) AS name,
			   u.profile_image_url AS photo,
			   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code,
			   u.id AS id_user,
			   u.email,
			   u.followers_count,
			   u.friends_count,
			  (SELECT c.name FROM countries c WHERE c.id=u.country) AS country
			FROM  users_groups g
			INNER JOIN users u ON g.id_user = u.id
			WHERE md5(g.id_group) = '".$_GET['idGroup']."' AND u.id != '".$user['id']."' AND name LIKE '%".$_GET['like']."%'
			ORDER BY g.date DESC
		");
		$res=array();
		while( $friend = mysql_fetch_assoc($memberGroup) ) {
			$res[]=array(
				'photo'=>FILESERVER.getUserPicture($friend['code'].'/'.$friend['photo']),
				'name'=>utf8_encode($friend['name']),
				'email'=>$friend['email'],
				'followers_count'=>$friend['followers_count'],
				'friends_count'=>$friend['friends_count'],
				'country'=>$friend['country'],
				'id_user'=>$friend['id_user'],
				'id'=>$friend['id']
			);
		}
		die(jsonp($res));
	}
?>

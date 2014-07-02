<?php
include '../header.json.php';
$myId=$_SESSION['ws-tags']['ws-user']['id'];
$code=isset($_GET['code'])?$_GET['code']:$_SESSION['ws-tags']['ws-user']['code'];

	if(isset($_GET['picture'])){
		$user=$GLOBALS['cn']->queryRow('
			SELECT
				u.id,
				md5(u.id) AS uid,
				concat(u.name, " ", u.last_name) AS userName,
				u.profile_image_url AS picture
			FROM users u WHERE md5(CONCAT(u.id,"_",u.email,"_",u.id))="'.$code.'"
		');
		$user['code']=$code;
		$user['picture']="img/users/$code/".$user['picture'];
		$user['thumb']=FILESERVER.getUserPicture($user['picture'],'img/users/default.png');
		die(jsonp($user));
	}
	$sql='
		SELECT
			u.id,
			md5(u.id) AS uid,
			concat(u.name," ",u.last_name) AS userName,
			u.show_my_birthday,
			u.date_birth,
			u.tags_count AS numTags,
			u.profile_image_url AS picture,
			(SELECT name FROM countries WHERE id=u.country) AS country,
			u.type,
			u.friends_count AS friends,
			u.followers_count AS admirers,
			u.following_count AS admired,
			u.friends_count,u.followers_count,u.following_count
		FROM users u WHERE md5(CONCAT(u.id, "_", u.email, "_", u.id))="'.$code.'"
	';
	$user=$GLOBALS['cn']->queryRow($sql);
	$user['code']=$code;
	$user['userName']=utf8_encode(formatoCadena($user['userName']));
	$user['picture']="img/users/$code/".$user['picture'];
	$user['thumb']=FILESERVER.getUserPicture($user['picture'],'img/users/default.png');
	$user['imageUrl']=FILESERVER.getUserPicture($user['picture'],'img/users/default.png');//soporte para perfil viejo
	if($user['type']=='0'){
		if($user['show_my_birthday']==3)
			$user['birthday']='private';
		else
			$user['birthday']=maskBirthdayApp($user['date_birth'],$user['show_my_birthday']);
	}else{
		$user['birthday']=$user['date_birth'];
	}
	unset($user['date_birth']);
	$user['country']=trim($user['country'])!=''?$user['country']:'none';
	$sql='SELECT * FROM users_links WHERE md5(id_user)="'.intToMd5($myId).'" AND id_friend='.$user['id'];
	$query1=$GLOBALS['cn']->query($sql);
	$user['follow']=mysql_num_rows($query1)>0;
	$user['btnLink']=mysql_num_rows($query1)>0;//temporal (compativility)
	$sql='SELECT count(id) AS count FROM tags WHERE status=9 AND id_user='.$user['id'].' AND id_user=id_creator';
	$query2=$GLOBALS['cn']->queryRow($sql);
	$user['numPersTags']=$query2['count'];

	die(jsonp($user));
?>

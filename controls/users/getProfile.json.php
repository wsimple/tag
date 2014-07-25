<?php
include '../header.json.php';
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	$code=isset($_GET['code'])?$_GET['code']:$_SESSION['ws-tags']['ws-user']['code'];

	if(isset($_GET['picture'])){
		$user=CON::getRow('SELECT
								u.id,
								md5(u.id) AS uid,
								concat(u.name, " ", u.last_name) AS userName,
								u.profile_image_url AS picture
							FROM users u WHERE md5(CONCAT(u.id,"_",u.email,"_",u.id))=?',array($code));
		$user['code']=$code;
		$user['picture']="img/users/$code/".$user['picture'];
		$user['thumb']=getUserPicture($user['picture'],false);
		if (!$user['thumb']) $user['thumb']=DOMINIO.'img/users/default.png'; 
		else $user['thumb']=FILESERVER.$user['thumb'];
		die(jsonp($user));
	}
	$sql=safe_sql('SELECT
					u.id,
					md5(u.id) AS uid,
					concat(u.name," ",u.last_name) AS userName,
					u.show_my_birthday,
					u.date_birth,
					-- u.tags_count AS numTags,
					(SELECT count(t.id) FROM tags t WHERE t.id_user="2" AND t.status = 1) AS numTags,
					u.profile_image_url AS picture,
					(SELECT name FROM countries WHERE id=u.country) AS country,
					u.type,
					u.friends_count AS friends,
					u.followers_count AS admirers,
					u.following_count AS admired,
					u.friends_count,u.followers_count,u.following_count,
					(SELECT ul.id_user FROM users_links ul WHERE md5(ul.id_user)=? AND ul.id_friend=u.id) AS follow,
					(SELECT count(t.id) FROM tags t WHERE t.status=9 AND t.id_user=u.id AND t.id_user=t.id_creator) AS numPersTags
				FROM users u WHERE md5(CONCAT(u.id, "_", u.email, "_", u.id))=?',array(intToMd5($myId),$code));
	$user=CON::getRow($sql);
	$user['code']=$code;
	$user['userName']=utf8_encode(formatoCadena($user['userName']));
	$user['picture']="img/users/$code/".$user['picture'];
	$user['thumb']=getUserPicture($user['picture'],false);
	if (!$user['thumb']) $user['thumb']=DOMINIO.'img/users/default.png';
	else $user['thumb']=FILESERVER.$user['thumb'];
	$user['imageUrl']=getUserPicture($user['picture'],false);//soporte para perfil viejo
	if (!$user['imageUrl']) $user['imageUrl']=DOMINIO.'img/users/default.png';
	else $user['imageUrl']=FILESERVER.$user['imageUrl'];
	if($user['type']=='0'){
		if($user['show_my_birthday']==3) $user['birthday']='private';
		else $user['birthday']=maskBirthdayApp($user['date_birth'],$user['show_my_birthday']);
	}else{ $user['birthday']=$user['date_birth']; }
	unset($user['date_birth']);
	$user['country']=trim($user['country'])!=''?$user['country']:'none';
	$user['btnLink']=$user['follow'];//temporal (compativility)
	
	die(jsonp($user));
?>

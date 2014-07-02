<?php
@header('Content-Type: text/html; charset=ISO-8859-1');
/* <!--
	+ ------------------------------------------------ +
	|                                                  |
	|   Developed By: Websarrollo.com & Maoghost.com   |
	|   Copy Rights : Tagamation, LLc                  |
	|   Date        : 02/22/2011                       |
	|                                                  |
	+ ------------------------------------------------ +
--> */


function view_friends_json($id='',$like='',$notIn=''){

	$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : $id;

	dropViews(array('view_friends'));

	//los que el usuario sigue
	$friends = $GLOBALS['cn']->query('
		CREATE VIEW view_friends AS
			SELECT DISTINCT
				l.id_user,
				l.id_friend,
				u.screen_name,
				CONCAT(u.name, " ", u.last_name) AS name_user,
				u.profile_image_url  AS photo_friend,
				u.email,
				u.home_phone,
				u.mobile_phone,
				u.work_phone,
				md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend,
				u.followers_count,
				u.friends_count
			FROM users u INNER JOIN users_links l ON u.id=l.id_friend
			WHERE md5(l.id_user)="'.$user.'";
	');

	//amigos
	if($like!='') $like = 'AND f.name_user LIKE "%'.$like.'%"';

	$friends = $GLOBALS['cn']->query('
		SELECT	f.id_friend AS friend,
				f.name_user,
				f.photo_friend,
				f.code_friend,
				f.screen_name,
				f.followers_count,
				f.friends_count

		FROM view_friends f JOIN users_links u ON f.id_friend=u.id_user
		WHERE md5(u.id_friend) = "'.$user.'" '.$like.' '.$notIn.'
        ORDER BY f.name_user

		LIMIT 0, 50
	');

	return $friends;
}

// los que me siguen y no sigo
function followers_json($id='',$like='',$notIn=''){

	$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : $id;

	if($like!='') $like = 'AND (u.`name` LIKE "%'.$like.'%") OR (u.last_name LIKE "%'.$like.'%")';

	$followers = $GLOBALS['cn']->query('
		SELECT
			l.id_user AS friend,
			CONCAT(u.`name`, " ", u.last_name)  AS name_user,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend,
			u.screen_name,
			u.followers_count,
		    u.friends_count

		FROM users u JOIN users_links l ON u.id=l.id_user

		WHERE md5(l.id_friend) = "'.$user.'" '.$like.' '.$notIn.'

		ORDER BY CONCAT(u.`name`, " ", u.last_name)

		LIMIT 0, 50
	');

	return $followers;
}

//los que sigo y no me siguen
function following_json($id='',$like='',$notIn=''){
	$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : $id;

	if($like!='') $like = 'AND (u.`name` LIKE "%'.$like.'%") OR (u.last_name LIKE "%'.$like.'%")';

	$following = $GLOBALS['cn']->query('
		SELECT
			l.id_friend AS friend,
			CONCAT(u.`name`, " ", u.last_name)  AS name_user,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend,
			u.screen_name,
			u.followers_count,
		    u.friends_count

		FROM users u JOIN users_links l ON u.id=l.id_friend

		WHERE md5(l.id_user) = "'.$user.'" '.$like.' '.$notIn.'

		ORDER BY CONCAT(u.`name`, " ", u.last_name)

		LIMIT 0, 50

	');

	return $following;
}

function users_json($where=''){
	$users = $GLOBALS['cn']->query('
		SELECT
			u.id AS friend,
			CONCAT(u.`name`, " ", u.last_name)  AS name_user,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend,
			u.screen_name,
			u.followers_count,
		    u.friends_count

		FROM users u

		WHERE '.$where.'

		ORDER BY u.name

		LIMIT 0, 50
	');

	return $users;
}


function tour_json($where=''){

	if ($_SESSION['ws-tags']['ws-user'][type]==0){

		$notIn = 'AND u.id_div not in("#TourProduct")';

	}

	if ($_SESSION['ws-tags']['ws-user'][view_creation_tag]==0){

		$notInView = 'AND u.id_div not in("#txtMsg","#TourCreationType","#showOrHidevideo","#txtVideo")';

	}

	$hashtour = $GLOBALS['cn']->query('
		SELECT
			u.id_div AS id_div,
			u.title AS title,
			u.message AS message,
			u.position AS position,
			u.hash_tash AS hash_tash
		FROM tour_comment u
		WHERE md5(u.hash_tash) = "'.$where.'" '.$notIn.' '.$notInView.'
	');

	return $hashtour;
}

function tourIp_json($where){
	$tourIp = $GLOBALS['cn']->query('
		SELECT
			u.ip AS ip,
			u.date AS date
		FROM tour_hash u
		WHERE u.ip = "'.$where.'"
		ORDER BY u.id DESC
	');

	$iptours = mysql_fetch_array($tourIp);

	$fechaIp = explode(" ", $iptours[date]);
	$fechaActual = date("Y-m-d");

	if ($fechaActual!=$fechaIp[0]){

		$GLOBALS['cn']->query('	INSERT
								INTO 	tour_hash
								SET 	ip = "'.$where.'", id_user = "0", hash_tash = "-"');

		return '0';//registra el ip del dia
	}else{
		return '1';//ya ese ip se registro el mismo dia
	}
}

function tourHash_json($hashtash){
	$iduser = $_SESSION['ws-tags']['ws-user'][id];

	$tourHash = $GLOBALS['cn']->query('
		SELECT
			u.id_user AS id_user,
			u.hash_tash AS hash_tash
		FROM tour_hash u
		WHERE u.id_user = "'.$iduser.'" AND u.hash_tash = "'.$hashtash.'"
	');

	$Hashtour = mysql_fetch_array($tourHash);

	if ($Hashtour[hash_tash]!=$hashtash){

		$GLOBALS['cn']->query('	INSERT
								INTO 	tour_hash
								SET 	id_user = "'.$iduser.'",
										hash_tash = "'.$hashtash.'"');

		return '0';//registra el usuario y el hash
	}else{
		return '1';//ya ese hash y usuario se registro
	}
}
?>
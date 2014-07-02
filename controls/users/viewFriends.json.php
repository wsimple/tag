<?php
include '../header.json.php';

//include '../../includes/funciones_images.php';
//include '../../includes/functions.json.php';
    
	if (quitar_inyect()){
		$res=array();
		$id_user_My=false;
		if( isset($_GET['id_user']) ) {
			$sql		= 'SELECT id, concat(name," ",last_name) AS user_name FROM users WHERE md5(concat(id, "_", email, "_", id))="'.$_GET['id_user'].'"';
			$query		= $GLOBALS['cn']->query($sql);
			$sql		= mysql_fetch_assoc($query);
			$res		= $sql;
			$id_user	= $sql['id'];
			$user_name	= utf8_encode($sql['user_name']);
			if ($id_user==$_SESSION['ws-tags']['ws-user']['id'])$id_user_My=true;
		} else {
			$res['id'] = $_SESSION['ws-tags']['ws-user']['id'];
			$id_user = $_SESSION['ws-tags']['ws-user']['id'];
		}
		//getFriend devuelve la consulta de amigos segun el tipo especificado.
		function getFriends($type=1,$id='',$where=''){
			$start=isset($_REQUEST['start'])?$_REQUEST['start']:0;
			$start=is_numeric($start)?intval($start):0;
			$limit=isset($_REQUEST['limit'])?$_REQUEST['limit']:10;
			$limit=is_numeric($limit)?intval($limit):10;
			if($id=='') $id = $_SESSION['ws-tags']['ws-user']['id'];
			$_id=array('id_user','id_friend');
			switch($type){
				//1=friends, 2=admirers, 3=admired
				case 1: $isfriend=1; break;
				case 2: $_id=array('id_friend','id_user');//los admiradores se buscan a la inversa
				case 3: $isfriend=0;
			}
			//si where viene vacio comparamos id0 con el id
			if($where=='')	$where = 'l.'.$_id[0].'="'.$id.'" ';
			//si es friend/admirer/admired agregamos la condicion de busqueda
			if($type<4)		$where.= 'AND l.is_friend='.$isfriend;
			$sql='
				SELECT DISTINCT
					u.id,
					md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code,
					CONCAT(u.name, " ", u.last_name) AS name,
					u.screen_name,
					u.profile_image_url AS photo,
					u.friends_count AS friends,
					u.followers_count AS admirers,
					u.following_count AS admired
				FROM users u JOIN users_links l ON u.id=l.'.$_id[1].'
				WHERE '.$where.'
				ORDER BY u.name
				'/*.'LIMIT '.$start.', '.$limit/**/.'
			';
			return $GLOBALS['cn']->query($sql);
		}
		function searchFriendjson($where=''){
			$users = $GLOBALS['cn']->query('
				SELECT
					u.id,
					CONCAT(u.`name`, " ", u.last_name)  AS name,
					u.profile_image_url AS photo,
					md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code,
					u.followers_count,
					u.following_count,
					u.friends_count,
					u.followers_count AS admirers,
					u.following_count AS admired,
					u.friends_count AS friends
				FROM users u
				WHERE '.$where.'
				ORDER BY u.name
				LIMIT 0, 50
			');
			return $users;
		}

		if($_GET['type']<4) $friends=getFriends($_GET['type'],$res['id']);
		switch ($_GET['type']){
			//Friends
			case '1':
				//$friends = view_friends_json(md5($id_user));
				$tileLst = USER_FINDFRIENDSTITLELINKS;
			break;
			//Admirers
			case '2':
				//$friends = followers_json(md5($id_user));
				$tileLst = USER_LBLFOLLOWERS;
			break;
			//Admired
			case '3':
				//$friends = following_json(md5($id_user));
				$tileLst = USER_LBLFRIENDS;
			break;
			//All
			case '4':
				if (trim($_GET['dato'])!=''){
					$where = '
						u.id!="'.$id_user.'" AND
						(email LIKE "%'.$_GET['dato'].'%" OR
						name LIKE "%'.$_GET['dato'].'%" OR
						last_name LIKE "%'.$_GET['dato'].'%")
					';
				}else{
					$where = ' u.id!="'.$id_user.'" ';
				}
				$friends = searchFriendjson($where);
				$tileLst = USER_RESULTS;
			break;
			case '5':
				$friends=view_friendsOfFriends();
			break;
		}//switch type
		$arrayfriends=array();
		while ($friend = mysql_fetch_assoc($friends)){
			$friend['photo'] = getUserPicture($friend['code'].'/'.$friend['photo']);
			if($friend['photo']=='') unset($friend['photo']);
			$friend['name'] = utf8_encode(formatoCadena($friend['name']));
			$arrayfriends[] = $friend;
		}//while
		//Si la búsqueda es para un usuario en especifico
		$users = $GLOBALS['cn']->query('SELECT CONCAT(name, " ", last_name)  AS name FROM users WHERE md5(id) = "'.$_GET['dato'].'"');
		$user  = mysql_fetch_assoc($users);
		//output
		die(jsonp(array(
			'id'		=> $id_user,
			'user_name'	=> $user_name,
			'divider'	=> ($user['name']!='' ? utf8_encode($user['name']).', ' : '').$tileLst.(($id_user_My)?'':(($_GET['type']!='4')?' of '.$user_name:'')),
			'friends'	=> $arrayfriends
		)));
	}//quitar_inyect
?>

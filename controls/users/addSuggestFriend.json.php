<?php
include '../header.json.php';
if(quitar_inyect()) {

	$res = array();	
	
	$cadena = '';
	$ids = '';
	foreach ($_POST['user'] as $var){
		$cadena.= '"'.$var.'",';
	$query=$GLOBALS['cn']->query('
		SELECT
			u.id AS id
		FROM users u
		WHERE md5(u.id) = "'.$var.'"');
	$friend = mysql_fetch_assoc($query);
	$ids.= '"'.$friend['id'].'",';
	
	}
	$res['cad'] = rtrim($cadena,',');
	$res['ids'] = rtrim($ids,',');
	
	$friends = randSuggestionFriends($res['ids'], 1); //incremetar el 0 por si se necesita relleno
	
	if(mysql_num_rows($friends)!=0){
		$friend = mysql_fetch_assoc($friends);

		$friend['id_friend'] = md5($friend['id_friend']);

		$friend['photo_friend'] = FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png');

		$friend['name_user'] = ucwords($friend['name_user']);

		$res['friend'][] = $friend;
	}else{
		$res['friend'][]=0;
	}
	
	die(jsonp($res));
}//quitar_inyect()
?>

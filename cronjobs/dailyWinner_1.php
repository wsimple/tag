<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	header('Access-Control-Allow-Origin: *');
	$path='../';
	include $path.'includes/config.php';
	include $path.'includes/session.php';
	include $path.'includes/functions.php';
	include $path.'class/wconecta.class.php';
	include $path.'includes/languages.config.php';
	function getWinner($funtion='DAY'){
		$sql='
			SELECT t.id_user, th.id_tag, th.hits
			FROM tags_hits th
			JOIN tags t ON t.id=th.id_tag
			JOIN users u ON u.id=t.id_user
			WHERE '.$funtion.'(th.date)='.$funtion.'(NOW())-1
				AND '.$funtion.'(th.date) NOT IN (SELECT '.$funtion.'(date) FROM log_actions'.''.')
			ORDER BY th.hits DESC
			LIMIT 1
		';
		return $GLOBALS['cn']->queryRow($sql);
	}
	$uid=current($GLOBALS['cn']->queryRow('SELECT id FROM users WHERE email="wpanel@tagbum.com";'));
	if (!$uid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
	$date=current($GLOBALS['cn']->queryRow('SELECT NOW();'));
	$fecha=strtotime($date);
	$actions=array(
		'DAY'=>22,
		'WEEKOFYEAR'=>25,
		'MONTH'=>26,
		'YEAR'=>27
	);
	$puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='22' LIMIT 1");
	$totalprice=$puntos['puntos'];
	$winner=getWinner();
	logAction(22,$winner['tag'],$winner['id_user']);
	notifications($winner['id_user'],$winner['tag'],22,'',$uid);
	$GLOBALS['cn']->query("
		UPDATE users
							SET		accumulated_points=accumulated_points + '".$totalprice."',
									current_points=current_points + '".$totalprice."'
							WHERE id = '".$row['id_user']."'
						");
	$GLOBALS['cn']->query("	UPDATE users
							SET		accumulated_points = accumulated_points + '".$totalprice."',
									current_points = current_points + '".$totalprice."'
							WHERE id = '".$row['id_user']."'
						");
	echo '1';
	if (date('j',$fecha)==1){
		$sql=returnSQL('MONTH');
		$winner=$GLOBALS['cn']->query($sql);
		$row=mysql_fetch_assoc($winner);
		notifications($row['id_user'],$row['tag'],'26',"",$uid);
		$puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='26' LIMIT 1");
		$totalprice=$puntos['puntos'];
		$GLOBALS['cn']->query("	UPDATE users 
							SET		accumulated_points = accumulated_points + '".$totalprice."',
									current_points = current_points + '".$totalprice."'
							WHERE id = '".$row['id_user']."'
						");
		echo '2';
		// if (date('m')==1){
		//	$sql=returnSQL('YEAR',true);
		//	$winner=$GLOBALS['cn']->query($sql);
		//	$row=mysql_fetch_assoc($winner);
		//	notifications($row['id_user'],$row['tag'],'20',"",$uid);
		//	$puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='22' LIMIT 1");
		//	$totalprice=$puntos['puntos'];
		//	$GLOBALS['cn']->query("	UPDATE users 
		//						SET		accumulated_points = accumulated_points + '".$totalprice."',
		//								current_points = current_points + '".$totalprice."'
		//						WHERE id = '".$row['id_user']."'
		//					");
		//	echo '3';
		//}
	}
	if(date('w')==0){
		$sql=returnSQL('WEEKOFYEAR');
		$winner=$GLOBALS['cn']->query($sql);
		$row=mysql_fetch_assoc($winner);
		notifications($row['id_user'],$row['tag'],'25',"",$uid);
		$puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='25' LIMIT 1");
		$totalprice=$puntos['puntos'];
		$GLOBALS['cn']->query("	UPDATE users 
							SET		accumulated_points = accumulated_points + '".$totalprice."',
									current_points = current_points + '".$totalprice."'
							WHERE id = '".$row['id_user']."'
						");
		echo '4';
	}
?>
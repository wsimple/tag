<?php
include_once('../header.json.php');
	global $debug,$myId,$source,$type;
	$type=$_REQUEST['type'];
	switch($type){
		case 4: $source=CON::getVal('SELECT id FROM tags WHERE md5(id)=?',array(intToMd5($_REQUEST['source'])));
		break;
		case 15: $source=CON::getVal('SELECT id FROM store_products WHERE md5(id)=?',array(intToMd5($_REQUEST['source'])));
		break;
	}
	$all=isset($_REQUEST['all']);
	$action=$_REQUEST['action'];
	$res=array();
	$res['action']=$action;
	if($action=='insert'||$action=='del'){
		include 'comment.json.php';
	}
	if($action=='all') $action='more';
	if($action=='insert') $action='refresh';
	if($type==4){
		$res['likes']=CON::count('likes','id_source=?',array($source));
		if($debug) $res['_sql_'][]=CON::lastSql();
		$res['dislikes']=CON::count('dislikes','id_source=?',array($source));
		if($debug) $res['_sql_'][]=CON::lastSql();
	}
	$dif=($action=='refresh')?'>':'<=';
	$now=CON::getVal('SELECT now() as date');
	$res['date']=($action!='reload'&&$_POST['date']!='')?$_POST['date']:$now;
	$whereCount=safe_sql("c.id_source=? AND c.id_type=?",array($source,$type));
	$res['total']=CON::count('comments c',$whereCount);
	if ($res['total']==0){
		$res['list']=array();
		die(jsonp($res));
	}elseif ($res['total']>1) $where=$whereCount.safe_sql(" AND c.date $dif ?",array($res['date']));
	else $where=$whereCount;

	$start=(is_numeric($_REQUEST['start'])?intval($_REQUEST['start']):0);
	if($all) $num=$res['total']-$start;
	else $num=(is_numeric($_REQUEST['limit'])?intval($_REQUEST['limit']):20);
	$limit=$action=='refresh'?'':"LIMIT $start,$num";
	$comments=CON::query("
		SELECT
			md5(md5(c.id)) AS id,
			c.comment AS comment,
			c.date AS commentDate,
			CONCAT(u.name,' ',u.last_name) AS nameUser,
			u.email AS emailUser,
			u.id AS idUser,
			u.profile_image_url AS photoUser
		FROM comments c
		JOIN users AS u ON u.id=c.id_user_from 
		WHERE $where
		ORDER BY c.date DESC
		$limit
	");
	if($debug) $res['_sql_'][]=CON::lastSql();
	if($action=='refresh') $res['date']=$now;
	$res['list']=array();
	while($comment=CON::fetchAssoc($comments)){
		$date=explode(' ',$comment['commentDate']);//fecha,hora
		$hora=$date[1];//hora completa
		$date=explode('-',$date[0]);//año,mes,dia
		$sent=getMonth(intval($date[1])).' '.$date[2];
		if($date[0]==date('Y')&&$date[1]==date('m')&&$date[2]==date('d'))
			$sent=NOTIFICATIONS_SENTDATE2;
		if($date[0]==date('Y')&&$date[1]==date('m')&&$date[2]==(date('d')-1))
			$sent=NOTIFICATIONS_SENTDATE3;
		$comment['fdate']=$sent.', '.$hora;
		$comment['delete']=($comment['idUser']==$_SESSION['ws-tags']['ws-user']['id']);
		$comment['codeUser']=md5($comment['idUser'].'_'.$comment['emailUser'].'_'.$comment['idUser']);
		$comment['idUser']=md5($comment['idUser']);
		unset($comment['email']);
		$comment['photoUser']=FILESERVER.getUserPicture('img/users/'.$comment['codeUser'].'/'.$comment['photoUser'],'');
		if($comment['photoUser']==FILESERVER) unset($comment['photoUser']);
		$comment['nameUser']=formatoCadena($comment['nameUser']);
		if(strlen($comment['comment'])>250){
			$pos=strpos($comment['comment'],' ',240);
			if($pos) $comment['subComment']=strToLink(substr($comment['comment'],0,$pos)).'...';
		}
		if(strlen($comment['comment'])>300){
			$ini=strrpos(substr($comment['comment'],0,300),' ',$ini);
			if($ini==0){
				$comment['short']=substr($comment['comment'],0,300).' ...';
			}elseif($ini<250){
				$comment['short']=strToLink(substr($comment['comment'],0,$ini)).substr($comment['comment'],$ini,300-$ini).' ...';
			}else{
				$comment['short']=strToLink(substr($comment['comment'],0,$ini)).' ...';
			}
			unset($ini);
		}
		$comment['comment']=strToLink($comment['comment']);
		$res['list'][]=$comment;
	}
	die(jsonp($res));
?>

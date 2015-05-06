<?php
include '../header.json.php';
include RELPATH.'class/class.phpmailer.php';

$res=array();
if( $_GET['uid']!='' && md5($myId)!=$_GET['uid']) {
	$users=CON::getRow("SELECT id,email,username FROM users WHERE md5(id)=?",array($_GET['uid']));
	if (count($users)>0){
		$linked=CON::getVal("SELECT id_friend FROM users_links WHERE id_user=? AND md5(id_friend)=?",array($myId,$_GET['uid']));
		$admirer=CON::getVal("SELECT id_user FROM users_links WHERE md5(id_user)=? AND id_friend=?",array($_GET['uid'],$myId));
		$res['unlink']=$linked?true:false;
		if(!$linked){#seguir a un usuario
			CON::insert('users_links','id_user=?,id_friend=?,is_friend=?',array($myId,$users['id'],($admirer?1:0)));
			if ($admirer) CON::update('users_links','is_friend=1','id_user=? AND id_friend=?',array($users['id'],$myId));
			// notifications($users['id'],$users['id'],$admirer?5:11);
			$res['my']=updateUsersCounters(md5($myId));
			$res['friend']=updateUsersCounters($_GET['uid']);
			notifications($users['id'],$users['id'],($admirer?5:11),false,false,$users);
		}else{#dejar de seguir a un usuario
			CON::delete('users_links','id_user=? AND id_friend=?',array($myId,$users['id']));
			if($admirer){
				CON::update('users_links','is_friend=0','id_user=? AND id_friend=?',array($users['id'],$myId));
				CON::delete('users_notifications','((id_friend=? AND id_user=?) OR (id_friend=? AND id_user=?)) AND id_type = 5 LIMIT 1',array($users['id'],$myId,$myId,$users['id']));
				CON::delete('users_notifications','id_user=? AND id_friend=? AND id_type = 11 LIMIT 1',array($myId,$users['id']));
			}else{
				CON::delete('users_notifications','((id_friend=? AND id_user=?) OR (id_friend=? AND id_user=?)) AND id_type = 11 LIMIT 1',array($users['id'],$myId,$myId,$users['id']));
			}
			updateUsersCounters(md5($myId));
			$res['friend']=updateUsersCounters($_GET['uid']);
		}
	}else $res['error']='users no exist';
}else{
	if($myId=='') $res['error']='no se ha logeado';
	elseif($_GET['uid']=='') $res['error']='falta el id de usuario';
	else $res['error']='linktome';
}
die(jsonp($res));
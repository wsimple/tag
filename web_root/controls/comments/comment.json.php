<?php
include_once('../header.json.php');
include_once('../../class/class.phpmailer.php');
include_once('../../class/validation.class.php');
$included=included(__FILE__);
global $debug,$myId,$source,$type;
if(!$source||!$type){
	$type=$_REQUEST['type'];
	$source=CON::getVal('SELECT id_source FROM comments WHERE md5(id_source)=?',array(intToMd5($_REQUEST['source'])));
}
if(!$included){
	//si no hay usuario logeado cancelamos el proceso
	$action=$_REQUEST['action'];
	$res=array();
	$res['action']=$action;
	if($myId==''){
		$res['msg']='need login';
		 die(jsonp($res));
	}
}
$res['type']=$type;
$res['source']=$source;
if($action=='del'){//si es eliminar
	$id=isset($_POST['c'])?$_POST['c']:$_REQUEST['id'];
	$res['deleted']=!!CON::delete('comments','md5(md5(id))=? AND id_user_from=?',array($id,$myId));
	die(jsonp($res));
}elseif($action=='insert'&&$_POST['txt']==''){//si es una insersion y no hay texto que ingresar
	$res['inserted']=false;
}elseif($action=='insert'){//si es una insersion
	//destinatario
	$res['txt']=formatText($_POST['txt']);
	$res['inserted']=false;
	$user_to=CON::getVal('SELECT id FROM users WHERE md5(md5(id))=? LIMIT 1',array($_POST['to']));
	switch($type){
		case 4:
			$table='tags';
			$_source=CON::getRow('SELECT id,id_user FROM '.$table.' WHERE id=?',array($source));
			if(count($_source)){
				incPoints(4,$_source['id'],$_source['id_user'],$myId);
				incHitsTag($_source['id']);
			}
			$type2=28;
		break;
		case 15:
			$table='store_products';
			$_source=CON::getRow('SELECT id FROM '.$table.' WHERE id=?',array($source));
			$type2=29;
		break;
	}
	if(count($_source)){
		//insertamos el comentario
		$res['inserted']=CON::insert('comments','id_type=?,id_source=?,id_user_from=?,id_user_to=?,comment=?',array(
			$type,$_source['id'],$myId,$user_to,formatText($_POST['txt'])
		));
		
		//Usado para trending toping
		set_trending_topings($_POST['txt'],true);
		$res['_sql_'][]=CON::lastSql();
		if(CON::error()) $res['_sqlerror_'][]=CON::errorMsg();
		if($res['inserted']){
			//verificamos el propietario de la tag, para evitar notificaciones innecesarias
			// $usr=CON::getVal('SELECT id_user FROM '.$table.' WHERE id=?',array($_source['id']));
			if($user_to!=''&&$user_to!=$myId)//se notifica al destinatario
				notifications($user_to,$_source['id'],$type);
			// if($usr!=$myId&&$usr!=$user_to)//se notifica al propietario
			// 	notifications($usr,$_source['id'],$type);
			//buscamos a los demas usuarios que hayan comentado
			$query=CON::query('	SELECT c.id_user_from AS id, u.email
								FROM users u 
								JOIN comments c ON u.id=c.id_user_from
								WHERE c.id_source=?
									AND c.id_type=?
									AND c.id_user_from NOT IN(?,?)
								GROUP BY c.id_user_from
			',array(
				$_source['id'],
				$type,$user_to,$myId
			));
			$res['_sql_'][]=CON::lastSql();
			while($user=CON::fetchAssoc($query)){//se les notifica que alguien ha escrito
				notifications($user['id'],$_source['id'],$type2,false,false,$user);
			}
		}
	}
}
if(!$included) die(jsonp($res));
unset($included);
?>
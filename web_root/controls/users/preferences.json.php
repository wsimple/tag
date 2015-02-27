<?php 
include '../header.json.php';
unset($_SESSION['ws-tags']['ws-user']['progress']);
if (($myId=='' && !isset($_GET['eprofi'])) || !isset($_GET['action'])) die(jsonp(array()));
$res=array();
switch ($_GET['action']) {
	case 'up': 
		if (isset($_GET['code'])){
			$id_user=CON::getVal("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id))=?",array($_GET['code']));
			if (!$id_user) die(jsonp(array()));
		}else	$id_user=$myId;
		$preference[1]='';$preference[2]='';$preference[3]='';
		for($i=1;$i<4;$i++){	
			if (!is_array($_POST['preference_'.$i])) $post_prefe=explode(",",$_POST['preference_'.$i]);
			else $post_prefe=$_POST['preference_'.$i];
			foreach ($post_prefe as $key) {
				if (trim($key)=="") continue;
				$id=CON::getVal("SELECT id FROM preference_details WHERE detail=?",array($key));
				if (!$id) $id=CON::insert('preference_details','detail=?',array($key));
				if ($id) $preference[$i].=($preference[$i]!=''?',':'').$id;
			}
		}
		CON::delete('users_preferences','id_user=? AND id_preference IN (1,2,3)',array($id_user));
		CON::insert('users_preferences','id_user=?,id_preference=1,preference=?',array($id_user,$preference[1]));
		CON::insert('users_preferences','id_user=?,id_preference=2,preference=?',array($id_user,$preference[2]));
		CON::insert('users_preferences','id_user=?,id_preference=3,preference=?',array($id_user,$preference[3]));
		if (CON::exist("users_preferences","id_user=? LIMIT 1",array($myId))) $res['insert']=true;
		else $res['insert']=false;		
	break;
	case 'add':
		if (!isset($_GET['type']) || !isset($_GET['p'])) die(jsonp(array()));
		if (isset($_GET['code'])){
			$id_user=CON::getVal("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id))=?",array($_GET['code']));
			if (!$id_user) die(jsonp(array()));
		}else	$id_user=$myId;
		if (!CON::exist('users_preferences','id_user=? AND id_preference=? AND preference LIKE "%??%"',array($id_user,$_GET['type'],$_GET['p']))){
			CON::update('users_preferences',"preference= CONCAT(preference,',',?)","id_user=? AND id_preference=?",array($_GET['p'],$id_user,$_GET['type']));	
		}
		$res['update']=true;
	break;
	case 'del':
		if (!isset($_GET['type']) || !isset($_GET['p'])) die(jsonp(array()));
		if (isset($_GET['code'])){
			$id_user=CON::getVal("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id))=?",array($_GET['code']));
			if (!$id_user) die(jsonp(array()));
		}else	$id_user=$myId;
		$prefe=CON::getVal("SELECT preference FROM users_preferences WHERE id_user=? AND id_preference=? AND preference LIKE '%??%'",array($id_user,$_GET['type'],$_GET['p']));
		if ($prefe){
			CON::update('users_preferences',"preference=?","id_user=? AND id_preference=?",array(str_replace(",,",",",str_replace($_GET['p'],"",$prefe)),$id_user,$_GET['type']));	
		}
		$res['update']=true;
	break;
	case 'sr': 
		if (!isset($_GET['term'])) die(jsonp(array()));
		$datos=explode(' ',$_GET['term']);$where='';
		foreach ($datos as $key) 
			$where.=($where!=''?' AND ':'').safe_sql('detail LIKE "%??%"',array($key));
		$query=CON::query("SELECT md5(id) AS id, detail FROM preference_details WHERE $where LIMIT 20");
		while($row=CON::fetchAssoc($query))
			$res[]=(object)array('id'=>$row['detail'],'text'=>$row['detail']);
	break;
	default:
		if (isset($_GET['code'])){
			$id_user=CON::getVal("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id))=?",array($_GET['code']));
			if (!$id_user) die(jsonp(array()));
		}else	$id_user=isset($_GET['u'])?$_GET['u']:$myId;
		$_GET['type']=isset($_GET['type'])?$_GET['type']:false;
		$res['dato']=users_preferences($id_user,$_GET['type']);
	break;
}
die(jsonp($res));
?>
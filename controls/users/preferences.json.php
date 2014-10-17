<?php 
include '../header.json.php';
if (($myId=='' && !isset($_GET['eprofi'])) || !isset($_GET['action'])) die(jsonp(array()));
$res=array();
switch ($_GET['action']) {
	case 'up':		
		if (isset($_GET['code'])){
			$id_user=CON::getVal("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id))=?",array($_GET['code']));
			if (!$id_user) die(jsonp(array()));
			for ($i=1;$i<4;$i++){
				$pre=CON::getArray("SELECT DISTINCT md5(id) AS id, detail FROM preference_details WHERE detail IN ('".str_replace(",","','",str_replace("'","\'",$_POST['preference_'.$i]))."') GROUP BY detail");
				$datos=array();
				$dato=explode(',',$_POST['preference_'.$i]);

				$_POST['preference_'.$i]=array();
				foreach ($dato as $key => $value) { $band=false;
					foreach ($pre as $subpre) 
						if ($subpre['detail']==$value){
							$_POST['preference_'.$i][]=$subpre['id'];
							$band=true;
						}
					if (!$band) $_POST['preference_'.$i][]=$value;
				}
			}
		}else	$id_user=$myId;
		CON::delete('users_preferences','id_user=? AND id_preference IN (1,2,3)',array($id_user));
		CON::insert('users_preferences','id_user=?,id_preference=1,preference=?',array($id_user,@implode(',',$_POST['preference_1'])));
		CON::insert('users_preferences','id_user=?,id_preference=2,preference=?',array($id_user,@implode(',',$_POST['preference_2'])));
		CON::insert('users_preferences','id_user=?,id_preference=3,preference=?',array($id_user,@implode(',',$_POST['preference_3'])));
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
		$query=CON::query("SELECT md5(id) AS id, detail FROM preference_details WHERE $where");
		while($row=CON::fetchAssoc($query))
			$res[]=(object)array('id'=>$row['id'],'text'=>$row['detail']);
	break;
	default:
		if (isset($_GET['code'])){
			$id_user=CON::getVal("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id))=?",array($_GET['code']));
			if (!$id_user) die(jsonp(array()));
		}else	$id_user=isset($_GET['u'])?$_GET['u']:$myId;
		$where=isset($_GET['type'])?safe_sql(' AND id_preference=?',array($_GET['type'])):'';
		$preferences=CON::query("SELECT * FROM users_preferences WHERE md5(id_user)=?".$where,array(intToMd5($id_user)));
		$res['dato']=array();
		while ($row=CON::fetchAssoc($preferences)) {
			$pre=CON::getArray("SELECT md5(id) AS id, detail FROM preference_details WHERE md5(id) IN ('".str_replace(",","','",$row['preference'])."')");
			$datos=array();
			$dato=explode(',',$row['preference']);
			foreach ($dato as $key => $value) { $band=false;
				foreach ($pre as $subpre) {
					if ($subpre['id']==$value){
						$datos[]=(object)array('id'=>$subpre['id'],'text'=>$subpre['detail']);
						$band=true;
					}
				}
				if (!$band) $datos[]=(object)array('id'=>$value,'text'=>$value);
			}
			$res['dato'][$row['id_preference']]=$datos;
		}
	break;
}
die(jsonp($res));
?>
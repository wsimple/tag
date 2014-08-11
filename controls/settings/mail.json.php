<?php 
	include '../header.json.php';
	$res=array();
	if (isset($_POST['action']) && isset($_POST['type'])){
		$res['action']=$_POST['action'];$miId=$_SESSION['ws-tags']['ws-user']['id'];
		if(CON::exist('type_actions','id=?',array($_POST['type']))){
			switch ($_POST['action']) {
				case 0:	
					CON::delete('users_config_notifications','id_user=? AND id_notification=?',array($miId,$_POST['type']));
					$res['suc']=true;
				break;
				case 1:	
					if(!CON::exist('users_config_notifications','id_user=? AND id_notification=?',array($miId,$_POST['type']))){
						$res['suc']=CON::insert('users_config_notifications','id_user=?,id_notification=?',array($miId,$_POST['type']));
					}
				break;
			}
		}
	}
	die(jsonp($res));
?>
<?php
	include '../../../includes/session.php';
	include '../../../includes/functions.php';
	include '../../../includes/config.php';
	include '../../../class/wconecta.class.php';
	include ("../../../includes/languages.config.php");

	$notifiTypes = $GLOBALS['cn']->query("
		SELECT 
			id_user, 
			id_notification
		FROM users_config_notifications
		WHERE id_user ='".$_SESSION['ws-tags']['ws-user'][id]."' AND id_notification ='".$_GET[id_noti]."' 
	");
	$notifiType = mysql_fetch_assoc($notifiTypes);
	
	if ($_GET[id_noti]==$notifiType[id_notification]) {
		$GLOBALS['cn']->query("
			DELETE FROM users_config_notifications 
			WHERE id_user = '".$_SESSION['ws-tags']['ws-user'][id]."' AND id_notification = '".$_GET[id_noti]."'
		");
		$img = '<img src="imgs/config_noti_email.png" onclick="mail(\''.$_GET[id_noti].'\');" title="'.PRIVACY_INACTIVESECTION.'" />';
		echo "0".'|'.$img;
	}else{
		$GLOBALS['cn']->query("
			INSERT INTO users_config_notifications SET
				id_user	= '".$_SESSION['ws-tags']['ws-user'][id]."', 
				id_notification	= '".$_GET[id_noti]."'
		");
		$img = '<img src="imgs/config_noti_unselect.png" onclick="mail(\''.$_GET[id_noti].'\');" title="'.PRIVACY_ACTIVESECTION.'" />';
		echo "1".'|'.$img;
	}
?>
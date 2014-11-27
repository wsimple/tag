<?php
	if ($_GET[ajaxnoti]=="1"){
		include ("session.php");
		include ("config.php");
		include ("functions.php");
		include ("../class/wconecta.class.php");
		include ("languages.config.php");
	}
	//si reviso las notificaciones
	if($_GET[notix]!=""){
		$GLOBALS['cn']->query("
			UPDATE users_notifications SET revised = '2'
			WHERE revised!='2' AND id_type = '".$_GET[type]."' AND id_friend = '".$_SESSION['ws-tags']['ws-user'][id]."' AND md5(id_source) = '".$_GET[notix]."'
		");
		$notifications = $GLOBALS['cn']->query("
			SELECT COUNT(*) AS num
			FROM users_notifications
			WHERE revised = '0' AND id_friend = '".$_SESSION['ws-tags']['ws-user'][id]."'
			GROUP BY id_type, id_source
		");
		$num_notifications = mysql_num_rows($notifications);
		$notification = mysql_fetch_assoc($notifications);
		echo (($num_notifications>0)?$num_notifications:'0').'|<img src="img/finishedwork1.png" width="20" height="20" border="0"  />';
	}elseif ($_GET[notixq] != ""){
		$GLOBALS['cn']->query("
			UPDATE users_notifications SET revised = '1'
			WHERE revised = '0' AND id_friend = '".$_SESSION['ws-tags']['ws-user'][id]."'
		");
		$notifications = $GLOBALS['cn']->query("
			SELECT COUNT(*) AS num
			FROM users_notifications
			WHERE revised = '0' AND id_friend = '".$_SESSION['ws-tags']['ws-user'][id]."'
			GROUP BY id_type, id_source
		");
		$num_notifications = mysql_num_rows($notifications);
		$notification = mysql_fetch_assoc($notifications);
		echo (($num_notifications>0)?$num_notifications:'0').'|<img src="img/finishedwork1.png" width="20" height="20" border="0"  />';
	}else{
		$notifications = $GLOBALS['cn']->query("
			SELECT COUNT(*) AS num
			FROM users_notifications u
			WHERE u.id_friend = '".$_SESSION['ws-tags']['ws-user'][id]."' AND u.revised = '0'
			GROUP BY u.id_type, u.id_source
		");
		$num_notifications = mysql_num_rows($notifications);
		$notification  = mysql_fetch_assoc($notifications);
		echo ($num_notifications>0) ? $num_notifications : "";

		if ($num_notifications>0 && $_GET[ajaxnoti]==""){
?>
	<script type="text/javascript">
		$(document).ready(function(){
			titulo =  document.title.split('-');
			//alert(titulo[0]+","+titulo[1]);
			document.title = " (<?=$num_notifications?>) " + titulo[0] +' - '+titulo[1];
		});
	</script>
<?php   }//if notification
     }//else
?>
<?php
	    session_start();
		
	    include ("../../includes/functions.php");
		
		if (quitar_inyect()){ 
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");
			include ("../../includes/languages.config.php");
			include ("../../class/class.phpmailer.php");
			include ("../../class/validation.class.php");
			
			$users = $GLOBALS['cn']->query("SELECT id 
			                                FROM users 
											WHERE md5(CONCAT(id, '_', email, '_', id)) = '".cls_string($_GET[code])."'
										   ");
										   
			$user  = mysql_fetch_assoc($users);
			
			$tags  = $GLOBALS['cn']->query("SELECT id
			                                FROM tags 
											WHERE id_creator = '".$user[id]."' AND id = '".cls_string($_GET[tag])."'  
										   ");
										   
			echo (mysql_num_rows($tags)==0) ? 0 : 1;
		}else{
		    echo "";
		}
?>
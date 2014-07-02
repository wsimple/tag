<?php
 include ("../../includes/session.php");
 include ("../../includes/config.php");
 include ("../../includes/functions.php");
 include ("../../class/wconecta.class.php");

 if(isset($_GET[hide]))$vector=0; else $vector=1;

 $GLOBALS['cn']->query("UPDATE users SET view_creation_tag = '".$vector."'
						WHERE id = '".$_SESSION['ws-tags']['ws-user'][id]."'");

 $_SESSION['ws-tags']['ws-user']['view_creation_tag']=$vector;

?>
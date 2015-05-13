<?php
include ("../../includes/session.php");
include ("../../includes/config.php");
include ("../../includes/functions.php");
include ("../../class/wconecta.class.php");
with_session(function($sesion){
	$vector=isset($_GET['hide'])?0:1;
	CON::update('users','view_creation_tag=?','id=?',array($vector,$sesion['ws-tags']['ws-user']['id']));
	$sesion['ws-tags']['ws-user']['view_creation_tag']=$vector;
	return $session;
});

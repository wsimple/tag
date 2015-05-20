<?php
include '../header.json.php';

$points=CON::getVal('SELECT current_points FROM users WHERE id=?',array($_SESSION['ws-tags']['ws-user']['id']));
if(true){
	$points=mskPoints($points);
}else{
	$points=number_format($points);
}
with_session(function(&$sesion)use($points){ $sesion['ws-tags']['ws-user']['current_points']=$points; });

die(jsonp($points));

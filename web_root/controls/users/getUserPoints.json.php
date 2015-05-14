<?php
include '../header.json.php';

$points=campo("users","id",$_SESSION['ws-tags']['ws-user'][id],"current_points");	
if(true){
	$points=mskPoints($points);
}else{
	$points=number_format($points);
}
save_in_session(array('ws-tags'=>array('ws-user'=>array('current_points'=>$points))));

die(jsonp($points));

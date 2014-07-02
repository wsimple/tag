<?php
include '../header.json.php';

	$res=array();
	$templates=array();
	#user templates
	$imagesAllowed=array('jpg','jpeg','png','gif');
	$folder=opendirFTP('templates/'.$_SESSION['ws-tags']['ws-user']['code'].'/',RELPATH);
	$blocked=arrayBackgroundsBlocked();
	while($pic=readdirFTP($folder)){
		$extension=strtolower(end(explode('.',$pic)));
		if(in_array($extension,$imagesAllowed)&&!in_array($pic,$blocked)){
			$templates[]=FILESERVER.'img/templates/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$pic;
		}
	}
	#default templates
	$dir=RELPATH.'img/templates/defaults/';
	$folder=opendir($dir);
	while($p=readdir($folder)){
		if(filetype($dir.$p)!='dir'&&strpos($p,'.')>0){
			$extension=$extension=strtolower(end(explode('.',$p)));
			if(in_array($extension,$imagesAllowed)){
				$templates[]=str_replace('../../','../',RELPATH).'img/templates/defaults/'.$p;
			}
		}
	}
	$res['templates']=$templates;
	die(jsonp($res));
?>

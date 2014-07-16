<?php
	include ('../includes/session.php');
	include ('../includes/config.php');
	include ('../includes/functions.php');
	include ('../class/wconecta.class.php');
	include ('../includes/languages.config.php');
	header	('Content-Type: text/javascript');

	$const=get_defined_constants();
	$array=array();
	foreach($const as $key => $val){
		if(substr($key, 0, 3)=='JS_'){
			$array[$key]=  utf8_encode($val);
		}
	}
	echo 'var lang='.json_encode($array).';';
if(false){?><script><?php } ?>
function lan(txt){
	return (lang&&lang[txt]||txt||'');
}

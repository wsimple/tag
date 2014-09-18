<?php
$formats='/\.(mp4)$/';
if(isset($_GET['path'])) $url=$_GET['path'];
else{
	$url=explode('?',$_SERVER['REQUEST_URI']);
	$url=array_shift($url);
}
// if(!preg_match('/\.[a-z0-9]{3,}$/',$url)) die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI'].', '.$url);
$file='videos/not-found.mp4';
if(preg_match($formats,$url)){
	if($config->video_server_path!=''){
		$tmp=explode($config->video_server_path,$url);
		if(count($tmp)>1) $url=end($tmp);
	}
	if(is_file("videos/$url")) $file="videos/$url";
	header('Content-Type: '.mime_content_type($file));
}else{
	header("HTTP/1.0 404 Not Found");
}
if(is_file($file)) readfile($file);

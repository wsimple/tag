<?php
$formats='/\.(mp4)$/';
if(isset($_GET['path'])) $url=$_GET['path'];
else $url=array_shift(explode('?',$_SERVER['REQUEST_URI']));
// if(!preg_match('/\.[a-z0-9]{3,}$/',$url)) die($_SERVER['SCRIPT_NAME'].', '.$_SERVER['REQUEST_URI'].', '.$url);
$file='videos/not-found.mp4';
if(preg_match($formats,$url)){
	if($config->video_server_path!=''){
		$tmp=explode($config->video_server_path,$url);
		if(count($tmp)>1) $url=end($tmp);
	}
	$file="videos/$url";
	echo getcwd()."<br>$file<br>";
	echo (is_file($file)?'is ':'not ').'file';
	header('Content-Type: '.mime_content_type($file));
}else{
	header("HTTP/1.0 404 Not Found");
}
readfile($file);

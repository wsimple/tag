<?php
require_once('includes/client.php');

$validate=false;

$code=isset($_COOKIE['__code__'])?$_COOKIE['__code__']:(isset($_REQUEST['code'])?$_REQUEST['code']:'');
if($validate){
	$uid=isset($_COOKIE['__uid__'])?$_COOKIE['__uid__']:(isset($_REQUEST['uid'])?$_REQUEST['uid']:'');
	$db=new TAG_db();
	$user=$db->getRow('SELECT *
		FROM (SELECT id,email,md5(id) as uid,md5(CONCAT(id,"_",email,"_",id)) as code FROM users)
		WHERE uid=? AND code=?',array($uid,$code));
	$myId=isset($user['id'])?$user['id']:0;
	$code=isset($user['code'])?$user['code']:0;
}

$folder="/videos/pending/$code";

if(!is_dir($folder)){ mkdir($folder,0755,true);}

$files=array();
if(count($_FILES))
	foreach($_FILES as $file){
		if($file['error']==0){
			//#nombre personalizado
			$file_name=hash_file('crc32',$file['tmp_name']).'_'.date('YmdHis').'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
			if(rename($file['tmp_name'],__DIR__."$folder/$file_name")){
				$files[]=array('name'=>$file_name);
			}
		}
	}
function __autoload($classname){
	#carga automatica de clases permitidas
	$file="$classname.php";
	if(is_file($file)) require_once $file;
	else die('Class not found.');
}
if(isset($_GET['convert'])){
	$_REQUEST['file']=$_GET['file']=$_POST['file']=$file_name;
	$options=null;
	if(isset($_SERVER['HTTP_REFERER']))
		$_referer=$_SERVER['HTTP_REFERER'];
	elseif(preg_match('/firefox/i',$_SERVER['HTTP_USER_AGENT']))
		$_referer=$config->main_server;
	else
		$_referer='localhost';
	$_referer=preg_replace('/^(\w+:\/\/)?([^\/]+)(\/.*)?$/','$2',$_referer);
	header("data-referer: $_referer");
	// if(preg_match('/^(localhost|(192|52)(\.\d+){3}|(\w+\.)?tagbum\.com)$/',$_referer)){
		$options=array(
			'access_control_allow_origin'=>"http://$_referer",
			'access_control_allow_credentials'=>true
		);
	// }
	unset($_POST['CROSSDOMAIN'],$_REQUEST['CROSSDOMAIN']);

	$handler = new VideoConvertionApp($options);
	die();
}

die(json_encode(array('file'=>$file_name)));

die(json_encode(array(
	'files'=>$files,
	'folder'=> $folder,
	// 'request'=> $_REQUEST,
	// 'upload'=> $_FILES
)));

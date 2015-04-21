<?php
require_once('includes/client.php');

$validate=true;

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
die(json_encode(array('file'=>$file_name)));

die(json_encode(array(
	'files'=>$files,
	'folder'=> $folder,
	// 'request'=> $_REQUEST,
	// 'upload'=> $_FILES
)));

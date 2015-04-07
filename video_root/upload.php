<?php
require_once('includes/client.php');
if(!$myId){
	$db=new TAG_db();
	$user=array();
	$user=$db->getRow('SELECT id,email FROM users WHERE md5(id)=? AND md5(CONCAT(id,"_",email,"_",id))=?',
		[ $_COOKIE['__uid__'],$_COOKIE['__code__'] ]);
	$myId=$user['id'];
}
if(!$myId) $myId=0;

$folder='/videos/pending';
$files=[];
if(count($_FILES)){
	foreach($_FILES as $file){
		if($file['error']==0){
			#nombre personalizado
			$file_name=hash_file('crc32',$file['tmp_name']).'_'.date('YmdHis').'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
			if(rename($file['tmp_name'],dirname(__FILE__)."$folder/$file_name")){
				$files[]=['name'=>$file_name];
			}
		}
	}
}
die(json_encode([
	'files'=>$files,
	'folder'=> $folder,
	'request'=> $_REQUEST,
	'upload'=> $_FILES
]));

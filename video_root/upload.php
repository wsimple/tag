<?php
require_once('includes/client.php');
if(!$myId){
	$db=new TAG_db();
	$user=array();
	$user=$db->getRow('SELECT id,email FROM users WHERE md5(id)=? AND md5(CONCAT(id,"_",email,"_",id))=?',
		array($_COOKIE['__uid__'],$_COOKIE['__code__']));
	$myId=$user['id'];
}
 if(!$myId) $myId=0;

$folder='/videos/pending/'.$_POST['code'];

if(!is_dir($folder)){ mkdir($folder,0755,true);}

$files=array();
if(count($_FILES))
	foreach($_FILES as $file){
		if($file['error']==0){
			//#nombre personalizado
			$file_name=hash_file('crc32',$file['tmp_name']).'_'.date('YmdHis').'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
			if(rename($file['tmp_name'],dirname(__FILE__)."$folder/$file_name")){
				$files[]=array('name'=>$file_name);
			}
		}
	}
die(json_encode(array('file'=>$file_name, 'folder'=>$folder, 'FILE'=>$_FILES, 'GET'=>$_GET, 'POST'=>$_POST)));
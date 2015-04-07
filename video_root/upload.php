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

$files=array();
if(count($_FILES)){
	foreach($_FILES as $file){
		if($file['error']==0&&rename($file['tmp_name'],"tmp/$myId-".$file['name'])){
			$files[]="tmp/$myId-".$file['name'];
		}
	}
}


$result_=@move_uploaded_file($_FILES["file"]["tmp_name"], "aaa_".$_FILES["file"]["name"]);

die(json_encode(array(

	'FILES'=>$_FILES,
	'result'=> $result_,
	'folder'=> getcwd ()
)));

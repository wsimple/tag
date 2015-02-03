<?php 
include '../header.json.php';
if($myId=='') die('{}');
$res= array();
$default=json_decode('{"sex_preference":0,"wish_to":0,"min_age":10,"max_age":80}');

if(isset($_GET['insert'])){
	$data=CON::getRowObject('select * from users_search_preferences where id=?',array($myId));
	if($data->id!=$myId) $data=$default;
	if(isset($_POST['sex_preference'])) $data->sex_preference=$_POST['sex_preference'];
	if(isset($_POST['wish_to'])){
		$wish=0;
		foreach($_POST['wish_to'] as $val) $wish+=intval($val);
		$data->wish_to=$wish;
	}
	if(isset($_POST['min_age'])) $data->min_age=$_POST['min_age'];
	if(isset($_POST['max_age'])) $data->max_age=$_POST['max_age'];
	// echo jsonp($data);
	CON::insert_or_update('users_search_preferences','sex_preference=?,wish_to=?,min_age=?,max_age=?','id=?','id=?',
		array($data->sex_preference,$data->wish_to,$data->min_age,$data->max_age,$myId,$myId));
}

$res=CON::getRowObject('select * from users_search_preferences where id=?',array($myId));
if($res->id!=$myId) $res=$default;

die(jsonp($res));

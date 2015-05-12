<?php
$t=array_sum(explode(' ',microtime()));
global $_header_json;
if(!$_header_json){
	if(isset($_COOKIE['_DEBUG_']))
		error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
	else
		error_reporting(0);
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Allow-Origin: '.($_origin!=''?$_origin:'http://localhost'));
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');
	//header('Access-Control-Max-Age: 86400');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/'.(isset($_GET['callback'])?'javascript':'json'));
	$path=preg_replace('/([\/][^\/]*)$/','',str_replace('\\','/',dirname(__FILE__)));
	@define('RELPATH',"$path/");
	include_once("$path/includes/config.php");
	//if(is_debug('header')) echo "Time config:".(array_sum(explode(' ',microtime()))-$t)."\n";
	include "$path/includes/session.php";
	//if(is_debug('header')) echo "Time session:".(array_sum(explode(' ',microtime()))-$t)."\n";
	include "$path/includes/functions.php";
	if(is_debug('header')) echo "Time functions:".(array_sum(explode(' ',microtime()))-$t)."\n";
	include "$path/includes/functions_mails.php";
	if(is_debug('header')) echo "Time functions_mails:".(array_sum(explode(' ',microtime()))-$t)."\n";
	include "$path/class/wconecta.class.php";
	if(is_debug('header')) echo "Time wconecta:".(array_sum(explode(' ',microtime()))-$t)."\n";
	$_head=array();
	$_head=apache_request_headers();
	$mobile=($_POST['CROSSDOMAIN']||$_head['SOURCEFORMAT']=='mobile');
	global $debug,$myId,$mobile,$_origin;

	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	if(!$myId) $myId=0;
	if(!$_origin) include RELPATH.'includes/languages.config.php';

	if(is_debug('header')) echo "Time languages:".(array_sum(explode(' ',microtime()))-$t)."\n";

	quitar_inyect();
	$debug=isset($_REQUEST['debug'])?$_REQUEST['debug']:$_COOKIE['_DEBUG_'];
	unset($path,$_head);
}
$_header_json=true;
if($_need_login&&!$myId) die('');

if(is_debug('header')) echo "Time final:".(array_sum(explode(' ',microtime()))-$t)."\n";

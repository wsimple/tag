<?php
global $_header_json;
if(!$_header_json){
	global $debug,$myId,$mobile,$_origin;
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Allow-Origin: '.($_origin!=''?$_origin:'http://localhost'));
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');
	//header('Access-Control-Max-Age: 86400');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/'.(isset($_GET['callback'])?'javascript':'json'));
	$_head=array();
	if(!function_exists('apache_request_headers')){
		function apache_request_headers(){
			$arh=array();
			$rx_http='/\AHTTP_/';
			foreach($_SERVER as $key=>$val){
				if(preg_match($rx_http,$key)){
					$arh_key=preg_replace($rx_http,'',$key);
					$arh[$arh_key]=$val;
				}
			}
			return($arh);
		}
	}
	$_head=apache_request_headers();
	$mobile=($_POST['CROSSDOMAIN']||$_head['SOURCEFORMAT']=='mobile');
	$path=str_repeat('../',1+substr_count(end(explode('controls/',$_SERVER['PHP_SELF'])),'/'));
	include_once($path.'includes/config.php');
	include $config->relpath.'includes/session.php';
	include $config->relpath.'includes/functions.php';
	include $config->relpath.'class/wconecta.class.php';
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	if(!$_origin) include $config->relpath.'includes/languages.config.php';
	if(!quitar_inyect()) die();
//	error_reporting(E_ERROR);
	$debug=isset($_REQUEST['debug'])?$_REQUEST['debug']:$_COOKIE['_DEBUG_'];
	unset($path,$_head);
}
$_header_json=true;
?>

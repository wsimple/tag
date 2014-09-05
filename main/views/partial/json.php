<?php
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Origin: '.($origin!=''?$origin:'http://localhost'));
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

//	error_reporting(E_ERROR);
if($json!=''){
	if(is_assoc($json)&&$control->is_debug()){
		$d=array();
//		$d['cookies']=$_COOKIE;
//		$d['sesion']=$_SESSION;
		$d['REQUEST']=$_REQUEST;
		$d['POST']=$_POST;
		$d['GET']=$_GET;
		$headers=apache_request_headers();
		$d['ismobile']=($_POST['CROSSDOMAIN']||$headers['SOURCEFORMAT']=='mobile');
		$res['_DEBUG_']=$d;
	}
	$txt=json_encode($json);
	if(isset($_GET['callback'])) $txt=$_GET['callback']."($txt)";
	echo $txt;
}
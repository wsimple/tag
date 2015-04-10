<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include('includes/config.php');
include('includes/session.php');
$url=$config->base_url;
if(isset($_SESSION['ws-tags']['ws-user'])){
	if(!empty($_GET['redirect_to'])) $url=$_GET['redirect_to'];
	elseif(!empty($_GET['url'])) $url=$_GET['url'];
	elseif(!empty($_POST['goto'])) $url=$_POST['goto'];
	elseif(!empty($_POST['url'])) $url=$_POST['url'];
	else $url=@$_SESSION['ws-tags']['ws-user']['logins_count']>1?$config->base_url:$config->base_url.'welcome';
}

//if(isset($_COOKIE['_DEBUG_'])) echo 'url='.$url;
//if($_COOKIE['_DEBUG_']!='login') 
	@header("Location:$url");

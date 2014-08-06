<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
   	include('includes/session.php');
   	include('includes/functions.php');
   	if(!$_SESSION['ws-tags']['ws-user']) $url=base_url();
      elseif($_POST['goto']!='') $url=$_POST['goto'];
   	elseif($_POST['url']!='') $url=$_POST['url'];
   	elseif($_GET['url']!='') $url=$_GET['url'];
   	else $url=$_SESSION['ws-tags']['ws-user']['logins_count']>1?base_url():base_url('welcome');
      if($url=='') $url='.';
   if(isset($_COOKIE['_DEBUG_'])) echo 'url='.$url;
   if($_COOKIE['_DEBUG_']!='login') @header("Location:$url");

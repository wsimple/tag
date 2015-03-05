<?php
include '../header.json.php';

$kl=keepLogin();
if(!$kl['logged']) logout();
ifIsLogged();
$kl['photo_thumb'] = FILESERVER.$_SESSION['ws-tags']['ws-user']['pic'];
die(jsonp($kl));
?>
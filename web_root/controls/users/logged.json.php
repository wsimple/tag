<?php
include '../header.json.php';

$kl=keepLogin();
if(!$kl['logged']) logout();
ifIsLogged();
die(jsonp($kl));
?>
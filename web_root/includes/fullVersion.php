<?php
include ('session.php');
include ('config.php');
$_SESSION['ws-tags']['ws-user']['fullversion'] = 1;
echo '<meta HTTP-EQUIV="REFRESH" content="0; url='.DOMINIO.'">';
?>
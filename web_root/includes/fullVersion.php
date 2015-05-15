<?php
include('session.php');
include('config.php');
with_session(function(&$sesion){ $sesion['ws-tags']['ws-user']['fullversion']=1; });
echo '<meta HTTP-EQUIV="REFRESH" content="0; url='.DOMINIO.'">';

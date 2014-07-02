<?php
session_start();
include '../includes/config.php';
include '../includes/conexion.php';
if (!session_is_registered("locale")) { //check if the session variable has already been set first
	
	
	$ip_num = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
	
	$result = mysql_query( "SELECT * FROM geo_ip WHERE $ip_num BETWEEN start AND end" );
	$num_rows = mysql_num_rows($result);
	
	$locale=mysql_fetch_assoc($result);
	$_SESSION['locale']=$locale[idioma];
	
}
echo $_SESSION['locale'];
?>
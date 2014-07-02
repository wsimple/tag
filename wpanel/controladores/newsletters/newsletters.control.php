<?php
include '../../../includes/config.php';
include '../../../class/wconecta.class.php';
include '../../../includes/conexion.php';
include '../../../includes/functions.php';

switch ( $_REQUEST[txt_status] ) {
	case 'Active':	$_REQUEST[txt_status] = '1'; break;
	case 'Inactive':$_REQUEST[txt_status] = '2'; break;
	case 'Pending':	$_REQUEST[txt_status] = '5'; break;
	case 'Sent':	$_REQUEST[txt_status] = '6'; break;
	default: break;
}

if( $_GET[updateId] ) {

	mysql_query("UPDATE newsletters SET content = '".$_REQUEST[txt_content]."', status = '".$_REQUEST[txt_status]."', tittle = '".$_REQUEST[txt_tittle]."' WHERE md5(id) = '".$_REQUEST[updateId]."';") or die(mysql_error());

} elseif( isset($_GET[newId]) ) {

	mysql_query("INSERT INTO newsletters SET content = '".$_REQUEST[txt_content]."', status = '".$_REQUEST[txt_status]."', tittle = '".$_REQUEST[txt_tittle]."';") or die(mysql_error());

} elseif( $_GET[sendId] ) {


	?> <script>alert("here goes the code to send this notification manually id='" + "<?=$_GET[sendId]?>" + "'");</script> <?php
}

redirect("../../index.php?url=vistas/newsletters/newsletters.view.php");
?>
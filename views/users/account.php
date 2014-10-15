<?php
$sc=$_GET['sc'];
if($_GET['usr']!='') $sc=6;
if(!$logged&&$sc!=6){
	include('views/main/failure.php');
}else{
	switch($sc){
		case 7:include('account/userPrivacy.view.php');break;
		case 6:include('eprofile.php'); break;
		case 5:include('account/foto.view.php');break;
		case 4:include('account/resetPasswordTab.view.php');break;
		case 3:include('account/business_card/beginning.php');break;
		case 2:include('account/preferences.php');break;
		case 1:
		default:include('account/profile.view.php');
	}
}
?>

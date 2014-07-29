<?php
global $section,$params;

if(!$section) include('users/account.php');
else{
	switch($params[0]){
		case 7:
			include('users/account/userPrivacy.view.php');break;
		case 'preferences':
			include('users/account/preferences.view.php');break;
		case 'businesscards':
			include('users/account/business_card/beginning.php');break;
		case 'password':
			include('users/account/resetPasswordTab.view.php');break;
		case 'miniature':case 'picturecrop':
			include('users/account/foto.view.php');break;
		case 'external':case 'preview':
			include('users/eprofile.php'); break;
		case 'profile':
		default:
			include('users/account/profile.view.php');
	}
}
?>

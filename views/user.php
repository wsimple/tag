<?php
global $section,$params;
$numPanels=2;

if(!$section) include('users/account.php');
else{
	switch($params[0]){
		case 'privacy':
			include('users/account/userPrivacy.view.php');break;
		case 'preferences':
			include('users/account/preferences.php');break;
		case 'businesscards':case 'cards':
			include('users/account/business_card/beginning.php');break;
		case 'password':
			include('users/account/resetPasswordTab.view.php');break;
		case 'mini':case 'picturecrop':
			include('users/account/foto.view.php');break;
		case 'external':case 'preview':
			include('users/eprofile.php'); break;
		case 'user':case 'profile':
		default:
			if(preg_match('/^[0-9a-f]{32}$/i',$params[0]))
				include('users/eprofile.php');
			else
				include('users/account/profile.view.php');
	}
}

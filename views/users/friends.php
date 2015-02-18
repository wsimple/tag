<?php
global $section,$params;
//Seleccion del menu Friends
$sc = $_GET['sc'];
if ($section=='friends') $sc=$section;
if($params[0]!='') $sc=$params[0];
switch ($sc) {
	case 1: case 2: case 'find':case 'dates':
		include("friends/yourFriendsView.php"); break;
	// case 2:
	// 	include("friends/findFriendsView.php");
	// 	break;
	case 3: case 'invite':
		include("friends/inviteFriendsView.php"); break;
	case 4: include('friends/addressBookView.php');	break;
	default: include("friends/yourFriendsView.php"); break;
}

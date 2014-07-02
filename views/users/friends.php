<?php

//Seleccion del menu Friends
$sc = $_GET['sc'];

switch ($sc) {
	case 1:
		include("friends/yourFriendsView.php");
		break;
	case 2:
		include("friends/findFriendsView.php");
		break;

	case 3:
		include("friends/inviteFriendsView.php");
		break;
	case 4:
		include('friends/addressBookView.php');
		break;
	
	default:
		include("friends/yourFriendsView.php");
		break;
}
?>

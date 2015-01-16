<?php  
	session_start();
	echo $_SESSION['ws-tags']['email'];
	if (isset($_GET['clear']) && isset($_SESSION['ws-tags']['email'])){
		unset($_SESSION['ws-tags']['email']);
	} 
?>
<?php
	session_start();
	unset($_SESSION['wpanel_user']);
	session_write_close();
	echo '<META HTTP-EQUIV="refresh" content="0; URL=../index.php">';

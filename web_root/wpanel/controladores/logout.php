<?php
       session_start();
	   $_SESSION['wpanel_user']=""; 
	   unset($_SESSION['wpanel_user']);
	   
	   echo "<META HTTP-EQUIV=\"refresh\" content=\"0; URL=../index.php\">";
	      
?>
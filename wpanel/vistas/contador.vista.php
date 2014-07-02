<?php
     if ($_GET[ajax]=='1'){
	 
	 
	 
	 }
     
	 $users = mysql_query("SELECT COUNT(*) AS num FROM users") or die (mysql_error());
	 
	 $user  = mysql_fetch_assoc($users);
	 
	 echo $user[num];

?>
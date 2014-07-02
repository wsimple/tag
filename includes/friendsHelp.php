<?php
	 session_start();
	 include ("../includes/functions.php");
	 if (quitar_inyect()){
		 include ("../includes/config.php");
		 include ("../class/wconecta.class.php");
		 include ("../includes/languages.config.php");
		 //$query = ($_GET[value]!='') ? friendsHelp($_GET[value]) : friendsHelp();
		 $query = ($_GET[value]!='') ? friendsHelp($_GET[tag],true) : friendsHelp($_GET[tag]);
		 //$query = friendsHelp($_GET['tag']);
		 $salida= '[';								 
		 while ($array = mysql_fetch_assoc($query)){
			 $array['key'] = utf8_encode( $array['key']);
		     $salida.= json_encode($array); 
		 }
		 echo str_replace('}{','},{',$salida).']'; 
	 }
?>
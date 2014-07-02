<?php
//[{"key": "movies", "value": "4123"},]

	//$_GET[id]=1;
	 include ("../includes/functions.php");
	 
	 if (quitar_inyect()){
	 
	 include ("../includes/config.php");
	 include ("../class/wconecta.class.php");
	 include ("../includes/languages.config.php");
		 
	  $query = $GLOBALS['cn']->query("SELECT  TRIM(detail) as  'key', id as 'value'
										FROM `preference_details`
										WHERE `id_preference` ='$_GET[id]'"); 
	$salida= '[';								 
	 while( $array = mysql_fetch_assoc($query)){
	  	$salida.= json_encode($array); 
	  }
	echo str_replace('}{','},{',$salida).']'; 
	
	} 

?>

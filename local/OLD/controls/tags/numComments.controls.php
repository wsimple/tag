<?php
	    session_start();

	    include ("../../includes/functions.php");

		if (quitar_inyect()){
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");
			include ("../../includes/languages.config.php");
			include ("../../class/class.phpmailer.php");
			include ("../../class/validation.class.php");
			
			
			
			echo numRecord("tags_comments", " WHERE id_tag = '".$_GET[t]."'");
			
			
		}
?>
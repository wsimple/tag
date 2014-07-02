<?php
	    include ("../../includes/functions.php");

		if (quitar_inyect()){
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");
			include ("../../includes/languages.config.php");
			include ("../../class/class.phpmailer.php");
			include ("../../class/validation.class.php");
			
			echo numRecord("comments", " WHERE id_source = '".$_GET[source]."' AND id_type = '".$_GET[type]."' ");
			
		}
?>
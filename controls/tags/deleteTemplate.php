<?php     
	    session_start();

	    include ("../../includes/functions.php");

		if (quitar_inyect()){
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");
			
			if ($_GET[template]!=''){
			    
				$GLOBALS['cn']->query(" INSERT INTO tags_delete_backgrounds SET 
				                                    
													id_user    = '".$_SESSION['ws-tags']['ws-user'][id]."',
													background = '".$_GET[template]."'
									  ");
			
			}//if template
        
		}//if inyect
?>
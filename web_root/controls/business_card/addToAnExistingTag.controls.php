<?php

		session_start();
		include ("../../includes/functions.php");
		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");
		include '../../includes/languages.config.php';
		/*if( quitar_inyect() )
		//{
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");


			$id		= explode('|', $_GET['id_bc']);
			// $id[0] idTag
			// $id[1] idBC

			$result = $GLOBALS['cn']->query("	SELECT id_business_card
												FROM tags
												WHERE md5(id) = '".$id[0]."'");

			$result = mysql_fetch_assoc( $result );

			if( !$result[id_business_card] ) {

					$GLOBALS['cn']->query("	UPDATE tags
											SET id_business_card = '".$id[1]."'
											WHERE md5(id) = '".$id[0]."'");

					$id[0] = $id[0]."|".md5($id[1]);

			} else {

					$GLOBALS['cn']->query("	UPDATE tags
											SET id_business_card = ''
											WHERE md5(id) = '".$id[0]."'");
			}
			echo $id[0]."|";
		}*/
		
		
		if ((isset($_GET['id_tag'])) && (isset($_GET['id_bc']))){
			$idTagP=$_GET['id_tag'];
			$idBc=$_GET['id_bc'];
			$idUser=$_GET['id_user'];
			$result = $GLOBALS['cn']->query("	SELECT id
												FROM business_card
												WHERE id = '".$idBc."'");
			$result = mysql_fetch_assoc( $result );
			if ($result['id']==$idBc){
				$GLOBALS['cn']->query("	UPDATE tags
										SET id_business_card = '".$idBc."'
										WHERE id = '".$idTagP."'");
				echo SPONSORTAG_SPANEXITO;
			}else{
				echo JS_ERROR;
			}
		}else{
			echo SIGNUP_CTRTITLEALERT1;
		}
?>
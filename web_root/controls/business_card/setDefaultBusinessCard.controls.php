<?php

		session_start();
		include ("../../includes/functions.php");


		if (quitar_inyect())
		{
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");

			$result = $GLOBALS['cn']->query("	SELECT	md5(id) AS id
												FROM	business_card
												WHERE	id_user = '".$_SESSION['ws-tags']['ws-user'][id]."' AND
														type = '0'");

			$result = mysql_fetch_assoc( $result );

			if( $result['id'] != $_GET['id_bc'] )
			{
					$GLOBALS['cn']->query("	UPDATE business_card
											SET type = '1'
											WHERE id_user = '".$_SESSION['ws-tags']['ws-user'][id]."'");

					$GLOBALS['cn']->query("	UPDATE business_card
											SET type = '0'
											WHERE md5(id) = '".$_GET['id_bc']."'");

					echo $_GET['id_bc']."-".$result['id'];
			}
		}
?>
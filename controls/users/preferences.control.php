<?php

	include '../../includes/session.php';
	include '../../class/validation.class.php';
	include '../../includes/functions.php';
	include '../../includes/config.php';
	include '../../class/wconecta.class.php';
		$query = $GLOBALS['cn']->query("SELECT id, name FROM preferences LIMIT 0,30");

		while( $preference = mysql_fetch_assoc($query) ) {

			$preferences = @implode(",", $_POST['preference_'.$preference[id]]); //separamos por comas el vector que llega

				$accion = $GLOBALS['cn']->query("	SELECT id_preference
													FROM users_preferences
													WHERE	id_user ='".$_SESSION['ws-tags']['ws-user'][id]."' AND
															id_preference ='".$preference[id]."'");
				if( mysql_num_rows($accion)==0 ) { //se inserta la preferencia
					$GLOBALS['cn']->query("	INSERT INTO users_preferences
											SET	id_user = '".$_SESSION['ws-tags']['ws-user'][id]."',
												id_preference  = '".$preference[id]."',
												preference = '".mysql_real_escape_string($preferences)."'");
					$ret .= '_I'.$preference[id];
				} else { //se actualiza la preferencia
					$GLOBALS['cn']->query("	UPDATE users_preferences
											SET preference = '".mysql_real_escape_string($preferences)."'
											WHERE	id_user = '".$_SESSION['ws-tags']['ws-user'][id]."' AND
													id_preference = '".$preference[id]."'");
					$ret .= '_U'.$preference[id];
				}
		}// while

		$ret = explode('_', $ret);
		for($i=1; $i<count($ret); $i++) {
			echo $ret[$i];
			if( $i<count($ret)-1 )
				echo "_";
		}
?>
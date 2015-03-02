<?php
include('../../includes/config.php');
include('../../class/wconecta.class.php');

if( isset($_GET['idIdeaAgree']) ) {
	$result = $GLOBALS['cn']->query('
		SELECT * FROM feedback_ip
		WHERE
			ip="'.$_SERVER['REMOTE_ADDR'].'" AND
			DATE(time)!="'.date('d-m-Y H:i:s').'" AND
			id_feedback = "'.$_GET['idIdeaAgree'].'"
	');

	if(mysql_num_rows($result)<=0){
		$GLOBALS['cn']->query('UPDATE feedback SET	votes = votes + 1 WHERE md5(id) = "'.$_GET['idIdeaAgree'].'"');
		$GLOBALS['cn']->query('INSERT INTO feedback_ip SET id_feedback = "'.$_GET['idIdeaAgree'].'",ip="'.$_SERVER['REMOTE_ADDR'].'"');
		$result = $GLOBALS['cn']->queryRow('SELECT votes FROM feedback WHERE md5(id) = "'.$_GET['idIdeaAgree'].'"');
		echo $result['votes'];
	}
} else {
	if( isset($_GET['idUser']) ) {
		$GLOBALS['cn']->query('
			INSERT INTO feedback SET
				id_user		= "'.$_GET['idUser'].'",
				idea		= "'.$_GET['txtIdea'].'",
				description	= "'.$_GET['txtDescription'].'",
				votes		= "1"
		');
	}else{
		$GLOBALS['cn']->query('
			INSERT INTO feedback SET
				email		= "'.$_GET['txtEmail'].'",
				idea		= "'.$_GET['txtIdea'].'",
				description	= "'.$_GET['txtDescription'].'",
				votes		= "1"
		');
	}
}
?>
<?php
include '../../includes/session.php';
include '../../includes/config.php';
include '../../includes/functions.php';
include '../../class/wconecta.class.php';
include '../../class/validation.class.php';

addJs('../../js/funciones_bc.js');

$fields = "	id, id_user, type, address, company, specialty, email, middle_text, home_phone, work_phone, mobile_phone, company_logo_url,
			background_url, (SELECT concat(u.`name`, ' ', u.last_name) FROM users u WHERE id = id_user) AS nameUsr";

if( isset($_GET[id_user]) || isset($_GET[id_tag]) ) {

	//when it's launched from a tag editing window
	if( isset($_GET[id_tag]) ) {

		$tags = $GLOBALS['cn']->query("SELECT id_business_card AS id FROM tags WHERE id = '$_GET[id_tag]'");
		$businessCardToMark = (mysql_num_rows($tags)=='1' ? mysql_fetch_assoc($tags) : '');

	} else {

		//aqui va el proceso cuando manda el id de usuario
	}
}

$businessCards = $GLOBALS['cn']->query("SELECT ".$fields."
										FROM business_card
										WHERE id_user ='".$_SESSION['ws-tags']['ws-user'][id]."'");
?>



<div style="height: 500px;">
	<div id="listOfBusinessCards" style="height: 500px;" >

		<?php while( $bc = mysql_fetch_assoc($businessCards) ) { ?>

				<div style="list-style: none; padding: 12px; width: 350px; height: 250px; float: left;">
					<?php
						$exclude = true;
						$listAddToTag = true;

						( $businessCardToMark[id] ? $markThisBC=($bc[id]==$businessCardToMark[id] ? true : false) : '' );

						include("businessCard_dialog.view.php");
					?>
				</div>

		<?php } ?>
	</div>
</div>
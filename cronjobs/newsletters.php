<?php
// ******************** SOME MAIL DATA *************************************************************************************
		$from = 'no-reply@tagbum.com';
		$fromName = 'seemytag.com';
		$path = '../';
		$formatMailWidth = "750";
// ******************** END - SOME MAIL DATA *******************************************************************************


if( isset($_GET[send_one_mail]) ) {

		//$_GET[send_one_mail][0]; // correo
		//$_GET[send_one_mail][1]; // md5(id)

		include '../includes/config.php';
		include '../class/wconecta.class.php';
		include '../includes/conexion.php';
		include '../class/class.phpmailer.php';
		include '../includes/functions.php';
		include '../includes/languages.config.php';

		$_GET[send_one_mail] = explode('|', $_GET[send_one_mail]);

		$newsletter = mysql_query('	SELECT	tittle, content
									FROM	newsletters
									WHERE	md5(id)="'.$_GET[send_one_mail][1].'"') or die(mysql_error());

		$newsletter = mysql_fetch_assoc($newsletter);

		$body		= formatMail($newsletter[content], $formatMailWidth);
		$subject	= $newsletter[tittle];

		sendMail($body, $from, $fromName, $subject, $_GET[send_one_mail][0], $path);
		redirect('../wpanel/?url=vistas/newsletters/newsletters.view.php');

} else {


		$_cronjob=true;
		include '../includes/config.php';
		include '../class/wconecta.class.php';
		include '../includes/conexion.php';
		include '../class/class.phpmailer.php';
		include '../includes/functions.php';
		include '../includes/languages.config.php';


		// ******************** GETTING NEWSLETTERS BATCH FROM SYSTEM **************************************************************
		$queryBatch = mysql_query("SELECT newsletters_batch AS batch FROM config_system;")or die(mysql_error());
		$queryBatch = mysql_fetch_assoc($queryBatch);
		// ******************** END- GETTING NEWSLETTERS BATCH FROM SYSTEM *********************************************************



		// ******************** SENDING ACTIVE NEWSLETTERS *************************************************************************
		$queryNewsletters = mysql_query("SELECT	id, content, current_sent, status, sending_failed, tittle
										 FROM	newsletters
										 WHERE	status = '1';")or die(mysql_error());

		while( $newsletter = mysql_fetch_assoc($queryNewsletters) )
		{

			   $_sql="SELECT	id, email, concat(name, ' ', last_name) AS nameUsr
						FROM	users
						ORDER BY id ASC
						LIMIT ".$newsletter[current_sent].", ".$queryBatch[batch].";";

			$queryIdUsers = mysql_query($_sql)or die(mysql_error());

			if( mysql_num_rows($queryIdUsers)>0 )
			{
				$pendingMails = false;
				while( $user = mysql_fetch_assoc($queryIdUsers) )
				{
					$body = formatMail($newsletter[content], $formatMailWidth);
					$subject = $newsletter[tittle].' - '.$user[nameUsr];
					sendMail($body, $from, $fromName, $subject, $user['email'], $path);

				}
				mysql_query("	UPDATE newsletters
								SET	current_sent = current_sent + '".$queryBatch[batch]."'
								WHERE id = '".$newsletter[id]."';");
			}
		}
		// ******************** END - SENDING ACTIVE NEWSLETTERS *******************************************************************
}
?>
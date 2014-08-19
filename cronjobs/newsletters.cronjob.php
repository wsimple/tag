<?php
$_cronjob=true;
include '../includes/config.php';
include '../class/wconecta.class.php';
include '../includes/conexion.php';
include '../class/class.phpmailer.php';
include '../includes/functions.php';
include ("../includes/languages.config.php");







// ******************** SOME MAIL DATA *************************************************************************************
$from = EMAIL_NO_RESPONDA;
$fromName = 'Tagbum.com';
$path = '../';
$formatMailWidth = "750";
// ******************** END - SOME MAIL DATA *******************************************************************************







// ******************** GETTING NEWSLETTERS BATCH FROM SYSTEM **************************************************************
$queryBatch = mysql_query("SELECT newsletters_batch AS batch FROM config_system;");
$queryBatch = mysql_fetch_assoc($queryBatch);
// ******************** END- GETTING NEWSLETTERS BATCH FROM SYSTEM *********************************************************







// ******************** SENDING ACTIVE NEWSLETTERS *************************************************************************
$queryNewsletters = mysql_query("SELECT	id, content, current_sent, status, sending_failed, tittle
								 FROM	newsletters
								 WHERE	status = '1';");

while( $newsletter = mysql_fetch_assoc($queryNewsletters) )
{
	$queryIdUsers = mysql_query("	SELECT	id, email, concat(name, ' ', last_name) AS nameUsr
									FROM	users
									WHERE	status = '1'
									ORDER BY id ASC
									LIMIT ".$newsletter[current_sent].", ".$queryBatch[batch].";");

	if( mysql_num_rows($queryIdUsers)>0 )
	{
		$pendingMails = false;
		while( $user = mysql_fetch_assoc($queryIdUsers) )
		{
			$body = formatMail($newsletter[content], $formatMailWidth);
			$subject = "Notification for ".$user[nameUsr]." (".$newsletter[tittle].")";

			if( !sendMail($body, $from, $fromName, $subject, $user[email], $path) )
			{
				$pendingMails = true;
				mysql_query("	UPDATE newsletters
								SET sending_failed = CONCAT(sending_failed, '".$user[id]."-')
								WHERE id = '".$newsletter[id]."';");
			}
		}
		mysql_query("	UPDATE newsletters
						SET	current_sent = current_sent + '".$queryBatch[batch]."',
							status = '".( $pendingMails ? '5' : '6' )."'
						WHERE id = '".$newsletter[id]."';");
	}
}
// ******************** END - SENDING ACTIVE NEWSLETTERS *******************************************************************







// ******************** TRYING TO RESEND OUTSTANDING NEWSLETTERS ***********************************************************
$queryNewsletters = mysql_query("SELECT	id, content, tittle, sending_failed
								 FROM	newsletters
								 WHERE	sending_failed end!= '' AND ( status = '5' OR status = '6' );");

while( $newsletter = mysql_fetch_assoc($queryNewsletters) )
{
	$pendingEmails = explode("-", $newsletter[sending_failed]);
	foreach( $pendingEmails as $pendingEmail )
	{
		if( is_integer($pendingEmail) )
		{
			$queryIdUsers = mysql_query("	SELECT id, email, concat(name,' ',last_name) AS nameUsr
											FROM users
											WHERE id = '".$pendingEmail."';");

			if( mysql_num_rows($queryIdUsers)==1 )
			{
				$user = mysql_fetch_assoc($queryIdUsers);
				$body		= formatMail($newsletter[content], $formatMailWidth);
				$subject	= "Notification for ".$user[nameUsr]." (".$newsletter[tittle].")";

				if( sendMail($body, $from, $fromName, $subject, $user[email], $path) )
				{
					mysql_query("	UPDATE	newsletters
									SET	sending_failed = REPLACE(sending_failed,'-".$user[id]."-','-')
									WHERE id = '".$newsletter[id]."';");
				}
			}
		}
	}
}
// ******************** END - TRYING TO RESEND OUTSTANDING NEWSLETTERS *****************************************************
?>

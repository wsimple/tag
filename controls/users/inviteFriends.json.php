<?php
session_start();
include ("../../includes/functions.php");

if (quitar_inyect()){
	include ("../../includes/config.php");
	include ("../../class/wconecta.class.php");
	include ("../../includes/languages.config.php");
	include ("../../includes/functions_mails.php");
	include ("../../class/class.phpmailer.php");

	 //_imprimir($_POST);
	$jsonResult = array('status' => 0);

	if(isset($_POST[message]))
		$msj_body   = trim($_POST[message]);
	else
		$msj_body = EMAIL_INVITEFRIEND;

	$tr = '';
	if ($msj_body!=""){
		$tr = '
		<tr>
			<td style="text-align:left; font-size:14px; padding:0"><strong>'.INVITEUSERS_CTRLBODYLABELMSG.',</strong></td>
		</tr>
		<tr>
			<td>'.convertir_especiales_html($msj_body).'</td>
		</tr>

		';
	}

	$body = '
	<table width="700" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
		<tr>
			<td style="text-align:left; font-size:18px; padding:0; color: #ff8a28;"><strong>'.formatoCadena($_SESSION['ws-tags']['ws-user'][full_name]).', '.INVITEUSERS_CTRLSUBJECT.'</strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="font-size:11px; color:#000; padding:0; text-align:justify">
				'.INVITEUSERS_CTRLBODYMAIL1.'  <br>
				<a href="'.base_url('signup').'">'.DOMINIO.'/signup</a>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		'.$tr.'
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:left; font-size:14px; padding:0"><strong>'.INVITEUSERS_CTRLBODYLABELABOUT.'.</strong></td>
		</tr>
		<tr>
			<td style="font-size:11px; color:#000; padding:0; text-align:justify">
				'.INVITEUSERS_CTRLBODYABOUT.'
			</td>
		</tr>
	</table>';

	if( $_POST[emails] || $_GET['email'] ) {
		$personas	= trim($_POST[emails]); //Limpiamos
		$perso='';

		if (is_array($_POST[emails])) {
			foreach( $personas as $per ) {
				if( $per ) {
					$perso.=($perso!= '')?', '.$per:' '.$per;
					if(sendMail(formatMail($body,800), EMAIL_NO_RESPONDA, 'Tagbum.com', $_SESSION['ws-tags']['ws-user']['full_name'].', '.INVITEUSERS_CTRLSUBJECT, $per,     '../../') )
						$jsonResult['status'] = 1;
				}
			}
		}else{
			if(sendMail(formatMail($body,800), EMAIL_NO_RESPONDA, 'Tagbum.com', $_SESSION['ws-tags']['ws-user']['full_name'].', '.INVITEUSERS_CTRLSUBJECT, $_GET['email'],'../../') )
				$jsonResult['status'] = 1;
		}
	}//if mails
}
die(jsonp($jsonResult));
?>


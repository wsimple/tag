<?php
     session_start();
	 include ("../../includes/functions.php");

	 if (quitar_inyect()){
		 include ("../../includes/config.php");
		 include ("../../class/wconecta.class.php");
		 include ("../../includes/languages.config.php");
		 include ("../../class/class.phpmailer.php");

		 //_imprimir($_POST);

		 $msj_body = trim($_POST[message]);

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
					<a href="'.DOMINIO.'/signup">'.DOMINIO.'/signup</a>
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

		//echo $body;

		if( $_POST[emails] ) {
			$personas	= trim($_POST[emails]);
			$persona	= explode(',', $personas);
			$correos	= 0;
			$perso='';
			foreach( $persona as $per ) {
				if( $per ) {
					$perso.=($perso!= '')?', '.$per:' '.$per;
					//	sendMail($body,                 $from,                   $fromName,      $subject,                                     $address,                  $path='')
					if(sendMail(formatMail($body,800), 'no-reply@tagbum.com', 'Tagbum.com', $_SESSION['ws-tags']['ws-user']['full_name'].', '.INVITEUSERS_CTRLSUBJECT, $per,     '../../') )
						$correos = 1;
				}
			}
		}//if mails


		 if ($correos == 1)
		    echo '<div class="div_exito">'.INVITEUSERTOSYSTEM_CTRSSENDMAILTOFRIEND.$perso.'</div>';
		 else
		    echo '<div class="div_error">'.INVITEUSERTOSYSTEM_CTRSSENDMAILTOFRIENDERROR.'</div>';

	 }

?>


<?php

    include ("includes/session.php");

	include ("includes/config.php");

	include ("includes/functions.php");

	include ("class/wconecta.class.php");
	
	include ("class/class.phpmailer.php");
	
	include ("includes/languages.config.php");
	
	include ("class/validation.class.php");

    
    $registro = '
							<table width="700" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
							<tr>
							<td><strong>'.SIGNUP_BODYEMAIL1.', '.cls_string('Gustavi').' '.cls_string('Ocanto').'</strong></td>
							</tr>
							<tr>
							<td style="color:#666">'.SIGNUP_BODYEMAIL2.':</td>
							</tr>
							<tr>
							<td><a href="'.DOMINIO.'?keyusr='.md5('2_gustavoocanto@gmail.com_2').'">'.DOMINIO.'?keyusr='.md5('2_gustavoocanto@gmail.com_2').'</a></td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							</tr>
							<tr>
							<td style="color:#666">'.SIGNUP_BODYEMAIL3.'.</td>
							</tr>
							<tr>
							<td><em style="font-size:10px; color:#999">'.SIGNUP_BODYEMAIL4.'</em></td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							</tr>
							<tr>
							<td style="border-top:1px solid #666; text-align:justify; font-size:11px; color:#CCC">'.SIGNUP_BODYEMAIL5.'. </td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							</tr>
							</table>				
				';
	
	//tags
	$tags = $GLOBALS['cn']->query("
		SELECT
			(SELECT screen_name FROM users u WHERE u.id=t.id_creator)									AS nameUsr,
			(SELECT screen_name FROM users u WHERE u.id=t.id_user)										AS nameUsr2,
			(SELECT md5(CONCAT(u.id, '_', u.email, '_', u.id)) FROM users u WHERE u.id=t.id_creator)	AS code,
			(SELECT u.profile_image_url FROM users u WHERE u.id=t.id_creator)							AS photoUser,
			t.id							AS idTag,
			t.id_user						AS idUser,
			t.id_creator					AS idCreator,
			t.code_number					AS code_number,
			t.color_code					AS color_code,
			t.color_code2					AS color_code2,
			t.color_code3					AS color_code3,
			t.text							AS texto,
			t.text2							AS texto2,
			t.date							AS fechaTag,
			t.background					AS fondoTag,
			t.video_url						AS video_url,
			u.email							AS email,
			u.referee_number				AS referee_number
		FROM tags t INNER JOIN users u ON t.id_creator = u.id
		WHERE md5(t.id) = '".md5(63)."'");

	$tag   = mysql_fetch_assoc($tags);

	//incHitsTag($tag[idTag]); //incremento de hits a la tag que se recibe

	//obtenemos los email

    $_GET[mails] = 'ertesteo@hotmail.com,gustavoocanto@gmail.com'; 

	if ($_GET[mails]!=""){
		$personas = trim(trim($_GET[mails],','));
		$persona  = explode(',', $personas);
		$correos  = "";
		foreach ($persona as $per){

				 if ($per!='' && valid::isEmail($per)) {

						//imagenes del email
						$backg		= (strpos(' '.$tag[fondoTag],'default')?DOMINIO:FILESERVER).'img/templates/'.$tag[fondoTag];
						$placa		= DOMINIO.'img/placaFondo.png';
						$linkTag	= DOMINIO.'?current=viewTag&tag='.md5($tag[idTag]).'&referee='.$_SESSION['ws-tags']['ws-user'][code].'&email='.md5($per);

						$foto_usuario   = ($tag[photoUser]!='')	 ? (FILESERVER."img/users/".$tag[code]."/".$tag[photoUser])	: (DOMINIO."img/users/default.jpg");
						$foto_remitente = ($_SESSION['ws-tags']['ws-user'][photo]!='')	? (FILESERVER."img/users/".$_SESSION['ws-tags']['ws-user'][code]."/".$_SESSION['ws-tags']['ws-user'][photo]) : (DOMINIO."img/users/default.jpg");

						//product tags
						if( $product=isProductTag($tag[idTag]) ) {
							$foto_usuario = FILESERVER."img/products/".$product[picture];
							$tag[nameUsr] = $product[name];
						}


						//insert tabla verificacion
						if( !existe("tags_share_mails", "id_tag", " WHERE id_tag = '".$_GET[tag]."' AND referee_number = '".$_SESSION['ws-tags']['ws-user'][code]."' AND email_destiny = '".$per."' ") ) {
							$insert  = $GLOBALS['cn']->query("INSERT INTO tags_share_mails SET id_tag          = '".$_GET[tag]."',
																							   referee_number  = '".$_SESSION['ws-tags']['ws-user'][code]."',
																							   email_destiny   = '".$per."',
																							   view            = '0';");
						}
						////

						if ($_GET[msj]!=""){
							$trMsj = '
										<tr>
										<td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.$_GET[msj].'</td>
										</tr>
									 ';
						} else {
							$trMsj = '';
						}

						//cuerpo del email

						$body  = '
									<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

									<tr>
										<td style="padding-left:5px; font-size:14px; text-align:left">
											<img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:1px solid #CCCCCC" />
										</td>
									</tr>
									<tr>
										<td style="color:#000; padding-left:5px; font-size:14px">
											<strong>Gustavo Ocanto</strong>, '.MENUTAG_CTRSHAREMAILTITLE1.'.
										</td>
									</tr>

									'.$trMsj.'

									<tr>
									<td>&nbsp;</td>
									</tr>


									<tr>
										<td style="color:#999; text-align:center; font-size:14px; font-weight:bold">
											<a href="'.$linkTag.'">'.MENUTAG_CTRSHAREMAILTITLE2.'</a>.
										</td>
									</tr>
									
									<tr>
									<td>&nbsp;</td>
									</tr>
									
									<tr>
										<td valign="top">

										<table width="650" height="300" border="0" align="center" background="'.$backg.'" style="border-radius:30px;behavior: url(border-radius.htc); -moz-border-radius:30px;-webkit-border-radius:30px;font-family: Verdana, Geneva, sans-serif;background-position:left top;">
											<tr>
												<td background="'.$placa .'" style="background-position:left top" valign="top">
													<table width="605" border="0" align="center" style="margin-top:52px; color:#FFFFFF; margin-left:25px;text-shadow: 2px 2px 2px #000;filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#000000\', Direction=135, Strength=4);">
														<tr>
															<td colspan="3" style="color:'.(($tag[color_code]!="")?$tag[color_code]:"#FFFFFF").'"><h5 style="font-size: 20px;padding:0; width:100%; text-align:center; padding:0; margin:0;">'.str_replace('&nbsp',' ', $tag[texto]).'</h5></td>
														</tr>
														<tr>
															<td colspan="3" style="color:'.(($tag[color_code2]!="")?$tag[color_code2]:"#FFFFFF").'; padding:0; "><p style="padding:0; margin:0; margin-top:-15px; font-size:110px; letter-spacing:-10px; text-transform:uppercase; text-align:center; ">'.str_replace('&nbsp',' ', $tag[code_number]).'</p></td>
														</tr>
														<tr>
															<td width="60" rowspan="2" valign="top" style="padding-top:3px;"><img  src="'.$foto_usuario.'" border="0" width="60" height="60" style="border:1px solid #FFFFFF" /></td>
															<td width="465"><h4 style="font-size:20px; margin:0; margin-top:-15px;">'.$tag[nameUsr].'</h4></td>
															<td width="58" rowspan="2" style="padding-top:3px;">'.$video.'</td>
														</tr>
														<tr>
															<td style="color:'.(($tag[color_code3]!="")?$tag[color_code3]:"#FFFFFF").'" valign="top"><h6 style="font-size:12px;padding:0; margin:0px;">'.str_replace('&nbsp',' ', $tag[texto2]).'</h6></td>
														</tr>
													</table>
												</td>
											</tr>

										</table>


										</td>
									</tr>
									
									</table>

									

									<br><br>

									<div align="center"style="color:#999; padding-left:5px; text-align:center">'.MENUTAG_CTRSHAREMAILTITLE3.': <a href="'.$linkTag.'">'.DOMINIO.'</a></div>
								 ';

						//envio del correo
						sendMail(formatMail($body, "750"), "no-reply@seemytag.com", "Seemytag.com", MENUTAG_CTRSHAREMAILASUNTO, $per, "");
						$correos .= "-&nbsp;".$per.".<br/>";
						
						echo formatMail($body, "750")."<br>--<br><br>";

				 }//if per

		}//foreach
	}

   echo formatMail($registro,"800")."<br><br>***************<br><br>";

   if (sendMail(formatMail($registro,'800'), 'no-reply@seemytag.com', 'Seemytag.com', 'Prueba, gustavoocanto@gmail.com ', 'ertesteo@hotmail.com', ''))
       echo "bello";
   else
      echo "fuck"; 


?>


















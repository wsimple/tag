<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function mailTag($tagId,$mails,$msj, $device){
    $tags = $GLOBALS['cn']->query('
		SELECT
			u.screen_name										AS nameUsr,
			(SELECT screen_name FROM users WHERE id=t.id_user)	AS nameUsr2,
			md5(CONCAT(u.id, "_", u.email, "_", u.id))			AS code,
			u.profile_image_url									AS photoUser,
			t.id							AS idTag,
			t.id_user						AS idUser,
			t.id_creator					AS idCreator,
			t.code_number,
			t.color_code,
			t.color_code2,
			t.color_code3,
			t.text							AS texto,
			t.text2							AS texto2,
			t.date							AS fechaTag,
			t.background					AS fondoTag,
			t.video_url,
			u.email,
			u.referee_number
		FROM tags t JOIN users u ON t.id_creator=u.id
		WHERE md5(t.id)="'.intToMd5($tagId).'"
	');
	$tag=mysql_fetch_assoc($tags);

	incHitsTag($tag['idTag']); //incremento de hits a la tag que se recibe

	//obtenemos los email

	if ($mails!=""){
		$personas = trim(trim($mails,','));
		$persona  = explode(',', $personas);
		$correos  = "";
		foreach ($persona as $per){

			if ($per!='' && valid::isEmail($per)) {

				//verificar si el correo esta registrado o no en seemytag
				$query = $GLOBALS['cn']->query('
					SELECT
						u.id AS id,
						u.email AS email
					FROM users u
					WHERE u.email = "'.$per.'"
				');
				$emailUserSend = mysql_fetch_assoc($query);

				if($emailUserSend['email']!=''){
					$sendDataPublicity = $emailUserSend['id'];
				}else{
					$sendDataPublicity = $emailUserSend['email'].'|'.$tag['idTag'];
				}
				//imagenes del email
				$backg			= (strpos(' '.$tag['fondoTag'],'default') ? DOMINIO : FILESERVER).'img/templates/'.$tag['fondoTag'];
				$placa			= DOMINIO.'img/placaFondo.png';
				$linkTag		= DOMINIO.'?current=viewTag&tag='.md5($tag['idTag']).'&referee='.$_SESSION['ws-tags']['ws-user']['code'].'&email='.md5($per);
				$imgTag			= DOMINIO.'includes/tag.php?tag='.md5($tag[idTag]);
				$iconoSpon		= DOMINIO.'/img/menu_users/publicidad.png';
				$foto_usuario   = FILESERVER.getUserPicture($tag['code'].'/'.$tag['photoUser']);
				$foto_remitente	= FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']);
				//product tags
				if( $product=isProductTag($tag['idTag']) ) {
					$foto_usuario = FILESERVER."img/products/".$product['picture'];
					$tag[nameUsr] = $product['name'];
				}
				//insert tabla verificacion
				if( !existe("tags_share_mails", "id_tag", " WHERE id_tag = '".$tagId."' AND referee_number = '".$_SESSION['ws-tags']['ws-user']['code']."' AND email_destiny = '".$per."' ") ) {
					$insert  = $GLOBALS['cn']->query("INSERT INTO tags_share_mails SET
															id_tag		  = '".$tagId."',
															referee_number  = '".$_SESSION['ws-tags']['ws-user']['code']."',
															email_destiny   = '".$per."',
															view			= '0';");
				}
				if ($msj!=""){
					$trMsj='
						<tr>
							<td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.$msj.'</td>
						</tr>
					 ';
				} else {
					$trMsj = '';
				}
				//datos de la tag
				$_texto1 = ($tag['texto']!='&nbsp') ? $tag['texto'] : '<br/>';
				$_texto2 = (trim($tag['code_number'])!='&nbsp') ? $tag['code_number'] : '<br/>';
				$_texto3 = (trim($tag['texto2'])!='&nbsp') ? $tag['texto2'] : '<br/>';
				//cuerpo del email
				$body  = '
					<div style="border-radius:7px; background: #fff; padding-top:25px">
					<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
						<tr>
							<td style="padding-left:5px; font-size:14px; text-align:left">
								<img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:1px solid #CCCCCC" />
							</td>
						</tr>
						<tr>
							<td colspan="2" style="color:#000; padding-left:5px; font-size:14px">
								<strong>'.$_SESSION['ws-tags']['ws-user']['full_name'].'</strong>, '.MENUTAG_CTRSHAREMAILTITLE1.'.
								<div style="padding-left: 50px; padding-top: 3px; float: right;width: 155px; color: #075C7F; height: 22px; border: 1px solid #075C7F; border-radius: 5px; background-color: #AFE6FD">
										<a style="font-weight: bold; color:#075C7F; font-size:12px; text-decoration: none" href="'.$linkTag.'">'.MENUTAG_CTRSHAREMAILTITLE2.'</a>.
								</div>
							</td>
						</tr>
						'.$trMsj.'
						<tr>
						<td>&nbsp;</td>
						</tr>
						<tr>
							<td valign="top">
								<p>&nbsp;</p>
								<p>&nbsp;</p>
								<p><a href="'.$linkTag.'" target="_blank"><img src="'.$imgTag.'"></a></p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
							</td>
						<tr>
							<td><img src="'.$iconoSpon.'" width="16" height="16" border="0" />&nbsp;'.SPONSORTAG_TITLELISPRICEPUBLICITY.'</td>
						</tr>
						<tr>
							<td>
								<p>&nbsp;</p>
								'.showPreferencesMailOthers($sendDataPublicity).'
								<p>&nbsp;</p>
							</td>
						</tr>
					</table>
					</div>
					<br/><br/>
					<div align="center"style="color:#fff; padding-left:5px; text-align:center">'.
						(isset($device) ? 'This tag have been sent using my '.$device : '').'<br/>'.
						MENUTAG_CTRSHAREMAILTITLE3.': <a style="color:#fff" href="'.$linkTag.'">'.DOMINIO.'</a>'.
					'</div>
				';
				//envio del correo
				sendMail(formatMail($body, "790"), "no-reply@seemytag.com", "Seemytag.com", MENUTAG_CTRSHAREMAILASUNTO, $per, "../../");
				$correos .= "-&nbsp;".$per.".<br/>";
			}//if per
		}//foreach
	}
	//echo $body;
	echo (($correos!="")?'<div class="div_exito"><strong>'.MENUTAG_CTRSHAREMAILEXITO.":</strong></div><br><br> ".$correos : '<div class="div_error">'.MENUTAG_CTRSHAREMAILERROR.'</div>');

}
?>

<div style="    ">
<?php
	include('session.php');
	include('config.php');

	include('functions.php');
	include('../class/wconecta.class.php');
	include('languages.config.php');
	include('../class/forms.class.php');


	$idTagRed  = 1778;
	$iconoTipo = DOMINIO.'/img/notifications/like.png';
	$iconoSpon = DOMINIO.'/img/menu_users/publicidad.png';
	$msj_sent  = NOTIFICATIONS_LIKETAGMSJUSERSENT;
	$msj_link  = NOTIFICATIONS_LIKETAGMSJUSERLINK;

		$tags = $GLOBALS['cn']->query('
			SELECT
				u.screen_name AS nameUsr,
				(SELECT screen_name FROM users WHERE id=t.id_user)	AS nameUsr2,
				md5(CONCAT(u.id, "_", u.email, "_", u.id))			AS code,
				u.profile_image_url				AS photoUser,
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
			FROM tags t JOIN users u ON t.id_creator = u.id
			WHERE t.id = "'.$idTagRed.'"
		');

		$tag = mysql_fetch_assoc($tags);
		$sendDataPublicity = $tag['email'].'|'.$tag['idTag'];

		//imagenes del email
		$backg			= (strpos(' '.$tag['fondoTag'],'default')?DOMINIO: FILESERVER).'img/templates/'.$tag[fondoTag];//FILESERVER.'img/templates/'.$tag[fondoTag];
		$placa			= DOMINIO.'img/placaFondo.png';
		$linkTag		= DOMINIO.'?current=viewTag&tag='.md5($tag[idTag]).'&referee='.$_SESSION['ws-tags']['ws-user'][code].'&email='.md5($tag[email]);
		$imgTag			= DOMINIO.'includes/tag.php?tag='.md5($tag[idTag]);
		$videoTag		= ($tag[video_url]!=' ') ? $tag[video_url] : ' ';
		$foto_usuario	=FILESERVER.getUserPicture($tag['code'].'/'.$tag['photoUser']);
		$foto_remitente	=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['code']."/".$_SESSION['ws-tags']['ws-user']['photo']);
		if($videoTag!='http://'){
			if((strpos($videoTag, 'youtube'))||(strpos($videoTag, 'youtu.be'))){
				$cad .='<a href="'.$videoTag.'" target="_blank"><img src="'.DOMINIO.'img/iconvideo.png" title="'.WATCH_VIDEO.'" border="0" style="border:0px; margin:0;" /></a>';
			}else{
				$cad .='<a href="'.$videoTag.'" target="_blank"><img src="'.DOMINIO.'img/iconvimeo.png" title="'.WATCH_VIDEO.'" border="0" style="border:0px; margin:0;" /></a>';
			}
		}

		//datos de la tag
		$_texto1 = ($tag['texto']!='&nbsp') ? $tag['texto'] : '<br/>';
		$_texto2 = (trim($tag['code_number'])!='&nbsp') ? $tag['code_number'] : '<br/>';
		$_texto3 = (trim($tag['texto2'])!='&nbsp') ? $tag['texto2'] : '<br/>';

			//datos de la cabecera del correo del usuario
			$query = $GLOBALS['cn']->query('
				SELECT
					CONCAT(u.name, " ", u.last_name) AS name_user,
					u.username AS username,
					(SELECT a.name FROM countries a WHERE a.id=u.country) AS pais,
					u.followers_count AS followers,
					u.friends_count AS friends
				FROM users u
				WHERE u.id = "'.$_SESSION['ws-tags']['ws-user']['id'].'"
			');
			$array = mysql_fetch_assoc($query);

			if (trim($array['username'])!=''){

				$external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.":&nbsp;<span ><a style='color:#999999' href='".DOMINIO.$array[username]."' onFocus='this.blur();' target='_blank'>".DOMINIO.$array[username]."</a><br>";
			}
			if (trim($array[pais])!=''){

				$pais=USERS_BROWSERFRIENDSLABELCOUNTRY.":&nbsp;<span style='color:#999999'>".$array[pais]."</span><br/>";
			}

		?>
		<?php
		$a = '
		<div style="border-radius:7px; background: #fff; padding-top:25px; width:790px">
		<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
			<tr>
				<td width="68" style="padding-left:5px; font-size:14px; text-align:left">
					<img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:1px solid #CCCCCC" />
				</td>
				<td width="569" style="padding-left:5px; font-size:12px; text-align:left;">
					<div>
						'.$external.'
						'.$pais.'
						'.USERS_BROWSERFRIENDSLABELFRIENDS.'('.$array[friends].'),&nbsp;'.USERS_BROWSERFRIENDSLABELADMIRERS.'('.$array[followers].')
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="color:#000; padding-left:5px; font-size:14px">
					<strong>'.$_SESSION['ws-tags']['ws-user']['full_name'].'</strong>, '.MENUTAG_CTRSHAREMAILTITLE1.'.
					<div style="padding-left: 40px; padding-top: 3px; float: right;width: 155px; color: #075C7F; height: 22px; border: 1px solid #075C7F; border-radius: 5px; background-color: #AFE6FD">
							<a style="font-weight: bold; color:#075C7F; font-size:12px; text-decoration: none" href="'.$linkTag.'">'.MENUTAG_CTRSHAREMAILTITLE2.'</a>.
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p><a href="'.$linkTag.'" target="_blank"><img src="'.$imgTag.'"></a></p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
				</td>
			</tr>
			<tr>
				<td  colspan="2"><img src="'.$iconoSpon.'" width="16" height="16" border="0" />&nbsp;'.SPONSORTAG_TITLELISPRICEPUBLICITY.'</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					<p>&nbsp;</p>
					'.showPreferencesMailOthers($sendDataPublicity).'
					<p>&nbsp;</p>
				</td>
			</tr>
		</table>
		</div>
		<br><br>
		<div align="center"style="color:#fff; padding-left:5px; text-align:center;">'.MENUTAG_CTRSHAREMAILTITLE3.': <a style="color:#fff" href="'.$linkTag.'">'.DOMINIO.'</a></div>
	';
		?>
		<?=formatMail($a,'790')?>



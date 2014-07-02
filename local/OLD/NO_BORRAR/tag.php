<?php
	include ("includes/config.php");

	include ("includes/functions.php");

	include ("class/wconecta.class.php");

	include ("includes/languages.config.php");

	include ("class/forms.class.php");

	include ('class/class.phpmailer.php');

	$tags  = mysql_query("SELECT (SELECT screen_name FROM users u WHERE u.id=t.id_creator) AS nameUsr,
					             (SELECT screen_name FROM users u WHERE u.id=t.id_user) AS nameUsr2,
					             (SELECT md5(CONCAT(u.id, '_', u.email, '_', u.id)) FROM users u WHERE u.id=t.id_creator) AS code,
					             (SELECT u.profile_image_url FROM users u WHERE u.id=t.id_creator) AS photoUser,
					             t.id AS idTag,
					             t.id_user AS idUser,
					             t.id_creator AS idCreator,
					             t.code_number AS code_number,
							     t.color_code AS color_code,
							     t.color_code2 AS color_code2,
							     t.color_code3 AS color_code3,
							     t.`text` AS texto,
							     t.`text2` AS texto2,
							     t.date AS fechaTag,
							     t.background AS fondoTag,
							     t.video_url AS video_url

	                      FROM tags t INNER JOIN users u ON t.id_user = u.id

						  WHERE t.id_creator = '2' AND  t.id='164'
						 ") or die(mysql_error());

	$time   = mysql_fetch_assoc($tags);

	$video = ($time[video_url]!='http://' && $time[video_url]!='') ? '<a href="'.$time[video_url].'" target="_blank"><img src="'.DOMINIO.'img/iconvideo.png" border="0" style="border:0px; margin:0;" /></a>' : '&nbsp;';

	$foto_usuario  = ($time[photoUser]!='') ? FILESERVER."img/users/".$time[code]."/".$time[photoUser] : DOMINIO."img/users/default.jpg";

    //product tags
    if ($product=isProductTag($time[idTag])){
	    $foto_usuario = FILESERVER."img/products/".$product[picture];
	    $time[nameUsr] = $product[name];
    }//fin product tag


	$body = '
				<table width="650" height="300" border="0" align="center" background="'.FILESERVER.'img/templates/'.$time[fondoTag].'" style="border-radius:30px;behavior: url(border-radius.htc); -moz-border-radius:30px;-webkit-border-radius:30px;font-family: Verdana, Geneva, sans-serif;background-position:left top; background-repeat:no-repeat">
					<tr>
						<td background="'.FILESERVER.'img/placaFondo.png" style="background-position:left top" valign="top">
							<table width="605" border="0" align="center" style="margin-top:52px; color:#FFFFFF; margin-left:25px;text-shadow: 2px 2px 2px #000;filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#000000\', Direction=135, Strength=4);">
								<tr>
									<td colspan="3" style="color:'.(($time[color_code]!="")?$time[color_code]:"#FFFFFF").'"><h5 style="font-size: 20px;padding:0; width:100%; text-align:center; padding:0; margin:0;">'.$time[texto].'</h5></td>
								</tr>
								<tr>
									<td colspan="3" style="color:'.(($time[color_code2]!="")?$time[color_code2]:"#FFFFFF").'; padding:0; "><p style="padding:0; margin:0; margin-top:-15px; font-size:110px; letter-spacing:-10px; text-transform:uppercase; text-align:center; ">'.$time[code_number].'</p></td>
								</tr>
								<tr>
									<td width="60" rowspan="2" valign="top" style="padding-top:3px;"><img  src="'.$foto_usuario.'" border="0" width="60" height="60" style="border:1px solid #FFFFFF" /></td>
									<td width="465"><h4 style="font-size:20px; margin:0; margin-top:-15px;">'.$time[nameUsr].'</h4></td>
									<td width="58" rowspan="2" style="padding-top:3px;">'.$video.'</td>
								</tr>
								<tr>
									<td style="color:'.(($time[color_code3]!="")?$time[color_code3]:"#FFFFFF").'" valign="top"><h6 style="font-size:12px;padding:0; margin:0px;">'.$time[texto2].'</h6></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			';

    sendMail($body, "no-reply@seemytag.com", "Seemytag.com", "Prueba de Tag Share mail", "gustavoocanto@gmail.com");
	echo $body;
?>

<span style="text-align:left; "></span>

<a href=""></a>



[	{"key":"Gustavo Ocanto","value":"1"},
	{"key":"Luis Alfredo","value":"3"},
    {"key":"Jorge Maldonado","value":"5"},
    {"key":"adrian esqueda","value":"6"},
    {"key":"jorge Ortuno","value":"9"},
    {"key":"jesus castillo","value":"12"},
    {"key":null,"value":"15"},
    {"key":"Timothy Riley","value":"16"},
    {"key":"Jakeline Colina","value":"41"},
    {"key":"Emilia Herrera","value":"39"},
    {"key":"carlos  fuentes","value":"32"},
    {"key":"cody bailey","value":"36"}
    
    ]
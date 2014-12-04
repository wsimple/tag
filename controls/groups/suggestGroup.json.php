<?php
include '../header.json.php';
include(RELPATH.'class/class.phpmailer.php');
include(RELPATH.'class/validation.class.php');
if ( quitar_inyect() ){


	$msj = $_POST['msj'];
	$mails = $_POST['data'];

	if (count($mails)>0){
		//$personas = trim(trim($mails,','));
		//$persona  = explode(',', $personas);
		$correos="";
		$foto_remitente=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['pic'],'img/users/default.png');
		$share=DOMINIO.'css/smt/tag/groups_default.png';
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
            $external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.":&nbsp;<span ><a style='color:#999999' href='".base_url($array['username'])."' onFocus='this.blur();' target='_blank'>".DOMINIO.$array['username']."</a><br>";
        }else { $external=  formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']); }
        if (trim($array['pais'])!=''){
            $pais=USERS_BROWSERFRIENDSLABELCOUNTRY.":&nbsp;<span style='color:#999999'>".$array['pais']."</span><br/>";
        }
        if ($msj!=""){
            $trMsj = '<tr>
                        <td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.convertir_especiales_html($msj).'</td>
                     </tr>';
        } else { $trMsj = ''; }
        $queryGroup="SELECT name, photo, description AS des
                FROM  `groups`
                WHERE md5(id)='".$_GET['grp']."'
                LIMIT 1";
        $group=$GLOBALS['cn']->query($queryGroup);
        $group=  mysql_fetch_assoc($group);
       
        $groupPhoto= file_exists(RELPATH.'img/groups/'.$group['photo'])?DOMINIO.'img/groups/'.$group['photo']:DOMINIO.'css/smt/groups_default.png';
        
        foreach ($mails as $per){

			if (!strpos($per,'@')){ $per = campo("users", "md5(id)", $per, "email"); }

            if ($per!='' && valid::isEmail($per)) {
				//verificar si el correo esta registrado o no en tagbum
				$query = $GLOBALS['cn']->query('
					SELECT 
						u.id AS id,
						u.email AS email 
					FROM users u
					WHERE u.email = "'.$per.'"
				');

				$emailUserSend = mysql_fetch_assoc($query);
				if($emailUserSend['email']!=''){ $sendDataPublicity = $emailUserSend['id'];}
                else{ $sendDataPublicity = $emailUserSend['email'].'|'.$_GET['grp']; }
				$linkGroup = DOMINIO.base_url('groupsDetails?grp='.$_GET['grp']);

                //cuerpo del email
				$body  = '
                                <table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;border-radius:7px; background: #fff; padding-top:5px">
                                    <tr>
                                        <td style="padding-left:5px; font-size:14px; text-align:left">
                                            <img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:3px solid #CCCCCC" />
                                        </td>
                                        <td width="569" style="padding-left:5px; padding-bottom:20px; font-size:12px; text-align:left;">
                                            <div>
                                                '.$external.'<br>
                                                '.$pais.'<br>
                                                <strong>'.USERS_BROWSERFRIENDSLABELFRIENDS.'('.$array['friends'].'),&nbsp;'.USERS_BROWSERFRIENDSLABELADMIRERS.'('.$array['followers'].')</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="color:#000; padding-left:5px; font-size:14px">
                                            <table style="width:100%;">
                                            <tr>
                                                <td style="width:20px;">
                                                    <img src="'.$share.'" width="16" height="16" border="0" />
                                                </td>
                                                <td style="text-align: left; width:450px;">
                                                    <strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'</strong>'.GROUP_SHAREMAILTITLE1.'
                                                </td>
                                                <td background="'.DOMINIO.'css/smt/email/yellowbutton_get_started2.png" style="width: 140px; height: 22px;  display: inline-block; background-repeat: no-repeat; padding: 10px 14px 5px 5px;">
                                                    <a style="font-weight: bold; color: #2d2d2d; font-size:12px; text-decoration: none" href="'.$linkGroup.'">'.GROUP_SHAREMAILTITLE2.'</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="padding-top: 25px;">
                                                  <img src="'.$groupPhoto.'" width="120" height="80" style="border-radius: 8px;-moz-border-radius: 8px; -ms-border-radius: 8px; -o-border-radius: 8px;">                                                    
                                                  <br>
                                                  <div>
                                                      <strong>'.$group['name'].'</strong><br>
                                                      <span style=" font-size: 10px;">'.$group['des'].'</span>
                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top"> 
											<table width="100%">
												<tr>
													<td width="100%">
														'.$trMsj.'
													</td>
												</tr>
											</table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top">
                                            <center>
                                                <table width="100%">
													<tr>
														<td colspan="2" valign="top" style="border-bottom: 1px #f4f4f4 solid; border-top: 1px #f4f4f4 solid; padding: 8px 0px 0px 0px;">
															<img src="'.DOMINIO.'/css/smt/email/publicidad3.png">
															&nbsp;
															'.USERPUBLICITY_PAYMENT.'
														</td>
													</tr>
													<tr>
														<td colspan="2" valign="top" style="padding: 70px 0px 0px 0px; font-size: 13px; text-align: center; height: 70px;">
															'.PUBLICITYSPACETEXT.'
														</td>
													</tr>
                                                </table>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
										<td colspan="2" valign="top">
											<table width="100%">
												<tr>
													<td align="center"style="padding-left:5px; text-align:center">'.
														GROUP_CTRSHAREMAILTITLE3.': <a href="'.$linkTag.'">Tagbum.com</a>
													</td>
												</tr>
											</table>
										</td>
                                    </tr>
                                </table>';
/*
 * esto es la publicidad en la linia 140 se comento por peticion del cliente 
<tr>
	 <td width="100%">
		 '.showPreferencesMailOthers($sendDataPublicity).'
	 </td>
 </tr>
 */
				//envio del correo
				if (sendMail(formatMail($body, "790"),EMAIL_NO_RESPONDA,formatoCadena($_SESSION['ws-tags']['ws-user'][full_name]), formatoCadena($_SESSION['ws-tags']['ws-user'][full_name]).' '.GROUP_EMAILASUNTOSUGGEST, $per, "../../")){
					$correos .= "-&nbsp;".$per.".<br/>";
					//insert tabla verificacion
					// if( !existe("tags_share_mails", "id_tag", " WHERE id_tag = '".$group['idTag']."' AND referee_number = '".$_SESSION['ws-tags']['ws-user']['code']."' AND email_destiny = '".$per."' ") ) {
					// 	$insert  = $GLOBALS['cn']->query("
					// 		INSERT INTO tags_share_mails SET
					// 			id_tag = '".$_GET['tag']."',
					// 			referee_number = '".$_SESSION['ws-tags']['ws-user']['code']."',
					// 			email_destiny  = '".$per."',
					// 			view = '0'
					// 	");
					// }
				}//end if envio de correo

			}//if per

		}//foreach

	}//if (count($mails)>0)

	//echo (($correos!="")?'<div class="div_exito"><strong>'.GROUP_SUGGESTOKMAIL.":</strong></div><br><br> ".$correos : '<div class="div_error">'.GROUP_SUGGESTERRORMAIL.'</div>');
	$res['menjs']= (($correos!="")?'<div class="div_exito"><strong>'.GROUP_SUGGESTOKMAIL.":</strong></div><br><br> ".$correos : '<div class="div_error">'.GROUP_SUGGESTERRORMAIL.'</div>');
}
die(jsonp($res));
?>

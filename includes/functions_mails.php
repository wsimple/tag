<?php

/**
* returns the main body the emails
* retorna el cuerpo principal de los emails
*
* @param string $body  (cuerpo especifico del email)
* @param int $width width body (ancho del cuerpo)
* @return string
*/
function formatMail ($body,$width=800){ 
	return '<table width="'.$width.'" align="center" cellpadding="0" cellspacing="0" style="font-family:\'Lucida Grande\',Tahoma,Verdana,Arial,Sans-Serif;">
			<tr>
				<td style="text-align:right;font-size:10px;padding-bottom:5px;">
					<a href="'.$GLOBALS['config']->main_server.'" style="padding-left:5px;text-decoration:none;color:#2d2d2d;" target="_blank">'.EMAILCONTACTNUMBER.''.EMAILCONTACTLETTER.'</a>
					<span style="padding-left:5px;">|</span>
					<a href="'.$GLOBALS['config']->main_server.'signup" style="padding-left:5px;text-decoration:none;color:#2d2d2d;" target="_blank">'.EMAIL_APP.'<br>
				</td>
			</tr>
			<tr>
				<td align="center">
					<table background="'.$GLOBALS['config']->main_server.'css/smt/email/body_bgn2.png" cellpadding="0" cellspacing="0" style="width:100%;border:2px #ccc solid;border-radius:5px;">
						<tr>
							<td></td>
							<td background="'.$GLOBALS['config']->main_server.'css/tbum/email/bg_logo.png" id="head-logo" style="text-align:right;padding-top:15px;padding-right:15px;">
								<table style="width: 100%;"><tr>
									<td align="left"><a href="'.$GLOBALS['config']->main_server.'" target="blank"><img src="'.$GLOBALS['config']->main_server.'css/tbum/email/tagbumlogo_1.png" style="border:none; margin: 40px;height:100px;width:85px;" alt="tagbum.com"></a></td>
									<td align="right"><a href="'.$GLOBALS['config']->main_server.'" target="blank"><img src="'.$GLOBALS['config']->main_server.'css/tbum/email/tagbumlogo_2.png" style="border:none;margin:40px;height:100px;width:180px" alt="tagbum.com"></a></td>
								</tr></table>
							</td>
						</tr>
						<tr>
							<td></td>
							<td style="width:100%;height:25px;text-align:center;">
								<img src="'.$GLOBALS['config']->main_server.'css/smt/horizontal_separator.png">
							</td>
						</tr>
						<tr><td></td>
							<td id="publicity" style="text-align:center;font-size:11px;padding:5px;color:#999999;">
								'.$body.'
							</td>
						</tr>
						<tr><td></td><td style="width:100%;border-top:1px #f4f4f4 solid;"></td></tr>
						<tr>
							<td></td><td style="width:100%;border:1px #f4f4f4 solid;text-align: center;height: 40px;">'.ucfirst(USERS_DNOTRECEIVEEMAILS).' <a href="'.$GLOBALS['config']->main_server.base_url('setting?sc=1').'" target="_blank" style="color:#ff8a28;">'.SIGNUP_H5TITLE1.'</a></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<center>
									<table cellspacing="0" cellpadding="0" style=" width:390px;">
										<tr>
											<td>
												<table style="text-align:center;">
													<tr>
														<td>
															<center><table>
																<tr>
																	<td background="'.$GLOBALS['config']->main_server.'css/smt/email/yellowbutton_for_points.png" style="background-repeat:no-repeat;color:#ff8a28;font-size:11px;height:50px;">
																		<a href="'.$GLOBALS['config']->main_server.'" style="padding:38px 27px 10px 24px;">
																			<img src="'.$GLOBALS['config']->main_server.'css/smt/email/green1000points.png">
																		</a>
																	</td>
																</tr>
															</table></center>
														</td>
													</tr>
													<tr>
														<td style="width:190px;color:#ff8a28;font-size:11px;">
															<h2 style="-webkit-margin-before:0.23em;-webkit-margin-after:0.23em;">
																<span style="color:#b7b900;">$</span>
																<span style="color:#ff8a28;">'.EMAIL_REDEEMPOINTS.'</span>
																<span style="color:#b7b900;">$</span>
															</h2>
															<span style="color:#000">'.EMAIL_POINTSCollect.'</span>
															'.EMAIL_POINTS.'
														</td>
													</tr>
												</table>
											</td>
											<td >
												<table background="'.$GLOBALS['config']->main_server.'css/smt/email/gray_dotter_line.png" style="background-repeat:no-repeat;padding:12px 33px 31px 49px;">
													<tr>
														<td background="'.$GLOBALS['config']->main_server.'css/smt/email/yellowbutton_get_started.png" style="background-repeat:no-repeat;width:90px;padding:10px;">
															<a href="'.$GLOBALS['config']->main_server.'" style="color:#2d2d2d;font-size:12px;text-decoration:none;padding:8px 26px 8px 10px;">
																<strong >'.EMAIL_INI.'</strong>
															</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td style="text-align:center;">
								<img src="'.$GLOBALS['config']->main_server.'css/smt/email/background_buildings.png" style="text-align:center;">
							</td>
						</tr>
						<tr style="border-buttom:1px #ccc solid;border-radius:2px;">
							<td></td>
							<td style="text-align:center;font-size:11px;">
								<center>
									<table cellpadding="0" cellspacing="25" class="font-b" style="color:rgb(255,138,40);font-size:11px;">
										<tr>
											<td style="text-align:center;">
												<a href="'.$GLOBALS['config']->main_server.'signup" target="_blank">
													<img src="'.$GLOBALS['config']->main_server.'css/smt/email/creat_tag_icon.png" style=" padding:11px 23px 7px 23px;border:2px #ccc solid;border-radius:5px;"><br>
												</a>
												<strong>'.EMAILCREATETAGS.'</strong>
											</td>
											<td style="text-align:center;">
												<a href="'.$GLOBALS['config']->main_server.'signup" target="_blank">
													<img src="'.$GLOBALS['config']->main_server.'css/smt/email/share_tag_icon.png" style="padding:11px 23px 7px 23px;border:2px #ccc solid;border-radius:5px;"><br>
												</a>
												<strong>'.EMAILSTAGS.'</strong>
											</td>
											<td style="text-align:center;">
												<a href="'.$GLOBALS['config']->main_server.'signup" target="_blank">
													<img src="'.$GLOBALS['config']->main_server.'css/smt/email/redistribute_tags_icon.png" style="padding:12px 16px 11px 15px;border:2px #ccc solid;border-radius:5px;"><br>
												</a>
												<strong>'.EMAILRTAGS.'</strong>
											</td>
											<td style="text-align:center;">
												<a href="'.$GLOBALS['config']->main_server.'signup" target="_blank">
													<img src="'.$GLOBALS['config']->main_server.'css/smt/email/sponsor_tags_icon.png" style="padding:11px 27px 7px 27px;border:2px #ccc solid;border-radius:5px;"><br>
												</a>
												<strong>'.EMAILSPTAGS.'</strong>
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr><td></td><td style="border-bottom:1px #ccc solid;"></td></tr>
						<tr>
							<td></td>
							<td style="font-size:12px;text-align:center;padding:10px;">
									'.EMAIL_OPTIONTAGS.' <span style="color:rgb(255,138,40)">'.EMAIL_OPTIONTag.'</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding-top:5px;">
					<table style="width:100%;">
						<td id="email-socialMedia">
							<a href="https://www.facebook.com/pages/Tagbum/182709268463153?ref=ts&fref=ts" target="_blank"><img src="'.$GLOBALS['config']->main_server.'css/smt/email/facebook.png" style="text-align:left;border:none;"></a>
							<a href="https://twitter.com/tag_bum" target="_blank"><img src="'.$GLOBALS['config']->main_server.'css/smt/email/twitter.png" style="text-align:left;border:none;"></a>
							<a href="http://www.linkedin.com/in/tagbum/" target="_blank"><img src="'.$GLOBALS['config']->main_server.'css/smt/email/likedIn.png" style="text-align:left;border:none;"></a>
							<a href="https://plus.google.com/u/0/105016519974283790958" target="_blank"><img src="'.$GLOBALS['config']->main_server.'css/smt/email/google.png" style="text-align:left;border:none;"></a>
						</td>
						<td id="email-pie_terms" style="font-size:10px;text-align:right;">
							<a href="'.$GLOBALS['config']->main_server.'terms" style="padding-right:5px;text-decoration:none;color:#2d2d2d;" target="_blank">'.EMAIL_TERMS.'</a>
						</td>
					</table>
				</td>
			</tr>
			<tr>
				<td style="width:100%;font-size:11px;color:#cccccc"><center>'.EMAIL_ENDNOTE.'</center></td>
			</tr>
	</table>';
}

function showInfoUser($id=''){
	if ($id!=''){
		$array = CON::getRow("SELECT u.id,
			                    CONCAT(u.name,' ', u.last_name) AS full_name,
			                    md5(concat(u.id,'_',u.email,'_',u.id)) AS code,
			                    u.profile_image_url AS photo,
			                    u.username AS username,
			                    (SELECT a.name FROM countries a WHERE a.id=u.country) AS pais,
			                    u.followers_count,
			                    u.friends_count
	            			FROM users u
	            			WHERE u.id =?",array($id));		
	}else{
		if (!isset($_SESSION['ws-tags']['ws-user']['pais']))
			$_SESSION['ws-tags']['ws-user']['pais']=CON::getVal("SELECT a.name AS pais
																FROM users u 
																INNER JOIN countries a ON a.id=u.country
																WHERE u.id =? LIMIT 1",array($_SESSION['ws-tags']['ws-user']['id']));
		$array=$_SESSION['ws-tags']['ws-user'];
	}
	$foto_remitente=FILESERVER.getUserPicture("img/users/".$array['code']."/".$array['photo'],'img/users/default.png');
    if (trim($array['username'])!='') 
    	$external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.':&nbsp;<a href="'.$GLOBALS['config']->main_server.$array['username'].'"  target="_blank">'.$GLOBALS['config']->main_server.formatoCadena($array['username']).'</a>';
    else $external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.':&nbsp;<a href="'.$GLOBALS['config']->main_server.'user/'.md5($array['id']).'" target="_blank">'.$GLOBALS['config']->main_server.'user/'.md5($array['id']).'</a>';
    
    if (trim($array['pais'])!='') $pais=USERS_BROWSERFRIENDSLABELCOUNTRY.':&nbsp;<span>'.$array['pais'].'</span>';
    else $pais='';
	return ('<tr><td><table style="width:100%;">
				<tr>
					<td width="68" style="padding-left:5px;padding-bottom:20px;font-size:14px;text-align:left">
						<img src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:1px #ccc solid;border-radius: 50%;" alt="user" >
					</td>
					<td width="569" style="padding-left:5px;padding-bottom:20px;font-size:12px;text-align:left;">
						<div>
							<strong style="color:#999999">'.USER_LBLNAME.': '.formatoCadena($array['full_name']).'<br>
							<strong style="color:#999999">'.$external.'<br>'.$pais.'<br>
							'.USERS_BROWSERFRIENDSLABELFRIENDS.'('.$array['friends_count'].'),&nbsp;'.USERS_BROWSERFRIENDSLABELADMIRERS.'('.$array['followers_count'].')</strong>
						</div>
					</td>
				</tr>
			</table></td></tr>');
}

function showPublicityMail($data=false){
	return '';
	return ('<tr>
				<td>
					<center><table>
						<tr>
							<td colspan="2" valign="top" style="border-bottom:1px #f4f4f4 solid;border-top:1px #f4f4f4 solid;padding:8px 0px 0px 0px;">
								<img src="'.$GLOBALS['config']->main_server.'css/smt/email/publicidad3.png" alt="publicity">&nbsp;'.USERPUBLICITY_PAYMENT.'
							</td>
						</tr>
						<tr>
							<td colspan="2" valign="top" style="padding:70px 0px 0px 0px;font-size:13px;text-align:center;height:70px;">
								'.PUBLICITYSPACETEXT.'
							</td>
						</tr>
					</table></center>
				</td>
			</tr>');
}
function formatShowTagMail($tagId,$iconoTipo,$msj_sent,$msj_link,$msj=''){
	$tag=CON::getRow("SELECT
			md5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code,
			t.id							AS idTag,
			t.video_url						AS video_url,
			u.email							AS email
		FROM tags t JOIN users u ON t.id_creator=u.id
		WHERE t.id=?",array($tagId));
	//imagenes del email
	// $iconoSpon		=$GLOBALS['config']->main_server.'/img/menu_users/publicidad.png';
	$linkTag		=$GLOBALS['config']->main_server.'tag?id='.$tag['idTag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code'].'&email='.md5($tag['email']);
	$imgTag			=tagURL($tag['idTag']);
	$videoTag		=($tag['video_url']!=' ')?$tag['video_url']:' ';
	if ($msj!=""){
		$trMsj = '<tr><td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.convertir_especiales_html($msj).'</td></tr>';
	} else { $trMsj = ''; }
	$cadCom='
		<div style="border-radius:7px;background:#fff;padding-top:25px">
		<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana,Geneva,sans-serif;font-size:12px">
			'.showInfoUser().'
			<tr>
				<td colspan="2" style="color:#000;padding-left:5px;font-size:14px" >
					<table style="width:100%;">
						<tr>
							<td style="width:20px;"><img src="'.$iconoTipo.'" width="16" height="16" border="0" alt="photo"/></td>
							<td style="text-align:left;width:450px;">
								<strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'</strong>&nbsp;'.formatoCadena($msj_sent).' '.$msj_link.'
							</td>
							<td background="'.$GLOBALS['config']->main_server.'css/smt/email/yellowbutton_get_started2.png" style="width: 150px; height: 40px;  display: inline-block; background-repeat: no-repeat;padding-top: 10px;">
								<a style="font-weight:bold;color:#2d2d2d;font-size:12px;text-decoration:none;margin-left: 40px;" href="'.$linkTag.'">'.MENUTAG_CTRSHAREMAILTITLE2.'</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br><p><a href="'.$linkTag.'" target="_blank"><img src="'.$imgTag.'" alt="tag"></a></p><br></td>
			</tr>
			'.$trMsj.'
			'.showPublicityMail().'
			<tr>
				<td>
					<center><table>
						<tr>
							<td style="padding-left:5px;text-align:center">'.MENUTAG_CTRSHAREMAILTITLE3.': <a href="'.$linkTag.'">Tagbum.com</a>
							</td>
						</tr>
					</table></center>
				</td>
			</tr>
		</table>
		</div>
	';
	return $cadCom;
	//'.showPreferencesMailOthers($sendDataPublicity).' //linia 1724
}

function formatShowFriendsMail($type){
	$res['my']=updateUsersCounters(md5($_SESSION['ws-tags']['ws-user']['id']));
	if (trim($_SESSION['ws-tags']['ws-user']['username'])!=''){
		$nameExternal="<a style='color:#999999;text-decoration:none;' href='".DOMINIO.$_SESSION['ws-tags']['ws-user']['username']."' onFocus='this.blur();' target='_blank'>".formatoCadena($_SESSION['ws-tags']['ws-user']['full_name'])." (".$_SESSION['ws-tags']['ws-user']['screen_name'].")</a>";
		$ip = DOMINIO.$_SESSION['ws-tags']['ws-user']['username'];
	}else{
		$nameExternal="<a style='color:#999999; text-decoration: none' href='".DOMINIO.'user/'.md5($_SESSION['ws-tags']['ws-user']['id'])."' onFocus='this.blur();' target='_blank'>".formatoCadena($_SESSION['ws-tags']['ws-user']['full_name'])." (".$_SESSION['ws-tags']['ws-user']['screen_name'].")</a>";
		$ip = DOMINIO.'user/'.md5($_SESSION['ws-tags']['ws-user']['id']);
	}
	$imgPhoto=($GLOBALS['config']->local?DOMINIO:FILESERVER).getUserPicture("img/users/".$_SESSION['ws-tags']['ws-user']['code']."/".$_SESSION['ws-tags']['ws-user']['photo'],'img/users/default.png');
	$imgPhoto = '<a href="'.$ip.'" onFocus="this.blur();" target="_blank"><img src="'.$imgPhoto.'" width="60" height="60" style="float:right; border:1px #ccc solid;border-radius: 50%;" /></a>';
	$body = '<table width="500" border="0" align="center" cellpadding="2" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
		<tr><td colspan="4" style="text-align:left; font-size:18px; padding:0"><strong>'.$nameExternal.'</strong> '.($type==5?NEWS_FRIENDTAGMSJUSERSENT:MAILFALLOWFRIENDS_SUBJECT).'</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td width="62">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr style="text-align:center; font-weight:bold; background-color:#F4F4F4">
			<td rowspan="2" valign="middle" style="border:1px solid #CCC;">'.$imgPhoto.'</td>
			<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">Tags</td>
			<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">'.MAILFALLOWFRIENDS_ADMIRERS.'</td>
			<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">'.MAILFALLOWFRIENDS_ADMIRED.'</td>
		</tr>
		<tr style="text-align:center; font-weight:bold; background-color:#F4F4F4">
			<td width="108" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($_SESSION['ws-tags']['ws-user']['tags_count']).'</td>
			<td width="157" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($res['my']['admirers']).'</td>
			<td width="147" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($res['my']['admired']).'</td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td colspan="4" style="text-align:center;">'.MAILFALLOWFRIENDS_GOTO.' <a style="text-decoration: none;color:#999999" href="'.DOMINIO.'">Tagbum</a></td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td colspan="4" style="border-top:1px solid #999">&nbsp;</td></tr>
		<tr><td colspan="4" style="font-size:10px; color:#CCC; text-align:justify; padding:0">'.MAILFALLOWFRIENDS_MSGDONW.'</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
	</table>';
	return $body;
}

function formatShowGroupsMail($id_group,$tipe,$msj='',$tag=false){
	$linkGroup = DOMINIO.base_url('groupsDetails?grp='.md5($id_group));
	$share=DOMINIO.'css/smt/tag/groups_default.png';
    //datos de la cabecera del correo del usuario
    if ($msj!=""){
        $trMsj = '<tr>
                    <td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.convertir_especiales_html($msj).'</td>
                 </tr>';
    }else{ $trMsj = ''; }
    if ($tag){
    	$linkTag		=$GLOBALS['config']->main_server.'tag?id='.$tag.'&referee='.$_SESSION['ws-tags']['ws-user']['code'].'&email='.md5($tag['email']);
		$imgTag			=tagURL($tag);
		$trTag='<tr>
			<td colspan="2"><br><p><a href="'.$linkTag.'" target="_blank"><img src="'.$imgTag.'" alt="tag"></a></p><br></td>
		</tr>';
    }else $trTag='';
    $group=CON::getRow("SELECT name, photo, description AS des 
    					FROM  groups
            			WHERE id=? LIMIT 1",array($id_group));
    // $groupPhoto= file_exists($GLOBALS['config']->main_server.'img/groups/'.$group['photo'])?$GLOBALS['config']->main_server.'img/groups/'.$group['photo']:$GLOBALS['config']->main_server.'css/smt/groups_default.png';
	$groupPhoto=($GLOBALS['config']->local?DOMINIO:FILESERVER).'img/groups/'.$group['photo'];
    $groupPhoto=fileExists($groupPhoto)?$groupPhoto:$GLOBALS['config']->main_server.'css/smt/groups_default.png';
	switch ($tipe) {
		case 6: case 14: $textAction=GROUP_EMAILASUNTOSUGGEST; break;
		case 10: $textAction=NOTIFICATIONS_TITLEGROUPSTAGUSER_EMAIL; break;
		case 12: $textAction=NOTIFICATIONS_JOINGROUP; break;
		case 13: $textAction=NOTIFICATIONS_ADMINREQUESTUSERSENT_PLURAL; break;
		default: $textAction=GROUP_SHAREMAILTITLE1; break;
	}
	//cuerpo del email
	$body  = '<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;border-radius:7px; background: #fff; padding-top:5px">
                '.showInfoUser().'
                <tr>
                    <td colspan="2" style="color:#000; padding-left:5px; font-size:14px"><table style="width:100%;">
                        <tr>
                            <td style="width:20px;"><img src="'.$share.'" width="16" height="16" border="0" /></td>
                            <td style="text-align: left; width:450px;">
                                <strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'</strong>'.$textAction.'
                            </td>
                            <td background="'.$GLOBALS['config']->main_server.'css/smt/email/yellowbutton_get_started2.png" style="width: 150px; height: 40px;  display: inline-block; background-repeat: no-repeat;padding-top: 10px;">
                                <a style="font-weight: bold; color: #2d2d2d; font-size:12px; text-decoration: none;margin-left: 20px;" href="'.$linkGroup.'">'.GROUP_SHAREMAILTITLE2.'</a>
                            </td>
                        </tr>
                        <tr>
	                        <td colspan="3" style="padding-top: 25px;">
	                          	<table style="width:100%;"><tr>
	                          	<td style="width: 130px;"><img src="'.$groupPhoto.'" style="width:120px;height:80px;border-radius: 8px;-moz-border-radius: 8px; -ms-border-radius: 8px; -o-border-radius: 8px;overflow: hidden;"/></td>
	                          	<td valign="top" align="left">
									<div><strong>
		                          		<img src="'.$GLOBALS['config']->main_server.'css/smt/menu_left/groups.png" alt="Group Icons" width="30" height="30">
		                          		'.$group['name'].'</strong>
	                          		</div>
	                          		<div style="font-size: 10px;">'.$group['des'].'</div>
	                          	</td>
	                          	</tr></table>	                          	
	                        </td>
	                    </tr>
                    </table></td>
                </tr>
                '.$trTag.'
                <tr>
                    <td colspan="2" valign="top"> 
						<center><table width="100%"><tr><td width="100%">'.$trMsj.'</td></tr></table></center>
                    </td>
                </tr>
				'.showPublicityMail().'
                <tr>
					<td colspan="2" valign="top">
						<table width="100%">
							<tr><td align="center"style="padding-left:5px; text-align:center">'.
									GROUP_CTRSHAREMAILTITLE3.': <a href="'.DOMINIO.'">Tagbum.com</a>
							</td></tr>
						</table>
					</td>
                </tr>
    </table>';
	return $body;
}
function formatShowProductMail($id_product,$tipe,$msj=''){
	$linkGroup = DOMINIO.base_url('detailprod?prd='.md5($id_product));
	$share=DOMINIO.'css/smt/tag/groups_default.png';
    //datos de la cabecera del correo del usuario
    if ($msj!=""){
        $trMsj = '<tr>
                    <td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.convertir_especiales_html($msj).'</td>
                 </tr>';
    }else{ $trMsj = ''; }
    $product=CON::getRow("SELECT name, photo, description AS des 
    					FROM  store_products
            			WHERE id=? LIMIT 1",array($id_product));
    
    $productPhoto = ($GLOBALS['config']->local?DOMINIO:FILESERVER).'img/'.$product['photo'];
	if(!fileExists($productPhoto)) $productPhoto = $GLOBALS['config']->main_server.'imgs/defaultAvatar.png'; 
    
	switch ($tipe) {
		case 29: $textAction=NOTIFICATIONS_STORECOMMENTSMSJUSER_EMAIL; break;
		default: $textAction=NOTIFICATIONS_TITLESTORECOMMENTSMSJUSER_EMAIL; break;
	}
	//cuerpo del email
	$body  = '<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;border-radius:7px; background: #fff; padding-top:5px">
                '.showInfoUser().'
                <tr>
                    <td colspan="2" style="color:#000; padding-left:5px; font-size:14px"><table style="width:100%;">
                        <tr>
                            <td style="width:20px;"><img src="'.$share.'" width="16" height="16" border="0" /></td>
                            <td style="text-align: left; width:450px;">
                                <strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'</strong>'.$textAction.'
                            </td>
                            <td background="'.$GLOBALS['config']->main_server.'css/smt/email/yellowbutton_get_started2.png" style="width: 150px; height: 40px;  display: inline-block; background-repeat: no-repeat;padding-top: 10px;">
                                <a style="font-weight: bold; color: #2d2d2d; font-size:12px; text-decoration: none;margin-left: 20px;" href="'.$linkGroup.'">'.GROUP_SHAREMAILTITLE2.'</a>
                            </td>
                        </tr>
                        <tr>
	                        <td colspan="3" style="padding-top: 25px;">
	                          	<table style="width:100%;"><tr>
	                          	<td style="width: 130px;"><img src="'.$productPhoto.'" style="float:left;width: 150px;height: 130px;margin: 10px 10px;"></td>
	                          	<td valign="top" align="left">
									<div style="font-weight: bold;font-size: 16px;">'.PRODUCTS_NAME.': <span style="color: #f57b1a;">'.$product['name'].'</span></div>
	                          		<div style="font-size: 12px;">'.PRODUCTS_DESCRIPTION.': '.$product['des'].'</div>
	                          	</td>
	                          	</tr></table>	                          	
	                        </td>
	                    </tr>
                    </table></td>
                </tr>
                '.$trTag.'
                <tr>
                    <td colspan="2" valign="top"> 
						<center><table width="100%"><tr><td width="100%">'.$trMsj.'</td></tr></table></center>
                    </td>
                </tr>
				'.showPublicityMail().'
                <tr>
					<td colspan="2" valign="top">
						<table width="100%">
							<tr><td align="center"style="padding-left:5px; text-align:center">'.
									GROUP_CTRSHAREMAILTITLE3.': <a href="'.DOMINIO.'">Tagbum.com</a>
							</td></tr>
						</table>
					</td>
                </tr>
    </table>';
	return $body;
}

function storeCarMail($car,$type=16){
//*********************************************** PREPARACION PARA LOS EMAILS ********************************************************************
	//VARIABLES NECESARIAS
	//array devuelto
	$return=array('seller'=>array(),'buyer'=>array());
	//arrays de banderas para comprovaciones por usuario
	$backgrounds=array(); $productSC=array();
	//arrays que va a llevar los datos de cada vendedor
	$seller=array();
	//variables para crear de forma dinamica el sql para reutilizar los string
	$sql='SELECT
			u.id AS idUser,
			CONCAT(u.name," ",u.last_name) AS name_user,
			u.username AS username,
			u.home_phone,
			u.mobile_phone,
			u.work_phone,
			u.profile_image_url AS photo,
			md5(concat(u.id,\'_\',u.email,\'_\',u.id)) AS code,
			u.type,
			u.email AS email';
	$pais=' ,p.name AS pais,
			c.name AS ciudad,
			u.zip_code,
			u.address AS direccion';
	$join='INNER JOIN countries p ON p.id=u.country
			INNER JOIN cities c ON c.id=u.city';
	$where=' id IN (';
	$limit=0;
//*******************************************************************************************************************************************************
	$product=array();$acumulado_pedido=array();
	foreach ($car as $carrito){
		if (!$carrito['order']){

			$product['id']=$carrito['id'];
			$product['Mid']=md5($carrito['id']);
			$product['id_user']=$carrito['seller'];
			$product['name']=$carrito['name'];
			$product['description']=$carrito['description'];
			$product['photo']=$carrito['photo'];
			$product['place']=$carrito['place'];
			$product['sale_points']=$carrito['sale_points'];
			$product['nameC']=$carrito['category'];
			$product['nameSC']=$carrito['subCategory'];
			$product['id_category']=$carrito['id_category'];
			$product['id_sub_category']=$carrito['id_sub_category'];
			$product['email_seller']=$carrito['email_seller'];
			$product['formPayment']=$carrito['formPayment'];
			$product['productFail']=$carrito['productFail'];
			$product['cant']=$carrito['cant'];
			$product['fail']=$carrito['fail'];

			$cant=$carrito['cant'];$productCost=0;
			if ($carrito['formPayment']!=1)
				$productCost=$product['sale_points']*$cant;

//****************************************************************************************************************************************************************
		
		//armado del arrays que posee todos los datos para la maquetacion del email
		//a diferencia del carrito el email se agrupa por vendedor por eso es necesario ordenar el array de dicha forma
			if (isset($acumulado_pedido[$product['id_user']])){
				$i=count($acumulado_pedido[$product['id_user']]['products']);
				$acumulado_pedido[$product['id_user']]['email_seller']=$product['email_seller'];
				$acumulado_pedido[$product['id_user']]['place']=$product['place'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['id']=$product['id'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['id_user']=$product['id_user'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['name']=$product['name'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['photo']=$product['photo'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['place']=$product['place'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['price2']=$product['sale_points'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['price']=$product['formPayment']=='1'?number_format($product['sale_points'],2,'.',','):number_format($product['sale_points'],0,'',',');;
				$acumulado_pedido[$product['id_user']]['products'][$i]['nameCate']=$product['nameC'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['nameSubCate']=$product['nameSC'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['id_category']=$product['id_category'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['id_sub_category']=$product['id_sub_category'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['cant2']=$product['cant'];
				$acumulado_pedido[$product['id_user']]['products'][$i]['cant']=number_format($product['cant'],0,'',',');
				$acumulado_pedido[$product['id_user']]['products'][$i]['formPayment']=$product['formPayment'];
				if (!$backgrounds[$product['id_user']]&&($product['id_category']==1)) $backgrounds[$product['id_user']]=true;
				if (!$productSC[$product['id_user']]&&($product['id_category']!=1)) $productSC[$product['id_user']]=true;
			}else{
				$acumulado_pedido[$product['id_user']]['total_suma']=$productCost;
				$acumulado_pedido[$product['id_user']]['email_seller']=$product['email_seller'];
				$acumulado_pedido[$product['id_user']]['place']=$product['place'];
				$acumulado_pedido[$product['id_user']]['id_user']=$product['id_user'];
				$acumulado_pedido[$product['id_user']]['products'][0]['id']=$product['id'];
				$acumulado_pedido[$product['id_user']]['products'][0]['id_user']=$product['id_user'];
				$acumulado_pedido[$product['id_user']]['products'][0]['name']=$product['name'];
				$acumulado_pedido[$product['id_user']]['products'][0]['photo']=$product['photo'];
				$acumulado_pedido[$product['id_user']]['products'][0]['place']=$product['place'];
				$acumulado_pedido[$product['id_user']]['products'][0]['price2']=$product['sale_points'];
				$acumulado_pedido[$product['id_user']]['products'][0]['price']=$product['formPayment']=='1'?number_format($product['sale_points'],2,'.',','):number_format($product['sale_points'],0,'',',');
				$acumulado_pedido[$product['id_user']]['products'][0]['nameCate']=$product['nameC'];
				$acumulado_pedido[$product['id_user']]['products'][0]['nameSubCate']=$product['nameSC'];
				$acumulado_pedido[$product['id_user']]['products'][0]['id_category']=$product['id_category'];
				$acumulado_pedido[$product['id_user']]['products'][0]['id_sub_category']=$product['id_sub_category'];
				$acumulado_pedido[$product['id_user']]['products'][0]['cant2']=$product['cant'];
				$acumulado_pedido[$product['id_user']]['products'][0]['cant']=number_format($product['cant'],0,'',',');
				$acumulado_pedido[$product['id_user']]['products'][0]['formPayment']=$product['formPayment'];
				if (isset($product['fail'])) $failOrderStock[$product['id_user']]=true;
				$backgrounds[$product['id_user']]=($product['id_category']==1)?true:false;
				$productSC[$product['id_user']]=($product['id_category']!=1)?true:false;
				$where.=($where==' id IN (')?'"'.$product['id_user'].'"':',"'.$product['id_user'].'"';
				$limit++;
			}
		}
	}
	$where.=')';
//***************************************************COMIENZA EL EMAIL**********************************************************************************

	//consultas a la base de datos para obtener los datos del usuario comprador para los emails de los vendedores
	$query=$GLOBALS['cn']->query($sql.$pais.' FROM users u '.$join.' WHERE u.id="'.$car['order']['comprador'].'" LIMIT 0,1;');
	$array=mysql_fetch_assoc($query);

	//consultas a la base de datos para obtener los datos de los usuarios vendedores para el email del usuario comprador
	$query2=$GLOBALS['cn']->query($sql.' FROM users u WHERE '.$where.' LIMIT 0,'.$limit.';');
	//llenado del vector para tener libre acceso a los datos de los vendedores
	while ($array2=mysql_fetch_assoc($query2)){
		$seller[$array2['idUser']]['id']=$array2['idUser'];
		$seller[$array2['idUser']]['name_user']=$array2['name_user'];
		$seller[$array2['idUser']]['username']=$array2['username'];
		$seller[$array2['idUser']]['home_phone']=$array2['home_phone'];
		$seller[$array2['idUser']]['mobile_phone']=$array2['mobile_phone'];
		$seller[$array2['idUser']]['work_phone']=$array2['work_phone'];
		$seller[$array2['idUser']]['email']=$array2['email'];
		$seller[$array2['idUser']]['type']=$array2['type'];
		$seller[$array2['idUser']]['photo']=FILESERVER.getUserPicture($array2['code']."/".$array2['photo']);
	}

	//foto del usuario comprador
	$foto_remitente=FILESERVER. getUserPicture($array['code']."/".$array['photo']);

	if (trim($array['username'])!=''){
		$external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.":&nbsp;<span ><a style='color:#999999' href='".base_url($array['username'])."' target='_blank'>".$GLOBALS['config']->main_server.$array['username']."</a><br>";
	}else{ $external=formatoCadena($array['name_user']); }
	$pay="";
	if ($type==17) 
		$pay='<td style="width:100%;border:1px #f4f4f4 solid;text-align: center;height: 40px;">
				<a href="'.DOMINIO.base_url('orders').'" target="_blank" style="color:#ff8a28;">'.SEARCHALL_SEEMORECLKHERE.'</a> '.STORE_TIME_END_ORDER.'</td>';
	//cabecera del email para el comprador
	$emailComprador='<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana,Geneva,sans-serif;font-size:12px;border-radius:7px;background:#fff;padding-top:25px;">
						<tr>
							<td style="height:30px;font-size:20px;color:#999;font-weight:bold;text-align:center;">'.($type==16?STORE_PURCHASETITLENEW:NOTIFICATIONS_TITLE_STORE_ORDERS_NO_COMPLETE).' <br><br></td>
						</tr>'.$pay;
	//variables necesarias para el email del comprador
	$bodyEmail='';$totalPuntosAcumulados=0;$totalDolaresAcumulados=0;$countS=0;
	foreach ($acumulado_pedido as $acumulado){

				//bodyEmail es el cuerpo del mensaje al comprador
				$bodyEmail.='<tr>
								<td style="height:30px;font-size:16px;color:#999;font-weight:bold;text-align:left;">'.SELLER.':&nbsp;'.formatoCadena($seller[$acumulado['id_user']]['name_user']).'</td>
							</tr>
							<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana,Geneva,sans-serif;font-size:12px;background:#fff;padding-top:25px;">
									<tr>
										<td>
											<table style="width:100%;">
												<tr>
													<td style="padding-left:5px;font-size:14px;text-align:left">
														<img src="'.$seller[$acumulado['id_user']]['photo'].'" alt="user" border="0" width="60" height="60" style="border:1px solid #CCC; border-radius: 50%;">
													</td>
													<td width="569" style="padding-left:5px;padding-bottom:20px;font-size:12px;text-align:left;">
														<div>';
															if($seller[$acumulado['id_user']]['type']=='0')
																$bodyEmail.='<strong>'.ADDRESSBOOK_LBLHOMEPHOME.': </strong>'.$seller[$acumulado['id_user']]['home_phone'].'<br>';															 
				$bodyEmail.='								<strong>'.EMAIL_SELLER.': </strong>'.$seller[$acumulado['id_user']]['email'].'<br>
															<strong>'.USERPROFILE_LBLMOBILEPHONE.': </strong>'.$seller[$acumulado['id_user']]['mobile_phone'].'<br>
															<strong>'.USERPROFILE_LBLWORKPHONE.': </strong>'.$seller[$acumulado['id_user']]['work_phone'].'</br>
														</div>
													</td>
												 </tr>
											</table>
										</td>
									</tr>';

				//emaelSeller es el cuerpo de los mensajes de cada vendedor
				$emailSeller='<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana,Geneva,sans-serif;font-size:12px;border-radius:7px;background:#fff;padding-top:25px;">
									<tr>
										<td style="height:30px;font-size:24px;color:#999;font-weight:bold;text-align:center;"><strong>'.formatoCadena($array['name_user']).'&nbsp;'.STORE_EMAILSELLER.'</strong><br><br></td>
									</tr>
									<tr>
										<td>
											<table style="width:100%;">
												<tr>
													<td style="padding-left:5px;font-size:14px;text-align:left">
														<img src="'.$foto_remitente.'" alt="user" border="0" width="60" height="60" style="border:1px solid #CCC; border-radius: 50%;">
													</td>
													<td width="569" style="padding-left:5px;padding-bottom:20px;font-size:12px;text-align:left;">
														<div>
															<strong>'.formatoCadena($external).'</strong><br>';
															if($array['type']=='0')
																$emailSeller.='<strong>'.ADDRESSBOOK_LBLHOMEPHOME.':</strong>'.formatoCadena($array['home_phone']).'<br>';
				$emailSeller.='								<strong>'.SIGNUP_LBLEMAIL.': </strong>'.$array['email'].'<br>
														</div>
													</td>
												 </tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="height:30px;font-size:16px;color:#999;font-weight:bold;text-align:left;">'.STORE_SHIPPING.'</td>
									</tr>
									<tr>
										<td>
											<table style="width:100%;">
												<tr>
													<td style="width:120px;"><strong>'.BUSINESSCARD_LBLCOUNTRY.':</strong></td>
													<td style="text-align:left;">'.formatoCadena($array['pais']).'</td>
												</tr>
												<tr>
													<td style="width:120px;"><strong>'.BUSINESSCARD_LBLCITY.':</strong></td>
													<td style="text-align:left;">'.formatoCadena($array['ciudad']).'</td>
												</tr>
												<tr>
													<td style="width:120px;"><strong>'.BUSINESSCARD_LBLADDRESS.':</strong></td>
													<td style="text-align:left;">'.formatoCadena($array['direccion']).'</td>
												</tr>
												<tr>
													<td style="width:120px;"><strong>'.SIGNUP_ZIPCODE.':</strong></td>
													<td style="text-align:left;">'.$array['zip_code'].'</td>
												</tr>
												<tr>
													<td style="width:120px;"><strong>'.USERPROFILE_LBLMOBILEPHONE.':</strong></td>
													<td style="text-align:left;">'.$array['mobile_phone'].'</td>
												</tr>
												<tr>
													<td style="width:120px;"><strong>'.USERPROFILE_LBLWORKPHONE.':</strong></td>
													<td style="text-align:left;">'.$array['work_phone'].'</td>
												</tr>

											</table>
										</td>
									</tr>';
				if (isset($failOrderStock[$acumulado['id_user']])){
					$bodyEmail.='	<tr style="text-align:center;color:#AD3838;">
										<td style="padding:5px;">'.STORE_MAIL_ORDER_FAIL.'</td>
									</tr>';
				}
				//si la venta o la compra fueron unos fondos
				if ($backgrounds[$acumulado['id_user']]){
				 $bodyEmailP='<tr>
									<td style="height:30px;font-size:16px;color:#999;font-weight:bold;text-align:left;">'.NEWTAG_LBLBACKGROUNDS.' <br><br></td>
								</tr>
								<tr>
									<td><center>
										<table>
											<tr style="text-align:center">
												<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:#AD3838;">'.STORE_DETPRDDETAIL.'</td>
												<td style="padding:5px;border-bottom:1px solid #F4F4F4;"></td>
											</tr>';
								$totalPoints=0;$totalDollars=0;
								$bodyEmail.=$bodyEmailP;
								$emailSeller.=$bodyEmailP;
								foreach ($acumulado['products'] as $ordenDetalles){
									if ($ordenDetalles['id_category']==1){

									if ($ordenDetalles['formPayment']==1){
										$totalDollars=$totalDollars+($ordenDetalles['price2']*$ordenDetalles['cant']);
										$totalDolaresAcumulados=$totalDolaresAcumulados+($ordenDetalles['price2']*$ordenDetalles['cant2']);
									}else{
										$totalPoints=$totalPoints+($ordenDetalles['price2']*$ordenDetalles['cant']);
										$totalPuntosAcumulados=$totalPuntosAcumulados+($ordenDetalles['price2']*$ordenDetalles['cant2']);
									}
									$photoBack=($GLOBALS['config']->local?DOMINIO:FILESERVER).'img/'.$ordenDetalles['photo'];
									 $bodyEmail.='<tr style="text-align:center">
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;">
														<img src="'.$photoBack.'" style="width: 150px;height: 130px;margin: 10px 10px;"/></td>
														<td style="border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;text-align:left;width:400px;">
															<strong style="color: #f57b1a;">'.formatoCadena($ordenDetalles['name']).'</strong><br>
															<strong>'.STORE_CATEGORIES2.':</strong> '.formatoCadena($ordenDetalles['nameCate']).'
															<br><span style="color:#AD3838;">'.(($ordenDetalles['formPayment']==1)?'$'.$ordenDetalles['price']:$ordenDetalles['price'].' '.STORE_TITLEPOINTS).'</span>&nbsp;&nbsp;'.QUANTITYSTORE.':'.$ordenDetalles['cant'].'
														</td>
													</tr>';
									 $emailSeller.='<tr style="text-align:center">
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;">
														<img src="'.$photoBack.'" style="width: 150px;height: 130px;margin: 10px 10px;"/></td>
														<td style="border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;text-align:left;width:400px;">
															<strong style="color: #f57b1a;">'.formatoCadena($ordenDetalles['name']).'</strong><br>
															<strong>'.STORE_CATEGORIES2.': </strong>'.formatoCadena($ordenDetalles['nameCate']).'
															<br><span style="color:#AD3838;">'.(($ordenDetalles['formPayment']==1)?'$'.$ordenDetalles['price']:$ordenDetalles['price'].' '.STORE_TITLEPOINTS).'</span>&nbsp;&nbsp;'.QUANTITYSTORE.': '.$ordenDetalles['cant'].'
														</td>
													</tr>';


									}
								}
								$bodyEmailP='<tr style="text-align:center">
									<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:black;">'.SUBTOTAL.'</td>
									<td style="padding:5px;border-bottom:1px solid #F4F4F4;"></td>
								</tr>';
								if ($totalPoints>0){
								$bodyEmailP.='<tr style="text-align:center">
									<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:#AD3838;"><span style="margin-left:20px;">'.STORE_TITLEPOINTS.'</span></td>
									<td style="padding:5px;border-bottom:1px solid #F4F4F4;">'.number_format($totalPoints,0,'',',').'</td>
								</tr>';
								}
								if ($totalDollars>0){
								$bodyEmailP.='<tr style="text-align:center">
									<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:#AD3838;"><span style="margin-left:20px;">'.TYPEPRICEMONEY.'</span></td>
									<td style="padding:5px;border-bottom:1px solid #F4F4F4;">$'.number_format($totalDollars,2,'.',',').'</td>
								</tr>';
								}
							$bodyEmailP.='</table></center>
						</td>
					</tr>';
					$bodyEmail.=$bodyEmailP;
					$emailSeller.=$bodyEmailP;
				}
				//si la compra o venta fueron unos productos
				if ($productSC[$acumulado['id_user']]){
					$bodyEmailP=' <tr>
										<td style="height:30px;font-size:16px;color:#999;font-weight:bold;text-align:left;">'.PRODUCT_TITLE.' <br><br></td>
									</tr>
									<tr>
										<td>
											<center>
												<table>
													<tr style="text-align:center">
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:#AD3838;">'.STORE_DETPRDDETAIL.'</td>
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;"></td>
													</tr>';
									$totalPoints=0;$totalDollars=0;
									$bodyEmail.=$bodyEmailP;
									$emailSeller.=$bodyEmailP;
									foreach ($acumulado['products'] as $ordenDetalles){
										if ($ordenDetalles['id_category']!=1){

											if ($ordenDetalles['formPayment']==1){
												$totalDollars=$totalDollars+($ordenDetalles['price2']*$ordenDetalles['cant2']);
												$totalDolaresAcumulados=$totalDolaresAcumulados+($ordenDetalles['price2']*$ordenDetalles['cant2']);
											}else{
												$totalPoints=$totalPoints+($ordenDetalles['price2']*$ordenDetalles['cant']);
												$totalPuntosAcumulados=$totalPuntosAcumulados+($ordenDetalles['price2']*$ordenDetalles['cant2']);
											}
											$photoBack=($GLOBALS['config']->local?DOMINIO:FILESERVER).'img/'.$ordenDetalles['photo'];
											$bodyEmail.=' <tr style="text-align:center">
																<td style="padding:5px;border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;">
																	<img src="'.$photoBack.'" style="width: 150px;height: 130px;margin: 10px 10px;"/></td>																
																	<td style="border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;text-align:left;width:400px;">
																	<strong style="color: #f57b1a;">'.formatoCadena($ordenDetalles['name']).'</strong><br>
																	<strong>'.STORE_CATEGORIES2.': </strong>'.formatoCadena($ordenDetalles['nameCate']).' <strong>'.STORE_CATEGORIES3.': </strong>'.formatoCadena($ordenDetalles['nameSubCate']).'
																	<br><span style="color:#AD3838;">'.(($ordenDetalles['formPayment']==1)?'$'.$ordenDetalles['price']:$ordenDetalles['price'].' '.STORE_TITLEPOINTS).'</span>&nbsp;&nbsp;'.QUANTITYSTORE.': '.$ordenDetalles['cant'].'
																</td>
															</tr>';
											$emailSeller.=' <tr style="text-align:center">
																<td style="padding:5px;border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;">
																	<img src="'.$photoBack.'" style="width: 150px;height: 130px;margin: 10px 10px;"/></td>																
																	<td style="border-bottom:1px solid #F4F4F4;border-right:1px solid #F4F4F4;text-align:left;width:400px;">
																	<strong style="color: #f57b1a;">'.formatoCadena($ordenDetalles['name']).'</strong><br>
																	<strong>'.STORE_CATEGORIES2.': </strong>'.formatoCadena($ordenDetalles['nameCate']).' <strong>'.STORE_CATEGORIES3.': </strong>'.formatoCadena($ordenDetalles['nameSubCate']).'
																	<br><span style="color:#AD3838;">'.(($ordenDetalles['formPayment']==1)?'$'.$ordenDetalles['price']:$ordenDetalles['price'].' '.STORE_TITLEPOINTS).'</span>&nbsp;&nbsp;'.QUANTITYSTORE.': '.$ordenDetalles['cant'].'
																</td>
															</tr>';
										}
									}
									$bodyEmailP=' <tr style="text-align:center">
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:black">'.SUBTOTAL.'</td>
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;"></td>
													</tr>';
									if($totalPoints>0){
									$bodyEmailP.='	<tr style="text-align:center">
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:#AD3838;"><span style="margin-left:20px;">'.STORE_TITLEPOINTS.'</span></td>
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;">'.number_format($totalPoints,0,'',',').'</td>
													</tr>';
									}
									if($totalDollars>0){
									$bodyEmailP.='	<tr style="text-align:center">
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;font-weight:bold;color:#AD3838;"><span style="margin-left:20px;">'.TYPEPRICEMONEY.'</span></td>
														<td style="padding:5px;border-bottom:1px solid #F4F4F4;">$'.number_format($totalDollars,2,'.',',').'</td>
													</tr>';
									}
									$bodyEmailP.='</table>
											</center>
										</td>
									</tr>';
					$bodyEmail.=$bodyEmailP;
					$emailSeller.=$bodyEmailP;
				}
				$emailSeller.='</table>';

				//envio del email a los vendedores...
				$return['seller'][$countS]['html']=formatMail($emailSeller,'790');
				$return['seller'][$countS++]['email']=$acumulado['email_seller'];
		}
		//unir la cabecera con el cuerpo del email de comprador
		$emailComprador.=$bodyEmail;
		//terminar el email del comprador
		$emailComprador.=' <tr style="text-align:left">
								<td style="padding:5px;font-weight:bold;color:black;">'.TOTAL.' '.STORE_ORDER.'</td>
							</tr>';
		if ($totalPuntosAcumulados>0){
		$emailComprador.='	<tr style="text-align:left">
								<td style="padding:5px;"><span style="font-weight:bold;color:black;margin-left:20px;">'.STORE_TITLEPOINTS.': </span> '.number_format($totalPuntosAcumulados,0,'',',').'</td>
							</tr>';
		}
		if ($totalDolaresAcumulados>0){
		$emailComprador.='	<tr style="text-align:left">
								<td style="padding:5px;"><span style="font-weight:bold;color:black;margin-left:20px;">'.TYPEPRICEMONEY.': </span>$'.number_format($totalDolaresAcumulados,2,'.',',').'</td>
							</tr>';
		}
		$emailComprador.=$pay.'</table>';
		$return['puto']=$acumulado_pedido;
		$return['buyer']['html']=formatMail($emailComprador,'790');
		$return['buyer']['email']=$array['email'];
		$return['buyer']['name']=$array['name_user'];
//fin del envio del correo electronico 
//*************************************************************************************************************************************
	return $return;		
}

function storeEndFreeProducts($winner,$id_raffle){
		$winnerData='<tr><td style="height:30px;font-size:20px;color:#999;font-weight:bold;text-align:center;">'.STORE_RAFFLEWINNER.' <br><br></td></tr>'
		.showInfoUser($winner);
		$raffle=CON::getRow("SELECT 
						 		a.id_user AS id_user, 
						 		a.id_product AS id_product, 
						 		u.email AS email,
						 		p.name AS name,
						 		p.photo AS photo,
						 		p.description AS description,
						 		p.place AS place
						   FROM store_raffle a
						   INNER JOIN store_products p ON p.id=a.id_product
						   INNER JOIN users u ON u.id = a.id_user
						   WHERE a.id=?;",array($id_raffle));
		
		$backg = ($GLOBALS['config']->local?DOMINIO:FILESERVER).'img/'.$raffle['photo'];
		if(!fileExists($backg)) $backg = $GLOBALS['config']->main_server.'imgs/defaultAvatar.png'; 

		$body='<table border="0" align="center" width="700">
					<tr>
						<td style="height:30px; font-size: 20px; color:#F57133; font-weight:bold; border-bottom:1px dotted #CCC;text-align:center;">
						'.STORE_THANKYOUREFFLEEMAIL.'<br><br><div style="font-size:14px; color:#888;">'.STORE_FINALRESULTMAIL.'</div></td>
					</tr>
					<tr><td style="border-top:1px dotted #CCC;">
						<table border="0" width="600" align="center">
							<tr><td colspan="2" style="padding: 10px 0">&nbsp;</td></tr>
							'.$winnerData.'
							<tr>
								<td style="padding: 10px 0 0 0; color:#F57133; font-weight: bold;text-align:left;">'.STORE_RAFFLEPRODUCTEMAIL.':</td>
								<td style="color:#888; padding: 10px 0 0 10px;text-align:left;">'.formatoCadena($raffle['name']).'</td>
							</tr>
							<tr>
								<td style="padding: 4px 0 0 0; color:#F57133; font-weight: bold;  vertical-align: top;text-align:left;">'.STORE_DESCRIPTIONEMAIL.':</td>
								<td style="padding: 0 0 0 10px;color:#888;text-align:justify;">'.$raffle['description'].'</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="padding: 20px 0" ><img src="'.$backg.'" style="width: 150px;height: 130px;margin: 10px 10px;"></td>
							</tr>
						</table>
					</td></tr>
					<tr>
						<td align="center" style="font-size: 12px;padding: 10px 0; color:#777">'.STORE_FOOTERMESAAGESMAIL.' <a target="_blank" href="'.base_url('freeproducts').'">'.PRODUCTS_RAFFLE.'</a></td>
					</tr>
				</table>';
		//correo dueno
		$bodyOwner = '<table border="0" align="center" width="700"><tr>
							<td style="height:30px; font-size: 20px; color:#F57133; font-weight:bold; border-bottom:1px dotted #CCC;text-align:center;">
							'.STORE_RAFFLEENDMESSAGE.'<br><br><div style="font-size:14px; color:#888;">'.STORE_FINALRESULTMAIL.'</div>
						</td></tr>
						<tr><td style="border-top:1px dotted #CCC;">
							<table border="0" width="600" align="center">
								<tr><td colspan="2" style="padding: 20px 0; font-weight: bold; color:#888;">'.STORE_WINNERPRODUCT.' '.formatoCadena($raffle['name']).' '.STORE_WINNERPRODUCTES.':</td></tr>
								'.$winnerData.'
								<tr><td style="padding: 15px 0 0 0; color:#F57133; font-weight: bold;  vertical-align: top" colspan="2" align="center">'.STORE_RAFFLEPRODUCTEMAIL.':</td></tr>
								<tr><td colspan="2" align="center" style="padding: 20px 0" ><img src="'.$backg.'" style="width: 150px;height: 130px;margin: 10px 10px;"></td></tr>
							</table>
						</td></tr>
						<tr>
							<td align="center" style="font-size: 12px;padding: 10px 0; color:#777">'.STORE_FOOTERMESAAGESMAIL.' <a target="_blank" href="'.base_url('freeproducts').'">'.PRODUCTS_RAFFLE.'</a></td>
						</tr>
					</table>';
		return array('email'=>$body,'emailOwner'=>$bodyOwner,'owner'=>$raffle['email']);
}


function showPreferencesMail($data){
	// 	if(is_numeric($data)){
	// 		$id_user=$data;
	// 		$limit_p=3;//limite de registro por consulta
	// 		$like	='';
	// 		$usr	=($id_user!='')?$id_user:$_SESSION['ws-tags']['ws-user']['id'];
	// 		$cad	='';
	// 		$query	=$GLOBALS['cn']->query('SELECT preference FROM users_preferences WHERE id_user="'.$usr.'"');//todas las preferencias del usuario

	// 		while ($array=mysql_fetch_assoc($query)){
	// 				$ids=explode(',',$array[preference]);//vector de preferencias
	// 				foreach ($ids as $index){
	// 						if ($index!=''){
	// 							$validar=$GLOBALS['cn']->query("SELECT id_preference,detail FROM preference_details WHERE id='".replaceCharacters($index)."' ");
	// 							if (mysql_num_rows($validar)==0){
	// 								$cad.=$index.'|';
	// 							}else{
	// 								$valida=mysql_fetch_assoc($validar);
	// 								$cad.=$valida['detail'].'|';
	// 							}
	// 						}//si el dato no esta vacio

	// 				}//foreach
	// 		}//while

	// 		$camPre=rtrim($cad,'|');

	// 		//selecci?n de preferencias del usuario en session
	// 		$preferences=explode('|',$camPre);
	// 		foreach ($preferences as $value){
	// 			$like.=" _datox_ LIKE '%".replaceCharacters($value)."%' OR ";
	// 		}

	// 		$publicitys=$GLOBALS['cn']->query('
	// 			SELECT
	// 				md5(id) AS id,
	// 				id AS id_valida,
	// 				link,
	// 				picture,
	// 				title,
	// 				message
	// 			FROM users_publicity
	// 			WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" AND ('.str_replace('_datox_','title',rtrim($like,' OR ')).' OR '.str_replace('_datox_','message',rtrim($like,' OR ')).')
	// 			ORDER BY RAND()
	// 			LIMIT 0,'.$limit_p
	// 		);
	// 		$paso=false;
	// 		while ($publicity=mysql_fetch_assoc($publicitys)){
	// 			$lst_publix.='"'.$publicity[id_valida].'",';
	// 			$paso=true;

	// 			$cadPublicity.='
	// 						<div style="width:180%;width:180px;float:left;margin-bottom:10px;height:200px;margin:18px;">
	// 						<div style="display:block;width:160px;height:140px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF">
	// 							 <img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=150&alto=120&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 						</div>
	// 						<div style="display:block;font-size:11px;text-align:left">
	// 							<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 						</div>
	// 					</div>';
	// 				}

	// 		//relleno con publicidades aleatorias que no tienen que ver con las preferencias del usuario en session
	// 		$limit_relleno=(mysql_num_rows($publicitys)<4)?$limit_p-mysql_num_rows($publicitys):0;//limite de registro por consulta

	// 		$where=(mysql_num_rows($publicitys)==0)?"":" AND id NOT IN (".rtrim($lst_publix,',').") ";

	// 		$rellenos=$GLOBALS['cn']->query('
	// 			SELECT md5(id) AS id,link,picture,title,message
	// 			FROM users_publicity
	// 			WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" '.$where.'
	// 			ORDER BY RAND()
	// 			LIMIT 0,'.$limit_relleno
	// 		);
	// 		//datos que muestra la descripcion de la publicidad $publicity['message']
	// 		if ($limit_relleno>0){
	// 			while ($publicity=mysql_fetch_assoc($rellenos)){

	// 				$cadPublicity.='
	// 					<div style="width:180%;width:180px;float:left;margin-bottom:10px;height:200px;margin:18px;">
	// 						<div style="display:block;width:160px;height:140px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF">
	// 							 <img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=150&alto=120&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 						</div>
	// 						<div style="display:block;font-size:11px;text-align:left">
	// 							<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 							<br />
	// 						</div>
	// 					</div>';
	// 			}
	// 		}
	// 		return $cadPublicity;
	// 	}else{
	// 		$limit_p=3;//limite de registro por consulta
	// 		$like='';
	// 		$datos=$data.explode('|',$data);

	// 		$tags=$GLOBALS['cn']->query('
	// 		SELECT
	// 			t.id			AS idTag,
	// 			t.code_number	AS code_number,
	// 			t.text			AS texto,
	// 			t.text2			AS texto2
	// 		FROM tags t
	// 		WHERE t.id="'.$datos[1].'"');

	// 		$tag=mysql_fetch_assoc($tags);

	// 		$textDataTag=$tag['code_number'].'|'.$tag['texto'].'|'.$tag['texto2'];

	// 		$camPre=rtrim($textDataTag,'|');

	// 		//selecci?n de preferencias del usuario en session
	// 		$preferences=explode('|',$camPre);
	// 		foreach ($preferences as $value){
	// 			$like.=" _datox_ LIKE '%".replaceCharacters($value)."%' OR ";
	// 		}

	// 		$publicitys=$GLOBALS['cn']->query('
	// 			SELECT
	// 				md5(id) AS id,
	// 				id AS id_valida,
	// 				link,
	// 				picture,
	// 				title,
	// 				message
	// 			FROM users_publicity
	// 			WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" AND ('.str_replace('_datox_','title',rtrim($like,' OR ')).' OR '.str_replace('_datox_','message',rtrim($like,' OR ')).')
	// 			ORDER BY RAND()
	// 			LIMIT 0,'.$limit_p
	// 		);
	// 		$paso=false;
	// 		while ($publicity=mysql_fetch_assoc($publicitys)){
	// 			$lst_publix.='"'.$publicity[id_valida].'",';
	// 			$paso=true;

	// 			$cadPublicity.='
	// 						<div style="width:180%;width:180px;float:left;margin-bottom:10px;height:200px;margin:18px;">
	// 						<div style="border:1px solid #000;display:block;width:160px;height:140px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF">
	// 							<img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=150&alto=120&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 						</div>
	// 						<div style="display:block;font-size:11px;text-align:left">
	// 							<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 						</div>
	// 					</div>';
	// 				}

	// 		//relleno con publicidades aleatorias que no tienen que ver con las preferencias del usuario en session
	// 		$limit_relleno=(mysql_num_rows($publicitys)<4)?$limit_p-mysql_num_rows($publicitys):0;//limite de registro por consulta

	// 		$where=(mysql_num_rows($publicitys)==0)?"":" AND id NOT IN (".rtrim($lst_publix,',').") ";

	// 		$rellenos=$GLOBALS['cn']->query('
	// 			SELECT md5(id) AS id,link,picture,title,message
	// 			FROM users_publicity
	// 			WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" '.$where.'
	// 			ORDER BY RAND()
	// 			LIMIT 0,'.$limit_relleno
	// 		);
	// 		//datos que muestra la descripcion de la publicidad $publicity['message']
	// 		if ($limit_relleno>0){
	// 			while ($publicity=mysql_fetch_assoc($rellenos)){
	// 				$cadPublicity.='
	// 					<div style="width:180%;width:180px;float:left;margin-bottom:10px;height:200px;margin:18px;">
	// 						<div style="display:block;width:160px;height:140px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF">
	// 							 <img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=150&alto=120&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 						</div>
	// 						<div style="display:block;font-size:11px;text-align:left">
	// 							<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 							<br />

	// 						</div>
	// 					</div>';
	// 			}
	// 		}
	// 		return $cadPublicity;
	// 	}
}

function showPreferencesMailOthers($data){
	// if(is_numeric($data)){
	// 	$id_user=$data;
	// 	$limit_p=3;//limite de registro por consulta
	// 	$like='';
	// 	$usr=($id_user!='')?$id_user:$_SESSION['ws-tags']['ws-user']['id'];
	// 	$cad='';
	// 	$query=$GLOBALS['cn']->query('SELECT preference FROM users_preferences WHERE id_user="'.$usr.'"');//todas las preferencias del usuario
	// 	while ($array=mysql_fetch_assoc($query)){
	// 		$ids=explode(',',$array['preference']);//vector de preferencias
	// 		foreach ($ids as $index){
	// 			if ($index!=''){
	// 				$validar=$GLOBALS['cn']->query("SELECT id_preference,detail FROM preference_details WHERE id='".replaceCharacters($index)."' ");
	// 				if (mysql_num_rows($validar)==0){
	// 					$cad.=$index.'|';
	// 				}else{
	// 					$valida=mysql_fetch_assoc($validar);
	// 					$cad.=$valida['detail'].'|';
	// 				}
	// 			}//si el dato no esta vacio
	// 		}//foreach
	// 	}//while
	// 	$camPre=rtrim($cad,'|');
	// 	//selecci?n de preferencias del usuario en session
	// 	$preferences=explode('|',$camPre);
	// 	foreach ($preferences as $value){
	// 		$like.=" _datox_ LIKE '%".replaceCharacters($value)."%' OR ";
	// 	}
	// 	$publicitys=$GLOBALS['cn']->query('
	// 		SELECT
	// 			md5(id) AS id,
	// 			id AS id_valida,
	// 			link,
	// 			picture,
	// 			title,
	// 			message
	// 		FROM users_publicity
	// 		WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" AND ('.str_replace('_datox_','title',rtrim($like,' OR ')).' OR '.str_replace('_datox_','message',rtrim($like,' OR ')).')
	// 		ORDER BY RAND()
	// 		LIMIT 0,'.$limit_p
	// 	);
	// 	$paso=false;
	// 	while ($publicity=mysql_fetch_assoc($publicitys)){
	// 		$lst_publix.='"'.$publicity['id_valida'].'",';
	// 		$paso=true;
	// 		$cadPublicity.='
	// 			<div style="width:100%;width:180px;float:left;margin-bottom:18px;margin-left:5px;margin-top:18px;margin-right:5px;height:200px;boder:2px #86878a solid;display:inline-block;">
	// 				<div style="display:block;width:160px;height:123px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF;boder:2px #dbdbdb solid;">
	// 					 <img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=155&alto=115&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 				</div>
	// 				<div style="display:block;font-size:11px;text-align:center;color:#ff8a28;">
	// 					<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 				</div>
	// 			</div>
	// 		';
	// 	}
	// 	//relleno con publicidades aleatorias que no tienen que ver con las preferencias del usuario en session
	// 	$limit_relleno=(mysql_num_rows($publicitys)<4)?$limit_p-mysql_num_rows($publicitys):0;//limite de registro por consulta

	// 	$where=(mysql_num_rows($publicitys)==0)?"":" AND id NOT IN (".rtrim($lst_publix,',').") ";

	// 	$rellenos=$GLOBALS['cn']->query('
	// 		SELECT md5(id) AS id,link,picture,title,message
	// 		FROM users_publicity
	// 		WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" '.$where.'
	// 		ORDER BY RAND()
	// 		LIMIT 0,'.$limit_relleno
	// 	);
	// 	//datos que muestra la descripcion de la publicidad $publicity['message']
	// 	if ($limit_relleno>0){
	// 		while ($publicity=mysql_fetch_assoc($rellenos)){
	// 			$cadPublicity.='
	// 				<div style="boder:2px #86878a groove;display:inline-block;">
	// 					<div style="width:100%;width:180px;float:left;margin-bottom:18px;margin-left:5px;margin-top:18px;margin-right:5px;height:200px;boder:2px #86878a solid;display:inline-block;">
	// 						<div style="display:block;width:160px;height:123px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF;boder:2px #dbdbdb solid;">
	// 							<img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=155&alto=115&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 						</div>
	// 						<div style="display:block;font-size:11px;text-align:center;color:#ff8a28;">
	// 							<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 							<br />
	// 						</div>
	// 					</div>
	// 				</div>';
	// 		}
	// 	}
	// 	return $cadPublicity;
	// }else{
	// 	$limit_p=3;//limite de registro por consulta
	// 	$like='';
	// 	$datos=$data.explode('|',$data);

	// 	$tags=$GLOBALS['cn']->query('
	// 	SELECT
	// 		t.id			AS idTag,
	// 		t.code_number	AS code_number,
	// 		t.text			AS texto,
	// 		t.text2			AS texto2
	// 	FROM tags t
	// 	WHERE t.id="'.$datos[1].'"');

	// 	$tag=mysql_fetch_assoc($tags);

	// 	$textDataTag=$tag['code_number'].'|'.$tag['texto'].'|'.$tag['texto2'];

	// 	$camPre=rtrim($textDataTag,'|');

	// 	//selecci?n de preferencias del usuario en session
	// 	$preferences=explode('|',$camPre);
	// 	foreach ($preferences as $value){
	// 		$like.=" _datox_ LIKE '%".replaceCharacters($value)."%' OR ";
	// 	}

	// 	$publicitys=$GLOBALS['cn']->query('
	// 		SELECT
	// 			md5(id) AS id,
	// 			id AS id_valida,
	// 			link,
	// 			picture,
	// 			title,
	// 			message
	// 		FROM users_publicity
	// 		WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" AND ('.str_replace('_datox_','title',rtrim($like,' OR ')).' OR '.str_replace('_datox_','message',rtrim($like,' OR ')).')
	// 		ORDER BY RAND()
	// 		LIMIT 0,'.$limit_p
	// 	);
	// 	$paso=false;
	// 	while ($publicity=mysql_fetch_assoc($publicitys)){
	// 		$lst_publix.='"'.$publicity['id_valida'].'",';
	// 		$paso=true;

	// 		$cadPublicity.='
	// 			<div style="width:180%;width:180px;float:left;margin-bottom:18px;margin-left:5px;margin-top:18px;margin-right:5px;height:200px;boder:2px #86878a solid;display:inline-block;">
	// 				<div style=" display:block;width:160px;height:123px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF;boder:2px #dbdbdb solid;">
	// 					<img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=155&alto=115&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 				</div>
	// 				<div style="display:block;font-size:11px;text-align:center;color:#ff8a28;">
	// 					<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 				</div>
	// 			</div>';
	// 	}

	// 	//relleno con publicidades aleatorias que no tienen que ver con las preferencias del usuario en session
	// 	$limit_relleno=(mysql_num_rows($publicitys)<4)?$limit_p-mysql_num_rows($publicitys):0;//limite de registro por consulta

	// 	$where=(mysql_num_rows($publicitys)==0)?"":" AND id NOT IN (".rtrim($lst_publix,',').") ";

	// 	$rellenos=$GLOBALS['cn']->query('
	// 		SELECT md5(id) AS id,link,picture,title,message
	// 		FROM users_publicity
	// 		WHERE status="1" AND click_max>=click_current AND id_type_publicity="2" '.$where.'
	// 		ORDER BY RAND()
	// 		LIMIT 0,'.$limit_relleno
	// 	);
	// 	//datos que muestra la descripcion de la publicidad $publicity['message']
	// 	if ($limit_relleno>0){
	// 		while ($publicity=mysql_fetch_assoc($rellenos)){

	// 			$cadPublicity.='
	// 				<div style="width:180%;width:180px;float:left;margin-bottom:18px;margin-left:5px;margin-top:18px;margin-right:5px;height:200px;boder:1px #86878a solid;display:inline-block;">
	// 					<div style="display:block;width:160px;height:123px;cursor:pointer;background-position:0 50%;background-repeat:no-repeat;background-color:#FFF;boder:1px #dbdbdb solid;">
	// 						 <img src="'.$GLOBALS['config']->main_server.'includes/imagen.php?ancho=155&alto=115&tipo=2&img='.FILESERVER.'img/publicity/'.$publicity['picture'].'" alt="picture">
	// 					</div>
	// 					<div style="display:block;color:#ff8a28;font-size:11px;text-align:center">
	// 						<strong><a href="'.$publicity['link'].'" onfocus="this.blur()" target="_blank">'.$publicity['title'].'</a></strong>
	// 											<dic>
	// 				</div>';
	// 		}
	// 	}

	// 	return $cadPublicity;

	// }
}
?>

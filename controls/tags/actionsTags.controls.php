<?php
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Allow-Origin: http://localhost');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');
	session_start();

	include('../../includes/functions.php');

	if (quitar_inyect()){
		include('../../includes/functions_mails.php');
		include('../../includes/config.php');
		include('../../class/wconecta.class.php');
		include('../../includes/languages.config.php');
		include('../../class/class.phpmailer.php');
		include('../../class/validation.class.php');
		$tag=$GLOBALS['cn']->queryRow('SELECT id,id_user FROM tags WHERE md5(id) = "'.intToMd5($_GET['tag']).'" LIMIT 0,1');
		switch($_GET['action']){
			case 3://redistribute
				//getting tag source
				$_sourceTag=$GLOBALS['cn']->query('SELECT source FROM tags WHERE id="'.$tag['id'].'"');
				$_sourceTag=mysql_fetch_assoc($_sourceTag);
				$_sourceTag=$_sourceTag['source'];
				$_valRedist=$GLOBALS['cn']->query('
					SELECT id FROM tags
					WHERE id_creator!=id_user AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND source="'.$_sourceTag.'"
				');
				if(mysql_num_rows($_valRedist)<=0){
					//Tabla Tags
					$atributes='
						id_user,			id_creator,	id_product,		background,
						code_number,		color_code,	color_code2,	color_code3,
						text,				text2,		geo_lat,		geo_log,
						profile_img_url,	video_url,	date,			status,
						points,				source,		id_business_card
					';
					//nuevo tag
					$validatex	= $GLOBALS['cn']->query("SELECT	id
														FROM	tags
														WHERE	id_user	= '".$_SESSION['ws-tags']['ws-user']['id']."' AND
																source	= '".$tag['id']."'");
					if( mysql_num_rows($validatex)==0 ) {
						incPoints(8,$tag['id'],$tag['id_user'],$_SESSION['ws-tags']['ws-user']['id']); //incremento de hits a la tag que se recibe
						incHitsTag($tag['id']);
						$insert = $GLOBALS['cn']->query("INSERT INTO tags ($atributes)
																SELECT	 $atributes
																FROM tags
																WHERE id = '".$tag['id']."'");
						$idTag=mysql_insert_id();
						createTag($idTag);
						//act dueño tag
						$update=$GLOBALS['cn']->query("UPDATE tags SET id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' WHERE id = '".$idTag."'");
						//selecion el id_user de la tag redistribuida
						$select_id=$GLOBALS['cn']->query("SELECT id_creator, id_user FROM tags WHERE id = '".$idTag."'");
						$idUserRedis=mysql_fetch_assoc($select_id);
						//notificacion de redistribucion - envio de correo
						notifications($idUserRedis[id_creator],$tag['id'],8);
						// adding user's points
								$points	= getTagPoints($_sourceTag);
								updateUserCounters($_SESSION['ws-tags']['ws-user']['id'],	'accumulated_points',	$points,	'+');
								updateUserCounters($_SESSION['ws-tags']['ws-user']['id'],	'current_points',		$points,	'+');
						// END - adding user's points
						$msgBox='<img src="img/re-distribuirTag.png" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" />';
					}else{//validacion de solo una redistribucion
						$msgBox = '&nbsp;';
					}
				}else{
					$msgBox = '<img src="img/re-distribuirTag.png" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" />';
				}
			break;
			// END - redistribute (3)
			// likes  (4)
				case 4:
							//add favorite
							if (!existe("likes", "id_source", " WHERE  id_source = '".$tag['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'")){

								$insert = $GLOBALS['cn']->query("INSERT INTO likes (id_user,id_source, date)
																					 SELECT '".$_SESSION['ws-tags']['ws-user']['id']."' as  id_user_like,	id, NOW()
																					 FROM tags
																					 WHERE id = '".$tag['id']."'
																");
								$idFav = mysql_insert_id();
								incPoints(2,$tag['id'],$tag['id_user'],$_SESSION['ws-tags']['ws-user']['id']);
                                incHitsTag($tag['id']);
								//se valida el tipo de salida
								$msgBox = '<img src="img/star.png" title="'.TAGS_OPTIONUNLIKE.'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';

								if ($_GET['isComment']==1){ //si el like es desde un ventana de comentarios
									$msgBox = '<a href="javascript:void(0);" onfocus="this.blur();" title="'.COMMENTS_FLOATHELPLINKLIKES.'" onclick="viewUserLikedTag(\''.COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG.'\',\'views/tags/viewUserLikedTag.view.php?t='.$tag['id'].'\');" style="color:#F58220;font-weight:bold;">'.numRecord("likes", " WHERE id_source = '".$tag['id']."'").'</a>';
								}else{
									$msgBox = '<img src="img/star.png" title="'.TAGS_OPTIONUNLIKE.'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';
								}

								$validateUserTag = $GLOBALS['cn']->query("SELECT id_user FROM tags WHERE id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' AND id  = '".$tag['id']."' ");

								if (mysql_num_rows($validateUserTag)==0){
									if ($_SESSION['ws-tags']['ws-user']['like']!=null){
										$bandera=false;
										for ($i=0;$i<count($_SESSION['ws-tags']['ws-user']['like']);$i++){
											if ($tag['id']==$_SESSION['ws-tags']['ws-user']['like'][$i]){
												$bandera=true;
											}
										}
										if ($bandera==false){
											$i=count($_SESSION['ws-tags']['ws-user']['like']);
											$select_id = $GLOBALS['cn']->query("SELECT id_creator, id_user FROM tags WHERE id = '".$tag['id']."'");
											$selectUser = mysql_fetch_assoc($select_id);
											//notoficacion si le gusta la tag - envio de correo
											notifications(campo("tags", "id", $tag['id'], "id_user"), $tag['id'], 2);
											$_SESSION['ws-tags']['ws-user']['like'][$i]=$tag['id'];
										}
									}else{
										$select_id = $GLOBALS['cn']->query("SELECT id_creator, id_user FROM tags WHERE id = '".$tag['id']."'");
										$selectUser = mysql_fetch_assoc($select_id);
										//notoficacion si le gusta la tag - envio de correo
										notifications(campo("tags", "id", $tag['id'], "id_user"), $tag['id'], 2);
										$_SESSION['ws-tags']['ws-user']['like'][0]=$tag['id'];
									}
								}//if validateUserTag
								$delete = $GLOBALS['cn']->query("DELETE FROM dislikes WHERE id_source = '".$tag['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' ");
							}
					////salida alterna para News
						if($_GET['news']==1){
							$msgBox = numRecord("dislikes", " WHERE id_source = '".$tag['id']."'").'|'.numRecord("likes", " WHERE id_source = '".$tag['id']."'");

						}
				break;
			// END - favorite (4)
				// share (by mail)
				case 5:
					$tags = $GLOBALS['cn']->query('
						SELECT
							u.screen_name AS nameUsr,
							(SELECT screen_name FROM users WHERE id=t.id_user) AS nameUsr2,
							md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code,
							u.profile_image_url	 AS photoUser,
							t.id AS idTag,
							t.id_user AS idUser,
							t.id_creator AS idCreator,
							t.code_number AS code_number,
							t.color_code AS color_code,
							t.color_code2 AS color_code2,
							t.color_code3 AS color_code3,
							t.text AS texto,
							t.text2 AS texto2,
							t.date AS fechaTag,
							t.background AS fondoTag,
							t.video_url AS video_url,
							u.email AS email,
							u.referee_number AS referee_number
						FROM tags t JOIN users u ON t.id_creator = u.id
						WHERE t.id = "'.$tag['id'].'"
					');
					$tag = mysql_fetch_assoc($tags);
					incPoints(7,$tag['idTag'],$tag['idUser'],$_SESSION['ws-tags']['ws-user']['id']); //incremento de hits a la tag que se recibe
					incHitsTag($tag['idTag']);
                    $msj=$_GET['msj'];
					$mails=explode(',',$_GET['mails']);
					if(count($mails)>0){
						$correos='';
						foreach($mails as $per){
							if($per!=''){
								//verificar si el correo esta registrado o no en Tagbum
								$query=$GLOBALS['cn']->query('SELECT u.id,u.email FROM users u WHERE u.email LIKE "'.$per.'" OR md5(u.id)="'.$per.'"');
								if (mysql_num_rows($query)>0){
									$emailUserSend = mysql_fetch_assoc($query);
									$sendDataPublicity = $emailUserSend['id'];
									$per = $emailUserSend['email'];
								}
								$sendDataPublicity = $tag['idTag'];
								//echo '- '.$per.'<br>';
								//----------------------- revisar link de tag
								//imagenes del email
								$backg = (strpos(' '.$tag['fondoTag'],'default') ? DOMINIO : FILESERVER).'img/templates/'.$tag['fondoTag'];
								$placa = DOMINIO.'img/placaFondo.png';
								//$linkTag = DOMINIO.'#timeline?current=timeLine&tag='.$tag['idTag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code'];
								$imgTag = DOMINIO.'includes/tag.php?tag='.md5($tag['idTag']);
								$linkTag = base_url('&tag='.$tag['idTag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code']);
								$iconoSpon = DOMINIO.'/img/menu_users/publicidad.png';
								$foto_usuario=FILESERVER.getUserPicture($tag['code'].'/'.$tag['photoUser']);
								$foto_remitente	=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']);
								$share=DOMINIO.'/css/smt/tag/share.png';
								//product tags
								if( $product=isProductTag($tag['idTag']) ) {
									$foto_usuario = FILESERVER."img/products/".$product['picture'];
									$tag['nameUsr'] = $product['name'];
								}
								if ($msj!=""){
									$trMsj = '
										<tr>
											<td style="padding:5px; font-size:12px; color:#000; text-align:justify">'.convertir_especiales_html($msj).'</td>
										</tr>
									';
								} else {
									$trMsj = '';
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
												$external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.":&nbsp;<span ><a style='color:#999999' href='".base_url($array['username'])."' onFocus='this.blur();' target='_blank'>".DOMINIO.$array['username']."</a><br>";
										}else {
											$external=  formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']);
										}
										if (trim($array['pais'])!=''){
												$pais=USERS_BROWSERFRIENDSLABELCOUNTRY.":&nbsp;<span style='color:#999999'>".$array['pais']."</span><br/>";
										}
										//cuerpo del email
								$body  = '<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; border-radius:7px; background: #fff; padding-top:25px;">
										<tr>
											<td>
												<table style="width:100%;">
													<tr>
														<td style="padding-left:5px; font-size:14px; text-align:left">
															<img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:3px solid #CCCCCC">
														</td>
														<td width="569" style="padding-left:5px; padding-bottom:20px; font-size:12px; text-align:left;">
																<div>
																		'.$external.'<br>
																		'.$pais.'<br>
																		<strong>'.USERS_BROWSERFRIENDSLABELFRIENDS.'('.$array[friends].'),&nbsp;'.USERS_BROWSERFRIENDSLABELADMIRERS.'('.$array['followers'].')</strong>
																</div>
														</td>
													 </tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="color:#000; padding-left:5px; font-size:14px">
												<table style="width:100%;">
													<tr>
														<td style="width:20px;">
															<img src="'.$share.'" width="16" height="16" border="0">
														</td>
														<td style="text-align: left; width: 450px;">
															<strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'&nbsp;</strong>'.MENUTAG_CTRSHAREMAILTITLE1.'
														</td>
														<td background="'.DOMINIO.'css/smt/email/yellowbutton_get_started2.png" style="width: 140px; height: 22px;  display: inline-block; background-repeat: no-repeat; padding: 10px 14px 5px 5px;">
															<a style="font-weight: bold; color: #2d2d2d; font-size:12px; text-decoration: none" href="'.$linkTag.'">'.MENUTAG_CTRSHAREMAILTITLE2.'</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td><center>
												<table style="width:100%;">
													'.$trMsj.'
												 </table></center>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<br>
													<p><a href="'.$linkTag.'" target="_blank"><img src="'.$imgTag.'"></a></p>
												<br>
											</td>
										</tr>
										<tr>
											<td colspan="2" valign="top">
												<center><table style="width:100%;">
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
												</table></center>
											</td>
										</tr>
											<tr>
												<td>
													<center><table>
														<tr>
															<td align="center" style="padding-left:5px; text-align:center; width:100%;">
																'.(isset($device) ? 'This tag have been sent using my '.$device : '').'<br>'.
																MENUTAG_CTRSHAREMAILTITLE3.':&nbsp;<a href="'.$linkTag.'">Tagbum.com</a>
															</td>
														</tr>
													</table></center>
												</td>
											</tr>
									</table>
								';
								/*
									esto es la publicidad de la linea 314 se comento por peticion del cliente
									<tr>
									<td>
										'.showPreferencesMailOthers($sendDataPublicity).'
									</td>
									</tr>
								*/
								//envio del correo
								//if (sendMail(formatMail($body, "790"), "no-reply@seemytag.com", "Tagbum.com", MENUTAG_CTRSHAREMAILASUNTO, $per, "../../")){
								if (sendMail(formatMail($body, "790"), "no-reply@seemytag.com", formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.MENUTAG_CTRSHAREMAILTITLE1, $per, "../../")){
									$correos .= "-&nbsp;".$per.".<br/>";
									//insert tabla verificacion
									if( !existe("tags_share_mails", "id_tag", " WHERE id_tag = '".$tag['idTag']."' AND referee_number = '".$_SESSION['ws-tags']['ws-user']['code']."' AND email_destiny = '".$per."' ") ) {
										$insert  = $GLOBALS['cn']->query("
											INSERT INTO tags_share_mails SET
												id_tag = '".$tag['id']."',
												referee_number = '".$_SESSION['ws-tags']['ws-user']['code']."',
												email_destiny  = '".$per."',
												view = '0'
										");
									}
								}//end if envio de correo
							}//if per
						}//foreach
					}//if (count($mails)>0)
					echo (($correos!="")?'<div class="div_exito"><strong>'.MENUTAG_CTRSHAREMAILEXITO.":</strong></div><br><br> ".$correos : '<div class="div_error">'.DOMINIO.$device.MENUTAG_CTRSHAREMAILERROR.'</div>');
				break; //share
				//delete
				case 6:
					$myId = $_SESSION['ws-tags']['ws-user']['id'];
					if(isset($_REQUEST['url'])){
						$idcre=$GLOBALS['cn']->query('SELECT id_creator FROM tags WHERE id="'.$tag['id'].'"');
						$idcrea=mysql_fetch_assoc($idcre);
						if($idcrea['id_creator']==$myId){
							$creator  = 'AND id_creator="'.$myId.'"';
						}else{
							$creator  = 'AND id_creator="'.$idcrea['id_creator'].'"';
						}
						$satusTag = 'AND status="10"';
						$GLOBALS['cn']->query('UPDATE tags SET status="2" WHERE id="'.$tag['id'].'" AND source = "'.$tag['id'].'" '.$creator.' '.$satusTag.'');
						header('Location: '.DOMINIO.$_REQUEST['url'].'');
					}else{
						$tag = $GLOBALS['cn']->queryRow('SELECT id,status FROM tags WHERE id = "'.$tag['id'].'"');
						//$redist = $GLOBALS['cn']->queryRow('SELECT * FROM tags WHERE source != "'.$tag['id'].'" AND id!=source LIMIT 0,1');
						if($tag['status']=='4') {//si la tag es privada
							// eliminamos los tags privados
							$delete = $GLOBALS['cn']->query("DELETE FROM tags_privates WHERE id_tag = '".$tag['id']."' AND id_friend = '".$myId."'");
							// eliminamos las notificaciones de esa tag
							$delete = $GLOBALS['cn']->query('DELETE FROM users_notifications WHERE id_source = "'.$tag['id'].'" AND id_friend = "'.$myId.'" AND id_type IN (1,2,4,7,8,9,10)');
							// eliminamos los comentarios de la tag
							$delete = $GLOBALS['cn']->query('DELETE FROM comments WHERE id_type="4" AND id_source = "'.$tag['id'].'" AND id_user_from = "'.$myId.'"');
							$msgBox = 1;
						} else {
							//validamos si la tag es un sponsor activo
							$validateSponsor = $GLOBALS['cn']->query('
								SELECT id_tag
								FROM users_publicity
								WHERE id_tag = "'.$tag['id'].'"
									AND status = "1"
							');//AND id_user = "'.$myId.'"
							if (mysql_num_rows($validateSponsor)==0){ //si la tag no es un patrocinio
								$redist = $GLOBALS['cn']->queryRow('SELECT id FROM tags WHERE source != "'.$tag['id'].'" AND id!=source LIMIT 0,1');
								if($redist[id]!=''){//si fue redistribuida se le cambia el estado
									$update = $GLOBALS['cn']->query('UPDATE tags SET status="2" WHERE source = "'.$tag['id'].'" AND (id_creator = "'.$myId.'" OR id_user = "'.$myId.'")');
								}else{//si no fue redistribuida  la eliminamos
									$delete = $GLOBALS['cn']->query('DELETE FROM users_notifications WHERE id_source = "'.$tag['id'].'" AND id_creator = "'.$myId.'"');
									// eliminamos la tag
//									$delete = $GLOBALS['cn']->query('
//										DELETE FROM tags WHERE
//										(source	="'.$tag['id'].'" AND id_creator	= "'.$myId.'") OR
//										(id		="'.$tag['id'].'" AND id_user		= "'.$myId.'")
//									');
									$update = $GLOBALS['cn']->query('UPDATE tags SET status="2" WHERE source = "'.$tag['id'].'" AND (id_creator = "'.$myId.'" OR id_user = "'.$myId.'")');
									// eliminamos los tags privados
									$delete = $GLOBALS['cn']->query('DELETE FROM tags_privates WHERE id_tag = "'.$tag['id'].'"');
									// eliminamos las notificaciones de esa tag
									$delete = $GLOBALS['cn']->query('DELETE FROM users_notifications WHERE id_source = "'.$tag['id'].'" AND id_type IN (1,2,4,7,8,9,10)');
									// eliminamos los comentarios de la tag
									$delete = $GLOBALS['cn']->query('DELETE FROM comments WHERE id_source = "'.$tag['id'].'"');
								}
								//decremento del numero de tags del usuario
								updateUserCounters(	$_SESSION['ws-tags']['ws-user']['id'], 'tags_count', '1',	'-');
								$msgBox = 1;
							}elseif(mysql_num_rows($validateSponsor)>0){ //si la tag esta patrocinada
								$msgBox = MENUTAG_CTRERRORDELETETAGSPONSORED;
							}
						}//else delprivate
					}
				break;
				//report
				case 8:
					//validamos si es mi misma tag
					$validar = $GLOBALS['cn']->query("
						SELECT id_creator
						FROM tags
						WHERE id = '".$tag['id']."' AND id_creator = '".$_SESSION['ws-tags']['ws-user']['id']."'
					");
					if (mysql_num_rows($validar)==0){
						//validamos si ya se denuncio el tag
						$validar = $GLOBALS['cn']->query("
							SELECT id
							FROM tags_report
							WHERE id_tag = '".$tag['id']."' AND id_user_report = '".$_SESSION['ws-tags']['ws-user']['id']."'
						");
						if (mysql_num_rows($validar)==0){
							$insert = $GLOBALS['cn']->query('
								INSERT INTO tags_report (id_tag, id_user_creator, id_user_report, type_report)
											SELECT	id, id_creator, "'.$_SESSION['ws-tags']['ws-user']['id'].'", id
											FROM	tags
											WHERE	id = '.$tag['id']
							);
							$id = mysql_insert_id();
							$typeR = campo("type_tag_report", "md5(id)", $_GET['type_report'], "id");
							$update = $GLOBALS['cn']->query('
								UPDATE	tags_report
									SET type_report = '.$typeR.'
								WHERE	id='.$id
							);
							incPoints(21,$tag['id'],$tag['id_user'],$_SESSION['ws-tags']['ws-user']['id']);
							incHitsTag($tag['id']);
                            if($_SESSION['ws-tags']['ws-user']['super_user']==1&&$typeR=='6'){
								$GLOBALS['cn']->query('UPDATE tags SET status="2" WHERE id="'.$tag['id'].'"');
							}
							echo '<div class="success_message"><img src="imgs/message_success.png" /> '.ACTIONTAG_REPORTEXITO.'</div>';
						}else{
							echo '<div class="error_message"><img src="imgs/message_error.png" /> '.ACTIONTAG_REPORTERROR1.'</div>';
						}
					}else{
							echo '<div class="error_message"><img src="imgs/message_error.png" /> '.ACTIONTAG_REPORTERROR2.'</div>';
					}
				break;//report
			// luego del preview (9)
				case 9:
					if(false){
						if ($_SESSION['ws-tags']['ws-user']['update_tag_id']!=''){
							//borramos la tag ya que estamos en un preview
//								$delete = $GLOBALS['cn']->query("
//									DELETE FROM tags
//									WHERE
//										id = '".$_SESSION['ws-tags']['ws-user']['update_tag_id']."' AND
//										id_creator = '".$_SESSION['ws-tags']['ws-user']['id']."'
//									LIMIT 1
//								");
							//borrado de las tags_privates temporales del usuario
							$delete = $GLOBALS['cn']->query("
								DELETE FROM tags_privates
								WHERE
									id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' AND
									id_tag = '".$_SESSION['ws-tags']['ws-user']['update_tag_id']."'
							");
							transferTag($_SESSION['ws-tags']['ws-user']['update_tag_id'], $tag['id'], 1); //comentarios
							transferTag($_SESSION['ws-tags']['ws-user']['update_tag_id'], $tag['id'], 2); //redistribuciones
							transferTag($_SESSION['ws-tags']['ws-user']['update_tag_id'], $tag['id'], 3); //likes
							transferTag($_SESSION['ws-tags']['ws-user']['update_tag_id'], $tag['id'], 4); //notificaciones
							$_SESSION['ws-tags']['ws-user']['update_tag_id']='';

						}// if $_POST[update]
						//verificamos si es un tag privado
						$query	= $GLOBALS['cn']->query("SELECT id_tag FROM tags_privates WHERE id_tag = '".$tag['id']."'");

						//asiganamos el status de la nueva tag
						$status	= (mysql_num_rows($query)==0) ? 1 : 4;
						//actualizamos tabla tags
						$update	= $GLOBALS['cn']->query("UPDATE tags SET status = '".$status."' WHERE source = '".$tag['id']."' AND id_creator = '".$_SESSION['ws-tags']['ws-user']['id']."' AND status = '0' ");
						//updating users data, se verifica que sea un tag valido
						if ($status!='0'){
							$points = getCreatingTagPoints();
							//updateUserCounters ($_SESSION['ws-tags']['ws-user']['id'], "tags_count", '1', '+');//numero de tags
							updateUserCounters($_SESSION['ws-tags']['ws-user']['id'], 'accumulated_points', $points, '+');//puntos del usuarios
							updateUserCounters($_SESSION['ws-tags']['ws-user']['id'], 'current_points', $points, '+');//puntos del usuarios
						}
						if ($status==4){
							//actualizamos tabla privates_tags
							$update = $GLOBALS['cn']->query("UPDATE tags_privates SET status_tag = '".$status."'
														 WHERE id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' AND
															   id_tag  = '".$tag['id']."' AND
															   status_tag = '0'");
							$friends = $GLOBALS['cn']->query("SELECT id_friend, id_tag
															  FROM tags_privates
															  WHERE id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' AND
																	id_tag  = '".$tag['id']."' AND
																	status_tag = '4'");
							while ($friend = mysql_fetch_assoc($friends)){
									notifications($friend['id_friend'], $friend['id_tag'], 1, md5($friend['id_tag']));
							} //while
						}
						$status =$GLOBALS['cn']->query("SELECT status, id_group, id_business_card
															  FROM tags
															  WHERE id  = '".$tag['id']."' ");
						$status=mysql_fetch_assoc($status);
						echo $status['status'].'|'.md5($status['id_group']).'|'.$status['id_business_card'];
					}
				break;
			// END - luego del preview (9)
				//sponsor tag
				case 10:
					$monto_inversion = str_replace(",","",$_GET['inver']);

					//sondeo publicitario
					$valida = $GLOBALS['cn']->query("SELECT id, click_to, cost
													 FROM cost_publicity
													 WHERE '".factorPublicity(4, $monto_inversion)."' BETWEEN click_from AND click_to");

					if (mysql_num_rows($valida)>0){
						$_datos = "SELECT id, click_to, cost
								   FROM cost_publicity
								   WHERE '".factorPublicity(4, $monto_inversion)."' BETWEEN click_from AND click_to";

					}elseif (mysql_num_rows($valida)==0){
						$_datos = "SELECT MAX(cost) AS cost,
										  id,
										  click_to
								   FROM cost_publicity
								   WHERE id_typepublicity = '4'
								   GROUP BY cost
								   LIMIT 0, 1";
					}

					$costos = $GLOBALS['cn']->query($_datos);
					$costo  = mysql_fetch_assoc($costos);
					//insert/update patrocinio
					if( !$_GET[update] ){
						$insert = $GLOBALS['cn']->query("
							INSERT INTO users_publicity SET
								id_tag				= '".$tag['id']."',
								id_type_publicity	= '4',
								id_cost				= '".$costo['id']."',
								id_user				= '".$_SESSION['ws-tags']['ws-user']['id']."',
								title				= '',
								message				= '',
								link				= '',
								picture				= '',
								picture_title_tag	= '',
								cost_investment		= '".$monto_inversion."',
								click_max			= '".($_SESSION['ws-tags']['ws-user']['super_user']=='0' ? intval($monto_inversion/$costo['cost']) : 100)."',
								click_current		= '0',
								status				= '".($_SESSION['ws-tags']['ws-user']['super_user']=='0' ? 2 : 1)."'
						");
						$id_publicity = mysql_insert_id();
						$tag_sponsor = $GLOBALS['cn']->query("SELECT id_creator FROM tags WHERE id = '".$tag['id']."'");
						$tag_sponsor_creator  = mysql_fetch_assoc($tag_sponsor);
						//notificacion de patrocinio - envio de correo
						notifications($tag_sponsor_creator['id_creator'],$tag['id'],9);
					}else{
						//$update = $GLOBALS['cn']->query("UPDATE users_publicity SET link = '".$_GET['link']."' WHERE md5(id) = '".$_GET['p']."'");
						$id_publicity = campo("users_publicity", "md5(id)", $_GET['p'], "id");
					}
					if( $_SESSION['ws-tags']['ws-user']['super_user']=='0' ) {
						//paypal (se redirecciona a paypal solo cuando se hace el insert de la publicidad)
						if( $_GET['update']=='' && $_SESSION['ws-tags']['ws-user']['super_user']=='0') {
							header ("Location: ../../views/pay.view.php?payAcc=personaltag&uid=$id_publicity");
						}
					}
					////////
					//echo PUBLICITY_MSGSUCCESSFULLY;
			   break;//case 10
			   case 11://add dislikes
					if (!existe('dislikes','id_source'," WHERE id_source='".$tag['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'")){
						$insert = $GLOBALS['cn']->query("INSERT INTO dislikes (id_user,id_source, date)
															SELECT '".$_SESSION['ws-tags']['ws-user']['id']."' as  id_user_like,	id, NOW()
															FROM tags
															WHERE id = '".$tag['id']."'
														");
						$idFav = mysql_insert_id();
						incPoints(20,$tag['id'],$tag['id_user'],$_SESSION['ws-tags']['ws-user']['id']); //incremento de hits a la tag que se recibe
						incHitsTag($tag['id']);
                        //se valida el tipo de salida
						$msgBox = '<img src="img/star.png" title="'.TAGS_OPTIONUNLIKE.'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';

						if ($_GET['isComment']==1){ //si el like es desde un ventana de comentarios
							$msgBox = '<a href="javascript:void(0);" onfocus="this.blur();" title="'.COMMENTS_FLOATHELPLINKLIKES.'" onclick="viewUserLikedTag(\''.COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG.'\',\'views/tags/viewUserLikedTag.view.php?t='.$tag['id'].'\');" style="color:#F58220;font-weight:bold;">'.numRecord("likes", " WHERE id_source = '".$tag['id']."'").'</a>';
						}else{
							$msgBox = '<img src="img/star.png" title="'.TAGS_OPTIONUNLIKE.'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';
						}
						$validateUserTag = $GLOBALS['cn']->query("SELECT id_user FROM tags WHERE id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' AND id  = '".$tag['id']."' ");
						if (mysql_num_rows($validateUserTag)==0){
							$select_id = $GLOBALS['cn']->query("SELECT id_creator, id_user FROM tags WHERE id = '".$tag['id']."'");
							$selectUser = mysql_fetch_assoc($select_id);
							//notoficacion si le gusta la tag - envio de correo
							//notifications(campo("tags", "id", $tag['id'], "id_user"), $tag['id'], 2);
						}//if validateUserTag
						$delete = $GLOBALS['cn']->query("DELETE FROM likes WHERE  id_source = '".$tag['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' ");
					}
					////salida alterna para News
					if($_GET[news]==1){
						$msgBox = numRecord("dislikes", " WHERE id_source = '".$tag['id']."'").'|'.numRecord("likes", " WHERE id_source = '".$tag['id']."'");

					}
				break;
			// END - dislikes (10)
			// get likes and dislikes (12)
				case 12:
					function likes($tag,$id){
						return $id==''?0:
						(existe('likes', 'id_source', 'WHERE id_source='.$tag.' AND id_user='.$id)?1:
						(existe('dislikes','id_source', 'WHERE id_source="'.$tag.'" AND id_user="'.$id.'"')?-1:
						0));
					}
					$taglikeIt = likes($tag['id'],$_SESSION['ws-tags']['ws-user']['id']);

					echo numRecord('likes', 'WHERE id_source = '.$tag['id']).'|'.numRecord('dislikes', 'WHERE id_source = '.$tag['id']).'|'.$taglikeIt;
				break;
		}//switch
	}else{
		$msgBox = 'ERROR';
	}
	echo $msgBox;
?>

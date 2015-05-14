<?php
	include '../header.json.php';
	
	include $config->relpath.'/class/class.phpmailer.php';

	if (quitar_inyect()){
		$myId=$myId?$myId:$_SESSION['ws-tags']['ws-user']['id'];
		$tag=CON::getRow("SELECT id,id_user,status FROM tags WHERE md5(id)=?",array(intToMd5($_GET['tag'])));
		switch($_GET['action']){
			case 3://redistribute
				//getting tag source
				$_sourceTag=CON::getRow("SELECT source,id_creator, CONCAT(text,' ',text2,' ',code_number) AS text FROM tags WHERE id=?",array($tag['id']));

				//Toma redistribuciones de tags como trending toping
				set_trending_topings($_sourceTag['text'],true);

				if($tag['id_user']!=$myId && !CON::getVal("SELECT id FROM tags
					WHERE id_creator!=id_user AND id_user=? AND source=?",array($myId,$_sourceTag['source']))){
					//Tabla Tags
					$atributes='
						id_user,			id_creator,	id_product,		background,
						code_number,		color_code,	color_code2,	color_code3,
						text,				text2,		geo_lat,		geo_log,
						profile_img_url,	video_url,	date,			status,
						points,				source,		id_business_card
					';
					incPoints(8,$tag['id'],$tag['id_user'],$myId); //incremento de hits a la tag que se recibe
					incHitsTag($tag['id']);
					CON::query("INSERT INTO tags ($atributes)
											SELECT	 $atributes
											FROM tags
											WHERE id =?",array($tag['id']));
					$idTag=mysqli_insert_id(CON::con());
					createTag($idTag,true,is_debug());
					//act dueño tag
					CON::update("tags","id_user=?"," id=?",array($myId,$idTag));
					
					//notificacion de redistribucion - envio de correo
					notifications($_sourceTag["id_creator"],$tag['id'],8);
				}else $msgBox = '<img src="img/re-distribuirTag.png" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" />';
			break; // END - redistribute (3)
			case 4: //add favorite
				if (!CON::getVal("SELECT id FROM likes WHERE id_source=? AND id_user=?",array($tag['id'],$myId))){
					CON::insert("likes","id_user=?,id_source=?,date=NOW()",array($myId,$tag['id']));
					CON::delete("dislikes","id_user=? AND id_source=?",array($myId,$tag['id']));
					incPoints(2,$tag['id'],$tag['id_user'],$myId);
                    incHitsTag($tag['id']);
					if ($myId!=$tag['id_user']){
						$bandera=false;
						if ($_SESSION['ws-tags']['ws-user']['like']!=null){
							for ($i=0;$i<count($_SESSION['ws-tags']['ws-user']['like']);$i++)
								if ($tag['id']==$_SESSION['ws-tags']['ws-user']['like'][$i]) $bandera=true;
						}else with_session(function($sesion){
							$sesion['ws-tags']['ws-user']['like']=array();
							return $sesion;
						});
						if($bandera==false){
							$select_id = $GLOBALS['cn']->query("SELECT id_creator, id_user FROM tags WHERE id = '".$tag['id']."'");
							$selectUser = mysql_fetch_assoc($select_id);
							notifications($tag['id_user'],$tag['id'],2);
							with_session(function($sesion)use($tag){
								$sesion['ws-tags']['ws-user']['like'][]=$tag['id'];
								return $sesion;
							});
						}
					}
				}
				//salidas WEB o APP
				$likes=CON::count('likes','id_source=?',array($tag['id'])); 
				$dislikes=CON::count('dislikes','id_source=?',array($tag['id']));

				if (isset($_GET['this_is_app'])){ //app
					die(jsonp(array('success'=>'likes','likes'=>$likes,'dislikes'=>$dislikes)));
				}else{ //la web
					//se valida el tipo de salida
					$msgBox='<img src="img/star.png" title="'.$lang["TAGS_OPTIONUNLIKE"].'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';
					if ($_GET['isComment']==1) //si el like es desde un ventana de comentarios
						$msgBox = '<a href="javascript:void(0);" onfocus="this.blur();" title="'.$lang["COMMENTS_FLOATHELPLINKLIKES"].'" action="UserLikedOrRaffle,l,'.$tag['id'].'" style="color:#F58220;font-weight:bold;">'.$likes.'</a>';
					else
						$msgBox = '<img src="img/star.png" title="'.$lang["TAGS_OPTIONUNLIKE"].'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';
					////salida alterna para News
					if($_GET['news']==1) $msgBox = $dislikes.'|'.$likes;	
				}
			break; // END - favorite (4)
			case 5: // share (by mail)
				$tag = CON::getRow("SELECT 
						md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code,
						u.profile_image_url	 AS photoUser,
						t.id AS idTag,
						t.id_user AS idUser,
						u.email AS email,
						u.referee_number AS referee_number
					FROM tags t JOIN users u ON t.id_creator = u.id
					WHERE t.id =?",array($tag['id']));
				incPoints(7,$tag['idTag'],$tag['idUser'],$_SESSION['ws-tags']['ws-user']['id']); //incremento de hits a la tag que se recibe
				incHitsTag($tag['idTag']);
                $mails=explode(',',$_POST['mails']);
				if(count($mails)>0){
					$array=array('correos'=>'','per'=>$mails,'msj'=>$_POST['msj']);
					$array=notifications(false,$tag['idTag'],7,false,false,$array);
				}
				$res = '';
				for ($i=0; $i < count($mails); $i++) {
					if (!filter_var($mails[$i], FILTER_VALIDATE_EMAIL)) {
					   $tag = CON::getRow("SELECT 
					   							id, email 
					   					   FROM users 
					   					   WHERE MD5(id) = ?",$mails[$i]);
					   $res.= '- '.$tag['email'].'<br>';
					}else{
						$res.= '- '.$mails[$i].'<br>';
					}					
				}
				// $msgBox = implode($mails);
				$msgBox='<div class="div_exito"><strong>'.$lang['MENUTAG_CTRSHAREMAILEXITO'].":</strong></div><br><br> ".$res;
				if ($array['correos']==="") $msgBox=$_GET['device']? '<div class="div_error">'.$_GET['device'].'<br>'.$lang['MENUTAG_CTRSHAREMAILERROR'].'</div>':'<div class="div_error">'.$lang['MENUTAG_CTRSHAREMAILERROR'].'</div>';
				if (isset($_GET['this_is_app'])){ 
					if ($array['correos']==="") $pass=false;
					else $pass=true;
					die(jsonp(array('success'=>$pass,'msg'=>$msgBox)));
				}
			break; //share
			//delete
			case 6:
				if(isset($_REQUEST['url'])){
					$idcre=CON::getVal("SELECT id_creator FROM tags WHERE id=?",array($tag['id']));
					CON::update("tags","status='2'","id=? AND source =? AND id_creator=? AND status='10' ",array($tag['id'],$tag['id'],$idcre));

					if (isset($_GET['report'])) {
						$idcre=CON::getVal("SELECT id_creator FROM tags WHERE id=?",array($tag['id']));
						CON::update("tags","status='2'","id=? AND source =? AND id_creator=? AND status='1' ",array($tag['id'],$tag['id'],$idcre));
						CON::update("tags_report","status='2'","id_tag=? AND status='1' ",array($tag['id']));
					}
					// echo CON::lastSql();
					header('Location: '.$config->main_server.$_REQUEST['url'].'');
				}else{
					if($tag['status']=='4') {//si la tag es privada
						// eliminamos los tags privados
						$delete = CON::delete("tags_privates","id_tag =? AND id_friend=?",array($tag['id'],$myId));
						// eliminamos las notificaciones de esa tag
						$delete = CON::delete("users_notifications","id_source =? AND id_friend = ? AND id_type IN (1,2,4,7,8,9,10)",array($tag['id'],$myId));
						// eliminamos los comentarios de la tag
						$delete = CON::delete("comments","id_type='4' AND id_source=? AND id_user_from =?",array($tag['id'],$myId));
						$msgBox = 1;
					} else {
						//validamos si la tag es un sponsor activo
						$validateSponsor = CON::count("users_publicity","id_tag=? AND status ='1'",array($tag['id']));
						//AND id_user = "'.$myId.'"
						if ($validateSponsor==0){ //si la tag no es un patrocinio
							$redist = CON::getVal("SELECT source FROM tags WHERE source !=? AND id!=source AND id=? LIMIT 1",array($tag['id'],$tag['id']));
							if($redist!=''){//si fue redistribuida se le cambia el estado
								CON::update("tags","status='2'","id=? AND source=? AND (id_creator=? OR id_user=?)",array($tag['id'],$redist,$myId,$myId));
							}else{ //si no fue redistribuida  la eliminamos
								CON::update("tags","status='2'","source=? AND id=source AND (id_creator=? OR id_user=?)",array($tag['id'],$myId,$myId));
								// eliminamos los tags privados
								CON::delete("tags_privates","id_tag=?",array($tag['id']));
								// eliminamos las notificaciones de esa tag
								CON::delete("users_notifications","id_source=? AND id_type IN (1,2,4,7,8,9,10)",array($tag['id']));
								// eliminamos los comentarios de la tag
								CON::delete("comments","id_source=?",array($tag['id']));
							}
							//decremento del numero de tags del usuario
							updateUserCounters(	$_SESSION['ws-tags']['ws-user']['id'], 'tags_count', '1',	'-');
							$msgBox = 1;
						}elseif($validateSponsor>0){ //si la tag esta patrocinada
							$msgBox = MENUTAG_CTRERRORDELETETAGSPONSORED;
						}
					}//else delprivate
				}
			break; //end delete
			case 8: ////report
				//validamos si es mi misma tag
				$creador = CON::getVal("SELECT id_creator FROM tags WHERE id =? ",array($tag['id']));
				$myId=$_SESSION['ws-tags']['ws-user']['id'];
				if ($creador!=$myId){
					//validamos si ya se denuncio el tag
					if (!CON::getVal("SELECT id FROM tags_report WHERE id_tag=? AND id_user_report=?",array($tag['id'],$myId))){
						CON::insert("tags_report","id_tag=?,id_user_creator=?,id_user_report=?, 
									type_report=(SELECT tp.id FROM type_tag_report tp WHERE md5(tp.id)=?)",array($tag['id'],$creador,$myId,$_GET['type_report']));
						//cantidad de reportes
						$Nreport = CON::getVal("SELECT COUNT(id_tag) FROM tags_report WHERE id_tag=?",array($tag['id']));
						//numero de seguidores
						$Nsegui = CON::getVal("SELECT COUNT(id_user) FROM users_links WHERE id_friend=?",array($creador));
						$row=CON::getRow("SELECT porcen_reporta_tag,emails_admin_reports_tags FROM config_system WHERE id=1");
						//porcentaje de seguidores
						$porcenEmails = $row['porcen_reporta_tag'];
						//correos destinatarios 
						$emails = $row['emails_admin_reports_tags'];

						//calculo del porcentje para enviar los correos
						$total = (($Nsegui*$porcenEmails)/100);
						// echo 'id creador '.$creador.'<br> num repor '.$Nreport.'<br> num segui '.$Nsegui.' <br> porcentaje de seguidores '.$porcenEmails.' <br> porcen sin deci '.round($total);
						if ($Nreport>=$total) notifications(false,$tag['id'],21,false,false,array('emails'=>explode(',',$emails)));
						incPoints(21,$tag['id'],$tag['id_user'],$myId);
						incHitsTag($tag['id']);
                        if($_SESSION['ws-tags']['ws-user']['super_user']==1&&$typeR=='6')
							CON::update("tags","status='2'","id=?",array($tag['id']));
						echo '<div class="success_message"><img src="'.$config->main_server.'imgs/message_success.png" /> '.$lang["ACTIONTAG_REPORTEXITO"].'</div>';
					}else echo '<div class="error_message"><img src="'.$config->main_server.'imgs/message_error.png" /> '.$lang["ACTIONTAG_REPORTERROR1"].'</div>';
				}else echo '<div class="error_message"><img src="'.$config->main_server.'imgs/message_error.png" /> '.$lang["ACTIONTAG_REPORTERROR2"].'</div>';
			break;//END report
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
					$_datos = "SELECT
							MAX(cost) AS cost,
							id,
							click_to
						FROM cost_publicity
						WHERE id_typepublicity = '4'
						GROUP BY cost
						LIMIT 0, 1
					";
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
				if (!CON::getVal("SELECT id FROM dislikes WHERE id_source=? AND id_user=?",array($tag['id'],$myId))){
					CON::insert("dislikes","id_user=?,id_source=?,date=NOW()",array($myId,$tag['id']));
					CON::delete("likes","id_user=? AND id_source=?",array($myId,$tag['id']));
					incPoints(20,$tag['id'],$tag['id_user'],$myId); //incremento de hits a la tag que se recibe
					incHitsTag($tag['id']);
					
				}
				//salidas WEB o APP
				$likes=CON::count('likes','id_source=?',array($tag['id'])); $dislikes=CON::count('dislikes','id_source=?',array($tag['id']));

				if (isset($_GET['this_is_app'])){ //app
					die(jsonp(array('success'=>'dislikes','likes'=>$likes,'dislikes'=>$dislikes)));
				}else{ //la web
					//se valida el tipo de salida
					$msgBox='<img src="img/star.png" title="'.$lang["TAGS_OPTIONUNLIKE"].'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');" />';
					if ($_GET['isComment']==1) //si el like es desde un ventana de comentarios
						$msgBox = '<a href="javascript:void(0);" onfocus="this.blur();" title="'.$lang["COMMENTS_FLOATHELPLINKLIKES"].'" action="UserLikedOrRaffle,d,'.$tag['id'].'" style="color:#F58220;font-weight:bold;">'.$likes.'</a>';
					else
						$msgBox = '<img src="img/star.png" title="'.$lang["TAGS_OPTIONUNLIKE"].'" width="29" height="29" border="0" style="border:0px; cursor:pointer; margin:0" onclick="send_ajax(\'controls/tags/actionsTags.controls.php?action=4&tag='.$tag['id'].'\', \'#start_favorite'.$_GET["current"].'_'.$tag['id'].'\', 0, \'html\');"  />';
					////salida alterna para News
					if($_GET['news']==1) $msgBox = $dislikes.'|'.$likes;	
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

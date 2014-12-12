<?php
/*******************************/
/*   Agerga, edita y elimina   */
/*   un producto o una rifa		*/
/*	de la store					*/
/*******************************/

//Includes a utilizar
include '../header.json.php';
include (RELPATH.'class/class.phpmailer.php');
// $_GET['acc']='0';
// $userId='1'; 
// $status='2'; 
// $txtCategory='3';
// $txtSubCategory='4';
// $txtName='5';
// $txtDescription='6'; 
// $txtStock='7'; 
// $txtPrice='8';
// $img='9';
// $place='10';
// $txtMethod='11';
// $txtVideo='12';

switch ($_GET['acc']) {
    case 'img': 
        $img = uploadPhoto();
        $res['action'] = 'img';
		$res['img'] = $img;
        break;
    case '0': //Agregar producto
		if( quitar_inyect() ) {
			$userId = $_SESSION['ws-tags']['ws-user']['id'];
			foreach ($_POST as $nameVar => $valueVar) ${$nameVar} = "$valueVar";
			$txtPrice = str_replace(',','',$txtPrice); //Formatea el tipo de dinero para ser insertado
			
            if (isset($backgSelect_)){
				$place='null';
				$txtCategory='1';
				$txtSubCategory='1';
				$txtMethod=0;
                $img=$backgSelect_;
			}else{ 
			    $place='1'; 
                for($i=1;$i<6;$i++){ if($_POST['backgSelect_'.$i]!='') { $img=$_POST['backgSelect_'.$i]; break; } }
				// echo $img;
            }
            if($txtVideo==''||!preg_match(regex('video'),$txtVideo)) $txtVideo=='http://';
            else $txtVideo=str_replace("'",'',$txtVideo);
           	$idproduct=CON::insert('store_products','id_user=?,
									id_status=?,id_category=?,
									id_sub_category=?,name=?,
									description=?,stock=?,
									sale_points=?,photo=?,
									join_date=NOW(),update_date=NOW(),
									place=?,formPayment=?,
									video_url=?',array($userId,$status,$txtCategory,$txtSubCategory,formatText($txtName),$txtDescription,$txtStock,$txtPrice,$img,$place,$txtMethod,$txtVideo));
			if (!isset($backgSelect_)){
				$band=false;
				// $idproduct=mysql_insert_id();
				$sql='INSERT INTO `store_products_picture` (
						`id` ,`id_product` ,`picture` ,`order` ,`status` ) VALUES ';
				for ($y=1;$y<6;$y++){
					if ($_POST['backgSelect_'.$y]){
						$sql.=($band?',':'').safe_sql("(?,?,?,?,1)",array($y,$idproduct,$_POST['backgSelect_'.$y],$_POST['txtOrder'.$y]));
						$band=true;
					}
				}
				$sql.=';';
				$result = CON::query($sql);
			}
			if($result){ 
				$res['action'] = 'insert'; 
				$wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
				if (!$wid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
				notifications($userId,$idproduct,'29',"",$wid);
			}			
		}
    break;
    case '1': //Editar Producto
		if( quitar_inyect() ) {
		  if( isset($_GET['id']) ){
    		  if (existe('store_products', 'id', 'WHERE id= "'.$_GET['id'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"')){
    			if (!existe('store_orders o JOIN store_orders_detail od ON od.id_order=o.id', 'o.id', 'WHERE od.id_product= "'.$_GET['id'].'" AND ((o.id_status="1" AND od.id_status="11") OR (o.id_status="11" AND od.id_status="11"))')){
				    foreach ($_POST as $nameVar => $valueVar) ${$nameVar} = "$valueVar";
					if (isset($backgSelect_)){
        				$place='null';
        				$txtCategory='1';
        				$txtSubCategory='1';
        				$txtMethod=0;
                        $img=$backgSelect_;
        			}else{ 
        			    $place='1'; 
                        for($i=1;$i<6;$i++){ if($_POST['backgSelect_'.$i]!='') { $img=$_POST['backgSelect_'.$i]; break; } }
                    }
					$txtPrice = str_replace(',','',$txtPrice); //Formatea el tipo de dinero para ser insertado
                    if($txtVideo==''||!preg_match(regex('video'),$txtVideo)) $txtVideo=='http://';
                    else $txtVideo=str_replace("'",'',$txtVideo);					
					$result = CON::update('store_products','id_status=?,name=?,id_category=?,id_sub_category=?,
										description=?,stock=?,sale_points=?,photo=?,update_date=NOW(),formPayment=?,video_url=?',
										'id=?',
										array($status,formatText($txtName),$txtCategory,$txtSubCategory,$txtDescription,$txtStock,$txtPrice,$img,$txtMethod,$txtVideo,$_GET['id']));
					if (!isset($backgSelect_)){
						$band=false;
						for ($y=1;$y<6;$y++){
							if ($_POST['backgSelect_'.$y])
								CON::insert_or_update('store_products_picture','picture=?,store_products_picture.order=?','id=?,id_product=?,status=1','id=? AND id_product=?',
									array($_POST['backgSelect_'.$y],$_POST['txtOrder'.$y],$y,$_GET['id'],$y,$_GET['id']));
						}
					}
                    if ($result) $res['action']='update';
    			  }else{ $res['action']='no-update'; }
                }else{$res['action']='no-per-id-update'; }
            }else{ $res['action']='no-id-update'; }
		}
    break;
    case '2': //Borrar Producto
        if(isset($_GET['id'])){
            if (existe('store_products', 'id', 'WHERE id= "'.$_GET['id'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"')){
                if (!existe('store_orders o JOIN store_orders_detail od ON od.id_order=o.id', 'o.id', 'WHERE od.id_product= "'.$_GET['id'].'" AND ((o.id_status="1" AND od.id_status="11") OR (o.id_status="11" AND od.id_status="11"))')){
    				$sql="  UPDATE store_products 
                            SET id_status='2', stock=0  
                            WHERE id= ".$_GET['id'];
    				$result = $GLOBALS['cn']->query($sql);
    				if( $result ) $res['action']='delete';
    			}else{ $res['action']='no-update'; }
            }else{$res['action']='no-per-id-update'; }
        }else{ $res['action']='no-id-update'; }
    break;
	case '3'://crear una nueva rifa
        if (isset($_GET['idProduct'])){
			if(!existe('store_raffle', 'id', 'WHERE id_product = "'.$_GET['idProduct'].'" AND id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'" AND status = 1')){
				$carrito=$GLOBALS['cn']->query('SELECT id_category,stock FROM store_products WHERE id="'.$_GET['idProduct'].'" AND id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'" AND id_status = 1 LIMIT 1;');				
                if (mysql_num_rows($carrito)>0){
                    $carrito=  mysql_fetch_assoc($carrito);
    				if ($carrito['id_category']!='1'){
    					$num=(intval($carrito['stock'])-1);
    					if ($num>=0){
    						$GLOBALS['cn']->query('	UPDATE store_products SET 
    													'.($num=='0'?'id_status="2",':'').'
    														stock='.$num.'
    												WHERE id="'.$_GET['idProduct'].'" 
    												AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'";');
    						$_GET['txtPrice'] = str_replace(',','',$_GET['txtPrice']); //Formatea el tipo de dinero para ser insertado
    						$GLOBALS['cn']->query("INSERT INTO store_raffle
    									   SET id_product = '".$_GET['idProduct']."',
    										   id_user    = '".$_SESSION['ws-tags']['ws-user']['id']."',
    										   points     = '".$_GET['txtPrice']."',
    										   cant_users = '".$_GET['txtCant']."',
    										   status     = '1'");
    						$res['action']='rifa';
    					}else{ $res['action']='no-stock'; }
    				}else{
    					$GLOBALS['cn']->query("INSERT INTO store_raffle
    									   SET id_product = '".$_GET['idProduct']."',
    										   id_user    = '".$_SESSION['ws-tags']['ws-user']['id']."',
    										   points     = '".$_GET['txtPrice']."',
    										   cant_users = '".$_GET['txtCant']."',
    										   status     = '1'
    					");
    					$res['action']='rifa';
    				}
                }else{ $res['action']='no-per-id-update'; }
			}else{ $res['action']='exist'; }
        }else{ $res['action']='no-id-update'; }
	break;
	case '4': //unirse a la rifa y sorteo de la rifa...
			//cantidad de usuarios unidos a la rifa y cantidad maxima de usuarios
        if (isset($_GET['rfl'])){
            if (!existe('store_raffle r INNER JOIN store_raffle_join rj ON rj.id_raffle = r.id','r.id','WHERE  md5(r.id) = "'.$_GET['rfl'].'" AND rj.id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"')){
			$Raffle = $GLOBALS['cn']->query("
											SELECT 
												(SELECT COUNT( rj.id ) FROM store_raffle r INNER JOIN store_raffle_join rj ON rj.id_raffle = r.id WHERE  md5(r.id) =  '".$_GET['rfl']."') AS cant_join, 
												r.cant_users, 
												r.points,
												r.id,
                                                r.id_user
											FROM store_raffle r
											WHERE  md5(r.id) =  '".$_GET['rfl']."' AND r.id_user!='".$_SESSION['ws-tags']['ws-user']['id']."' LIMIT 0,1;");
			$Raffles = mysql_fetch_assoc($Raffle);
			$idRaffle=$Raffles['id'];
			if($Raffles['cant_join']<$Raffles['cant_users']){
				//consultamos los puntos del usuario
				$pointsUser = $GLOBALS['cn']->query("
							SELECT a.accumulated_points AS accumulated_points,
								   a.current_points AS current_points
							FROM users a
							WHERE id = '".$_SESSION['ws-tags']['ws-user']['id']."'
				");
				$pointsUsers = mysql_fetch_assoc($pointsUser);

				if($pointsUsers['current_points']>$Raffles['points']){
					//decrementar los puntos del usuario por ingresar a la rifa
					$GLOBALS['cn']->query("
						UPDATE users
						SET    accumulated_points = accumulated_points - '".$Raffles['points']."',
							   current_points = current_points - '".$Raffles['points']."'
						WHERE id = '".$_SESSION['ws-tags']['ws-user']['id']."'
					");
                    $GLOBALS['cn']->query("
						UPDATE users
						SET    accumulated_points = accumulated_points + '".$Raffles['points']."',
							   current_points = current_points + '".$Raffles['points']."'
						WHERE id = '".$Raffles['id_user']."'
					");
					//ingresamos al usuario a la rifa
					$GLOBALS['cn']->query("INSERT INTO store_raffle_join
											  SET id_user = '".$_SESSION['ws-tags']['ws-user']['id']."',
												  id_raffle = '".$idRaffle."'");
					$id = mysql_insert_id();
					$res['action']=($id)?'join':'error';
					if(($Raffles['cant_join']+1)==$Raffles['cant_users']){
						$GLOBALS['cn']->query("UPDATE store_raffle  SET status = '2', end_date = NOW()  WHERE id = '".$idRaffle."'");
						$res['action'] = 'end';

						//seleccionamos el ganador
						$selectWinner = $GLOBALS['cn']->query("
									SELECT
										a.id_user as id_user,
										u.email as email,
										md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code,
										CONCAT(u.name, ' ', u.last_name) AS name_user,
										u.username AS username,
										u.profile_image_url AS profile_image_url,
										(SELECT a.name FROM countries a WHERE a.id=u.country) AS pais,
										u.followers_count AS followers,
										u.friends_count AS friends

									FROM store_raffle_join a
									INNER JOIN users u ON u.id=a.id_user
									WHERE id_raffle = '".$idRaffle."'
									ORDER BY RAND()
									LIMIT 1");
						$Winner = mysql_fetch_assoc($selectWinner);

						//Guarad id del ganador de la rifa
						$updateWinner = "UPDATE store_raffle SET winner = ".$Winner['id_user']." WHERE id = $idRaffle LIMIT 1";
						$GLOBALS['cn']->query($updateWinner);

						//seleccionamos el dueno de la rifa y seleccionamos el producto concursante en la rifa
						$selectOwner = $GLOBALS['cn']->query("
							SELECT 
								a.id_user AS id_user, 
								a.id_product AS id_product, 
								b.email AS email,
								p.name AS name,
								p.photo AS photo,
								p.description AS description,
								p.place AS place
						  FROM store_raffle a
						  INNER JOIN store_products p ON p.id=a.id_product
						  INNER JOIN users b ON b.id = a.id_user
						  WHERE a.id =  '".$idRaffle."';
								");
						$Owner = mysql_fetch_assoc($selectOwner);
						//detalles del correo
						//seleccionamos todos los usuarios de la rifa
						$selectAll = $GLOBALS['cn']->query("
									SELECT a.id_user as id_user,
										   b.email as email
									FROM store_raffle_join a
									INNER JOIN users b ON b.id=a.id_user
									WHERE id_raffle = '".$idRaffle."'
									");
						$backg=FILESERVER.'img/'.$Owner['photo'];
						$foto_remitente	=FILESERVER.getUserPicture($Winner['code'].'/'.$Winner['profile_image_url'],'img/users/default.png');
						if (trim($Winner['username'])!=''){
								$external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.":&nbsp;<span ><a style='color:#999999' href='".base_url($Winner['username'])."' onFocus='this.blur();' target='_blank'>".DOMINIO.$Winner['username']."</a><br>";
						}else { $external=  formatoCadena($Winner['name_user']); }
						if (trim($Winner['pais'])!=''){
								$pais=USERS_BROWSERFRIENDSLABELCOUNTRY.":&nbsp;<span style='color:#999999'>".$Winner['pais']."</span><br/>";
						}
						$winnerData='<tr>
										<td style="padding: 4px 0; color:#F82; font-weight: bold">'.STORE_RAFFLEWINNER.':</td>
										<td style="color:#888">
											<table style="width:100%;">
												<tr>
													<td style="padding-left:5px; font-size:14px; text-align:left">
														<img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:3px solid #CCCCCC">
													</td>
													<td width="569" style="padding-left:5px; padding-bottom:20px; font-size:12px; text-align:left;">
															<div>
																	'.$external.'
																	'.$pais.'
																	<strong>'.USERS_BROWSERFRIENDSLABELFRIENDS.'('.$Winner[friends].'),&nbsp;'.USERS_BROWSERFRIENDSLABELADMIRERS.'('.$Winner['followers'].')</strong>
															</div>
													</td>
												 </tr>
											</table>
										</td>
									</tr>';
						while($All = mysql_fetch_assoc($selectAll)){

							$body = '
									<table border="0" align="center" width="700">
										<tr>
											<td style="height:30px; font-size: 20px; color:#F82; font-weight:bold; border-bottom:1px dotted #CCC;text-align:center;">
											'.STORE_THANKYOUREFFLEEMAIL.'<br><br><div style="font-size:14px; color:#888;">'.STORE_FINALRESULTMAIL.'</div>
											</td>
										</tr>
										<tr>
											<td style="border-top:1px dotted #CCC;">
												<table border="0" width="600" align="center">
													<tr>
														<td colspan="2" style="padding: 10px 0">&nbsp;</td>
													</tr>
													'.$winnerData.'
													<tr>
														<td style="padding: 10px 0 0 0; color:#F82; font-weight: bold;text-align:left;">'.STORE_RAFFLEPRODUCTEMAIL.':</td>
														<td style="color:#888; padding: 10px 0 0 10px;text-align:left;">'.$Owner['name'].'</td>
													</tr>
													<tr>
														<td style="padding: 4px 0 0 0; color:#F82; font-weight: bold;  vertical-align: top;text-align:left;">'.STORE_DESCRIPTIONEMAIL.':</td>
														<td style="padding: 0 0 0 10px;color:#888;text-align:justify;">'.$Owner['description'].'</td>
													</tr>
													<tr>
														<td colspan="2" align="center" style="padding: 20px 0" ><img src="'.$backg.'"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" style="font-size: 12px;padding: 10px 0; color:#777">'.STORE_FOOTERMESAAGESMAIL.' <a target="_blank" href="'.base_url('store?sc=5').'">'.PRODUCTS_RAFFLE.'</a></td>
										</tr>
									</table>';

							// Envia notificacion a participantes y a ganador con informacion e la rifa
							if($All['id_user'] != $Winner['id_user']){
								notifications($All['id_user'],$idRaffle,18,'',$Winner['id_user']); //Participante
							}else{
								notifications($Winner['id_user'],$idRaffle,19,'',427); //Ganador
							}

							if(sendMail(formatMail($body, '790'), EMAIL_NO_RESPONDA, 'Tagbum.com', STORE_RAFFLEEMAILMESSAGE, $All['email'], '../../'))
								$emailSendAll = '1';
							else
								$emailSendAll = '0';

						}//fin while usuarios participantes

						//correo dueno
						$bodyOwner = '
							<table border="0" align="center" width="700">
								<tr>
									<td style="height:30px; font-size: 20px; color:#F82; font-weight:bold; border-bottom:1px dotted #CCC;text-align:center;">
									'.STORE_RAFFLEENDMESSAGE.'<br><br><div style="font-size:14px; color:#888;">'.STORE_FINALRESULTMAIL.'</div>
									</td>
								</tr>
								<tr>
									<td style="border-top:1px dotted #CCC;">
										<table border="0" width="600" align="center">
											<tr>
												<td colspan="2" style="padding: 20px 0; font-weight: bold; color:#888;">'.STORE_WINNERPRODUCT.' '.$Owner['name'].' '.STORE_WINNERPRODUCTES.':</td>
											</tr>
											'.$winnerData.'
											<tr>
												<td style="padding: 15px 0 0 0; color:#F82; font-weight: bold;  vertical-align: top" colspan="2" align="center">'.STORE_RAFFLEPRODUCTEMAIL.':</td>
											</tr>

											<tr>
												<td colspan="2" align="center" style="padding: 20px 0" ><img src="'.$backg.'"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="center" style="font-size: 12px;padding: 10px 0; color:#777">'.STORE_FOOTERMESAAGESMAIL.' <a target="_blank" href="'.base_url('store?sc=5').'">'.PRODUCTS_RAFFLE.'</a></td>
								</tr>
							</table>';

							sendMail(formatMail($bodyOwner, '790'), EMAIL_NO_RESPONDA, 'Tagbum.com', STORE_RAFFLEEMAILMESSAGE, $Owner['email'], '../../');
						//correo dueno
					//fin detalles del correo
					}
				}else{ $res['action']='no-points'; }
            }else{ $res['action']='no-cupon'; }
            }else{ $res['action']='exist'; }
        }else{ $res['action']='no-id-update'; }
	break;
}

//Retorno al ajax
die(jsonp($res));

//Funciones necesartias
function uploadPhoto(){
    //Si todo salio bien (valor de retorno)
	$auxi='';
	if ($_SESSION['ws-tags']['ws-user']['type']==1){
		$auxi=$_GET['num'];
		$pa='store';
	} else { $pa='templates'; }
    $imagesAllowed = array('jpg','jpeg','png','gif');
    $parts         = explode('.', $_FILES['photo'.$auxi]['name']);
    $ext           = strtolower(end($parts));
    if (in_array($ext,$imagesAllowed)){
        $path  = RELPATH."img/".$pa."/".$_SESSION['ws-tags']['ws-user']['code'].'/';       //ruta para crear dir
        $photo = $_SESSION['ws-tags']['ws-user']['code'].'/'.md5($_FILES['photo'.$auxi]['name']).'.jpg';
        $photo_= md5($_FILES['photo'.$auxi]['name']).'.jpg';

        //existencia de la folder
        if (!is_dir ($path)){
            $old = umask(0);
            mkdir($path,0777);
            umask($old);
            $fp=fopen($path.'index.html',"w");
            fclose($fp);
        }// is_dir

        if (redimensionar($_FILES['photo'.$auxi]['tmp_name'], RELPATH."img/".$pa."/".$photo, 650)){
            uploadFTP($photo_,$pa,RELPATH);
            $r['img'] = $pa.'/'.$photo;
            $r['pos']=($auxi?$auxi:'');
        }
    }else {$r['img']=''; }
    return $r;
}
?>

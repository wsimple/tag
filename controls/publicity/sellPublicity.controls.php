<?php
	require_once '../../includes/session.php';
	require_once '../../includes/config.php';
	require_once '../../includes/functions.php';

	 if (quitar_inyect()) {

		 
		 require_once '../../class/wconecta.class.php';
		 require_once '../../includes/languages.config.php';
		 require_once '../../class/class.phpmailer.php';

	 if ($_GET[ajax]=='1' && $_GET[op]=='1') {
	     
		 //validacion del click en la publicidad por usuario
		 $validaClick = validPointPubli($_SESSION['ws-tags']['ws-user'][id],$_GET[p],$_SERVER['REMOTE_ADDR']);
		 
		 if(($_SESSION['ws-tags']['ws-user'][id]!='')&&($validaClick==1)){
			 			
			$update = $GLOBALS['cn']->query("UPDATE users_publicity SET click_current = click_current + 1 WHERE md5(id) = '".$_GET[p]."'");

			$update = $GLOBALS['cn']->query("UPDATE users_publicity SET status = '2' WHERE click_current >= click_max ");

			//datos publi
			$publix  = $GLOBALS['cn']->query("SELECT (select a.name from type_publicity a where a.id = p.id_type_publicity) AS type,
													 (select b.email from users b where b.id = p.id_user) AS email_persona,
													 (select concat(c.name, ' ',c.last_name) as name from users c where c.id = p.id_user) AS persona,
													 (select d.name from status d where d.id = p.status) AS status,

													  p.cost_investment AS cost_investment,
													  p.click_max AS click_max,
													  p.click_current AS click_current,
													  p.link AS link

											  FROM users_publicity p

											  WHERE md5(id) = '".$_GET[p]."'
											 ");

			$publi = mysql_fetch_assoc($publix);

		 if ($publi[click_max] == $publi[click_current]){

				  //verificaci�n de finalizaci�n de la campa�a
				  $body = '
							 <table width="600" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
							 <tr>
							 <td style="text-align:left; font-size:18px; padding:0"><strong>'.PUBLICITY_CTREMAILTITLE1.'</strong>&nbsp;</td>
							 </tr>
							 <tr>
							 <td>&nbsp;</td>
							 </tr>
							 <tr>
							 <td style="font-size:11px; color:#000; padding:0; text-align:justify">
							 '.PUBLICITY_CTREMAILTITLE2.'.</td>
							 </tr>
							 <tr>
							 <td>&nbsp;</td>
							 </tr>
							 <tr>
							 <td style="text-align:left; padding:3px"><strong>'.PUBLICITY_CTREMAILDATO1.':</strong>&nbsp;'.$publi[type].'</td>
							 </tr>
							 <tr>
							 <td style="text-align:left; padding:3px"><strong>'.PUBLICITY_CTREMAILDATO2.':</strong>&nbsp;'.$publi[cost_investment].'</td>
							 </tr>
							 <tr>
							 <td style="text-align:left; padding:3px"><strong>'.PUBLICITY_CTREMAILDATO3.':</strong>&nbsp;'.$publi[click_max].'</td>
							 </tr>
							 <tr>
							 <td style="text-align:left; padding:3px"><strong>'.PUBLICITY_CTREMAILDATO4.':</strong>&nbsp;'.$publi[click_current].'</td>
							 </tr>
							 <tr>
							 <td style="text-align:left; padding:3px"><strong>'.PUBLICITY_CTREMAILDATO5.':</strong>&nbsp;<a href="'.$publi["link"].'">'.$publi["link"].'</a></td>
							 </tr>
							 <tr>
							 <td style="text-align:left; padding:3px"><strong>'.PUBLICITY_CTREMAILDATO6.':</strong>&nbsp;'.$publi[status].'</td>
							 </tr>
							 <tr>
							 <td>&nbsp;</td>
							 </tr>
							 <tr>
							 <td>'.PUBLICITY_CTREMAILTEXTO1.': <a href="'.base_url('?current=myPubli').'">View my Ads</a></td>
							 </tr>
							 <tr>
							 <td>&nbsp;</td>
							 </tr>
							 <tr>
							 <td>Tagbum - Team</td>
							 </tr>
							 <tr>
							 <td>&nbsp;</td>
							 </tr>
							 <tr>
							 <td style="border-top:1px solid #999">&nbsp;</td>
							 </tr>
							 <tr>
							 <td style="color:#CCC; text-align:center; padding:0"><a href="'.base_url().'">'.DOMINIO.'</a></td>
							 </tr>
							 <tr>
							 <td>&nbsp;</td>
							 </tr>
							 </table>
				 ';

				 @sendMail(formatMail($body, 700), "no-reply@seemytag.com", "Tagbum.com", PUBLICITY_CTREMAILASUNTO, $publi[email_persona], "../../");

			 }//if ($publi[click_max] == $public[click_current])

			  echo $validaClick;
			 //echo 'link: '.$publi['link'].'Ingreso clik: si '.$validaClick;

		}else{
			echo $validaClick;
		}

	 } elseif( !$_GET[ajax] ) {

			 switch( $_POST[op] ) {

					case '1': break; // case 1 (control de clicks)


				//updating publicity
					case '2':
							$datos	= $GLOBALS['cn']->query("SELECT picture FROM users_publicity WHERE md5(id) = '".$_POST[id_p]."'");
							$dato	= mysql_fetch_assoc($datos);

						//image validation
							$imagesAllowed	= array('jpg', 'jpeg', 'png', 'gif');
							$photo			= "";
							$save			= 1;
							$picture_bd	= "";

							if( $_FILES[publi_img][error]==0 ) {
								$imagesAllowed = array('jpg','jpeg','png','gif');
								$parts         = explode('.', $_FILES[publi_img][name]);
								$ext           = strtolower(end($parts));

								if (in_array($ext,$imagesAllowed)){
									//@unlink("../../img/publicity/".$dato[picture]); //borrado de la foto existente

									$path  = RELPATH."img/publicity/".$_SESSION['ws-tags']['ws-user'][code].'/';       //ruta para crear dir

									$photo = $_SESSION['ws-tags']['ws-user'][code].'/'.md5(str_replace(' ', '', $_FILES[publi_img][name])).'.jpg';

									// $photo_= md5($_FILES[publi_img][name]).'.jpg';

									$picture_bd = " ,picture = '".$photo."' ";

									//existencia de la folder
									if (!is_dir ($path)){
										$old = umask(0);
										mkdir($path,0777);
										umask($old);
										$fp=fopen($path.'index.html',"w");
										fclose($fp);
									}// is_dir

									if (redimensionar($_FILES[publi_img][tmp_name], RELPATH."img/publicity/".$photo, 200)){
										//echo $_FILES[photo][tmp_name].'<br>';

										// uploadFTP($photo_,"publicity", '../../');
										FTPupload('publicity/'.$photo);
										deleteFTP( str_replace($_SESSION['ws-tags']['ws-user'][code].'/','',$dato[picture]),'publicity');

									}else{
										echo "2";
//										redirect("../../?publicity=error");
//										exit();
										$save  = 0;
									}//copy

								}else{//extension
									echo "2";
//									redirect("../../?publicity=error");
//									exit();
									$save  = 0;
								}
							}//$_FILES
						//END - image validation

						//if image OK
							if( $save==1 ) {

								if(($_POST[publi_title]=='')||($_POST[publi_msg]=='')||($_POST[publi_link]==''))  {

									echo "1";

								}elseif(!isValidURL($_POST[publi_link])){

										echo "3";

									}else{


									$GLOBALS['cn']->query("
										UPDATE	users_publicity
										SET	title			= '".$_POST[publi_title]."',
											message			= '".$_POST[publi_msg]."',
											link			= '".$_POST[publi_link]."'
											$picture_bd
										WHERE	md5(id) = '".$_POST[id_p]."'");

									adPreference($_POST[publi_title]);
									echo "update";

									}
							}// save == 1
						//END - if image OK
					break;
					//END - updating publicity  - case '2':

				//creating a new publicity
					default:

						if( $_SESSION['ws-tags'][chkpublicity]==1 ) { //se valida que solo pase una vez por aqui

							$_SESSION['ws-tags'][chkpublicity] = 0;
							$imagesAllowed = array('jpg','jpeg','png','gif');
							$photo         = "";
							$save          = 1;

							if( !$_POST[picture] ) {
								if( $_FILES[publi_img][error]==0 ) {
									$imagesAllowed = array('jpg','jpeg','png','gif');
									$parts         = explode('.', $_FILES[publi_img][name]);
									$ext           = strtolower(end($parts));

									if( in_array($ext, $imagesAllowed) ) {
										$path  = RELPATH."img/publicity/".$_SESSION['ws-tags']['ws-user'][code].'/';       //ruta para crear dir
										$photo = $_SESSION['ws-tags']['ws-user'][code].'/'.md5(str_replace(' ', '', $_FILES[publi_img][name])).'.jpg';
										//$photo_= md5(str_replace(' ', '', $_FILES[publi_img][name])).'.jpg';

										//existencia de la folder
										if( !is_dir ($path) ) {
											$old = umask(0);
											mkdir($path,0777);
											umask($old);
											$fp=fopen($path.'index.html',"w");
											fclose($fp);
										}// is_dir

										if( redimensionar($_FILES[publi_img][tmp_name], RELPATH."img/publicity/".$photo, 200) ) {
											//echo $_FILES[photo][tmp_name].'<br>';
											FTPupload('publicity/'.$photo);

										}else{
											redirect("../../?publicity=error");
											exit();
											$save  = 0;
										}//copy

									} else {//extension
										redirect("../../?publicity=error");
										exit();
										$save  = 0;
									}
								}//$_FILES
							} else {//picture is not empty, product to publicity

								$path  = RELPATH.'img/publicity/'.$_SESSION['ws-tags']['ws-user'][code].'/';

								//existencia de la folder
								if( !is_dir ($path) ) {
									$old = umask(0);
									mkdir($path,0777);
									umask($old);
									$fp=fopen($path.'index.html', 'w');
									fclose($fp);
								}// is_dir

								//copy('../../img/products/'.$_POST[picture], '../../img/publicity/'.$_POST[picture]);
								
								//FTPcopy('products/'.$_POST[picture],'publicity/'.$_POST[picture]);

								copyFTP(str_replace($_SESSION['ws-tags']['ws-user'][code].'/','',$_POST[picture]), 'products', 'publicity', '../../');
								$photo=$_POST[picture];
							}

							if( $save==1 ) {
								$payment_type = $_POST[payment];
								if (!PAYPAL_PAYMENTS) $payment_type = '3';

						//payment methods
								switch( $payment_type ) {
									//payment = points
									case "3":
										$monto_inversion = $_POST[number_of_points];

										$id_points	= $GLOBALS['cn']->query("
													SELECT	id
													FROM	points_publicity
													WHERE	id_typepublicity = '2' AND '"
															.$_POST[number_of_points]."' BETWEEN min_points AND max_points");

										//if used points are aout of range, the clicks are calculated with the lowest factor
										if( mysql_num_rows($id_points)!=1 ) {

											$id_points	= $GLOBALS['cn']->query("
													SELECT	id
													FROM	points_publicity
													WHERE	id_typepublicity = '2' AND
															factor = (	SELECT	MIN(factor)
																		FROM	points_publicity
																		WHERE	id_typepublicity = '2')");
										}
										$id_points	= mysql_fetch_assoc($id_points);

										//updating user points
										$GLOBALS['cn']->query("
													UPDATE	users
													SET		current_points = current_points - '".$_POST[number_of_points]."'
													WHERE	id = '".$_SESSION['ws-tags']['ws-user'][id]."'");

										if( mysql_affected_rows()==1 ) {

											if( $_POST['do'] ) {
												$GLOBALS['cn']->query("DELETE FROM users_publicity WHERE md5(id) = '".$_POST['do']."'");
											}

											$insert = $GLOBALS['cn']->query("
													INSERT INTO users_publicity
													SET	id_tag				= '',
														id_type_publicity	= '2',
														id_cost				= '".$id_points[id]."',
														id_user				= '".$_SESSION['ws-tags']['ws-user'][id]."',
														id_currency			= '".$payment_type."',
														title				= '".$_POST[publi_title]."',
														message				= '".$_POST[publi_msg]."',
														link				= '".$_POST[publi_link]."',
														picture				= '".$photo."',
														picture_title_tag	= '',
														cost_investment		= '".$_POST[number_of_points]."',
														click_max			= '".intval($_POST[showedClicks])."',
														click_current		= '0',
														status				= '1'");


										} else {
											echo "CAN'T UPDATE users TABLE";
											die();
										}
										redirect(RELPATH."publicity");
									break;//END - payment = points case "3":


									//payment = $
									case "1":
										$monto_inversion = str_replace(',','',$_POST['publi_amount_1']);

										// $monto_inversion = $_POST[publi_amount_1].'.'.$_POST[publi_amount_1];

										//sondeo publicitario
										$valida = $GLOBALS['cn']->query("
												SELECT id, click_to, cost
												FROM cost_publicity
												WHERE '".factorPublicity(2, $monto_inversion)."' BETWEEN click_from AND click_to");

										if( mysql_num_rows($valida)>0 ) {

											$_datos = "
												SELECT id, click_to, cost
												FROM cost_publicity
												WHERE '".factorPublicity(2, $monto_inversion)."' BETWEEN click_from AND click_to";

										} elseif( mysql_num_rows($valida)==0 ) {

											$_datos = "
												SELECT MAX(cost) AS cost, id, click_to
												FROM cost_publicity
												WHERE id_typepublicity = '2'
												GROUP BY cost
												LIMIT 0,1";
										}

										$costos = $GLOBALS['cn']->query($_datos);
										$costo  = mysql_fetch_assoc($costos);

										//insert patrocinio
										$insert = $GLOBALS['cn']->query("
											INSERT INTO users_publicity
											SET id_tag				= '',
												id_type_publicity	= 2,
												id_cost				= '".$costo[id]."',
												id_user				= '".$_SESSION['ws-tags']['ws-user'][id]."',
												id_currency			= '".$payment_type."',
												title				= '".$_POST[publi_title]."',
												message				= '".$_POST[publi_msg]."',
												link				= '".$_POST[publi_link]."',
												picture				= '".$photo."',
												picture_title_tag	= '',
												cost_investment		= '".$monto_inversion."',
												click_max			= '".intval($monto_inversion/$costo[cost])."',
												click_current		= 0,
												status				= ".($_SESSION['ws-tags']['ws-user'][super_user]=='0' ? '2' : '1'));

										//si no es SU, entonces tiene que pagar
										//( en el INSERT se le asigna el estado a la publicidad, míralo, si tu  )
										if( $_SESSION['ws-tags']['ws-user'][super_user]=='0' ) {

											$id_publicity = md5( mysql_insert_id() );

											adPreference($_POST[publi_title]);

											// include ('../../views/pay.view.php');
											@header('Location: ../../views/pay.view.php?payAcc=publicity&uid='.$id_publicity);
										} else {
												redirect("../../publicity");
										}
									break;//END - payment = $ case "1":
								}
						//END - SWITCH - payment methods



							}//if save == 1
						}

					 break;//END - creating a new publicity - default:
			}// switch
	}//if ($_GET[ajax]=='1' && $_GET[op]=='1')

}//quitar_inyect
	 //echo $title." >> ".$msj
?>

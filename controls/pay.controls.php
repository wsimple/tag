<?php
	session_start();
	require_once ("../includes/functions.php");
	require_once ("../includes/config.php");
	require_once ("../class/wconecta.class.php");
	require_once ("../includes/languages.config.php");

	//formato del custom
	//tabla|criterio_con_que_se_va_comparar_en_el_update
	//
	//Acciones para $custom[0]
	//$custom[0] == 0, 'pago orden pendiente en STORE'
	//$custom[0] == 1, 'pago de puntos de usuario'
	//$custom[0] == 2, 'pago de publicidad en cuentas business'
	//$custom[0] == 3, 'pago de patrocinio en tags personales'
	//$custom[0] == 4, 'pago de business cards adicionales'
	//$custom[0] == 5, 'pago de cuenta business'

	//email princiapl en payPal
	// $acount = 'ddb93828fa727a4c1f26fdf9c92f49d3';
	$acount = md5('elijose.c-facilitator@gmail.com');

	//datos
	$req = 'cmd=_notify-validate';
	if( isset($_POST) ){
		foreach ($_POST as $key => $value){
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
	}
	//description
	// Nuevas Headers
	$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Host: www.paypal.com\r\n";
	$header .= "Connection: close\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

	// $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 

	$num = '';					//Enumera los productos pagados
	$paid_product = array();	//Arreglo de productos pagados
	$monto_total = 0;			//Monto total cancelado en paypal

	//Repsuesta de articulo(s) pagados en paypal
	if ( $_POST['txn_type'] == 'cart' ) {
		$count=trim($_POST['num_cart_items']);
		
		for ($num=1; $num < $count; $num++) { 
			$paid_product[trim($_POST['item_number'.$num])] = array(
				'item_name'=>trim($_POST['item_name'.$num]),
				'item_number'=>trim($_POST['item_number'.$num]),
				'product_amount'=>trim($_POST['mc_gross_'.$num]),
				'quantity'=>trim($_POST['quantity'.$num])
			);

			$monto_total += $paid_product[$num]['product_amount']*$paid_product[$num]['quantity']; //suma monto de cada producto...
		}
	}else{
		$paid_product[0] = array(
			'item_name'=>trim($_POST['item_name']),
			'item_number'=>trim($_POST['item_number']),
			'product_amount'=>trim($_POST['mc_gross'])
		);

		$monto_total += $paid_product[0]['product_amount'];
	}
	// $monto_total = number_format( $monto_total, 3, '.', '' );


	//Respuesta de paypal
	$payment_status   = trim($_POST['payment_status']);
	$payment_currency = trim($_POST['mc_currency']);
	$txn_id           = trim($_POST['txn_id']);
	$txn_type         = trim($_POST['txn_type']);
	$receiver_email   = trim($_POST['receiver_email']);
	$payer_email      = trim($_POST['payer_email']);
	$custom           = explode('|', trim($_POST['custom']));


	$todo= $payment_status.'*/*'.$payment_currency.'*/*'.$txn_id.'*/*'.$txn_type.'*/*'.$receiver_email.'*/*'.$payer_email.'*/*'.implode('*/*',$custom);
	CON::update('users','description=?','id=1',array($todo));

	// variables generales para log en tabla payPal
	$id_user = '';
	$id_publicity = 0;
	$description = '';
	$txn = $txn_id;

  	if ($acount == md5($receiver_email)){
		//validamos lo que viene de paypal
		if (!$fp){
		 	$db = $GLOBALS['cn']->query("INSERT INTO paypal SET
											id_user      = '0',
											id_publicity = '0',
											amount       = '0',
											description  = 'No file Open: $payment_status ($res ".generaGet().")'
										");
		}else{
			fputs ($fp, $header . $req);
			while (!feof($fp)){
				
				$res = fgets ($fp, 1024);
				$res = trim($res);
				if (strcmp($res, "VERIFIED") == 0) {
					//Verificamos que el pago este completo para luego realizar acciones...
					$status = 0;
					if (strtolower($payment_status)=='completed'){
						$status=1; // Estatus Pagado
						switch ($custom[0]){
							
							case '0':	//Verifica compra en la store y paga a los vendedores
								require_once 'paypal.api.php'; //API de Paypal

	//							$_dato = $item_name."|".$item_number."|".$payment_status."|".$payment_amount."|".$payment_currency."|".$txn_id."|".$receiver_email."|".$payer_email;


	// 							$db = $GLOBALS['cn']->query("INSERT INTO paypal SET
	//															id_user      = ".$custom[1].",
	//															id_publicity = '0',
	//															amount       = '".$payment_amount."',
	//															description  = '".$_dato."'
	//														");

								$nvpstr;
								$emailSubject =urlencode(STORE_PURCHASETITLENEW);  //Asunto del correo al vendedor
								$receiverType = urlencode( $receiver_email ); //Correo tagbum o del comprador
								$currency=urlencode('USD'); // USD
								
								$code=md5($custom[1].'_'.$custom[2].'_'.$custom[1]);
								
								$car = createSessionCar($custom[1],$code,'','',$custom[3],true);//Carrito de compra en proceso de la BD
									
								$j=0;
								$order_id=$car['order']['order'];
								$buy_id=$car['order']['comprador'];
								$code_id=$car['order']['comprador_code'];
							    foreach ($car as $product){
									if (!$product['order']){
										if ($product['formPayment']==1){
												//Log de compras
												$plural = ($product['cant']<2) ? 'one' : $product['cant'] ;
												$_dato = 'User '.$custom[1].' buy: ('.$product['name'];
												$_dato .= ') '.$plural.' to '.$product['seller'].' for: $'.$product['sale_points'];

												$db = $GLOBALS['cn']->query("INSERT INTO paypal SET
																		id_user      = ".$custom[1].",
																		id_publicity = '0',
																		amount       = '".$payment_amount."',
																		description  = '".$_dato."'
																	");
												//Fin log de compras

												$receiverEmail = urlencode($product['paypal']);
												//verificacion si es un mismo vendedor
												$countSameSeller = count( array_keys($car) );

												$amount = urlencode($product['sale_points']*$product['cant']);
												$uniqueID = urlencode($product['id']);
												$note = urlencode('');
												$nvpstr.="&L_EMAIL$j=$receiverEmail&L_Amt$j=$amount&L_UNIQUEID$j=$uniqueID&L_NOTE$j=$note";
												$j+=1;
										}
									}
							    }

							    //Contiene todas las variables que se enviaran a paypal, asi como las configuraciones y metodos de pago
							    $nvpstr.="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency" ;


							    //Llamada a la API de pago de paypal
							    $resArray=hash_call("MassPay",$nvpstr);

							    $ack = strtoupper($resArray["ACK"]); //Respuesta de servidor paypal (masspay)

								if($ack!="SUCCESS"){
									//Si le pago el sistema a todos los vendedores podemos hacer algo aqui...
							    }
								$action = 4;
								require_once 'store/shoppingCart.json.php'; //control del carrito checkout
							break;

							case 1: //Si esta comprando puntos
								//query
								$arrayPoints = $GLOBALS['cn']->queryRow("
									SELECT 
										id,
										points_bought,
										id_user,
										cost_investment
									FROM users_points_purchase
									WHERE md5(id) = '".$custom[2]."' 
									LIMIT 1
								");

								//Comprobamos precio a pagar con pago realizado
								// if( $monto_total == number_format( $arrayPoints['cost_investment'], 3, '.', '' ) ){
									//users
									$GLOBALS['cn']->query("
										UPDATE users SET 
											current_points = current_points +".$arrayPoints['points_bought'].", 
											accumulated_points = accumulated_points+".$arrayPoints['points_bought']."
										WHERE id = '".$arrayPoints['id_user']."' 
										LIMIT 1
									");
									//users_buy_points
									$GLOBALS['cn']->query("
										UPDATE users_points_purchase SET 
											status = '1'
										WHERE id = '".$arrayPoints['id']."' 
										LIMIT 1
									");
								// }

								//Resultado para insercion en paypal
								$id_user = $arrayPoints['id_user'];
								$id_publicity = $arrayPoints['id'];
								$description = PAY_USER_POINTS.'id: '.$arrayPoints['id'];
							break;

							case 2: //Publicidad
								//datos de la publicidad
								$array = $GLOBALS['cn']->queryRow("SELECT id_user,
																		 cost_investment,
																		 id
																  FROM users_publicity
																  WHERE md5(id) = '".$custom[1]."'");

								//Comprobamos precio a pagar con pago realizado
								if($monto_total == number_format( $array['cost_investment'], 3, '.', '' )){
									$query = $GLOBALS['cn']->query("UPDATE users_publicity SET status = 5 WHERE id = '".$array['id']."'");
								}

								//Resultado para insercion en paypal
								$id_user = $array['id_user'];
								$id_publicity = $array['id'];
								$description = PAY_PUBLICITY;
							break; //user_publicity

							case 3: //personal tag

								// datos del usuario
								$user = $GLOBALS['cn']->queryRow("SELECT id FROM users WHERE md5(id) = '".$custom[1]."' LIMIT 1");

								//configuracion del sistema
								$array = $GLOBALS['cn']->queryRow("SELECT * FROM `config_system` LIMIT 1");

								// if( $monto_total == number_format( $array['cost_individual_personal_tag_old'], 2, '.', '' ) ){
								if( true ){
									$query = $GLOBALS['cn']->query("UPDATE users SET pay_personal_tag = '1' WHERE id = '".$custom[1]."'");
								}

								//Resultado para insercion en paypal
								$id_user = $user['id'];
								$description = PAY_PERSONAL_TAG;
							break;

							case 4: //Compra nuevas business cards
								//datos del usuario
								$user = $GLOBALS['cn']->queryRow("SELECT id, 
								                                       email,
																	   home_phone,
																	   mobile_phone,
																	   work_phone 
																   FROM users 
																   WHERE md5(id) = '".$custom[1]."'");

								//configuracion del sistema
								$array = $GLOBALS['cn']->queryRow("SELECT * FROM config_system");

								//Comprobamos precio a pagar con pago realizado
								if( $monto_total == number_format( $array['cost_company_bc'], 3, '.', '' ) ){
									//se incrementa la cantidad de BC que el usuario tiene
									$query = $GLOBALS['cn']->query("UPDATE users 
																	SET pay_bussines_card=pay_bussines_card+1
																	WHERE id = '".$user['id']."'");
									
									//se inserta una business card simple
									$insert = $GLOBALS['cn']->query("INSERT INTO business_card SET 
																	  id_user      = '".$user['id']."',
	                                                                  email		   = '".$user['email']."',
	                                                                  company	   = 'Social Media Marketing',
	                                                                  middle_text  = 'www.tagbum.com',
	                                                                  type		   = '1',
																	  home_phone   = '".$user['home_phone']."',
																	  work_phone   = '".$user['work_phone']."',
																	  mobile_phone = '".$user['mobile_phone']."'
								                                    ");
								}

								//Resultado para insercion en paypal
								$id_user = $user['id'];
								$description = PAY_BUSINESS_CARDS;
							break;
							case 5: //Pago cuenta business

								//configuracion del sistema
								$plans = $GLOBALS['cn']->query("SELECT price, DATE_ADD(NOW(), INTERVAL days DAY) AS date FROM subscription_plans WHERE id = ".$custom[2]);
								$plan = mysql_fetch_assoc($plans);

								//tipo e id del usuario
								$user = $GLOBALS['cn']->query("SELECT id, type FROM users WHERE md5(id) = '".$custom[1]."' LIMIT 1");
								$user = mysql_fetch_assoc($user);

								//Comprobamos precio a pagar con pago realizado
								// if($monto_total == number_format( $plan['price'], 3, '.', '' )){
								if($user['type']==1 || $user['type']==2){ //Pago cuenta business
									//Cambio status del user a activo
									$query = $GLOBALS['cn']->query("UPDATE users SET type=1, status = 1 WHERE id = '".$user['id']."' LIMIT 1");
									
									$query = $GLOBALS['cn']->query("INSERT INTO users_plan_purchase SET id_user ='".$user['id']."', id_plan = ".$custom[2].", init_date = NOW(), end_date='".$plan['date']."';");
								}
								
								//Resultado para insercion en paypal
								$id_user = $user['id'];
								$description = PAY_ACCOUNT_BUSINESS;
							break; //user
									
						}//switch custom
					}//If Pago completo

					//insertamos la transaccion del pago
					$GLOBALS['cn']->query("INSERT INTO paypal SET id_user   = '".$id_user."',
											 id_publicity = ".$id_publicity.",
											 amount       = '".$monto_total."',
											 description  = '".$description.": $payment_status',
											 txn_id		  = '".$txn_id."',
											 status       = '".$status."'");

				}else if (strcmp ($res, "INVALID") == 0) {
					$db = $GLOBALS['cn']->query("INSERT INTO paypal SET id_user     = '0',
												   id_publicity = '0',
												   amount       = '0',
												   description  = 'INVALID: $payment_status ($res ".generaGet().")'
											 ");
				}
				
			}//while !feof($fp)

			fclose ($fp);
		}
	}?>
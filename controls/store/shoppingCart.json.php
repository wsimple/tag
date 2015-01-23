<?php
if (!$car){
	include '../header.json.php';
}
include ('../../class/class.phpmailer.php');

	$jsonResponse = array();

	if (quitar_inyect()){
		$points='';$money='';
		$datosCar = array();

		$products = $GLOBALS['cn']->query('SELECT	p.id AS id,
													p.id_user AS seller,
													u.paypal AS paypal_account,
													p.id_category AS id_category,
													p.id_sub_category AS id_sub_category,
													p.description AS description,
													(SELECT name FROM store_category WHERE id=p.id_category) AS category,
													(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
													u.email AS email_seller,
													p.name AS name,
													p.sale_points AS sale_points,
													p.photo AS photo,
													p.place AS place,
													p.stock AS stock,
													p.id_status AS id_status,
													p.formPayment AS formPayment
											FROM store_products p
											INNER JOIN users AS u ON p.id_user=u.id
											WHERE md5(p.id) = "'.$_GET['id'].'"');
		$product = mysql_fetch_assoc($products);
		$producto = $product['id'];

		$action = (isset($_GET['action'])) ? $_GET['action'] : $action ;
		switch ($action){
		case 1:
			#Añadir productos al carrito
			if($product['seller']==$_SESSION['ws-tags']['ws-user'][id]){ $jsonResponse['datosCar2']['add'] = 'no'; }
            else{
				if ($product['id_status']!='2' && $product['stock']>'0'){
					$jsonResponse['datosCar2']['add'] = 'si';
					$idOrder=$GLOBALS['cn']->query("SELECT id FROM store_orders WHERE id_status = '1' AND id_user = '".$myId."'");
					$numIdOrder=mysql_num_rows($idOrder);
					$idOrder=  mysql_fetch_assoc($idOrder);
					$idOrder=$idOrder['id'];
					if (!existe('store_orders_detail', 'id', "WHERE id_status = '11' AND id_order='".$idOrder."' AND id_product='".$producto."'")){
						$_SESSION['car'][$producto]['id'] = $product['id'];
						$_SESSION['car'][$producto]['seller'] = $product['seller'];
						$_SESSION['car'][$producto]['id_category'] = $product['id_category'];
						$_SESSION['car'][$producto]['id_sub_category'] = $product['id_sub_category'];
						$_SESSION['car'][$producto]['category'] = lan($product['category']);
						$_SESSION['car'][$producto]['subCategory'] = lan($product['subCategory']);
						$_SESSION['car'][$producto]['name'] = formatoCadena($product['name']);
						$_SESSION['car'][$producto]['sale_points'] = $product['sale_points'];
						$_SESSION['car'][$producto]['photo'] = $product['photo'];
						$_SESSION['car'][$producto]['place'] = $product['place'];
						$_SESSION['car'][$producto]['description'] = $product['description'];
						$_SESSION['car'][$producto]['email_seller'] = $product['email_seller'];
						$_SESSION['car'][$producto]['formPayment'] = $product['formPayment'];
						$_SESSION['car'][$producto]['cant'] = '1';
						$_SESSION['car'][$producto]['paypal'] = $product['paypal_account'];

						//Para saber si tiene que pagar productos en paypal
						if (PAYPAL_PAYMENTS && $product['formPayment']==1) $_SESSION['havePaypalPayment'] = true;

						$price = 0;
						$nproduct = 0;
						if ($numIdOrder==0){
							$GLOBALS['cn']->query("INSERT INTO store_orders SET id_status = '1', id_user = '".$myId."'");
							$idOrder=  mysql_insert_id();
							$_SESSION['car']['order']['order']=$idOrder;
							$_SESSION['car']['order']['comprador']=$myId;
							$_SESSION['car']['order']['comprador_code']=$_SESSION['ws-tags']['ws-user']['code'];
							$tiempo=getTimeShoppingCarActive();
							$minuto=$tiempo>=60?intval($tiempo%60):$tiempo;
							$hora=$tiempo>=60?intval($tiempo/60):'';
							$dias=$hora>=24?intval($hora/24):'';
							$tiempo=$dias!=''?$dias.' '.DAY.($dias>1?'s':''):'';
							$tiempo.=' '.($hora!='' && $hora!=0)?$hora.' '.HOUR.($hora>1?'s':''):'';
							$tiempo.=' '.($minuto!='' && $minuto!= 0?($minuto.' '.MINUTE.($minuto>1?'s':'')):'');
							$jsonResponse['datosCar2']['order']=STORE_TIME_FROM_NEW.' '.$tiempo.' '.STORE_TIME_END_CAR;
						}
						$GLOBALS['cn']->query("INSERT INTO store_orders_detail SET id_order = '".$idOrder."',
													  id_product = '".$product['id']."',
													  id_user = '".$product['seller']."',
													  cant = 1,
													  price = '".$product['sale_points']."',
													  id_status=11,
													  formPayment='".$product['formPayment']."'
						");
						if ($product['id_category']!='1'){
							$numStock=campo('store_products','id',$producto,'stock');
							if (($numStock-1)==0){ $jsonResponse['datosCar2']['msg']='no-product'; }
						}
                        $jsonResponse['datosCar2']['new']='si';
                        $jsonResponse['datosCar2']['count']=  numRecord('store_orders_detail','WHERE id_order="'.$idOrder.'" AND id_status="11"');
					}else{
						if ($product['id_category']=='1'){ $jsonResponse['datosCar2']['msg']='backg'; $jsonResponse['datosCar2']['add'] = 'no';}
                        else{
                            $jsonResponse['datosCar2']['new']='no';
							$_SESSION['car'][$producto]['cant'] = campo('store_orders_detail', 'id_order', $idOrder, 'cant','AND id_product="'.$producto.'"')+1;
							if ($product['stock']>=$_SESSION['car'][$producto]['cant']){
								$GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$_SESSION['car'][$producto]['cant'].'" 
																	WHERE id_product="'.$producto.'" 
																	AND id_order="'.$idOrder.'"
																	AND id_status=11');
								$numStock=campo('store_products','id',$producto,'stock');
								if (($_SESSION['car'][$producto]['cant']-$numStock)==0){ $jsonResponse['datosCar2']['msg']='no-product'; }
							}else{ $jsonResponse['datosCar2']['msg']='no-stock'; $jsonResponse['datosCar2']['add'] = 'no'; }
						}
					}
				}else{ $jsonResponse['datosCar2']['msg']='no-disponible'; $jsonResponse['datosCar2']['add'] = 'no'; }
			}
		break;

		case 2:
            if (isset($_GET['all'])){
                $where='';
                if (isset($_GET['idOrder'])){ $idOrder=$_GET['idOrder']; }
                else{ 
                    if (!isset($_SESSION['car'])) createSessionCar (); 
                    $idOrder=md5($_SESSION['car']['order']['order']);
                }
                switch ($_GET['mod']){
                    case 'pay': //orden pendiente por pagar //orden que no ha sido cancelada en paypal
                        $where='md5(id_order)="'.$idOrder.'" AND id_status="11"'; $statusOrder='11';
                        break;
                    case 'wish': //lista de deseos 
                        $where='md5(id_order)="'.$idOrder.'" AND id_status="5"'; $statusOrder='5';
                        unset($_SESSION['store']['wish']);
                        break;
                    case 'wish-pend': //productos de la lista de deseos que no poseen stock o han sido eliminados
                        $sqlIN=''; $sql="SELECT p.id 
                                        FROM store_products p
                                        JOIN  store_orders_detail od ON p.id=od.id_product
                                        WHERE (p.stock='0' OR p.id_status='2')
                                        AND md5(od.id_order)='".$idOrder."' AND od.id_status='5'";
                        $idProds=$GLOBALS['cn']->query($sql);
                        while ($result=mysql_fetch_assoc($idProds)){
                            $sqlIN.=$sqlIN==''?$result['id']:','.$result['id'];
                        }
                        $where='md5(id_order)="'.$idOrder.'" AND id_product IN ('.$sqlIN.');'; $statusOrder='5';
                        break;
                    case 'car-pend': //productos del carrito de compras que no poseen stock o han sido eliminados
                        $sqlIN=''; $sql="SELECT p.id 
                                        FROM store_products p
                                        JOIN  store_orders_detail od ON p.id=od.id_product
                                        WHERE (p.stock='0' OR p.id_status='2')
                                        AND md5(od.id_order)='".$idOrder."' AND od.id_status='11'";
                        $idProds=$GLOBALS['cn']->query($sql);
                        while ($result=mysql_fetch_assoc($idProds)){
                            $sqlIN.=$sqlIN==''?$result['id']:','.$result['id'];
                        }
                        $where='md5(id_order)="'.$idOrder.'" AND id_product IN ('.$sqlIN.');'; $statusOrder='1';
                        break;
                    default : //carrito de compras
                        $where='md5(id_order)="'.$idOrder.'" AND id_status="11";'; $statusOrder='1';
                        unset($_SESSION['store']['car']);
                        unset($_SESSION['havePaypalPayment']);
                        unset($_SESSION['car']);
                }
				if ($_GET['mod'] == 'pay'){
                    $result=$GLOBALS['cn']->query('SELECT 
                                                        d.cant,
                                                        d.id_user,
                                                        d.id_product,
                                                        p.id_category,
                                                        p.stock
                                                    FROM store_orders_detail d 
                                                    JOIN store_products p ON p.id=d.id_product
                                                    WHERE md5(id_order)="'.$idOrder.'"');
                    while ($row=  mysql_fetch_assoc($result)){
                        if ($row['id_category']!='1'){							
                            $GLOBALS['cn']->query('	UPDATE store_products SET 
                                                                '.($row['stock']=='0'?'id_status="1",':'').'
                                                                stock='.(intval($row['cant'])+intval($row['stock'])).'
                                                        WHERE id="'.$row['id_product'].'" 
                                                        AND id_user="'.$row['id_user'].'";');
                        }
                    }
                    //eliminamos las notificaciones de orden pendiente por pagar
                    $GLOBALS['cn']->query('DELETE FROM `users_notifications` WHERE id_type="17" AND id_user="427" AND id_friend="'.$myId.'" AND md5(id_source)="'.$idOrder.'"');
                }
                $GLOBALS['cn']->query('UPDATE store_orders_detail SET id_status="2" WHERE '.$where); //eliminamos los productos de la orden
                switch ($_GET['mod']){ //validamos si la orden fue borrada por completo o no
                    case 'wish-pend': case 'car-pend':
                        $num= numRecord('store_orders_detail', "WHERE md5(id_order)='".$idOrder."' AND id_status='".(($statusOrder=='1')?'11':$statusOrder)."'");
                        if ($num==0){
                            $GLOBALS['cn']->query('UPDATE `store_orders` SET id_status="2" WHERE md5(id)="'.$idOrder.'" AND id_status="'.$statusOrder.'" AND id_user="'.$myId.'"');
                            if ($_GET['mod']=='car-pend'){
                                unset($_SESSION['store']['car']);
                                unset($_SESSION['havePaypalPayment']);
                                unset($_SESSION['car']);
                            }else{ unset($_SESSION['store']['wish']); }
                            $jsonResponse['del'] = 'all';
                        }else{ 
                            $jsonResponse['del'] = 'no-all'; 
                            $jsonResponse['numR'] = $num;
                            $code;
                            if ($sqlIN!=''){
                                $productos=  explode(',', $sqlIN);
                                foreach ($productos as $id){  $code[]=md5(md5($id)); }
                            }
                            $jsonResponse['delete'] = $code;
                        }
                        break;
                    case 'pay': case 'wish': default :
                        $GLOBALS['cn']->query('UPDATE `store_orders` SET id_status="2" WHERE md5(id)="'.$idOrder.'" AND id_status="'.$statusOrder.'" AND id_user="'.$myId.'"');
                        $jsonResponse['del'] = 'all';
                }
 			}else{
				if ($_GET['mod']=='wish'){  
                    if (!isset($_SESSION['store']['wish'])){
                        $_SESSION['store']['wish']=campo('store_orders','id_status','5','id',' AND id_user="'.$myId.'"');
                    }
                    $statusOrder='5';$idOrder=$_SESSION['store']['wish'];
                }else{
                    $idOrder=$_SESSION['car']['order']['order'];
                    $statusOrder='11';
                }
                $GLOBALS['cn']->query('UPDATE store_orders_detail SET id_status="2" WHERE id_order="'.$idOrder.'" AND id_status="'.$statusOrder.'" AND id_product="'.$producto.'"');
				$num= numRecord('store_orders_detail', "WHERE id_order='".$idOrder."' AND id_status='".$statusOrder."'");
                if ($num==0){
                    $GLOBALS['cn']->query('UPDATE store_orders SET id_status="2" WHERE id="'.$idOrder.'" AND id_status="'.($statusOrder=='11'?'1':$statusOrder).'"');
                    if ($_GET['mod']=='wish'){ unset($_SESSION['store']['wish']);}
                    else{
                        unset($_SESSION['car']);
                        unset($_SESSION['store']['car']);
                        unset($_SESSION['havePaypalPayment']);
                    }
                    $jsonResponse['del'] = 'all';
                }else{
                    if ($statusOrder=='11'){
                        $num2= numRecord('store_orders_detail', "WHERE id_order='".$idOrder."' AND id_status='11' AND formPayment='1'");    
                        if ($num2==0) unset($_SESSION['havePaypalPayment']);
                    }
                    $jsonResponse['del'] = '1'; 
                    $jsonResponse['numR'] = $num; 
                    $jsonResponse['delete'] = $code=md5(md5($producto)); 
                    unset($_SESSION['car'][$producto]);
                }
			}
            //$jsonResponse['del'].=$where;
		break;
		case 3:
			 $products = $GLOBALS['cn']->query('SELECT name FROM store_products WHERE md5(id) = "'.$_GET['id'].'"');
			 $product = mysql_fetch_assoc($products);
			 $datosCar[] =$product['name'];
			 $price = 0;
			 $nproduct = 0;

		break;
		//checkout
		case 4:
            
			$noValida=false; //el nombre de no valida es porque si viene de paypal no se hace esta validacion
			//verificarmos si la orden viene de paypal
			if (isset($custom)){
				$email=$custom[2];
				$ordeId=$custom[3];
				$comprador=$custom[1];
				if (strtolower($payment_status)=='completed') $bandDollar='true';
				else $bandDollar=false;
			}else{
				$ordeId='';$comprador='';
				$email=$_SESSION['ws-tags']['ws-user']['email'];
				$car=createSessionCar();
				$bandDollar=false;
				foreach ($car as $carrito){
					if ($carrito['id_category']!='1'){
						$result=campo('store_products','id',$carrito['id'],'stock','AND id_user="'.$carrito['seller'].'"');
						$num=(intval($result)-intval($carrito['cant']));
						if ($num<0){
							$activo=campo('store_products','id',$carrito['id'],'id_status','AND id_user="'.$carrito['seller'].'"');
							if($activo=='2'){
								$GLOBALS['cn']->query('DELETE FROM store_orders_detail WHERE id_order="'.$_SESSION['car']['order']['order'].'" AND id_product="'.$carrito['id'].'" AND id_user="'.$carrito['seller'].'"');
								unset($_SESSION['car'][$carrito['id']]);
								break;
							}elseif ($activo=='1') {
								$GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$result.'" 
														WHERE id_product="'.$carrito['id'].'" 
														AND id_order="'.$_SESSION['car']['order']['order'].'"
														AND id_status=11');
							}
							$noValida=true;
						}
                        if ($mobile && $carrito['id_category']!=1 && !isset($_SESSION['ws-tags']['ws-user']['yaShipp']) && !isset($_GET['ned'])){ $jsonResponse['productMobile']=1; }
                        if ($mobile && $carrito['formPayment']==1){ $jsonResponse['formPaymentD']=1; }
					}
				}
                if ($mobile && $jsonResponse['productMobile']){ die(jsonp($jsonResponse)); }
                else if ($mobile && $jsonResponse['formPaymentD']){ die(jsonp($jsonResponse)); }
                unset($_SESSION['ws-tags']['ws-user']['yaShipp']);
			}
			if (!$noValida):
				$numIt=createSessionCar($comprador,'','count','',$ordeId);
				if (($numIt=='0'||$numIt=='') && $ordeId==''){ $datosCar='noCart'; }
                else{
					if ($numIt=='0'||$numIt=='') $orderDelete=true;
					else $orderDelete=false;
					$id_comprador = $car['order']['comprador'];
					$code_comprador = $car['order']['comprador_code'];

					$totalprice = 0; //calcular la cantidad de puntos acumulados de la orden
					foreach ($car as $carrito){
						if (($carrito['formPayment']!=1)&&(!$carrito['order'])){ $totalprice = ($carrito['sale_points']*$carrito['cant']) + $totalprice; }
					}
					//consultar los puntos del usuario
					$pointsUser = $GLOBALS['cn']->query("	SELECT	a.accumulated_points AS accumulated_points,
																	a.current_points AS current_points
															FROM users a
															WHERE id = '".$id_comprador."'");
					$pointsUsers = mysql_fetch_assoc($pointsUser);
					$bandPoints=false;
					if($pointsUsers['current_points']>$totalprice) $bandPoints=true;
//					$GLOBALS['cn']->query("UPDATE users SET description = 'entrando 1-".$payment_status." 2-".(string)$bandDollar." 3-".(string)$bandPoints." 4-".$ordeId." 5-".$comprador."' WHERE id ='".($id_comprador)."'");
					if($bandDollar || $bandPoints){
						$id_order = $car['order']['order'];
						$GLOBALS['cn']->query("UPDATE store_orders SET id_status = '12' WHERE id_user = '".$id_comprador."' AND id='".$id_order."'");
						$product=array();$noProduct=false;
//						$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 0' WHERE id ='".$id_comprador."'");
						foreach ($car as $carrito){
							if (!$carrito['order']){
								switch ($carrito['formPayment']){
									case '0': //productos cancelados con puntos
										if ($bandPoints){
//											$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 1' WHERE id ='".($id_comprador)."'");
											//acumular los costo del producto por la cantidad
											$productCost=$carrito['sale_points']*$carrito['cant'];

											if ($carrito['id_category']==1){
//												$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 2' WHERE id ='".($id_comprador)."'");
					//							if ($carrito['place']=='1'){
					//
					//								$photoWpanel = $GLOBALS['cn']->query('SELECT a.picture AS picture FROM store_products_picture a WHERE a.id_product = "'.$carrito['id'].'" ORDER BY a.order');
					//
					//								while($photoWpanels = mysql_fetch_assoc($photoWpanel)){
					//									$original_file = $photoWpanels['picture'];
					//									$photoUpload = explode('/',$photoWpanels['picture']);
					//									$photoUploadMd5 = explode('.',$photoUpload[2]);
					//									$destination_file = 'templates/'.$_SESSION['ws-tags']['ws-user'][code].'/'.md5($photoUploadMd5[0]).'.'.$photoUploadMd5[1];
					//
					//									//$nproductUp = $original_file.'----'.$destination_file;
					//									$nproductUp =  FTPcopy($original_file,$destination_file);
					//								}
												//}else{
													$original_file = $carrito['photo'];
													$photoUpload = explode('/',$carrito['photo']);
													$photoUploadMd5 = explode('.',$photoUpload[2]);
													$destination_file = 'templates/'.$code_comprador.'/'.md5($photoUploadMd5[0]).'.'.$photoUploadMd5[1];
													//$nproductUp = $original_file.'----'.$destination_file;
													$nproductUp =  FTPcopy($original_file,$destination_file);
												//}
											}
											//actualizo el estado de los productos por puntos como productos pagados
//											$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 3-".$id_order."-".$carrito['id']."' WHERE id ='".($id_comprador)."'");
											$GLOBALS['cn']->query("	UPDATE store_orders_detail 
																	SET id_status=12 
																	WHERE id_order='".$id_order."'
																	AND id_product='".$carrito['id']."'");

											//incrementar los puntos del usuario por su venta
											$GLOBALS['cn']->query("	UPDATE users 
																	SET		accumulated_points = accumulated_points + '".$productCost."',
																			current_points = current_points + '".$productCost."'
																	WHERE id = '".$carrito['seller']."'
																");
											incHitsTag($carrito['id'],2,'store_products');
											if ($carrito['id_category']!='1'){
												if (!$bandDollar){
													$result=campo('store_products','id',$carrito['id'],'stock','AND id_user="'.$carrito['seller'].'"');
													$num=(intval($result)-intval($carrito['cant']));
													if ($num>=0){
														$GLOBALS['cn']->query('	UPDATE store_products SET 
																					'.($num=='0'?'id_status="2",':'').'
																						stock='.$num.'
																				WHERE id="'.$carrito['id'].'" 
																				AND id_user="'.$carrito['seller'].'";');
													}
												}else{
													if ($orderDelete){
														$result=campo('store_products','id',$carrito['id'],'stock','AND id_user="'.$carrito['seller'].'"');
														$num=(intval($result)-intval($carrito['cant']));
														if ($num>=0){
															$GLOBALS['cn']->query('	UPDATE store_products SET 
																						'.($num=='0'?'id_status="2",':'').'
																							stock='.$num.'
																					WHERE id="'.$carrito['id'].'" 
																					AND id_user="'.$carrito['seller'].'";');
														}else{
															$GLOBALS['cn']->query('	UPDATE store_products SET 
																						id_status="2",
																							stock="0"
																					WHERE id="'.$carrito['id'].'" 
																					AND id_user="'.$carrito['seller'].'";');
															$GLOBALS['cn']->query("	UPDATE store_orders_detail 
																	SET cant=".$result."
																	WHERE id_order='".$id_order."'
																	AND id_product='".$carrito['id']."'");
															$car[$carrito['id']]['fail']=true;
														}
													}
												}
											}
										}elseif (!$bandPoints){
//											$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 4' WHERE id ='".($id_comprador)."'");
											//$GLOBALS['cn']->query('DELETE FROM store_orders_detail WHERE id_product="'.$carrito['id'].'" AND id_order="'.$id_order.'"');
											if ($bandDollar && !$orderDelete){
												$sta=  campo('store_products', 'id', $carrito['id'], 'id_status');
												$GLOBALS['cn']->query('	UPDATE store_products SET 
																				'.($sta=='2'?'id_status="1",':'').'
																					stock=stock+'.$carrito['cant'].'
																			WHERE id="'.$carrito['id'].'" 
																			AND id_user="'.$carrito['seller'].'";');
											}
											unset($car[$carrito['id']]);
											break;
										}
										break;
									case '1': //productos cancelados con dollars
										if ($bandDollar){
//											$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 5' WHERE id ='".($id_comprador)."'");
											//actualizo el estado de los productos por dolar como productos pagados
											$GLOBALS['cn']->query("	UPDATE store_orders_detail 
																	SET id_status=12 
																	WHERE id_order='".$id_order."'
																	AND id_product='".$carrito['id']."'");
											incHitsTag($carrito['id'],2,'store_products');
											if ($carrito['id_category']!='1'){
												if ($orderDelete){
													$result=campo('store_products','id',$carrito['id'],'stock','AND id_user="'.$carrito['seller'].'"');
													$num=(intval($result)-intval($carrito['cant']));
													if ($num<0){
														$GLOBALS['cn']->query('	UPDATE store_products SET 
																					id_status="2",
																						stock="0"
																				WHERE id="'.$carrito['id'].'" 
																				AND id_user="'.$carrito['seller'].'";');
														$GLOBALS['cn']->query("	UPDATE store_orders_detail 
																SET cant=".$result."
																WHERE id_order='".$id_order."'
																AND id_product='".$carrito['id']."'");
														$car[$carrito['id']]['fail']=true;
													}													
												}
											}
										}elseif (!$bandDollar){
//											$GLOBALS['cn']->query("UPDATE users SET description = 'aqui estoy 6' WHERE id ='".($id_comprador)."'");
											//$GLOBALS['cn']->query('DELETE FROM store_orders_detail WHERE id_product="'.$carrito['id'].'" AND id_order="'.$id_order.'"');
											if (isset($custom) && !$orderDelete){
												$sta=  campo('store_products', 'id', $carrito['id'], 'id_status');
												$GLOBALS['cn']->query('	UPDATE store_products SET 
																				'.($sta=='2'?'id_status="1",':'').'
																					stock=stock+'.$carrito['cant'].'
																			WHERE id="'.$carrito['id'].'" 
																			AND id_user="'.$carrito['seller'].'";');
											}
											unset($car[$carrito['id']]);
											break;
										}
										break;
								}								
							}
						}
						if ($bandPoints){
							//decrementar los puntos del usuario por su compra
							$GLOBALS['cn']->query("	UPDATE users 
													SET		accumulated_points = accumulated_points - '".$totalprice."',
															current_points = current_points - '".$totalprice."'
													WHERE id = '".$id_comprador."'
												");
						}
						$datosCar = 'checked';
						$price = $totalprice;
						$nproduct = $nproductUp;
						$nOrden = $id_order;
						if ($payment_status) $GLOBALS['cn']->query('DELETE FROM `users_notifications` WHERE id_type="17" AND id_user="427" AND id_friend="'.$car['order']['comprador'].'" AND id_source="'.$car['order']['order'].'"');
						$wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com" OR email="wpanel@seemytag.com";');
						if (!$wid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com" OR email="wpanel@seemytag.com";');
						notifications($car['order']['comprador'],$car['order']['order'],16,'',$wid,$car);
						unset($_SESSION['car']);
					}else{
						 $datosCar = 'noCredit';
						 $price = 0;
						 $nproduct = 0;
						 $nOrden = 0;
					}
				}
			else:
				$datosCar='order-alter';
			endif;
		break;
		case 6: //completando los datos necesarios del usario para el shippin
            foreach ($_POST as $nameVar => $valueVar) ${$nameVar} = "$valueVar";
            // if (!is_array($_POST['city'])){
            //     $cities=$GLOBALS['cn']->query("SELECT c.id AS idCities
        	   //     						FROM  cities c WHERE name LIKE '".$_POST['city']."' LIMIT 1");
            //     if(mysql_num_rows($cities)==0){ $jsonResponse['rescity']=utf8_encode(CITY_INVALID);  die(jsonp($jsonResponse)); }
            //     else { 
            //         $city=mysql_fetch_assoc($cities);
            //         $city=$city['idCities']; 
            //     }
            // }else{ $city=$_POST['city'][0];}
			if (is_array($_POST['city'])){
				$city=$_POST['city'][0];
				if (is_numeric($city)) $city=CON::getVal("SELECT name FROM cities WHERE id=?",array($city));
			}else $city=$_POST['city'];

			//actualizando variable session
			$home_code=explode('---',$home_code);
			$mobile_code=explode('---',$mobile_code);
			$work_code=explode('---',$work_code);
			$country=explode('---',$country);
			$_SESSION['ws-tags']['ws-user']['city']=$city;
			$_SESSION['ws-tags']['ws-user']['address']=$addres;
			$_SESSION['ws-tags']['ws-user']['home_phone']=$home_code[0].'-'.$phoneHome;
			$_SESSION['ws-tags']['ws-user']['mobile_phone']=$mobile_code[0].'-'.$phoneMobile;
			$_SESSION['ws-tags']['ws-user']['work_phone']=$work_code[0].'-'.$phoneWork;
			$_SESSION['ws-tags']['ws-user']['country']=$country[1];
			$_SESSION['ws-tags']['ws-user']['zip_code']=$zipCode;
			$last='';$home='';
			if ($_SESSION['ws-tags']['ws-user']['type']==0){ $home="home_phone= '".$_SESSION['ws-tags']['ws-user']['home_phone']."',"; }
			// updating database
				$GLOBALS['cn']->query("	UPDATE users
										SET	
											city				= '".$_SESSION['ws-tags']['ws-user']['city']."',
											address				= '".$_SESSION['ws-tags']['ws-user']['address']."',
											".$home."
											mobile_phone		= '".$_SESSION['ws-tags']['ws-user']['mobile_phone']."',
											work_phone			= '".$_SESSION['ws-tags']['ws-user']['work_phone']."',
											country				= '".$_SESSION['ws-tags']['ws-user']['country']."',
											zip_code			= '".$_SESSION['ws-tags']['ws-user']['zip_code']."'
										WHERE id = '".$_SESSION['ws-tags']['ws-user'][id]."'");
			// END - updating database
			
			$numIt=createSessionCar('','','count');
			if ($numIt=='0'||$numIt==''){ $datosCar='guardado-noCart'; }
            else{
				//Verificamos si hay cosas que pagar con paypal para redireccionar
				$datosCar='guardado';$noProduct=false;
				createSessionCar();
				foreach ($_SESSION['car'] as $product){
					if ($product['id_category']!='1'){
						$result=$GLOBALS['cn']->query('SELECT stock,id_status FROM store_products WHERE id="'.$product['id'].'" AND id_user="'.$product['seller'].'"');
						$result=  mysql_fetch_assoc($result);
						$num=(intval($result['stock'])-intval($product['cant']));
						if ($num<0){
							if($result['id_status']=='2'){
								$GLOBALS['cn']->query('UPDATE store_orders_detail SET id_status=2 WHERE id_order="'.$_SESSION['car']['order']['order'].'" AND id_product="'.$product['id'].'" AND id_user="'.$product['seller'].'"');
								$noProduct=true;
							}elseif ($result['id_status']=='1') {
								$GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$result['stock'].'" 
														WHERE id_product="'.$product['id'].'" 
														AND id_order="'.$_SESSION['car']['order']['order'].'"
														AND id_status=11');
								$noProduct=true;
							}
						}else{
							//$GLOBALS['cn']->query('UPDATE users SET description="'.$num.'" WHERE id="184"');
							if( $_SESSION['havePaypalPayment'] ){
								$GLOBALS['cn']->query('	UPDATE store_products SET 
																'.($num==0?'id_status="2",':'').'
																stock="'.$num.'"
														WHERE id="'.$product['id'].'";');
							}
						}
					}
				}
				if (!$noProduct){
					if( $_SESSION['havePaypalPayment'] ){
						$tiempo=getTimeOrderPay();
						$minuto=$tiempo>=60?intval($tiempo%60):$tiempo;
						$hora=$tiempo>=60?intval($tiempo/60):'';
						$dias=$hora>=24?intval($hora/24):'';
						$tiempo=$dias!=''?$dias.' '.DAY.($dias>1?'s':''):'';
						$tiempo.=' '.($hora!='' && $hora!=0)?$hora.' '.HOUR.($hora>1?'s':''):'';
						$tiempo.=' '.($minuto!='' && $minuto!= 0?($minuto.' '.MINUTE.($minuto>1?'s':'')):'');
						$jsonResponse['havePaypalPayment'] = utf8_encode(STORE_TIME_FROM.' '.$tiempo.' '.STORE_TIME_END_ORDER);
					}
				}else{ $jsonResponse['orderEdit']='true'; }
				
			}

		break;
		case 7: //actualizar la cantidad de productos segun lo especifico el usuario
			//	a diferencia del app los productos pueden comprarse más de uno a la vez
			if(isset($_POST['data'])){
				foreach ($_SESSION['car'] as $carrito){
						foreach ($_POST['data'] as $dataT){
							if($dataT['id']==md5($carrito['id'])){
								$result=$GLOBALS['cn']->query('	SELECT stock,id_status
																FROM store_products 
																WHERE id="'.$carrito['id'].'"
																AND id_user="'.$carrito['seller'].'"');
								$result=  mysql_fetch_assoc($result);
								$num=($result['stock'])-$dataT['cant'];
								if ($num>=0){
									$_SESSION['car'][$carrito['id']]['cant']=$dataT['cant'];
									$GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$dataT['cant'].'" 
															WHERE id_product="'.$carrito['id'].'" 
															AND id_order="'.$_SESSION['car']['order']['order'].'"
															AND id_status=11');
								}else{
									$datosCar='no-update';
									$activo=$result['id_status'];
									if($activo=='2' || ($result['stock']=='0' || $result['stock']=='')){
										$GLOBALS['cn']->query('UPDATE store_orders_detail SET id_status="2" WHERE id_order="'.$_SESSION['car']['order']['order'].'" AND id_product="'.$carrito['id'].'" AND id_user="'.$carrito['seller'].'"');
										unset($_SESSION['car'][$carrito['id']]);
										break;
									}elseif ($activo=='1' && ($result['stock']!='0' && $result['stock']!='')) {
										$GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$result['stock'].'" 
																WHERE id_product="'.$carrito['id'].'" 
																AND id_order="'.$_SESSION['car']['order']['order'].'"
																AND id_status=11');
									}
									break 2;
								}
							}
						}			
				}
			}
			$datosCar=$datosCar=='no-update'?$datosCar:'update';
		break;
		case 9: //ordenes ya realizadas
			$a=0;
			if (!isset($_GET['orderId'])){
				$filterRadio='';
				if (isset($_GET['radio'])){
					switch ($_GET['radio']){
						case 'pend': 
							$filterRadio=' AND (o.id_status="11" AND od.id_status="11")'; 
							$filterRadio2=' AND (id_status="11")'; 
							break;
						case 'fins': 
							$filterRadio=' AND (o.id_status="12" AND od.id_status="12")'; 
							$filterRadio2=' AND (id_status="12")'; 
							break;
					}
				}
				$filter='	o.id_user="'.$myId.'" 
							AND YEAR(o.date)=(SELECT YEAR(`date`) FROM `store_orders` WHERE `id_user`="'.$myId.'" '.$filterRadio2.' AND (id_status!="1") AND (id_status!="5") AND (id_status!="2") ORDER BY `date` DESC LIMIT 1)
							AND MONTH(o.date)=(SELECT MONTH(`date`) FROM `store_orders` WHERE `id_user`="'.$myId.'" '.$filterRadio2.' AND (id_status!="1") AND (id_status!="5") AND (id_status!="2") ORDER BY `date` DESC LIMIT 1) ';
				if($_GET['year']){
					$filter='o.id_user="'.$myId.'" AND YEAR(o.date)='.$_GET['year'];
					if ($_GET['month']){ $filter.=' AND MONTH(o.date)='.$_GET['month'].' '; } 
				}
				$filter.=$filterRadio.'AND ((o.id_status="12" AND od.id_status="12") OR (o.id_status="11" AND od.id_status="11"))';
			}else{ $filter='md5(o.id)="'.$_GET['orderId'].'" AND '.($_GET['option']=='orders'?'o':'od').'.id_user="'.$myId.'" AND ((o.id_status="12" AND od.id_status="12") OR (o.id_status="11" AND od.id_status="11"))'; }
			$sql='SELECT	
						md5(p.id) AS id,
						o.id AS idOrder,
						o.date AS dateOrder,
						od.cant AS cant,
						o.id_status AS pago,
						od.price AS sale_points,
						md5(p.id_user) AS seller,
						u.paypal AS paypal_account,
						DATE(p.join_date) AS inicio,
						DATE(o.date) AS fin,
						p.id_category AS id_category,
						p.id_sub_category AS id_sub_category,
						p.description AS description,
						(SELECT name FROM store_category WHERE id=p.id_category) AS category,
						(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
						u.email AS email_seller,
						CONCAT(u.name, " ", u.last_name) AS name_user,
						u.profile_image_url,
						md5(concat(u.id,\'_\',u.email,\'_\',u.id)) AS code,
						p.name AS name,
						p.photo AS photo,
						p.place AS place,
						od.formPayment AS formPayment
					FROM store_orders o
					INNER JOIN store_orders_detail od ON od.id_order=o.id
					INNER JOIN store_products p ON p.id=od.id_product
					INNER JOIN users AS u ON p.id_user=u.id
					WHERE  
					'.$filter.'
					ORDER BY o.date DESC;';
			$products = $GLOBALS['cn']->query($sql);
			//echo $sql;
			while($array=  mysql_fetch_array($products)){
				$hora=  explode(' ',$array['dateOrder']);
				$fecha=  explode('-',$array['dateOrder']);
				$dia=  explode(' ',$fecha[2]);
				$datosCar[$a]['product_seller']=$array['seller'];	
				$datosCar[$a]['idOrder']=$array['idOrder'];
				$datosCar[$a]['idOrderM']=md5($array['idOrder']);
				$datosCar[$a]['dateOrder']=$fecha[1].'/'.$dia[0].'/'.$fecha[0].' - '.$hora[1];
				$datosCar[$a]['year']=$fecha[0];
				$datosCar[$a]['inicio']=date("m/d/Y",strtotime($array['inicio']));
				$datosCar[$a]['fin']=date("m/d/Y",strtotime($array['fin']));
				$datosCar[$a]['product_id']=$array['id'];
				$datosCar[$a]['product_id']=$array['id'];
				$datosCar[$a]['product_name']=utf8_encode(formatoCadena($array['name']));
				$photo	= FILESERVER.'img/'.$array['photo'];
				if(fileExistsRemote($photo)){ $datosCar[$a]['product_photo'] = $photo; }
                else{ $datosCar[$a]['product_photo'] = DOMINIO.'imgs/defaultAvatar.png';}
				$datosCar[$a]['product_place']=$array['place'];
				$datosCar[$a]['product_paypal_account']=$array['paypal_account'];
				$datosCar[$a]['product_price']=$array['sale_points'];
				$datosCar[$a]['product_category']=  formatoCadena(lan($array['category']));
				$datosCar[$a]['product_subCategory']=  formatoCadena(lan($array['subCategory']));
				$datosCar[$a]['product_id_category']=$array['id_category'];
				$datosCar[$a]['product_id_sub_category']=$array['id_sub_category'];
				$datosCar[$a]['product_cant']=$array['cant'];
				$datosCar[$a]['product_email_seller']=$array['email_seller'];
				$datosCar[$a]['product_imagenUser']=FILESERVER.getUserPicture($array['code'].'/'.$array['profile_image_url'],'img/users/default.png');
				$datosCar[$a]['product_name_user']=  utf8_encode(formatoCadena($array['name_user']));
				$datosCar[$a]['product_formPayment']=$array['formPayment'];
				$datosCar[$a]['pago']=$array['pago'];
				$a++;
			}
		break;
		case 10: //fechas de las ordenes ya realizadas
			$i=0; $filtro='';$inner='';$group='';
			if ($_GET['option']=='orders'){ $filtro='o.id_user="'.$myId.'"'; }
            elseif($_GET['option']=='sales'){
				$filtro='od.id_user="'.$myId.'"';
				$inner='INNER JOIN store_orders_detail od ON od.id_order=o.id';
				$group=' GROUP BY o.id';
			}
			if (isset($_GET['radio'])){
				switch ($_GET['radio']){
					case 'pend': $filter=' AND (o.id_status="11" )'; break;
					case 'fins': $filter=' AND (o.id_status="12" )'; break;
                    default: $filter=' AND (o.id_status="11" OR o.id_status="12")';
				}
            }
			//consulta para obtener todas las fechas para el filtro
			$sql=$GLOBALS['cn']->query('SELECT DISTINCT	
											YEAR(o.date) AS year,
											MONTH(o.date) AS month
										FROM store_orders o
										'.$inner.'
										WHERE '.$filtro.' '.$filter.' '.$group.'
										ORDER BY o.date DESC;');
			while($array=  mysql_fetch_assoc($sql)){
				$datosCar[$i]['year']=$array['year'];
				$datosCar[$i]['month']=$array['month'];
				$datosCar[$i++]['monthL']=  getMonth((int)$array['month']);
			}
			break;
		case 11: //consultas de las ciudades de la tabla ciudad... se llama por ajax para que no cuelgue la vista de users_shoppingCart
			if (!isset($_POST['data'])){
				$cities=$GLOBALS['cn']->query("SELECT c.id AS 'value', c.name AS 'key'
								FROM  `cities` c WHERE name LIKE '%".$_GET['tag']."%' LIMIT 40");
				$salida='[';
				while($array=  mysql_fetch_assoc($cities)){
					$array['key']=  htmlentities($array['key']);
					$salida.=json_encode($array);
				}
			}else{
				if (is_numeric($_POST['data'])){
					$cities=$GLOBALS['cn']->query("SELECT c.id AS 'idCities', c.name AS 'city'
									FROM  `cities` c WHERE id='".$_POST['data']."'");
					$array=  mysql_fetch_assoc($cities);				
					$datosCar['idCities']=$array['city'];
					$datosCar['city']=$array['city'];		
				}else{
					$datosCar['idCities']=$_POST['data'];
					$datosCar['city']=$_POST['data'];		
				}
			}
			break;
		case 12: //consultas de las ventas que he realizado en el store de tagbum
			$filterRadio="";
			if (isset($_GET['radio'])){
				switch ($_GET['radio']){
					case 'pend': 
						$filterRadio='AND (o.id_status="11" AND od.id_status="11") '; 
						$filterRadio2='AND (so.id_status="11" AND sod.id_status="11") '; 
						break;
					case 'fins': 
						$filterRadio='AND (o.id_status="12" AND od.id_status="12") '; 
						$filterRadio2='AND (so.id_status="12" AND sod.id_status="12") '; 
						break;
				}
			}
			$a=0;$filter='	AND YEAR(o.date)=(SELECT YEAR(so.date) FROM `store_orders` so INNER JOIN store_orders_detail sod ON sod.id_order=so.id WHERE sod.id_user="'.$myId.'" '.$filterRadio2.' AND so.id_status!="1" AND so.id_status!="2" AND so.id_status!="5" ORDER BY so.date DESC LIMIT 1)
							AND MONTH(o.date)=(SELECT MONTH(so.date) FROM `store_orders` so INNER JOIN store_orders_detail sod ON sod.id_order=so.id WHERE sod.id_user="'.$myId.'" '.$filterRadio2.'  AND so.id_status!="1" AND so.id_status!="2" AND so.id_status!="5" ORDER BY so.date DESC LIMIT 1)';
			if($_GET['year']){
				$filter=' AND YEAR(o.date)='.$_GET['year'];
				if ($_GET['month']){ $filter.=' AND MONTH(o.date)='.$_GET['month']; }
			}
			//ALTER TABLE  `store_orders_detail` ADD  `formPayment` CHAR( 1 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 0
			$sql='SELECT	o.id AS idOrder,
							o.date AS dateOrder,
							md5(o.id_user) AS buyer,
							u.paypal AS paypal_account,
							u.email AS email_seller,
							md5(u.id) AS idU,
							md5(concat(u.id,\'_\',u.email,\'_\',u.id)) AS code,
							CONCAT(u.name, " ", u.last_name) AS name_user,
							COUNT(od.id) AS numItems,
							u.profile_image_url
					FROM store_orders o
					INNER JOIN store_orders_detail od ON od.id_order=o.id
					INNER JOIN store_products p ON p.id=od.id_product
					INNER JOIN users AS u ON o.id_user=u.id
					WHERE od.id_user="'.$myId.'" AND o.id_status!="1" AND o.id_status!="2" AND o.id_status!="5"
					'.$filter.' '.$filterRadio.'
					GROUP BY o.id
					ORDER BY o.id DESC';
			$products = $GLOBALS['cn']->query($sql);
			while($array=  mysql_fetch_array($products)){
				$hora=  explode(' ',$array['dateOrder']);
				$fecha=  explode('-',$array['dateOrder']);
				$dia=  explode(' ',$fecha[2]);
				$datosCar[$a]['buyer']=$array['buyer'];	
				$datosCar[$a]['idOrder']=$array['idOrder'];
				$datosCar[$a]['idOrderM']=md5($array['idOrder']);
				$datosCar[$a]['dateOrder']=$fecha[1].'/'.$dia[0].'/'.$fecha[0].' - '.$hora[1];
				$datosCar[$a]['year']=$fecha[0];
				$datosCar[$a]['email_seller']=$array['email_seller'];
				$datosCar[$a]['numItems']=$array['numItems'];
				$datosCar[$a]['imagenUser']=FILESERVER.getUserPicture($array['code'].'/'.$array['profile_image_url'],'img/users/default.png');
				$datosCar[$a]['name_user']=  utf8_encode(formatoCadena($array['name_user']));
				$sqlprice='SELECT SUM(price) AS total,formPayment FROM store_orders_detail WHERE id_user="'.$myId.'" AND id_order="'.$array['idOrder'].'" GROUP BY formPayment';
				$result=$GLOBALS['cn']->query($sqlprice);
				$b=0;
				while ($row=  mysql_fetch_assoc($result)){
					$datosCar[$a]['f_pago'][$b]['total']=$row['total'];
					$datosCar[$a]['f_pago'][$b++]['formPayment']=$row['formPayment'];
				}
				$a++;
			}
			break;
		case 13: //valida filtros de ordenes y ventas
			$a=0;$filter='';$join='';
			//ALTER TABLE  `store_orders_detail` ADD  `formPayment` CHAR( 1 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 0
			
			if ($_GET['option']=='orders'){ $filter=' o.id_user="'.$myId.'"'; }
            elseif($_GET['option']=='sales'){
				$join=' INNER JOIN store_orders_detail od ON od.id_order=o.id';
				$filter=' od.id_user="'.$myId.'"';
			}
			$sql='SELECT	COUNT(o.id) AS num,
							o.id_status AS tipo
					FROM store_orders o
					'.$join.'
					WHERE 
					'.$filter.'
					AND o.id_status!="1"
					GROUP BY o.id_status
					ORDER BY o.id DESC';
			$products = $GLOBALS['cn']->query($sql);
			while ($product=mysql_fetch_assoc($products)){ $datosCar[$a++]=$product; }
			break;
		case 14:
			#Añadir productos a la lista de deseados  (estatus 5 porque en la tabla de status el 5 es pendiente)
			if($product['seller']==$myId){ $jsonResponse['listWish'] = 'no'; }
			else{
				if (($product['id_status']!='2' && $product['stock']>'0') || isset($_GET['shop'])){
					$jsonResponse['listWish'] = 'si';
					$idOrder=$GLOBALS['cn']->query("SELECT id FROM store_orders WHERE id_status = '5' AND id_user = '".$myId."'");
					$numIdOrder=mysql_num_rows($idOrder);
					$idOrder=  mysql_fetch_assoc($idOrder);
					$idOrder=$idOrder['id'];
                    $existe=existe('store_orders_detail', 'id', "WHERE id_status = '5' AND id_order='".$idOrder."' AND id_product='".$producto."'");
					if ((!$existe) || (isset($_GET['shop']))){				
						$price = 0;
						$nproduct = 0;
						if ($numIdOrder==0){
							$GLOBALS['cn']->query("INSERT INTO store_orders SET id_status = '5', id_user = '".$myId."'");
							$idOrder=  mysql_insert_id();
                            $_SESSION['store']['wish']=$idOrder;
                            $jsonResponse['nuevo']='si';
						}
                        if (isset($_GET['car']) && $_GET['car']=='toWish'){
                            if ($_GET['id']!='1'){
                                $idsUpdates=$product['id'];
                                if (!$existe){
                                    $GLOBALS['cn']->query(' UPDATE store_orders_detail SET 
                                                                id_status="5",id_order="'.$idOrder.'" 
                                                            WHERE 
                                                                (id_order="'.$_SESSION['car']['order']['order'].'" 
                                                                    AND id_status="11" 
                                                                    AND id_product="'.$product['id'].'")');
                                }else{
                                    $GLOBALS['cn']->query(' UPDATE store_orders_detail SET 
                                                                id_status="2" 
                                                            WHERE 
                                                                (id_order="'.$_SESSION['car']['order']['order'].'" 
                                                                    AND id_status="11" 
                                                                    AND id_product="'.$product['id'].'")');
                                }
                            }else{
                                   $idsUpdates='';
                                   $sqlIN=''; $sql="   SELECT p.id 
                                                       FROM store_products p
                                                       WHERE (p.stock='0' OR p.id_status='2')
                                                       AND p.id IN (	SELECT id_product 
                                                                       FROM store_orders_detail
                                                                       WHERE (id_order='".$_SESSION['car']['order']['order']."' AND id_status='11')) 
                                                       AND p.id NOT IN (	SELECT id_product 
                                                                           FROM store_orders_detail
                                                                           WHERE (id_order='".$idOrder."' AND id_status='5'));";
                                   $idProds=$GLOBALS['cn']->query($sql);
                                   while ($result=mysql_fetch_assoc($idProds)){
                                       $sqlIN.=$sqlIN==''?$result['id']:','.$result['id'];
                                   }
                                   if ($sqlIN!=''){
                                       $GLOBALS['cn']->query(' UPDATE store_orders_detail SET id_order="'.$idOrder.'", id_status="5"
                                                               WHERE id_order="'.$_SESSION['car']['order']['order'].'" 
                                                               AND id_product IN ('.$sqlIN.');');
                                       $idsUpdates=$sqlIN;
                                   }
                                   $sql="  SELECT p.id 
                                           FROM store_products p
                                           JOIN  store_orders_detail od ON p.id=od.id_product
                                           WHERE (p.stock='0' OR p.id_status='2')
                                           AND id_order='".$_SESSION['car']['order']['order']."' AND od.id_status='11'";
                                   $idProds=$GLOBALS['cn']->query($sql);
                                   while ($result=mysql_fetch_assoc($idProds)){
                                       $sqlIN.=$sqlIN==''?$result['id']:','.$result['id'];
                                   }
                                   if ($sqlIN!=''){
                                       $idsUpdates.=$idsUpdates==''?$sqlIN:','.$sqlIN;
                                       $GLOBALS['cn']->query(' UPDATE store_orders_detail SET id_status="2"
                                                               WHERE id_order="'.$_SESSION['car']['order']['order'].'" 
                                                               AND id_product IN ('.$sqlIN.');');
                                   }  
                            }
                            $numIt=createSessionCar('','','count');
                            if ($numIt=='0' || $numIt==''){
                                $GLOBALS['cn']->query(' UPDATE store_orders SET id_status="2"
                                                    WHERE id="'.$_SESSION['car']['order']['order'].'";');
                                unset($_SESSION['car']);
                            }else{
                                $productos=  explode(',', $idsUpdates);
                                foreach ($productos as $id){
                                    unset($_SESSION['car'][$id]);
                                    $jsonResponse['delete'][]=md5(md5($id));
                                }
                            }
                            $jsonResponse['numRow']=$numIt; 
                        }else{
                            $GLOBALS['cn']->query("INSERT INTO store_orders_detail SET id_order = '".$idOrder."',
                                                          id_product = '".$product['id']."',
                                                          id_user = '".$product['seller']."',
                                                          cant = 1,
                                                          price = '".$product['sale_points']."',
                                                          id_status=5,
                                                          formPayment='".$product['formPayment']."'
                            ");
                        }
					}else{ $jsonResponse['listWish']='ya-existe'; }
				}else{ $jsonResponse['listWish']='no-disponible'; }
			}
		break;
        case 15: //actualizar la cantidad de productos en vivo       
			if(isset($_GET['linea'])){
                $carrito['id']=  campo("store_products", "md5(id)", $_GET['linea'], 'id');
				if($_GET['linea']==md5($carrito['id'])){
                    $result=$GLOBALS['cn']->query('	SELECT stock 
                                                    FROM store_products 
                                                    WHERE id="'.$carrito['id'].'"');
                    $result=  mysql_fetch_assoc($result);
                    $num=($result['stock'])-$_GET['cant'];
                    if ($num>=0){
                        $_SESSION['car'][$carrito['id']]['cant']=$_GET['cant'];
                        $GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$_GET['cant'].'" 
                                                WHERE id_product="'.$carrito['id'].'" 
                                                AND id_order="'.$_SESSION['car']['order']['order'].'"
                                                AND id_status=11');
                    }else{
                        $datosCar='no-update';
                        $activo=campo('store_products','id',$carrito['id'],'id_status');
                        if($activo=='2'){
                            $GLOBALS['cn']->query('DELETE FROM store_orders_detail WHERE id_order="'.$_SESSION['car']['order']['order'].'" AND id_product="'.$carrito['id'].'"');
                            unset($_SESSION['car'][$carrito['id']]);
                            break;
                        }elseif ($activo=='1') {
                            $GLOBALS['cn']->query('	UPDATE store_orders_detail SET cant="'.$result['stock'].'" 
                                                    WHERE id_product="'.$carrito['id'].'" 
                                                    AND id_order="'.$_SESSION['car']['order']['order'].'"
                                                    AND id_status=11');
                        }
                        break;
                    }
                }
			}
			$datosCar=$datosCar=='no-update'?$datosCar:'update';
		break;
        case 16: //consulta para el shipping  
            $jsonResponse['exitSC']=(isset($_SESSION['car']) && count($_SESSION['car'])>0?true:false);
            if (is_numeric($_SESSION['ws-tags']['ws-user']['city']))
            	$_SESSION['ws-tags']['ws-user']['city']=CON::getVal("SELECT name FROM cities WHERE id=?",array($_SESSION['ws-tags']['ws-user']['city']));
            $city=$_SESSION['ws-tags']['ws-user']['city'];
			if (!isset($_GET['noEditS'])){
                    $_SESSION['ws-tags']['ws-user']['yaShipp']='1';
                    $numIt=createSessionCar('','','count');
                	$countries=$GLOBALS['cn']->query("SELECT p.id AS id, p.code_area AS code_area, p.name AS country FROM  `countries` p ");
                	$numberh = explode('-',$_SESSION['ws-tags']['ws-user']['home_phone']);
                	$numberw = explode('-',$_SESSION['ws-tags']['ws-user']['work_phone']);
                	$numberm = explode('-',$_SESSION['ws-tags']['ws-user']['mobile_phone']);
                	$numberp = $_SESSION['ws-tags']['ws-user']['country'];
                	$options='';$tele_home='';$tele_mobile='';$tele_work;$num_pais='';
                    
                	while( $country = mysql_fetch_assoc($countries) ){
                	       $country['country']=utf8_encode($country['country']);
                		if ($numberh[0]==$country['code_area']){
                			$tele_home='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
                							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>
                						</option>';
                		}
                		if ($numberw[0]==$country['code_area']){
                			$tele_work='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
                							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>
                						</option>';
                		}
                		if ($numberm[0]==$country['code_area']){
                			$tele_mobile='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
                							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>
                						</option>';
                		}
                		if ($numberp==$country['id']){
                			$num_pais='<option value="'.$country['code_area'].'---'.$country['id'].'" selected="1">
                							'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>
                						</option>';
                		}
                		$options.='<option value="'.$country['code_area'].'---'.$country['id'].'" >
                			'.$country['country'].'&nbsp;<span>('.$country['code_area'].')<span>
                		</option>';
                	}
                    $datosCar['zipCode']=$_SESSION['ws-tags']['ws-user']['zip_code'];
                    $datosCar['address']=$_SESSION['ws-tags']['ws-user']['address'];
                    
                    $datosCar['option']=$options;
                    $datosCar['city2']=$city;
                    if($_SESSION['ws-tags']['ws-user']['type']=='0'){
                        $datosCar['thome']=$tele_home;
                        $datosCar['nhome']=$numberh[1];  
                    } 
                    $datosCar['tmobile']=$tele_mobile;
                    $datosCar['twork']=$tele_work;
                    $datosCar['npais']=$num_pais;
                    $datosCar['nmobile']=$numberm[1];
                    $datosCar['nwork']=$numberw[1];
			}else{
			     unset($_SESSION['ws-tags']['ws-user']['yaShipp']);
			     if ($_SESSION['ws-tags']['ws-user']['work_phone']!='-' &&
                    $_SESSION['ws-tags']['ws-user']['country']!='' &&
                    $_SESSION['ws-tags']['ws-user']['city']!='' &&
                    $_SESSION['ws-tags']['ws-user']['zip_code']!='' &&
                    $_SESSION['ws-tags']['ws-user']['address']!='' &&
                    $_SESSION['ws-tags']['ws-user']['mobile_phone']!='-' &&
                    ($_SESSION['ws-tags']['ws-user']['home_phone']!='-' || $_SESSION['ws-tags']['ws-user']['type']=='1')  
                    ){
                         $countries=$GLOBALS['cn']->query("  SELECT p.name AS country 
                                                     FROM  `countries` p 
                                                     WHERE id='".$_SESSION['ws-tags']['ws-user']['country']."'");
                         $country = mysql_fetch_assoc($countries);
        			     $string='   <div class="msgShipp">
                                            <strong>'.utf8_encode(STORE_SHIPPING).'</strong>
                                            <p>
                                                '.utf8_encode(USERS_BROWSERFRIENDSLABELCOUNTRY).': '.utf8_encode($country['country']).'<br/>
                                                '.utf8_encode(BUSINESSCARD_LBLCITY).': '.$city.'<br/>
                                                '.utf8_encode(BUSINESSCARD_LBLZIPCODE).': '.$_SESSION['ws-tags']['ws-user']['zip_code'].'<br/>
                                                '.utf8_encode(BUSINESSCARD_LBLZIPCODE).': '.$_SESSION['ws-tags']['ws-user']['address'].'<br/>
                                                '.utf8_encode(ADDRESSBOOK_LBLMOBILEPHOME).': '.$_SESSION['ws-tags']['ws-user']['mobile_phone'].'<br/>
                                                '.($_SESSION['ws-tags']['ws-user']['type']=='0'?utf8_encode(ADDRESSBOOK_LBLHOMEPHOME).': '.$_SESSION['ws-tags']['ws-user']['home_phone'].'<br/>':'').'
                                                '.utf8_encode(ADDRESSBOOK_LBLWORKPHOME).': '.$_SESSION['ws-tags']['ws-user']['work_phone'].'<br/>
                                            </p>
                                    </div>';
                    }else{ $string=''; }
                    $jsonResponse['msgShipp']=$string;
			}
            
		break;
		}
		//unset( $_SESSION['car']);
		//output
        if (isset($_GET['shop'])){
            $i = 0;
            $price = 0;$points=0;$money=0;$update='';$a=0;$disable='';
            createSessionCar();
            if($_SESSION['car']){
                $product= array();
//					 _imprimir($_SESSION['car']);
                foreach ($_SESSION['car'] as $carrito){
                    if (!$carrito['order']){
                        $carrito['nameC']= $carrito['category'];
                        $carrito['nameSC']=$carrito['subCategory'];
                        $carrito['mId']=md5($carrito['id']);
                        $carrito['id_user']=$carrito['seller'];
                        $product=$carrito;

                        //validacion precio
                        if ($product['price']!=$product['sale_points'] || $product['fp']!=$product['formPayment']){
                            $storeTo=STORE_TO;
                            switch ($product['formPayment']){
                                case '1': $product['actualPrecio']='$ '.$product['sale_points']; break;
                                default : $product['actualPrecio']=$product['sale_points'].' '.STORE_TITLEPOINTS; 
                            }
                            switch ($product['fp']){
                                case '1': $product['nuevolPrecio']='$ '.$product['price'];break;
                                default : $product['nuevolPrecio']=$product['price'].' '.STORE_TITLEPOINTS;
                            }
                            $code=md5($product['mId']);
                            $update.='<span h="'.$code.'"><a href="'.base_url('detailprod?prd='.$product['mId']).'">'.$product['name'].'</a>';
                            if ($product['sale_points']>$product['price']){ $update.=' '.STORE_DECREMENTE.' '; }
                            elseif ($product['sale_points']<$product['price']){ $update.=' '.STORE_INCREASED.' '; }
                            else { 
                                    $update.=' '.utf8_encode(STORE_CHANGED).' '; 
                                    $storeTo=$_SESSION['ws-tags']['ws-user']['language']=='en'?$storeTo:'a';
                                }
                            $update.=INVITEUSERS_FROM.' <em>'.$product['actualPrecio'].'</em> '.$storeTo.' <em>'.$product['nuevolPrecio'].'</em>.<br></span>';
                            $product['sale_points']=$product['price']; //actualiza el precio sale_points
                            $product['formPayment']=$product['fp'];
                            $GLOBALS['cn']->query('UPDATE store_orders_detail SET price="'.$product['price'].'",formPayment="'.$product['fp'].'" WHERE id_order="'.$_SESSION['car']['order']['order'].'" AND id_product="'.$product['id'].'";');
                            $a++;
                        }
                        
                        if ($product['id_status']==2 || $product['stock']==0){
                            $product['nombreDisable']=$product['name'];
                            $product['idDisable']=$product['id'];
                            $product['stock']=0;
                            $code=md5($product['mId']);
                            $disable.='<span h="'.$code.'"><a href="'.base_url('detailprod?prd='.$product['mId']).'">'.$product['name'].'</a><br></span>';
                        }else{
                            if ($product['formPayment']==1) $money=($product['sale_points']*$product['cant'])+$money;
                            else $points=($product['sale_points']*$product['cant'])+$points;
                            $price = ($product['sale_points']*$product['cant']) + $price;
                        }
                        $codeUserapp = $GLOBALS['cn']->query('
                                    SELECT
                                           a.id AS id,
                                           md5(a.id) AS mId,
                                           followers_count AS admirers,
                                           following_count AS admired,
                                           a.name AS name,
                                           md5(concat(id,\'_\',email,\'_\',id)) AS code,
                                           profile_image_url,
                                           a.last_name AS last_name
                                    FROM users a
                                    WHERE  a.id = "'.$product['id_user'].'"');
                        $codeUserapps  = mysql_fetch_assoc($codeUserapp);
                        $product['name'] = utf8_encode(formatoCadena($product['name']));
                        $product['nameUser'] = utf8_encode(formatoCadena($codeUserapps['name']).' '.formatoCadena($codeUserapps['last_name']));
                        $product['idUser'] = $codeUserapps['mId'];
                        $product['imagenUser'] = FILESERVER.getUserPicture($codeUserapps['code'].'/'.$codeUserapps['profile_image_url'],'img/users/default.png');
                        $product['admirers'] = $codeUserapps['admirers']?$codeUserapps['admirers']:'0';
                        $product['admired'] = $codeUserapps['admired']?$codeUserapps['admired']:'0';

                        $photo	= FILESERVER.'img/'.$product['photo'];
                        if(fileExistsRemote($photo)){ $product['photo'] = $photo; }
                        else{ $product['photo'] = DOMINIO.'imgs/defaultAvatar.png'; }
                        $datosCar[] = $product;
                        $i++;
//							_imprimir($product);
                        }
                    }
                    if ($update!='' || $disable!=''){
                        $disable=$disable!=''?'<div class="noST">
                                                    <div><strong>'.utf8_encode(ITEMS_NOT_AVAILABLE).':</strong></div>
                                                    '.$disable.'<em>'.NOT_P_ITEMS_NOT_STOCK.'</em>'.
                                                    ((!$mobile)?'<div id="actionItems">
                                                        '.STORE_WANT_TO_DO.'
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="button addToWish" style="margin: 5px 0;" >'.utf8_encode(STORE_WISH_LIST_MOVE).'</span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="button deleteToCar" style="margin: 5px 0;" >'.utf8_encode(NEWTAG_HELPDELETEBACKGROUNDTEMPLATE).'</span>
                                                    </div>':'').'
                                                </div>':'';
                        $update=$update!=''?'<div class="updateItems"><div><strong><span class="numI">'.$a.'</span> '.utf8_encode(ITEM.($a==1?'':'s')).' '.utf8_encode(STORE_CHANGE_PRICE).'</div>'.$update.'</div>':'';
                        $jsonResponse['bodyEmerg']='<div class="messageAdver changeOrder">'.$disable.'<br>'.$update.'</div>';
                    }
                }else{
                    $datosCar[] ='vacio';
                    $price = 0;
                    $i = 0;
                    $nOrden = 0;
                }
                $nproduct = $i;
        }
        //end carrito de compras
        //start lista de deseo
        if (isset($_GET['lisWihs']) || isset($_GET['lisWishsShow'])){
            if (isset($_GET['shopW'])) $_GET['shop']='1';
            $array['tipo']='wish';
            $array['mobile']=$mobile;
            if (!$mobile && isset($_GET['appMobile'])) $array['mobile']=true;
            $wishList=consulWishList($array,$lang);
            if (!isset($wishList['body'])) $_GET['shop']='1';
            if (isset($wishList['body']) || isset($_GET['shop'])){
                $array['tipo']  ='prefe';
                $array['max']   =5;
                if (isset($wishList['body'])){ 
                    $array['noId']= $wishList['noId']; 
                    $band=false;
                }else{ 
                    $array['noId']=''; 
                    $band=true;
                }
                // $temp=consulWishList($array,$lang);
                // if (!isset($temp['body'])){ 
                //     $array['tipo']  ='aso';
                //     $temp=consulWishList($array,$lang);
                // }
                if (isset($temp['body'])){
                    if (isset($wishList['body']) && $wishList['body']!='') $wishList['body'].=$temp['body'];
                    else $wishList['body']=$temp['body'];
                     @$wishList['result']=array_merge($wishList['result'],$temp['result']);
                }
                if (!$array['mobile'])
	                if (!isset($_GET['lisWishsShow']) && isset($wishList['body']) && $wishList['body']!= '' && $band==false){ $wishList['body'].='</ul>'; }
	                elseif ($band==true) { 
	                	$wishList['body']='<ul id="ulToCarWish" h="0">'.(isset($wishList['body']) && $wishList['body']!=''?$wishList['body']:'
								<div class="messageAdver">'.$lang["STORE_NO_WL"].'</div>
	                		').'</ul>'; 
	                }
                if (isset($wishList['noId'])) unset($wishList['noId']);
            }
        }
        
		if(isset($salida)){ echo str_replace('}{','},{',$salida).']'; }
        else{
			if (isset($wishList) && $wishList!='') $jsonResponse['wish']    = $wishList;
			if (isset($datosCar) && $datosCar!='') $jsonResponse['datosCar']    = $datosCar;
			$jsonResponse['totalprice']  = $pric;
			$jsonResponse['totalpoints'] = $points;
			$jsonResponse['totalmoney']  = $money;
			$jsonResponse['nproduct']    = $nproduct;
			$jsonResponse['nOrden']      = md5($id_order);
			die(jsonp($jsonResponse));
		}
	}//quitar_inyect
    function consulWishList($array,$lang){
       	$myId=$_SESSION['ws-tags']['ws-user']['id'];
        #consulta productos de la lista de deseados  (estatus 5 porque en la tabla de status el 5 es pendiente)
        $select=common_data().',
                    u.name AS nameUser,
                    u.last_name AS last_name';
        $from='     store_orders o
                    JOIN store_orders_detail od ON od.id_order=o.id
                    JOIN store_products p ON p.id=od.id_product
                    JOIN users u ON p.id_user=u.id';
        $where='    o.id_user="'.$myId.'" AND 
                    o.id_status=5 AND 
                    od.id_status=5;';
        $noId='';
        switch ($array['tipo']){
            case 'prefe':   $select.=',p.formPayment,p.sale_points AS price';
                            $from=' store_products p
                            		JOIN users u ON p.id_user=u.id';
                            $where='p.id_user!="'.$myId.'" AND (p.id_status="1" AND p.stock>0)';
                           	$prefe=users_preferences();
							if (count($prefe)==0) $random=true;
							else{
								$like=' AND (';$or='';$random=false;
								foreach ($prefe as $typePre)
									foreach ($typePre as $row) {
										$like.=$or.safe_sql('p.name LIKE "%??%" OR p.description LIKE "%??%"',array($row->text,$row->text));
										if (!$or) $or=' OR ';
									}
								$like.=')';
							}
							if (!$random) $where.=$like;
       						if (isset($array['noId']) && $array['noId']!=''){ $where.=' AND p.id NOT IN('.$array['noId'].')';}
                            $where.='LIMIT 0,'.$array['max'];
                break;
            case 'aso':     $select.=',p.formPayment,p.sale_points AS price';
                            $from=' store_products p
                            		JOIN users u ON p.id_user=u.id';
                            $where='p.id_user!="'.$myId.'" AND (p.id_status="1" AND p.stock>0)';
       						if (isset($array['noId']) && $array['noId']!=''){ $where.=' AND p.id NOT IN('.$array['noId'].')';}
                            $where.='ORDER BY RAND() LIMIT 0,'.$array['max'];
                break;
            default : $select.=',od.price,
                                od.formPayment,
                                p.formPayment AS fp,
                                o.id AS idOrder';
        }
        $sql='  SELECT '.$select.'
                FROM '.$from.'
                WHERE '.$where;
        $idOrder=CON::query($sql);
        // $idOrder=$GLOBALS['cn']->query($sql);
        if (isset($_GET['debug'])) echo CON::lastSql();
        // $numIdOrder=mysql_num_rows($idOrder);
        $numIdOrder=CON::numRows($idOrder);
        if ($numIdOrder==0){ return ''; }
        else{ 
            $update='';$disable='';$i=0;$r;$u;$a=0;$idorden='';
            if ($array['mobile']){ 
            	$html='<li data-role="list-divider" class="titleDivider">'.($array['tipo']=='wish'?$lang["STORE_WISH_LIST"]:$lang["STORE_WISH_ASO"]).'</li>'; 
            }else{
            	if (isset($_GET['lisWishsShow'])){ $html=''; }
                elseif($array['tipo']=='wish'){ $html='<ul id="ulToCarWish" h="'.$numIdOrder.'">'; }
                elseif($array['tipo']!='wish'){ $html=''; }                
            }
            while ($row=CON::fetchAssoc($idOrder)){
            // while ($row=  mysql_fetch_assoc($idOrder)){
                $noId.=($noId!=''?',':'').$row['id'];
	            $idorden=  md5($row['idOrder']);
                $row['name']=utf8_encode(formatoCadena($row['name']));
                $row['nameUser']=utf8_encode(formatoCadena($row['nameUser'].' '.$row['last_name']));
                $row['category']=utf8_encode(formatoCadena(lan($row['category'])));
                $row['subCategory']=utf8_encode(formatoCadena(lan($row['subCategory'])));
                unset($row['last_name']);
                $photo	= FILESERVER.'img/'.$row['photo'];
                if(fileExistsRemote($photo)){ $row['photo'] = $photo; }
                else{ $row['photo'] = DOMINIO.'imgs/defaultAvatar.png'; }
                if($array['tipo']=='wish'){
                	if ($row['price']!=$row['sale_points'] || $row['fp']!=$row['formPayment']){
	                    $storeTo=$lang["STORE_TO"];
	                    $t['nombre']=$row['name'];
	                    $t['id']=$row['id'];
	                    switch ($row['formPayment']){
	                        case '1': $t['actual']='$ <span money="d">'.$row['price'].'</span>'; break;
	                        default : $t['actual']='<span money="p">'.$row['price'].'</span> '.$lang["STORE_TITLEPOINTS"]; 
	                    }
	                    switch ($row['fp']){
	                        case '1': $t['nuevo']='$ '.$row['sale_points'];break;
	                        default : $t['nuevo']=$row['sale_points'].' '.$lang["STORE_TITLEPOINTS"];
	                    }
	                    $code=md5(md5($row['id']));
	                    $update.='<span h="'.$code.'"><a href="'.base_url('detailprod?prd='.md5($row['id'])).'">'.$row['name'].'</a>';
	                    if ($row['price']>$row['sale_points']){ $update.=' '.utf8_encode($lang["STORE_DECREMENTE"]).' '; }
	                    else if ($row['price']<$row['sale_points']){ $update.=' '.utf8_encode($lang["STORE_INCREASED"]).' '; }
	                    else { 
	                        $update.=' '.utf8_encode($lang["STORE_CHANGED"]).' '; 
	                        $storeTo=$_SESSION['ws-tags']['ws-user']['language']=='en'?$storeTo:'a';
	                    }
	                    $update.=utf8_encode($lang["INVITEUSERS_FROM"]).' <em>'.$t['actual'].'</em> '.$storeTo.' <em>'.$t['nuevo'].'</em>.<br></span>';
	                    $row['price']=$row['sale_points']; //actualiza el precio
	                    $row['formPayment']=$row['fp'];
	                    $GLOBALS['cn']->query('UPDATE $lang["store_orders_detail"] SET price="'.$row['sale_points'].'",formPayment="'.$row['fp'].'"  WHERE id_order="'.$row['idOrder'].'" AND id_product="'.$row['id'].'";');
	                    $a++;
	                }
	                if ($row['id_status']==2 || $row['stock']==0){
	                    $t['nombreDisable']=$row['name'];
	                    $t['idDisable']=$row['id'];
	                    $row['stock']=0;
	                    $code=md5(md5($row['id']));
	                    $disable.='<span h="'.$code.'"><a href="'.base_url('detailprod?prd='.md5($row['id'])).'">'.$row['name'].'</a><br></span>';
	                }
                }	                
                switch ($row['formPayment']){
                    case '1': $price='$ <span money="d">'.$row['price'].'</span>'; break;
                    default : $price='<span money="p">'.$row['price'].'</span> '.$lang["STORE_TITLEPOINTS"];
                }                
                //datos empieza el html
                if ($array['mobile']){
                    $html.=mobileWishList($row,$lang,$array,$price);
                }else $html.=wishList($row,$i,$lang,$array,$price);  
                $i++;$r[]=$row;
            }

            if (isset($_GET['lisWishsShow'])){
                $htmlEmer=''; 
                if (isset($_GET['noSTP']) && $array['tipo']=='wish'){
                    $datosCar['disable']=$disable!=''?'<div class="noST"><div><strong>'.utf8_encode($lang["ITEMS_NOT_AVAILABLE"]).':</strong></div>'.$disable.'<div id="deleteItemsNot" h="'.$idorden.'">'.utf8_encode($lang["STORE_DELETE_ALL_TO_WISH"]).'</div></div>':'';
                }
            }else{
               $disable=$disable!=''?'<div class="noST"><div><strong>'.utf8_encode($lang["ITEMS_NOT_AVAILABLE"]).':</strong></div>'.$disable.(!$array['mobile']?'<div id="deleteItemsNot" h="'.$idorden.'">'.utf8_encode($lang["STORE_DELETE_ALL_TO_WISH"]).'</div>':'').'</div>':'';
               $update=$update!=''?'<div class="updateItems"><div><strong><span class="numI">'.$a.'</span> '.utf8_encode($lang["ITEM"].($a==1?'':'s')).' '.utf8_encode($lang["STORE_CHANGE_PRICE_WISH"]).'</div>'.$update.'</div>':'';
               $htmlEmer=$update!='' || $disable!=''?'<div class="messageAdver changeOrder">'.$disable.'<br>'.$update.'</div>':'';   
               if (isset($_GET['noSTP']) && $array['tipo']=='wish'){ $datosCar['disable']=$disable; }  
            }
            
            if ($numIdOrder<$array['max'] && $array['tipo']=='prefe'){
                $array['max']=$array['max']-$numIdOrder;
                $array['tipo']='aso';
                $array['noId']=($array['noId'] && $array['noId']!=''?$array['noId'].',':'').$noId;
                $temp=consulWishList($array,$lang);
                if ($temp!='no-deseo'){
                    $html.=$temp['body'];
                    $r2=$temp['result'];
               }
            }
            
            //$datosCar['resultUpdate']=$u; //STORE_WANT_TO_DO
            if (isset($r2) && is_array($r2)) $datosCar['result']=array_merge ($r,$r2);
            else $datosCar['result']=$r;
            $datosCar['noId']= $noId;
            
            if ($array['mobile']){
                if ($array['tipo']=='wish'){
                    $datosCar['emergency']=$htmlEmer;
                    $datosCar['body']= $html;   
                }else $datosCar['body']= $html;
            }else{
                if ($array['tipo']=='wish')$datosCar['body']= $htmlEmer.$html;
                else $datosCar['body']= $html;
            }
            return $datosCar;
        }
    }


    /********************************PRE - DATOS ***********************************/
    function common_data(){
    	return ('p.id,p.id_user AS seller,p.id_category,p.id_sub_category,
            (SELECT name FROM store_category WHERE id=p.id_category) AS category,
            (SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
            p.name,p.photo,p.place,p.stock,p.id_status,p.sale_points');
    }
    /********************************END - PRE - DATOS ***********************************/
    /********************************HTML***********************************/
    function wishList($row,$i,$lang,$array,$price){
    	$class='';$button='';$msg='';$delete='';$noSt='';
    	if ($row['stock']<=10 && $row['id_category']!='1'){
    		$class='class="color_red"';
    		$msg='&nbsp;&nbsp;'.(($row['stock']==0)?$lang["STORE_NOT_STOCK_LIST"]:$lang["STORE_MESSAGE_STOCK_LOW"]);
    	}
		if ($row['stock']>0){
			$button='<span class="button addToCar" style="margin: 5px 0;" h="'.md5($row['id']).'">'.$lang["STORE_ADDCART"].'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
			$noSt='noST';
		}
    	if ($array['tipo']!='prefe' && $array['tipo']!='aso')
    		$delete='<span class="deleteItemCar" action="deleteItemCar,'.md5($row['id']).',wish'.((isset($_GET['shop']))?',shop':',shop').'">'.$lang["NEWTAG_HELPDELETEBACKGROUNDTEMPLATE"].'</span>';
    	$html='<li class="carStore liVoid'.$i.' '.$noSt.'">
    				<div class="lis_product_store" style="background-image:url(\''.$row['photo'].'\')";></div>
				</li>
				<li class="carStoreDetails liVoid'.$i.' wish '.$noSt.'">
					<div class="lis_product_store_details">
						<span class="nameSP" action="detailProd,'.md5($row['id']).'">'.$row['name'].'</span><br>
						<span class="sellerSP" action="profile,'.md5($row['seller']).'"><strong>'.$lang["SELLER"].':</strong> '.$row['nameUser'].'</span><br>
						<span class="footer"><strong>'.$lang["STORE_CATEGORIES2"].':</strong> '.$row['category'];
		if ($row['id_category']!='1') 
			$html.= 	'<br><strong>'.$lang["STORE_CATEGORIES3"].':</strong> '.$row['subCategory'];
		$html.=     	'<br><strong>'.$lang["PRODUCTS_PRICE"].': </strong><span class="color_red_dark">'.$price.'</span>
						<br><strong>'.formatoCadena($lang["STORE_STOCK"]).': </strong><span '.$class.' >'.$row['stock'].$msg.'</span></span><br>'.$button.$delete.'
					</div>
				</li>';
		return $html; 
    }
    function mobileWishList($row,$lang,$array,$price){
		$delete='';$button='';
    	if ($array['tipo']!='prefe' && $array['tipo']!='aso')
    		$delete='<a func="delete" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f">
    					<span class="ui-btn-inner"><span class="ui-btn-text">'.$lang["STORE_REMOVEITEMSCTITLE"].'</span></span>
    				</a>';
    	if ($row['stock']>0)
    		$button='<a func="sendCart" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f">
    					<span class="ui-btn-inner"><span class="ui-btn-text">'.$lang["STORE_ADDCART"].'</span></span>
					</a>';
    	$html='<li id='.md5($row['id']).'>
    				<div class="contentItem">
    					<div class="itemPic"><img src="'.$row['photo'].'"/></div>
						<div class="itemDes">
							<div class="name">'.$row['name'].'</div>
							<div><strong>'.$lang["SELLER"].':</strong> '.$row['nameUser'].'</div>
							<div>'.$row['category'].' > '.$row['subCategory'].'</div>
							<div class="price">'.$lang["PRODUCTS_PRICE"].': '.$price.'</div>
							<div >'.$lang["STORE_STOCK"].': '.$row['stock'].'</div>
        				</div><br/>
        				<div class="buttons">
        					<a func="details" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f">
        						<span class="ui-btn-inner"><span class="ui-btn-text">'.$lang["STORE_VIEWDETAILS"].'</span></span>
    						</a>'.$delete.$button.'
    					</div>
                </li>';
        return $html;
    }
    /********************************END - HTML***********************************/
?>
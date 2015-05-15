<?php
include '../header.json.php';

	if (quitar_inyect()){
		if ($_GET['outShopping']!=1){

			$i = 0;
			$totalPrice = 0;
			$orderShopping = array();

			$detailsOrder = $GLOBALS['cn']->query('
					SELECT
						b.id_order AS id_order,
						b.id_product AS id_product,
						b.price AS price,
						c.id_user AS id_user,
						c.name AS nameProduct,
						c.photo AS photo,
						c.sale_points AS sale_points,
						c.place AS place,
						d.email AS email,
						d.name AS nameUser,
						d.last_name AS lastnameUser,
						a.date AS fecha
					FROM store_orders a
					INNER JOIN store_orders_detail b ON a.id = b.id_order
					INNER JOIN store_products c ON b.id_product = c.id
					INNER JOIN users d ON c.id_user = d.id
					WHERE md5(a.id) = "'.$_GET['nOrden'].'"
			');

			while($detailsOrders  = mysql_fetch_assoc($detailsOrder)){

					$detailsOrders['nameUser'] = formatoCadena($detailsOrders['nameUser']).' '.formatoCadena($detailsOrders['lastnameUser']);

//					if(($detailsOrders['place']=='1')||($detailsOrders['place']=='2')){
//
//						$photoWpanel = $GLOBALS['cn']->query('SELECT a.picture AS picture FROM store_products_picture a WHERE a.id_product = "'.$detailsOrders['id_product'].'" ORDER BY a.order');
//
//						while($photoWpanels = mysql_fetch_assoc($photoWpanel)){
//							$photo	= FILESERVER.'img/'.$photoWpanels['picture'];
//						}
//						if(fileExistsRemote($photo)){
//							$detailsOrders['photo'] = $photo;
//						}else{
//							$detailsOrders['photo'] = FILESERVER.'imgs/defaultAvatar.png';
//						}
//					}else{
						$photo	= FILESERVER.'img/'.$detailsOrders['photo'];
						if(fileExistsRemote($photo)){
							$detailsOrders['photo'] = $photo;
						}else{
							$detailsOrders['photo'] = FILESERVER.'imgs/defaultAvatar.png';
						}
//					}

					$totalPrice = $totalPrice + $detailsOrders['sale_points'];

					$orderShopping[] = $detailsOrders;
					$i++;
					$fechaOrder = $detailsOrders['fecha'];
					with_session(function(&$sesion){ unset($sesion['carrito']); });
			}
		}else{
			$totalPrice = 0;
			$orderShopping = 0;
			$i = 0;
			with_session(function(&$sesion){ unset($sesion['car']); });
		}

		$date=explode(' ',$fechaOrder);

		die(jsonp(array(
			'datosOrder' => $orderShopping,
			'nproduct'   => $i,
			'total'      => $totalPrice,
			'orderDate'  => $date[0]
		)));

	}//quitar_inyect
?>
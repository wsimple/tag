<?php
include '../header.json.php';

$arrayCate = array();
$arrayPhotos = array();

switch ($_GET['action']){
	//category	
	case 1:
		$category = $GLOBALS['cn']->query("
			SELECT 
				md5(a.id) AS id, 
				a.name AS name,
				a.photo	
			FROM store_category a 
			INNER JOIN store_sub_category b ON a.id = b.id_category 
			INNER JOIN store_products c ON c.id_category = a.id
			WHERE 
				c.id_user != '".$_SESSION['ws-tags']['ws-user']['id']."' 
				AND c.formPayment=0 
				AND (   SELECT SUM(p.id) 
						FROM store_products AS p
						WHERE p.id_category=a.id AND p.id_status=1 AND p.stock>0 AND p.id_user!='".$_SESSION['ws-tags']['ws-user']['id']."') > 0
			GROUP BY a.id
		");
		$i=0;
		while($categorys=mysql_fetch_assoc($category)){
			$arrayCate[$i]['id'] = $categorys['id'];
			// if ($categorys['photo']) $arrayCate[$i]['photo'] = $config->img_server.'css/tbum/storeCategory/'.$categorys['photo'];
			// else
				$arrayCate[$i]['photo']=$config->main_server.'css/tbum/storeCategory/category.png';
			$arrayCate[$i++]['name'] = utf8_encode(formatoCadena(lan($categorys['name'])));
		}
	break;
	//sub-category
	case 2:
		$category = $GLOBALS['cn']->query("
			SELECT 
				md5(a.id) AS id, 
				a.name AS name, 
				(	
					SELECT COUNT(x.id)
					FROM store_products x
					WHERE x.id_sub_category = a.id AND x.id_user != '".$_SESSION['ws-tags']['ws-user']['id']."' AND x.formPayment=0
				) AS cant
			FROM store_sub_category a 
			INNER JOIN store_products b ON b.id_sub_category = a.id
			WHERE
				md5(a.id_category) = '".$_GET['id']."' 
				AND b.id_user != '".$_SESSION['ws-tags']['ws-user']['id']."' 
				AND b.formPayment=0
				AND (   SELECT SUM(p.id) 
						FROM store_products AS p
						WHERE p.id_sub_category=a.id AND p.id_status=1 AND p.stock>0 AND p.id_user!='".$_SESSION['ws-tags']['ws-user']['id']."') > 0
			GROUP BY a.id
		");
		$i = 0;
		while($categorys  = mysql_fetch_assoc($category)){
			$arrayCate[$i]['id'] = $categorys['id'];
			$arrayCate[$i]['name'] = formatoCadena(lan($categorys['name']));
			$arrayCate[$i++]['cant'] = $categorys['cant'];
		}
	break;
	case 3:
		$arrayCate[0] = (isset($_SESSION['car'])&&count($_SESSION['car'])>0)?1:0;				
	break;
	//product detail
	case 4:
		$products = $GLOBALS['cn']->query("
			SELECT
				md5(p.id) AS id,
				p.id_status AS status,
				(SELECT CONCAT(u.name,' ',u.last_name) AS name FROM users u WHERE u.id=p.id_user LIMIT 1) AS sellerName,
				(SELECT name FROM store_category WHERE id=p.id_category LIMIT 1) AS category,
				(SELECT name FROM store_sub_category WHERE id=p.id_sub_category LIMIT 1) AS subCategory,
				p.name AS name,
				p.description AS description,
				p.sale_points AS cost,
				md5(p.id_category) AS mid_category,
				p.photo AS photo,
				p.place AS place,
				p.formPayment AS formPayment
			FROM store_products p
			WHERE md5(p.id) = '".$_GET['id']."'
			LIMIT 1
		");			
		$product = mysql_fetch_assoc($products);
		$product['sellerName'] = utf8_encode(formatoCadena($product['sellerName']));
		$product['category'] = utf8_encode(formatoCadena(lan($product['category'])));
		$product['subCategory'] = utf8_encode(formatoCadena(lan($product['subCategory'])));
		if ($product['place']=='1'){
			$photos = $GLOBALS['cn']->query("
				SELECT
					id,
					picture
				FROM store_products_picture
				WHERE md5(id_product) = '".$product['id']."'
				ORDER BY `order` DESC
			");
			$i=0;
			while ($photo = mysql_fetch_assoc($photos)){
				$arrayPhotos[$i]['id'] = md5($photo['id']);
				$arrayPhotos[$i++]['pic'] = FILESERVER.'img/'.$photo['picture'];
			}
		}else{
			$product['photo'] = FILESERVER.'img/'.$product['photo'];
		}
		$arrayCate[] = $product;
	break;
}
//output
die(jsonp(array(
	'data' => $arrayCate,
	'photos' => $arrayPhotos,
	'sCart' => (isset($_SESSION['car']) && count($_SESSION['car'])>0?true:false)
)));

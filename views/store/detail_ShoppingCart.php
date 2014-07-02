<div class="ui-single-box" style="height: 900px;">
<?php
function todoaqui(){
$backgrounds=array();
$product=array();
$sql='SELECT
		CONCAT(u.name, " ", u.last_name) AS name_user,
		u.username AS username,
		u.home_phone,
		u.mobile_phone,
		u.work_phone';
$pais=' ,p.name AS pais,
		c.name AS ciudad,
		u.zip_code,
		u.address AS direccion';
$join='INNER JOIN countries p ON p.id=u.country
		INNER JOIN cities c ON c.id=u.city';
$where='';
$limit='';
foreach ($_SESSION['car'] as $carrito){
	
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
	$product['cant']=1;
	
	if (isset($acumulado_pedido[$product['id_user']])){
		$i=  count($acumulado_pedido[$product['id_user']]['products']);
		$acumulado_pedido[$product['id_user']]['total_suma']=$acumulado_pedido[$product['id_user']]['total_suma']+$productCost;
		$acumulado_pedido[$product['id_user']]['email_seller']=$product['email_seller'];
		$acumulado_pedido[$product['id_user']]['place']=$product['place'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['id']=$product['id'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['id_user']=$product['id_user'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['name']=$product['name'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['photo']=$product['photo'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['place']=$product['place'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['price']=$product['sale_points'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['nameCate']=$product['nameC'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['nameSubCate']=$product['nameSC'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['id_category']=$product['id_category'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['id_sub_category']=$product['id_sub_category'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['cant']=$product['cant'];
		$acumulado_pedido[$product['id_user']]['products'][$i]['formPayment']=$product['formPayment'];
		if (!$backgrounds[$product['id_user']] && ($product['id_category']==1)) $backgrounds[$product['id_user']]=true;
		if (!$productSC[$product['id_user']] && ($product['id_category']!=1)) $productSC[$product['id_user']]=true;
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
		$acumulado_pedido[$product['id_user']]['products'][0]['price']=$product['sale_points'];
		$acumulado_pedido[$product['id_user']]['products'][0]['nameCate']=$product['nameC'];
		$acumulado_pedido[$product['id_user']]['products'][0]['nameSubCate']=$product['nameSC'];
		$acumulado_pedido[$product['id_user']]['products'][0]['id_category']=$product['id_category'];
		$acumulado_pedido[$product['id_user']]['products'][0]['id_sub_category']=$product['id_sub_category'];
		$acumulado_pedido[$product['id_user']]['products'][0]['cant']=$product['cant'];
		$acumulado_pedido[$product['id_user']]['products'][0]['formPayment']=$product['formPayment'];
		$backgrounds[$product['id_user']]=($product['id_category']==1)?true:false;
		$productSC[$product['id_user']]=($product['id_category']!=1)?true:false;
	}
				
}

$foto_remitente	=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'],'img/users/default.png');
	
	//datos de la cabecera del correo del usuario
	$query = $GLOBALS['cn']->query('
			
			FROM users u
			
			WHERE u.id = "'.$_SESSION['ws-tags']['ws-user']['id'].'"
			LIMIT 0,1;	
	');
	$array = mysql_fetch_assoc($query);

	if (trim($array['username'])!=''){

			$external=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.":&nbsp;<span ><a style='color:#999999' href='".DOMINIO.$array['username']."' onFocus='this.blur();' target='_blank'>".DOMINIO.$array['username']."</a><br>";
	}else {
		$external=  formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']);
	}
	if (trim($array[pais])!=''){

			$pais=USERS_BROWSERFRIENDSLABELCOUNTRY.":&nbsp;<span style='color:#999999'>".$array['pais']."</span><br/>";
	}
$emailComprador='<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; border-radius:7px; background: #fff; padding-top:25px;">
					<tr>
						<td style="height:30px; font-size: 20px; color:#999; font-weight:bold; text-align:center;"><?=STORE_PURCHASETITLE?> <br><br></td>
					</tr>';
$bodyEmail='';	
foreach ($acumulado_pedido as $acumulado){
	
	
	
	
	
	
	
	$emailSeller='<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; border-radius:7px; background: #fff; padding-top:25px;">
						<tr>
							<td style="height:30px; font-size: 24px; color:#999; font-weight:bold; text-align:center;"><strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'&nbsp;te&nbsp;ha&nbsp;echo&nbsp;una&nbsp;compra</strong><br><br></td>
						</tr>
						<tr>
							<td>
								<table style="width:100%;">
									<tr>
										<td style="padding-left:5px; font-size:14px; text-align:left">
											<img  src="'.$foto_remitente.'" border="0" width="60" height="60" style="border:3px solid #CCCCCC">
										</td>'
	
	
	
?>
	<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; border-radius:7px; background: #fff; padding-top:25px;">
		<tr>
			<td style="height:30px; font-size: 24px; color:#999; font-weight:bold; text-align:center;"><strong><?=formatoCadena($_SESSION['ws-tags']['ws-user']['full_name'])?>&nbsp;te&nbsp;ha&nbsp;echo&nbsp;una&nbsp;compra</strong><br><br></td>
		</tr>
		<tr>
			<td>
				<table style="width:100%;">
					<tr>
						<td style="padding-left:5px; font-size:14px; text-align:left">
							<img  src="<?=$foto_remitente?>" border="0" width="60" height="60" style="border:3px solid #CCCCCC">
						</td>
						<td width="569" style="padding-left:5px; padding-bottom:20px; font-size:12px; text-align:left;">
							<div>
									<strong><?=formatoCadena($external)?></strong><br>
									<?php if( $_SESSION['ws-tags']['ws-user']['type']=='0' ) { ?>
											<strong><?=ADDRESSBOOK_LBLHOMEPHOME?>:</strong><?=  formatoCadena($array['home_phone'])?><br>
									<?php } ?>
									<strong><?=SIGNUP_LBLEMAIL?></strong><?=formatoCadena($_SESSION['ws-tags']['ws-user']['email'])?><br>
									
							</div>
						</td>
					 </tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="height:30px; font-size: 16px; color:#999; font-weight:bold; text-align:left;"><?=STORE_SHIPPING?></td>
		</tr>
		<tr>
			<td>
				<table style="width:100%;">
					<tr>
						<td style="width: 120px;"><strong><?=BUSINESSCARD_LBLCOUNTRY?>:</strong></td>
						<td style="text-align: left;"><?=  formatoCadena($array['pais'])?></td>
					</tr>
					<tr>
						<td style="width: 120px;"><strong><?=BUSINESSCARD_LBLCITY?>:</strong></td>
						<td style="text-align: left;"><?=  formatoCadena($array['ciudad'])?></td>
					</tr>
					<tr>
						<td style="width: 120px;"><strong><?=BUSINESSCARD_LBLADDRESS?>:</strong></td>
						<td style="text-align: left;"><?=  formatoCadena($array['direccion'])?></td>
					</tr>
					<tr>
						<td style="width: 120px;"><strong><?=SIGNUP_ZIPCODE?>:</strong></td>
						<td style="text-align: left;"><?=  formatoCadena($array['zip_code'])?></td>
					</tr>
					<tr>
						<td style="width: 120px;"><strong><?=USERPROFILE_LBLMOBILEPHONE?>:</strong></td>
						<td style="text-align: left;"><?=  formatoCadena($array['mobile_phone'])?></td>
					</tr>
					<tr>
						<td style="width: 120px;"><strong><?=USERPROFILE_LBLWORKPHONE?>:</strong></td>
						<td style="text-align: left;"><?=  formatoCadena($array['work_phone'])?></td>
					</tr>
					
				</table>
			</td>
		</tr>
		<tr>
			<td style="height:30px; font-size: 20px; color:#999; font-weight:bold; text-align:center;"><?=STORE_PURCHASETITLE?> <br><br></td>
		</tr>
		<?php if ($backgrounds[$acumulado['id_user']]){ ?>
		<tr>
			<td style="height:30px; font-size: 16px; color:#999; font-weight:bold; text-align:left;"><?=TOUR_CREATIONMOREBACK_TITLE?> <br><br></td>
		</tr>
		<tr>
			<td><center>
				<table>
					<tr style="text-align:center">
						<td style="padding:5px; border-bottom:1px solid #F4F4F4; font-weight:bold; color:#AD3838;"><?=STORE_DETPRDDETAIL?></td>
						<td style="padding:5px; border-bottom:1px solid #F4F4F4;  "></td>
					</tr>
					<?php
					foreach ($acumulado['products'] as $ordenDetalles){
						if ($ordenDetalles['id_category']==1){
							if (($acumulado['place']==1)||($acumulado['place']==2)){
								$photoP = $GLOBALS['cn']->query('SELECT a.picture AS picture FROM store_products_picture a WHERE a.id_product = "'.$ordenDetalles['id'].'" ORDER BY a.order ASC LIMIT 0,1');
								$photoP=  mysql_fetch_assoc($photoP);
								$ordenDetalles['photo']=($acumulado['place']==1)?'store/'.$photoP['picture']:'templates/'.$photoP['picture'];
							}else{
								$ordenDetalles['photo']='templates/'.$photoP['picture'];
							}
					?>
					
							<tr style="text-align:center">
								<td style="padding:5px; border-bottom:1px solid #F4F4F4; border-right:1px solid #F4F4F4;">
								<img src="<?=FILESERVER.'img/'.$ordenDetalles['photo']?>" style="width:60px; height:60px;" /></td>
								<td style="border-bottom:1px solid #F4F4F4; border-right:1px solid #F4F4F4;text-align: left;width: 400px;">
									<strong><?=formatoCadena($ordenDetalles['name'])?></strong><br>
									<?=STORE_CATEGORIES2.': '.formatoCadena($ordenDetalles['nameCate'])?>
									<br><span style="color:#AD3838;"><?=(($ordenDetalles['formPayment']==1)?'$'.$ordenDetalles['price']:$ordenDetalles['price'].' '.STORE_TITLEPOINTS)?></span>&nbsp;&nbsp;<?=QUANTITYSTORE.': '.$ordenDetalles['cant']?>
								</td>
							</tr>
					
					<?php
						}
					}
					?>
					<?=$acumulado['id_user']?>
				</table></center>
			</td>
		</tr>
		<?php } 
			if ($productSC[$acumulado['id_user']]){
		?>
		<tr>
			<td style="height:30px; font-size: 16px; color:#999; font-weight:bold; text-align:left;"><?=TOUR_PRODUCT_TITLE?> <br><br></td>
		</tr>
		<tr>
			<td>
				<center>
					<table>
						<tr style="text-align:center">
							<td style="padding:5px; border-bottom:1px solid #F4F4F4; font-weight:bold; color:#AD3838;"><?=STORE_DETPRDDETAIL?></td>
							<td style="padding:5px; border-bottom:1px solid #F4F4F4;  "></td>
						</tr>
						<?php
						foreach ($acumulado['products'] as $ordenDetalles){
							if ($ordenDetalles['id_category']!=1){
								if (($acumulado['place']==1)||($acumulado['place']==2)){
									$photoP = $GLOBALS['cn']->query('SELECT a.picture AS picture FROM store_products_picture a WHERE a.id_product = "'.$ordenDetalles['id'].'" ORDER BY a.order ASC LIMIT 0,1');
									$photoP=  mysql_fetch_assoc($photoP);
									$ordenDetalles['photo']=($acumulado['place']==1)?'store/'.$photoP['picture']:'templates/'.$photoP['picture'];
								}else{
									$ordenDetalles['photo']='templates/'.$photoP['picture'];
								}
						?>

								<tr style="text-align:center">
									<td style="padding:5px; border-bottom:1px solid #F4F4F4; border-right:1px solid #F4F4F4;">
									<img src="<?=FILESERVER.'img/'.$ordenDetalles['photo']?>" style="width:60px; height:60px;" /></td>
									<td style="border-bottom:1px solid #F4F4F4; border-right:1px solid #F4F4F4;text-align: left;width: 400px;">
										<strong><?=formatoCadena($ordenDetalles['name'])?></strong><br>
										<?=STORE_CATEGORIES2.': '.formatoCadena($ordenDetalles['nameCate']).' '.STORE_CATEGORIES3.': '.formatoCadena($ordenDetalles['nameSubCate'])?>
										<br><span style="color:#AD3838;"><?=(($ordenDetalles['formPayment']==1)?'$'.$ordenDetalles['price']:$ordenDetalles['price'].' '.STORE_TITLEPOINTS)?></span>&nbsp;&nbsp;<?=QUANTITYSTORE.': '.$ordenDetalles['cant']?>
									</td>
								</tr>

						<?php
							}
						}
						?>
						<?=$acumulado['id_user']?>
					</table>
				</center>
			</td>
		</tr>
		<?php } ?>
	</table>
<?php
	}
}
?>
</div>
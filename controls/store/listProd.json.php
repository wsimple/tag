<?php 
	include '../header.json.php';
	$res=array();
	//variables necesarias para armar el select
	$where='';$from='';$limit='LIMIT '.$_GET['limit'].',9';$select='';$order='';$array['tipo']='prod';
	if(isset($_GET['scc'])){//si viene este get es porque son mis productos 
		if ($_SESSION['ws-tags']['ws-user']['type']!='1') die(jsonp(array('noB'=>true)));
		$where="p.id_user=".$_SESSION['ws-tags']['ws-user']['id']." ";
        if (isset($_GET['allProducts'])) $where.=" AND p.id_status=1 AND p.stock>0";
	}elseif(isset($_GET['srh']) && (strpos($_GET['srh'],',')!='')){ //busqueda general del sitio
		$where="p.id_status=1 AND p.stock>0";
	}elseif(isset($_GET['idp'])){//de lo contrario es el store
		$where="md5(p.id)='".$_GET['idp']."' ";
		$limit='LIMIT 1';
	}else{//de lo contrario es el store
		$where="p.id_status=1 AND p.stock>0 AND p.id_user!=".$_SESSION['ws-tags']['ws-user']['id']." ";
	}
	if($_GET['source']=='mobile'){ $where.=' AND p.formPayment=0 ';}
	

	//module store para la lista del store
	if($_GET['module']=='store'){
		$from='store_products p';
		$select=',p.formPayment AS pago';
		$array['storeList']=!isset ($_GET['scc'])?true:false;
		if(isset($_GET['radio'])){
			switch ($_GET['radio']){ 
				case 'points'   : $where.=' AND p.formPayment=0';	   break;
				case 'dollas'   : $where.=' AND p.formPayment=1';	   break;
				case 'moreC'	: $order='ORDER BY p.sale_points DESC '; break;
				case 'moreE'	: $order='ORDER BY p.sale_points ASC ';  break;
				case 'moreCp'   : $order='ORDER BY p.sale_points DESC '; $where.=' AND p.formPayment=0'; break;
				case 'moreEp'   : $order='ORDER BY p.sale_points ASC ';  $where.=' AND p.formPayment=0'; break;
				case 'moreCd'   : $order='ORDER BY p.sale_points DESC '; $where.=' AND p.formPayment=1'; break;
				case 'moreEd'   : $order='ORDER BY p.sale_points ASC ';  $where.=' AND p.formPayment=1'; break;
				case 'moreR'	: $order='ORDER BY p.hits ASC ';		 break;
			}
		}
	}elseif($_GET['module']=='raffle'){ //module raffle para la lista de rifas
		$from='store_products p INNER JOIN store_raffle c ON c.id_product=p.id';
		$select='   ,c.points AS points,
					c.start_date AS start_date,
					c.cant_users AS cant_users';
		if(isset ($_GET['my'])){
			$select.=',md5(c.id) AS id_raffle,c.end_date AS end_date';
			$where.= "AND c.id_user=".$_SESSION['ws-tags']['ws-user']['id']."";
		}else{ $where.= "AND c.status=1 AND c.id_user!=".$_SESSION['ws-tags']['ws-user']['id'].""; }
		if($_GET['myplays']){
			$select.=',c.end_date AS end_date';
			$from.=' JOIN store_raffle_join aj ON aj.id_raffle=c.id';
			$where='p.id_user!='.$_SESSION['ws-tags']['ws-user']['id'].'  
					AND aj.id_user='.$_SESSION['ws-tags']['ws-user']['id'].' 
					AND c.id_user!='.$_SESSION['ws-tags']['ws-user']['id'].'';
		}
	}
	//si viene la categoria se filtra por categoria y subcategoria
	if(isset($_GET['c'])){
		$where.=' AND ';
		if($_GET['sc']=='all') $where.="md5(p.id_category) = '".$_GET['c']."'";
		else $where.="  md5(p.id_sub_category) = '".$_GET['sc']."' 
						AND md5(p.id_category) = '".$_GET['c']."'";
	}
	if(isset($_GET['srh'])){ //si viene palabra de busqueda se filtra por bur busqueda
		$findhash=strpos($_GET['srh'],',');
		if($findhash!=''){
			$hash=explode(',',$_GET['srh']);
//				$where.=" AND CONCAT_WS( " ",p.name,  p.description) LIKE '%".$hash[0]."%'";
//				@$_SESSION['store']['temp']=$hash[0];
		}else{ 
			$hash[0]=$_GET['srh'];
//				$where.=" AND CONCAT_WS( " ",p.name,  p.description) LIKE '%".$_GET['srh']."%'"; 
//				@$_SESSION['store']['temp']=$_GET['srh'];
		}
		 $where.=" AND p.name LIKE '%".$hash[0]."%'"; 
		 @$_SESSION['store']['temp']=$hash[0];

	}elseif(isset($_GET['aso'])){ //aso de asocuacion para filtrar las sugerencias de productos
		if(count($_SESSION['car'])>0){
			$cadena='';$data='';
			foreach($_SESSION['car'] as $productC){
				if(!$productC['order']){
					$aux=split(' ',$productC['name']);
					foreach($aux as $aux_){
						if($aux_!='') $cadena.=($cadena=='')?$aux_:'|'.$aux_;
					}
					$data.=($data==''?'':',').$productC['id'];
				}
			}
			if($data!=''){
				$where.= " AND p.name REGEXP '".$cadena."'
							AND p.id NOT IN (".$data.") ";
				$array['noId']=$data;
			}
		}
		$order= ' ORDER BY RAND()';
		$array['tipo']='aso';
		$limit=' LIMIT 0,'.$_GET['limit'];
		$array['max']=$_GET['limit'];
	}elseif($_GET['rand']){ $order=' ORDER BY RAND()'; }
	if($where!='')	 $array['where']=$where;
	if($from!='')	  $array['from']=$from;
	if($limit!='' && !isset($_GET['allProducts']))	 $array['limit']=$limit;
	if($select!=''){   $array['select']=$select; $array['select_forma']=1; }
	if($select!=''){   $array['select']=$select; }
	if($order!='')	 $array['order']=$order;
	//consulta store 
	if(!isset($_GET['categoryJSON']) && !isset($_GET['noStore'])) $res=consulListProd($array);
	if($array['tipo']=='aso' && $res=='no-result'){

		$array['where']='   p.id_status=1 AND
							p.stock>0 AND
							p.id_user!="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND 
							p.id NOT IN ('.$array['noId'].')';
		$array['double']=true;
		$temp=consulListProd($array);
		if($temp!='no-result'){ $res=$temp; }
	}
	//consulta de categorias
	if(isset($_GET['categoryJSON'])){
		if (!PAYPAL_PAYMENTS){ $importantWhere.=' AND p.formPayment=0 ';}else $importantWhere='';
		$where="";$JOIN='';

		if(isset($_GET['scc'])){ // si viene este get es porque son mis productos 
			$where=" AND p.id_status=1 AND p.stock>0 AND p.id_user=".$_SESSION['ws-tags']['ws-user']['id'];
			if(isset($_GET['my'])){ $JOIN='INNER JOIN store_raffle r ON r.id_product = p.id '; }
			elseif($_GET['myplays']){
				$JOIN='INNER JOIN store_raffle r ON r.id_product = p.id INNER JOIN store_raffle_join aj ON aj.id_raffle=r.id ';
				$where=' AND p.id_status=1 AND p.id_user!='.$_SESSION['ws-tags']['ws-user']['id'].'  AND aj.id_user='.$_SESSION['ws-tags']['ws-user']['id'].' ';
			}
		}else{
			$where=" AND p.id_status=1 AND p.stock>0 AND p.id_user!=".$_SESSION['ws-tags']['ws-user']['id'];
			if($_GET['module']=='raffle'){
				$JOIN='JOIN store_raffle r ON r.id_product = p.id ';
				$where.=' AND r.status=1';
			}
		}
		if(isset($_GET['radio'])){
			switch($_GET['radio']){ 
				case 'points'   : $where.=' AND p.formPayment=0';	   break;
				case 'dollas'   : $where.=' AND p.formPayment=1';	   break;
				case 'moreCp'   : $where.=' AND p.formPayment=0';	   break;
				case 'moreEp'   : $where.=' AND p.formPayment=0';	   break;
				case 'moreCd'   : $where.=' AND p.formPayment=1';	   break;
				case 'moreEd'   : $where.=' AND p.formPayment=1';	   break;
			}
		}
		$array=array();
		$array['select']="
			md5(s.id) as mId,
			s.id as id,
			md5(s.id_category) as mId_category,
			s.id_category as id_category,
			c.photo,
			(SELECT COUNT(p.id) FROM store_products AS p $JOIN WHERE p.id_sub_category=s.id $where) AS cantProduc,
			s.name, c.name AS category_name
		";
		$array['from']=' store_sub_category AS s JOIN store_category AS c ON c.id=s.id_category ';
		$array['where']="   c.id_status=1 
							AND s.id_status=1 
							AND (   SELECT SUM(p.id) 
									FROM store_products AS p ".$JOIN."
									WHERE p.id_sub_category=s.id ".$where.$importantWhere.") > 0";
		$array['order']=' ORDER BY s.id ASC';
		$array['limit']=" ";$array['tipo']='category';
		$res=consulListProd($array);
	}
	//sugerencia de la wishlist
	if(!isset($_GET['categoryJSON']) && !isset($_GET['aso']) && (strpos($_GET['srh'],',')=='') && isset($_GET['sug'])){
		$where='p.id_status=1 AND 
				p.stock>0 AND
				p.id_user!="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND';
		if(isset($_GET['idp'])){
			$where.=' md5(p.id)!="'.$_GET['idp'].'" AND ';
		}
		if(isset($_SESSION['store']['wish'])){
			$sql='  SELECT p.name, p.id
					FROM store_orders o
					JOIN store_orders_detail od ON od.id_order=o.id
					JOIN store_products p ON p.id=od.id_product
					WHERE o.id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND 
					o.id_status=5 AND 
					od.id_status=5;';
			$result=$GLOBALS['cn']->query($sql);
			if(mysql_num_rows($result)>0){
				$data='';$array['noId']='';
				while($row=  mysql_fetch_assoc($result)){
					$aux=  split(' ', $row['name']);
					foreach($aux as $aux_){
						if($aux_!='') $data.=(($data=='')?'':'|').$aux_;
					}
					$array['noId'].=($array['noId']==''?'':',').$row['id'];
				}
				if(isset($_SESSION['car']) && $data!=''){
					foreach($_SESSION['car'] as $productC){
						if(!$productC['order'] && $productC['id']){ $array['noId'].=($array['noId']==''?'':',').$productC['id']; }
					}
				}
				if(isset($_GET['debug'])) echo '<br>'._imprimir($array).'<br><br>';
				if($data!=''){
					$array['where']= $where.' p.id NOT IN ('.$array['noId'].')
										AND p.name REGEXP "'.$data.'"';
					$array['limit']=' LIMIT 0,4';
					$array['tipo']='asoWish';
					$temp=consulListProd($array);
					if($temp!='no-result'){
						$res[$array['tipo']]=$temp[$array['tipo']];
					}
				}
			}
		}
		if(isset($_SESSION['store']['srh'])){
			$array['limit']=' LIMIT 0,4';$array['noId']='';
			$array['tipo']='asoSrh';
			if(isset($_SESSION['car']) && $data!=''){
				foreach($_SESSION['car'] as $productC){
					if(!$productC['order']){ $array['noId'].=($array['noId']==''?'':',').$productC['id']; }
				}
			}
			$array['where']=$where.' (p.name REGEXP "'.$_SESSION['store']['srh'].'")';
			if($array['noId']!=''){ $array['where'].=' AND p.id NOT IN ('.$array['noId'].')'; }
			$temp=consulListProd($array);
			if($temp!='no-result'){
				if (gettype($res)=='string') $res=array();
				$res[$array['tipo']]=$temp[$array['tipo']];
			}
		}
	}
	if($_GET['source']!='mobile'){
		if(isset($_GET['idp'])){
			if(isset($res['prod'][0]['description']) && $res['prod'][0]['description']!=''){
				$textTop=get_hashtags($res['prod'][0]['description']);
				$result=count($textTop);
				if($result>0){
					$textTop=explode(' ',implode(' ',$textTop));
					$res['hash']=$textTop;
				}   
			}
		}else{
			$textTop=vectorPhash($_GET['srh'],10);
			if($textTop!=''){
				$textTop=explode(' ',implode(' ',$textTop));
				$res['hash']=$textTop;
			} 
		} 
	}
	if (!is_array($res)) $res=array();
	$wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
	if (!$wid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
	if ($_SESSION['ws-tags']['ws-user']['type']==1)	$res['empre']=1;
	if ($_SESSION['ws-tags']['ws-user']['id']==$wid)	$res['adtb']=1;
	die(jsonp($res));
	function consulListProd($array){
		if (!PAYPAL_PAYMENTS && !isset($_GET['categoryJSON'])){ 
			$importantWhere.=' AND p.formPayment=0 ';
		}else $importantWhere='';
		$select="
			p.id,
			p.id_user,
			(SELECT CONCAT(a.name,' ',a.last_name) FROM users a WHERE a.id=p.id_user) AS seller,
			(SELECT a.email FROM users a WHERE a.id=p.id_user) AS eseller,
			(SELECT type FROM users a WHERE a.id=p.id_user) AS type_user,
			p.id_status AS status,
			(SELECT name FROM store_category WHERE id=p.id_category) AS category,
			(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
			p.name AS name,
			p.description AS description,
			p.sale_points AS cost,
			p.id_category,
			p.photo AS photo,
			p.stock AS stock,
			p.place AS place,
			p.video_url AS video,
			p.join_date AS join_date
		";
		$from=' store_products p';
		$where="";$order=" ORDER BY p.update_date DESC,p.id DESC ";$limit=" LIMIT ".$_GET['limit'].",9";

		if(isset($array['select'])){
			if($array['select_forma']==1){ $select.=$array['select'];}
			else{ $select=$array['select']; }
		}
		if(isset($array['from'])){ $from=$array['from']; }
		if(isset($array['where'])){ $where=$array['where']; }
		if(isset($array['limit']) && !isset($_GET['allProducts'])){ $limit=$array['limit']; }
		if(isset($array['order'])){ $order=$array['order']; }

		$sql='  SELECT '.$select.'
				FROM '.$from.'
				WHERE '.$where.$importantWhere.' '.$order.' '.$limit;
		if(isset($_GET['debug'])) echo '<br><br><div><pre>'.$sql.'</pre></div><br><br>'._imprimir($array).'<br><br>';
		$result=$GLOBALS['cn']->query($sql);
		$num=mysql_num_rows($result);
		if($num==0){ return 'no-result'; }
		else{ $products; $html='';$noId='';
			while($row=mysql_fetch_assoc($result)){
				if($array['tipo']=='category'){
					$row['category_name']=formatoCadena(@constant($row['category_name']));
					$row['sub_category_mId']=$row['mId'];
					$row['sub_category_id']=$row['id'];
					$row['sub_category_name']= formatoCadena(@constant($row['name']));
				}else{
					if ($row['eseller']=='wpanel@tagbum.com') $row['p_adtb'];
					elseif ($row['eseller']=='wpanel@tagbum.com') $row['p_adtb'];

					unset($row['eseller']);
					$noId.=($noId==''?'':',').$row['id'];
					$row['id']=md5($row['id']);
					$row['seller'] = formatoCadena($row['seller']);
					if(isset($_GET['raffle']) || $row['id_user']==$_SESSION['ws-tags']['ws-user']['id']){ $row['raffle']=true; }
					if($_GET['module']=='raffle'){
						if(isset ($_GET['my'])){ $row['my']=true; }
					}elseif ($_GET['module']=='store'){ if ($array['storeList']) $row['listStore']=true; }
					$row['category'] = formatoCadena(@constant($row['category']));
					$row['subCategory'] = formatoCadena(@constant($row['subCategory']));
					$row['name'] = formatoCadena($row['name']);
					$photo = FILESERVER.'img/'.$row['photo'];
					if(fileExistsRemote($photo)){ $row['photo'] = $photo; }
					else{ $row['photo'] = DOMINIO.'imgs/defaultAvatar.png'; }
					if($_GET['source']=='mobile'){
						$row['description'] = formatoCadena((strlen($row['description'])>300) ? substr($row['description'], 0,55)." ..." : $row['description']);
						$row['idse'] = $_SESSION['ws-tags']['ws-user']['id'];
						$row['titleList'] = $row['category'].' > '.$row['subCategory'];
						$row['mid_category'] = md5($row['id_category']);
						if($row['place']=='1' && isset($_GET['idp'])){
							$sqlPhoto=" SELECT id, picture
										FROM store_products_picture
										WHERE md5(id_product) = '".$row['id']."'
										ORDER BY `order` DESC";
							$photos = $GLOBALS['cn']->query($sqlPhoto);
							while ($photo = mysql_fetch_assoc($photos)){
								$photo['id'] = md5($photo['id']);
								if(fileExistsRemote(FILESERVER.'img/'.$photo['picture'])){ $photo['pic'] = FILESERVER.'img/'.$photo['picture']; }
								else{ $photo['pic'] = DOMINIO.'imgs/defaultAvatar.png'; }
								$photo['pic'] = FILESERVER.'img/'.$photo['picture'];
								$arrayPhotos[]=$photo;
							}
							$row['photo']=$arrayPhotos;
						}
					}else{ $row['description'] = $row['description']; }
					if($row['video']!=''){
						if(isVideo('vimeo',$row['video'])) $row['typeVideo']='vimeo';
						elseif(isVideo('youtube',$row['video'])){
							if($data['embed'])
								$row['video']=preg_replace(regex('youtube'), 'http://youtube.com/embed/$7$9', $row['video']);
							$row['typeVideo']='youtube';
						}
					}
				}
				$products[]=$row;
			}
			if(isset($array['max']) && $num<$array['max'] && !isset($array['double'])){
				if(isset($array['noId'])){ $array['noId']=$array['noId'].','.$noId; }
				else $array['noId']=$noId;
				$array['where']='   p.id_status=1 AND
									p.stock>0 AND
									p.id_user!="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND 
									p.id NOT IN ('.$array['noId'].')';
				$array['double']=true;
				$array['max']=$array['max']-$num;
				$array['limit']=' LIMIT 0,'.$array['max'];
				$temp=consulListProd($array);
				if($temp!='no-result'){
					$products=array_merge($products,$temp[$array['tipo']]);
					$num+=$temp['num'];
				}
			}
			if(isset($_SESSION['store']['temp'])){
				if(isset($_SESSION['store']['srh']) && $_SESSION['store']['temp']!=''){ 
					$vector=  explode('|', $_SESSION['store']['srh']);
					if(!in_array($_SESSION['store']['temp'],$vector)){
						$_SESSION['store']['srh'].='|'.$_SESSION['store']['temp']; 
					}
				}else{ $_SESSION['store']['srh']=$_SESSION['store']['temp']; }
				unset($_SESSION['store']['temp']);
			}
			$res[$array['tipo']]=$products;
			$res['num']=$num;
			return $res;
		}
	}
?>

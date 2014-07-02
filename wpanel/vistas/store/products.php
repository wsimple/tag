<?php

	define(NUMBOXES, 5);
	define(_PATH_, "../img/store/");
	define(IDUSR, 427);//id user wpanel inna cloud

	if (trim($_GET['delete'])=='0'){ 
			mensajes("This action isn\'t allowed in this section, because these items belong to purchases transactions. <br><br>From this moment, the item selected was put how <strong>\'Inactive\'</strong>", "?url=".$_GET['url'], "info");
	}
	
	if ($_REQUEST['action']!=''){
		$imagesAllowed = array('jpg','jpeg','png','PNG');
		switch ($_REQUEST['action']){
			case 'insert':
				mysql_query("INSERT INTO store_products SET 
					id_user = '".IDUSR."',
					id_status = '".$_REQUEST['status']."',
					id_category = '".$_REQUEST['category']."',	
					id_sub_category = '".$_REQUEST['sub_category']."',
					name = '".$_REQUEST['name']."',
					description = '".$_REQUEST['description']."',
					stock = '".$_REQUEST['stock']."',
					sale_points = '".$_REQUEST['points']."',
					photo = '',
					join_date = '".date('Y-m-d')."',
					place = '1'
				") or die ('(13): '.mysql_error());
				$id_banner = mysql_insert_id();
				$folder = md5($id_banner);
				for($i=0;$i<NUMBOXES;$i++){
					$parts = explode('.', $_FILES['photo'.$i]['name']);
					$ext = strtolower(end($parts));
					if (in_array($ext,$imagesAllowed)){
						$path  = _PATH_.$folder."/";
						$photo = md5(str_replace(' ', '', $_FILES['photo'.$i]['name']).microtime()+$i).'.'.$ext;
						//existencia de la folder
						if (!is_dir ($path)){	
							$old = umask(0);
							mkdir($path,0777);
							umask($old);
							$fp=fopen($path.'index.html',"w");
							fclose($fp);
						}// is_dir
						if (getRedime($_FILES['photo'.$i][tmp_name], $path.$photo, 650)){
							uploadFTP($photo,"store","../",1,$folder);
							//insert
							mysql_query("
								INSERT INTO store_products_picture SET
									id = '".$i."',
									id_product = '".$id_banner."',
									picture = 'store/".$folder.'/'.$photo."',
									`order` = '".$_REQUEST['order'.$i]."',
									status = '1'	
							") or die ('(48): '.mysql_error());							
						}
					}//in_array					
				}//for
			break;
			
			case 'update':
				$id_banner = $_REQUEST['id_consulta'];
				$folder = md5($id_banner);
				for($i=0;$i<=NUMBOXES;$i++){
					mysql_query("
						UPDATE store_products SET 
							id_user = '".IDUSR."',
							id_status = '".$_REQUEST['status']."',
							id_category = '".$_REQUEST['category']."',	
							id_sub_category = '".$_REQUEST['sub_category']."',
							name = '".$_REQUEST['name']."',
							description = '".$_REQUEST['description']."',
							stock = '".$_REQUEST['stock']."',
							sale_points = '".$_REQUEST['points']."',
							photo = '',
							update_date = '".date('Y-m-d')."',
							place = '1'
						WHERE id = '".$id_banner."' 
					") or die ('(68): '.mysql_error());
					mysql_query("
						UPDATE store_products_picture SET
							`order` = '".$_REQUEST['order'.$i]."'
						WHERE id_product = '".$id_banner."' AND `order` = '".$i."'
					") or die ('(83): '.mysql_error());
				    if ($_FILES['photo'.$i]['error'] == 0){
						$imagesAllowed = array('jpg','jpeg','png','PNG');
						$parts = explode('.', $_FILES['photo'.$i]['name']);
						$ext = strtolower(end($parts));
						if (in_array($ext,$imagesAllowed)){
							$path  = _PATH_.$folder."/";
							$photo = md5(str_replace(' ', '', $_FILES['photo'.$i]['name']).microtime().microtime()).'.'.$ext;
							//existencia de la folder
							if (!is_dir ($path)){	
								$old = umask(0);
								mkdir($path,0777);
								umask($old);
								$fp=fopen($path.'index.html',"w");
								fclose($fp);
							}// is_dir		
							//antigua foto
							$query = mysql_query("
								SELECT
									picture
								FROM store_products_picture
								WHERE id_product = '".$id_banner."' AND id = '".$i."'
							") or die (mysql_error());
							$array = mysql_fetch_assoc($query);
							$old_pic = $array['picture'];
							//upload
							if (getRedime($_FILES['photo'.$i][tmp_name], $path.$photo, 650)){
								if ($old_pic!='') deleteFTP($old_pic,'store');	
								uploadFTP($photo,"store","../",1,$folder);		
								//insert
								if (mysql_num_rows($query)>0){
									mysql_query("
										UPDATE store_products_picture SET
											picture = 'store/".$folder.'/'.$photo."',
											`order` = '".$_REQUEST['order'.$i]."'
										WHERE id_product = '".$id_banner."' AND id = '".$i."'
									") or die ('Update photos (104): '.mysql_error());
								}else{
									mysql_query("
										INSERT INTO store_products_picture SET
											id = '".$i."',
											id_product = '".$id_banner."',
											picture = 'store/".$folder.'/'.$photo."',
											`order` = '".$_REQUEST['order'.$i]."',
											status = '1'	
									") or die ('Insert photos (130): '.mysql_error());	
								}
							}//upload
						}//in_array
					}//if
				}//for		
			break;
		 }//switch
		 
		 $query = mysql_query("
			 SELECT
				picture
			 FROM store_products_picture  
			 WHERE id_product = '".$id_banner."'
			 ORDER BY `order` 
			 LIMIT 1
		 ") or die (mysql_error());
		 $array = mysql_fetch_assoc($query);
		 mysql_query("
			 UPDATE store_products SET
				photo = '".$array['picture']."' 
			 WHERE id = '".$id_banner."'
		 ") or die (mysql_error());
		 mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
	 }//action
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
			<?php
				$frm = new formulario('Manage Products Store', '?url='.$_GET[url], 'Send', 'Manage Products Store', $metodo='post');
				$frm->inicio();
				$where = '';
				
				if ($_REQUEST['id_consulta']!=''){
					$frm->consulta=true;
					$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
					
					$category = "
						SELECT 
							id AS valor, 
							(select b.text from translations_template b where b.id=store_category.id_template) AS descripcion 
						FROM store_category 
						WHERE id != '1'
						| AND 
						
						".($_GET['_category_']!=""?" id = '".$_GET['_category_']."' ":" id = '".campo("store_products", "id", $_REQUEST['id_consulta'], 3)."' ")."	
					";

					$sub_category = "
						SELECT 
							id AS valor, 
							(select b.text from translations_template b where b.id=store_sub_category.id_template) AS descripcion 
						FROM store_sub_category 
						WHERE ".($_GET['_category_']!=''?" id_category='".$_GET['_category_']."' ":" 1 ")."
						| AND 
						id = '".campo("store_products", "id", $_REQUEST['id_consulta'], 4)."'
					";
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
						| AND 
						id = '".campo("store_products", "id", $_REQUEST['id_consulta'], 2)."'
					";
				}else{
					$category = "
						SELECT 
							id AS valor, 
							(select b.text from translations_template b where b.id=store_category.id_template) AS descripcion 
						FROM store_category 
						WHERE id_status = '1' AND id != '1'
							
						".($_GET['_category_']!=''?" | AND id = '".$_GET['_category_']."' ":"")."
					";
					$sub_category = "
						SELECT 
							id AS valor, 
							(select b.text from translations_template b where b.id=store_sub_category.id_template) AS descripcion 
						FROM store_sub_category 
						WHERE id_status = '1' ".($_GET['_category_']!=''?" AND id_category='".$_GET['_category_']."' ":"")."
					";
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
					";
				}
				
				$frm->selects(array("category"=>$category));
				$frm->selects(array("sub_category"=>$sub_category));
				
				$frm->inputs("
					SELECT 
						name AS name_1,
						stock AS stock_1,
						sale_points AS points_1,
						description AS description_1
						
					FROM store_products
					$where
				");
				  
				$frm->selects(array("status"=>$status));
				
				$frm->insertColspan();
				
				$frm->insertTitle('Photo control');
				
				$frm->insertColspan();
				
				for ($i=1; $i<=NUMBOXES; $i++){
					$photos = mysql_query("
						SELECT 
							picture,
							`order`
						FROM store_products_picture 
						WHERE id_product = '".$_REQUEST['id_consulta']."' AND id = '".$i."'
					") or die (mysql_error());
					$photo = mysql_fetch_assoc($photos);
					
					$td_photo = '
						<input type="file" id="photo'.$i.'" name="photo'.$i.'" /> &raquo; Order:
						<input id="order'.$i.'" name="order'.$i.'" type="text" size="4" value="'.($photo['order']!=''?$photo['order']:$i).'" />
					';
					
					if (mysql_num_rows($photos)>0 && $_REQUEST['id_consulta']!='' && empty($_REQUEST['action'])){
						$td_photo .= '
							<br>
							<img src="'.FILESERVER.'img/'.$photo['picture'].'" height="100" style="margin:2px 0 2px 3px; border:1px solid #ccc" />
						';
					}
					$frm->insertHtml('Photo ('.$i.')', $td_photo);
				}//for
				
				$frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));
				$frm->hidden('url',$_GET[url]);
				$frm->fin(false);  	
            ?>
        </td>
    </tr>
    <tr>
        <td>
			<?php
				$frm->grilla("
					SELECT
						id,
						
						(
							SELECT b.text
							FROM store_category a JOIN translations_template b ON a.id_template=b.id
							WHERE store_products.id_category = a.id
							
						) AS category,
						
						(
							SELECT b.text
							FROM store_sub_category a JOIN translations_template b ON a.id_template=b.id
							WHERE store_products.id_sub_category = a.id
						) AS subCategory,
						
						name,
						join_date,
						update_date,
			
						(
							SELECT c.name 
							FROM status c 
							WHERE c.id=store_products.id_status
						) AS status
						
					FROM store_products
					WHERE id_category != '1'
					ORDER BY name			
				",1);
            ?>
        </td>
    </tr>
</table>
<script type="text/javascript">
	window.addEvent('domready', function() {
		$('primero').addEvent('change', function(){
			var url = 'index.php?url=<?=$_GET['url']?>';
			url += '&_category_='+this.value;
			url += '<?=(($_GET['id_consulta']!='')?'&id_consulta='.$_GET['id_consulta']:'')?>';
			window.location = url;
		});
	});
</script>
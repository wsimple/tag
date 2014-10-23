<?php

	define(NUMBOXES, 5);
	define (_PATH_, "../img/publicity/banners/");
	
//	if (in_array($_SERVER['SERVER_NAME'],array('64.15.140.154','tagbum.com','www.tagbum.com'))){
//		define (_PATH_, "../newDesign/img/publicity/banners/");
//	}else{
//		define (_PATH_, "../img/publicity/banners/");
//	}
//	
//	
	if ($_REQUEST['del']=='1'){
		//_imprimir($_REQUEST);
		$query = mysql_query("SELECT * FROM banners_picture WHERE id = '".$_REQUEST['id']."' AND id_banner = '".$_REQUEST['ba']."' ");
		$array = mysql_fetch_assoc($query);
		//_imprimir($array);
		//echo '../img/publicity/banners/'.$array['picture'];
		mysql_query("DELETE FROM banners_picture WHERE id = '".$_REQUEST['id']."' AND id_banner = '".$_REQUEST['ba']."' ");
		unlink('../img/publicity/banners/'.$array['picture']);
		mensajes("Sucessfully Process", "?url=".$_REQUEST[url]."&id_consulta=".$_REQUEST['ba'], "info");
	}
	
	if ($_REQUEST['action']!=''){
		//print_r($_REQUEST);die();
		$imagesAllowed = array('jpg','jpeg','png','PNG');
		
		switch ($_REQUEST['action']){
			case 'insert':
				mysql_query("INSERT INTO banners SET 
					id_type = '".$_REQUEST['place']."',
					title = '".$_REQUEST['title']."',
					link = '".$_REQUEST['link']."',
					status = '".$_REQUEST['status']."'
				") or die ('Insert banner (16): '.mysql_error());
				
				$id_banner = mysql_insert_id();
				
				if ($_REQUEST['place'] == '3') {
					$pieces = explode(";", $_REQUEST['text']);
					foreach ($pieces as $order => $piece) {
						mysql_query("INSERT INTO banners_picture SET
								id_banner = '".$id_banner."',
								order = '$order',
								text = '$piece',
								status = '1'	
						") or die ('Insert text (41): '.mysql_error());
					}
				}else{
					for($i=0;$i<NUMBOXES;$i++){
						$parts = explode('.', $_FILES['photo'.$i]['name']);
						$ext = strtolower(end($parts));
					
						if (in_array($ext,$imagesAllowed)){
							$path  = _PATH_.$id_banner."/";
							$photo = md5(str_replace(' ', '', $_FILES['photo'.$i]['name']).microtime()+$i).'.'.$ext;
							
							//existencia de la folder
							if (!is_dir ($path)){	
								$old = umask(0);
								mkdir($path,0777);
								umask($old);
								$fp=fopen($path.'index.html',"w");
								fclose($fp);
							}// is_dir
							
							if (copy($_FILES['photo'.$i]['tmp_name'], $path.$photo)){
								//redimensionar($path.$photo, $path.$photo, 650);
								//insert
								mysql_query("
									INSERT INTO banners_picture SET
										id = '".$i."',
										id_banner = '".$id_banner."',
										picture = '".$id_banner.'/'.$photo."',
										`order` = '".$_REQUEST['order'.$i]."',
										status = '1'	
								") or die ('Insert photos (41): '.mysql_error());
							}//copy
						}//in_array					
					}//for
				}
				
			break;
			
			case 'update':
				
				$id_banner = $_REQUEST['id_consulta'];
				
				for($i=0;$i<=NUMBOXES;$i++){
				
				
					mysql_query("
						UPDATE banners SET 
							id_type = '".$_REQUEST['place']."',
							title = '".$_REQUEST['title']."',
							link = '".$_REQUEST['link']."',
							status = '".$_REQUEST['status']."'
						WHERE id = '".$id_banner."'
					") or die ('Update banner (60): '.mysql_error());
					
					mysql_query("
						UPDATE banners_picture SET
							`order` = '".$_REQUEST['order'.$i]."'
						WHERE id_banner = '".$id_banner."' AND `order` = '".$i."'
					") or die ('Update photos (69): '.mysql_error());
					
					
				    if ($_FILES['photo'.$i]['error'] == 0){
						$imagesAllowed = array('jpg','jpeg','png','PNG');
						$parts = explode('.', $_FILES['photo'.$i]['name']);
						$ext = strtolower(end($parts));

						if (in_array($ext,$imagesAllowed)){
							$path  = _PATH_.$id_banner."/";
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
								FROM banners_picture
								WHERE id_banner = '".$id_banner."' AND id = '".$i."'
							") or die (mysql_error());
							$array = mysql_fetch_assoc($query);
							$old_pic = $array['picture'];
							
							//upload
							if (copy($_FILES['photo'.$i]['tmp_name'], $path.$photo)){
								//redimensionar($path.$photo, $path.$photo, 650);
								if ($old_pic!='') unlink(_PATH_.$old_pic);
								//bd
								if (mysql_num_rows($query)>0){
									mysql_query("
										UPDATE banners_picture SET
											picture = '".$id_banner.'/'.$photo."',
											`order` = '".$_REQUEST['order'.$i]."'
										WHERE id_banner = '".$id_banner."' AND id = '".$i."'
									") or die ('Update photos (104): '.mysql_error());
								}else{
									mysql_query("
										INSERT INTO banners_picture SET
											id = '".$i."',
											id_banner = '".$id_banner."',
											picture = '".$id_banner.'/'.$photo."',
											`order` = '".$_REQUEST['order'.$i]."',
											status = '1'	
									") or die ('Insert photos (110): '.mysql_error());	
								}
							}//copy
						}//in_array
					}//if
				}//for
				
			break;
		
		 }//switch
		 
		 mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
		 
	 }//action
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
			<?php
				$frm = new formulario('Manage Banners', '?url='.$_GET[url], 'Send', 'Manage Banners', $metodo='post');
				$frm->inicio();
				$where = '';
				
				if ($_REQUEST['id_consulta']!=''){
					$frm->consulta=true;
					$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
					$place = "
						SELECT 
							id AS valor, 
							name AS descripcion 
						FROM type_banners 
						WHERE status = '1'
						| AND 
						id = '".campo("banners", "status", $_REQUEST['id_consulta'], 2)."'
					";
					//cboBoxs
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
						| AND 
						id = '".campo("banners", "status", $_REQUEST['id_consulta'], 1)."'
					";
				}else{
					$place = "
						SELECT 
							id AS valor, 
							name AS descripcion 
						FROM type_banners 
						WHERE status = '1'
					";
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
					";
				}
				$frm->inputs("
					SELECT 
						title AS title_1,
						link AS link_1
					FROM banners
					$where
				");
				  
				$frm->selects(array("place"=>$place));
				$frm->selects(array("status"=>$status));
				// $frm->selects(array( 'option'=>array( 
				// 	'1|Text',
				// 	'2|Image'
				// )) );

				//Texto del banner
				// $frm->insertColspan();
				// $frm->insertTitle('Text control(Only Top Side Banners)');
				// $frm->insertColspan();
				// $frm->insertFCKEditor('text');
				// $frm->inputs("SELECT text,class AS CSS_Class FROM banners_picture 
				// 			  WHERE id_banner = '".$_REQUEST['id_consulta']."' "
				// 			);

				//Imagenes del baner
				$frm->insertColspan();
				$frm->insertTitle('Photo control');
				$frm->insertColspan();
				for ($i=1; $i<=NUMBOXES; $i++){
					$photos = mysql_query("
						SELECT 
							picture,
							`order`
						FROM banners_picture 
						WHERE id_banner = '".$_REQUEST['id_consulta']."' AND id = '".$i."'
					") or die (mysql_error());
					$photo = mysql_fetch_assoc($photos);
					
					
					$td_photo = '
						<input type="file" id="photo'.$i.'" name="photo'.$i.'" /> &raquo; Order:
						<input id="order'.$i.'" name="order'.$i.'" type="text" size="4" value="'.($photo['order']!=''?$photo['order']:$i).'" />
					';
					
					if (mysql_num_rows($photos)>0 && $_REQUEST['id_consulta']!='' && empty($_REQUEST['action'])){
						$td_photo .= '
							<br>
							<img src="'._PATH_.$photo['picture'].'" width="400" style="margin:2px 0 2px 3px; border:1px solid #ccc" />
							<a href="?url='.$_REQUEST[url].'&del=1&id='.$i.'&ba='.$_REQUEST['id_consulta'].'">Delete</a>
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
						title,
						(select b.name from type_banners b where b.id=banners.id_type) AS place,
						(select c.name from status c where c.id=banners.status) AS status
						
					FROM banners
					ORDER BY title			
				",1);
            ?>
        </td>
    </tr>
</table>
<?php

	if (trim($_GET['delete'])=='0'){ 
			mensajes("This action isn\'t allowed in this section, because these items belong to purchases transactions. <br><br>From this moment, the item selected was put how <strong>\'Inactive\'</strong>", "?url=".$_GET['url'], "info");
	} 

	if ($_REQUEST['action']!=''){
		
		$text = strtolower($_REQUEST['name']);
        $text2 = strtolower($_REQUEST['summary']);
		$out = array(
			"msg" => "Category already exists.",
			"type" => "error"
		);
		
		//label language 
		$paso = true;
		do{
			$label_n = 'GROUPS_CATEGORY'.'_'.md5(microtime()*microtime());
			if (existe("translations_template", "label", "WHERE label LIKE '".$label_n."'"))
				$paso = false;
		}while($paso==false);
		do{
			$label_s = 'GROUPS_CATEGORY'.'_'.md5(microtime()*microtime());
			if (existe("translations_template", "label", "WHERE label LIKE '".$label_s."'"))
				$paso = false;
		}while($paso==false);
		switch ($_REQUEST['action']){
			case 'insert':
				if ($paso){
					//validate
					$validate = mysql_query("
						SELECT id
						FROM translations_template
						WHERE text LIKE '".$text."' AND id_lenguage = '1' AND section = '32'
					") or die (mysql_error());
					if (mysql_num_rows($validate)==0){
						//language
						mysql_query("INSERT INTO translations_template SET 
							id_lenguage = '1',
							section = '32',
							label = '".$label_n."',
							text = '".strtolower($_REQUEST['name'])."',
							text_help = ''
						") or die ('(30): '.mysql_error());
                        $id_template_n=mysql_insert_id();
                        //language
						mysql_query("INSERT INTO translations_template SET 
							id_lenguage = '1',
							section = '32',
							label = '".$label_s."',
							text = '".strtolower($_REQUEST['summary'])."',
							text_help = ''
						") or die ('(30): '.mysql_error());
                        $id_template_s=mysql_insert_id();
						//category
						mysql_query("INSERT INTO groups_category SET 
							name = '".$label_n."',
                            summary = '".$label_s."',
							id_status = '".$_REQUEST['status']."',
							id_template = '".$id_template_n."',
                            id_template_sum = '".$id_template_s."'
						") or die ('(38): '.mysql_error());
						//out
						$out = array(
							"msg" => "Sucessfully Process.",
							"type" => "info"
						);
                        $id_category=mysql_insert_id();
                        $parts = explode('.', $_FILES['photo']['name']);
						$ext = strtolower(end($parts));
                        $imagesAllowed = array('jpg','jpeg','png','PNG');
						if (in_array($ext,$imagesAllowed)){
							$path  = "../img/groups/category/".$id_category."/";
							$photo = md5(str_replace(' ', '', $_FILES['photo']['name']).microtime()).'.'.$ext;
							
							//existencia de la folder
							if (!is_dir ($path)){	
								$old = umask(0);
								mkdir($path,0777);
								umask($old);
								$fp=fopen($path.'index.html',"w");
								fclose($fp);
							}// is_dir
							
							if (copy($_FILES['photo']['tmp_name'], $path.$photo)){
								//redimensionar($path.$photo, $path.$photo, 650);
								//insert
								mysql_query("
									UPDATE groups_category SET
										icon = '".$id_category.'/'.$photo."'
									WHERE id='".$id_category."';	
								") or die ('Insert photos (41): '.mysql_error());
							}//copy
						}//in_array	
                        
					}//validate
				}//paso
			break;
		
			case 'update':
				if ($paso){
					$query = mysql_query("
						SELECT id,id_template,id_template_sum
						FROM groups_category
						WHERE id = '".$_REQUEST['id_consulta']."'
					") or die ('(54): '.mysql_error());
					$array = mysql_fetch_assoc($query);

					//validate
					$validate = mysql_query("
						SELECT id
						FROM translations_template
						WHERE text LIKE '".$text."' AND id = '".$array['id_template']."'
					") or die (mysql_error());

					//language
					if (mysql_num_rows($validate)==0){
						mysql_query("
							UPDATE translations_template SET 
								text = '".$text."'
							WHERE id = '".$array['id_template']."'
						") or die ('(35): '.mysql_error());
					}
                    //validate
					$validate = mysql_query("
						SELECT id
						FROM translations_template
						WHERE text LIKE '".$text2."' AND id = '".$array['id_template_sum']."'
					") or die (mysql_error());

					//language
					if (mysql_num_rows($validate)==0){
						mysql_query("
							UPDATE translations_template SET 
								text = '".$text2."'
							WHERE id = '".$array['id_template_sum']."'
						") or die ('(35): '.mysql_error());
					}

					//category
					mysql_query("
						UPDATE groups_category SET 
							id_status = '".$_REQUEST['status']."'
						WHERE id = '".$_REQUEST['id_consulta']."'
					");
                    $id_category=$_REQUEST['id_consulta'];
                    $parts = explode('.', $_FILES['photo']['name']);
					$ext = strtolower(end($parts));
                    $imagesAllowed = array('jpg','jpeg','png','PNG');
					if (in_array($ext,$imagesAllowed)){
						$path  = "../img/groups/category/".$id_category."/";
						$photo = md5(str_replace(' ', '', $_FILES['photo']['name']).microtime()).'.'.$ext;
						
						//existencia de la folder
						if (!is_dir ($path)){	
							$old = umask(0);
							mkdir($path,0777);
							umask($old);
							$fp=fopen($path.'index.html',"w");
							fclose($fp);
						}// is_dir
						
						if (copy($_FILES['photo']['tmp_name'], $path.$photo)){
							//redimensionar($path.$photo, $path.$photo, 650);
							//insert
							mysql_query("
								UPDATE groups_category SET
									icon = '".$id_category.'/'.$photo."'
								WHERE id='".$id_category."';	
							") or die ('Insert photos (41): '.mysql_error());
						}//copy
					}//in_array	
				}//paso
				
				//out
				$out = array(
					"msg" => "Sucessfully Process.",
					"type" => "info"
				);
                
			break;
		}
		
		mensajes($out['msg'], "?url=".$_REQUEST['url'], $out['type']);
		//_imprimir($out); 
	}//action
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
			<?php
				$frm = new formulario('Groups - Category', '?url='.$_GET['url'], 'Send', 'Groups - Category', $metodo='post');
				$frm->inicio();
				$where = '';
				
				if ($_REQUEST['id_consulta']!=''){
					$frm->consulta=true;
					$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 					$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
						| AND 
						id = '".campo("groups_category", "id", $_REQUEST['id_consulta'],'id')."'
					";
				}else{
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
						name AS name_1,
                        (   SELECT text
                			FROM translations_template a INNER JOIN groups_category b ON a.id=b.id_template_sum
                			WHERE b.id = '".(isset($_REQUEST['id_consulta'])?$_REQUEST['id_consulta']:'0')."'
                			LIMIT 1) summary_1
						
					FROM groups_category
					$where
				");

                  
				$frm->selects(array("status"=>$status));
                $photos = mysql_query("
					SELECT 
						icon AS photo
					FROM groups_category 
					WHERE id = '".$_REQUEST['id_consulta']."'
				") or die (mysql_error());
				$photo = mysql_fetch_assoc($photos);
				
				
				$td_photo = '
					<input type="file" id="photo" name="photo" />
				';
				
				if (mysql_num_rows($photos)>0 && $_REQUEST['id_consulta']!='' && empty($_REQUEST['action'])){
					$td_photo .= '
						<br>
						<img src="../img/groups/category/'.$photo['photo'].'" width="200" style="margin:2px 0 2px 3px; border:1px solid #ccc" />
					';
				}
				$frm->insertHtml('Photo', $td_photo);
				$frm->hidden('action',(($_REQUEST['id_consulta']!='')?'update':'insert'));
				$frm->hidden('id_consulta',$_REQUEST['id_consulta']);
				$frm->hidden('url',$_GET['url']);
				$frm->fin(false);  	
            ?>
        </td>
    </tr>
    <tr>
        <td>
			<?php
				$frm->grilla("
					SELECT
						groups_category.id AS id,
						(select c.text from translations_template c where c.id=groups_category.id_template) AS name,
                        (select c.text from translations_template c where c.id=groups_category.id_template_sum) AS summary,
						(select b.name from status b where b.id=groups_category.id_status) AS status						
					FROM groups_category
					WHERE groups_category.id != '1'
					ORDER BY groups_category.name			
				",1);
            ?>
        </td>
    </tr>
</table>
<?php 
	//replace name by template_name
	if ($_REQUEST['id_consulta']!=''){
		$query = mysql_query("
			SELECT text
			FROM translations_template a INNER JOIN groups_category b ON a.id=b.id_template
			WHERE b.id = '".$_REQUEST['id_consulta']."'
			LIMIT 1
		");
		$array = mysql_fetch_assoc($query);
		echo "
			<script>
			document.getElementById('primero').value = '".$array['text']."';
			</script>
		";
	} 
?>
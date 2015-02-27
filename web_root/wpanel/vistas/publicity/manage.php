<?php

//	if (in_array($_SERVER['SERVER_NAME'],array('64.15.140.154','tagbum.com','www.tagbum.com'))){
//		define (_PATH_, "../newDesign/img/publicity/wpanel/");
//	}else{
//		define (_PATH_, "../img/publicity/wpanel/");
//	}
	
	define (_PATH_, "../img/publicity/wpanel/");
	if ($_REQUEST['action']!=''){
		switch ($_REQUEST['action']){
			case 'insert':
				$imagesAllowed = array('jpg','jpeg','png','PNG');
				$parts = explode('.', $_FILES[photo][name]);
			    $ext = strtolower(end($parts));
				
				if (in_array($ext,$imagesAllowed)){
					$path  = _PATH_;
					$photo = md5(str_replace(' ', '', $_FILES[photo][name]).microtime()).'.jpg';
					
					//existencia de la folder
					if (!is_dir ($path)){	
						$old = umask(0);
						mkdir($path,0777);
						umask($old);
						$fp=fopen($path.'index.html',"w");
						fclose($fp);
					}// is_dir
					
					if (copy($_FILES[photo][tmp_name], $path.$photo)){
						//redimensionar($path.$photo, $path.$photo, 450);
						//insert
						mysql_query("
							INSERT INTO users_publicity SET
								id_type_publicity = '".$_REQUEST['place']."',
								title = '".$_REQUEST['title']."',
								link = '".$_REQUEST['link']."',
								picture = 'wpanel/".$photo."',
								status = '".$_REQUEST['status']."',
								id_currency = '1',
								id_cost = '5',
								cost_investment = '1000.00',
								click_max = '10000000'
						");
						mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
					}else{
						mensajes("Error to the moment of upload file", "?url=".$_REQUEST[url], "error");
					}//copy
				}else{ 
					mensajes("Format photo Icorrect", "?url=".$_REQUEST[url], "error");
				}//in_array
			break;
			
			case 'update': 
				if ($_FILES[photo][error] != 0){
					mysql_query("
						UPDATE users_publicity SET
							id_type_publicity = '".$_REQUEST['place']."',
							title = '".$_REQUEST['title']."',
							link = '".$_REQUEST['link']."',
							status = '".$_REQUEST['status']."'
						WHERE id = '".$_REQUEST['id_consulta']."'
					");
					mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
				}elseif($_FILES[photo][error] == 0){
					$imagesAllowed = array('jpg','jpeg','png','PNG');
					$parts = explode('.', $_FILES[photo][name]);
					$ext = strtolower(end($parts));
				
					if (in_array($ext,$imagesAllowed)){
						$path  = _PATH_;
						$photo = md5(str_replace(' ', '', $_FILES[photo][name]).microtime().microtime()).'.jpg';

						//existencia de la folder
						if (!is_dir ($path)){	
							$old = umask(0);
							mkdir($path,0777);
							umask($old);
							$fp=fopen($path.'index.html',"w");
							fclose($fp);
						}// is_dir
						
						$query = mysql_query("
							SELECT
								picture
							FROM users_publicity
							WHERE id = '".$_REQUEST['id_consulta']."'
						") or die (mysql_error());
						$array = mysql_fetch_assoc($query);
						$old_pic = $array['picture'];
						
						if (copy($_FILES[photo][tmp_name], $path.$photo)){
							//redimensionar($path.$photo, $path.$photo, 450);
							@unlink(_PATH_.$old_pic);
							//update
							mysql_query("
								UPDATE users_publicity SET
									id_type_publicity = '".$_REQUEST['place']."',
									title = '".$_REQUEST['title']."',
									link = '".$_REQUEST['link']."',
									picture = 'wpanel/".$photo."',
									status = '".$_REQUEST['status']."'
								WHERE id = '".$_REQUEST['id_consulta']."'
							");
							mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
						}else{
							mensajes("Error to the moment of upload file", "?url=".$_REQUEST[url], "error");
						}//copy
					}else{ 
						mensajes("Format photo Icorrect", "?url=".$_REQUEST[url], "error");
					}//in_array
				}//elseif
			break;
		 }//switch
	 }//action
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
			<?php
				$frm = new formulario('Manage Publicity', '?url='.$_GET[url], 'Send', 'Manage Publicity', $metodo='post');
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
						FROM type_publicity 
						WHERE status = '1' AND id IN ('1','2')
						| AND 
						id = '".campo("users_publicity", "id_type_publicity", $_REQUEST['id_consulta'], 1)."'
					";
					//datos de la publicidad
					$publicitys = mysql_query("SELECT * FROM users_publicity WHERE id = '".$_REQUEST['id_consulta']."'");
					$publicity = mysql_fetch_assoc($publicitys);
					//cboBoxs
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2', '5')
						| AND 
						id = '".campo("users_publicity", "status", $_REQUEST['id_consulta'], 1)."'
					";
				}else{
					$place = "
						SELECT 
							id AS valor, 
							name AS descripcion 
						FROM type_publicity 
						WHERE status = '1' AND id IN ('1','2')
					";
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2','5')
					";
				}				  
				  
				$frm->selects(array("place"=>$place));
				
				$frm->inputs("
					SELECT 
						title AS title_1,
						link AS link_1
					FROM users_publicity
					$where
				");
				
				$frm->selects(array("status"=>$status));
				$frm->insertTitle('Photo Ad');
				$frm->insertColspan();
				$frm->insertHtml('Photo', '<input type="file" id="photo" name="photo" />');
				$frm->insertColspan();
				
				if ($publicity['picture']!=''){
					$frm->insertColspan('<img src="'.str_replace('wpanel/','',_PATH_).$publicity['picture'].'" height="100" />');
					$frm->insertColspan();
					$frm->insertColspan();
				}
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
						title AS title,
						(select b.name from type_publicity b where b.id=users_publicity.id_type_publicity) AS place,
						(select c.name from status c where c.id=users_publicity.status) AS status
						
					FROM users_publicity
					WHERE id_type_publicity IN ('1','2')
					ORDER BY title			
				",1);
            ?>
        </td>
    </tr>
</table>
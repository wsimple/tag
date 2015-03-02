<?php
	include '../header.json.php';
	include $config->relpath.'class/class.phpmailer.php';
	if (quitar_inyect()){
		$errorFile='0';
		$mem='vacio';
		$res['action']=$_REQUEST['action'];
		$myId=$myId?$myId:$_SESSION['ws-tags']['ws-user']['id'];
		switch($_REQUEST['action']){
			case 0: //upload update photo
				$id_group=campo('groups', 'md5(id)', $_POST['grp'], 'id');
				if ($_FILES['photo_g']['error'] <= 0){
					//extension
					$imagesAllowed	=array('jpg','jpeg','png','gif','bmp');
					$parts			=explode('.', $_FILES['photo_g']['name']);
					$ext			=strtolower(end($parts));
					//validacion del formato de la imagen
					if ( in_array($ext,$imagesAllowed) ){
						$path1 = RELPATH.'img/';
						$path2 = 'groups/'.md5($id_group.'_'.$id_group.'_'.$id_group).'/';
						$photo = 'profile_'.md5($id_group.'_'.$id_group.'_'.$id_group.'_'.time()).'.'.$ext;
						//si la imagen pesa menos de 2,5mb
						if($_FILES['photo_g']['size'] < 2500000){
							//existencia de la folder
							if (!is_dir ($path1.$path2)){
								$old = umask(0);
								mkdir($path1.$path2,0777);
								umask($old);
								$fp=fopen($path1.$path2.'index.html','w');
								fclose($fp);
							}// is_dir
							//subiendo del archivo al servidor
							if (redimensionar($_FILES['photo_g']['tmp_name'], $path1.$path2.$photo, 200)){
								FTPupload($path2.$photo);
								$res['photo'] = md5($id_group.'_'.$id_group.'_'.$id_group).'/'.$photo;
							}
						}else{ $res['error'] = 'pesoMax'; }
					}else{ $res['error'] = 'formatError'; }// if imagesAllowed
				}else{ $res['error'] = 'noFile'; }
			break;// end upload update photo
			case 1: //new groups
				$sql='	id_creator	= ?,
						id_category = ?,
						id_oriented	= ?,
						id_privacy	= ?,
						name		= ?,
						description	= ?,
						photo		= ?,
						icon		= "0.png",
						status		= "1"';
				$setA=array($_SESSION['ws-tags']['ws-user']['id'],
							$_POST['category_group'],$_POST['type_content'],
							$_POST['privacy'],formatText($_POST['name']),formatText($_POST['description']),
							$photo);
				//creamos el grupo
				$id_group=CON::insert('groups',$sql,$setA);
				if ($id_group!=''){
					//code del grupo
					$code=md5($id_group.'_'.$id_group.'_'.$id_group);
					$photo='';
					//añadimos el admiistrador como miembro
					$sql='id_group=?,id_user=?,is_admin="1",date_update=now(),status="1"';
					$sqlA=array($id_group,$_SESSION['ws-tags']['ws-user']['id']);
					CON::insert('users_groups',$sql,$sqlA);
					$res['insert']='true';
					$res['id']=md5($id_group);
				}else{ $res['insert']='false'; die(jsonp($res)); }
				$msgBox  = $_FILES['photo_g']['size'];
				if($_POST['logoSelect'] == 'file'){
					// Imagen Grupo
					if ($_FILES['photo_g']['error'] <= 0){
						$imagesAllowed	= array('jpg','jpeg','png','gif','bmp');
						$parts			= explode('.', $_FILES['photo_g']['name']);
						$ext			= strtolower(end($parts));
						//validacion del formato de la imagen
						if ( in_array($ext,$imagesAllowed) ){
							//$path  = RELPATH.'img/groups/'.$code.'/';
							$path1 = RELPATH.'img/';
							$path2 = 'groups/'.$code.'/';
							$photo = 'profile_'.$code.'.'.$ext;
							//si la imagen pesa menos de 2,5mb
							if($_FILES['photo_g']['size'] < 2500000){
								//existencia de la folder
								if (!is_dir ($path1.$path2)){
									$old = umask(0);
									mkdir($path1.$path2,0777);
									umask($old);
									$fp=fopen($path1.$path2.'index.html','w');
									fclose($fp);
								}// is_dir
								//subiendo del archivo al servidor
								if (redimensionar($_FILES['photo_g']['tmp_name'],$path1.$path2.$photo,200)){
									FTPupload($path2.$photo);
									$photo=$code.'/'.$photo;
									$res['photo']=$photo;
								}else{
									$photo='default.jpg';
									$res['photo']='nopUpload';
								}
							}else{ $res['error']='pesoMax'; }
						}else{ $res['error']='formatError'; }// if imagesAllowed
					}
				}else{ $photo='default.jpg'; }
				//update groups code y photo
				CON::update('groups','code=?,photo=?','id=?',array($code,$photo,$id_group));
			break;// fin add
			case 2: //update
				$id_group = CON::getVal('SELECT id FROM groups WHERE md5(id)=?;',array($_POST['grp']));
				if($id_group){
					$code_grp = $_POST['code_g'];
					$photo=$_POST['bgkphoto']!=''?$_POST['bgkphoto']:'default.jpg';
					//actualizamos los datos grupo
					$sql='id_oriented=?,id_privacy=?,name=?,description=?,photo=?,icon=?';
					$sqlA=array($_POST['type_content'],$_POST['privacy'],formatText($_POST['name']),
								formatText($_POST['description']),$photo,$_POST['icon'],$id_group);
					CON::update("groups",$sql,'id=?',$sqlA);
					$res['update']='true';
					//miembros del grupo
					$res['members_update']=$_POST['members_update'];
					if (count($_POST['members_update'])>0){
						$members = CON::query(' SELECT md5(id_user) AS id FROM users_groups
												WHERE id_group=? AND id_user!=?',
												array($id_group,$_SESSION['ws-tags']['ws-user']['id']));
						//Convierto arreglo assoc en simple para compararlo con resultado de fkcomplete
						$memaux = array();
						while($row = CON::fetchAssoc($members)){ $memaux[] = $row['id']; }
						//Comparo arrglos para saber que elimino o borro de los miembros
						$miembrosNuevos		= array_diff( $_POST['members_update'], $memaux);
						$mienbrosEliminados	= array_diff( $memaux, $_POST['members_update'] );
						$res['nuevos']=$miembrosNuevos;
						$res['eliminados']=$mienbrosEliminados;
						//agregar los nuevos miembros
						if(count($miembrosNuevos)>0){
							foreach ($miembrosNuevos as $newMem) {
								$idMem= CON::getRow('SELECT id,email FROM users WHERE md5(id)=?',array($newMem));
								if (count($idMem)>0 && !CON::getVal('SELECT id_user FROM users_groups WHERE id_group=? AND id_user=?',array($id_group,$newMem))){
									CON::insert("users_groups","id_group=?,id_user=?,date_update = now(),status = '2'",
										array($id_group,$idMem['id']));
									notifications($idMem['id'],$id_group,6,false,false,$idMem);
								}
							}
						}
						//Eliminar miembros y notificaciones antiguas
						if ( count($mienbrosEliminados) > 0 ) {
							foreach ($mienbrosEliminados as $oldMem) {
								$idMem= CON::getVal('SELECT id FROM users WHERE md5(id)=?',array($oldMem));
								if ($idMem){
									//Enlace a grupo
									CON::delete("users_groups","id_group =? AND id_user!=? AND id_user=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?);",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$idMem,$id_group));
									//Notificaciones
									CON::delete("users_notifications","id_source=?  AND ((id_friend =? AND (id_type = '6' OR id_type = '14')) OR (id_user AND id_type='13')) AND id_friend!=? AND id_friend!=(SELECT id_creator FROM groups WHERE id=?);",array($id_group,$idMem,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
								}
							}
						}
					}else{
						CON::delete("users_groups","id_group = ? AND id_user!=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?)",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
						//Notificaciones
						CON::delete("users_notifications "," id_source = ? AND id_type = '6' AND id_friend!=? AND id_friend!=(SELECT id_creator FROM groups WHERE id=?);",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
					}//if members
					//administradores del grupo
					if (count($_POST['admins'])>0){
						$admins = CON::query('SELECT md5(id_user) AS id FROM users_groups WHERE id_group =? AND is_admin = "1" AND id_user!=?',array($id_group,$_SESSION['ws-tags']['ws-user']['id']));
						//Convierto arreglo assoc en simple para compararlo con resultado de fkcomplete
						$adminaux = array();
						while($row = CON::fetchAssoc($admins)){ $adminaux[] = $row['id']; }
						$adminsNuevos		= array_diff( $_POST['admins'], $adminaux);
						$adminsEliminados	= array_diff( $adminaux, $_POST['admins'] );
						//agregar los nuevos administradores
						if ( count($adminsNuevos) > 0 ) {
							foreach ($adminsNuevos as $newMem) {
								$idMem= CON::getRow("SELECT id,email FROM users WHERE md5(id)=?",array($newMem));
								if (count($idMem)>0 && !CON::getVal("SELECT id_user FROM users_groups WHERE id_user=? AND id_group = ?",array($newMem,$id_group))){
									CON::insert("users_groups","id_group=?,id_user = ?, is_admin = '1', date_update = now(), status = '2'",array($id_group,$idMem));
									//se envia la notificaciones
									//notifications($idMem['id'],$id_group,14,false,false,$idMem);
									notifications($idMem['id'],$id_group,6,false,false,$idMem);
								}else{ CON::update("users_groups ","is_admin ='1'","id_group=? AND id_user!=? AND id_user =?;",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$idMem)); }
							}
						}
						//Eliminar admins y notificaciones antiguas
						if ( count($adminsEliminados) > 0 ) {
							foreach ($adminsEliminados as $oldMem) {
								$idMem= CON::getVal("SELECT id FROM users WHERE md5(id)=?",array($oldMem));
								//Enlace a grupo
								CON::update("users_groups ","is_admin = '0'"," id_group=? AND id_user!=? AND id_user=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?)",array($id_group,$_SESSION['ws-tags']['ws-user']['id']),$idMem,$id_group);
								//Notificaciones
								CON::delete("users_notifications "," id_source =? AND id_friend =? AND id_type = '14' AND id_friend!=? AND id_friend!=(SELECT id_creator FROM groups WHERE id=?)",array($id_group,$idMem,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
							}
						}
					}else{
						CON::update("users_groups","is_admin ='0'"," id_group = ? AND id_user!=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?);",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
						//Notificaciones
						CON::delete("users_notifications","id_source = ? AND id_type = '14' AND id_friend!=? AND id_friend!=(SELECT id_creator FROM groups WHERE id=?);",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
					}//if admins
					$typeBox = '1';
					$msgBox  = GROUPS_CTRUPDATEMSGEXITO;
				}else{ $res['update']='false'; }
			break;//fin update
			case 3: // join to group
				if (isset($_GET['grp']) && existe('users_groups', 'id', 'WHERE md5(id_group)="'.$_GET['grp'].'"')){
					$status=  campo('users_groups', 'md5(id_group)', $_GET['grp'], 'status','AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
					switch ($status){
						case '1': $res['join']='true'; break;
						case '2':
							$GLOBALS['cn']->query('UPDATE users_groups SET status="1" WHERE md5(id_group)="'.$_GET['grp'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
							$res['join']='true';
						break;
						case '5': $res['join']='existe'; break;
						default :
							//$privacy = campo('groups', 'md5(id)', $_GET['grp'], 'id_privacy');
							$sql="SELECT id_privacy,id,id_creator FROM groups WHERE md5(id)='".$_GET['grp']."' LIMIT 1";
							$result = $GLOBALS['cn']->query($sql);
							$result=  mysql_fetch_assoc($result);
							if ($result['id_privacy']=='1'){
								$GLOBALS['cn']->query("
									INSERT INTO users_groups SET
										id_group = '".$result['id']."',
										id_user = '".$_SESSION['ws-tags']['ws-user']['id']."',
										date_update = now(), status = '1'");
								$res['join']='true';
							}elseif($result['id_privacy']=='2'){
								if (!existe('users_groups', 'id', 'WHERE id_group = "'.$result['id'].'" AND id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'"')){
									//notificación
									$row=CON::getRow("SELECT email FROM users WHERE id=?",array($result['id_creator']));
									notifications($result['id_creator'],$result['id'],12,false,false,$row);
									$GLOBALS['cn']->query("
									INSERT INTO users_groups SET
										id_group = '".$result['id']."',
										id_user = '".$_SESSION['ws-tags']['ws-user']['id']."',
										date_update = now(), status = '5'");
									$res['join']='private-sent';
								}else{ $res['join']='private-nosent'; }
							}else{ $res['join']='secrete'; }//privacy
					}
				}
			break;// end join to group
			case 4: // leave to group
				if (isset($_GET['grp'])){
                    $id_group = CON::getVal("SELECT id FROM groups WHERE md5(id)=?",array($_GET['grp']));
                    if (!$id_group){ $res['leave'] ='no-group'; break; }
                    //control de nuevos miembros
                    $admins  = CON::getRow("SELECT (SELECT COUNT(id) FROM users_groups WHERE id_group=? AND is_admin=1) AS numA,
                    								 is_admin AS admin
                    						FROM users_groups 
                    						WHERE id_group=? AND id_user=?",array($id_group,$id_group,$myId));
                    $res['tes']=$admins;
					if(!isset($_GET['force']) && ($admins['numA']==1 && $admins['admin']=='1')) $res['leave']= 'leave';
					else{
						if ($admins['numA']==1 && $admins['admin']=='1'){//se verifica si el usuario en sesion es el unico admin del grupo
							CON::delete("users_groups","id_group = ?",array($id_group)); //se borran las miembros
							CON::delete("groups","id=?",array($id_group)); //se borra el grupo
							CON::delete("users_notifications","id_source = ? AND (id_type = '6' OR id_type = '14' OR id_type = '13')",array($id_group)); //se borran las notificaciones tipo grupos
							$query = CON::query("SELECT id FROM tags WHERE id_group=?",array($id_group)); //se consultan las tags del grupo
							//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion)
							while ($row= CON::fetchAssoc($id_group)){ //se borran las notificaciones del tags del grupo en cuestion
								CON::delete("users_notifications","id_type = '10' AND id_source = ?",array($row['id']));
							} 
							CON::update("tags","status='2'","id_group=? AND status=7",array($id_group));//se borran las tags del grupo
						}else{
							//se elimina como miembro del grupo
							CON::delete("users_groups","id_group=? AND id_user=? ",array($id_group,$myId));
							//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion) del miembro borrado
							$query = CON::query("SELECT id FROM tags WHERE id_group=?",array($id_group)); //se consultan las tags del grupo
							//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion)
							while ($row= CON::fetchAssoc($id_group)) //se borran las notificaciones del tags del grupo en cuestion
								   CON::delete("users_notifications","id_type = '10' AND id_source = ?",array($row['id']));
							//se borran las notificaciones tipo grupo (grupo en cuestion) del miembro borrado
							CON::delete("users_notifications","id_source=? AND id_friend=? AND (id_type = '6' OR id_type = '14' OR id_type = '10' OR id_type = '13')",array($id_group,$myId));
							//verificamos si el usuario en sesion es el creador del grupo, para asiganrle a otro usuario que ahora sera el creador del mismo
							$idCreator = CON::getVal("SELECT id_creator FROM groups WHERE id=?",array($id_group));
							if ($idCreator==$myId)
								 CON::update("groups","id_creator=(SELECT id_user
																	FROM users_groups
																	WHERE id_group = ? AND is_admin = '1' LIMIT 1)",
								 				"id=?",array($id_group,$id_group));
						}
						$res['leave'] ='true';
					}
                }else { $res['leave'] ='no-group'; }
			break;// end leave to group
			case 5: //invite friend
                if (isset($_POST['grp'])){
                    $id_group = CON::getVal("SELECT id FROM groups WHERE md5(id)=?",array($_POST['grp']));
                    if (!$id_group){ $res['mensj'] ='no-group'; break; }
                    //control de nuevos miembros
                    $array=array();
                    $array['newSelect']='md5(ul.id_friend) AS id_friend,ul.id_friend AS id,u.email';
					$array['where']=safe_sql('ul.id_user=? AND ul.is_friend=1',array($myId));
					$array['where'].=safe_sql(" AND ul.id_friend NOT IN ((SELECT id_user FROM users_groups WHERE id_group=?))",array($id_group));
					$query=peoples($array);
                    $typeBox = false;  
                    while ($row=CON::fetchAssoc($query)){
                		if (isset($_POST['brower_type'])){ //invitar amigos en la web (esta forma debe ser elimida de inmediato)
                           if (isset($_POST['chkLstUsersBroswer_'.$row['id_friend']])){
                                $id=CON::insert('users_groups','id_group=?,id_user=?,date_update = now(),status="2"',array($id_group,$row['id']));
                                if ($id){
                                	notifications($row['id'],$id_group,6,false,false,$row);
	                                $typeBox = true;
                                } 
                           }
               			}elseif (isset($_POST['friends'])) { //invitar amigos app (esta debe ser la invitacion general o usar mismo esquema)
                           if (in_array($row['email'],$_POST['friends'])){
                                $id=CON::insert('users_groups','id_group=?,id_user=?,date_update = now(),status="2"',array($id_group,$row['id']));
                                if ($id){
                                	notifications($row['id'],$id_group,6,false,false,$row);
	                                $typeBox = true;
                                } 
                           }               				
               			}
                    }
                    $res['mensj']=!$typeBox?'no-invite':'invite';
                }else { $res['mensj'] ='no-group'; }
			break;
			case 6: //eliminar ultimo administrador y asiganr uno nuevo
				if (isset($_GET['grp'])){
					$id_group = CON::getVal("SELECT id FROM groups WHERE md5(id)=?",array($_GET['grp']));
                    if (!$id_group){ $res['asig'] ='no-group'; break; }
                    if (!$_GET['chkVal'] && !$_POST['uemails']){ $res['asig']='false'; break; }
					if(isset($_GET['chkVal']) && $_GET['chkVal']!=''){
						$where="md5(id) IN ('".str_replace(",","','",$_GET['chkVal'])."')";
					}elseif(isset($_POST['uemails'])){
						if (count($_POST['uemails'])==0){ $res['asig']='false'; break; }
						$where="email IN ('".implode("','",$_POST['uemails'])."')";
					}else{ $res['asig']='false'; break; }
					$ultId='';
					$query=CON::query("SELECT id,email FROM users WHERE $where");
					while ($row=CON::fetchAssoc($query)){
						CON::insert_or_update("users_groups","is_admin='1',date_update=now(),status='1'","id_group=?,id_user=?","id_group=? AND id_user=?",array($id_group,$row['id'],$id_group,$row['id']));
						notifications($row['id'],$id_group,14,false,false,$row);
						$ultId=$row['id'];
					}
					CON::delete("users_groups","id_group=? AND id_user=?",array($id_group,$myId));
					CON::update("groups","id_creator=?","id=?",array($ultId,$id_group));
					$res['asig'] = 'true';
				}else{ $res['asig'] = 'false'; }
			break;
			case 7:
				if ($_GET['grp'] && existe('users_groups', 'id', 'WHERE md5(id_group)="'.$_GET['grp'].'"')){
					$res['accept']='none';
					$status=  campo('users_groups', 'md5(id_group)', $_GET['grp'], 'status','AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
					if($_GET['accept'] == 1){
						$res['accept']='true'; 
						if ($status=='2'){
						//echo ('Aqui actualizo status a 1 de la tabla users_groups si el usurio acepta ser admin o user');
						$GLOBALS['cn']->query('UPDATE users_groups SET status="1" WHERE md5(id_group)="'.$_GET['grp'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
						}elseif(!$status || $status=='5'){ $res['invite']='no-invite'; }
					}else{
						if ($status!='1'){
						$res['accept']='false';
						if ($status && $status=='2') $GLOBALS['cn']->query('DELETE FROM users_groups WHERE md5(id_group)="'.$_GET['grp'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
						$GLOBALS['cn']->query('	DELETE FROM users_notifications
												WHERE	md5(id_source) = "'.$_GET['grp'].'" AND
														(id_type = "6" OR id_type = "14") AND
														id_friend = "'.$_SESSION['ws-tags']['ws-user']['id'].'"');
						}else{ $res['accept']='true'; }
					}
				}else{ $res['group']='noG'; }
			break;
			case 8:
				$row=CON::getRow("SELECT u.id,u.email,g.id_group 
								FROM users_groups g JOIN users u ON u.id=g.id_user
								WHERE md5(g.id_group)=? AND md5(g.id_user)=?",array($_GET['grp'],$_GET['id']));
				
				if($_GET['accept']==1 && count($row)>0){//acepta usuario
					CON::update("users_groups","date_update=now(),status ='1'","id_group=? AND id_user=?",array($row['id_group'],$row['id']));
					notifications($row['id'],$row['id_group'],13,false,false,$row); 
					$res['insert']='insert';
				}elseif(count($row)>0){ //rechaza usuario
					//aceptamos la solicitud del usuario en el grupo
					CON::delete("users_groups","id_group=? AND id_user=?",array($row['id_group'],$row['id']));
					$res['insert']='false';
				}

				//contamos la cantidad de usuario status 5
				$res['cug']=CON::getVal("SELECT COUNT(*) FROM users_groups WHERE status=5");
				//eliminamos la notificacion que posee el administrador del grupo
				notifications($_SESSION['ws-tags']['ws-user']['id'],$row['id_group'],12,1,$row['id']);
				//verficar cuantas notificaciones de solicitud de grupo estan activas
				$res['num'] = CON::getVal("SELECT COUNT(id_user)
											FROM users_notifications
											WHERE id_type = '12' AND id_source=?",array($row['id_group']));
			break;
		}// fin switch
		die(jsonp($res));
	}

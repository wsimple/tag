<?php
    include '../header.json.php';
	if (quitar_inyect()){
        //$detect=new Mobile_Detect();
		$errorFile='0';
		$mem='vacio';
		$res['action']=$_REQUEST['action'];
		switch($_REQUEST['action']){
			case 0: //upload update photo
				$id_group=campo('groups', 'md5(id)', $_POST['grp'], 'id');
				if ($_FILES['photo_g']['error'] <= 0){
					    //extension
					    $imagesAllowed =array('jpg','jpeg','png','gif','bmp');
					    $parts         =explode('.', $_FILES['photo_g']['name']);
					    $ext           =strtolower(end($parts));
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
									//uploadFTP($photo,'groups',RELPATH);
                                    FTPupload($path2.$photo);
									$res['photo'] = md5($id_group.'_'.$id_group.'_'.$id_group).'/'.$photo;
								}
							}else{ $res['error'] = 'pesoMax'; }
						}else{ $res['error'] = 'formatError'; }// if imagesAllowed
				}else{ $res['error'] = 'noFile'; }
			break;// end upload update photo
			case 1: //new groups
				$sql='  id_creator	= ?,
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
						$imagesAllowed = array('jpg','jpeg','png','gif','bmp');
						$parts         = explode('.', $_FILES['photo_g']['name']);
						$ext           = strtolower(end($parts));
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
									//uploadFTP($photo,'groups',RELPATH);
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
							$miembrosNuevos     = array_diff( $_POST['members_update'], $memaux);
							$mienbrosEliminados = array_diff( $memaux, $_POST['members_update'] );
							$res['nuevos']=$miembrosNuevos;
							$res['eliminados']=$mienbrosEliminados;
							//agregar los nuevos miembros
							if(count($miembrosNuevos)>0){
								foreach ($miembrosNuevos as $newMem) {
									$idMem= CON::getVal('SELECT id FROM users WHERE md5(id)=?',array($newMem));
									if ($idMem && !CON::getVal('SELECT id_user FROM users_groups WHERE id_group=? AND id_user=?',array($id_group,$newMem))){
										CON::insert("users_groups","id_group=?,id_user=?,date_update = now(),status = '2'"
                                                    ,array($id_group,$idMem));
										//se envia la notificaciones
										notifications($idMem,$id_group,6);
									}
								}
							}
							//Eliminar miembros y notificaciones antiguas
							if ( count($mienbrosEliminados) > 0 ) {
								foreach ($mienbrosEliminados as $oldMem) {
									$idMem= CON::getVal('SELECT id FROM users WHERE md5(id)=?',array($oldMem));
									if ($idMem){
                                        //Enlace a grupo
    									CON::delete("users_groups","id_group =? AND id_user!=? AND id_user=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?);"
                                                    ,array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$idMem,$id_group));
    									//Notificaciones
    									CON::delete("users_notifications","id_source=?  AND ((id_friend =? AND (id_type = '6' OR id_type = '14')) OR (id_user AND id_type='13'))
                                                                    AND id_friend!=? AND id_friend!=(SELECT id_creator FROM groups WHERE id=?);"
                                                                ,array($id_group,$idMem,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
                                    }
								}
							}
						}else{
							CON::delete("users_groups","id_group = ? AND id_user!=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?);"
                                        ,array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
							//Notificaciones
							CON::delete("users_notifications "," id_source = ? AND id_type = '6' AND id_friend!=?
                                                        AND id_friend!=(SELECT id_creator FROM groups WHERE id=?);"
                                        ,array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
						}//if members
						//administradores del grupo
						if (count($_POST['admins'])>0){
							$admins = CON::query('  SELECT md5(id_user) AS id FROM users_groups
                                                    WHERE id_group =? AND is_admin = "1" AND id_user!=?;'
                                ,array($id_group,$_SESSION['ws-tags']['ws-user']['id']));
							//Convierto arreglo assoc en simple para compararlo con resultado de fkcomplete
							$adminaux = array();
							while($row = CON::fetchAssoc($admins)){ $adminaux[] = $row['id']; }
							$adminsNuevos     = array_diff( $_POST['admins'], $adminaux);
							$adminsEliminados = array_diff( $adminaux, $_POST['admins'] );
							//agregar los nuevos administradores
							if ( count($adminsNuevos) > 0 ) {
								foreach ($adminsNuevos as $newMem) {
									$idMem= CON::getVal("SELECT id FROM users WHERE md5(id)=?",array($newMem));
									if ($idMem && !CON::getVal("SELECT id_user FROM users_groups WHERE id_user=? AND id_group = ?",array($newMem,$id_group))){
										CON::insert("users_groups","id_group=?,id_user = ?, is_admin = '1', date_update = now(), status = '2'"
                                                ,array($id_group,$idMem));
										//se envia la notificaciones
										//notifications($idMem,$id_group,14);
										notifications($idMem,$id_group,6);
									}else{ CON::update("users_groups ","is_admin ='1'","id_group=? AND id_user!=? AND id_user =?;",array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$idMem)); }
								}
							}
							//Eliminar admins y notificaciones antiguas
							if ( count($adminsEliminados) > 0 ) {
								foreach ($adminsEliminados as $oldMem) {
									$idMem= CON::getVal("SELECT id FROM users WHERE md5(id)=?",array($oldMem));
									//Enlace a grupo
									CON::update("users_groups ","is_admin = '0'"," id_group=? AND id_user!=? AND id_user=?
                                                                AND id_user!=(SELECT id_creator FROM groups WHERE id=?);"
                                                ,array($id_group,$_SESSION['ws-tags']['ws-user']['id']),$idMem,$id_group);
									//Notificaciones
									CON::delete("users_notifications "," id_source =? AND id_friend =? AND id_type = '14'
                                                                AND id_friend!=? AND id_friend!=(SELECT id_creator FROM groups WHERE id=?);",array($id_group,$idMem,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
								}
							}
						}else{
							CON::update("users_groups","is_admin ='0'"," id_group = ? AND id_user!=? AND id_user!=(SELECT id_creator FROM groups WHERE id=?);",
                                        array($id_group,$_SESSION['ws-tags']['ws-user']['id'],$id_group));
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
                            case '2': $GLOBALS['cn']->query('UPDATE users_groups SET status="1" WHERE md5(id_group)="'.$_GET['grp'].'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
                                $res['join']='true'; break;
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
                                        notifications($result['id_creator'],$result['id'],12);
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
				$id_group = campo('groups', 'md5(id)', $_GET['grp'], 'id');
				if($id_group!=''){
				    //numero de administradores del grupo
					$admins  = $GLOBALS['cn']->query("
						SELECT id FROM users_groups
						WHERE id_group = '".$id_group."' AND is_admin = '1'
					");
				    $admins  = mysql_num_rows($admins);
					$admins2 = $GLOBALS['cn']->query("
						SELECT id FROM users_groups
						WHERE id_group = '$id_group' AND is_admin='1' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'
					");
					$admins2 = mysql_num_rows($admins2);
					if((!isset($_GET['force'])) && ($admins==$admins2)){ $res['leave']= 'leave';
					}else{
						if ($_GET['admin']=='1'&& $admins==$admins2){//se verifica si el usuario en sesion es el unico admin del grupo
							$GLOBALS['cn']->query("DELETE FROM users_groups WHERE id_group = '".$id_group."' "); //se borran las miembros
							$GLOBALS['cn']->query("DELETE FROM groups WHERE id = '".$id_group."' "); //se borra el grupo
							$GLOBALS['cn']->query("DELETE FROM users_notifications WHERE id_source = '".$id_group."' AND (id_type = '6' OR id_type = '14' OR id_type = '13')"); //se borran las notificaciones tipo grupos
							$tagsErases = $GLOBALS['cn']->query("SELECT id FROM tags WHERE id_group ='".$id_group."' "); //se consultan las tags del grupo
							//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion)
                            while ($tagsErase = mysql_fetch_assoc($tagsErases)){//se borran las notificaciones del tags del grupo en cuestion
								   $GLOBALS['cn']->query("DELETE FROM users_notifications WHERE id_type = '10' AND id_source = '".$tagsErase['id']."' ");
							}
							$GLOBALS['cn']->query("UPDATE tags SET status='2' WHERE id_group = '".$id_group."' AND status=7");//se borran las tags del grupo
						}else{//si no es el unico admin
							//se elimina como miembro del grupo
							$GLOBALS['cn']->query("
								DELETE FROM users_groups
								WHERE id_group = '".$id_group."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'
							");
							//se borran las notificaciones tipo TAG DE GRUPO (grupo en cuestion) del miembro borrado
                            $tagsErases = $GLOBALS['cn']->query("SELECT id FROM tags WHERE id_group ='".$id_group."' "); //se consultan las tags del grupo
							while ($tagsErase = mysql_fetch_assoc($tagsErases)){//se borran las notificaciones del tags del grupo en cuestion
								   $GLOBALS['cn']->query("DELETE FROM users_notifications WHERE id_type = '10' AND id_source = '".$tagsErase['id']."' AND id_friend = '".$_SESSION['ws-tags']['ws-user']['id']."'");
							}
							//se borran las notificaciones tipo grupo (grupo en cuestion) del miembro borrado
							$GLOBALS['cn']->query("DELETE FROM users_notifications WHERE id_source = '".$id_group."' AND id_friend = '".$_SESSION['ws-tags']['ws-user']['id']."' AND (id_type = '6' OR id_type = '14' OR id_type = '10' OR id_type = '13')");
							
							//verificamos si el usuario en sesion es el creador del grupo, para asiganrle a otro usuario que ahora sera el creador del mismo
							$idCreator = $GLOBALS['cn']->query("SELECT id_creator FROM groups WHERE id_creator = '".$_SESSION['ws-tags']['ws-user']['id']."'");

							$idCreatorGroup = mysql_num_rows($idCreator);
							if ($idCreatorGroup!=0){
								 $adminUserGrps = mysql_fetch_assoc($adminUserGrp);
								 $GLOBALS['cn']->query("UPDATE groups 
                                                        SET id_creator = (  SELECT id_user
                                                                            FROM users_groups
                                                                            WHERE id_group = '".$id_group."' AND is_admin = '1' LIMIT 1) 
                                                        WHERE id = '".$id_group."'");
							}
						}
						$res['leave']='true';
					}
                }else{$res['leave']='no-group';}
			break;// end leave to group
			case 5: //invite friend
                    if (isset($_POST['grp'])){
                        $id_group = campo('groups', 'md5(id)', $_POST['grp'], 'id');
                        //control de nuevos miembros
                        switch ($_POST['brower_type']){
                            case 1:
                                    $lstUsrs = $GLOBALS['cn']->query('
                                          SELECT id_user
                                          FROM users_groups
                                          WHERE id_group = "'.$id_group.'" AND id_user != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
                                          GROUP BY id_user
                                    ');
                                    $arrayMembersGroup = mysqlFetchAssocToArray($lstUsrs, 'id_user'); //array de miembros del grupo
                                    $idsNotIn = '';
                                    foreach ($arrayMembersGroup as $id_menber) $idsNotIn .= "'".$id_menber."',";
                                    $whereIdsNotIn = ($idsNotIn!='') ? " AND f.id_friend NOT IN (".rtrim($idsNotIn,',').") ":"";
                                    $friends = view_friends('','', $whereIdsNotIn);
                                    $fieldWhereDatail = 'id_friend';
                            break;
                        }
                        $typeBox = 0;
                        while ($friend = mysql_fetch_assoc($friends)){
                               if (isset($_POST['chkLstUsersBroswer_'.md5($friend[$fieldWhereDatail])]) && !@in_array($friend[$fieldWhereDatail], $arrayDelete) && !existe('users_groups', 'id_user', " WHERE id_user = '".$friend[$fieldWhereDatail]."' AND id_group = '".$id_group."'")){
                                     $GLOBALS['cn']->query("
                                         INSERT INTO users_groups SET
                                            id_group = '".$id_group."',
                                            id_user  = '".$friend[$fieldWhereDatail]."',
                                            date_update = now(),
                                            status = '2'
                                    ");
                                     //notificación
                                     $selectUsers = $GLOBALS['cn']->query("SELECT id_user FROM users_groups WHERE id_group = '".$id_group."' AND id_user = '".$friend[$fieldWhereDatail]."'");
                                     $selectUser  = mysql_num_rows($selectUsers);
                                     if ($selectUser['id_user']==0){
                                            notifications($friend[$fieldWhereDatail],$id_group,6);
                                     }
                                $typeBox = 1;
                               }
                        }
                        $res['mensj']  = $typeBox==0?'no-invite':'invite';
                    }else { $res['mensj']  = 'no-group'; }
			break;
			//eliminar ultimo administrador y asiganr uno nuevo
			case 6:
				if($_GET['chkVal']!=''){
					$chk = explode(",", $_GET['chkVal']);
					$a=0;
					$lstUsrs = $GLOBALS['cn']->query('
						SELECT id
						FROM groups
						WHERE md5(id) = "'.$_GET['grp'].'"
					');
					$id_group = mysql_fetch_assoc($lstUsrs);
					$ultId='';
					while($chk[$a]!=''){
						$lstUsrs = $GLOBALS['cn']->query('
							SELECT id
							FROM users
							WHERE md5(id) = "'.$chk[$a].'"
						');
						 $lstUsr = mysql_fetch_assoc($lstUsrs);
						 $ultId = $lstUsr['id'];
						if (existe('users_groups', 'id', " WHERE id_group = '".$id_group['id']."' AND id_user = '".$lstUsr['id']."'")){
							$GLOBALS['cn']->query("UPDATE users_groups SET is_admin = '1', date_update = now(), status = '1' WHERE id_group = '".$id_group['id']."' AND id_user = '".$lstUsr['id']."';");
						}else{
						   $GLOBALS['cn']->query("INSERT INTO users_groups SET is_admin = '1', id_group = '".$id_group['id']."', id_user = '".$lstUsr['id']."', date_update = now(), status = '1'");
						}
						notifications($lstUsr['id'], $id_group['id'], 14);
						$a++;
					 }
                     $GLOBALS['cn']->query("DELETE FROM users_groups WHERE id_group = '".$id_group['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' AND is_admin = '1'"); //se borran las miembros
					 $GLOBALS['cn']->query("UPDATE groups SET id_creator  = '".$ultId."' WHERE id = '".$id_group['id']."'");
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
                $res['get']=$_GET;
				$idGroup=  campo('groups', 'md5(id)', $_GET['grp'], 'id');
				$_GET['id']=  campo('users', 'md5(id)', $_GET['id'], 'id');
                
                if($_GET['accept']==1){//acepta usuario
                    //aceptamos la solicitud del usuario en el grupo
                    $GLOBALS['cn']->query("UPDATE users_groups SET date_update = now(), status = '1' WHERE id_group = '".$idGroup."' AND id_user = '".$_GET['id']."';");
                    //enviamos notificacion al usuario que es aceptado en el grupo
                    notifications($_GET['id'],$idGroup,13); 
                    $res['insert']='insert';
                }else{//rechaza usuario
                     //aceptamos la solicitud del usuario en el grupo
                    $GLOBALS['cn']->query("DELETE FROM users_groups WHERE id_group = '".$idGroup."' AND id_user = '".$_GET['id']."';");
                    $res['insert']='false';
                }
                //eliminamos la notificacion que posee el administrador del grupo
                notifications($_SESSION['ws-tags']['ws-user']['id'],$idGroup,12,1,$_GET['id']);
                //verficar cuantas notificaciones de solicitud de grupo estan activas
                $userGroups = $GLOBALS['cn']->query("SELECT id_user
                                               FROM users_notifications
                                               WHERE id_type = '12' AND id_source = '".$idGroup."'");
                $res['num'] = mysql_num_rows($userGroups);
			break;
            case 42: echo htmlentities(replaceCaraterSpecial($_GET['hola'])).'<br><br>';
		}// fin switch
		die(jsonp($res));
	}
?>

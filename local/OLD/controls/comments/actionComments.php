<?php
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Allow-Origin: http://localhost');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');

	session_start();

	include ('../../includes/functions.php');

	if (quitar_inyect()){

		include ('../../includes/config.php');
		include ('../../class/class.phpmailer.php');
		include ('../../class/wconecta.class.php');
		include ('../../includes/languages.config.php');
		include ('../../class/validation.class.php');
		
		if ($_POST['del']=='false'){
			if ($_SESSION['ws-tags']['ws-user']['id']!='' && $_POST['txt']!=''){
				//destinatario
				$users = $GLOBALS['cn']->query('SELECT id FROM users WHERE md5(md5(id)) = "'.$_POST['to'].'" LIMIT 0,1');
				$id_user_to = mysql_fetch_assoc($users);
				switch ($_POST['type']){
					case '4': 
                        $source = $GLOBALS['cn']->queryRow('SELECT id,id_user FROM tags WHERE md5(id) = "'.intToMd5($_POST['source']).'" LIMIT 0,1'); 
                        incPoints(4,$source['id'],$source['id_user'],$_SESSION['ws-tags']['ws-user']['id']);
                        incHitsTag($source['id']);
                    break;
					case '15': $source = $GLOBALS['cn']->queryRow('SELECT id FROM store_products WHERE md5(id) = "'.intToMd5($_POST['source']).'" LIMIT 0,1'); break;
				}
				

				//insertamos el comentario
				$GLOBALS['cn']->query('
					INSERT INTO comments SET
						id_type      = "'.$_POST['type'].'",
						id_source    = "'.$source['id'].'",
						id_user_from = "'.$_SESSION['ws-tags']['ws-user']['id'].'",
						id_user_to   = "'.$id_user_to['id'].'",
						comment      = "'.limpiaTextComentarios(utf8_decode($_POST['txt'])).'"
				');

				$id_comment = mysql_insert_id();

				//agregamos la notificación
				$notifications = $GLOBALS['cn']->query('
					SELECT id_user_from AS id_user
					FROM comments
					WHERE	id_source = "'.$source['id'].'"
						AND id_user_from != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
						AND id_user_from != "'.$id_user_to['id'].'"
						AND id_type = "'.$_POST['type'].'"
					GROUP BY id_user_from
				');

				if (mysql_num_rows($notifications)>0){
					while ($notification = mysql_fetch_assoc($notifications)){//se inserta notificacion a todos los users involucrados
						notifications($notification['id_user'], $source['id'], $_POST['type']);
						//$array_froms[] = $notification['id_user'];
					}
				}

				if ($id_user_to['id'] != $_SESSION['ws-tags']['ws-user']['id']){//validamos que el remitente sea diferente al destinatario
					notifications($id_user_to['id'], $source['id'], $_POST['type']);
				}
			}//if txt
		}else{ // si es eliminar
			if ($_POST['c']!=''){
				$GLOBALS['cn']->query('DELETE FROM comments WHERE md5(md5(id)) = "'.$_POST['c'].'"');
			}
		}
	}//if quitar inyect
?>
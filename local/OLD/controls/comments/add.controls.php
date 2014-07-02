<?php

	session_start();

	include ('../../includes/functions.php');

	if (quitar_inyect()){

		include ('../../includes/config.php');
		include ('../../class/class.phpmailer.php');
		include ('../../class/wconecta.class.php');
		include ('../../includes/languages.config.php');
		include ('../../class/validation.class.php');

		if ($_SESSION['ws-tags']['ws-user']['id']!='' && $_GET['txt']!=''){
			//destinatario
			$users = $GLOBALS['cn']->query('SELECT id FROM users WHERE md5(md5(id)) = "'.$_GET['to'].'" LIMIT 0,1');
			$id_user_to = mysql_fetch_assoc($users);

			//insertamos el comentario
			$GLOBALS['cn']->query('
				INSERT INTO comments SET
					id_type      = "'.$_GET['type'].'",
					id_source    = "'.$_GET['source'].'",
					id_user_from = "'.$_SESSION['ws-tags']['ws-user']['id'].'",
					id_user_to   = "'.$id_user_to['id'].'",
					comment      = "'.limpiaTextComentarios(utf8_decode($_GET['txt'])).'"
			');

			$id_comment = mysql_insert_id();
			
			//agregamos la notificación
			$notifications = $GLOBALS['cn']->query('
				SELECT id_user_from AS id_user
				FROM comments
				WHERE	id_source = "'.$_GET['source'].'"
					AND id_user_from != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
					AND id_user_from != "'.$id_user_to['id'].'"
					AND id_type = "'.$_GET['type'].'"
				GROUP BY id_user_from
			');

			if (mysql_num_rows($notifications)>0){
				while ($notification = mysql_fetch_assoc($notifications)){//se inserta notificacion a todos los users involucrados
					notifications($notification['id_user'], $_GET['source'], $_GET['type']);
					//$array_froms[] = $notification['id_user'];
				}
			}
			
			if ($id_user_to['id'] != $_SESSION['ws-tags']['ws-user']['id']){//validamos que el remitente sea diferente al destinatario
				notifications($id_user_to['id'], $_GET['source'], $_GET['type']);
			}
			
			
			//notifications($id_user_to['id'], $_GET['source'], $_GET['type']);

			//salida
			$comments = $GLOBALS['cn']->query('
				SELECT
					c.id_source AS id_source,
					c.id_user_from AS id_from,
					c.id_user_to AS id_to,
					c.comment AS comment,
					c.date AS comment_date,
					(SELECT concat(u.name," ",u.last_name) FROM users u WHERE u.id = c.id_user_from)  AS user_from,
					(SELECT md5(CONCAT(u.id, "_", u.email, "_", u.id)) FROM users u WHERE u.id = c.id_user_from) AS codeUser,
					(SELECT u.profile_image_url FROM users u WHERE u.id = c.id_user_from) AS photoUser,
					c.id AS id,
					c.id_type AS id_type
				FROM comments c
				WHERE c.id = "'.$id_comment.'"');

			$comment = mysql_fetch_assoc($comments);

			$foto_usuario  =FILESERVER.getUserPicture($comment['codeUser'].'/'.$comment['photoUser'],'img/users/default.png');

			//$cuantos = numRecord('comments', " WHERE id_source = '".$_GET['source']."' AND id_type = '".$type['id']."' ");

			$table =  '
				<tr id="comment_'.$comment['id'].'" class="tr-comment" comment="'.$comment['id'].'">
					<td width="7%" style="padding-left:5px" valign="top">
						<img class="imgUser"  src="'.$foto_usuario.'" border="0" style="border:1px solid #999; cursor:pointer" title="'.COMMENTS_FLOATHELPVIEWPROFILEUSER.'" width="40" height="40" onclick="userProfile(\''.$comment['user_from'].'\', \'Close\', \''.md5($comment['id_from']).'\');" />
					</td>
					<td width="93%" valign="top" style="border-bottom:1px solid #F4F4F4">
						<img src="img/delete_comment.png" width="8" height="8" style="float:right; margin-right:5px; cursor:pointer" border="0" title="'.COMMENTS_FLOATHELPREMOVECOMMENT.'"  onclick="_addOrDeleteComments(\'#comment_'.$comment['id'].'\', \'c='.$comment['id'].'\', true);" />
						<a href="javascript:void(0);" onclick="userProfile(\''.$comment['user_from'].'\', \'Close\', \''.md5($comment['id_from']).'\');" onfocus="this.blur();" title="'.COMMENTS_FLOATHELPVIEWPROFILEUSER.'" style="color:#F58220; font-weight:bold; text-decoration:none">'.formatoCadena($comment['user_from']).'</a><br />
						'.strToLink($comment['comment']).'<br />
						<em style="font-size:9px; color:#CCC; float:right; margin-right:5px">'.$comment['comment_date'].'</em>
					</td>
				</tr>';

			//mostramos el comentario
            if($_GET['mobile']=='')
                echo $table;

		}//if txt

	}//if quitar inyect
?>
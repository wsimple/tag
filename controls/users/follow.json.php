<?php
include '../header.json.php';
include RELPATH.'class/class.phpmailer.php';

	if(isset($_GET['debug'])) _imprimir($_GET);
	if(quitar_inyect()) {
		$uid=$_SESSION['ws-tags']['ws-user']['id'];
		$res=array();
		if( $uid!='' && $_GET['uid']!='' ) {
			//datos de amigo
			$array	= $GLOBALS['cn']->queryRow('SELECT u.id, u.email FROM users u WHERE md5(u.id) ="'.$_GET['uid'].'" LIMIT 1');
			$follow	= $array['id'];
			$email	= $array['email'];
			$link	= $GLOBALS['cn']->queryRow('
				SELECT is_friend FROM users_links
				WHERE id_user = "'.$uid.'" AND id_friend = "'.$follow.'"
			');
			$follower = $GLOBALS['cn']->queryRow('
				SELECT is_friend FROM users_links
				WHERE id_user  = "'.$follow.'" AND id_friend = "'.$uid.'"
			');
			$isFollower=count($follower)>0;
			if( !isset($_GET['unfollow']) && !count($link) && ($uid != $follow) ) {//si no eras seguidor, ahora lo sigues
				if( isset($_GET['debug']) ) echo 'follow';
				$insert = $GLOBALS['cn']->query('
					INSERT INTO users_links (id_user, id_friend,is_friend)
					VALUES ("'.$uid.'", "'.$follow.'","'.($isFollower?1:0).'")
				');
				if( !$insert ) {
					$res['error']='no se pudo hacer link';
				}else{
					if($isFollower){//si tambien te sigue ahora son amigos
						$GLOBALS['cn']->query('
							UPDATE `users_links`
							SET `is_friend`=1
							WHERE (`id_user`="'.$follow.'" AND `id_friend`="'.$uid.'") 
								OR  (`id_friend`="'.$follow.'" AND `id_user`="'.$uid.'")
							LIMIT 2;
						');
					}
					if( isset($_GET['debug']) ) echo '<br>Insert amistad amigo='.$follow.' yo='.$uid.' $isFollower='.$isFollower;
					notifications($follow,$follow,$isFollower?5:11);
					updateUsersCounters($uid);
					$res['friend']=updateUsersCounters($follow);
					//envio de email
					$_mail = $GLOBALS['cn']->queryRow('
						SELECT followers_count, friends_count, tags_count
						FROM users
						WHERE id  = "'.$uid.'"
					');
					$photo = FILESERVER.'img/users/'.getUserPicture($_SESSION['ws-tags']['ws-user']['photo']);
					$body = '
						<table width="500" border="0" align="center" cellpadding="2" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
							<tr><td colspan="4" style="text-align:left; font-size:18px; padding:0"><strong>'.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' ('.$_SESSION['ws-tags']['ws-user']['screen_name'].')</strong> '.MAILFALLOWFRIENDS_INOWADMIRE.' Tagbum</td></tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr><td width="62">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							<tr style="text-align:center; font-weight:bold; background-color:#F4F4F4">
								<td rowspan="2" valign="middle" style="border:1px solid #CCC;"><img src="'.$photo.'" width="60" height="60" style="float:right; border:1px solid #999999" /></td>
								<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">Tags</td>
								<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">'.MAILFALLOWFRIENDS_ADMIRERS.'</td>
								<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">'.MAILFALLOWFRIENDS_ADMIRED.'</td>
							</tr>
							<tr style="text-align:center; font-weight:bold; background-color:#F4F4F4">
								<td width="108" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($_mail['tags_count']).'</td>
								<td width="157" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($_mail['followers_count']).'</td>
								<td width="147" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($_mail['friends_count']).'</td>
							</tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr><td colspan="4" style="text-align:center">'.MAILFALLOWFRIENDS_GOTO.' <a href="'.base_url().'">Tagbum</a></td></tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr><td colspan="4" style="border-top:1px solid #999">&nbsp;</td></tr>
							<tr><td colspan="4" style="font-size:10px; color:#CCC; text-align:justify; padding:0">'.MAILFALLOWFRIENDS_MSGDONW.'</td></tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr><td colspan="4">&nbsp;</td></tr>
						</table>
					';
					//echo $body;
					if( !LOCAL ) {
						sendMail(formatMail($body,600), EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), MAILFALLOWFRIENDS_SUBJECT, $email, '../../');
					}//fin envio de email
				}
			}elseif(isset($_GET['unfollow']) && count($link)){//dejar de seguir
				if( isset($_GET['debug']) ) echo 'unfollow';
				$delete	= $GLOBALS['cn']->query('DELETE FROM users_links WHERE id_user = "'.$uid.'" and id_friend = "'.$follow.'"');
				if (!$delete){
					$res['error']='no pudo hacer unlink';
				}else{
					if($isFollower){//si eran amigos ahora es tu seguidor
						$GLOBALS['cn']->query('
							UPDATE `users_links`
							SET `is_friend`=0
							WHERE (`id_user`="'.$follow.'" AND `id_friend`="'.$uid.'")
							LIMIT 1;
						');
						if( isset($_GET['debug']) ) echo '<br>delete amistad amigo='.$follow.' yo='.$uid;
						$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE ((id_friend = "'.$follow.'" AND id_user = "'.$uid.'") OR (id_friend = "'.$uid.'" AND id_user = "'.$follow.'")) AND id_type = 5 LIMIT 1');
						//elimina la notificacion de seguidores
						if( isset($_GET['debug']) ) echo '<br>delete seguidor si yo la envie amigo='.$follow.' yo='.$uid;
						$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE id_user = "'.$uid.'" AND id_friend = "'.$follow.'" AND id_type = 11 LIMIT 1');	
					}else{
						if( isset($_GET['debug']) ) echo '<br>delete seguidor amigo='.$follow.' yo='.$uid;
						//elimina la notificacion de seguidores
						$GLOBALS['cn']->query('DELETE FROM users_notifications WHERE ((id_user = "'.$uid.'" AND id_friend = "'.$follow.'") OR (id_user = "'.$follow.'" AND id_friend = "'.$uid.'")) AND id_type = 11 LIMIT 1');
					}
					updateUsersCounters($uid);
					$res['friend']=updateUsersCounters($follow);
				}
			}
		}else{
			if($uid=='')
				$res['error']='no se ha logeado';
			else
				$res['error']='falta el id de usuario';
		}
		die(jsonp($res));
	}//quitar_inyect()
?>

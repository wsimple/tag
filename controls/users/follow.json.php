<?php
include '../header.json.php';
include RELPATH.'class/class.phpmailer.php';

$res=array();
if( $_GET['uid']!='' && md5($myId)!=$_GET['uid']) {
	$users=CON::getRow("SELECT id,email,username FROM users WHERE md5(id)=?",array($_GET['uid']));
	if (count($users)>0){
		$linked=CON::getVal("SELECT id_friend FROM users_links WHERE id_user=? AND md5(id_friend)=?",array($myId,$_GET['uid']));
		$admirer=CON::getVal("SELECT id_user FROM users_links WHERE md5(id_user)=? AND id_friend=?",array($_GET['uid'],$myId));
		$res['unlink']=$linked?true:false;
		if(!$linked){#seguir a un usuario
			CON::insert('users_links','id_user=?,id_friend=?,is_friend=?',array($myId,$users['id'],($admirer?1:0)));
			if ($admirer) CON::update('users_links','is_friend=1','id_user=? AND id_friend=?',array($users['id'],$myId));
			notifications($users['id'],$users['id'],$admirer?5:11);
			$res['my']=updateUsersCounters(md5($myId));
			$res['friend']=updateUsersCounters($_GET['uid']);
			// $foto_remitente	=FILESERVER.generateThumbPath("img/users/".$_SESSION['ws-tags']['ws-user']['code']."/".$_SESSION['ws-tags']['ws-user']['photo']);

			$uLink=CON::getRow("SELECT id,username FROM users WHERE id=?",array($myId));

			if (trim($uLink['username'])!=''){
				$nameExternal="<a style='color:#999999;text-decoration:none;' href='".DOMINIO.$uLink['username']."' onFocus='this.blur();' target='_blank'>".formatoCadena($_SESSION['ws-tags']['ws-user']['full_name'])." (".$_SESSION['ws-tags']['ws-user']['screen_name'].")</a>";
				$ip = DOMINIO.$uLink['username'];
			}else{
				$nameExternal="<a style='color:#999999; text-decoration: none' href='".DOMINIO.'user/'.md5($_SESSION['ws-tags']['ws-user']['id'])."' onFocus='this.blur();' target='_blank'>".formatoCadena($_SESSION['ws-tags']['ws-user']['full_name'])." (".$_SESSION['ws-tags']['ws-user']['screen_name'].")</a>";
				$ip = DOMINIO.'user/'.md5($_SESSION['ws-tags']['ws-user']['id']);
			}


			// $photo = FILESERVER.generateThumbPath("img/users/".$_SESSION['ws-tags']['ws-user']['code']."/".$_SESSION['ws-tags']['ws-user']['photo']);

			$imgPhoto = '<a href="'.$ip.'" onFocus="this.blur();" target="_blank"><img src="'.FILESERVER.generateThumbPath("img/users/".$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo']).'" width="60" height="60" style="float:right; border:1px solid #999999" /></a>';


			$body = '<table width="500" border="0" align="center" cellpadding="2" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
				<tr><td colspan="4" style="text-align:left; font-size:18px; padding:0"><strong>'.$nameExternal.'</strong> '.MAILFALLOWFRIENDS_INOWADMIRE.' Tagbum</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td width="62">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr style="text-align:center; font-weight:bold; background-color:#F4F4F4">
					<td rowspan="2" valign="middle" style="border:1px solid #CCC;">'.$imgPhoto.'</td>
					<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">Tags</td>
					<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">'.MAILFALLOWFRIENDS_ADMIRERS.'</td>
					<td style="border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC">'.MAILFALLOWFRIENDS_ADMIRED.'</td>
				</tr>
				<tr style="text-align:center; font-weight:bold; background-color:#F4F4F4">
					<td width="108" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($_SESSION['ws-tags']['ws-user']['tags_count']).'</td>
					<td width="157" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($res['my']['admirers']).'</td>
					<td width="147" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($res['my']['admired']).'</td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4" style="text-align:center;">'.MAILFALLOWFRIENDS_GOTO.' <a style="text-decoration: none;color:#999999" href="'.DOMINIO.'">Tagbum</a></td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4" style="border-top:1px solid #999">&nbsp;</td></tr>
				<tr><td colspan="4" style="font-size:10px; color:#CCC; text-align:justify; padding:0">'.MAILFALLOWFRIENDS_MSGDONW.'</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
			</table>';
			if( !LOCAL ){
				//verificar si el usuario tiene inactivo el envio de correo
				$notifiUser=CON::getRow('SELECT md5(id_user) id_user FROM users_config_notifications WHERE md5(id_user)=? and id_notification=?',array($_GET['uid'],$admirer?5:11));
				if($_GET['uid']!=$notifiUser['id_user']){
					sendMail(formatMail($body,600), EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), MAILFALLOWFRIENDS_SUBJECT, $users['email'], '../../');
				}
			}//fin envio de email
		}else{#dejar de seguir a un usuario
			CON::delete('users_links','id_user=? AND id_friend=?',array($myId,$users['id']));
			if($admirer){
				CON::update('users_links','is_friend=0','id_user=? AND id_friend=?',array($users['id'],$myId));
				CON::delete('users_notifications','((id_friend=? AND id_user=?) OR (id_friend=? AND id_user=?)) AND id_type = 5 LIMIT 1',array($users['id'],$myId,$myId,$users['id']));
				CON::delete('users_notifications','id_user=? AND id_friend=? AND id_type = 11 LIMIT 1',array($myId,$users['id']));
			}else{
				CON::delete('users_notifications','((id_friend=? AND id_user=?) OR (id_friend=? AND id_user=?)) AND id_type = 11 LIMIT 1',array($users['id'],$myId,$myId,$users['id']));
			}
			updateUsersCounters(md5($myId));
			$res['friend']=updateUsersCounters($_GET['uid']);
		}
	}else $res['error']='users no exist';
}else{
	if($myId=='') $res['error']='no se ha logeado';
	elseif($_GET['uid']=='') $res['error']='falta el id de usuario';
	else $res['error']='linktome';
}
die(jsonp($res));

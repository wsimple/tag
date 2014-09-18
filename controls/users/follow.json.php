<?php
include '../header.json.php';
include RELPATH.'class/class.phpmailer.php';
if ($myId=='') die(jsonp(array()));
	$res=array();
	if(quitar_inyect()) {
		$uid=$_SESSION['ws-tags']['ws-user']['id'];
		if( $uid!='' && $_GET['uid']!='' && md5($uid)!=$_GET['uid']) {
			$users=CON::getRow("SELECT id,email FROM users WHERE md5(id)=?",array($_GET['uid']));
			if (count($users)>0){
				$link=CON::getVal("SELECT id_friend FROM users_links WHERE id_user=? AND md5(id_friend)=?",array($uid,$_GET['uid']));
				$hislink=CON::getVal("SELECT id_user FROM users_links WHERE md5(id_user)=? AND id_friend=?",array($_GET['uid'],$uid));
				$res['unlink']=$link?true:false;
				if (!$link){
					CON::insert('users_links','id_user=?,id_friend=?,is_friend=?',array($uid,$users['id'],($hislink?1:0)));
					if ($hislink) CON::update('users_links','is_friend=1','id_user=? AND id_friend=?',array($users['id'],$uid));
					notifications($users['id'],$users['id'],$hislink?5:11);
					$res['my']=updateUsersCounters(md5($uid));
					$res['friend']=updateUsersCounters($_GET['uid']);
					$photo = FILESERVER.'img/users/'.getUserPicture($_SESSION['ws-tags']['ws-user']['photo']);
					$body = '<table width="500" border="0" align="center" cellpadding="2" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
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
							<td width="108" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($_SESSION['ws-tags']['ws-user']['tags_count']).'</td>
							<td width="157" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($res['my']['admirers']).'</td>
							<td width="147" style="border-bottom:1px solid #CCC; border-right:1px solid #CCC">'.mskPoints($res['my']['admired']).'</td>
						</tr>
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr><td colspan="4" style="text-align:center">'.MAILFALLOWFRIENDS_GOTO.' <a href="'.base_url().'">Tagbum</a></td></tr>
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr><td colspan="4" style="border-top:1px solid #999">&nbsp;</td></tr>
						<tr><td colspan="4" style="font-size:10px; color:#CCC; text-align:justify; padding:0">'.MAILFALLOWFRIENDS_MSGDONW.'</td></tr>
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr><td colspan="4">&nbsp;</td></tr>
					</table>';
					if( !LOCAL ){
						sendMail(formatMail($body,600), EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), MAILFALLOWFRIENDS_SUBJECT, $users['email'], '../../');
					}//fin envio de email
				}else{
					CON::delete('users_links','id_user=? AND id_friend=?',array($uid,$users['id']));
					if ($hislink){
						CON::update('users_links','is_friend=0','id_user=? AND id_friend=?',array($users['id'],$uid));
						CON::delete('users_notifications','((id_friend=? AND id_user=?) OR (id_friend=? AND id_user=?)) AND id_type = 5 LIMIT 1',array($users['id'],$uid,$uid,$users['id']));
						CON::delete('users_notifications','id_user=? AND id_friend=? AND id_type = 11 LIMIT 1',array($uid,$users['id']));
					}else{
						CON::delete('users_notifications','((id_friend=? AND id_user=?) OR (id_friend=? AND id_user=?)) AND id_type = 11 LIMIT 1',array($users['id'],$uid,$uid,$users['id']));
					}
					updateUsersCounters(md5($uid));
					$res['friend']=updateUsersCounters($_GET['uid']);
				}
			}else $res['error']='users no exist';
		}else{
			if($uid=='') $res['error']='no se ha logeado';
			elseif($_GET['uid']=='') $res['error']='falta el id de usuario';
			else $res['error']='linktome';
		}
	}//quitar_inyect()
	die(jsonp($res));
?>

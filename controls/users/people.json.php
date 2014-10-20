<?php 
include '../header.json.php';
if ($myId=='' || !isset($_GET['action'])) die(jsonp(array()));
$res= array();
switch ($_GET['action']) {
	case 'friendsAndFollow': //amigos admiradores admirados y encontrar amigos
		if (!isset($_GET['mod'])) $_GET['mod']='friends';
		if (!isset($_GET['limit'])) $_GET['limit']=0;
		$numAction=1;
		$coi=isset($_GET['code'])?"md5(concat(id,'_', email,'_',id))":"md5(id)";
		if (!isset($_POST['uid']))	$uid=$myId;
		else $uid=CON::getVal("SELECT id FROM users WHERE $coi=?",array($_POST['uid']));
		if (!$uid) die(jsonp(array('error'=>'noIdValid')));
		// if (!isset($_GET['nolimit'])) $array['limit']='LIMIT '.$_GET['limit'].',30';
		$array['select']=',IF(u.id='.$myId.',1,0) AS iAm,
						(SELECT oul.id_user FROM users_links oul WHERE oul.id_user='.$myId.' AND oul.id_friend=u.id) AS conocido';
		$array['order']='ORDER BY u.name, u.last_name';
		switch ($_GET['mod']) {
			case 'friends': 
				$array['select'].=',md5(ul.id_user) AS id_user, md5(ul.id_friend) AS id_friend';
				$array['join']=' JOIN users_links ul ON ul.id_friend=u.id';
				$array['where']=safe_sql('ul.id_user=? AND ul.is_friend=1',array($uid));
			break;
			case 'unfollow': //admirados
				$array['select'].=',md5(ul.id_user) AS id_user, md5(ul.id_friend) AS id_friend';
				$array['where']=safe_sql('ul.id_user=?',array($uid));
				$array['join']=' JOIN users_links ul ON ul.id_friend=u.id';
			break;
			case 'follow': //admiradores
				$array['select'].=',md5(ul.id_user) AS id_friend, md5(ul.id_friend) AS id_user';
				$array['join']=' JOIN users_links ul ON ul.id_user=u.id';
				$array['where']=safe_sql('ul.id_friend=?',array($uid));
			break;
			case 'find': //encontrar amigos
				$numAction=3;
				$array['join']='';
				$array['select']=',md5(u.id) AS id_user, md5(u.id) AS id_friend,
						IF(u.id='.$myId.',1,0) AS iAm,
						(SELECT oul.id_user FROM users_links oul WHERE oul.id_user='.$myId.' AND oul.id_friend=u.id) AS conocido';
				if (isset($_GET['search'])){
					$searches = explode(' ',$_GET['search']);$where='';$res['where']='';
					foreach ($searches as $word) {
						// AND g.name LIKE ?",array('%'.$hash[0].'%'));
						$where.=safe_sql('AND  CONCAT_WS(" ",u.username,u.last_name,u.screen_name,u.name,u.email) LIKE "%??%"',array($word));
					}
					$array['where']=safe_sql('u.id!=? '.$where,array($uid));
					$array['order']='ORDER BY u.username';
				}else{
					$array['order']='ORDER BY RAND()';
					$array['where']=safe_sql('u.id!=? AND u.id NOT IN ((SELECT ul.id_friend FROM users_links ul WHERE ul.id_user=?)) AND u.id NOT IN ((SELECT ul.id_user FROM users_links ul WHERE ul.id_friend=?))',array($uid,$uid,$uid));
				}
				$res['num']=1;
			break;
		}
		if (!isset($res['num'])) $res['num']=CON::numRows(CON::query("SELECT ul.id_user FROM users_links ul WHERE ".$array['where']));
		$html='';
		if ($res['num']>0){ $query=peoples($array);  } 
		elseif(!isset($_GET['nosugg'])){
			$array['order']='ORDER BY RAND()';
			$array['join']='';
			$array['select']=',md5(u.id) AS id_user, md5(u.id) AS id_friend,
						IF(u.id='.$myId.',1,0) AS iAm,
						(SELECT oul.id_user FROM users_links oul WHERE oul.id_user='.$myId.' AND oul.id_friend=u.id) AS conocido';
			$array['where']=safe_sql('u.id!=? AND u.id NOT IN ((SELECT ul.id_friend FROM users_links ul WHERE ul.id_user=?)) AND u.id NOT IN ((SELECT ul.id_user FROM users_links ul WHERE ul.id_friend=?))',array($uid,$uid,$uid));
			$query=peoples($array);
			if (CON::numRows($query)>0) $html='<div class="ui-single-box-title">'.HOME_SUGGESTFRIENDS.'</div>';
		}
		$info=array();
		while ($row=CON::fetchAssoc($query)){
			$row['name_user']=formatoCadena($row['name_user']);
			$row['photo_friend']=FILESERVER.getUserPicture($row['code_friend'].'/'.$row['photo_friend'],'img/users/default.png');
			$info[]=$row;
			if (isset($_GET['withHtml'])) $html.=htmlfriends($row,$numAction);
		}
		$res['datos']=$info;
		if ($html!='') $res['html']=$html;
	break;
	case 'usersLikesTags':
		if (!isset($_GET['t']) || !isset($_GET['s'])) die(jsonp(array()));
		$numAction=3;
		$array['select']=',md5(u.id) AS id_user, md5(u.id) AS id_friend,
						IF(u.id='.$myId.',1,0) AS iAm,
						(SELECT oul.id_user FROM users_links oul WHERE oul.id_user='.$myId.' AND oul.id_friend=u.id) AS conocido';
		switch ($_GET['t']) {
			case 'l': //likes
				$array['join']=' JOIN likes lk ON lk.id_user=u.id';
				$array['where']=safe_sql(' md5(lk.id_source)=?',array(intToMd5($_GET['s'])));
			break;
			case 'd': //dislikes
				$array['join']=' JOIN dislikes lk ON lk.id_user=u.id';
				$array['where']=safe_sql(' md5(lk.id_source)=?',array(intToMd5($_GET['s'])));
				
			break;
			case 'r': //raffle (mejor conocidos como productos gratis)
				$array['join']=' JOIN store_raffle_join lk ON lk.id_user=u.id';
				$array['where']=safe_sql(' md5(lk.id_raffle)=?',array(intToMd5($_GET['s'])));
			break;
		}
		$query=peoples($array); 
		$info=array();
		while ($row=CON::fetchAssoc($query)){
			$row['photo_friend']=FILESERVER.getUserPicture($row['code_friend'].'/'.$row['photo_friend'],'img/users/default.png');
			$info[]=$row;
			if (isset($_GET['withHtml'])) $html.=htmlfriends($row,$numAction);
		}
		$res['datos']=$info;
		if ($html!='') $res['html']=$html;
	break;
}
die(jsonp($res));

function htmlfriends($row,$numAction=1){
	$foto=$row['photo_friend'];
	$width=!isset($_GET['w'])?'width:450px;':'width:'.$_GET['w'].'px;';
	$body='<div class="divYourFriends thisPeople">
		<div style="float:left; width:80px; cursor:pointer;">
	        <img onclick="userProfile(\''.$row['name_user'].'\',Close,\''.$row['id_friend'].'\')" src="'.$foto.'" border="0"  width="62" height="62" style="border: 1px solid #ccc" />
	    </div>
	    <div style="float:left;'.$width.'">
	        <div style="'.$width.' float: left;">
	            <a href="javascript:void(0);" onclick="userProfile(\''.$row['name_user'].'\',\'Close\',\''.$row['id_friend'].'\')">
	            	<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">
	                '.ucwords($row['name_user']).'</a><br>';
	if($row['username']!=''){
	$body.='<span class="titleField">'.USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.':</span>&nbsp;<a style="color:#ccc; font-size:12px;" href="'.base_url($row['username']).'" onFocus="this.blur();" target="_blank">'.DOMINIO.$row['username'].'</a><br><div class="clearfix"></div>';
	}
	$body.='<span class="titleField">Email:</span>'.$row['email'].'<div class="clearfix"></div>
			<span class="titleField">'.USER_LBLFOLLOWERS.' ('.$row['followers_count'].')</span> 
			<span class="titleField">'.USER_LBLFRIENDS.' ('.$row['friends_count'].')</span><br>';
	if($nameCountryUser!=''){
		$body.='<span class="titleField">'.USERS_BROWSERFRIENDSLABELCOUNTRY.':&nbsp;</span>'.$nameCountryUser['name'].'<div class="clearfix"></div><br>';
	}
	$body.='</div>';
	if ($row['iAm']=='0'){
		$body.='<div style="height:70px; width:0px;float: right; text-align: right;">
	            <input type="button" value="'.USER_BTNLINK.'" action="linkUser,'.$row['id_friend'].','.$numAction.'" '.($row['conocido']?'style="display:none"':'').'/>					
				<input type="button" value="'.USER_BTNUNLINK.'" action="linkUser,'.$row['id_friend'].','.$numAction.'" '.($row['conocido']?'':'style="display:none"').' />
	        </div>';
	}        
	$body.='</div><div class="clearfix"></div></div>';
	return $body;
}

?>
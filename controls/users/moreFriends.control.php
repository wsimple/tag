<?php
include('../../includes/config.php');
include('../../includes/functions.php');
include('../../class/wconecta.class.php');
include('../../includes/languages.config.php');

//		 $page=$_GET[page_count_num_sql];
//
//		 $controlFriends = $GLOBALS['cn']->query("SELECT id_user,url FROM control_see_more WHERE url = 'controls/users/moreFriends.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user']['id']."'");
//		 $controlFriend = mysql_num_rows($controlFriends);
//
//		 if($controlFriend!=0){
//		 		$controlFriendsSuma = $GLOBALS['cn']->query("SELECT id_user,cantidad FROM control_see_more WHERE url = 'controls/users/moreFriends.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user']['id']."'");
//		 		$controlFriendSum = mysql_fetch_assoc($controlFriendsSuma);
//
//				$sum = ($controlFriendSum[cantidad]+$page);
//		 		$query = $GLOBALS['cn']->query("UPDATE control_see_more SET cantidad = '".$sum."' WHERE url = 'controls/users/moreFriends.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user']['id']."'");
//
//		 }else{
//
//		 		$query = $GLOBALS['cn']->query("INSERT INTO control_see_more (id_user,url,cantidad) values ('".$_SESSION['ws-tags']['ws-user']['id']."','controls/users/moreFriends.control.php','".$page."')");
//
//		 }
	  if(!isset($_SESSION['ws-tags']['see_more']['friends'])){
			$_SESSION['ws-tags']['see_more']['friends'] = 50;
	  }else{
			$_SESSION['ws-tags']['see_more']['friends']+= 50;
	  }

	$id=="";
	$user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
	dropViews(array("view_friends"));

	//los que el usuario sigue
	$friends = $GLOBALS['cn']->query("CREATE VIEW view_friends AS
										SELECT DISTINCT
											   l.id_user AS id_user,
											   l.id_friend as id_friend,
											   u.screen_name,
											   CONCAT(u.name, ' ', u.last_name) AS name_user,
											   u.profile_image_url  AS photo_friend,
											   u.email as email,
											   u.home_phone,
											   u.mobile_phone,
											   u.work_phone,
											   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend
										FROM users u INNER JOIN users_links l ON u.id=l.id_friend
										WHERE md5(l.id_user)='".$user."';
					                   ");
	//amigos
	$friends = $GLOBALS['cn']->query("SELECT f.id_friend AS id_friend,
											   f.name_user AS name_user,
											   f.photo_friend AS photo_friend,
											   f.code_friend AS code_friend,
											   f.email as email,
											   f.home_phone,
											   f.screen_name,
											   f.mobile_phone,
											   f.work_phone
										FROM view_friends200 f INNER JOIN users_links u ON f.id_friend=u.id_user
										WHERE md5(u.id_friend) = '".$user."'
										LIMIT ".($_SESSION['ws-tags']['see_more']['friends']).", 50;
									  ");

	$num=mysql_num_rows($friends);
	while($friend=mysql_fetch_assoc($friends)){

	$html .=
		'<div id="div_f'.md5($friend['id_friend']).'" class="divYourFriends" ">
			<div style="float:left; width:80px; cursor:pointer">
				<img onclick="userProfile(\''.$friend['name_user'].'\',\'Close\',\''.md5($friend['id_friend']).'\')" src="'.FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png').'" border="0"  width="65" height="65" style=" border:1px solid #ccc;" />
			</div>
			<div style="float:right; width:155px; height:75px;">
				<p style="height:20px; width:100%">
					<a href="#" onclick="userProfile(\''.$friend['name_user'].'\',\'Close\',\''.md5($friend['id_friend']).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').')"
					onfocus="this.blur();" title="View User Profile">
						'.$friend['name_user'].'
					</a>
				</p>
				<p style="text-align:left">
					<input name="btn_link_s'.md5($friend['id_friend']).'"
						id="btn_link_s'.md5($friend['id_friend']).'"
						type="button" value="'.USER_BTNUNLINK.'"
						onclick="unLinkUserFallowing(\'#div_f'.md5($friend['id_friend']).'\', \''.md5($friend['id_friend']).'\', \''.md5(rand()).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').');" />
				</p>
			</div>
		</div>';

	}//while

	//sleep(2);
	echo $html.'|'.$num;

?>
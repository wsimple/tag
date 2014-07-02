<?php
		session_start();
		include ("../../includes/functions.php");
 		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php");

//		 $page=$_GET[page_count_num_sql];
//
//		 $controlFollowings = $GLOBALS['cn']->query("SELECT id_user,url FROM control_see_more WHERE url = 'controls/users/moreFollowing.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user']['id']."'");
//		 $controlFollowing = mysql_num_rows($controlFollowings);
//
//		 if($controlFollowing!=0){
//		 		$controlFollowingSuma = $GLOBALS['cn']->query("SELECT id_user,cantidad FROM control_see_more WHERE url = 'controls/users/moreFollowing.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user']['id']."'");
//		 		$controlFollowingSum = mysql_fetch_assoc($controlFollowingSuma);
//
//				$sum = ($controlFollowingSum[cantidad]+$page);
//		 		$query = $GLOBALS['cn']->query("UPDATE control_see_more SET cantidad = '".$sum."' WHERE url = 'controls/users/moreFollowing.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user']['id']."'");
//
//		 }else{
//
//		 		$query = $GLOBALS['cn']->query("INSERT INTO control_see_more (id_user,url,cantidad) values ('".$_SESSION['ws-tags']['ws-user']['id']."','controls/users/moreFollowing.control.php','".$page."')");
//
//		 }

		  if(!isset($_SESSION['ws-tags']['see_more']['following'])){ $_SESSION['ws-tags']['see_more']['following'] = 50;
		  }else{ $_SESSION['ws-tags']['see_more']['following']+= 50; }

		$id = "";
	    $user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
		$followings = $GLOBALS['cn']->query("
											SELECT
												   l.id_user AS id_user,
												   l.id_friend as id_friend,
												   CONCAT(u.`name`, ' ', u.last_name) AS name_user,
												   u.profile_image_url AS photo_friend,
												   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend
											FROM users u INNER JOIN users_links l ON u.id=l.id_friend
											WHERE md5(l.id_user) = '".$user."'
											ORDER BY name_user ASC
											LIMIT ".($_SESSION['ws-tags']['see_more']['following']).", 50;
		                                  ");

		$num=mysql_num_rows($followings);
		while($following=mysql_fetch_assoc($followings)){
		$html .=

			'<div id="div_f'.md5($following['id_friend']).'" class="divYourFriends" ">
				<div style="float:left; width:80px; cursor:pointer">
					<img onclick="userProfile(\''.$following['name_user'].'\',\'Close\',\''.md5($following['id_friend']).'\')" src="'.FILESERVER.getUserPicture($following['code_friend'].'/'.$following['photo_friend'],'img/users/default.png').'" border="0" width="65" height="65" style=" border:1px solid #ccc;"/>
				</div>
				<div style="float:right; width:155px; height:75px;">
					<p style="height:20px; width:100%">
						<a href="#" onclick="userProfile(\''.$following['name_user'].'\',\'Close\',\''.md5($following['id_friend']).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').')"
						onfocus="this.blur();" title="View User Profile">
							'.$following['name_user'].'
						</a>
					</p>

					<p style="text-align:left">
						<input name="btn_link_s'.md5($following['id_friend']).'"
							id="btn_link_s'.md5($following['id_friend']).'"
							type="button" value="'.USER_BTNUNLINK.'"
							onclick="unLinkUserFallowing(\'#div_f'.md5($following['id_friend']).'\', \''.md5($following['id_friend']).'\', \''.md5(rand()).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').');" />
					</p>
				</div>
			</div>';

		}//while

		//sleep(2);
		echo $page.'|'.$html.'|'.$num;
?>
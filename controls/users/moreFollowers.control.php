<?php
		session_start();
		include ("../../includes/functions.php");
 		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php");

//		 $page=$_GET[page_count_num_sql];
//		 $controlFollowers = $GLOBALS['cn']->query("SELECT id_user,url FROM control_see_more WHERE url = 'controls/users/moreFollowers.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user'][id]."'");
//		 $controlFollower = mysql_num_rows($controlFollowers);
//
//		 if($controlFollower!=0){
//		 		$controlFollowersSuma = $GLOBALS['cn']->query("SELECT id_user,cantidad FROM control_see_more WHERE url = 'controls/users/moreFollowers.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user'][id]."'");
//		 		$controlFollowersSum = mysql_fetch_assoc($controlFollowersSuma);
//
//				$sum = ($controlFollowersSum[cantidad]+$page);
//		 		$query = $GLOBALS['cn']->query("UPDATE control_see_more SET cantidad = '".$sum."' WHERE url = 'controls/users/moreFollowers.control.php' AND id_user ='".$_SESSION['ws-tags']['ws-user'][id]."'");
//
//		 }else{
//
//		 		$query = $GLOBALS['cn']->query("INSERT INTO control_see_more (id_user,url,cantidad) values ('".$_SESSION['ws-tags']['ws-user'][id]."','controls/users/moreFollowers.control.php','".$page."')");
//
//		 }

		  if(!isset($_SESSION['ws-tags']['see_more']['followers'])){ $_SESSION['ws-tags']['see_more']['followers'] = 50;
		  }else{ $_SESSION['ws-tags']['see_more']['followers']+= 50; }

		 $id = "";


		 //amigos


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
											FROM view_friends f INNER JOIN users_links u ON f.id_friend=u.id_user
											WHERE md5(u.id_friend) = '".$user."';
										  ");
		//end amigos

		while($friend = mysql_fetch_assoc($friends))
		{
			$not_ids .= "'".$friend['id_friend']."',";
		}

	     $no_id=rtrim($not_ids,',');

		 $not_ids = ($not_ids!='') ? " AND l.id_user NOT IN (".$no_id.")" : "";

		 $followers = $GLOBALS['cn']->query("
											SELECT l.id_user AS id_user,
												   l.id_friend as id_friend,
												   CONCAT(u.`name`, ' ', u.last_name)  AS name_user,
												   u.profile_image_url AS photo_friend,
												   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend
											FROM users u INNER JOIN users_links l ON u.id=l.id_user
											WHERE md5(l.id_friend)='".$user."' ".$not_ids."
											LIMIT ".($_SESSION['ws-tags']['see_more']['followers']).", 50;
		");


		$num=mysql_num_rows($followers);

		while($follower=mysql_fetch_assoc($followers))
		{ if (!isFriend($follower['id_user'])){

		$html .=

			'<div id="div_f'.md5($follower['id_friend']).'" class="divYourFriends" ">

				<div style="float:left; width:80px; cursor:pointer">
					<img onclick="userProfile(\''.$follower['name_user'].'\',\'Close\',\''.md5($follower['id_friend']).'\')" src="'.FILESERVER.getUserPicture($follower['code_friend'].'/'.$follower['photo_friend'],'img/users/default.png').'" border="0"  width="65" height="65" style=" border:1px solid #ccc;" />
				</div>

				<div style="float:right; width:155px; height:75px;">
					<p style="height:20px; width:100%">
						<a href="#" onclick="userProfile(\''.$follower['name_user'].'\',\'Close\',\''.md5($follower['id_friend']).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').')"
						onfocus="this.blur();" title="View User Profile">
							'.$follower['name_user'].'
						</a>
					</p>
					<p style="text-align:left">
						<input name="btn_link_s'.md5($follower['id_friend']).'"
							id="btn_link_s'.md5($follower['id_friend']).'"
							type="button" value="'.USER_BTNUNLINK.'"
							onclick="linkUser(\'#div_f'.md5($follower['id_friend']).'\', \''.md5($follower['id_friend']).'\', \''.md5(rand()).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').');" />

						<input name="btn_unlink_'.md5($follower['id_user']).'"
							id="btn_link_s'.md5($follower['id_user']).'"
							type="button" value="'.USER_BTNUNLINK.'"
							onclick="unLinkUser(\'#div_f'.md5($follower['id_user']).'\', \''.md5($follower['id_user']).'\''.($_SESSION['ws-tags']['ws-user']['fullversion']==1?',true':'').');" style="display:none" />

					</p>


				</div>
			</div>';
			}//nofriend
		}//while

		//sleep(2);
		echo $page.'|'.$html.'|'.$num;
?>
<?php 
			session_start();
			include ("../../includes/functions.php");
			
	 		include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");

function view_friends_1($id=""){
		 $user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user'][id]) : md5($id);
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

											WHERE md5(u.id_friend) = '".$user."'

											;
										  ");
		 return $friends;
}


function followers_2($id="", $not_ids=""){
	     $user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user'][id]) : md5($id);
         
		 $not_ids = ($not_ids!='') ? " AND l.id_user NOT IN (".$not_ids.")" : "";
		     
		 $followers = $GLOBALS['cn']->query("
											SELECT l.id_user AS id_user,

												   l.id_friend as id_friend,

												   CONCAT(u.`name`, ' ', u.last_name)  AS name_user,

												   u.profile_image_url AS photo_friend,
												   
												   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend

											FROM users u INNER JOIN users_links l ON u.id=l.id_user

											WHERE md5(l.id_friend)='".$user."' ".$not_ids."

											;
										  ");
		 return $followers;
}


function following_3($id=""){
	     $user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user'][id]) : md5($id);

		 $following = $GLOBALS['cn']->query("
											SELECT
												   l.id_user AS id_user,

												   l.id_friend as id_friend,

												   CONCAT(u.`name`, ' ', u.last_name) AS name_user,

												   u.profile_image_url AS photo_friend,

												   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend

											FROM users u INNER JOIN users_links l ON u.id=l.id_friend

											WHERE md5(l.id_user) = '".$user."'

											;
										  ");
		 return $following;
}

		$friends = view_friends_1();
		$friend_total = mysql_num_rows($friends);
		while($friend = mysql_fetch_assoc($friends)){

 			$not_ids .= "'".$friend[id_friend]."',";
		}

		$followers = followers_2("", rtrim($not_ids,',')); 				  
		$follower_total=mysql_num_rows($followers);

		$followings = following_3(); 
		$following_total=mysql_num_rows($followings);


		echo $friend_total."|".$follower_total."|".$following_total;


?>
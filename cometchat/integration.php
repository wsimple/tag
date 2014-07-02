<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','0');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','0');		
define('INCLUDE_JQUERY','1');	
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

define('DB_SERVER',					'localhost'						    );
define('DB_PORT',					'3306'									);
define('DB_USERNAME',				'db_seemytag_user'						);
define('DB_PASSWORD',				'4kUHbM7KiadrHwOyUPiadr4kUH'			);
define('DB_NAME',					'seemytag'  							);
define('TABLE_PREFIX',				''							            );
define('DB_USERTABLE',				'users'									);
define('DB_USERTABLE_NAME',			'screen_name'							);
define('DB_USERTABLE_USERID',		'id'								    );
define('DB_USERTABLE_LASTACTIVITY',	'lastChatActivity'						);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

function getUserID() {
	$userid = 0;
	
	if (!empty($_SESSION['ws-tags']['ws-user'][id])) {
		$userid = $_SESSION['ws-tags']['ws-user'][id];
	}

	return $userid;
}


function getFriendsList($userid,$time) {
	
	$sql = ("SELECT 		u.id userid, 
			u.screen_name username,
			u.lastChatActivity lastactivity,
			CONCAT(md5(CONCAT(u.id, '_', u.email, '_', u.id)),'/',u.profile_image_url) avatar,
			if(u.username IS NOT NULL,u.username,CONCAT('#loadExternalProfile_?userIdExternalProfile=',MD5(u.id))) link, 
			cometchat_status.message,
			cometchat_status.status
			
	 FROM (users_links a INNER JOIN users_links b ON a.id_user=b.id_friend AND b.id_user=a.id_friend 
					   INNER JOIN users u ON u.id=a.id_friend) 
					   left join cometchat_status on u.id = cometchat_status.userid 
					   WHERE a.id_user='".mysql_real_escape_string($userid)."' order by username asc");
	
	
	return $sql;
}

function getUserDetails($userid) {
	$sql = ("select u.id userid, 
					u.screen_name username, 
					u.lastChatActivity lastactivity,  
					CONCAT(md5(CONCAT(u.id, '_', u.email, '_', u.id)),'/',u.profile_image_url) avatar,
			        if(u.username IS NOT NULL,u.username,CONCAT('#loadExternalProfile_?userIdExternalProfile=',MD5(u.id))) link,
					cometchat_status.message, 
					cometchat_status.status 
			from users u 
			     left join cometchat_status on u.id = cometchat_status.userid 
				 where u.id = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("update `users` set lastChatActivity = '".getTimeStamp()."' where id = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysql_real_escape_string($userid)."'");
	 return $sql;
}

function getLink($link) {
   return $link;
}

#funciones para obtener el avatar del usuario
define('FILESERVER','http://seemytagdemo.com/');
function fileExistsRemote($path){
    return (@fopen($path,'r')==true);
}
function getAvatar($photo) {
	$path='img/users/';
	$default=FILESERVER.$path.'default.png';
	if(strpos($photo,$path)===false) $photo=$path.$photo;
	$photo=FILESERVER.$photo;
	if(preg_match('/\S+\.\S+$/',$photo)){
		$thumb=preg_replace('/(\.\S+)$/','_thumb$1',$photo);
		if(fileExistsRemote($thumb))
			return $thumb;
		elseif(fileExistsRemote($photo))
			return $photo;
	}
	return $default;
}

function getTimeStamp() {
	return time();
}

function processTime($time) {
	return $time;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).'/license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
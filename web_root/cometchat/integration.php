<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('SWITCH_ENABLED','0');		
define('INCLUDE_JQUERY','1');	
define('FORCE_MAGIC_QUOTES','0');

define('WEB_SERVER','http://tagbum.com'	);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW

define('DB_SERVER',					$config->db->host		);
define('DB_PORT',					'3306'					);
define('DB_USERNAME',				$config->db->user		);
define('DB_PASSWORD',				$config->db->pass		);
define('DB_NAME',					$config->db->data		);
define('TABLE_PREFIX',				''						);
define('DB_USERTABLE',				'users'					);
define('DB_USERTABLE_USERID',		'id'					);
define('DB_USERTABLE_NAME',			'screen_name'			);
define('DB_AVATARTABLE',			" "						);
#personalizados
$usr_table=TABLE_PREFIX.DB_USERTABLE;
define('DB_AVATARFIELD'," CONCAT(md5(CONCAT($usr_table.id,'_',$usr_table.email,'_',$usr_table.id)),'/',$usr_table.profile_image_url) ");
define('DB_USERTABLE_USERLINK'," IF(TRIM(IFNULL($usr_table.username,''))!='',$usr_table.username,$usr_table.id) ");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

function getUserID() {
	$userid = 0;
	#tag
	if (!empty($_SESSION['ws-tags']['ws-user']['id'])) {
		$userid=intval($_SESSION['ws-tags']['ws-user']['id']);
	}
	return $userid;
	#end tag
	if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
		$_REQUEST['basedata'] = $_SESSION['basedata'];
	}

	if (!empty($_REQUEST['basedata'])) {
	
		if (function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
			$key = "";
			if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
				$key = KEY_A.KEY_B.KEY_C;
			}
			$uid = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(rawurldecode($_REQUEST['basedata'])), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
			if (intval($uid) > 0) {
				$userid = $uid;
			}
		} else {
			$userid = $_REQUEST['basedata'];
		}
	}
	if (!empty($_SESSION['userid'])) {
		$userid = $_SESSION['userid'];
	}

	$userid = intval($userid);
	return $userid;
}

function chatLogin($userName,$userPass) {
	return getUserID();
	#desactivado login por chat
	$userid = 0;
	if (filter_var($userName, FILTER_VALIDATE_EMAIL)) {
		$sql = ("SELECT * FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE email ='".$userName."'");
	} else {
		$sql = ("SELECT * FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE username ='".$userName."'"); 
	}
	$result = mysqli_query($GLOBALS['dbh'],$sql);
	$row = mysqli_fetch_assoc($result);
	$salted_password = md5($row1['value'].$userPass.$row['salt']);
	if($row['password'] == $salted_password) {
		$userid = $row['user_id'];
                if (isset($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp') {
                    $sql = ("insert into cometchat_status (userid,isdevice) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','1') on duplicate key update isdevice = '1'");
                    mysqli_query($GLOBALS['dbh'], $sql);
                }
	}
	if($userid && function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
		$key = "";
			if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
				$key = KEY_A.KEY_B.KEY_C;
			}
		$userid = rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $userid, MCRYPT_MODE_CBC, md5(md5($key)))));
	}

	return $userid;
}

function getFriendsList($userid,$time) {
	global $hideOffline;
	#original retocado
	$user_table=TABLE_PREFIX.DB_USERTABLE;
	$friends=TABLE_PREFIX.'friends';
	$values="$user_table.".DB_USERTABLE_USERID." userid, $user_table.".DB_USERTABLE_NAME." username, ".DB_USERTABLE_USERLINK." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice";
	$order='order by lastactivity desc, status';
	$limit='limit 40';
	$join="left join cometchat_status on $user_table.".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE;
	$sql = ("select DISTINCT $values
		from $friends join $user_table on $friends.toid = $user_table.".DB_USERTABLE_USERID." $join
		where $friends.fromid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'
		$order");
	#tag
	$friends=TABLE_PREFIX.'users_links';
	$join=" join $friends f on f.id_user=$user_table.id $join ";
	$where="f.is_friend AND f.id_friend = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'";
	$sql = ("select DISTINCT $values from $user_table $join where $where $order $limit");
	#end tag
	if ((defined('MEMCACHE') && MEMCACHE <> 0) || DISPLAY_ALL_USERS == 1) {
		$offlinecondition = '';
		if ($hideOffline) {
			$offlinecondition = "AND ((cometchat_status.lastactivity > (".mysqli_real_escape_string($GLOBALS['dbh'],$time)."-".((ONLINE_TIMEOUT)*2).")) OR cometchat_status.isdevice = 1) and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline')";
		}
		$sql = ("select DISTINCT $values from $user_table $join where $where $offlinecondition $order $limit");
	}
	return $sql;
}

function getFriendsIds($userid) {

	$sql = ("SELECT toid as friendid FROM `friends` WHERE status =1 and fromid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' union SELECT fromid as myfrndids FROM `friends` WHERE status =1 and toid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

	return $sql;
}

function getUserDetails($userid) {
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".DB_USERTABLE_USERLINK." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("insert into cometchat_status (userid,lastactivity) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','".getTimeStamp()."') on duplicate key update lastactivity = '".getTimeStamp()."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
	 return $sql;
}

function fetchLink($link) {
	$link=trim($link);
	return preg_match('/\D/',$link)?$link:'user/'.md5($link);
}

function fileExistsRemote($path){
	return (@fopen($path,'r')==true);
}

function getAvatar($image) {
	#tag
	global $config;
	$path='img/users/';
	$default=$config->img_server.$path.'default.png';
	$photo=$image;
	if(strpos($photo,$path)===false) $photo=$path.$photo;
	$photo=$config->img_server.$photo;
	if(preg_match('/\.[^\.]+$/',$photo)){
		$thumb=preg_replace('/(\.[^\.]+)$/','_thumb$1',$photo);
		if(fileExistsRemote($thumb))
			return $thumb;
		elseif(fileExistsRemote($photo))
			return $photo;
	}
	return $default;
	#end tag
	return BASE_URL.'images/noavatar.png';
}

function getTimeStamp() {
	return time();
}

function processTime($time) {
	return $time;
}

if (!function_exists('getLink')) {
  	function getLink($userid) { return fetchLink($userid); }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$to,$unsanitizedmessage) {
	
}

function hooks_updateLastActivity($userid) {
    
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

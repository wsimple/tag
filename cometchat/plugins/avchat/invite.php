<?php

/*

CometChat
Copyright (c) 2011 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts 
retains ownership of the Software and any copies of it, regardless of the 
form in which the copies may exist. This license is not a sale of the 
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each 
installed instance of the Software, a separate license is required. 
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts. 

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form. 

The Software source code may be altered (at your risk) 

All Software copyright notices within the scripts must remain unchanged (and visible). 

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to, 
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets, 
software piracy, and patents held by individuals, corporations, or other entities. 

If any of the terms of this Agreement are violated, Inscripts reserves the right 
to revoke the Software license at any time. 

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php";
include dirname(__FILE__).DIRECTORY_SEPARATOR."config.php";
include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";

if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
	include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
}

if ($rtl == 1) {
	$rtl = "_rtl";
} else {
	$rtl = "";
}

if (!file_exists(dirname(__FILE__)."/themes/".$theme."/avchat".$rtl.".css")) {
	$theme = "default";
}

function invite() {
	global $userid;
	global $theme;
	global $avchat_language;
	global $rtl;
	global $language;

	$status['available'] = $language[30];
	$status['busy'] = $language[31];
	$status['offline'] = $language[32];
	$status['invisible'] = $language[33];
	$status['away'] = $language[34];

	$id = $_GET['roomid'];

	$time = getTimeStamp();
	$buddyList = array();
	$sql = getFriendsList($userid,$time);

	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

	while ($chat = mysql_fetch_array($query)) {

		if ((($time-processTime($chat['lastactivity'])) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') {
			if ($chat['status'] != 'busy' && $chat['status'] != 'away') {
				$chat['status'] = 'available';
			}
		} else {
			$chat['status'] = 'offline';
		}
	
		$avatar = getAvatar($chat['avatar']);

		if (!empty($chat['username'])) {
			if (function_exists('processName')) {
				$chat['username'] = processName($chat['username']);
			}

			$buddyList[] = array('id' => $chat['userid'], 'n' => $chat['username'], 's' => $chat['status'], 'a' => $avatar);
		}
	}

	if (function_exists('hooks_forcefriends') && is_array(hooks_forcefriends())) {
		$buddyList = array_merge(hooks_forcefriends(),$buddyList);
	}

	$number = 0;

	$s['available'] = '';
	$s['away'] = '';
	$s['busy'] = '';
	$s['offline'] = '';

	foreach ($buddyList as $buddy) {
		++$number;
		$s[$buddy['s']] .= '<div class="invite_1"><div class="invite_2" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;"><img height=30 width=30 src="'.$buddy['a'].'"></div><div class="invite_3" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;">'.$buddy['n'].'<br/><span style="color:#999">'.$status[$buddy['s']].'</span></div><input type="checkbox" name="invite[]" value="'.$buddy['id'].'" id="check_'.$buddy['id'].'" class="invite_4"></div>';
		if ($number%2 == 0) {
			echo '<div style="clear:both"></div>';
			$number = 0;
		}
	}

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<title>{$avchat_language[18]}</title> 
<link type="text/css" rel="stylesheet" media="all" href="themes/{$theme}/avchat{$rtl}.css" /> 
</head>
<body>
<form method="post" action="invite.php?action=inviteusers">
<div class="container2">
<div style="background-color:#3E92BD;border-bottom:1px solid #11648F;">
	<div class="invitetitle">{$avchat_language[16]}</div><div style="float:right"><input type=submit value="{$avchat_language[17]}" class="invitebutton"></div>
	<div style="clear:both"></div>
</div>

<div style="height:162px;overflow-x:hidden;overflow-y:scroll;clear:both;padding-left:5px;padding-top:5px;padding-bottom:5px;">{$s['available']}{$s['away']}{$s['offline']}</div>
</div>

<input type="hidden" name="roomid" value="$id">
</form>
</body>
</html>
EOD;
}

function inviteusers() {
	global $theme;
	global $avchat_language;
	global $rtl;
	global $userid;

	foreach ($_POST['invite'] as $user) {
		sendMessageTo($user,"{$avchat_language[14]}<a href=\"javascript:jqcc.ccavchat.accept_fid('{$userid}','{$_POST['roomid']}')\">{$avchat_language[15]}</a>");
	}

	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<title>{$avchat_language[13]}</title> 
<link type="text/css" rel="stylesheet" media="all" href="themes/{$theme}/avchat{$rtl}.css" /> 
</head>
<body onload="setTimeout('window.close()',2000)">

<div class="container2">

<div class="invitesuccess">{$avchat_language[12]}<br/><span class="invitesuccessclose">{$avchat_language[11]}</span></div>
</div>

</body>
</html>
EOD;
}

if (!empty($_GET['action']) && function_exists($_GET['action'])) {
	call_user_func($_GET['action']);
} else {
	call_user_func('invite');
}
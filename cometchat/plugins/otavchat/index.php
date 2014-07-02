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

if (!file_exists(dirname(__FILE__)."/themes/".$theme."/otavchat".$rtl.".css")) {
	$theme = "default";
}

if ($p_<4) exit;

require_once dirname(__FILE__).'/sdk/API_Config.php';
require_once dirname(__FILE__).'/sdk/OpenTokSDK.php';

if ($_GET['action'] == 'request') {
	$apiObj = new OpenTokSDK($apiKey, $apiSecret);
		
	$location = time();

	if (!empty($_SERVER['REMOTE_ADDR'])) {
		$location = $_SERVER['REMOTE_ADDR'];
	}

	$session = $apiObj->create_session($location); 
	$sessionid = $session->getSessionId();

	sendMessageTo($_REQUEST['to'],$otavchat_language[2]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccotavchat.accept('".$userid."','".$sessionid."');\">".$otavchat_language[3]."</a> ".$otavchat_language[4]);

	sendSelfMessage($_REQUEST['to'],$otavchat_language[5]);

	
	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'()';
	}

}

if ($_GET['action'] == 'accept') {
	sendMessageTo($_REQUEST['to'],$otavchat_language[6]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccotavchat.accept_fid('".$userid."','".$_REQUEST['grp']."');\">".$otavchat_language[7]."</a>");

	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'()';
	}

}

if ($_GET['action'] == 'call') {
	$sessionid = $_GET['grp'];
	$apiObj = new OpenTokSDK($apiKey, $apiSecret);
	$token = $apiObj->generate_token();

	if (!empty($_GET['chatroommode'])) {
		if (empty($_GET['join'])) {
			sendChatroomMessage($sessionid,$otavchat_language[19]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccotavchat.join('".$_GET['grp']."');\">".$otavchat_language[20]."</a>");
		}

		$sql = ("select vidsession from cometchat_chatrooms where id = '".mysql_real_escape_string($sessionid)."'");
		$query = mysql_query($sql);
		$chatroom = mysql_fetch_array($query);

		if (empty($chatroom['vidsession'])) {
			$session = $apiObj->create_session(time());
			$newsessionid = $session->getSessionId();

			$sql = ("update cometchat_chatrooms set  vidsession = '".mysql_real_escape_string($newsessionid)."' where id = '".mysql_real_escape_string($sessionid)."'");
			$query = mysql_query($sql);

			$sessionid = $newsessionid;

		} else {
			$sessionid = $chatroom['vidsession'];
		}

	}


	$name = "";

    $sql = getUserDetails($userid);

	if ($guestsMode && $userid >= 10000000) {
		$sql = getGuestDetails($userid);
	}

	$result = mysql_query($sql);
	
	if($row = mysql_fetch_array($result)) {
		
		if (function_exists('processName')) {
			$row['username'] = processName($row['username']);
		}

		$name = $row['username'];
	}

	$name = urlencode($name);


	echo <<<EOD
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
		<title>{$otavchat_language[8]}</title> 
		<link href="otchat.css" type="text/css" rel="stylesheet" >
		<script src="http://static.opentok.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
			var apiKey = {$apiKey};
			var sessionId = '{$sessionid}';
			var token = '{$token}';
			
			var session;
			var publisher;
			var subscribers = {};
			var totalStreams = 0;
 			
			if (TB.checkSystemRequirements() != TB.HAS_REQUIREMENTS) {
				alert('Sorry, but your computer configuration does not meet minimum requirements for video chat.');
			} else {
				session = TB.initSession(sessionId);
				session.addEventListener('sessionConnected', sessionConnectedHandler);
				session.addEventListener('sessionDisconnected', sessionDisconnectedHandler);
				session.addEventListener('connectionCreated', connectionCreatedHandler);
				session.addEventListener('connectionDestroyed', connectionDestroyedHandler);
				session.addEventListener('streamCreated', streamCreatedHandler);
				session.addEventListener('streamDestroyed', streamDestroyedHandler);
			}
 
			function connect() {
				session.connect(apiKey, token);
			}
			
			function disconnect() {
				unpublish();
				session.disconnect();
				hide('navigation');
				show('endcall');
				var div = document.getElementById('canvas');	div.parentNode.removeChild(div);
				window.resizeTo(300,330);
			}
 
			function publish() {
				if (!publisher) {
					var parentDiv = document.getElementById("myCamera");
					var div = document.createElement('div');		
					div.setAttribute('id', 'opentok_publisher');
					parentDiv.appendChild(div);
					var params = {width: '{$vidWidth}', height: '{$vidHeight}', name: '{$name}'};
					publisher = session.publish('opentok_publisher', params); 	
					resizeWindow();
					show('unpublishLink');
					hide('publishLink');
				}
			}
 
			function unpublish() {

				if (publisher) {
					session.unpublish(publisher);
				}
				
				publisher = null;
				
				show('publishLink');
				hide('unpublishLink');
				resizeWindow();
			}

			function resizeWindow() {
				if (publisher) {
					width = (totalStreams+1)*({$vidWidth}+30);
					document.getElementById('canvas').style.width = (totalStreams+1)*{$vidWidth}+'px';
				} else {
					width = (totalStreams)*({$vidWidth}+30);
					document.getElementById('canvas').style.width = (totalStreams)*{$vidWidth}+'px';
				}

				if (width < {$vidWidth}+30) { width = {$vidWidth}+30; }
				if (width < 300) { width = 300; }

				window.resizeTo(width,{$vidHeight}+165);

				var h = {$vidHeight};
				if( typeof( window.innerWidth ) == 'number' ) {
					h = window.innerHeight;
				} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
					h = document.documentElement.clientHeight;
				} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
					h = document.body.clientHeight;
				}

				if (document.getElementById('canvas') && document.getElementById('canvas').style.display != 'none') {
					if (h > {$vidHeight}){
						offset = (h-30-{$vidHeight})/2;
						document.getElementById('canvas').style.marginTop = offset+'px';
					} else {
						document.getElementById('canvas').style.marginTop = '0px';
					}
				}

			}
			
			function sessionConnectedHandler(event) {
				
				hide('loading');
				show('canvas');
				
				if (event.groups.length > 0) {
				    globalGroup = event.groups[0];
					globalGroup.enableEchoSuppression();
				}

				for (var i = 0; i < event.streams.length; i++) {

					if (event.streams[i].connection.connectionId != session.connection.connectionId) {
						totalStreams++;
					}
					addStream(event.streams[i]);
				}

				publish();

				resizeWindow();
				show('navigation');
				show('unpublishLink');
				show('disconnectLink');
				hide('publishLink');
			}
 
			function streamCreatedHandler(event) {

				for (var i = 0; i < event.streams.length; i++) {
					if (event.streams[i].connection.connectionId != session.connection.connectionId) {
						totalStreams++;
					}
					addStream(event.streams[i]);
				}
				resizeWindow();
			}
 
			function streamDestroyedHandler(event) {

				for (var i = 0; i < event.streams.length; i++) {
					if (event.streams[i].connection.connectionId != session.connection.connectionId) {
						totalStreams--;
					}
				}
				resizeWindow();
			}
 
			function sessionDisconnectedHandler(event) {
				publisher = null;
			}
 
			function connectionDestroyedHandler(event) {
			}
 
			function connectionCreatedHandler(event) {
			}
			
			function exceptionHandler(event) {
			}
			
			function addStream(stream) {
			
				if (stream.connection.connectionId == session.connection.connectionId) {
					return;
				}
				var div = document.createElement('div');	
				var divId = stream.streamId;	
				div.setAttribute('id', divId);	
				div.setAttribute('class', 'camera');
				document.getElementById('otherCamera').appendChild(div);
				var params = {width: '{$vidWidth}', height: '{$vidHeight}'};
				subscribers[stream.streamId] = session.subscribe(stream, divId, params);
			}
 
			function show(id) {
				document.getElementById(id).style.display = 'block';
			}
 
			function hide(id) {
				document.getElementById(id).style.display = 'none';
			}
			
			function inviteUser() {
				window.open ('invite.php?action=invite&roomid='+sessionId, 'inviteusers',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=400,height=200"); 
			}
 
		</script>
	</head>
	<body>
		<div id="loading"><img src="res/init.png"></div>
		<div id="endcall"><img src="res/ended.png"></div>
		<div id="canvas">
			<div id="myCamera" class="publisherContainer"></div>
			<div id="otherCamera"></div>
			<div style="clear:both"></div>
		</div>
		<div id="navigation">
			<div id="navigation_elements">
				<a href="#" onclick="javascript:disconnect();" id="disconnectLink"><img src="res/hangup.png"></a>
				<a href="#" onclick="javascript:inviteUser()" id="inviteLink"><img src="res/invite.png"></a>
				<a href="#" onclick="javascript:publish()" id="publishLink"><img src="res/turnonvideo.png"></a>
				<a href="#" onclick="javascript:unpublish()" id="unpublishLink"><img src="res/turnoffvideo.png"></a>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>
		</div>
	</body>
    <script>
		window.resizeTo(300,330);
		connect();
		window.onload = function() { resizeWindow(); }
		window.onresize = function() { resizeWindow(); }
	</script>
</html>
EOD;
	
}
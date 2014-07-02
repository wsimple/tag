<?php
session_start();
include ("../includes/config.php");
include ("../includes/functions.php");
include ("../class/wconecta.class.php");
include ("../includes/languages.config.php");

define ('DBPATH',HOST);
define ('DBUSER',USER);
define ('DBPASS',PASS);
define ('DBNAME',DATA);



global $dbh;
$dbh = mysql_connect(DBPATH,DBUSER,DBPASS);
mysql_selectdb(DBNAME,$dbh);

if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { sendChat(); } 
if ($_GET['action'] == "closechat") { closeChat();  } 
if ($_GET['action'] == "startchatsession") { startChatSession(); }
if ($_GET['action'] == "online") {  setUserChatStatus(); }
if ($_GET['action'] == "offline") {  setUserChatStatus(1);}
if ($_GET['action'] == "ty") {  typing();}
if ($_GET['action'] == "noty") {  typing(0);}


function typing($status=1){
	
	mysql_query("REPLACE into `chat_typing` ( `status`, `to`, `from`, `send`) 
									values ( '$status', '".$_POST[to]."', '".$_SESSION['ws-tags']['ws-user'][code]."', '1')")or die('asd');
	
}


 

if (!isset($_SESSION['ws-tags']['ws-user']['chatHistory'])) {
	$_SESSION['ws-tags']['ws-user']['chatHistory'] = array();	
}

if (!isset($_SESSION['ws-tags']['ws-user']['openChatBoxes'])) {
	$_SESSION['ws-tags']['ws-user']['openChatBoxes'] = array();	
}

function setUserChatStatus($status=''){
	
	$time=$status==''?date('Y-m-d G:i:s'):'2011-01-01';
	
	$_SESSION['ws-tags']['ws-user'][status_chat]=($status==''?1:0);
	
	mysql_query("UPDATE users SET chat_last_update = '".$time."', status_chat= '".($status==''?1:0)."'  WHERE id='".$_SESSION['ws-tags']['ws-user'][id]."'");
	
	mysql_query("update chat_typing set chat_typing.status='0',chat_typing.send = '1'  where chat_typing.from='".$_SESSION['ws-tags']['ws-user'][code]."' and chat_typing.status='1' ")or die(mysql_error().' 2');
	
	
}


function chatHeartbeat() {
	
	$sql = "select * from chat where (chat.to = '".$_SESSION['ws-tags']['ws-user'][code]."' AND chat.recd = 0) order by id ASC";
	$query = mysql_query($sql);
	$items = '';

	$chatBoxes = array();

	while ($chat = mysql_fetch_array($query)) {

		if (!isset($_SESSION['ws-tags']['ws-user']['openChatBoxes'][$chat['from']]) && isset($_SESSION['ws-tags']['ws-user']['chatHistory'][$chat['from']])) {
			$items = $_SESSION['ws-tags']['ws-user']['chatHistory'][$chat['from']];
		}

		$chat['message'] = sanitize($chat['message']);
		$u=htmlentities(campo("users", "md5(CONCAT(id, '_', email, '_', id))", $chat[from], "screen_name"));
		$f=$chat[from];
		$items .= <<<EOD
{"s": "0","f": "{$f}","m": "{$chat['message']}","u": "$u","fu":"$u"},
EOD;

	if (!isset($_SESSION['ws-tags']['ws-user']['chatHistory'][$chat['from']])) {
		$_SESSION['ws-tags']['ws-user']['chatHistory'][$chat['from']] = '';
	}
	
	$_SESSION['ws-tags']['ws-user']['chatHistory'][$chat['from']] .= <<<EOD
{"s": "0","f": "{$f}","m": "{$chat['message']}","u": "$u","fu":"$u"},
EOD;
		
		unset($_SESSION['ws-tags']['ws-user']['tsChatBoxes'][$chat['from']]);
		$_SESSION['ws-tags']['ws-user']['openChatBoxes'][$chat['from']] = $chat['sent'];
	}//while

	if (!empty($_SESSION['ws-tags']['ws-user']['openChatBoxes'])) {
	foreach ($_SESSION['ws-tags']['ws-user']['openChatBoxes'] as $chatbox => $time) {
		if (!isset($_SESSION['ws-tags']['ws-user']['tsChatBoxes'][$chatbox])) {
			$now = time()-strtotime($time);
			$time = date('g:iA M dS', strtotime($time));
			$u=htmlentities(campo("users", "md5(CONCAT(id, '_', email, '_', id))", $chatbox, "screen_name"));
			$message = "Sent at $time";
			
			if ($now > 180) {
				$items .= <<<EOD
{"s": "2","f": "$chatbox","m": "{$message}","u": "$u","fu": "$u"},
EOD;

	if (!isset($_SESSION['ws-tags']['ws-user']['chatHistory'][$chatbox])) {
		$_SESSION['ws-tags']['ws-user']['chatHistory'][$chatbox] = '';
	}
	$u=htmlentities(campo("users", "md5(CONCAT(id, '_', email, '_', id))", $chatbox, "screen_name"));
	$_SESSION['ws-tags']['ws-user']['chatHistory'][$chatbox] .= <<<EOD
{"s": "2","f": "$chatbox","m": "{$message}","u": "$u","fu": "$u"},
EOD;
			$_SESSION['ws-tags']['ws-user']['tsChatBoxes'][$chatbox] = 1;
		}
		}
	}
}

	$sql = "update chat set chat.recd = 1 where chat.to = '".$_SESSION['ws-tags']['ws-user'][code]."' and chat.recd = 0";
	$query = mysql_query($sql);

	if ($items != '') {
		$items = substr($items, 0, -1);
	}
///typing

$_typings=mysql_query("SELECT * FROM chat_typing WHERE chat_typing.to='".$_SESSION['ws-tags']['ws-user'][code]."' and chat_typing.send = '1' ")or die(mysql_error().' 1');

$typingSalida='';

while($_typing=mysql_fetch_assoc($_typings)){
	
	$typingSalida.='{"u":"'.$_typing[from].'","s":"'.$_typing[status].'"},';
	
}
$typingSalida= substr($typingSalida, 0, -1);

mysql_query("update chat_typing set chat_typing.send='0' where chat_typing.to='".$_SESSION['ws-tags']['ws-user'][code]."' and chat_typing.send = '1'")or die(mysql_error().' 2');

///	end typing
	

if(trim($items)!=''or $typingSalida!=''){
//header('Content-type: application/json');
?>
{"ty":[<?=$typingSalida?>],"items":[<?=$items;?>]}
<?php
}
			
			exit(0);
}

function chatBoxSession($chatbox) {
	
	$items = '';
	
	if (isset($_SESSION['ws-tags']['ws-user']['chatHistory'][$chatbox])) {
		$items = $_SESSION['ws-tags']['ws-user']['chatHistory'][$chatbox];
	}

	return $items;
}

function startChatSession() {
	$items = '';
	if (!empty($_SESSION['ws-tags']['ws-user']['openChatBoxes'])) {
		foreach ($_SESSION['ws-tags']['ws-user']['openChatBoxes'] as $chatbox => $void) {
			$items .= chatBoxSession($chatbox);
		}
	}


	if ($items != '') {
		$items = substr($items, 0, -1);
	}

header('Content-type: application/json');
?>
{"username": "<?=$_SESSION['ws-tags']['ws-user'][code]?>","userDisplay": "<?=htmlentities($_SESSION['ws-tags']['ws-user'][screen_name])?>","items": [<?php echo $items;?>]}
<?php

	setUserChatStatus();
	exit(0);
}

function sendChat() {
	$from = $_SESSION['ws-tags']['ws-user'][code];
	$to = $_POST['to'];
	$message = $_POST['message'];

	$_SESSION['ws-tags']['ws-user']['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
	
	$messagesan = sanitize($message);

	if (!isset($_SESSION['ws-tags']['ws-user']['chatHistory'][$_POST['to']])) {
		$_SESSION['ws-tags']['ws-user']['chatHistory'][$_POST['to']] = '';
	}
	$u=htmlentities(campo("users", "md5(CONCAT(id, '_', email, '_', id))", $from, "screen_name"));
	$fu=htmlentities(campo("users", "md5(CONCAT(id, '_', email, '_', id))", $to, "screen_name"));
	$f=$to;
	$_SESSION['ws-tags']['ws-user']['chatHistory'][$_POST['to']] .= <<<EOD
{"s": "1","f": "{$f}","m": "{$messagesan}","u": "$u","fu": "$fu"},
EOD;


	unset($_SESSION['ws-tags']['ws-user']['tsChatBoxes'][$_POST['to']]);

	$sql = "insert into chat (chat.from,chat.to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".$messagesan."',NOW())";
	
	if(isFriend(campo("users", "md5(CONCAT(id, '_', email, '_', id))", $to, "id"))){
		$query = mysql_query($sql);
	}
	echo "1";
	setUserChatStatus(); 
	exit(0);
}

function closeChat() {

	unset($_SESSION['ws-tags']['ws-user']['openChatBoxes'][$_POST['chatbox']]);
	
	echo "1";
	exit(0);
}

function sanitize($text) {
	$codigos= array('&Agrave;', '&agrave;', '&Aacute;', '&aacute;', '&Acirc;', '&acirc;', '&Atilde;',
		  '&atilde;', '&Auml;', '&auml;', '&Aring;', '&aring;', '&AElig;', '&aelig;', '&Ccedil;', 
		  '&ccedil;', '&ETH;', '&eth;', '&Egrave;', '&egrave;', '&Eacute;', '&eacute;', '&Ecirc;', 
		  '&ecirc;', '&Euml;', '&euml;', '&Igrave;', '&igrave;', '&Iacute;', '&iacute;', '&Icirc;', 
		  '&icirc;', '&Iuml;', '&iuml;', '&Ntilde;', '&ntilde;', '&Ograve;', '&ograve;', '&Oacute;', 
		  '&oacute;', '&Ocirc;', '&ocirc;', '&Otilde;', '&otilde;', '&Ouml;', '&ouml;', '&Oslash;', 
		  '&oslash;', '&OElig;', '&oelig;', '&szlig;', '&THORN;', '&thorn;', '&Ugrave;', '&ugrave;', 
		  '&Uacute;', '&uacute;', '&Ucirc;', '&ucirc;', '&Uuml;', '&uuml;', '&Yacute;', '&yacute;', 
		  '&Yuml;', '&yuml;');
		  
	$caracteres=array('À', 'à', 'Á', 'á', 'Â', 'â', 'Ã','ã', 'Ä', 'ä', 'Å', 'å', 'Æ', 'æ', 'Ç', 
		  'ç', 'Ð', 'ð', 'È', 'è', 'É', 'é', 'Ê', 'ê', 'Ë', 'ë', 'Ì', 'ì', 'Í', 'í', 'Î', 
		  'î', 'Ï', 'ï', 'Ñ', 'ñ', 'Ò', 'ò', 'Ó', 'ó', 'Ô', 'ô', 'Õ', 'õ', 'Ö', 'ö', 'Ø', 
		  'ø', 'Œ', 'œ', 'ß', 'Þ', 'þ', 'Ù', 'ù', 'Ú', 'ú', 'Û', 'û', 'Ü', 'ü', 'Ý', 'ý', 
		  'Ÿ', 'ÿ');	  
	
	$text = str_replace($caracteres,$codigos,$text);
	$text = str_replace("	","&nbsp;&nbsp;",$text);//tab
	$text = str_replace(chr(152),'',$text);//tilde de la ñ  ˜
	$text = str_replace('"',"\"",$text);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}
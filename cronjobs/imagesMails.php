<?php
set_time_limit(1000);
//include('../includes/config.php');
include('functions.php');
include('receivemail.class.php');
mysql_connect('10.4.23.12','db_seemytag_user','4kUHbM7KiadrHwOyUPiadr4kUH');
mysql_select_db('tagbum');
function microtime_float(){
	list($useg,$seg)=explode(' ',microtime());
	return ((float)$useg+(float)$seg);
}
$tiempo_inicio=microtime_float();
///////////
//defaul values
//receiveMail($username,$password,$EmailAddress,$mailserver='localhost',$servertype='pop',$port='110',$ssl=false)
$obj=new receiveMail('photos+seemytagdemo.com','2mDk1BJoSJNM','photos@seemytagdemo.com','hd-a125cl.privatedns.com','imap','143/notls',false);

//Connect to the Mail Box
$obj->connect();//If connection fails give error message and exit

//Get Total Number of Unread Email in mail box
$tot=$obj->getTotalMails();//Total Mails in Inbox Return integer value

for($i=$tot;$i>0;$i--){
	$head=$obj->getHeaders($i);//Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)
	$query=mysql_query('SELECT id FROM users WHERE email like "'.cls_string($head['from']).'"');
	if(mysql_num_rows($query)!=0){
		$array=mysql_fetch_assoc($query);
		$carpeta=md5($array['id'].'_'.$head['from'].'_'.$array['id']);
		$str=$obj->GetImgAttach($i,'../img/templates/'.$carpeta.'/');//Get attached images from Mail Return name of file in comma separated string args. (mailid, Path to store file)
	}
	$obj->deleteMails($i);//Delete Mail from Mail box
}
$obj->close_mailbox();//Close Mail Box

$tiempo_fin=microtime_float();
$tiempo=$tiempo_fin-$tiempo_inicio;
echo '<br/>Tiempo empleado: '.($tiempo_fin-$tiempo_inicio);
?>
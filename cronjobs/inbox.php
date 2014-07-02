<?php
include("../class/receivemail.class.php");
//defaul values
//receiveMail($username,$password,$EmailAddress,$mailserver='localhost',$servertype='pop',$port='110',$ssl=false)
$obj=new receiveMail('photos@seemytag.com','nepali13','photos@seemytag.com','mail.maoghost.com','imap','143',true);

//Connect to the Mail Box
$obj->connect();//If connection fails give error message and exit

//Get Total Number of Unread Email in mail box
$tot=$obj->getTotalMails(); //Total Mails in Inbox Return integer value

echo "Total Mails:: $tot<br>";

for($i=$tot;$i>0;$i--){
	$head=$obj->getHeaders($i);//Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)
	echo "<pre>";
	print_r($head);
	echo "</pre>";
	echo "---------------------------------------<br>";
	//$obj->deleteMails($i);//Delete Mail from Mail box
}
$obj->close_mailbox();//Close Mail Box
?>
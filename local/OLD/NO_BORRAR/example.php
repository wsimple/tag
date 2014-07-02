<?php
$mailserver="hd-a126cl.privatedns.com";
$port="143/notls";
$user="photos+seemytag.com";
$pass="2mDk1BJoSJNM";
 
if ($mbox=imap_open( "{" . $mailserver . ":" . $port . "}INBOX", $user, $pass ))
 {  echo "Connected\n";
        
    $check = imap_mailboxmsginfo($mbox);
         
    echo "Date: "     . $check->Date    . "<br />\n" ;
    echo "Driver: "   . $check->Driver  . "<br />\n" ;
    echo "Unread: "   . $check->Unread  . "<br />\n" ;
    echo "Size: "     . $check->Size    . "<br />\n" ;
        
    imap_close($mbox);
 } else { exit ("Can't connect: " . imap_last_error() ."\n");  echo "FAIL!\n";  };
?>

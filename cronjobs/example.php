<?php
//***********************************************************************************************************
//
// You can break out the variables for $mailserver, $port, $user and
// $pass without passing brackets into functions this way. Be sure to use
// the dots to append connection strings, ie "stuff". $variable ."STUFF"
// otherwise will go to imap_open with wrong variable type. :)
// 
// Puedes romper las variables para el servidor de correo, puerto, usuario y
// contrasena sin pasar corchetes en las funciones de esta manera. Asegúrese de utilizar
// Los puntos para anexar cadenas de conexión, es decir, "cosas". $variable. "COSAS"
// De lo contrario irán a imap_open con mal tipo variable.
//
//***********************************************************************************************************

$mailserver="hd-a125cl.privatedns.com";
$port="143/notls";
$user="photos+oftag.com";
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

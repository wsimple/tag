<?php
  // ini_set('display_errors', 'On');
  // ini_set('display_errors', 1);
  //netbeans testing
  //second push
  //hmiharbi activando la jugada
  //jrivas activando el pusheooooo

  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
  error_reporting(E_ALL);
  error_reporting(-1);

  $hostname = "68.109.244.202";                  
  $username = "uservzla";                     
  $password = "*WzlaW3b*";                    
  $database = "tagbum";                       
  
  $hostname = "1111111111";                  
  $username = "uservzlaadrian";
  
  $link = new  mysqli($hostname, $username, $password, $database); 

  if ($link->connect_errno) {
  	echo "Fallo al contenctar a MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
  }else{
  	echo "fino";
    $query =  mysqli_query($link,"SELECT * FROM type_publicity");
    while ($fila = mysqli_fetch_assoc($query)) {
        echo " id = " . $fila['id']."&nbsp;".$fila['name']."</br>";
    }
  }

echo phpinfo();
?>
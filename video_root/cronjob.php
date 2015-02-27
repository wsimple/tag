<?php
$event='VIDEO SERVER CRONJOB. uri: '.$_SERVER['REQUEST_URI']
	.', remote server: '.$_SERVER['REMOTE_ADDR']
	.', full url: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
if(!isset($_GET['clean'])){
?>
Para ejecutar el cronjob sin guardar el resultado:<br>
wget http://localhost/cronjob.php?GET -O /dev/null
<?php
echo '<br><br>Evento:<br>'.$event;
}
#cortamos el proceso si es llamado de una url externa
if(preg_match('^(::1|localhost|192\.168\.\|(.+\.)?tagbum\.com)',$_SERVER['REMOTE_ADDR'])) die('Wrong use.');

require_once('includes/client.php');
$client=new Client();

#save event for test
// $client->db->insert('test_events','event=?',array($event));

$option=isset($_GET['opc'])&&$_GET['opc']!='':$_GET['opc']:'';

switch($option){
	case 1:#paso 1: revisar que archivos no estan en la lista y agregarlos
	#si se indica una ruta, se agrega un archivo especifico
	// $_GET['file']
	break;
	case 2:#paso 2: se revisa la lista de archivos pentientes y si hay alguno pendiente, se inicia uno
	break;
	case 3:#paso 3: si el proceso fue exitoso, se elimina el archivo original
	break;
	default:
}

<?php
require('../../includes/functions.php');
echo urldecode($_GET['msg']);
if(isset($_GET['msg'])){
	echo $mensaje=$_GET['msg'];
	//$bit=DOMINIO.'#view_?tag='.substr(md5($_GET['tag']),-15);
	require('../../widgets/twitteroauth/OAuth.php');
	require('../../widgets/twitteroauth/twitteroauth.php');
	define('_CONSUMER_KEY','BTEwe6Y9cZ2kDd9VO6w3A'); //Consumer Key
	define('_CONSUMER_SECRET','NL9JnXYVerjEAGOOr5kr7MwglFGseD9jM9Eu3RQAdQ'); //Consumer Secret
	define('_OAUTH_TOKEN','349185270-Qzss54EOBKn4jjBLGBdjWzZRz1ULhgTlPSNj26t7'); //Access token
	define('_OAUTH_TOKEN_SECRET','YIE2sYuCaUAyn8YITf4YjO6vzo6wfVDfHGqiDe7oWM'); //Access Token Secret

	//Función para acortar URL con bit.ly . Primero debemos registrarnos en http://bit.ly para obtener clave api y usuario
/*	function tinyurl($url_larga){
		$tiny = "http://api.bit.ly/v3/shorten?login=TuUsuario&apiKey=tuClaveApi&format=txt&longUrl=".$url_larga;
		$sesion = curl_init();
		curl_setopt ( $sesion, CURLOPT_URL, $tiny );
		curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
		$url_tiny = curl_exec ( $sesion );
		curl_close( $sesion );
		return($url_tiny);
	}
	$bit=tinyurl($link); //reducimos el link con la api de bit.ly
*/	//$quedan=(140-strlen($bit))-1; // calculo los caracteres restantes que me quedan para publicar restando los puntos suspensivo
	//if(strlen($mensaje)>$quedan) $mensaje=substr($mensaje,0,$quedan-3).'...';// corto el mensaje en caso de que sea muy largo
	//$mensaje.=' '.$bit;

	//declaramos la función que realiza la conexión a tu aplicación de twitter
	function getConnectionWithAccessToken() {
		$connection = new TwitterOAuth(_CONSUMER_KEY, _CONSUMER_SECRET,_OAUTH_TOKEN, _OAUTH_TOKEN_SECRET);
		return $connection;
	}
	//Realizamos la conexión
	$connection = getConnectionWithAccessToken();

	//Publicamos el mensaje en twitter
	$twitter=$connection->post('statuses/update', array('status' =>utf8_encode($mensaje)));
	_imprimir($twitter);
}
?>
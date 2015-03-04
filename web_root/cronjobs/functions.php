<?php
/*
<!--
    + ------------------------------------------------ +
    |                                                  |
    | 	Developed By: Websarrollo.com & Maoghost.com   |
    |   Copy Rights : Tagamation, LLc                  |
    |   Date        : 02/22/2011                       |
    |                                                  |
    + ------------------------------------------------ +
-->
*/

function is_debug($name=''){
	if($name=='') return isset($_COOKIE['_DEBUG_']);
	foreach(split(',',$name) as $value)
		if(in_array($value,split(',',$_COOKIE['_DEBUG_'])))
			return true;
	return false;
}

#Limpiar caracteres incompatibles con mysql
function cls_string($mensaje) {
	/*$mensaje = str_replace(array("'","\\","\"","'", "�", "�", "\'"),"",$mensaje);
	$mensaje = $mensaje; */
	return $mensaje;
}

#Evitar Inyecciones SQL
function quitar_inyect(){
	$filtro = array( "Content-Type:",
					"MIME-Version:", //evita email injection
					"Content-Transfer-Encoding:",
					"Return-path:",
					"Subject:",
					"From:",
					"Envelope-to:",
					"To:",
					"bcc:",
					"cc:",
					"UNION", // evita sql injection
					"DELETE",
					"DROP",
					"SELECT",
					"INSERT",
					"UPDATE",
					"CRERATE",
					"TRUNCATE",
					"ALTER",
					"INTO",
					"DISTINCT",
					"GROUP BY",
					"WHERE",
					"RENAME",
					"DEFINE",
					"UNDEFINE",
					"PROMPT",
					"ACCEPT",
					"VIEW",
					"COUNT",
					"HAVING",
					//"'",
					//'"',
					//"{",
					//"}",
					//"[",
					//"]",
					//"HOTMAIL", // evita introducir direcciones web
					//"WWW",
					//".COM",
					"W W W",
					". c o m",
					//"http://",
					//"$", //variables y comodines
					//"&",
					//"*",
					//"insert",
					//"update",
					//"delete",
					" x00 ",
					"\\",
					"\\\\",
					" x1a "
			   );

	foreach($_POST as $k=>$v){
		if (!is_array($v)){
			foreach ($filtro as $index){
				$v=str_replace(trim($index), '',$v);
			}
			$_POST[$k]=addslashes(htmlspecialchars($v,ENT_NOQUOTES));
		}
	}
	foreach($_GET as $k=>$v){
	    if (!is_array($v)){
			foreach ($filtro as $index){
				$v=str_replace(trim($index), '',$v);
			}
			$_GET[$k]=addslashes(htmlspecialchars($v,ENT_NOQUOTES));
		}
	}
	return true;
}

#Formatear las fechas, de mysql a html - de html a mysql
function formatoFecha($fecha){
	if(strpos($fecha,'-')){
		$fecha=split('[-]',$fecha);
		$fecha[2]=split('[ ]',$fecha[2]);
	    $fecha[2]=$fecha[2][0];
		return $fecha[2].'/'.$fecha[1].'/'.$fecha[0];
	}elseif(strpos($fecha,'/')){
		$fecha=split('[/]',$fecha);
		return $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	}
	return false;
}

#Imprimir vectores
function _imprimir($array=''){
		  if($array=='')$array=$_REQUEST;
          echo '<div data-role="page" style="background:#fff;"><pre>'; print_r($array); echo '</pre></div>';
		//  die();
}

#Formato Numerico
function formato($numero){
		return number_format($numero,2,',','.');
}

#Quita formato numerico
function sinFormato($number){
	return str_replace(',','.',str_replace('.','',$number));
}

#devuelve un campo de la bd
function campo($tabla, $campo, $criterio, $pos){
	$query = $GLOBALS['cn']->query("SELECT $pos FROM $tabla WHERE $campo = '$criterio'");
	$array = mysql_fetch_array($query);
	return $array[$pos];
}

#verifica existencia de un registro en la bd
function existe($tabla, $campo, $where) {
	$query = $GLOBALS['cn']->query("SELECT $campo FROM $tabla $where");
	return (mysql_num_rows($query) > 0);
}

#borrar de la bd
function delete($tabla, $campo, $criterio) {
	$query = $GLOBALS['cn']->query("DELETE FROM $tabla WHERE $campo = '$criterio'");
}

#formatear cadenas
function formatoCadena($cadena, $op=1){
	switch($op){
		case 1: return ucwords($cadena);	break;	#Pone en mayusculas el primer caracter de cada palabra de una cadena
		case 2: return ucfirst($cadena);	break;	#Pasar a mayusculas el primer caracter de una cadena
		case 3: return strtolower($cadena);	break;	#Pasa a minusculas una cadena
		case 4: return strtoupper($cadena);	break;	#Pasa a mayusculas una cadena
		case 5: return str_replace(' ', '', strtolower($cadena)); break; #Pasa a mayusculas una cadena
	}
}

#devueleve el numero de registros de una consulta sql
function numRecord($tabla, $where){
	$query = $GLOBALS['cn']->query("SELECT * FROM $tabla $where");
	return mysql_num_rows($query);
}

#suma registros en sql
function sumRecord($campo, $tabla, $where){
	$query = $GLOBALS['cn']->query("SELECT SUM($campo) AS suma FROM $tabla $where");
	$array = mysql_fetch_assoc($query);
	return $array['suma'];
}

#semilla
function make_seed(){
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}

#numero referencia
function refereeNumber($cad){
	$numero = substr(md5($cad), 0, 9);
	if (existe('users', 'referee_number', ' WHERE referee_number LIKE "'.$numero.'"')){
		refereeNumber($cad.srand(make_seed()));
	}else{
		return $numero;
	}
}

#calculo de la edad
function edad($fecha, $char){
	list($mes, $dia, $ano) = split("[$char]", $fecha);
	$diaAct = date('d'); $mesAct = date('m'); $anoAct = date('Y');
	//si el mes es el mismo pero el d�a inferior aun no ha cumplido a�os, le quitaremos un a�o al actual
	if ($mes == $mesAct && $dia > $diaAct)
		$anoAct=($anoAct-1);
	//meses
	if ($mes > $mesAct)
		$anoAct=($anoAct-1);
	return ($anoAct-$ano);
}

function redirect($url, $html=false){
	if ($html)
		echo '<meta HTTP-EQUIV="REFRESH" content="0; url='.$url.'">';
	else
		echo '<div data-role="page" ><script type="text/javascript">location="'.$url.'";</script></div>';
}

function mensajes($content, $titulo, $url='',  $actions='' ,$mobile='', $id='#messages',$ancho=300, $largo=200){
	if($mobile!=1){
		$action = "
			<script type='text/javascript'>
				$(document).ready(function(){
				$('$id').dialog({
					title: '$titulo',
					resizable: false,
					width: $ancho,
					height: $largo,
					modal: true,
					show: 'fade',
					hide: 'fade',
					buttons: {
						Ok: function() {
							$( this ).dialog( 'close' );
						}
					},
					close: function() {
						";
						if ($actions!=""){
							$action .= $actions;
						}else{
							$action .= ($url!=''?'':'//')."redirect('$url');";
						}
						$action .= "
					},
					open: function() {
						$('$id').html('$content');
					} //insert html
				});
			});
		</script>";
		echo $action;
	}else{
		$action = "
			<div data-role='page'>
				<div data-role='header' data-nobackbtn='true' data-theme='d' >
					<a data-theme='d' href='#' data-rel='back' style='display:none'></a>
					<h1>$titulo</h1>
				</div><!-- /header -->
				<div data-role='content'>
					$content
					<a href='#' data-role='button'  onclick='".($action!=''?$action:($url!=''?'location="'.$url.'";':""))."'  >Ok</a>
				</div><!-- /content -->
				<div data-role='footer' data-theme='d' data-position='fixed'>
					<h4>Tagbum &copy;</h4>
				</div>
			</div>";
		echo $action;
		//die();
	}
}

function isFriend($id_friend, $id_user=''){
	$id_user = ($id_user!='') ? md5($id_user) : md5($_SESSION['ws-tags']['ws-user']['id']);
	$id_friend = md5($id_friend);
	$query = $GLOBALS['cn']->query('
		SELECT id_friend
		FROM users_links
		WHERE md5(id_user) = "'.$id_friend.'" AND
			md5(id_friend) = "'.$id_user.'" AND
			"'.$id_friend.'" IN (SELECT md5(id_friend) AS id_friend FROM users_links WHERE md5(id_user) = "'.$id_user.'" AND md5(id_friend) = "'.$id_friend.'")
	');
	return (mysql_num_rows($query)!=0);
}

function isFallowing($id_user, $id_friend){
	$id_user   = md5($id_user);
	$id_friend = md5($id_friend);
	$query = $GLOBALS['cn']->query('
		SELECT id_friend
		FROM users_links
		WHERE md5(id_user) = "'.$id_user.'" AND md5(id_friend) = "'.$id_friend.'"
	');
	return (mysql_num_rows($query)!=0);
}

function dropViews($views){
	foreach ($views as $view) $drops = $GLOBALS['cn']->query('DROP VIEW IF EXISTS '.$view);
}

function view_friends($id=''){
	$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
	dropViews(array('view_friends'));
	//los que el usuario sigue
	$friends = $GLOBALS['cn']->query('
		CREATE VIEW view_friends AS
		SELECT DISTINCT
			l.id_user AS id_user,
			l.id_friend as id_friend,
			u.screen_name,
			CONCAT(u.name, " ", u.last_name) AS name_user,
			u.profile_image_url  AS photo_friend,
			u.email as email,
			u.home_phone,
			u.mobile_phone,
			u.work_phone,
			md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend
		FROM users u INNER JOIN users_links l ON u.id=l.id_friend
		WHERE md5(l.id_user)="'.$user.'";
	');
	//amigos
	$friends = $GLOBALS['cn']->query('
		SELECT
			f.id_friend AS id_friend,
			f.name_user AS name_user,
			f.photo_friend AS photo_friend,
			f.code_friend AS code_friend,
			f.email as email,
			f.home_phone,
			f.screen_name,
			f.mobile_phone,
			f.work_phone
		FROM view_friends f INNER JOIN users_links u ON f.id_friend=u.id_user
		WHERE md5(u.id_friend) = "'.$user.'"
		LIMIT 0, 50;
	');
	return $friends;
}

function friendsHelp($value='u.email'){
	$user = md5($_SESSION['ws-tags']['ws-user']['id']);
	dropViews(array('view_friends'));
	//los que el usuario sigue detail as 'key', id as 'value'
	$friends = $GLOBALS['cn']->query('
		CREATE VIEW view_friends AS
		SELECT DISTINCT
			CONCAT(u.name, " ", u.last_name) AS "key",
			'.$value.' AS "value",
			l.id_friend as id_friend
		FROM users u INNER JOIN users_links l ON u.id=l.id_friend
		WHERE md5(l.id_user)="'.$user.'";
	');
	//amigos
	$friends = $GLOBALS['cn']->query('
		SELECT  f.key, f.value
		FROM view_friends f JOIN users_links u ON f.id_friend=u.id_user
		WHERE md5(u.id_friend) = "'.$user.'"
		LIMIT 0, 50;
	');
	return $friends;
}

function view_friendsOfFriends($id=''){
	if ($_SESSION['ws-tags']['ws-user']['id']!='' || $id!=''){
		$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
		//los que yo sigo - Nivel 1
		dropViews(array('view_friends_level01'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level01 AS
			SELECT DISTINCT id_user AS id_user, id_friend as id_friend
			FROM users_links
			WHERE md5(id_user) = "'.$user.'"
		');
		//los que siguen :: Nivel 1
		dropViews(array('view_friends_level02'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level02 AS
			SELECT u.id_user AS id_user, u.id_friend AS id_friend
			FROM view_friends_level01 f JOIN users_links u ON f.id_friend = u.id_user
			WHERE
				md5(u.id_friend) != "'.$user.'" AND
				u.id_friend NOT IN ( select z.id_friend from view_friends_level01 z )
			GROUP BY u.id_friend
		');
		//los que siguen :: Nivel 2
		dropViews(array('view_friends_level03'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level03 AS
			SELECT u.id_user AS id_user, u.id_friend AS id_friend
			FROM view_friends_level02 f JOIN users_links u ON f.id_friend = u.id_user
			WHERE
				md5(u.id_friend) != "'.$user.'" AND
				u.id_friend NOT IN (select y.id_friend from view_friends_level01 y) AND
				u.id_friend NOT IN (select z.id_friend from view_friends_level02 z)
			GROUP BY u.id_friend
		');
		//los que siguen :: Nivel 3
		dropViews(array('view_friends_level04'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level04 AS
			SELECT u.id_user AS id_user, u.id_friend AS id_friend
			FROM view_friends_level03 f INNER JOIN users_links u ON f.id_friend = u.id_user
			WHERE
				md5(u.id_friend) != "'.$user.'" AND
				u.id_friend NOT IN (select x.id_friend from view_friends_level01 x) AND
				u.id_friend NOT IN (select y.id_friend from view_friends_level02 y) AND
				u.id_friend NOT IN (select z.id_friend from view_friends_level03 z)
			GROUP BY u.id_friend
		');
		//los que siguen :: Nivel 4
		dropViews(array('view_friends_level05'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level05 AS
			SELECT u.id_user AS id_user, u.id_friend AS id_friend
			FROM view_friends_level04 f JOIN users_links u ON f.id_friend = u.id_user
			WHERE
				md5(u.id_friend) != "'.$user.'" AND
				u.id_friend NOT IN (select w.id_friend from view_friends_level01 w) AND
				u.id_friend NOT IN (select x.id_friend from view_friends_level02 x) AND
				u.id_friend NOT IN (select y.id_friend from view_friends_level03 y) AND
				u.id_friend NOT IN (select z.id_friend from view_friends_level04 z)
			GROUP BY u.id_friend
		');
		//los que siguen :: Nivel 5
		dropViews(array('view_friends_level06'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level06 AS
			SELECT u.id_user AS id_user, u.id_friend AS id_friend
			FROM view_friends_level05 f INNER JOIN users_links u ON f.id_friend = u.id_user
			WHERE
				md5(u.id_friend) != "'.$user.'" AND
				u.id_friend NOT IN (select v.id_friend from view_friends_level01 v) AND
				u.id_friend NOT IN (select w.id_friend from view_friends_level02 w) AND
				u.id_friend NOT IN (select x.id_friend from view_friends_level03 x) AND
				u.id_friend NOT IN (select y.id_friend from view_friends_level04 y) AND
				u.id_friend NOT IN (select z.id_friend from view_friends_level05 z)
			GROUP BY u.id_friend}
		');
		//unificaci�n de las vistas
		dropViews(array('view_friends_level07'));
		$friends = $GLOBALS['cn']->query('
			CREATE VIEW view_friends_level07 AS
			(SELECT a.id_user AS id_user, a.id_friend AS id_friend FROM view_friends_level02 a)
			UNION
			(SELECT b.id_user AS id_user, b.id_friend AS id_friend FROM view_friends_level03 b)
			UNION
			(SELECT c.id_user AS id_user, c.id_friend AS id_friend FROM view_friends_level04 c)
			UNION
			(SELECT d.id_user AS id_user, d.id_friend AS id_friend FROM view_friends_level05 d)
			UNION
			(SELECT e.id_user AS id_user, e.id_friend AS id_friend FROM view_friends_level06 e)
		');
		//query
		$friends = $GLOBALS['cn']->query('
			SELECT
				f.id_user AS id_user,
				f.id_friend as id_friend,
				CONCAT(u.`name`, " ", u.last_name) AS name_user,
				u.description AS description,
				u.profile_image_url AS photo_friend,
				md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend
			FROM users u JOIN view_friends_level07 f ON u.id=f.id_friend
			WHERE u.status = "1"
			LIMIT 0, 50
		');
		return $friends;
	}else{
		$friends = $GLOBALS['cn']->query('
			SELECT
				CONCAT(u.`name`, " ", u.last_name) AS name_user,
				u.description AS description,
				u.profile_image_url AS photo_friend,
				md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend,
				u.id as id_friend
			FROM users u
			WHERE u.status = "1"
			ORDER BY RAND()
			LIMIT 0, 50
		');
		return $friends;
	}//else
}

function users($where=''){
	$users = $GLOBALS['cn']->query('
		SELECT
			u.id AS id_friend,
			CONCAT(u.`name`, " ", u.last_name) AS name_user,
			u.description AS description,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id, "_", u.email, "_", u.id)) AS code_friend
		FROM users u
		'.$where.'
		ORDER BY u.name
		LIMIT 0, 50
	');
	return $users;
}

function followers($id=''){
	$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
	$followers = $GLOBALS['cn']->query("
		SELECT
			l.id_user AS id_user,
			l.id_friend as id_friend,
			CONCAT(u.`name`, ' ', u.last_name)  AS name_user,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend
		FROM users u JOIN users_links l ON u.id=l.id_user
		WHERE md5(l.id_friend)='".$user."'
		LIMIT 0, 50;
	");
	return $followers;
}


function following($id=''){
	$user = ($id=='') ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
	$following = $GLOBALS['cn']->query("
		SELECT
			l.id_user AS id_user,
			l.id_friend as id_friend,
			CONCAT(u.`name`, ' ', u.last_name) AS name_user,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend
		FROM users u JOIN users_links l ON u.id=l.id_friend
		WHERE md5(l.id_user) = '".$user."'
		ORDER BY RAND()
		LIMIT 0, 50;
	");
	return $following;
}

function factorPublicity($type, $monto){
	$costos = $GLOBALS['cn']->query("SELECT MAX(cost) AS cost FROM cost_publicity WHERE id_typepublicity = '$type'");
	$costo  = mysql_fetch_assoc($costos);
	return intval(($costo[cost]!="") ? ($monto/$costo[cost]) : 0);
}

function redimensionar($original,$img_nueva,$width,$height=''){
	$type=Array(1=>'gif',2=>'jpg',3=>'png');
	//_imprimir(getimagesize($original));
	list($_width,$_height,$tipo,$imgAttr)=getimagesize($original);
	$type=$type[$tipo];
	switch($type){
		case 'jpeg':
		case 'jpg':$img=imagecreatefromjpeg($original);break;
		case 'gif':$img=imagecreatefromgif($original);break;
		case 'png':$img=imagecreatefrompng($original);break;
	}
	//Obtengo la relacion de escala
	if($_width>$width&&$width>0)
		$percent=(double)(($width*100)/$_width);
	if($_width<=$width)
		$percent=100;
	if(floor(($_height*$percent)/100)>$height&&$height>0)
		$percent=(double)(($height*100)/$_height);
	$width=($_width*$percent)/100;
	$height=($_height*$percent)/100;
	//crea imagen nueva redimencionada
	$thumb=imagecreatetruecolor($width,$height);
	if($type=='gif'||$type=='png'){
		#se mantiene la transparencia de la imagen
		$colorTransparancia=imagecolortransparent($img);#devuelve el color usado como transparencia o -1 si no tiene transparencias
		if($colorTransparancia>-1)
			$colorTransparente=imagecolorsforindex($img,$colorTransparancia);//devuelve colores RGB + alpha
		else
			$colorTransparente=array('red'=>0,'green'=>0,'blue'=>0,'alpha'=>0);
		$idColorTransparente=imagecolorallocatealpha($thumb,$colorTransparente['red'],$colorTransparente['green'],$colorTransparente['blue'],$colorTransparente['alpha']);//Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3
		imagefill($thumb,0,0,$idColorTransparente);//rellena de color desde una cordenada,en este caso todo rellenado del color que se definira como transparente
		imagecolortransparent($thumb,$idColorTransparente);//Ahora definimos que en la nueva imagen el color transparente sera el que hemos pintado el fondo.
	}
	#redimensionar imagen original copiandola en la imagen nueva
	imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,$_width,$_height);
	#guardar la imagen redimensionada donde indica $img_nueva
	switch($type){
		case 'jpeg':
		case 'jpg':
		case 'gif'://imagegif($thumb,$img_nueva);break;
		case 'png'://imagepng($thumb,$img_nueva);break;
			imagejpeg($thumb,$img_nueva,90);
	}
	imagedestroy($img);
	imagedestroy($thumb);
	return true;
}
function CreateThumb($img_original, $img_nueva, $tamanio,$x,$y, $ancho, $alto){

	$type=Array(1 => 'gif', 2 => 'jpg', 3 => 'png');

	list($imgWidth,$imgHeight,$tipo,$imgAttr)=getimagesize($img_original);
	$type=$type[$tipo];

	switch($type){
		case "jpg" :
		case "jpeg":  $img = imagecreatefromjpeg($img_original); break;
		case "gif" :  $img = imagecreatefromgif($img_original); break;
		case "png" :  $img = imagecreatefrompng($img_original); break;
	}


	// crea imagen nueva redimencionada

	$thumb = imagecreatetruecolor ($tamanio,$tamanio);

	if($type=='gif' || $type=='png')
	{

				imagepalettecopy($thumb,$img);
				$transparentcolor = imagecolortransparent($img);

				if($transparentcolor!=-1)$transparentcolor = imagecolorsforindex($img, $transparentcolor); //devuelve un array con las componentes de lso colores RGB + alpha

				$idColorTransparente = imagecolorallocatealpha($thumb, $transparentcolor['red'], $transparentcolor['green'], $transparentcolor['blue'], $transparentcolor['alpha']); // Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3

				imagefill($thumb, 0, 0, $idColorTransparente);// rellena de color desde una cordenada, en este caso todo rellenado del color que se definira como transparente


				imagecolortransparent($thumb,$idColorTransparente);

	}

	// redimensionar imagen original copiandola en la imagen nueva
	imagecopyresampled ($thumb,$img,0,0,$x,$y,$tamanio,$tamanio, $ancho,$alto);
	// guardar la imagen redimensionada donde indica $img_nueva
	switch($type){
		case "jpg":
		case "jpeg": imagejpeg($thumb,$img_nueva); break;
		case "gif":  imagegif($thumb,$img_nueva); break;
		case "png":  imagepng($thumb,$img_nueva); break;
	}

	imagedestroy($img);
	imagedestroy($thumb);


}

function sendMail($body, $from, $fromName, $subject, $address, $path=''){
	$mail = new phpmailer();
	$mail->PluginDir = $path.'class/';
	$mail->Mailer    = 'smtp';
	$mail->Host      = 'localhost';
	$mail->SMTPAuth  = false;
	$mail->Timeout   = 1;
	$mail->IsHTML(true);
	$mail->AddAddress($address);
	$mail->From      = $from;
	$mail->FromName  = $fromName;
	$mail->Subject   = $subject;
	$mail->Body      = $body;
	return $mail->Send();
}

function codeTag($code){
	return substr ('000000000'.str_replace(' ','',$code), -9);
}

/* Cantidad de seguidores de un usuario.  Si el usuario tiene
   mas de 10^6 de seguidores se toma como error y la funcion
   retorna cero */
function mskPoints( $points ){
	if( $points<20000000 ){
		$len = strlen($points);
		if ($points>=99999 && $len<7)
			return round(($points/1000),2)." ".CONST_UNITMIL;
		if ($len >= 7)
			return round(($points/1000000),2)." ".CONST_UNITMILLON;
		return $points;
	}
	return 0;
}

function generaGet(){
	reset($_REQUEST);
	$REQUEST=$_REQUEST;
	$get= '?';
	for($i=0;$i<count($REQUEST);$i++){
		$value = current($REQUEST);
		$nombre=key($REQUEST);
		$get.=$nombre.'='.$value.'&';
		next($REQUEST);
	}
	reset($_REQUEST);
	return substr($get,0,-1);
}

function priceList($type_publicity='4', $status='1'){
	return $GLOBALS['cn']->query("
		SELECT
			(select b.name from currency b where b.id=a.id_typecurrency) AS moneda,
			(select c.name from type_publicity c where c.id=a.id_typepublicity) AS tipo_publi,
			CONCAT(a.click_from, ' - ',a.click_to) AS rango,
			a.cost AS costo
		FROM cost_publicity a
		WHERE status = '".$status."' AND a.id_typepublicity = '".$type_publicity."'
		ORDER BY a.click_from ASC
	");
}
function maskBirthday($birthday, $type=1, $format=1){

		 $date = explode('-', $birthday);

         switch ($type){
		         case 1: echo (($format==1) ? $birthday : formatoFecha($birthday)); break; //full

				 case 2: echo (($format==1) ? $date[1].'-'.$date[2] : $date[2].'/'.$date[1]); break; //day-month

				 case 3: echo INDEX_LBL_PRIVATE; break; //nothing
		 }
}

function isProductTag($idTag){

	$idProduct= $GLOBALS['cn']->query("SELECT id_product
										FROM `tags`
										WHERE `id_product` !='0' AND id = '$idTag' ");

	if(mysql_num_rows($idProduct)==0) return false;

	$idProduct=mysql_fetch_assoc($idProduct);
	$idProduct=$idProduct[id_product];

	$product=$GLOBALS['cn']->query("SELECT id, name, picture, url
										FROM `products_user`
										WHERE `id` ='$idProduct'");

	return mysql_fetch_assoc($product);

}
function isYoutubeVideo($value) {
	$isValid = false;
        //validate the url, see: http://snipplr.com/view/50618/
	if (isValidURL($value)) {
                //code adapted from Moridin: http://snipplr.com/view/19232/
		$idLength = 11;
		$idOffset = 3;
		$idStarts = strpos($value, "?v=");
		if ($idStarts === FALSE) {
			$idStarts = strpos($value, "&v=");
		}
		if ($idStarts === FALSE) {
			$idStarts = strpos($value, "/v/");
		}
		if ($idStarts === FALSE) {
			$idStarts = strpos($value, "#!v=");
			$idOffset = 4;
		}
		if ($idStarts === FALSE) {
			$idStarts = strpos($value, 'youtu.be/');
			$idOffset = 9;
		}
		if ($idStarts !== FALSE) {
                        //there is a videoID present, now validate it
			//echo $idStarts + $idOffset;
			$isValid = substr($value, $idStarts + $idOffset, $idLength);


			/*$videoID = substr($value, $idStarts + $idOffset, $idLength);
			$http = new HTTP("http://gdata.youtube.com");
			$result = $http->doRequest("/feeds/api/videos/".$videoID, "GET");
                        //returns Array('headers' => Array(), 'body' => String);
			$code = $result['headers']['http_code'];
                        //did the request return a http code of 2xx?
			if (substr($code, 0, 1) == 2) {
				$isValid = $videoID;
			}*/
		}
	}
	return $isValid;
}

function isValidURL($value){
	if (preg_match("/((\s+(http[s]?:\/\/)|(www\.))?(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.(([a-zA-Z]{2}|aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel)(\.[a-z]{2,2})?))\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is", $value)){
		return true;
	} else {
		return false;
	}
}
function incHitsTag($tag, $resta=false) {

		 $hits = ($resta==false) ? "hits = hits + 1" : "hits = hits - 1";

		 $query = $GLOBALS['cn']->query("UPDATE tags SET $hits WHERE id = '".$tag."' OR md5(id) = '".$tag."';");
}

function restaFechaUsers($dFecIni, $dFecFin, $usr='') {
	$usr = ($usr!="") ? $urs : $_SESSION['ws-tags']['ws-user']['id'];
	$query = $GLOBALS['cn']->query("SELECT DATEDIFF(NOW(), u.created_at) AS num FROM users u WHERE u.id = '$usr'");
	$array = mysql_fetch_assoc($query);
	return $array[num];
}

function blockUser($created_at){
	list($anio,$mes,$dia) = explode('-', $created_at);
	if (restaFechaUsers($anio.'-'.$mes.'-'.$dia, date('Y-m-d')) >= getNumDaysDemo() && $_SESSION['ws-tags']['ws-user']['status'] == '3'){
		return true;
	}
	return false;
}

function fieldsLogin(){ //campos que se listaran al momento de hacer login en el sistema
	return ' *, DATE(created_at) AS created_at ';
}

function createSession($array){ //creacion de las variables de session del sistema
	$fullVersion = $_SESSION['ws-tags']['ws-user']['fullversion'];
	$_SESSION['ws-tags']['ws-user'] = $array;//aqui se construye el vector del usuario
	$_SESSION['ws-tags']['ws-user']['fullversion'] = $fullVersion;
	$time=time();
	$_SESSION['ws-tags']['ws-user']['smt'] = $time.','.md5($array['id'].md5($time));
	$_SESSION['ws-tags']['ws-user']['full_name'] = $array['name'].' '.$array['last_name'];
	$_SESSION['ws-tags']['ws-user']['code'] = md5($array['id'].'_'.$array['email'].'_'.$array['id']);
	$_SESSION['ws-tags']['ws-user']['photo'] = $array['profile_image_url'];
	// after the user deletes an image, the page refreshes
	// this variable indicates that photo gallery must be shown on page load
	$_SESSION['ws-tags']['ws-user']['showPhotoGallery'] = false;
}

function userExternalReference($keyusr){ //confirmar suscripcion :: login
         $query = $GLOBALS['cn']->query("SELECT ".fieldsLogin()."

		                                 FROM users

										 WHERE md5(md5(concat(id,'_',email,'_',id))) = '".$keyusr."'

										");

		$array = mysql_fetch_assoc($query);

		if (mysql_num_rows($query)>0){

            createSession($array);

			//update - colocamos el status del usuario en 3 con la finalidad de cobrar a los 14 dias su suscripcion al sistema

			$status = (($array[type]=='1') ? 3 : 1);

			$update = $GLOBALS['cn']->query("UPDATE users SET status = '".$status."' WHERE id = '".$array[id]."'");

			$_SESSION['ws-tags']['ws-user'][status] = $status;

			return true;

		 }elseif (mysql_num_rows($query)==0){ //validaci�n de login
		    return false;
		 }
}

//funciones para obtener datos en especifico

function getNumDaysDemo(){ //numero de dias para la prueba del sistema

		 return campo("config_system", "id", '1', "days_block");

}

function getCostAccountIndividual(){ //Costo de suscripci�n por personas

		 return campo("config_system", "id", '1', "cost_account_individual");

}

function getCostAccountCompany(){ //Costo de suscripci�n por empresas

		 return campo("config_system", "id", '1', "cost_account_company");

}

function getCostPersonalTagIndividual(){ //Costo para obtener mas personals tags por personas

		 return campo("config_system", "id", '1', "cost_individual_personal_tag");

}

function getCostPersonalTagCompany(){ /*Costo para obtener mas personals tags por empresas*/

		 return campo("config_system", "id", '1', "cost_company_personal_tag");

}

function getCostPersonalBusinessCard() { /*this is the price of editing a personal business card*/
		 return campo("config_system", "id", '1', "cost_personal_bc");
}

function getCostCompanyBusinessCard() { /*this is the price of editing a company business *card*/
		 return campo("config_system", "id", '1', "cost_company_bc");
}

function getPayBussinesCard( $idUser='' ) { /*this is to know if the user have paid for his BCs*/

	return campo("users", "id", ($idUser ? $idUser : $_SESSION['ws-tags']['ws-user'][id]), "pay_bussines_card");
}

/*INI - funcion en prueba*/
function fillBusinessCardData(	&$theUserName,	&$theUserSpecialty,	&$theUserCompany,		&$theUserAddress,	&$theUserPhone,
								&$theUserEmail,	&$theUserLogo,		&$theUserMiddleText,	$bc,				$user='') {
	if( $bc ) {

			/*INI - WHEN CALLED FROM businessCard.view OR userProfile.view*/
					if( $bc[company] != "" )	$theUserCompany = $bc[company];
					else											$theUserCompany = "Social Media Marketing";

							$theUserAddress = $bc[address];

							$theUserPhone	 = "";
							$theUserPhone	.= $bc[home_phone]		!= ""	&& $bc[home_phone]	!= " " ? "<strong>".HOMEPHONE."</strong>: "  .$bc[home_phone]  ."&nbsp;"	: "";
							$theUserPhone	.= $bc[work_phone]		!= ""	&& $bc[work_phone]	!= " " ? "<strong>".WORKPHONE."</strong>: "  .$bc[work_phone]  ."&nbsp;"	: "";
							$theUserPhone	.= $bc[mobile_phone]	!= ""	&& $bc[mobile_phone]!= " " ? "<strong>".MOBILEPHONE."</strong>: ".$bc[mobile_phone]."&nbsp;"	: "";
							$theUserPhone	.= $theUserPhone!="" ? "<br/>" : "";

							$theUserLogo = $bc[company_logo_url];

							$theUserMiddleText = $bc[middle_text];
			/*END - WHEN CALLED FROM businessCard.view OR userProfile.view*/


			if( !$user ) {

					$theUserName = $bc[nameUsr];

					if( $bc[specialty]!="" )									$theUserSpecialty = $bc[specialty];
					elseif( $_SESSION['ws-tags']['ws-user'][screenName]!="" )	$theUserSpecialty = $_SESSION['ws-tags']['ws-user'][screenName];
					else														$theUserSpecialty = "";

					if( $bc[email] )	$theUserEmail = $bc[email];
					else				$theUserEmail = $_SESSION['ws-tags']['ws-user'][email];

			} else {/*IF IT'S A NEW BUSINESS CARD*/

					$theUserName		=	$user[full_name];
					$theUserSpecialty	=	$user[screen_name];
					$theUserEmail		=	$user[email];

			}
	}
}
/*FIN - funcion en prueba*/




function uploadFTP($file,$path,$parent='', $borrar=1){
		// nombre de archivo y carpeta solamente,  parent es para cuando se trabaje desde un include

		//echo $path;
	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		ftp_chdir ($id_ftp, $path.'/');

		@ftp_mkdir($id_ftp, $_SESSION['ws-tags']['ws-user'][code]);
		//@ftp_chmod($id_ftp, 0777, $_SESSION['ws-tags']['ws-user'][code]);

		ftp_chdir ($id_ftp, $_SESSION['ws-tags']['ws-user'][code].'/');
		@ftp_put($id_ftp, 'index.html', $parent.'img/index.html', FTP_BINARY);


		ftp_put($id_ftp, $file, $parent.'img/'.$path.'/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$file, FTP_BINARY);
		ftp_quit($id_ftp);

		if($borrar){
			@unlink($parent.'img/'.$path.'/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$file);
			//die();

		}
		//die();
	}
}
function copyFTP($file,$path,$pathDestination){


		//echo $path;
	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		ftp_chdir ($id_ftp, $path.'/');
        @ftp_mkdir($id_ftp, $_SESSION['ws-tags']['ws-user'][code]);
		ftp_chdir ($id_ftp, $_SESSION['ws-tags']['ws-user'][code].'/');

		@ftp_put($id_ftp, $file, '/'.$pathDestination.'/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$file, FTP_BINARY);
		ftp_quit($id_ftp);


		//die();
	}
}
function deleteFTP($file,$path,$parent=''){
		// nombre de archivo y carpeta solamente,  parent es para cuando se trabaje desde un include

		//echo $path;
	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		ftp_chdir ($id_ftp, $path.'/'.$_SESSION['ws-tags']['ws-user'][code].'/');

		@ftp_delete($id_ftp,$file);
		ftp_quit($id_ftp);


		//die();
	}else{

		@unlink($parent.'img/'.$path.'/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$file);

	}
}

function opendirFTP($path,$parent=''){
		// nombre carpeta solamente,  lista los archivos contenidos en la carpeta
 	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		$salida = ftp_rawlist($id_ftp,$path);
		///////////////////// date extract

		  $_cont=0;
		  foreach ($salida as $v) {


			$vinfo = preg_split("/[\s]+/", $v, 9);
			if ($vinfo[0] !== "total"&&$vinfo[8]!='.'&&$vinfo[8]!='..') {

			  if($rawlist[strtotime($vinfo[5] . " " . $vinfo[6] . " " . $vinfo[7])]!=''){

				  $rawlist[strtotime($vinfo[5] . " " . $vinfo[6] . " " . $vinfo[7])+(++$_cont)] = $vinfo[8];

			  }else{
				  $rawlist[strtotime($vinfo[5] . " " . $vinfo[6] . " " . $vinfo[7])] = $vinfo[8];
			  }

			}
		  }

		 @krsort($rawlist);//

		////////////////////
		ftp_quit($id_ftp);



		//die ("sdfsdfsdfsdfsdfsdf");
		//print_r($salida);
		return $rawlist;


	}else{

		return @opendir($parent.'img/'.$path);

	}
}



function readdirFTP(&$_array){


	if(!NOFPT){

		$salida = @current($_array);
		@next($_array);
		return $salida;

	}else{

		return @readdir($_array);

	}

}
function fileExistsRemote($path){
	return (@fopen($path,'r')==true);
	// $res=get_headers($path);
	// echo $res[0];
}
function fileExists($file){
#detecta si un archivo existe, ya sea local o remoto
	return is_file($file) || (@fopen($file,'r')==true);
}

function notifications($id_friend, $id_source, $id_type, $url_destination="", $action="", $id_user=""){

		 $id_user = ($id_user!="") ? $id_user : $_SESSION['ws-tags']['ws-user'][id];

		 if ($action==""){

/*			 $validation = $GLOBALS['cn']->query("SELECT id

											  FROM users_notifications

											  WHERE id_type = '".$id_type."' AND

													id_source = '".$id_source."' AND

													url_destination = '".$url_destination."' AND

													id_user = '".$id_user."' AND

													id_friend = '".$id_friend."'
											 ");

			 if (mysql_num_rows($validation)==0 || $id_type=='4'){
				 //if ($id_user!=$id_friend){
*/					 $GLOBALS['cn']->query("INSERT INTO users_notifications SET id_type = '".$id_type."',
																			   id_source       = '".$id_source."',
																			   url_destination = '".$url_destination."',
																			   id_user         = '".$id_user."',
																			   id_friend       = '".$id_friend."',
																			   revised         = '0'
													 ");
				 //}
		    // }

		 }else{//else action

			 $GLOBALS['cn']->query("DELETE FROM users_notifications

											              WHERE id_type = '".$id_type."' AND

																id_source = '".$id_source."' AND

											                    url_destination = '".$url_destination."' AND

																id_user = '".$id_user."' AND

											                    id_friend = '".$id_friend."'
											 ");
		 }
}

function getMonth($pos=1){

         $array[0]  = '';
		 $array[1]  = JANUARY;
         $array[2]  = FEBRURY;
         $array[3]  = MARCH;
         $array[4]  = APRIL;
         $array[5]  = MAY;
         $array[6]  = JUNE;
         $array[7]  = JULY;
         $array[8]  = AUGUST;
         $array[9]  = SEPTEMBER;
         $array[10] = OCTOBER;
         $array[11] = NOVEMBER;
         $array[12] = DECEMBER;

         return $array[$pos];
}


/* newwwww */
function getCreatingTagPoints() {				/* *** points of creating a tag ***************** */
	return campo("config_system", "id", '1', "creating_tag_points");
}

function getSharingTagPoints() {			/* *** points of mailing a tag ****************** */
	return campo("config_system", "id", '1', "sending_tag_points");
}

function getTagPoints( $idTag ) {

	$redistributingTagPoints		= campo("config_system", "id", '1', "redistributing_tag_points");
	$redistributingSponsorTagPoints	= campo("config_system", "id", '1', "redistributing_sponsor_tag_points");

	$result = $GLOBALS['cn']->query("	SELECT click_current, click_max
										FROM users_publicity
										WHERE
											id_tag				= '".$idTag."' AND
											id_type_publicity	= '4' AND
											status				= '1';");

	if( mysql_num_rows($result)>0 )
	{
		$result = mysql_fetch_assoc($result);
		return $result[click_current]<$result[click_max] ? $redistributingSponsorTagPoints : $redistributingTagPoints;
	}

	return $redistributingTagPoints;
}

function updateUserCounters($id_user, $field, $inc, $action) {

	     $usr = ($id_user!='') ? $id_user : $_SESSION['ws-tags']['ws-user'][id];

	     $query = $GLOBALS['cn']->query(" SELECT  $field FROM users WHERE id = '".$usr."'");
		 $array = mysql_fetch_assoc($query);

		 if ($action=='+') {

			  $update = $GLOBALS['cn']->query("UPDATE users SET ".$field." = ".$field." ".$action." ".$inc." WHERE id = '".$id_user."'");

		 }elseif($action=='-' && $array[$field]>=$inc) {

			 $update = $GLOBALS['cn']->query("UPDATE users SET ".$field." = ".$field." ".$action." ".$inc." WHERE id = '".$id_user."'");

		 }

}

function getUserProfile(&$user_id){
	$profiles=$GLOBALS['cn']->query("SELECT id FROM users WHERE username='".basename($_SERVER['REQUEST_URI'])."' ");
	if (mysql_num_rows($profiles)==0){
		return false;
	}elseif (mysql_num_rows($profiles)>0){
		$profile=mysql_fetch_assoc($profiles);
		$user_id=$profile[id];
		return true;
	}
}
function arrayBackgroundsBlocked($id_user=''){
	$backgrounds=$GLOBALS['cn']->query('
		SELECT background
		FROM tags_delete_backgrounds
		WHERE id_user="'.(($id_user!='')?$id_user:$_SESSION['ws-tags']['ws-user']['id']).'"
	');
	$array=array('');//validacion,si no hay fondos borrados
	while ($background=mysql_fetch_assoc($backgrounds)){
		$array[]=$background['background'];
	}
	return $array;
}

function viewChatFriends($id=""){
		 $user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user'][id]) : md5($id);
		 dropViews(array("view_friends"));

		 //los que el usuario sigue  
		 $friends = $GLOBALS['cn']->query("CREATE VIEW view_friends AS

											SELECT DISTINCT
												   l.id_user AS id_user,

												   l.id_friend as id_friend,
												   
												   u.screen_name,

												   CONCAT(u.name, ' ', u.last_name) AS name_user,

												   u.profile_image_url  AS photo_friend,

												   u.email as email,

												   u.home_phone,

												   u.mobile_phone,

												   u.work_phone,
												   
												   u.chat_last_update,

												   md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend

											FROM users u INNER JOIN users_links l ON u.id=l.id_friend

											WHERE md5(l.id_user)='".$user."';
						                   ");
		 //amigos code_friend screen_name name_user photo_friend last_update
		 
		 $dif="TIMESTAMPDIFF(MINUTE,f.chat_last_update,now())";
		 $friends = $GLOBALS['cn']->query("SELECT 
												   f.name_user AS n,
												   f.photo_friend AS p,
												   f.code_friend AS c,
												   
												   if(f.screen_name='',f.name_user,f.screen_name) as s,
												   
												   if($dif>10,'offline',if($dif>5,'away','online')) as 't'


											FROM view_friends f INNER JOIN users_links u ON f.id_friend=u.id_user

											WHERE md5(u.id_friend) = '".$user."' 
											
											order by TIMESTAMPDIFF(MINUTE,f.chat_last_update,now()) ASC

											LIMIT 0, 50;
										  ");
		 return $friends;
}

function replaceCharacters($cad){
	return mysql_real_escape_string($cad);
}
function tagURL($tag,$mini=false){
	global $config;
	$tid=substr(intToMd5($tag),-16);
	// return $config->img_server_path.'img/templates/'.$tid.($mini?'.m':'').'.jpg';
	return $config->img_server.'img/tags/'.$tid.($mini?'.m':'').'.jpg';
}
function createTag($tag,$force=false,$msg=false){
	global $config;
	$img_path=$config->img_server_path;
	//Informacion basica para crear la imagen de tag
	$default='tmp'.rand(0,99);
	if (!class_exists('WideImage')) require(RELPATH.'class/wideImage/WideImage.php');
	$path='img/tags';
	$debug=isset($_GET['debug'])||(is_array($tag)&&$tag['debug']!='');
	$tid=substr(intToMd5(is_array($tag)?($tag['idTag']==''?$default:$tag['idTag']):$tag),-16);
	$tmpFile=$default;
	if($tid==$default){
		$force=true;
		$tid=$tmpFile;
	}
	$photo=$tid.'.jpg';
	$photom=$tid.'.m.jpg';
	$photopath=$path.'/'.$photo;
	$photompath=$path.'/'.$photom;
	$_path=$config->img_server_path;

	//$tempmatrix = str_replace('[','',);

	//Se busca la imagen de la tag
	if(!$force) $im=imagecreatefromany($_path.$photopath);
	//Si la imagen de la tag no existe,se crea
	if(@$im||$debug){
		if(!is_array($tag)) $tag=getTagData($tid);
		$tag['fondoTag']=preg_replace('/ /','%20',$tag['fondoTag']);
		if(!empty($tag['fondoTag'])){
			//Fondo
			if(preg_match('/[0-9a-f]{8}_\d+_\d\.jpe?g$/i',$tag['fondoTag']))
				$imagen=$config->video_server_path.'videos/'.$tag['fondoTag'];
			else
				$imagen=$config->img_server_path.'img/templates/'.$tag['fondoTag'];
		}
		$user_picture=getUserPicture($tag['photoOwner']);
		//Debugger

		$datamatrix = explode(',',str_replace(']','',str_replace('[','',$tag['bgmatrix'])));
		$matrixscale = $datamatrix[0] + 0;
		$matrixX = $datamatrix[4] + 0;
		$matrixY = $datamatrix[5] + 0;
		//print_r($datamatrix);

		if($debug){
			_imprimir($tag);
			echo '<br/><br/>fondo='.$imagen;
			echo '<br/>'.str_replace($img_path,$config->img_server,
				str_replace($config->video_server_path,$config->video_server,$imagen));
			echo '<br/><br/>photo url='.$img_path.$tag['photoOwner'];
			echo '<br/>'.$config->img_server.$tag['photoOwner'];
			echo '<br/><br/>photo used='.$img_path.$user_picture;
			echo '<br/>'.$config->img_server.$user_picture;
		}
		if($tag){
			$font=array(
				$config->relpath.'fonts/trebuc.ttf',
				$config->relpath.'fonts/trebucbd.ttf',
				$config->relpath.'fonts/verdana.ttf',
				$config->relpath.'fonts/verdanab.ttf'
			);
			//Se crea la imagen con el tamaño normal - 1200 x 554.
			$im=imagecreatetruecolor(TAGWIDTHHD,TAGHEIGHTHD);
			//calculo del tamanio base al tamanio HD
			$basemult = round(TAGWIDTHHD/TAGWIDTH,3);
			//Crear algunos colores
			$blanco=imagecolorallocate($im,255,255,255);
			$negro=imagecolorallocate($im,0,0,0);
			// $imagen=(strpos(' '.$tag['fondoTag'],'default')?$config->relpath:$_path).'img/templates/'.$tag['fondoTag'];
			// $img=imagecreatefromany($imagen);
			$is=@getimagesize($imagen);
			if($is[0]>0){
				list($bgancho, $bgalto, $bgtipo, $bgatributos) = getimagesize($imagen);
				//echo '<pre>Image :' .$bgancho;
				$img=WideImage::load($imagen);
				//Acomodar los fondos viejos para evitar los mozaicos
				if($is[0]<TAGWIDTHHD){
					$img = $img->resize(TAGWIDTHHD);
					$is[0]=$img->getWidth();
					$is[1]=$img->getHeight();
				}
				//Si tiene zoom la imagen
				if($matrixscale>1){
					$newwidt = round($bgancho*$matrixscale);
					$newheith = round($bgalto*$matrixscale);
					$img = $img->resize($newwidt,$newheith);
					$is[0]=$newwidt;
					$is[1]=$newheith;
					echo '<pre>Image needs rezise from crop: '.$is[0].'</pre>';
				}
				//Si fue movida la imagen
				if((abs($matrixX)>0)||(abs($matrixY)>0)){
					//echo '<pre>La imagen tiene movimiento: is0:'. $is[0] . ' is1:' . $is[1];
					//echo '<pre>La imagen tiene movimiento: x:'. $matrixX . ' y:' . $matrixY;
					$img = $img->crop(abs($matrixX),abs($matrixY));
					$is[0]=$img->getWidth();
					$is[1]=$img->getHeight();
					echo '<pre>La imagen nueva tiene: ancho:'. $is[0] . ' alto:' . $is[1];
				}
				if($is[0]<TAGWIDTHHD){
					$img = $img->resize(TAGWIDTHHD);
					$is[0]=$img->getWidth();
					$is[1]=$img->getHeight();
				}
				//$img->resizeDown(650);
				$img->resizeDown(TAGHEIGHTHD);
				$dy=intval((TAGHEIGHTHD-$is[1])/2);
				while($dy>0) $dy-=$is[1];
				do{
					$dx=$is[0]>TAGWIDTHHD?intval((TAGWIDTHHD-$is[0])/2):0;
					do{
						imagecopy($im,$img->getHandle(),$dx,$dy,0,0,$is[0],$is[1]);
						$dx+=$is[0];
					}while($dx<TAGWIDTHHD);
					$dy+=$is[1];
				}while($dy<TAGHEIGHTHD);
				// imagedestroy($img);
				$img->destroy();
			}
			//Bordes redondeados
			$cr=25;//radio de la curva
			$mask=imagecreatetruecolor(TAGWIDTHHD,TAGHEIGHTHD);
			imagecopy($mask,$im,0,0,0,0,TAGWIDTHHD,TAGHEIGHTHD);
			$im1=WideImage::loadFromHandle($mask);
			$im1=$im1->roundCorners(30,$im1->allocateColor(255,255,255), 2,255);
			imagecopy($im,$im1->getHandle(),0,0,0,0,TAGWIDTHHD,TAGHEIGHTHD);
			$im1->destroy(); 
			/**/
			//Imagen de usuario
			if($tag['idProduct']) $imagen=$_path.$tag['photoOwner'];
			else $imagen=$_path.getUserPicture($tag['photoOwner']);
			if($debug) echo '<br/>'.$imagen;
			$img=imagecreatefromany($imagen);
			if($img){
				$im2=WideImage::loadFromHandle($img);
				if ($im2->getWidth()!=round(60*$basemult) || $im2->getHeight()!=round(60*$basemult) ){
					if ($im2->getWidth()!==$im2->getHeight()){
						$w=$im2->getWidth();$h=$im2->getHeight();
						if ($w>$h){
							$y=0;
							$x=($w-$h)/2;
							$t=$h;
						}else{
							$x=0;
							$y=($h-$w)/2;
							$t=$w;
						}
						$im2 = $im2->crop($x,$y,$t,$t);
					}
					$im2=$im2->resize(round(60*$basemult),round(60*$basemult));
				}
				$im2=$im2->roundCorners(33,null, 2,255);
//				imagecopy($im,$im2->getHandle(),40,215,0,0,60,60); 
				imagecopy($im,$im2->getHandle(),round(40*$basemult),round(215*$basemult),0,0,round(60*$basemult),round(60*$basemult)); 
				$im2->destroy();
			}
			//Textos de la tag.
			//texto1 y texto2 por su tamaño se les define un ancho maximo y pueden tener multiples lineas
			$luz	=imagecolorhexallocatealpha($im,'#FFFFFF');
			$sombra	=imagecolorhexallocatealpha($im,'#000000');
			//Tipos de fuentes. 0=normal,1=negrita
			//texto1 - Parte superior
			$fuente=$font[1];
			$texto=strclean($tag['texto']);
			$color=imagecolorhexallocate($im,$tag['color_code']);
			//$size=15;
			$size=round(15*$basemult);
			$txt=imagettfbbox($size,0,$fuente,$texto);
			//$y=73;
			$y=round(73*$basemult);
			//$mw=600;//max width - ancho maximo
			$mw=TAGWIDTHHD;//max width - ancho maximo
			$tmp=explode(' ',$texto);
			$i=0;
			do{
				$texto=$tmp[$i++];
				$txt=imagettfbbox($size,0,$fuente,$texto);
				while(count($tmp)>$i&&$txt[2]<$mw){
					$txt=imagettfbbox($size,0,$fuente,$texto.' '.$tmp[$i]);
					if($txt[2]<$mw) $texto.=' '.$tmp[$i++];
				}
				$txt=imagettfbbox($size,0,$fuente,$texto);
				$x=intval((TAGWIDTHHD-$txt[2])/2);
				imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
				imagettftext($im,$size,0,$x-1,$y-1,$luz,$fuente,$texto);
				imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
				$y+=23;
			}while(count($tmp)>$i);
			//texto principal - Centro
			$fuente=$font[0];
			$texto=strtoupper(strclean($tag['code_number']));
			$color=imagecolorhexallocate($im,$tag['color_code2']);
			//$size=45;
			$size=round(45*$basemult);
			$s=0;//separacion entre letras
			$len=strlen($texto);
			$txt=imagettfbbox($size,0,$fuente,$texto);
			$x=intval((TAGWIDTHHD-$txt[2])/2);
			//$y=165;
			$y=round(165*$basemult);
			imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
			imagettftext($im,$size,0,$x-1,$y-1,$luz,$fuente,$texto);
			imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
			//nombre usuario
			$fuente=$font[1];
			$texto=strclean($tag['nameOwner']);
			$color=$blanco;
			$sombra=$negro;
			$size=round(15*$basemult);
			$x=round(115*$basemult);
			$y=round(223*$basemult);
			imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
			imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
			//fecha
			$txt=imagettfbbox($size,0,$fuente,$texto);
			$fuente=$font[0];
			$texto=date('d-M-Y H:i',$tag['date']);
			//$size=8;
			$size=round(8*$basemult);
			$x+=$txt[2]+10;
			imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
			imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);

			//texto2 - parte baja
			$fuente=$font[1];
			$texto=strclean($tag['texto2']);
			$color=imagecolorhexallocate($im,$tag['color_code3']);
			$size=round(10*$basemult);
			$x=round(115*$basemult);
			$y=round(241*$basemult);
			$mw=round(430*$basemult);//max width-ancho maximo
			$tmp=explode(' ',$texto);
			$i=0;
			do{
				$texto=$tmp[$i++];
				$txt=imagettfbbox($size,0,$fuente,$texto);
				while(count($tmp)>$i&&$txt[2]<$mw){
					$txt=imagettfbbox($size,0,$fuente,$texto.' '.$tmp[$i]);
					if($txt[2]<$mw) $texto.=' '.$tmp[$i++];
				}
				imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
				imagettftext($im,$size,0,$x-1,$y-1,$luz,$fuente,$texto);
				imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
				$y+=15;
			}while(count($tmp)>$i);
			//Imagen de placa
			$imagen=$config->relpath.'img/placaFondo.png';
			redimensionar($imagen,$imagen->relpath.$photompath,TAGWIDTHHD);
			$img=imagecreatefromany($imagen);
			if($img){
				$is=getimagesize($imagen);
				imagecopy($im,$img,0,0,0,0,$is[0],$is[1]);
				imagedestroy($img);
			}
		}
		//subir el archivo al servidor
		// if(!$debug){//si estamos en debug no se guarda
			$phototmp=$config->relpath.$path.'/tmp'.rand().'.png';
			imagepng($im,$phototmp);
			if (redimensionar($phototmp,$config->relpath.$photopath,TAGWIDTHHD)){
				@unlink($phototmp);
				$ftp=FTPupload("tags/$photo");
				if($msg) echo '<br/>guardada imagen '.$photo;
			}
		// }
	}elseif($msg) echo '<br/>ya existe la imagen '.$photo;
	//FIN - creacion de la imagen de la tag
	//creamos la miniatura si no existe
	if(@$im&&(!fileExists($_path.$photompath)||$force)){
		// if(!$debug){//si estamos en debug no se guarda
			$phototmp=$config->relpath.$path.'/'.$tmpFile.'.png';
			imagepng($im,$phototmp);
			if (redimensionar($phototmp,$config->relpath.$photompath,200)){
				@unlink($phototmp);
				$ftp=FTPupload("tags/$photom");
				if($msg) echo '<br/>guardada miniatura '.$photom;
			}
		// }
	}
	if($debug) echo "<br/>ftp result=$ftp";
	if(!empty($tag['id'])) CON::update('tags',"img=?",'id=?',array($tid,$tag['id']));
	return $tid;
}
function intToMd5($id){
	if(is_string($id)) $id=trim($id);
	if($id!=''&&!preg_match('/\D/',$id)) $id=md5($id);
	return $id;
}
function getTagData($tid=''){
	$noTag=array('idTag'=>$tid,'code_number'=>'notag','color_code2'=>'#333','photoOwner'=>'img/users/default.png','fondoTag'=>'empty');
	if($tid=='') return $noTag;
	$tid=intToMd5($tid);
	$where=safe_sql('substring(md5(t.id),-16)=?',array(substr($tid,-16)));
	if(strlen($tid)==15) $where=safe_sql('substring(md5(t.id),-15)=?',array(substr($tid,-15)));
	$tag=CON::getRow(getTagQuery().' WHERE '.$where);
	if($tag['id']=='') return $noTag;
	return $tag;
}
function getTagQuery($extra=''){ //t=tag,p=product,u=user(owner)
	return '
		SELECT
			t.id,
			t.id			as idTag,
			t.background	as fondoTag,
			t.bgmatrix 		as bgmatrix,
			t.id_creator	as idOwner,
			t.id_user		as idUser,
			if(p.id is null,u.screen_name,p.name) as nameOwner,
			(SELECT screen_name FROM users WHERE id=t.id_user) as nameUsr,
			if(p.id is null,
				if(u.profile_image_url="","img/users/default.png",concat("img/users/",md5(CONCAT(u.id,"_",u.email,"_",u.id)),"/",u.profile_image_url)),
				concat("img/",p.photo)
			) as photoOwner,
			p.id			as idProduct,
			t.text			as texto,
			t.text2			as texto2,
			t.date			as fechaTag,
			t.video_url		as video,
			t.color_code,t.color_code2,t.color_code3,
			t.points,t.code_number,t.profile_img_url,t.status,
			md5(CONCAT(u.id,"_",u.email,"_",u.id)) as code,
			unix_timestamp(t.date) AS date
			'.($extra==''||$extra==' '?'':','.$extra).'
		FROM tags t
		JOIN users u ON u.id=t.id_creator
		LEFT JOIN store_products p ON p.id=t.id_product
	';
}
function imagecreatefromany($imagen){
	if(!fileExists($imagen)){
		if(isset($_GET['debug'])) echo '<br/>No existe '.$imagen;
		return false;
	}
	$type=getimagesize($imagen);
	$type=$type[2];
	//$type:1=gif,2=jpg,3=png
	if($type==1) return imagecreatefromgif ($imagen);
	if($type==2) return imagecreatefromjpeg($imagen);
	if($type==3) return imagecreatefrompng ($imagen);
	//Retorna falso si no es ninguno de los tipos identificados
	return false;
}
function getUserPicture($photo,$default='img/users/default.png'){
	$path='img/users/';
	if(strpos($photo,$path)===false) $photo=$path.$photo;
	if(preg_match('/\S+\.\S+$/',$photo)){
		$thumb=preg_replace('/(\.\S+)$/','_thumb$1',$photo);
		if(fileExistsRemote(FILESERVER.$thumb))
			return $thumb;
		elseif(fileExistsRemote(FILESERVER.$photo))
			return $photo;
	}
	return $default;
}
function imagecolorhexallocatealpha(&$im,$hex,$alpha=50){
	$color=HexToRGB($hex);
	return imagecolorallocatealpha($im,$color['r'],$color['g'],$color['b'],$alpha);
}
function HexToRGB($hex){
	$hex=str_replace('#','',$hex);
	$color=array();
	if(strlen($hex)==3){
		$color['r']=hexdec(substr($hex,0,1).substr($hex,0,1));
		$color['g']=hexdec(substr($hex,1,1).substr($hex,1,1));
		$color['b']=hexdec(substr($hex,2,1).substr($hex,2,1));
	}elseif(strlen($hex)==6){
		$color['r']=hexdec(substr($hex,0,2));
		$color['g']=hexdec(substr($hex,2,2));
		$color['b']=hexdec(substr($hex,4,2));
	}
	return $color;
}
//funcion para limpiar y corregir caracteres especiales en una cadena.
function strclean($txt){
	$txt=preg_replace('/&nbsp;?/i',' ',$txt);
	$array=array(
		'\\\\'=>'\\',
		'\\\''=>'\'',
		'\\"'=>'"',
		'&amp;'=>'&'
	);
	return str_replace(array_keys($array),array_values($array),$txt);
}
function imagecolorhexallocate(&$im,$hex){
	if($hex=='') $hex='#fff';
	$color=HexToRGB($hex);
	return imagecolorallocate($im,$color['r'],$color['g'],$color['b']);
}

#subir imagenes por FTP. Usar rutas relativas desde dentro de IMG.
# Valores retornados:
# 200: subida exitosa
# 206: subida exitosa, pero falla al eliminar el original
# 400: la sintaxis de destino es incorrecta
# 401: no se pudo crear el archivo
# 403: no se pudo establecer la conexion
# 404: el archivo a subir no existe o la ruta es incorrecta
# 408: sin ftp, indica que no se pudo mover el archivo
# 409: sin ftp, indica que no se pudo copiar el archivo
# 412: no se pudo crear/acceder a la(s) carpeta(s) de destino
function FTPupload($origen,$destino='',$borrar=true){
	#origen: donde esta la imagen. destino: donde ira la imagen.
	#borrar: falso si no se quiere eliminar la imagen original
	#las rutas deben ser relativas a img. si destino es vacio o false, se colocara en la misma ruta del origen
	//validaciones previas
	if(!is_file(RELPATH.'img/'.$origen)) return 404;
	global $config;
	$error=0;
	if($destino=='') $destino=$origen;
	$file=end(explode('/',$destino));
	if(!$file) $error=400;
	$path=isset($config->ftp->folder)?$config->ftp->folder.'/':'';
	$path.=preg_replace('/^\/|\/[^\/]*$/','',$destino);
	$data=" P:$path F:$file O:$origen D:$destino";
	if(!$error)
	if(isset($config->ftp)){
		if(!isset($img_ftp_con)){
			$img_ftp_con=ftp_connect($config->ftp->host,isset($config->ftp->port)?$config->ftp->port:21);
			$login=@ftp_login($img_ftp_con,$config->ftp->user,$config->ftp->pass);
			if(!$login){
				$img_ftp_con=0;
				return 403;
			}
			ftp_pasv($img_ftp_con,true);
		}
		#vamos a la carpeta raiz
		// ftp_cdup($img_ftp_con);
		#Nos vamos a la carpeta destino. Se crean las carpetas que no existan.
		$foldercount=0;
		$folders=explode('/',$path);
		foreach($folders as $folder){
			if($folder!=''){
				if(@ftp_chdir($img_ftp_con,$folder)){#abrir carpeta
					$foldercount++;
				}elseif(@ftp_mkdir($img_ftp_con,$folder)){#crear y abrir carpeta
					ftp_chdir($img_ftp_con,$folder);
					$foldercount++;
					@ftp_put($img_ftp_con,'index.html',RELPATH.'img/index.html',FTP_BINARY);
				}else{
					$error=412;
				}
			}
		}
		if(!$error){
			$data=' PWD:'.ftp_pwd($img_ftp_con).$data;
			#Copiamos el archivo
			$error=(@ftp_put($img_ftp_con,$file,RELPATH.'img/'.$origen,FTP_BINARY)) ? 200 : 401;
			#Borramos la imagen de origen si es requerido
			if($borrar&&$error==200&&!@unlink(RELPATH.'img/'.$origen)) $error=206;
		}
		ftp_quit($img_ftp_con);
	// }elseif(!$config->local){
		#Si no es local movemos al servidor de imagenes
	}else{
		#movemos al servidor de imagenes
		if(!is_dir($config->img_server_path.'img/'.$path))
			if(!@mkdir($config->img_server_path.'img/'.$path,0775,true)) $error=412;
		if(!$error)
		if($borrar)
			$error=(!@rename($_origen,$config->img_server_path.'img/'.$destino))?408:200;
		else
			$error=(!@copy($_origen,$config->img_server_path.'img/'.$destino))?409:200;
/*	}elseif($destino!=$origen){
		#Cuando no es ftp, y el origen es distinto al destino, se mueve/copia el archivo
		if(!is_dir(RELPATH.'img/'.$path))
			if(!@mkdir(RELPATH.'img/'.$path,0777,true)) $error=412;
		if(!$error)
		if($borrar)
			$error=(!@rename(RELPATH.'img/'.$origen,RELPATH.'img/'.$destino))?408:200;
		else
			$error=(!@copy(RELPATH.'img/'.$origen,RELPATH.'img/'.$destino))?409:200;
*/	}
	return $error;#.$data;#descomentar data si decea ver los mensajes de error
}
function FTPcopy($origen,$destino){
	global $config;
	$error=0;
	$count=preg_match('/(.+\/)*/',$origen,$path);
	if(!isset($config->ftp)){
		//echo 'origen:'.$origen.'<br>desti:;'.$destino;
		// $error=(!@copy($_origen,$config->img_server_path.'img/'.$destino))?409:200;
		copy(RELPATH.'img/'.$origen,RELPATH.'img/'.$destino);
	}else{
		$id_ftp=ftp_connect($config->ftp->host,21);
		ftp_login($id_ftp,$config->ftp->user,$config->ftp->pass);
		ftp_pasv ($id_ftp,false);
		$num=0;
		$path=$path[1];
		while(($pos=strpos($path,'/'))!==false){
			$folder=substr($path,0,$pos);
			if(ftp_chdir($id_ftp,$folder)){
				$num++;
			}else{
				ftp_quit($id_ftp);
				return false;
			}
			$path=substr($path,$pos+1);
		}
		$tmp='ftp_'.rand().'.bin';
		$file=end(explode('/',$origen));
		//echo ftp_pwd($id_ftp).'<br>id_ftp='.$id_ftp.'<br>file='.$file.'<br>relpath='.RELPATH;
		if($count&&ftp_get($id_ftp,RELPATH.'img/'.$tmp,$file,FTP_BINARY)){
			FTPupload($tmp,$destino,true);
		}
	}
}

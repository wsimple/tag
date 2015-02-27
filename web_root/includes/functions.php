<?php
/*
	+---------------------------------------------------+
	|													|
	|	Developed By:Websarrollo.com & Maoghost.com		|
	|	Copy Rights	:Tagamation, LLc					|
	|	Date		:02/22/2011							|
	|													|
	+---------------------------------------------------+
*/
global $config;
if(!$config) include('config.php');

if(!function_exists('base_url')){
	function base_url($url=''){
		global $config;
		while(in_array(substr($url,0,1),array('.','#','/'))) $url=substr($url,1);
		return $config->base_url.$url;
	}
}

function view($url='',$data=array()){
	if($url=='') return;
	extract($data);
	include($url);
}

function lan($text='',$format=false){
	$txt=strtolower(__($text));
	switch($format){
		case 'lc':break;
		case 'uc':$txt=strtoupper($txt);break;
		case 'ucf':$txt=ucfirst($txt);break;
		case 'ucw':$txt=ucwords($txt);break;
		default: $txt=__($text);
	}
	return $txt;
}
function __($text='',$format=false){
	global $lang;
	return (isset($lang[$text])?$lang[$text]:$text);
}

function is_debug($name=''){
	if($name=='') return isset($_COOKIE['_DEBUG_']);
	foreach(split(',',$name) as $value)
		if(in_array($value,split(',',$_COOKIE['_DEBUG_'])))
			return true;
	return false;
}

#Limpiar caracteres incompatibles con mysql
function cls_string($mensaje){
	/*$mensaje=str_replace(array("'","\\","\"","'","ÃƒÂ¯Ã‚Â¿Ã‚Â½","ÃƒÂ¯Ã‚Â¿Ã‚Â½","\'"),"",$mensaje);
	$mensaje=$mensaje;/**/
	return $mensaje;
}

#limpiar caracteres incompatibles con javascript
function js_string($mensaje,$comillas=0){
	$mensaje=str_replace(chr(13),' ',str_replace(chr(10),' ',$mensaje));
	if($comillas==1) $mensaje=str_replace("'","\'",$mensaje);
	if($comillas==2) $mensaje=str_replace('"','\"',$mensaje);
	return $mensaje;
}
function html_string($mensaje){
	$mensaje=str_minify($mensaje);
	$mensaje=str_replace("'",'&#39;',$mensaje);
	$mensaje=str_replace('"','&quot;',$mensaje);
	return $mensaje;
}

#minimizar espacios en blanco y saltos de linea en una cadena para reducir datos de envio
function str_minify($str){
	if(is_string($str)){
		$str=preg_replace('/\\s+/',' ',$str);
		$str=preg_replace('/\\s*([\(\)\{\};])\\s*/','$1',$str);
		return $str;
	}elseif(is_array($str)){
		foreach($str as $key=>$value)
			$str[$key]=str_minify($value);
	}else{
		return $str;
	}
}

function quitar_inyect(){#Evitar Inyecciones SQL (deprecado)
	fix_request();
	return true;
}
function fix_request(){#sobrecarga manual de $_REQUEST. Prioridad: post,get
	$var=array();
	foreach($_GET as $k=>$v){
//		if(!is_array($v)){
//			foreach($filtros as $filtro){
//				$v=str_replace(trim($filtro),'',$v);
//			}
//			$_GET[$k]=$v;
			$var[$k]=$v;
//		}
	}
	foreach($_POST as $k=>$v){
//		if(!is_array($v)){
//			foreach($filtros as $filtro){
//				$v=str_replace(trim($filtro),'',$v);
//			}
//			$_POST[$k]=$v;
			$var[$k]=$v;
//		}
	}
	$_REQUEST=$var;
}

if(!function_exists('apache_request_headers')){
	function apache_request_headers(){
		$arh=array();
		$rx_http='/\AHTTP_/';
		foreach($_SERVER as $key=>$val){
			if(preg_match($rx_http,$key)){
				$arh_key=preg_replace($rx_http,'',$key);
				$arh[$arh_key]=$val;
			}
		}
		return($arh);
	}
}

function jsonp($res,$callback=true){
	if($callback&&is_assoc($res)&&is_debug()){
		$d=array();
//		$d['cookies']=$_COOKIE;
//		$d['sesion']=$_SESSION;
		$d['REQUEST']=$_REQUEST;
		$d['POST']=$_POST;
		$d['GET']=$_GET;
		$headers=apache_request_headers();
		$d['ismobile']=($_POST['CROSSDOMAIN']||$headers['SOURCEFORMAT']=='mobile');
		$res['_DEBUG_']=$d;
	}
	utf8_encode_all($res);
	$txt=json_encode($res);
	if(isset($_GET['callback'])&&$callback) $txt=$_GET['callback']."($txt)";
	return $txt;
}
function utf8_encode_all(&$var){
	if(is_string($var)&&is_ISO($var))
		$var=utf8_encode($var);
	elseif(is_array($var))
		foreach($var as $id=>&$value)
			utf8_encode_all($value);
	return $var;
}
function strcode($texto,$debug=false){#detecta el tipo de codificacion de una cadena (ASCII=1,UTF8=2,ISO-8859-1=3) (0=no string)
	if(!is_string($texto)) return 0;
	$c=0;
	$ascii=true;
	for($i=0;$i<strlen($texto);$i++){
		$byte=ord($texto[$i]);
		if($debug) echo $texto[$i].'='.$byte.'<br/>';
		if($c>0){
			if(($byte>>6)!=0x2){
				return 3;#ISO_8859_1;
			}else{
				$c--;
			}
		}elseif($byte&0x80){
			$ascii=false;
			if(($byte>>5)==0x6){
				$c=1;
			}elseif(($byte>>4)==0xE){
				$c=2;
			}elseif(($byte>>3)==0x1E){
				$c=3;
			}else{
				return 3;#ISO_8859_1;
			}
		}
	}
	return ($ascii)?1:2;#ASCII:UTF_8;
}
function is_ISO($texto){ return strcode($texto)==3; }
function is_UTF8($texto){ return strcode($texto)==2; }

if(!function_exists('is_assoc')){
	function is_assoc($a){#detecta si un arreglo es asosiativo
		if(!is_array($a)) return false;
		return !!count(array_diff(array_keys($a),range(0,count($a)-1)));
	}
}

function included($file=__FILE__){
	return basename($file)!=basename($_SERVER['SCRIPT_FILENAME']);
}

#Formatear las fechas,de mysql a html - de html a mysql
function formatoFecha($fecha){
	if(strpos($fecha,'-')){
		$fecha=explode('[-]',$fecha);
		$fecha[2]=explode('[ ]',$fecha[2]);
		$fecha[2]=$fecha[2][0];
		return $fecha[2].'/'.$fecha[1].'/'.$fecha[0];
	}elseif(strpos($fecha,'/')){
		$fecha=explode('[/]',$fecha);
		return $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	}
	return false;
}

#Imprimir vectores
function _imprimir($array='',$die=false){
	if($array=='') $array=$_REQUEST;
	echo '<div data-role="page" style="background:#fff;"><pre>';print_r($array);echo '</pre></div>';
	if($die) die();
}

#Formato Numerico
function formato($numero){
	return number_format($numero,2,',','.');//
}

#Quita formato numerico
function sinFormato($number){
	return str_replace(',','.',str_replace('.','',$number));
}

#devuelve un campo de la bd
function campo($tabla,$campo,$criterio,$pos,$and=''){
	$array=$GLOBALS['cn']->queryRow('SELECT '.$pos.' FROM '.$tabla.' WHERE '.$campo.'="'.$criterio.'" '.$and);
	return $array[$pos];
}
function get_campo($id,$tabla,$comp='1'){
	$array=$GLOBALS['cn']->queryRow('SELECT '.$id.' FROM '.$tabla.' WHERE '.$comp);
	return $array[$id];
}

#verifica existencia de un registro en la bd
function existe($tabla,$campo,$where){
	$query=$GLOBALS['cn']->query('SELECT '.$campo.' FROM '.$tabla.' '.$where);
	return (mysql_num_rows($query)>0)?true:false;
}

#borrar de la bd
function delete($tabla,$campo,$criterio){
	return $GLOBALS['cn']->query('DELETE FROM '.$tabla.' WHERE '.$campo.'="'.$criterio.'"');
}

#formatear cadenas
function formatoCadena($cadena,$op=1){
	switch($op){
		case 1:return ucwords($cadena);break;#Pone en mayusculas el primer caracter de cada palabra de una cadena
		case 2:return ucfirst($cadena);break;#Pasar a mayusculas el primer caracter de una cadena
		case 3:return strtolower($cadena);break;#Pasa a minusculas una cadena
		case 4:return strtoupper($cadena);break;#Pasa a mayusculas una cadena
		case 5:return str_replace(' ','',strtolower($cadena));break;#Pasa a mayusculas una cadena
	}
}

#devueleve el numero de registros de una consulta sql
function numRecord($tabla,$where){
	$query=$GLOBALS['cn']->query('SELECT id FROM '.$tabla.' '.$where);
	return mysql_num_rows($query);
}

#suma registros en sql
function sumRecord($campo,$tabla,$where){
	$query=$GLOBALS['cn']->query('SELECT SUM('.$campo.') AS suma FROM '.$tabla.' '.$where);
	$array=mysql_fetch_assoc($query);
	return $array['suma'];
}

#semilla
function make_seed(){
	list($usec,$sec)=explode(' ',microtime());
	return (float) $sec+((float) $usec*100000);
}


#numero referencia
function refereeNumber($cad){
	$numero=substr(md5($cad),0,9);

	if (existe('users','referee_number',' WHERE referee_number LIKE "'.$numero.'"')){
		refereeNumber($cad.srand(make_seed()));
	}else{
		return $numero;
	}
}

#calculo de la edad
function edad($fecha,$char){
	list($Y,$m,$d)=explode($char,$fecha);
	return(date('md')<$m.$d?date('Y')-$Y-1:date('Y')-$Y);
}

function redirect($url,$html=true){
	if ($html)
		echo '<meta HTTP-EQUIV="REFRESH" content="0;url='.$url.'">';
	else
		echo '<div data-role="page"><script type="text/javascript">$.mobile.changePage("'.$url.'");</script></div>';
}

function mensajes($content,$titulo,$url='',$actions='',$mobile='',$id='#messages',$ancho=300,$largo=200){
	if($mobile!=1){
		echo '
		<script type="text/javascript">
			$(function(){
				$("'.$id.'").dialog({
					title:"'.$titulo.'",
					resizable:false,
					width:'.$ancho.',
					height:'.$largo.',
					modal:true,
					show:"fade",
					hide:"fade",
					buttons:{
						'.JS_OK.':function(){
							$(this).dialog("close");
						}
					},
					open:function(){
						$(this).html("'.$content.'");
					},
					close:function(){
						';
		if ($actions!=''){
			echo $actions;
		}else{
			echo ($url!=''?'':'//').'redir("'.$url.'");';
		}
		echo '
					}
				});
			});
		</script>';
	}else{
		echo '
		<div data-role="page">
			<div data-role="header" data-nobackbtn="true" data-theme="d" >
			<a data-theme="d" href="#" data-rel="back" style="display:none"></a>
				<h1>'.$titulo.'</h1>
			</div><!--/header-->
			<div data-role="content">
				'.$content.'
				<a href="#" data-role="button" onclick="'.($actions!=''?$actions:($url!=''?(strpos(' '.$url,'Android')?$url:"location='".$url."'"):'')).'">Ok</a>
			</div><!--/content-->
			<div data-role="footer" data-theme="d" data-position="fixed">
				<h4>Tagbum &copy;</h4>
			</div>
		</div>';
		//die();
	}
}

function isFriend($id_friend,$id_user=''){
	if($id_user=='') $id_user=$_SESSION['ws-tags']['ws-user']['id'];
	$id_user=intToMd5($id_user);
	$id_friend=intToMd5($id_friend);
//	$query=$GLOBALS['cn']->query('
//		SELECT u1.id_friend
//		FROM users_links u1
//		JOIN users_links u2 ON u1.id_user=u2.id_friend AND u1.id_friend=u2.id_user
//		WHERE	md5(u1.id_user)="'.$id_friend.'" AND
//				md5(u1.id_friend)="'.$id_user.'"
//	');
	$query=$GLOBALS['cn']->query('
		SELECT id_friend
		FROM users_links
		WHERE	md5(id_user)="'.$id_user.'" AND
				md5(id_friend)="'.$id_friend.'" AND
				is_friend=1
	');
	return (mysql_num_rows($query)==0)?false:true;
}

function isFallowing($id_user,$id_friend){
	if($id_user=='') $id_user=$_SESSION['ws-tags']['ws-user']['id'];
	$id_user=intToMd5($id_user);
	$id_friend=intToMd5($id_friend);
//	$query=$GLOBALS['cn']->query('
//		SELECT id_friend
//		FROM users_links
//		WHERE md5(id_user)="'.$id_user.'" AND md5(id_friend)="'.$id_friend.'"
//	');
	$query=$GLOBALS['cn']->query('
		SELECT id_friend
		FROM users_links
		WHERE	md5(id_user)="'.$id_user.'" AND
				md5(id_friend)="'.$id_friend.'" AND
				is_friend=0
	');
	return (mysql_num_rows($query)==0)?false:true;
}

function dropViews($views){
	foreach($views as $view){
		$GLOBALS['cn']->query('DROP VIEW IF EXISTS '.$view);
	}
}

function view_friends($id='',$like='',$notIn='',$limit='0,2000'){
	$user=($id=='')?md5($_SESSION['ws-tags']['ws-user']['id']):md5($id);
	dropViews(array('view_friends'));

	//los que el usuario sigue
	$GLOBALS['cn']->query('
		CREATE VIEW view_friends AS
		SELECT DISTINCT
			l.id_user,
			l.id_friend,
			u.screen_name,
			u.username,
			CONCAT(u.name," ",u.last_name) AS name_user,
			u.profile_image_url AS photo_friend,
			u.email,
			u.home_phone,
			u.mobile_phone,
			u.followers_count,
			u.friends_count,
			u.work_phone,
			(SELECT c.name FROM countries c WHERE c.id=u.country) AS country,
			md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code_friend
		FROM users u JOIN users_links l ON u.id=l.id_friend
		WHERE md5(l.id_user)="'.$user.'" AND is_friend = 1
	');

	//amigos
	if($like!='') $like='AND f.name_user LIKE "%'.$like.'%"';

	$friends=$GLOBALS['cn']->query('
		SELECT	f.id_friend,
				f.name_user,
				f.photo_friend,
				f.code_friend,
				f.email,
				f.username,
				f.home_phone,
				f.screen_name,
				f.mobile_phone,
				f.followers_count,
				f.friends_count,
				f.work_phone,
				f.country
		FROM view_friends f JOIN users_links u ON f.id_friend=u.id_user
		WHERE md5(u.id_friend)="'.$user.'" '.$like.' '.$notIn.'
		ORDER BY f.name_user
		LIMIT '.$limit.';'
		);

	return $friends;
}

function view_friendsOfFriends($id='',$limit=10){
	if ($_SESSION['ws-tags']['ws-user']['id']!=''||$id!=''){
		$user=($id=='')?md5($_SESSION['ws-tags']['ws-user']['id']):md5($id);

		//los que yo sigo - Nivel 1
		dropViews(array('view_friends_level01'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level01 AS
			SELECT DISTINCT	id_user AS id_user,
							id_friend as id_friend
			FROM users_links
			WHERE md5(id_user)="'.$user.'"
		');

		//los que siguen::Nivel 1
		dropViews(array('view_friends_level02'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level02 AS
			SELECT
				u.id_user AS id_user,
				u.id_friend AS id_friend
			FROM view_friends_level01 f JOIN users_links u ON f.id_friend=u.id_user
			WHERE md5(u.id_friend)!="'.$user.'" AND u.id_friend NOT IN (select id_friend from view_friends_level01)
			GROUP BY u.id_friend
		');

		//los que siguen::Nivel 2
		dropViews(array('view_friends_level03'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level03 AS
			SELECT
				u.id_user AS id_user,
				u.id_friend AS id_friend
			FROM view_friends_level02 f JOIN users_links u ON f.id_friend=u.id_user
			WHERE md5(u.id_friend)!="'.$user.'" AND
				u.id_friend NOT IN (select id_friend from view_friends_level01) AND
				u.id_friend NOT IN (select id_friend from view_friends_level02)
			GROUP BY u.id_friend
		');

		//los que siguen::Nivel 3
		dropViews(array('view_friends_level04'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level04 AS
			SELECT
				u.id_user AS id_user,
				u.id_friend AS id_friend
			FROM view_friends_level03 f JOIN users_links u ON f.id_friend=u.id_user
			WHERE md5(u.id_friend)!="'.$user.'" AND
				u.id_friend NOT IN (select id_friend from view_friends_level01) AND
				u.id_friend NOT IN (select id_friend from view_friends_level02) AND
				u.id_friend NOT IN (select id_friend from view_friends_level03)
			GROUP BY u.id_friend
		');

		//los que siguen::Nivel 4
		dropViews(array('view_friends_level05'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level05 AS
			SELECT
				u.id_user AS id_user,
				u.id_friend AS id_friend
			FROM view_friends_level04 f JOIN users_links u ON f.id_friend=u.id_user
			WHERE md5(u.id_friend)!="'.$user.'" AND
				u.id_friend NOT IN (select id_friend from view_friends_level01) AND
				u.id_friend NOT IN (select id_friend from view_friends_level02) AND
				u.id_friend NOT IN (select id_friend from view_friends_level03) AND
				u.id_friend NOT IN (select id_friend from view_friends_level04)
			GROUP BY u.id_friend
		');

		//los que siguen::Nivel 5
		dropViews(array('view_friends_level06'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level06 AS
			SELECT
				u.id_user AS id_user,
				u.id_friend AS id_friend
			FROM view_friends_level05 f JOIN users_links u ON f.id_friend=u.id_user
			WHERE md5(u.id_friend)!="'.$user.'" AND
				u.id_friend NOT IN (select v.id_friend from view_friends_level01 v) AND
				u.id_friend NOT IN (select w.id_friend from view_friends_level02 w) AND
				u.id_friend NOT IN (select x.id_friend from view_friends_level03 x) AND
				u.id_friend NOT IN (select y.id_friend from view_friends_level04 y) AND
				u.id_friend NOT IN (select z.id_friend from view_friends_level05 z)
			GROUP BY u.id_friend
		');

		//unificacion de las vistas
		dropViews(array('view_friends_level07'));
		$GLOBALS['cn']->query('
			CREATE VIEW view_friends_level07 AS
				(SELECT id_user,id_friend FROM view_friends_level02)
			UNION
				(SELECT id_user,id_friend FROM view_friends_level03)
			UNION
				(SELECT id_user,id_friend FROM view_friends_level04)
			UNION
				(SELECT id_user,id_friend FROM view_friends_level05)
			UNION
				(SELECT id_user,id_friend FROM view_friends_level06)
		');

		//query
		$friends=$GLOBALS['cn']->query('
			SELECT
				f.id_user,
				f.id_friend,
				CONCAT(u.`name`," ",u.last_name) AS name_user,
				CONCAT(u.`name`," ",u.last_name) AS name,
				u.description AS description,
				md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code,
				u.username AS username,
				u.profile_image_url AS photo_friend,
				u.profile_image_url AS photo,
				u.email as email,
				u.followers_count,
				u.friends_count,
				u.following_count,
				u.followers_count AS admirers,
				u.following_count AS admired,
				u.friends_count AS friends,
				u.country as country,
				md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code_friend
			FROM users u INNER JOIN view_friends_level07 f ON u.id=f.id_friend
			WHERE u.status="1"
			LIMIT 0,'.$limit.'
		');
		return $friends;

	}else{

		$friends=$GLOBALS['cn']->query('
			SELECT
				CONCAT(u.`name`," ",u.last_name) AS name_user,
				CONCAT(u.`name`," ",u.last_name) AS name,
				md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code,
				u.description,
				u.profile_image_url AS photo_friend,
				u.profile_image_url AS photo,
				u.username AS username,
				u.email as email,
				u.country as country,
				u.followers_count,
				u.following_count,
				u.friends_count,
				u.followers_count AS admirers,
				u.following_count AS admired,
				u.friends_count AS friends,
				md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code_friend,
				u.id as id_friend
			FROM users u
			WHERE u.status=1
			ORDER BY RAND()
			LIMIT 0,'.$limit.'
		');
		return $friends;
	}//else
}

function suggestionFriends($not_ids,$limit=10){
	#se buscan los usuarios más populares y se retornan al azar
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	$criterio=($not_ids!='')?"u.id NOT IN ($not_ids) AND":'';
	if (is_int($limit)) $limit="LIMIT 0,".($limit*2);
	$friends=CON::getAssoc("
		SELECT
			u.id AS id_user,
			u.id AS id_friend,
			CONCAT(u.`name`,' ',u.last_name) AS name_user,
			u.username AS username,
			u.email as email,
			u.country as country,
			u.description AS description,
			u.followers_count,
			u.friends_count,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code_friend,
			if(u.following_count<3,0,u.followers_count/u.following_count)*
			if(u.profile_image_url='',1,2) as avg
		FROM users u
		LEFT JOIN (SELECT id_friend, id_user FROM users_links) ul ON (ul.id_friend=u.id AND ul.id_user=$myId)
		WHERE $criterio
			u.id!=$myId AND
			ul.id_friend IS NULL
		ORDER BY avg DESC
		$limit");
	shuffle($friends);
	// return array_slice($friends,0,$limit);
	return $friends;
}

function groups($where='',$limit=10,$ini=0, $suggest=false){
	if($where!='') $where='AND '.$where;
	if($limit<=0||$limit==null) $limit=50;
    $fecha=explode('-',$_SESSION['ws-tags']['ws-user']['date_birth']);
	$uid=$_SESSION['ws-tags']['ws-user']['id'];
    $join = '';
    $order_by = 'num_members DESC';
    if ($suggest) {
    	$join = 'JOIN users_groups ug ON g.id = ug.id_group';
    	$where = '
    		AND g.id_creator!="'.$uid.'" AND ug.id_user != "'.$uid.'"
    	';
    	$order_by = 'RAND()';
    }
	$sql ='SELECT
			g.name AS name,
			g.description AS des,
			g.icon AS icon,
			g.id_privacy AS privacy,
			g.photo AS photo,
			g.id AS id,
            (SELECT cg.name FROM groups_category cg WHERE cg.id=g.id_category) AS cname
            ,(SELECT cg.summary FROM groups_category cg WHERE cg.id=g.id_category) AS csummary
            ,(SELECT cg.icon FROM groups_category cg WHERE cg.id=g.id_category) AS cphoto
			,(SELECT CONCAT(p.name," ",p.last_name) AS nombre_completo FROM users p WHERE g.id_creator=p.id) AS name_creator,
			if (g.id_creator="'.$_SESSION['ws-tags']['ws-user']['id'].'",(SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group AND u.status!=2),(SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group AND u.status!=2 AND u.status!=5)) AS num_members,
            (SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group AND u.is_admin=1) AS num_admin,
			g.id_oriented AS oriented
		FROM groups g
		'.$join.'
		WHERE g.status=1 AND g.id_privacy!=3
		'.$where.'
        AND ((YEAR(NOW())-'.$fecha[0].')>(SELECT q.rule FROM groups_oriented q WHERE q.id=g.id_oriented) 
        	OR ((YEAR(NOW())-'.$fecha[0].')=(SELECT rule FROM groups_oriented WHERE id=g.id_oriented) 
    				AND '.$fecha[1].'>=MONTH(NOW())))
		ORDER BY '.$order_by.'
		LIMIT '.$ini.','.$limit;
	return $GLOBALS['cn']->query($sql);
}

function users($where='',$limit=10,$ini=0,$suggest=false){
	$uid=$_SESSION['ws-tags']['ws-user']['id'];
	if($limit<=0||$limit==null) $limit=50;
	$order_by = 'u.name';
	if ($suggest) {
		$where = 'WHERE u.id!="'.$uid.'" AND
			u.id NOT IN (SELECT f.id_friend FROM users_links f WHERE f.id_user!="'.$uid.'" AND f.id_friend!="'.$uid.'")';
		$order_by = 'RAND()';
	}
	$sql="SELECT
			u.id AS id_friend,
			CONCAT(u.name,' ',u.last_name) AS name_user,
			u.username AS username,
			u.description,
			u.email as email,
			u.country as country,
			u.followers_count,
			u.friends_count,
			u.profile_image_url AS photo_friend,
			md5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code_friend,
			(SELECT id_user AS id_user FROM users_links WHERE id_friend=u.id AND id_user=$uid) AS follower
		FROM users u
		$where
		ORDER BY $order_by
		LIMIT $ini,$limit";
	$users=$GLOBALS['cn']->query($sql);
	return $users;
}
//nuevas funciones para la busqueda procurar eliminar las otras
function peoples($array=''){
	$order='';$limit='LIMIT 0,50';$where='1';
	$uid=$_SESSION['ws-tags']['ws-user']['id'];
	// $from='users u';
	$from='(select *, TIMESTAMPDIFF(YEAR, date_birth, CURDATE()) AS age from users) u';
	$select=' DISTINCT
		u.id AS id,
		CONCAT(u.`name`," ",u.last_name) AS name_user,
		u.username AS username,
		u.description,
		u.email as email,
		u.country as id_country,
		u.profile_image_url AS photo_friend,
		md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code_friend,
		if(u.show_my_birthday<2,u.age,0) AS age,
		c.name AS country,
		u.friends_count,
		u.following_count,
		u.followers_count,
		ul.id_user AS follower
	';
	$from.="
		LEFT JOIN (SELECT id, name FROM countries) c ON c.id=u.country
		LEFT JOIN (SELECT id_friend, id_user,is_friend FROM users_links) ul ON (ul.id_friend=u.id AND ul.id_user='$uid')
	";
	if(isset($array['select'])){		$select.=$array['select']; }
	elseif(isset($array['newSelect'])){	$select=$array['newSelect']; }
	if (isset($array['from'])){			$from=$array['from']; }
	elseif(isset($array['join'])){		$from.=$array['join']; }
	if (isset($array['where'])){		$where=$array['where']; }
	if (isset($array['limit'])){		$limit=$array['limit']; }
	if (isset($array['order'])){		$order=$array['order']; }
	$sql="SELECT $select FROM $from WHERE $where $order $limit";
	if(isset($_GET['debug']) && isset($_GET['return'])) return '<pre>'.$sql.'</pre>';
	elseif(isset($_GET['debug'])) echo '<div><pre>'.$sql.'</pre></div>';
	$users=CON::query($sql);
	return $users;
}
function groupss($array=''){
	$uid=$_SESSION['ws-tags']['ws-user']['id'];
	$order='';$limit='LIMIT 0,10';$where='1';
	$from='groups g';
	$select='
		DATE(g.date) AS fecha,
		g.name AS name,
		g.description AS des,
		g.icon AS icon,
		g.id_privacy AS privacy,
		g.photo AS photo,
		md5(g.id) AS id,
		g.id_creator AS creator,
		(SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group) AS num_members,
		g.id_oriented AS oriented
	';
	if(isset($array['select'])){		$select.=$array['select']; }
	elseif(isset($array['newSelect'])){ $select=$array['newSelect']; }
	if (isset($array['from'])){			$from=$array['from']; }
	elseif(isset($array['join'])){		$from.=$array['join']; }
	if (isset($array['where'])){		$where=$array['where']; }
	if (isset($array['limit'])){		$limit=$array['limit']; }
	if (isset($array['order'])){		$order=$array['order']; }
	$sql="SELECT $select FROM $from WHERE $where $order $limit";
	if(isset($_GET['debug']) && isset($_GET['return'])) return '<pre>'.$sql.'</pre>';
	elseif(isset($_GET['debug'])) echo '<pre>'.$sql.'</pre>';
	$groups=CON::query($sql);
	return $groups;
}
function tags($where='',$limit=5, $suggest=false){
	if($where[0]!='#'){ $where='#'.$where;/*return null;*/ }
	$lim=($limit!='')?"LIMIT 0,".$limit :'';
	$srh = $where;
	$where = 'WHERE CONCAT_WS( " ",t.text,t.text2,t.code_number) LIKE "%'.$where.'%" AND t.status="1"';
	if ($suggest) {
		// $where = '
		// 			WHERE CONCAT(t.text," ",t.text2," ",t.code_number) 
		// 			LIKE CONCAT_WS('%', (SELECT up.preference FROM users_preferences up WHERE up.id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'")) AND t.status="1"';
		$where = '
			WHERE CONCAT(t.text," ",t.text2," ",t.code_number) REGEXP "^#{1}([A-z0-9])+" AND t.status="1"
			ORDER BY RAND() LIMIT '.$limit;
	}
	$sql='(SELECT t.id AS id ,CONCAT(t.text," ",t.text2," ",t.code_number) AS text
		FROM tags AS t
		'.$where.')';
	if (!$suggest) {
		$sql .= 'UNION
		(SELECT c.id_source AS id, c.comment AS text
		FROM comments AS c
		WHERE c.comment LIKE "%'.$srh.'%" AND c.id_type = 4)';
		$sql = 'SELECT id, text 
		FROM('.$sql.') result
		GROUP BY id
		ORDER BY id DESC
		'.$lim;
	}
	if (isset($_GET['debug']) && isset($_GET['return'])) return '<pre>'.$sql.'</pre>';
	elseif (isset($_GET['debug'])) echo '<div><pre>'.$sql.'</pre></div>';
	$hashTags=$GLOBALS['cn']->query($sql);
	return $hashTags;
}
function product($array){
	$select="
		p.id,
		p.id_user,
		(SELECT CONCAT(a.name,' ',a.last_name) FROM users a WHERE a.id=p.id_user) AS seller,
		(SELECT type FROM users a WHERE a.id=p.id_user) AS type_user,
		p.id_status AS status,
		(SELECT name FROM store_category WHERE id=p.id_category) AS category,
		(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
		p.name AS name,
		p.description AS description,
		p.sale_points AS cost,
		p.id_category,
		p.photo AS photo,
		p.stock AS stock,
		p.place AS place,
		p.join_date AS join_date
	";
	$from='	 store_products p';
	$where="1";
	$order=" ORDER BY p.update_date DESC,p.id DESC ";
	$limit=" LIMIT ".$_GET['limitIni'].",9";
	if(isset($array['select'])){		$select.=$array['select']; }
	elseif(isset($array['newSelect'])){	$select=$array['newSelect']; }
	if(isset($array['from'])){			$from=$array['from']; }
	elseif(isset($array['join'])){		$from.=$array['join']; }
	if(isset($array['where'])){			$where=$array['where']; }
	if(isset($array['limit'])){			$limit=$array['limit']; }
	if(isset($array['order'])){			$order=$array['order']; }
	$sql="SELECT $select FROM $from WHERE $where $order $limit";
	if(isset($_GET['debug']) && isset($_GET['return'])) return '<pre>'.$sql.'</pre>';
	elseif (isset($_GET['debug'])) echo '<pre>'.$sql.'</pre>';
	$result=CON::query($sql);
	return $result;
}
//hasta aqui las funciones para la busqueda
function productHash($where='',$limit=5){
	if($where==''){
		return null;
	}
	if(substr($where,0,1)!='#'){
		$where='#'.$where;//return null;
	}
	$lim=($limit!='')?"LIMIT 0,".$limit :'';

	$pHash=$GLOBALS['cn']->query('
		SELECT
			t.id,
			t.description as description
		FROM store_products t
		WHERE t.description LIKE "%'.$where.'%" AND t.id_status="1"
		ORDER BY t.id DESC
		'.$lim
	);
	return $pHash;
}

function productS($where='',$limit=3){
	if($where==''){
		return null;
	}
	
	$lim=($limit!='')?"LIMIT 0,".$limit :'';

	return $GLOBALS['cn']->query('
		SELECT
			t.id,
			t.name AS name,
			(SELECT name FROM store_category WHERE id=t.id_category) AS category,
			t.photo AS photo
		FROM store_products t
		WHERE  CONCAT_WS( " ",t.name,t.description) LIKE "%'.$where.'%" AND t.id_status="1" 
		ORDER BY t.update_date DESC,t.id DESC
		'.$lim
	);
}

function vectorPhash($sch='',$cant=10){
	$cond = ($sch=='')?'WHERE id_status=1 AND stock>0 ORDER BY RAND()':'WHERE id_status=1  AND name LIKE "%'.$sch.'%"';
	$hashproduct = $GLOBALS['cn']->query("
		SELECT description
		FROM store_products
		$cond
	");
	$vec = array();
	while($hash = mysql_fetch_assoc($hashproduct)){
		$textHash = get_hashtags($hash['description']);

		foreach ($textHash as &$value){
			$vec[] = rtrim($value,'\,\.');
		}
	}
	$textHash2 = array_unique($vec);
	$i=0;
	foreach ($textHash2 as &$value1){
		if($i<$cant){
				$vecH[] = $value1;
			}
		$i++;
	}
	return $vecH;
}

function followers($id='',$not_ids='',$limit='0,2000'){
	$user=($id=='')?md5($_SESSION['ws-tags']['ws-user']['id']):md5($id);
	$not_ids=($not_ids!='')?' AND l.id_user NOT IN ('.$not_ids.')':'';
	$followers=$GLOBALS['cn']->query('
		SELECT
			l.id_user AS id_user,
			l.id_friend as id_friend,
			CONCAT(u.`name`," ",u.last_name) AS name_user,
			u.profile_image_url AS photo_friend,
			u.email,
			u.country,
			u.followers_count,
			u.friends_count,
			md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code_friend
		FROM users u JOIN users_links l ON u.id=l.id_user
		WHERE md5(l.id_friend)="'.$user.'" '.$not_ids.' AND l.is_friend = 0
		ORDER BY CONCAT(u.`name`," ",u.last_name)
		LIMIT '.$limit.';'
		);
	return $followers;
}

function following($id='',$limit='0,2000'){
	$user=($id=='')?md5($_SESSION['ws-tags']['ws-user']['id']):md5($id);
	$following=$GLOBALS['cn']->query('
		SELECT
			l.id_user,
			l.id_friend,
			CONCAT(u.`name`," ",u.last_name) AS name_user,
			u.profile_image_url AS photo_friend,
			u.email,
			u.country,
			u.followers_count,
			u.friends_count,
			md5(CONCAT(u.id,"_",u.email,"_",u.id)) AS code_friend
		FROM users u JOIN users_links l ON u.id=l.id_friend
		WHERE md5(l.id_user)="'.$user.'" AND l.is_friend = 0
		ORDER BY name_user ASC
		LIMIT '.$limit.';'
		);
	return $following;
}

function factorPublicity($type,$monto){
	$costos=$GLOBALS['cn']->query('SELECT MAX(cost) AS cost FROM cost_publicity WHERE id_typepublicity="'.$type.'"');
	$costo=mysql_fetch_assoc($costos);

	return intval(($costo[cost]!='')?($monto/$costo['cost']):0);
}

function factorBuyPoints($monto){
	$costos=$GLOBALS['cn']->query('
		SELECT MAX(cost) AS cost
		FROM cost_points
		WHERE id_typecurrency="1"
	');
	$costo=mysql_fetch_assoc($costos);
	return intval(($costo[cost]!='')?($monto/$costo['cost']):0);
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
function CreateThumb($original,$img_nueva,$tamanio,$x,$y,$ancho,$alto){
	include(RELPATH.'class/wideImage/WideImage.php');
	$img=WideImage::load($original);
	$im2=$img->crop($x,$y,$ancho,$alto);
	$im2=$im2->resize($tamanio,$tamanio);
	$im2->saveToFile($img_nueva);
	$im2->destroy(); $img->destroy();
}

// function CreateThumb($original,$img_nueva,$tamanio,$x,$y,$ancho,$alto){
// 	$type=Array(1=>'gif',2=>'jpg',3=>'png');
// 	//obtener atributos de imagen original
// 	list($imgWidth,$imgHeight,$tipo,$imgAttr)=getimagesize($original);
// 	$type=$type[$tipo];
// 	switch($type){
// 		case 'jpg':
// 		case 'jpeg':$img=imagecreatefromjpeg($original);break;
// 		case 'gif':$img=imagecreatefromgif($original);break;
// 		case 'png':$img=imagecreatefrompng($original);break;
// 	}
// 	//crea imagen nueva redimencionada
// 	$thumb=imagecreatetruecolor ($tamanio,$tamanio);
// 	if($type=='gif'||$type=='png'){
// 		imagepalettecopy($thumb,$img);
// 		$transparentcolor=imagecolortransparent($img);
// 		if($transparentcolor!=-1)$transparentcolor=imagecolorsforindex($img,$transparentcolor);//devuelve un array con las componentes de lso colores RGB + alpha
// 		$idColorTransparente=imagecolorallocatealpha($thumb,$transparentcolor['red'],$transparentcolor['green'],$transparentcolor['blue'],$transparentcolor['alpha']);//Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3
// 		imagefill($thumb,0,0,$idColorTransparente);//rellena de color desde una cordenada, en este caso todo rellenado del color que se definira como transparente
// 		imagecolortransparent($thumb,$idColorTransparente);
// 	}
// 	//redimensionar imagen original copiandola en la imagen nueva
// 	imagecopyresampled($thumb,$img,0,0,$x,$y,$tamanio,$tamanio,$ancho,$alto);
	
// 	//guardar la imagen redimensionada donde indica $img_nueva
// 	switch($type){
// 		case 'jpg':
// 		case 'jpeg':imagejpeg($thumb,$img_nueva);break;
// 		case 'gif':imagegif($thumb,$img_nueva);break;
// 		case 'png':imagepng($thumb,$img_nueva);break;
// 	}
// 	imagedestroy($img);
// 	imagedestroy($thumb);
// }

function sendMail($body,$from,$fromName,$subject,$address,$path='',$ssl=false){
	global $config;
	if(LOCAL) return;
	$mail=new phpmailer();
	$mail->PluginDir=$path.'class/';
	$mail->Mailer	='smtp';

	$from = 'no-reply@mailtagbum.com';

	if(isset($config->email)){
		foreach(get_object_vars($config->email) as $key => $value) $mail->$key=$value;
		$mail->SMTPDebug = false;
		$mail->do_debug = 0;
		// if($ssl)
			$mail->SMTPSecure = "ssl";
	}elseif(!$config->local){
		$mail->Host		= 'mailtagbum.com';
		$mail->SMTPAuth	= true;
		$mail->Port		= "465";
		$mail->Username	= "no-reply@mailtagbum.com";
		$mail->Password	= "Nepali13@!";
		$mail->Timeout	=10;
		$mail->SMTPDebug = false;
		$mail->do_debug = 0;
		// if($ssl)
			$mail->SMTPSecure = "ssl";
	}else{
		$mail->Host		='localhost';
		$mail->SMTPAuth	=false;
		$mail->Timeout	=1;
	}

	$mail->IsHTML(true);
	$mail->AddAddress($address);

	$mail->From		=$from;
	$mail->FromName	=$fromName;
	$mail->Subject	=$subject.($config->local?' (ref:'.$_SERVER['HTTP_REFERER'].')':'');
	$mail->Body		=$body;

	return $mail->Send();
}

function codeTag($code){
	return substr ('000000000'.str_replace(' ','',$code),-9);
}

/* Cantidad de seguidores de un usuario. Si el usuario tiene
 * mas de 10^6 de seguidores se toma como error y la funcion
 * retorna cero
 */
function mskPoints($points){
	$len=strlen($points);
	if($len>17)	return '+100 '.CONST_UNITQUATRILLON;
	if($len>15)	return round(($points/1000000000000000),1).' '.CONST_UNITQUATRILLON;
	if($len>12)	return round(($points/1000000000000),1).' '.CONST_UNITTRILLON;
	if($len>9)	return round(($points/1000000000),1).' '.CONST_UNITBILLON;
	if($len>6)	return round(($points/1000000),1).' '.CONST_UNITMILLON;
	if($len>3)	return round(($points/1000),2).' '.CONST_UNITMIL;
	return $points;
}

function generaGet(){
	reset($_GET);
	$REQUEST=$_GET;
	return http_build_query($REQUEST);
}

//function generaGet(){
//	reset($_REQUEST);
//	$REQUEST=$_REQUEST;
//	return '?'.http_build_query($REQUEST);
//}

function priceList($type_publicity='4',$status='1'){
	return $GLOBALS['cn']->query("
		SELECT
			(select b.name from currency b where b.id=a.id_typecurrency) AS moneda,
			(select c.name from type_publicity c where c.id=a.id_typepublicity) AS tipo_publi,
			CONCAT(a.click_from,' - ',a.click_to) AS rango,
			a.cost AS costo
		FROM cost_publicity a
		WHERE status='".$status."' AND a.id_typepublicity='".$type_publicity."'
		ORDER BY a.click_from ASC
	");
}

function priceListPoints($status='1'){
	return $GLOBALS['cn']->query("
		SELECT
			(select b.name from currency b where b.id=a.id_typecurrency) AS moneda,
			CONCAT(a.amount_from,' - ',a.amount_to) AS rango,
			a.cost AS costo
		FROM cost_points a
		WHERE status='".$status."'
		ORDER BY a.amount_from ASC
	");
}

function findThumb($photoUser,$userCode){

	if($photoUser){
		if(file_exists('/img/users/'.$userCode.'/'.generateThumbPath($photoUser))){
			return FILESERVER.'img/users/'.$userCode.'/'.generateThumbPath($photoUser);
		}else{
			return FILESERVER.'img/users/'.$userCode.'/'.$photoUser;
		}
	}else{
		return 'img/users/default.png';
	}
}

function getTagQuery($extra=''){ //t=tag,p=product,u=user(owner)
	return '
		SELECT
			t.id,
			t.id			as idTag,
			t.background	as fondoTag,
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
function getTagData($tid=''){
	$noTag=array('idTag'=>$tid,'code_number'=>'notag','color_code2'=>'#333','photoOwner'=>'img/users/default.png','fondoTag'=>$tag[fondoTag]);
	if($tid=='') return $noTag;
	$tid=intToMd5($tid);
	$where=safe_sql('substring(md5(t.id),-16)=?',array(substr($tid,-16)));
	if(strlen($tid)==15) $where=safe_sql('substring(md5(t.id),-15)=?',array(substr($tid,-15)));
	$tag=CON::getRow(getTagQuery().' WHERE '.$where);
	if($tag['id']=='') return $noTag;
	return $tag;
}

function showSharedTag($tid){
	$cad='img/logo100.png';
	$sql=$GLOBALS['cn']->query('SELECT background FROM tags WHERE substring(md5(id),-15)="'.substr($tid,-15).'"');
	if(mysql_num_rows($sql)<1) return $cad;
	$data=mysql_fetch_assoc($sql);
	$fondoTag=$data['background'];
	return 'includes/imagen.php?ancho=100&tipo=3&img='.(strpos(' '.$fondoTag,'default')?'../':FILESERVER).'img/templates/'.$fondoTag;
}

function maskBirthday($birthday,$type=1,$format=1){
	$date=explode('-',$birthday);
	switch($type){
		case 1:echo (($format==1)?$birthday:formatoFecha($birthday));break;//full
		case 2:echo (($format==1)?$date[1].'-'.$date[2]:$date[2].'/'.$date[1]);break;//day-month
		case 3:echo INDEX_LBL_PRIVATE;break;//nothing
	}
}

function maskBirthdayApp($birthday,$type=1,$format=1){
	if($birthday!='0000-00-00'&&$birthday!=''){
		$date=explode('-',$birthday);
		switch ($type){
			case 1:return (($format==1)?$birthday:formatoFecha($birthday));break;//full
			case 2:return (($format==1)?$date[1].'-'.$date[2]:$date[2].'/'.$date[1]);break;//day-month
			case 3:return INDEX_LBL_PRIVATE;break;//nothing
		}
	}else{
		return 'none';
	}
}

function isProductTag($idTag){
	$query=$GLOBALS['cn']->query('SELECT id_product FROM tags WHERE id_product!="0" AND id="'.$idTag.'"');
	if(mysql_num_rows($query)>0)
		$query=mysql_fetch_assoc($query);
	else
		return false;
	$idProduct=$query['id_product'];
	$product=$GLOBALS['cn']->query('SELECT id,name,picture,url FROM products_user WHERE id="'.$idProduct.'"');
	return mysql_fetch_assoc($product);
}

// function adPreference($preference){
// 	$cad=mysql_real_escape_string($preference);
// 	$exist=$GLOBALS['cn']->query('
// 		SELECT id
// 		FROM preference_details
// 		WHERE detail LIKE "'.$cad.'" AND id_preference IN (2,3)
// 	');
// 	if(mysql_num_rows($exist)==0){
// 		$GLOBALS['cn']->query('
// 			INSERT INTO preference_details SET
// 				id_preference="2",
// 				detail="'.$cad.'"
// 		');
// 		$GLOBALS['cn']->query('
// 			INSERT INTO preference_details SET
// 				id_preference="3",
// 				detail="'.$cad.'"
// 		');
// 	}
// }

function isYoutubeVideo($value){
	$isValid=false;
	//validate the url,see:http://snipplr.com/view/50618/
	if (isValidURL($value)){
		//code adapted from Moridin:http://snipplr.com/view/19232/
		$idLength=11;
		$idOffset=3;
		$idStarts=strpos($value,'?v=');
		if ($idStarts===FALSE){
			$idStarts=strpos($value,'&v=');
		}
		if ($idStarts===FALSE){
			$idStarts=strpos($value,'/v/');
		}
		if ($idStarts===FALSE){
			$idStarts=strpos($value,'#!v=');
			$idOffset=4;
		}
		if ($idStarts===FALSE){
			$idStarts=strpos($value,'youtu.be/');
			$idOffset=9;
		}
		if ($idStarts!==FALSE){
			//there is a videoID present,now validate it
			//echo $idStarts+$idOffset;
			$isValid=substr($value,$idStarts+$idOffset,$idLength);
			/*$videoID=substr($value,$idStarts+$idOffset,$idLength);
			$http=new HTTP('http://gdata.youtube.com');
			$result=$http->doRequest('/feeds/api/videos/'.$videoID,'GET');
						//returns Array('headers'=>Array(),'body'=>String);
			$code=$result['headers']['http_code'];
						//did the request return a http code of 2xx?
			if (substr($code,0,1)==2){
				$isValid=$videoID;
			}*/
		}
	}
	return $isValid;
}

function isVimeoVideo($vimeo){
	//$isValid=0;
	if (isValidURL($vimeo)){
		if(preg_match('/https?:\/\/(www\.)?vimeo\.com(\/|\/clip:)(\d+)(.*?)/',$vimeo)){
			$isValid=true;
		}else{
			$isValid=false;
		}
	}
	return $isValid;
}

function regex($name){
	switch($name){
		case 'youtubelong'	:return '/\bhttps?:\\/\\/((m\\.|www\\.)?(youtube\\.com\\/)(embed\\/|watch\\?(.*&)*(v=))(.{11}).*)\b/i';
		case 'youtube'		:return '/\bhttps?:\\/\\/((m\\.|www\\.)?(youtube\\.com\\/)(embed\\/|watch\\?(.*&)*(v=))(.{11})|(youtu\\.be\\/(.{11}))).*\b/i';//code=7&9
		case 'vimeo'		:return '/\bhttps?:\\/\\/(((vimeo\\.com\\/)))((.{8,}))\b/i';//code=5
		case 'video'		:return '/\bhttps?:\\/\\/(vimeo\\.com\\/.{8,}|youtu\\.be\\/.{11}.*|(m\\.|www\\.)?youtube\\.com\\/(.+)(v=.{11}).*)?\b/i';//video=1
		case 'url'			:return '/\b(https?:\/\/\S+|www\.\S+)\b/';
		case 'validurl'		:return '/\b(https?:\\/\\/(www\\.)?([a-z][-a-z0-9]+\\.)?([a-z][-a-z0-9]*)\\.([a-zA-Z]{2}|aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel)(\.[a-z]{2})?(\/.*)?)\b/i';
		default				:return '/.*/i';
	}
}

function isVideo($type,&$value){
	global $config;
	if($type=='youtube')
		return preg_match('/youtu\\.be|youtube\\.com/i',$value);
	elseif($type=='vimeo')
		return preg_match('/vimeo\\.com/i',$value);
	elseif($type=='local' && $value!='' && $value!='http://'){
		return fileExistsRemote($config->video_server.'videos/'.$value);
	}
}

function isValidURL($value){
	return preg_match('/^((https?:\/\/)?(www\.)?)?([a-z][-a-z0-9]+\.)?([a-z][-a-z0-9]*)(\.[a-zA-Z]{2}|aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel)(\.[a-z]{2})?(\/.*)?/i',$value);
}

function isValidEmail($email){
	return preg_match('/^[a-zA-Z0-9]+([][\.a-zA-Z0-9_-])*@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+/',$email);
}
/**
* returns the preferences of a specific user or user session
* retorna las preferencias de un usuario especifico o del usuario en sesión
*
* @param string|int $usr user id (id del usuario)
* @param int|boolean $tipe type of preference, false=all (tipo de preferencia, false=todas)
* @param int $return type of data of return, 1=array 2=string (tipo de datos de retorno, 1=array 2=string)
* @return array
*/
function users_preferences($usr='',$tipe=false,$return=1){ 
	$usr=($usr!='')?$usr:$_SESSION['ws-tags']['ws-user']['id'];
	$where=$tipe?safe_sql(' AND id_preference=?',array($tipe)):'';
	$preferences=CON::query("SELECT * FROM users_preferences WHERE md5(id_user)=?".$where,array(intToMd5($usr)));
	$res=array();
	while ($row=CON::fetchAssoc($preferences)) {
		if (trim($row['preference'])=="") continue;
		$pre=CON::getArray("SELECT id, detail FROM preference_details WHERE id IN ('".str_replace(",","','",$row['preference'])."')");
		if ($return==1) $datos=array();
		else $datos='';
		$dato=explode(',',$row['preference']);
		foreach ($dato as $key => $value) { $band=false;
			foreach ($pre as $subpre) {
				if ($subpre['id']==$value){
					if ($return==1) $datos[]=(object)array('id'=>$subpre['detail'],'text'=>$subpre['detail']);
					else $datos.=($datos!=''?',':'').$subpre['detail'];
					$band=true;
				}
			}
			if (!$band) 
				if ($return==1) $datos[]=(object)array('id'=>$value,'text'=>$value);
				else $datos.=($datos!=''?',':'').$subpre['detail'];
		}
		$res[$row['id_preference']]=$datos;
	}
	return $res;
}

/**
* get publicity to a user, depending on your preference or randomly
* conseguir publicidad para un usuario, dependiendo de su preferencia o de forma aleatoria
*
* @param string|int $usr user id (id del usuario)
* @param int|boolean $tipe type of publicity, false=all (tipo de publicidad, false=todas)
* @param boolean $random query type (null = no random, false = random if preferences equal 0, true = random), Tipo de consulta (null = no al azar, false = aleatoria si las preferencias son iguales a 0, true = aleatorio)
* @return array
*/
function users_publicity($limit=5,$usr='',$tipe=false,$random=false,$noid=false){ 
	$usr=($usr!='')?$usr:$_SESSION['ws-tags']['ws-user']['id'];
	$where=$tipe?safe_sql(' AND id_type_publicity=?',array($tipe)):'';
	if (!$random){
		$prefe=users_preferences($usr);
		if (count($prefe)==0) $random=true;
		else{
			$like=' AND (';$or='';
			foreach ($prefe as $typePre)
				foreach ($typePre as $row) {
					$like.=$or.safe_sql('title LIKE "%??%"',array($row->text));
					if (!$or) $or=' OR ';
				}
			$like.=')';
		}
	}
	if ($random){ $like='';
		if ($noid){
			if (!is_array($noid)) $like=" AND id NOT IN ($noid)";
			elseif(count($noid)>0){ 
				$like="AND id NOT IN ("; $c='';
				foreach ($noid as $key) {
					$like.=$c.$key;
					if (!$c) $c=",";
				}
				$like.=")";
			}
		}
		$like.=' ORDER BY RAND()';	
	} 
	if (!isset($like) || $like=='') return array();
	$publicity=CON::query("SELECT  md5(id) AS id,
								   id AS id_valida,
								   link,
								   picture,
								   picture as picOri,
								   title,
								   id_cost,
								   message 
							FROM users_publicity 
							WHERE status = '1' 
							AND click_max > click_current $where $like LIMIT 0,$limit");
	// echo CON::lastSql()."<br><br><br>";
	$res=array();$num=CON::numRows($publicity);$ids=array();
	if ($num==0 && $random===false) $res2=users_publicity(5,$usr,$tipe,true);	
	else while ($row=CON::fetchAssoc($publicity)) {
		if ($row['id_cost']!='5') {
			$row['picture']=FILESERVER.getPublicityPicture('img/publicity/'.$row['picture'],'img/publicity/publicity_nofile.png');
			// $row['vari'] = 'no id_cost '.$row['picture'];
		} else {
			$row['picture']=$GLOBALS['config']->main_server.getPublicityPicture('img/publicity/'.$row['picture'],'img/publicity/publicity_nofile.png',$row['id_cost']);
			// $row['vari'] = 'id_cost '.$row['picture'];
		}

		$res[]=$row;$ids[]=$row['id_valida'];
	}
	if ($num<$limit && $random===false) $res2=users_publicity($limit-$num,$usr,$tipe,true,$ids);	
	if (isset($res2)) $res=array_merge($res,$res2);
	return $res;
}

function incHitsTag($id,$numHits=1,$table='tags_hits'){
	$hits=safe_sql('hits=hits+(?)',array($numHits));
	if($table=='tags_hits'){
		$id=CON::getVal('SELECT id FROM tags WHERE md5(id)=? AND status!=2',array(intToMd5($id)));
		if(!CON::exist($table,'id_tag=? AND date=CAST(NOW() AS DATE)',array($id))){
			CON::insert($table,'id_tag=?,date=NOW(),hits=?',array($id,$numHits));
		}else{
			CON::update($table,$hits,'md5(id_tag)=?',array(intToMd5($id)));
		}
	}else{
		CON::update($table,$hits,'md5(id)=?',array(intToMd5($id)));
	}
}
function incPoints($type,$source,$id_owner,$id_user=''){
	#buscamos los puntos
	$p=CON::getRowObject('
		SELECT points_owner AS owner,points_user AS user
		FROM action_points
		WHERE status=1 AND id_type=?
	',array($type));
	#si no hay puntos cancelamos el proceso
	if($p->owner==0&&$p->user==0) return false;
	#si hay usuario y ya realizo esta accion no se le daran puntos
	if($id_user!=''&&CON::getVal('SELECT id FROM log_actions WHERE id_type=? AND id_source=? AND id_user=?',array($type,$source,$id_user)))
		return false;
	if($p->owner!=0)
		CON::update('users',"accumulated_points=accumulated_points+($p->owner),current_points=current_points+($p->owner)",'id=?',array($id_owner));
	if($p->user!=0&&$id_user!='')
		CON::update('users',"accumulated_points=accumulated_points+($p->user),current_points=current_points+($p->user)",'id=?',array($id_user));
	$usr=$id_user!=''?$id_user:$id_owner;
	setLogAction($type,$source,$usr);
	return true;
}
function setLogAction($type,$source,$id_user=''){
	return !!CON::insert('log_actions','id_type=?,id_source=?,id_user=?',array($type,$source,$id_user!=''?$id_user:'0'));
}

function restaFechaUsers($dFecIni,$dFecFin,$usr=''){
	if($usr!='') $usr=$_SESSION['ws-tags']['ws-user']['id'];
	$query=$GLOBALS['cn']->query('
		SELECT DATEDIFF(NOW(),u.created_at) AS num
		FROM users u
		WHERE u.id="'.$usr.'"
	');
	$array=mysql_fetch_assoc($query);
	return $array['num'];
}

function blockUser($created_at){
	list($anio,$mes,$dia)=explode('-',$created_at);
	if(restaFechaUsers($anio.'-'.$mes.'-'.$dia,date('Y-m-d'))>=getNumDaysDemo()&&$_SESSION['ws-tags']['ws-user']['status']=='3'){
		return true;
	}
	return false;
}

function fieldsLogin(){ //campos que se listaran al momento de hacer login en el sistema
	return ' *,DATE(created_at) AS created_at ';
}

function cookie($name,$value=NULL,$expire=NULL,$path='/',$domain=NULL,$secure=false,$httponly=false){
	if($expire===NULL) $expire=30;
	$expire=time()+60*60*24*$expire;
	if($name!==NULL) setcookie($name,$value,($value==''?time()-3600:$expire),$path,$domain,$secure,$httponly);
	return $_COOKIE[$name];
}

function cookies($array,$expire=null,$path='/',$domain=null,$secure=false,$httponly=false){
	if($expire===NULL) $expire=30;
	$expire=time()+60*60*24*$expire;
	if(!is_array($array))
		return array();
	else foreach($array as $name=>$value){
		setcookie($name,$value,($value==''?time()-3600:$expire),$path,$domain,$secure,$httponly);
		$cookies[$name]=$_COOKIE[$name];
	}
	return $cookies;
}

function keepLogin($device=''){
	global $debug;
	$res=array( 'logged' => false );
	$keep='';
	$log=intToMd5(isset($_POST['_login_'])?$_POST['_login_']:$_COOKIE['_login_']);
	if($_SESSION['ws-tags']['ws-user']['id']!=''){
		$res['logged']=true;
		if($device=='') return $res;
		#crear el keep login
		$log=md5($device);
		$keep=CON::getVal('SELECT md5(concat(id,agent,date)) FROM users_device_login WHERE id=?',array($device));
		$res['kl']=array(
			'_login_'=>$log,
			md5('keep'.$log)=>$keep
		);
		if(!$keep) return $res;
		cookie('_login_',$log);
		cookie(md5('keep'.$log),$keep);
		return $res;
	}
	$res['log']=$log;
	if($keep==''){
		if(preg_match('/tagbum/i',$_SERVER['HTTP_USER_AGENT'])&&isset($_POST[md5('keep'.$log)]))
			$keep=$_POST[md5('keep'.$log)];
		elseif(isset($_COOKIE[md5('keep'.$log)]))
			$keep=$_COOKIE[md5('keep'.$log)];
	}
	if($keep!=''){
		$res['keep']=$keep;
		$query=CON::getRow('SELECT * FROM users_device_login WHERE md5(concat(id,agent,date))=? AND md5(id)=?',array(cls_string($keep),cls_string($log)));
		if($debug) $res['_sql_'][]=CON::lastSql();
		if($query['id']!=''&&substr($_SERVER['HTTP_USER_AGENT'],15,25)==substr($query['agent'],15,25)){
			$usr=CON::getRow('SELECT * FROM users WHERE id=?',array($query['id_user']));
			if($debug) $res['_sql_'][]=CON::lastSql();
			if($usr['status']=='1'||$usr['status']=='3'){
				$res['logged']=true;
				createSession($usr);
				cookie('_login_',$log);
				cookie(md5('keep'.$log),$keep);
			}
		}
	}
	return $res;
}

function ifIsLogged(){
	if($_SESSION['ws-tags']['ws-user']['id']!='')
		cookie('__logged__',md5($_SESSION['ws-tags']['ws-user']['time']));
	else
		cookie('__logged__',NULL);
}

function logout(){
	if(!isset($_GET['nocookies'])){
		cookie(md5('keep'.$_COOKIE['_login_']),NULL);
		cookie('_login_',NULL);
		ifIsLogged();
	}
	unset(
		$_SESSION['ws-tags']['ws-user'],
		$_SESSION['smt-app'],
		$_SESSION['car'],
		$_SESSION['store'],
		$_SESSION['havePaypalPayment']
	);
}

function createSession($array,$clear=true){//creacion de las variables de session del sistema
	unset($array['password'],$array['password_user'],$array['password_system']);
	if($clear) $usr=$array;
	else{
		$usr=$_SESSION['ws-tags']['ws-user'];
		foreach ($array as $key=>$value){
			$usr[$key]=$value;
		}
	}
	$usr['fullversion']=$_SESSION['ws-tags']['ws-user']['fullversion'];
	$usr['showPhotoGallery']=false;
	if($usr['profile_image_url'] && $usr['photo'] =='') $usr['photo']=$usr['profile_image_url'];
	if($usr['time']==''){//si esta vacio se captura el tiempo, para control de cache en el cliente
		$usr['time']=time();
	}
	if($usr['id']){
		$usr['smt']=$usr['time'].','.md5($usr['id'].md5($usr['time']));
		$usr['full_name']=$usr['name'].' '.$usr['last_name'];
		$usr['code']=md5($usr['id'].'_'.$usr['email'].'_'.$usr['id']);
		$usr['pic']='img/users/'.$usr['code'].'/'.$usr['photo'];
	}
	$_SESSION['ws-tags']['ws-user']=$usr;
	//this variable indicates that photo gallery must be shown on page load
	if($_POST['lng']!=''){
		$_SESSION['ws-tags']['language']=$_POST['lng'];
	}elseif($usr['language']!=''){
		$_SESSION['ws-tags']['language']=$usr['language'];
	}elseif($_POST['lang']!=''){
		$_SESSION['ws-tags']['language']=$_POST['lang'];
	}
	createSessionStore();
	ifIsLogged();
}
function createSessionCar($id_user='',$code='',$count='',$idproduct='',$idOrder='',$comePay=''){
	if($id_user=='') $id_user=$_SESSION['ws-tags']['ws-user']['id'];
	if($code=='') $code=$_SESSION['ws-tags']['ws-user']['code'];
	$carrito=array();
	//en mysql, si utiliza el nombre del campo se puede omitir el AS, y el INNER fue deprecado (INNER JOIN = JOIN)
	if ($count!=''){
		$select='SUM(od.cant) AS num';
	}else{
		$select='
			p.id,
			p.id_user AS seller,
			p.id_category,
			p.id_sub_category,
			(SELECT name FROM store_category WHERE id=p.id_category) AS category,
			(SELECT name FROM store_sub_category WHERE id=p.id_sub_category) AS subCategory,
			p.name,
			od.price AS sale_points,
			p.photo,
			p.place,
			p.stock,
			p.sale_points AS price,
			p.description,
			u.email AS email_seller,
			od.formPayment,
			p.formPayment AS fp,
			od.cant,
			u.paypal,
			o.id AS idOrder
		';
	}
	$sql='
		SELECT
			'.$select.'
		FROM store_orders o
		JOIN store_orders_detail od ON od.id_order=o.id
		JOIN store_products p ON p.id=od.id_product
		JOIN users u ON p.id_user=u.id
		WHERE o.id_user="'.$id_user.'" '.($idOrder!=''?'AND md5(o.id)="'.$idOrder.'" '.($comePay==''?'AND (o.id_status=11 AND od.id_status=11)':''):'AND (o.id_status=1 AND od.id_status=11)').' '.($idproduct!=''?' AND md5(p.id)="'.$idproduct.'"':'').';
	';
	$result=$GLOBALS['cn']->query($sql);
	if ($count==''){
		if (mysql_num_rows($result)>0){
			while ($product=mysql_fetch_assoc($result)){
				if (!$carrito['order']['order']){
					$carrito['order']['order']=$product['idOrder'];
					$carrito['order']['comprador']=$id_user;
					$carrito['order']['comprador_code']=$code;
				}
				unset($product['idOrder']);//borramos del arreglo lo que no queremos guardar
				//se trabajan las variables sobre el mismo arreglo, luego se guarda todo el arreglo
				$product['category']=utf8_encode(formatoCadena(constant($product['category'])));
				$product['subCategory']=utf8_encode(formatoCadena(constant($product['subCategory'])));
				$product['name']=utf8_encode(formatoCadena($product['name']));
				$carrito[$product['id']]=$product;//guardamos el producto en el carrito
				//Para saber si tiene que pagar productos en paypal
				// if($product['formPayment']==1) $_SESSION['havePaypalPayment']=true;
			}
		}
		$_SESSION['car']=$carrito;
		return $carrito;
	}else{
		$product=mysql_fetch_array($result);
		return $product['num'];
	}
}
function createSessionStore(){
	$id_user=$_SESSION['ws-tags']['ws-user']['id'];
	$sql="
		SELECT SUM(od.cant) AS cant, o.id_status AS status,o.id
		FROM store_orders o
		JOIN store_orders_detail od ON od.id_order=o.id
		WHERE o.id_user='".$id_user."'
			AND ((o.id_status='11' AND od.id_status='11')
			OR (o.id_status='1' AND od.id_status='11')
			OR (o.id_status='12' AND od.id_status='12')
			OR (o.id_status='5' AND od.id_status='5'))
		GROUP BY o.id_status
	";
	$result=$GLOBALS['cn']->query($sql);
	while($row=mysql_fetch_assoc($result)){
		switch ($row['status']){
			case '1':$store['car']=$row['cant'];break;
			case '11':case '12':$store['order']=1;break;
			case '5':$store['wish']=$row['id'];break;
		}
	}
	$wid=CON::getVal('SELECT users.id FROM users JOIN store_raffle_users ON users.email=store_raffle_users.email WHERE store_raffle_users.email = "'.$_SESSION['ws-tags']['ws-user']['email'].'";');
	if($_SESSION['ws-tags']['ws-user']['type']==1 || $wid>0){
		$sql="
			SELECT o.id
			FROM store_orders o
			JOIN store_orders_detail od ON od.id_order=o.id
			WHERE od.id_user='".$id_user."'
				AND od.id_status!='1' AND od.id_status!='2' AND od.id_status!='5'
			LIMIT 1
		";
		$result=$GLOBALS['cn']->query($sql);
		$row=mysql_fetch_assoc($result);
		if($row['id']!='') $store['sales']='1';
	}
	if(isset($store)){
		$_SESSION['store']=$store;
	}
}
function userExternalReference($keyusr){ //confirmar suscripcion::login
	$query=$GLOBALS['cn']->query('
		SELECT '.fieldsLogin().'
		FROM users
		WHERE md5(md5(concat(id,"_",email,"_",id)))="'.$keyusr.'"
	');
	$array=mysql_fetch_assoc($query);
	if(mysql_num_rows($query)>0){
		crearSession($array);
		//update - colocamos el status del usuario en 3 con la finalidad de cobrar a los 14 dias su suscripcion al sistema
		$status=(($array['type']=='1')?3:1);
		$GLOBALS['cn']->query('UPDATE users SET status="'.$status.'" WHERE id="'.$array['id'].'"');
		$_SESSION['ws-tags']['ws-user']['status']=$status;
		return true;
	}elseif(mysql_num_rows($query)==0){ //validacion de login
		return false;
	}
}

//funciones para obtener datos en especifico

function getNumDaysDemo(){ //numero de dias para la prueba del sistema
	return campo('config_system','id','1','days_block');
}

function getCostAccountIndividual(){ //Costo de suscripcion por personas
	return campo('config_system','id','1','cost_account_individual');
}

function getCostAccountCompany(){ //Costo de suscripcion por empresas
	return campo('config_system','id','1','cost_account_company');
}

function getCostPersonalTagIndividual(){ //Costo para obtener mas personals tags por personas
	return campo('config_system','id','1','cost_individual_personal_tag');
}

function getCostPersonalTagCompany(){ /*Costo para obtener mas personals tags por empresas*/
	return campo('config_system','id','1','cost_company_personal_tag');
}

function getCostPersonalBusinessCard(){ /*this is the price of editing a personal business card*/
	return campo('config_system','id','1','cost_personal_bc');
}

function getCostCompanyBusinessCard(){ /*this is the price of editing a company business *card*/
	return campo('config_system','id','1','cost_company_bc');
}

function getPayBussinesCard($idUser=''){ /*this is to know if the user have paid for his BCs*/
	return campo('users','id',($idUser?$idUser:$_SESSION['ws-tags']['ws-user']['id']),'pay_bussines_card');
}
function getTimeShoppingCarActive(){ /*this is the price of editing a company business *card*/
	return campo('config_system','id','1','time_in_minutes_shopping_cart_active');
}
function getTimeOrderPay(){ /*this is the price of editing a company business *card*/
	return campo('config_system','id','1','time_in_minutes_pending_order_payable');
}

/*INI - funcion en prueba*/
function fillBusinessCardData(&$theUserName,	&$theUserSpecialty,	&$theUserCompany,		&$theUserAddress,	&$theUserPhone,
								&$theUserEmail,	&$theUserLogo,		&$theUserMiddleText,	$bc,				$user=''){
	if($bc){
		/*INI - WHEN CALLED FROM businessCard.view OR userProfile.view*/
		if($bc['company']!='')	$theUserCompany=$bc['company'];
		else						$theUserCompany='Social Media Marketing';
		$theUserAddress=$bc['address'];
		$theUserPhone='';
		$theUserPhone.=$_SESSION['ws-tags']['ws-user']['type']!='1'&&$bc['home_phone']!=''&&$bc['home_phone']!=' '?"<strong>".HOMEPHONE."</strong>:".$bc['home_phone']."&nbsp;":'';
		$theUserPhone.=$bc['work_phone']!=''&&$bc['work_phone']!=' '?"<strong>".WORKPHONE."</strong>: ".$bc['work_phone']."&nbsp;":'';
		$theUserPhone.=$bc['mobile_phone']!=''&&$bc['mobile_phone']!=' '?"<strong>".MOBILEPHONE."</strong>: ".$bc['mobile_phone']."&nbsp;":'';
		$theUserPhone.=$theUserPhone!=''?'<br/>':'';
		$theUserLogo=$bc['company_logo_url'];
		$theUserMiddleText=$bc['middle_text'];
		/*END - WHEN CALLED FROM businessCard.view OR userProfile.view*/
		if(!$user){
			$theUserName=$bc['nameUsr'];
			if($bc['specialty']!='')									$theUserSpecialty=$bc['specialty'];
			elseif($_SESSION['ws-tags']['ws-user']['screenName']!='')	$theUserSpecialty=$_SESSION['ws-tags']['ws-user']['screenName'];
			else														$theUserSpecialty='';
			if($bc['email'])	$theUserEmail=$bc['email'];
			else				$theUserEmail=$_SESSION['ws-tags']['ws-user']['email'];
		}else{/*IF IT'S A NEW BUSINESS CARD*/
			$theUserName		=$user['full_name'];
			$theUserSpecialty	=$user['screen_name'];
			$theUserEmail		=$user['email'];
		}
	}
}
/*FIN - funcion en prueba*/

function uploadFTP($file,$path,$parent='',$borrar=true,$code=''){
	global $config;
	//nombre de archivo y carpeta solamente,parent es para cuando se trabaje desde un include
	$code=$path=='tags'?'':($code?$code:$_SESSION['ws-tags']['ws-user']['code']);
	if(isset($config->ftp)){
		$id_ftp=ftp_connect($config->ftp->host,21);
		ftp_login($id_ftp,$config->ftp->user,$config->ftp->pass);
		//echo FTPSERVER.' - '.FTPACCOUNT.' - '.FTPPASS;
		ftp_pasv($id_ftp,true);
		ftp_chdir($id_ftp,$path.'/');
		if($path!='tags'){
			@ftp_mkdir($id_ftp,$code);
			$code.='/';
			ftp_chdir ($id_ftp,$code);
		}
		@ftp_put($id_ftp,'index.html',$parent.'img/index.html',FTP_BINARY);
		@ftp_put($id_ftp,$file,$parent.'img/'.$path.'/'.$code.$file,FTP_BINARY);
		ftp_quit($id_ftp);
		if($borrar){
			@unlink($parent.'img/'.$path.'/'.$code.$file);
		}
	}
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
	if($destino=='') $destino=$origen;
	$file=end(explode('/',$destino));
	$error=0;
	if(!$file) $error=400;
	global $config;
	$path=preg_replace('/^\/|\/[^\/]*$/','',$destino);
	$data=" P:$path F:$file O:$origen D:$destino";
	if(!$error)
	if(isset($config->ftp)){
		if(!$img_ftp_con){
			$img_ftp_con=ftp_connect($config->ftp->host,21);
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
			$data='PWD:'.ftp_pwd($img_ftp_con).$data;
			#Copiamos el archivo
			$error=(@ftp_put($img_ftp_con,$file,RELPATH.'img/'.$origen,FTP_BINARY)) ? 200 : 401;
			#Borramos la imagen de origen si es requerido
			if($borrar&&$error==200&&!@unlink(RELPATH.'img/'.$origen)) $error=206;
		}
		ftp_quit($img_ftp_con);
	}elseif(!$config->local){
		#Si no es local movemos al servidor de imagenes
		if(!is_dir($config->img_server_path.'img/'.$path))
			if(!@mkdir($config->img_server_path.'img/'.$path,0777,true)) $error=412;
		if(!$error)
		if($borrar)
			$error=(!@rename($_origen,$config->img_server_path.'img/'.$destino))?408:200;
		else
			$error=(!@copy($_origen,$config->img_server_path.'img/'.$destino))?409:200;
	}elseif($destino!=$origen){
		#Cuando no es ftp, y el origen es distinto al destino, se mueve/copia el archivo
		if(!is_dir(RELPATH.'img/'.$path))
			if(!@mkdir(RELPATH.'img/'.$path,0777,true)) $error=412;
		if(!$error)
		if($borrar)
			$error=(!@rename(RELPATH.'img/'.$origen,RELPATH.'img/'.$destino))?408:200;
		else
			$error=(!@copy(RELPATH.'img/'.$origen,RELPATH.'img/'.$destino))?409:200;
	}
	return $error;//.$data;#descomentar data si decea ver los mensajes de error
}
function FTPcopy($origen,$destino){
	global $config;
	$count=preg_match('/(.+\/)*/',$origen,$path);
	if(!isset($config->ftp)){
		//echo 'origen:'.$origen.'<br>desti:;'.$destino;
		copy($config->img_server_path.'img/'.$origen,$config->img_server_path.'img/'.$destino);
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

function FTPdelete($file,$path,$parent=''){
	#borrado de archivos por FTP. por hacer.
}

function copyFTP($file,$pathftp,$pathftpimg,$path='',$rename='',$code=''){
	if(!NOFPT){
		if(!$code){
			$code=$_SESSION['ws-tags']['ws-user']['code'];
		}
		$id_ftp=ftp_connect(FTPSERVER,21);
		ftp_login($id_ftp,FTPACCOUNT,FTPPASS);
		ftp_pasv($id_ftp,true);
		echo $path.'img/temporal/'.$file.'+++++',$pathftp.'/'.$code.'/'.$file.'<br>';
		if(ftp_get($id_ftp,$path.'img/temporal/'.$file,$pathftp.'/'.$code.'/'.$file ,FTP_BINARY)){
			ftp_chdir ($id_ftp,$pathftpimg.'/');
			if($path!='tags'){
				@ftp_mkdir($id_ftp,$code);
				ftp_chdir ($id_ftp,$code.'/');
			}
			@ftp_put ($id_ftp,'index.html',$path.'img/index.html',FTP_BINARY);
			if(ftp_put($id_ftp,($rename?$rename:$file),$path.'img/temporal/'.$file,FTP_BINARY)){
				unlink($path.'img/temporal/'.$file);
			}else{
				return false;
			}
		}else{
			return false;
		}
		return true;
	}else{
		copy(($path?$path:'../../').'img/'.$file,($path?$path:'../../').'img/'.$rename);
	}
}

function deleteFTP($file,$path,$parent=''){
	//nombre de archivo y carpeta solamente, parent es para cuando se trabaje desde un include
	if(!NOFPT){
		$id_ftp=ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp,FTPACCOUNT,FTPPASS);
		ftp_pasv ($id_ftp,false);
		ftp_chdir ($id_ftp,$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/'));
		//echo ftp_pwd($id_ftp).'/'.$path.'/'.$file.' delete: '.$file.'//////<br>';
		@ftp_delete($id_ftp,$file);
//		if(){
//			echo ' eliminado.++++++++++++';
//		}else{
//			echo ' fallido.++++++++++++';
//		}
		ftp_quit($id_ftp);
	}else{
		@unlink($parent.'img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$file);
	}
}

function renameFTP($fileNew,$fileOld,$path,$parent=''){
	//RE-ESCRIBE UN ARCHIVO
	//echo 'rename: old: '.$fileNew.'--- new: '.$fileOld.'---'.$path.'. ====== . ';
	if(!NOFPT){
		//$old_file='img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileOld;
		//$new_file='img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileNew;
		$id_ftp=ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp,FTPACCOUNT,FTPPASS);
		ftp_pasv ($id_ftp,false);
		//echo 'rename: new: '.ftp_pwd($id_ftp).'/'.$path.'/'.$fileNew.'//////<br> rename: old: '.ftp_pwd($id_ftp).'/'.$path.'/'.$fileOld.'//////<br>';
		ftp_chdir ($id_ftp,$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/'));
//		if(fileExistsRemote(ftp_pwd($id_ftp).'/'.$fileNew)){
//			echo ' si existe.++++++++++++';
//		}else{
//			echo ' no existe.++++++++++++';
//		}
		@ftp_rename($id_ftp,$fileNew,$fileOld);
//		if(){
//			echo ' hizo el cambio.++++++++++++';
//		}else{
//			echo ' no lo hizo.++++++++++++';
//		}
		//cerrar la conexión ftp
		ftp_quit($id_ftp);
	}else{
		$old_file='img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileOld;
		$new_file='img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileNew;
		@rename($parent.$new_file,$parent.$old_file);
	}
}

function opendirFTP($path,$parent=''){
	//nombre carpeta solamente, lista los archivos contenidos en la carpeta
	if(!NOFPT){
		$id_ftp=ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp,FTPACCOUNT,FTPPASS);
		ftp_pasv ($id_ftp,false);

		$salida=ftp_rawlist($id_ftp,$path);
		/////////////////////date extract
		$_cont=0;
		$rawlist=array();
		foreach ($salida as $v){
			$vinfo=preg_split('/[\s]+/',$v,9);
			if ($vinfo[0]!=='total'&&$vinfo[8]!='.'&&$vinfo[8]!='..'){
				if ($rawlist[strtotime($vinfo[5] . ' ' . $vinfo[6] . ' ' . $vinfo[7])]!=''){
					$rawlist[strtotime($vinfo[5] . ' ' . $vinfo[6] . ' ' . $vinfo[7])+(++$_cont)]=$vinfo[8];
				}else{
					$rawlist[strtotime($vinfo[5] . ' ' . $vinfo[6] . ' ' . $vinfo[7])]=$vinfo[8];
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
		$salida=@current($_array);
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

function tiempoEjecucionFinal($tiempoInicio,$num)
{
			
			echo "Tiempo empleado ($num): " . (microtime(true) - $tiempoInicio)."<br>";
}


function emailRegistered($email){
	$id=CON::getVal('SELECT id FROM users WHERE email=?',$email);
	if ($id) return true;
	return false;
}

/**
* send or delete notifications 
* envía o borra notificaciones
*
* @param string|int|boolean $id_friend  id friend (id del amigo, si es false son emails de personas no registradas)
* @param int $id_source source the notifications tags,products or groups (fuente de la notificacion tags, productos o grupos)
* @param int $id_type type the notifications (tipo de notifications)
* @param boolean $delete action the delete, if false is insert (accion de borrar, si es false es insertar)
* @param string|int $id_user id user, if false is id user in session (id del usuario)
* @param string|array|boolean $data other data if required  (otros datos si se requieren)
* @return void
*/
function notifications($id_friend,$id_source,$id_type,$delete=false,$id_user=false,$data=false){
	require_once(RELPATH.'includes/functions_mails.php');
	if ($GLOBALS['config']->local && !isset($_SESSION['ws-tags']['email'])) $_SESSION['ws-tags']['email']='';
	$id_type*=1; //asegurando que sea numerico
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	$id_user=$id_user?$id_user:$myId;
	$htmlEmail='';
	if(!$delete){
		if ($id_friend){
			$notifi=CON::insert('users_notifications','id_type=?,id_source=?,id_user=?,id_friend=?,revised=0',
				array($id_type,$id_source,$id_user,$id_friend));
			CON::update('users','last_update=NOW()','id=? OR id=?',array($id_user,$id_friend));
		}else $notifi=true;
		if($notifi){ //si se realizo el INSERT envia correo de notificacion 
			if ($id_friend)	//verificar si el usuario tiene inactivo el envio de correo
				$noEmail=CON::getVal('SELECT id FROM users_config_notifications WHERE id_user=? AND id_notification=?',array($id_friend,$id_type));
			else $noEmail=false;
			if (!$noEmail || $id_type==19 || $id_type==16){
				if(in_array($id_type,array(2,4,8,9,20))){
					$userEmailAllTag=CON::getRow('
						SELECT t.id_creator AS idCreator, u.email AS email
						FROM tags t JOIN users u ON t.id_user=u.id
						WHERE t.id=?',array($id_source));
				}
				switch($id_type){
					case 1: // private tags
						$iconoTipo=$GLOBALS['config']->main_server.'css/smt/email/tags.png';
						$body=''.formatShowTagMail($id_source,$iconoTipo,LABELTAGSPRIVATE,'').'';
						if ($id_friend){ //emvio a mis amigos
							$email=CON::getVal("SELECT email FROM users WHERE id=?",array($id_friend));
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$email;
							$htmlEmail.=formatMail($body,'790');
							if ($email && !$GLOBALS['config']->local) sendMail($htmlEmail,EMAIL_NO_RESPONDA,formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.LABELTAGSPRIVATE,$email,'../../');
						}else{ // envio a correos no registrados
							if ($data && is_array($data) && count($data)>0)
								foreach ($data as $email) {
									if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$email;
									$htmlEmail.=formatMail($body,'790');
									if ($email && !$GLOBALS['config']->local) sendMail($htmlEmail,EMAIL_NO_RESPONDA,formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.LABELTAGSPRIVATE,$email,'../../');
								}
						}
					break;
					case 2: case 4: case 8: case 9: case 20: //2 email de favorito, 4 email de comentario tag (4- dueño), 8 email de redistribucion, 9 email de patrocinio, 20 dislike (desactivado)
						if($id_friend && isValidEmail($userEmailAllTag['email'])){
							$msjLink=NOTIFICATIONS_COMMENTSTAGMSJUSERLINK;
							$iconoTipo=$GLOBALS['config']->main_server.'css/smt/tag/';
							switch ($id_type){
								case 2: $iconoTipo.='like.png';
									$msjBody=NOTIFICATIONS_LIKETAGMSJUSERSENT;
									$msjHead=formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.MENUTAG_MSJASUNTOFAVORTIO;
								break;
								case 4: $iconoTipo.='comment.png';
									$msjBody=NOTIFICATIONS_COMMENTSTAGMSJUSERSENT; $msjHead=MENUTAG_MSJASUNTOCOMMENT;
								break;
								case 8: $iconoTipo.='redist.png';
									$msjBody=NOTIFICATIONS_REDISTRIBUTIONTAGMSJUSERSENT; $msjHead=MENUTAG_MSJASUNTOREDISTRIBUTION;
								break;
								case 9: $iconoTipo.='sponsor.png';
									$msjBody=NOTIFICATIONS_SPONSORTAGMSJUSERSENT; $msjHead=MENUTAG_MSJASUNTOSPONSORED;
								break;
								case 20: $iconoTipo.='dislike.png';
									$msjBody=NOTIFICATIONS_DISLIKETAGMSJUSERSENT; 
									$msjHead=formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.NOTIFICATIONS_DISLIKETAGMSJUSERSENT.' '.NOTIFICATIONS_COMMENTSTAGMSJUSERLINK;
								break;
							}
							$body=''.formatShowTagMail($id_source,$iconoTipo,$msjBody,$msjLink).'';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$userEmailAllTag['email'];
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail,EMAIL_NO_RESPONDA,formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),$msjHead,$userEmailAllTag['email'],'../../');
						}
					break;
					case 5: case 11: // email de amigos y seguidores
						if($id_friend && isValidEmail($data['email'])){
							$body=''.formatShowFriendsMail($id_type).'';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$data['email'];
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail, EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), ($id_type==5?NEWS_FRIENDTAGMSJUSERSENT:MAILFALLOWFRIENDS_SUBJECT), $data['email'], '../../');
						}
					break;
					case 6: case 14: case 12: case 13: //invitacion a grupo, solicitud de grupos, aprobacion de grupo
						if($id_friend && isValidEmail($data['email'])){
							switch ($id_type) {
								case 6: case 14: $textAction=GROUP_EMAILASUNTOSUGGEST; break;
								case 12: $textAction=NOTIFICATIONS_TITLEMSGGROUPADMINUSER; break;
								case 13: $textAction=formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.NOTIFICATIONS_ADMINREQUESTUSERSENT_PLURAL; break;
								default: $textAction=GROUP_SHAREMAILTITLE1; break;
							}
							$body=''.formatShowGroupsMail($id_source,$id_type).'';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$data['email'];
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail, EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),$textAction, $data['email'], '../../');
						}
					break;
					case 7: //share tag by email, esta no guarda notificacion
						if (!$id_friend){
							$numE=0;
							$iconoTipo=$GLOBALS['config']->main_server.'css/smt/tag/share.png';
							$body=''.formatShowTagMail($id_source,$iconoTipo,MENUTAG_CTRSHAREMAILTITLE1,'',$data['msj']).'';
							foreach($data['per'] as $per){ if ($per=='') continue;
								if (isValidEmail($per)){ if ($numE++>20) continue;
								}else{
									$query=CON::getRow("SELECT u.id,u.email FROM users u WHERE md5(u.id)=?",array($per));
									if (count($query)>0) $per = $query['email'];
									else continue;
								}
								if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$per;
								$htmlEmail.=formatMail($body,'790');
								if (!$GLOBALS['config']->local) $resp = sendMail($htmlEmail, EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']), formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.MENUTAG_CTRSHAREMAILTITLE1, $per, "../../");
								else $resp=true;
								if ($resp){
									$data['correos'].= "-&nbsp;".$per."<br/>";
									//insert tabla verificacion
									if(!CON::exist("tags_share_mails","id_tag=? AND referee_number=? AND email_destiny =?",array($id_source,$_SESSION['ws-tags']['ws-user']['code'],$per)))
										CON::insert("tags_share_mails","id_tag = ?,referee_number =?,email_destiny =?,view = '0'",
											array($tag['id'],$_SESSION['ws-tags']['ws-user']['code'],$per));
									return $data; 
								}
							}
						}
					break;
					case 10://tag de grupo
						if($id_friend && isValidEmail($data['email'])){ 
							$body=''.formatShowGroupsMail($data['grupo'],$id_type,'',$id_source).'';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$data['email'];
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail, EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),NOTIFICATIONS_TITLEGROUPSTAGUSER, $data['email'], '../../');
						}
					break;
					case 15: //comentarios productos (15- dueño)
						if($id_friend){ 
							$email=CON::getVal("SELECT email FROM users WHERE id=?",array($id_friend));
							if ($email){
								$body=''.formatShowProductMail($id_source,$id_type).'';
								if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$email;
								$htmlEmail.=formatMail($body,'790');
								if (!$GLOBALS['config']->local) sendMail($htmlEmail, EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.NOTIFICATIONS_TITLESTORECOMMENTSMSJUSER_EMAIL, $email, '../../');
							}
						}
					break;
					case 16: case 17: //orden procesada exitosamente, orden pendiente por pagar
						if($id_friend){ 
							$array=storeCarMail($data,$id_type);
							if ($id_type==16)
								foreach ($array['seller'] as $row) {
									if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$row['email'].$row['html'];
									else sendMail($row['html'],EMAIL_NO_RESPONDA,formatoCadena($array['buyer']['name']),$row['buyer']['name'].' '.STORE_EMAILMESSAGE,$row['email'],'../../');
								} 
							if (!$noEmail)
								if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$array['buyer']['email'].$array['buyer']['html'];
								else sendMail($array['buyer']['html'],EMAIL_NO_RESPONDA,'Tagbum.com',STORE_PURCHASETITLENEW,$array['buyer']['email'],'../../');
						}
					break;
					case 19: //ganador de la rifa
						if($id_friend){
							$array=storeEndFreeProducts($id_friend,$id_source);
							$html=formatMail($array['email'],'790');
							$htmlOwner=formatMail($array['emailOwner'],'790');
							foreach ($data as $row) {
								if ($row['id']==$id_friend){
									if (!CON::getVal('SELECT id FROM users_config_notifications WHERE id_user=? AND id_notification=?',array($row['id'],19)))
										if (!$GLOBALS['config']->local) sendMail($html, EMAIL_NO_RESPONDA,'Tagbum',STORE_RAFFLEWINNER,$row['email'],"../../");
										else $htmlEmail.='<br><strong>Send To:</strong> '.$row['email'].$html;
								}else{
									if (!CON::getVal('SELECT id FROM users_config_notifications WHERE id_user=? AND id_notification=?',array($row['id'],18)))
										if (!$GLOBALS['config']->local) sendMail($html, EMAIL_NO_RESPONDA,'Tagbum',STORE_RAFFLEEMAILMESSAGE,$row['email'],"../../");
										else $htmlEmail.='<br><strong>Send To:</strong> '.$row['email'].$html;
								}
							}							
							if (!$GLOBALS['config']->local) sendMail($htmlOwner, EMAIL_NO_RESPONDA,'Tagbum',STORE_RAFFLEEMAILMESSAGE,$array['owner'],"../../");
							else $htmlEmail.='<br><strong>Send To:</strong> '.$array['owner'].$htmlOwner;
						}
					break;
					case 21: // report tag, esta no guarda ninguna notificacion
						if(!$id_friend){
							$body ='<div>
										<div style="background-image: url(\''.$GLOBALS['config']->main_server.'css/smt/icon.png\');width: 100px;background-repeat: no-repeat;height: 103px;margin-left: 40px;"></div> 
										<div style="padding: 25px;text-align: center; font-size: 25px; color:#FA0D1F">'.EMAIL_REPORTS_TAGS.'</div>
										<div style="text-align: center;"><img src="'.tagURL($id_source).'"></div>
										<div style="text-align: center; font-size: 20px; font-weight:bold; padding:20px 0"><a style="text-decoration: none; color: #514C4C; " href="'.$GLOBALS['config']->main_server.'wpanel/?idtagreport='.md5($id_source).'">'.EMAIL_REPORTS_TAGS_DELETE.'</a></div>
									</div>';
							foreach($data['emails'] as $per){
								if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$per;
								$htmlEmail.=$body;
								if (!$GLOBALS['config']->local) sendMail($htmlEmail, EMAIL_NO_RESPONDA,'Tagbum','Report Tags',$per,"../../");
							}
						}
					break;
					case 22:  case 25: case 26: case 27: 
						$email=CON::getVal("SELECT email FROM users WHERE id=?",array($id_friend));
						if($id_friend && isValidEmail($email)){
							switch ($id_type) {
								case 22: $titulo=NOTIFICATIONS_TOPTAG_DAY; break;
								case 25: $titulo=NOTIFICATIONS_TOPTAG_WEEK; break;
								case 26: $titulo=NOTIFICATIONS_TOPTAG_MONTH; break;
								case 27: $titulo=NOTIFICATIONS_TOPTAG_YEAR; break;
							}
							$linkTag=$GLOBALS['config']->main_server.'tag?id='.$id_source;
							$imgTag=tagURL($id_source);
							$body ='<table align="center" width="650" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana,Geneva,sans-serif;font-size:12px">
									<tr>
										<td style="height:30px;font-size:20px;color:#999;font-weight:bold;text-align:center;">
										<img src="'.$GLOBALS['config']->main_server.'css/smt/icon.png" style="height: 80px;"/>
										'.CONGRATULATIONS.' '.$titulo.' <br><br></td>
									</tr>
									<tr><td colspan="2"><br><p><a href="'.$linkTag.'" target="_blank"><img src="'.$imgTag.'" alt="tag"></a></p><br></td></tr>
									</table>';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$email;
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail,EMAIL_NO_RESPONDA,TOPTAG_TITLE,CONGRATULATIONS,$email,'../../');						
						}
					break;
					case 28: // comentarios tag (28- otros usuarios que han comentado la tag)
						if($id_friend && isValidEmail($data['email'])){
							$iconoTipo=$GLOBALS['config']->main_server.'css/smt/tag/comment.png';
							$body=''.formatShowTagMail($id_source,$iconoTipo,NEWS_COMMENTSTAGMSJUSERSENT,'Tag').'';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$data['email'];
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail,EMAIL_NO_RESPONDA,formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.NEWS_COMMENTSTAGMSJUSERSENT.' Tag',$data['email'],'../../');
						}
					break;
					case 29: //comentarios productos (29- otros usuarios que han comentado)
						if($id_friend && isValidEmail($data['email'])){ 
							$body=''.formatShowProductMail($id_source,$id_type).'';
							if ($GLOBALS['config']->local) $htmlEmail.='<br><strong>Send To:</strong> '.$data['email'];
							$htmlEmail.=formatMail($body,'790');
							if (!$GLOBALS['config']->local) sendMail($htmlEmail, EMAIL_NO_RESPONDA, formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']),formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).' '.NOTIFICATIONS_STORECOMMENTSMSJUSER_EMAIL, $data['email'], '../../');
						}
					break;
				} //end switch	
			if ($GLOBALS['config']->local) $_SESSION['ws-tags']['email'].=$htmlEmail;
			}
		}
	}else{ //else delete
		if($id_friend!=$id_user){
			CON::delete('users_notifications','id_type=? AND id_source=? AND id_user=? AND id_friend=?',array(
				$id_type,$id_source,$id_user,$id_friend
			));
		}else{
			CON::delete('users_notifications','id_type=? AND id_source=? AND id_friend=? AND revised=1',array(
				$id_type,$id_source,$id_friend
			));
		}
	}
}

function logAction($id_type,$id_source,$id_user=''){
	if($id_user=='') $id_user=$_SESSION['ws-tags']['ws-user']['id'];
	return CON::insert('log_actions','id_type=?,id_source=?,id_user=?',array($id_type,$id_source,$id_user));
}

function getMonth($pos=1){
	$array=array(
		'',
		JANUARY,
		FEBRURY,
		MARCH,
		APRIL,
		MAY,
		JUNE,
		JULY,
		AUGUST,
		SEPTEMBER,
		OCTOBER,
		NOVEMBER,
		DECEMBER
	);
	return $array[$pos];
}

/* newwwww */
function getCreatingTagPoints(){	/**** points of creating a tag ******************/
	return campo('config_system','id','1','creating_tag_points');
}

function getSharingTagPoints(){	/**** points of mailing a tag *******************/
	return campo('config_system','id','1','sending_tag_points');
}

function getTagPoints($idTag){

	$redistributingTagPoints=campo('config_system','id','1','redistributing_tag_points');
	$redistributingSponsorTagPoints=campo('config_system','id','1','redistributing_sponsor_tag_points');

	$result=$GLOBALS['cn']->query("
		SELECT click_current,click_max
		FROM users_publicity
		WHERE
			id_tag				='".$idTag."' AND
			id_type_publicity	='4' AND
			status				='1';
	");

	if(mysql_num_rows($result)>0){
		$result=mysql_fetch_assoc($result);
		return $result['click_current']<$result['click_max']?$redistributingSponsorTagPoints:$redistributingTagPoints;
	}

	return $redistributingTagPoints;
}

function updateUserCounters($id_user,$field,$inc,$action){

	$usr=($id_user!='')?$id_user:$_SESSION['ws-tags']['ws-user']['id'];

	$query=$GLOBALS['cn']->query(" SELECT $field FROM users WHERE id='".$usr."'");
	$array=mysql_fetch_assoc($query);

	if ($action=='+'){

		$update=$GLOBALS['cn']->query("UPDATE users SET ".$field."=".$field." ".$action." ".$inc." WHERE id='".$id_user."'");

	}elseif($action=='-'&&$array[$field]>=$inc){

		$update=$GLOBALS['cn']->query("UPDATE users SET ".$field."=".$field." ".$action." ".$inc." WHERE id='".$id_user."'");

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

function viewChatFriends($id=''){
		$user=($id=='')?md5($_SESSION['ws-tags']['ws-user']['id']):md5($id);
		dropViews(array('view_friends'));
		//los que el usuario sigue
		$GLOBALS['cn']->query("
			CREATE VIEW view_friends AS
			SELECT DISTINCT
				l.id_user AS id_user,
				l.id_friend as id_friend,
				u.screen_name,
				CONCAT(u.name,' ',u.last_name) AS name_user,
				u.profile_image_url AS photo_friend,
				u.email,
				u.home_phone,
				u.mobile_phone,
				u.work_phone,
				u.chat_last_update,
				md5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code_friend
			FROM users u INNER JOIN users_links l ON u.id=l.id_friend
			WHERE md5(l.id_user)='".$user."';
		");
		//amigos code_friend screen_name name_user photo_friend last_update
		$dif='TIMESTAMPDIFF(MINUTE,f.chat_last_update,now())';
		$friends=$GLOBALS['cn']->query("
			SELECT
				f.name_user AS n,
				f.photo_friend AS p,
				f.code_friend AS c,
				if(f.screen_name='',f.name_user,f.screen_name) as s,
				if($dif>10,'offline',if($dif>5,'away','online')) as 't'
			FROM view_friends f INNER JOIN users_links u ON f.id_friend=u.id_user
			WHERE md5(u.id_friend)='".$user."'
			order by TIMESTAMPDIFF(MINUTE,f.chat_last_update,now()) ASC
			LIMIT 0,50;
		");
		return $friends;
}

function saveDevice($mobile=false){
	$langcode=array_shift(explode(',',array_shift(explode(';',$_SERVER['HTTP_ACCEPT_LANGUAGE']))));
	return CON::insert('users_device_login','id_user=?,agent=?,remote_addr=?,remote_host=?,remote_port=?,language=?,is_mobile=?',array(
		$_SESSION['ws-tags']['ws-user']['id'],
		$_SERVER['HTTP_USER_AGENT'],
		$_SERVER['REMOTE_ADDR'],
		$_SERVER['REMOTE_HOST'],
		$_SERVER['REMOTE_PORT'],
		$langcode,
		$mobile?1:0
	));
}

function registerDevice($mobile){
	$langcode=explode(';',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
	$langcode=explode(',',$langcode['0']);

	$GLOBALS['cn']->query('
		INSERT INTO users_device_login SET
			id_user		="'.$_SESSION['ws-tags']['ws-user']['id'].'",
			agent		="'.str_replace("'","\'",$_SERVER['HTTP_USER_AGENT']).'",
			remote_addr	="'.$_SERVER['REMOTE_ADDR'].'",
			remote_host	="'.$_SERVER['REMOTE_HOST'].'",
			remote_port	="'.$_SERVER['REMOTE_PORT'].'",
			language	="'.$langcode['0'].'",
			is_mobile	="'.$mobile.'"
	');
	return md5(mysql_insert_id());
}

function pointsList($type_publicity='4',$status='1'){
	return $GLOBALS['cn']->query('
		SELECT
			(SELECT name FROM currency WHERE id=a.id_typecurrency) AS moneda,
			(SELECT name FROM type_publicity WHERE id=a.id_typepublicity) AS tipo_publi,
			CONCAT(a.click_from," - ",a.click_to) AS rango,
			a.cost AS costo
		FROM points_publicity a
		WHERE status="'.$status.'" AND a.id_typepublicity="'.$type_publicity.'"
		ORDER BY a.click_from ASC
	');
}

function factorPublicityPoints($type,$points){
	$query=$GLOBALS['cn']->query('
		SELECT factor
		FROM points_publicity
		WHERE id_typepublicity="'.$type.'" AND "'.$points.'" BETWEEN min_points AND max_points
	');

	if(mysql_num_rows($query)==1){
		$result=mysql_fetch_assoc($query);
	}else{
		$query=$GLOBALS['cn']->query('
			SELECT MIN(factor) AS factor
			FROM points_publicity
			WHERE id_typepublicity="'.$type.'"
		');
		$result=mysql_fetch_assoc($query);
	}
	return intval($result['factor']?$points/$result['factor']:0);
}

function generateDivMessaje($id,$width,$content,$success=true,$float=''){
	if($success){
		echo '	<div id="'.$id.'" class="success_message" style="width:'.$width.'px;margin:0 auto;'.($float?"float:$float;":'').'">
					<img src="imgs/message_success.png" width="12" height="12"/>
					&nbsp;'.$content.'
				</div>';
	}else{
		echo '	<div id="'.$id.'" class="error_message" style="width:'.$width.'px;margin:0 auto;'.($float?"float:$float;":'').'">
					<img src="imgs/message_error.png" width="12" height="12"/>
					&nbsp;'.$content.'
				</div>';
	}
}

function replaceCharacters($cad){
	return mysql_real_escape_string($cad);
}

function filterListFolderImagess(){
	return array('.','..','Thumbs.db','_notes','.DS_Store','.svn');
}

function addJs($files){
	if (is_array($files)){
		foreach ($files as $value)
			echo '<script type="text/javascript" src="'.$value.'"></script>';
	}else{
		echo '<script type="text/javascript" src="'.$files.'"></script>';
	}
}

function mysqlFetchAssocToArray($query,$field){
	$_array=array();
	while($array=mysql_fetch_assoc($query))
		$_array[]=$array[$field];
	return $_array;
}

function generateThumbPath($photo,$onlyName=false,$default='img/users/default.png'){
	$path=LOCAL?RELPATH:FILESERVER;
	$imagesAllowed=array('jpg','jpeg','png','gif');
	$ext=strtolower(end(explode('.',$photo)));
	if(in_array($ext,$imagesAllowed)&&strpos(" $photo",'img/')){
		$imagen=str_replace(".$ext","_thumb.$ext",$photo);
		if($onlyName||fileExistsRemote($path.$imagen)){
			return $imagen;
		}elseif(fileExistsRemote($path.$photo)){
			return $photo;
		}
	}
	return $default;
}

function validImgUserfreinds($code,$photo){
	if(($code!='')&&($photo!='')){
		if(@fopen(FILESERVER."img/users/".$code."/".$photo,"r")==true){
			return generateThumbPath("img/users/".$code."/".$photo);
		}else{
			return "img/users/default.png";
		}
	}else{
		return "img/users/default.png";
	}
}

function noLineBreak($str){
	return str_replace(chr(13),' ',str_replace(chr(10),' ',$str));
}

//groups

function isInTheGroup($id_group,$id_user=''){
	$id_user	=($id_user!='')?$id_user:$_SESSION['ws-tags']['ws-user']['id'];
	$query		=$GLOBALS['cn']->query("SELECT if(is_admin='1','admin','belongs') as 'is' FROM users_groups WHERE id_user='".$id_user."' AND md5(id_group)='".$id_group."'");
	$is			=mysql_fetch_assoc($query);
	return $is['is']!=''?$is['is']:0;
}

function groupsOriented($oriented='',$id_user=''){
	$paso=false;
	$id_user=($id_user!='')?$id_user:$_SESSION['ws-tags']['ws-user']['id'];
	$user_age=edad($_SESSION['ws-tags']['ws-user']['date_birth'],'-');

	$rules=$GLOBALS['cn']->query('
		SELECT id,rule
		FROM groups_oriented
		WHERE id="'.$oriented.'"
	');

	$rule=mysql_fetch_assoc($rules);

	if ($user_age>=$rule['rule'])
		$paso=true;
	return $paso;
}

function ftp_copy($file){
	global $conn_id;
	$ftp_root='/public_html/';
	$site_root='/home/usr/public_html/';
	return ftp_put($conn_id,$ftp_root . $file,$site_root . $file,FTP_BINARY);
}

/* is_set($item,$alter)
 *		Si el item existe, retorna su valor, de lo contrario, retorna el valor alterno
 */
function is_set($item,$alter=false){
	return isset($item)?$item:$alter;
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

function convertir_especiales_html($str){
	if (!isset($GLOBALS['carateres_latinos'])){
		$todas=get_html_translation_table(HTML_ENTITIES,ENT_NOQUOTES);
		$etiquetas=get_html_translation_table(HTML_SPECIALCHARS,ENT_NOQUOTES);
		$GLOBALS['carateres_latinos']=array_diff($todas,$etiquetas);
	}
	$str=strtr($str,$GLOBALS['carateres_latinos']);
	return $str;
}

function transferTag($tag_from,$tag_to,$op,$type_notif=""){
	switch ($op){
		case '1':$query=$GLOBALS['cn']->query("UPDATE tags_comments SET id_tag='".$tag_to."' WHERE id_tag='".$tag_from."'");
		break;//comentarios
		case '2':$query=$GLOBALS['cn']->query("UPDATE tags SET source='".$tag_to."' WHERE source='".$tag_from."'");
		break;//redistribuciones
		case '3':$query=$GLOBALS['cn']->query("UPDATE likes SET id_source='".$tag_to."' WHERE id_source='".$tag_from."'");
		break;//likes
		case '4':	$type=($type_notif!='')?" AND id_type='".$type_notif."' ":"";
					$query=$GLOBALS['cn']->query('
						UPDATE users_notifications SET id_source="'.$tag_to.'"
						WHERE id_source="'.$tag_from.'" AND id_type IN (1,2,4,7,8,9,10) '.$type.'
					');
		break;//notifications
	}
}

function updateTagData($old,$new){
	CON::update('tags','source=?','source=?',array($new,$old));
	CON::update('likes','id_source=?','id_source=?',array($new,$old));
	CON::update('tags_comments','id_tag=?','id_tag=?',array($new,$old));
	CON::update('users_publicity','id_tag=?','id_tag=?',array($new,$old));
	CON::update('users_notifications','id_source=?','id_source=? AND id_type IN (1,2,4,7,8,9,10)',array($new,$old));
}

function limpiaTextComentarios($text){
//	$codigos=array('&Agrave;','&agrave;','&Aacute;','&aacute;','&Acirc;','&acirc;','&Atilde;',
//		'&atilde;','&Auml;','&auml;','&Aring;','&aring;','&AElig;','&aelig;','&Ccedil;',
//		'&ccedil;','&ETH;','&eth;','&Egrave;','&egrave;','&Eacute;','&eacute;','&Ecirc;',
//		'&ecirc;','&Euml;','&euml;','&Igrave;','&igrave;','&Iacute;','&iacute;','&Icirc;',
//		'&icirc;','&Iuml;','&iuml;','&Ntilde;','&ntilde;','&Ograve;','&ograve;','&Oacute;',
//		'&oacute;','&Ocirc;','&ocirc;','&Otilde;','&otilde;','&Ouml;','&ouml;','&Oslash;',
//		'&oslash;','&OElig;','&oelig;','&szlig;','&THORN;','&thorn;','&Ugrave;','&ugrave;',
//		'&Uacute;','&uacute;','&Ucirc;','&ucirc;','&Uuml;','&uuml;','&Yacute;','&yacute;',
//		'&Yuml;','&yuml;');
//
//	$caracteres=array('Ã€','Ã ','Ã�','Ã¡','Ã‚','Ã¢','Ãƒ','Ã£','Ã„','Ã¤','Ã…','Ã¥','Ã†','Ã¦','Ã‡',
//		'Ã§','Ã�','Ã°','Ãˆ','Ã¨','Ã‰','Ã©','ÃŠ','Ãª','Ã‹','Ã«','ÃŒ','Ã¬','Ã�','Ã­','ÃŽ',
//		'Ã®','Ã�','Ã¯','Ã‘','Ã±','Ã’','Ã²','Ã“','Ã³','Ã�?','Ã´','Ã•','Ãµ','Ã–','Ã¶','Ã˜',
//		'Ã¸','Å’','Å“','ÃŸ','Ãž','Ã¾','Ã™','Ã¹','Ãš','Ãº','Ã›','Ã»','Ãœ','Ã¼','Ã�','Ã½',
//		'Å¸','Ã¿');
//
//	$text=str_replace($caracteres,$codigos,$text);
	#se debe convertir utf8 a iso o viseversa, verificar en base de datos
//	$text=str_replace("	","&nbsp;&nbsp;",$text);//tab
//	$text=str_replace(chr(152),'',$text);//tilde de la Ã± Ëœ
//	//$text=str_replace('"',"\"",$text);
//	$text=str_replace('"',"&quot;",$text);
//	$text=str_replace("'","&apos;",$text);
	if(is_ISO($text)) $text=utf8_encode($text);
	$text=htmlentities($text);
	$text=str_replace("\r\n","\n",$text);
	$text=str_replace("\n\r","\n",$text);
	$text=str_replace("\n","<br>",$text);
	return $text;
}

function formatText($text,$html=false){
	if(is_ISO($text)) $text=utf8_encode($text);
	if(!$html) $text=htmlentities($text);
	$text=str_replace("\r\n","\n",$text);
	$text=str_replace("\n\r","\n",$text);
	$text=str_replace("\n","<br>",$text);
	return $text;
}

function updateUsersCounters($id){
	$data=CON::getRow('
		SELECT u.id,
			(SELECT COUNT(*) FROM users_links WHERE u.id=id_user	AND is_friend=1) AS friends,
			(SELECT COUNT(*) FROM users_links WHERE u.id=id_user	) AS admired,
			(SELECT COUNT(*) FROM users_links WHERE u.id=id_friend	) AS admirers
		FROM users u
		WHERE md5(u.id)="'.$id.'"
	');
	#actualizamos amigos de usuario
	CON::update('users','friends_count="'.$data['friends'].'",
			following_count	="'.$data['admired'].'",
			followers_count	="'.$data['admirers'].'"',
			'id="'.$data['id'].'"');
	if(CON::error()) die('updateUsersCounters -> '.CON::errorMsg());
	return $data;
}

function relativePath($url){
	return str_replace($GLOBALS['config']->main_server,'../',str_replace('http://tagbum.com','..',$url));
}

function generateAlbumView($userId,$showEditImages,$rel,$albumName){
	//selecting all photos from album $albumName (except the cover picture)
	$images_profile	=$GLOBALS['cn']->query('
		SELECT i.id,i.image_path
		FROM images i
		JOIN album a ON a.id_user=i.id_user
		WHERE
			i.id_user='.$userId.' AND
			i.id_images_type=2 AND
			a.name="'.$albumName.'" AND
			a.id_image_cover!=i.id
		ORDER BY i.id DESC
	');
	echo '<div style="display:none;">';
	while($image=mysql_fetch_assoc($images_profile)){
		$img_full_src=FILESERVER.'img/users/'.$image['image_path'];
		$showEditImages=($showEditImages?'&showMenu':'');
		echo
			'<a id="'.md5($img_full_src).'" class="grouped_PP" rel="'.$rel.'"'.
				'href="'.$GLOBALS['config']->main_server.'views/photos/picture.view.php?src='.$img_full_src.'&id_photo='.md5($image['id']).'&id_user='.$userId.$showEditImages.'">'.
				'<img src="'.$img_full_src.'" alt=""/>'.
			'</a>';
	}
	echo '</div>';
}

function getPicture($photoPath,$default=''){
	if(fileExistsRemote($photoPath)){
		return $photoPath;
	}
	return $default;
}
function getProfilePicture($photoPath){
	return getPicture(generateThumbPath($photoPath),'css/smt/usr.jpg');
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

function getPublicityPicture($photo,$default='img/publicity/publicity_nofile.png',$wpanel=''){
	$path='img/publicity/';
	if(strpos($photo,$path)===false) $photo=$path.$photo;

	if(preg_match('/\S+\.\S+$/',$photo)){
		//$thumb=preg_replace('/(\.\S+)$/',$photo);
		// if(fileExistsRemote(FILESERVER.$thumb))
		// 	return $thumb;
		if ($wpanel!='5') {
			if(fileExistsRemote(FILESERVER.$photo))
				return $photo;
		} else {
			if(fileExistsRemote($GLOBALS['config']->main_server.$photo))
				return $photo;
		}
		
		
	}
	return $default;
}

//funciones para manejo de imagenes
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
function imagecolorhexallocate(&$im,$hex){
	if($hex=='') $hex='#fff';
	$color=HexToRGB($hex);
	return imagecolorallocate($im,$color['r'],$color['g'],$color['b']);
}
function imagecolorhexallocatealpha(&$im,$hex,$alpha=50){
	$color=HexToRGB($hex);
	return imagecolorallocatealpha($im,$color['r'],$color['g'],$color['b'],$alpha);
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

function tagURL($tag,$mini=false){
	$tid=substr(intToMd5($tag),-16);
	return ($GLOBALS['config']->local?DOMINIO:FILESERVER).'img/tags/'.$tid.($mini?'.m':'').'.jpg';
}
function createTag($tag,$force=false,$msg=false){
	global $config;

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
	$_path=$config->local?RELPATH:$config->img_server_path;
	//Se busca la imagen de la tag
	if(!$force) $im=imagecreatefromany($_path.$photopath);
	//Si la imagen de la tag no existe,se crea
	if(!$im||$debug){
		if(!is_array($tag)) $tag=getTagData($tid);
		$tag['fondoTag']=preg_replace('/ /','%20',$tag['fondoTag']);
		//Debugger
		if($debug){
			_imprimir($tag);
			//Fondo
			if(preg_match('/[0-9a-f]{8}_\d+_\d\.jpe?g$/i',$tag['fondoTag']))
				$imagen=$config->video_server_path.'videos/'.$tag['fondoTag'];
			else
				$imagen=$config->img_server_path.'img/templates/'.$tag['fondoTag'];
			echo '<br/>fondo='.$imagen;
			echo '<br/>externo='.str_replace($config->img_server_path,$config->img_server,
				str_replace($config->video_server_path,$config->video_server,$imagen));
			echo '<br/>path='.$_path;
			echo '<br/>photo='.$tag['photoOwner'];
			echo '<br/>getUserPicture='.getUserPicture($tag['photoOwner']);
		}
		if($tag){
			$font=array(
				RELPATH.'fonts/trebuc.ttf',
				RELPATH.'fonts/trebucbd.ttf',
				RELPATH.'fonts/verdana.ttf',
				RELPATH.'fonts/verdanab.ttf'
			);
			//Se crea la imagen con el tamaño normal - 650 x 300.
			$im=imagecreatetruecolor(TAGWIDTH,TAGHEIGHT);
			//Crear algunos colores
			$blanco=imagecolorallocate($im,255,255,255);
			$negro=imagecolorallocate($im,0,0,0);
			//Fondo
			if(preg_match('/[0-9a-f]{8}_\d+_\d\.jpe?g$/i',$tag['fondoTag']))
				$imagen=$config->video_server_path.'videos/'.$tag['fondoTag'];
			else
				$imagen=$config->img_server_path.'img/templates/'.$tag['fondoTag'];
			if ($config->local) $imagen=RELPATH.$imagen;
			// $imagen=(strpos(' '.$tag['fondoTag'],'default')?RELPATH:$_path).'img/templates/'.$tag['fondoTag'];
			// $img=imagecreatefromany($imagen);
			$is=@getimagesize($imagen);
			if($is[0]>0){
				$img=WideImage::load($imagen);
				$img->resizeDown(650);
				$dy=intval((TAGHEIGHT-$is[1])/2);
				while($dy>0) $dy-=$is[1];
				do{
					$dx=$is[0]>TAGWIDTH?intval((TAGWIDTH-$is[0])/2):0;
					do{
						imagecopy($im,$img->getHandle(),$dx,$dy,0,0,$is[0],$is[1]);
						$dx+=$is[0];
					}while($dx<TAGWIDTH);
					$dy+=$is[1];
				}while($dy<TAGHEIGHT);
				// imagedestroy($img);
				$img->destroy();
			}
			//Bordes redondeados
			$cr=25;//radio de la curva
			$mask=imagecreatetruecolor(TAGWIDTH,TAGHEIGHT);
			imagecopy($mask,$im,0,0,0,0,TAGWIDTH,TAGHEIGHT);
			$im1=WideImage::loadFromHandle($mask);
			$im1=$im1->roundCorners(30,$im1->allocateColor(255,255,255), 2,255);
			imagecopy($im,$im1->getHandle(),0,0,0,0,TAGWIDTH,TAGHEIGHT);
			$im1->destroy(); 
			/**/
			//Imagen de usuario
			if($tag['idProduct']) $imagen=$_path.$tag['photoOwner'];
			else $imagen=$_path.getUserPicture($tag['photoOwner']);
			if($debug) echo '<br/>'.$imagen;
			$img=imagecreatefromany($imagen);
			if($img){
				$im2=WideImage::loadFromHandle($img);
				if ($im2->getWidth()!=60 || $im2->getHeight()!=60 ){
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
					$im2=$im2->resize(60,60);
				}
				$im2=$im2->roundCorners(33,null, 2,255);
				imagecopy($im,$im2->getHandle(),40,215,0,0,60,60); 
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
			$size=15;
			$txt=imagettfbbox($size,0,$fuente,$texto);
			$y=73;
			$mw=600;//max width - ancho maximo
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
				$x=intval((TAGWIDTH-$txt[2])/2);
				imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
				imagettftext($im,$size,0,$x-1,$y-1,$luz,$fuente,$texto);
				imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
				$y+=23;
			}while(count($tmp)>$i);
			//texto principal - Centro
			$fuente=$font[0];
			$texto=strtoupper(strclean($tag['code_number']));
			$color=imagecolorhexallocate($im,$tag['color_code2']);
			$size=45;
			$s=0;//separacion entre letras
			$len=strlen($texto);
			$txt=imagettfbbox($size,0,$fuente,$texto);
			$x=intval((TAGWIDTH-$txt[2])/2);
			$y=165;
			imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
			imagettftext($im,$size,0,$x-1,$y-1,$luz,$fuente,$texto);
			imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
			//nombre usuario
			$fuente=$font[1];
			$texto=strclean($tag['nameOwner']);
			$color=$blanco;
			$sombra=$negro;
			$size=15;
			$x=115;
			$y=223;
			imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
			imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);
			//fecha
			$txt=imagettfbbox($size,0,$fuente,$texto);
			$fuente=$font[0];
			$texto=date('d-M-Y H:i',$tag['date']);
			$size=8;
			$x+=$txt[2]+10;
			imagettftext($im,$size,0,$x+1,$y+1,$sombra,$fuente,$texto);
			imagettftext($im,$size,0,$x,$y,$color,$fuente,$texto);

			//texto2 - parte baja
			$fuente=$font[1];
			$texto=strclean($tag['texto2']);
			$color=imagecolorhexallocate($im,$tag['color_code3']);
			$size=10;
			$x=115;
			$y=241;
			$mw=430;//max width-ancho maximo
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
			$imagen=RELPATH.'img/placaFondo.png';
			$img=imagecreatefromany($imagen);
			if($img){
				$is=getimagesize($imagen);
				imagecopy($im,$img,0,0,0,0,$is[0],$is[1]);
				imagedestroy($img);
			}
		}
		//subir el archivo al servidor
		// if(!$debug){//si estamos en debug no se guarda
			$phototmp=RELPATH.$path.'/tmp'.rand().'.png';
			imagepng($im,$phototmp);
			if (redimensionar($phototmp,RELPATH.$photopath,650)){
				@unlink($phototmp);
				$ftp=FTPupload("tags/$photo");
				if($msg) echo '<br/>guardada imagen '.$photo;
			}
		// }
	}elseif($msg) echo '<br/>ya existe la imagen '.$photo;
	//FIN - creacion de la imagen de la tag
	//creamos la miniatura si no existe
	if(!fileExists($_path.$photompath)||$force){
		// if(!$debug){//si estamos en debug no se guarda
			$phototmp=RELPATH.$path.'/'.$tmpFile.'.png';
			imagepng($im,$phototmp);
			if (redimensionar($phototmp,RELPATH.$photompath,200)){
				@unlink($phototmp);
				$ftp=FTPupload("tags/$photom");
				if($msg) echo '<br/>guardada miniatura '.$photom;
			}
		// }
	}
	if($debug) echo "<br/>ftp result=$ftp";
	CON::update('tags',"img=?",'id=?',array($tid,$tag['id']));
	return $tid;
}
function tagEditEmail($new,$old){
	if($old!=0){
		$query=$GLOBALS['cn']->query('
			SELECT
				u.id_tag_old AS idOld,
				u.id_tag_new AS idNew
			FROM tags_edit_email u
			WHERE u.id_tag_new="'.$old.'"
		');
		if(mysql_num_rows($query)>0){
			$data=mysql_fetch_assoc($query);
			$GLOBALS['cn']->query('INSERT INTO tags_edit_email SET
					id_tag_old="'.$data['idOld'].'",
					id_tag_new="'.$new.'"
			');
		}
	}
	if($old==0){
		 $GLOBALS['cn']->query('INSERT INTO tags_edit_email SET
				id_tag_old="'.$new.'",
				id_tag_new="'.$new.'"
		');
	}

}

function strToLink($string){
	$pattern=regex('url');//'/((https?:\/\/)?[a-zA-Z]\w*([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?)/';
	$replacement='<a href="${1}" target="_blank">${1}</a>';
	return preg_replace($pattern,$replacement,$string);
}

function get_hashtags($tweet){
	preg_match_all('/#\S+/i',$tweet,$matches);
	return $matches[0];
}
function generaCodeId($id,$length,$caracter=0){
	$cadena='';$num=strlen($id);
	if ($num>$length) return false;
	for($i=0;$i<($length-$num);$i++){
		$cadena.=$caracter;
	}
	return '#'.$cadena.$id;
}
function intToMd5($id){
	if(is_string($id)) $id=trim($id);
	if($id!=''&&!preg_match('/\D/',$id)) $id=md5($id);
	return $id;
}

function validPointPubli($idUser,$idPubli,$ip){
	$sql=safe_sql('
		SELECT *,IF(TIMEDIFF(NOW(),timep)>"24:00:00",1,0) AS acceso
		FROM users_publicity_validation
		WHERE id_user=? AND md5(id_publicity)=? AND ip=?
		ORDER BY timep DESC
		LIMIT 1
	',array($idUser,$idPubli,$ip));
	$valida=$GLOBALS['cn']->query($sql);
	$pvalida = mysql_fetch_assoc($valida);
	$pvalidaN = mysql_num_rows($valida);

	if($pvalidaN==0||$pvalida['acceso']=='1'){
		$publi	= $GLOBALS['cn']->query("SELECT * FROM users_publicity WHERE md5(id) = '".$idPubli."'");
		$idp	= mysql_fetch_assoc($publi);
		$GLOBALS['cn']->query("
			INSERT INTO users_publicity_validation SET
				id_user			= '".$idUser."',
				id_publicity	= '".$idp['id']."',
				ip				= '".$ip."'
		 ");
		return mysql_insert_id();
	}else{
		echo $pvalida['acceso'];
	}
}

function tour_json($where=''){
	$notIn = ($_SESSION['ws-tags']['ws-user']['type']==0)?'AND u.id_div not in("#tourPublicity")':'';
	$hashtour = $GLOBALS['cn']->query('
		SELECT
			u.id_div AS id_div,
			u.title AS title,
			u.message AS message,
			u.position AS position,
			u.hash_tash AS hash_tash
		FROM tour_comment u
		WHERE md5(u.hash_tash) = "'.$where.'" AND active=1 AND sectionActive=1 '.$notIn.'
		ORDER BY u.orderP ASC
	');
	return $hashtour;
}

function tourHash_json($hashtash){
	$tourHash = $GLOBALS['cn']->query('
		SELECT
			u.id_user AS id_user,
			u.hash_tash AS hash_tash
		FROM tour_hash u
		WHERE u.id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'" AND u.hash_tash = "'.$hashtash.'"
	');
	$Hashtour = mysql_fetch_array($tourHash);
	if ($Hashtour[hash_tash]!=$hashtash){
		$GLOBALS['cn']->query('
			INSERT INTO tour_hash SET
				id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'",
				hash_tash = "'.$hashtash.'"
		');
		return '0';//registra el usuario y el hash
	}else{
		return '1';//ya ese hash y usuario se registro
	}
}

function get_trending($limit=5, $date = 'CURDATE()'){
	$sql = 'SELECT id,word 
			FROM trending_toping 
			WHERE day BETWEEN DATE_SUB(CURDATE(),INTERVAL 4 DAY) AND '.$date.'
			ORDER BY count DESC,RAND() LIMIT '.$limit;
	$trendings = $GLOBALS['cn']->query($sql);
	return $trendings;
}

function set_trending_topings($s, $by_hash=false){
	$s = strtolower($s);
	$sql = "SELECT id FROM trending_toping WHERE word LIKE ?";
	if ($by_hash) {
		$hashes = array();
		preg_match_all('/#\S+/i',$s,$matches);
		foreach ($matches[0] as $value) {
			$hashes[] = trim(strtolower($value), ',;.:[]{}¿?¡!');
		}

		//Si hay hash en el texto dado...
		if (count($hashes) > 0) {
			//$result = CON::getAssoc($sql,$s);
			$matches_count = array_count_values($hashes);
			foreach ($matches_count as $word => $num) {
				$result = CON::getRow($sql,$word);
				if (count($result)==1) {
					CON::update('trending_toping',"day = CURDATE(), count = IF(day = CURDATE(), count + $num, 1)",'id = '.$result['id']);
				}else{
					CON::insert('trending_toping', "count = $num, day = CURDATE(), word = ?", array($word));
				}
			}
			return $matches_count;
		}
		return false;
	}else{
		$result = CON::getRow($sql,$s);
		if (count($result)==1) {
			CON::update('trending_toping','day = CURDATE(), count = IF(day = CURDATE(), count + 1, 1)','id =?',array($result['id']));
		}else{
			CON::insert('trending_toping', "day = CURDATE(), word =?",array($s));
		}
		return true;
	}

	return false;
}

function calculateProgress(){
	if ($_SESSION['ws-tags']['ws-user']['id']!=''){
		/*porcentaje del progreso del perfil*/
		$cant=0; $complete=0;$noFails=array();
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['name']) && $_SESSION['ws-tags']['ws-user']['name']!=''){ $complete++; $noFails['name']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['username']) && $_SESSION['ws-tags']['ws-user']['username']!=''){ $complete++; $noFails['uname']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['screen_name']) && $_SESSION['ws-tags']['ws-user']['screen_name']!=''){ $complete++; $noFails['sname']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['date_birth']) && $_SESSION['ws-tags']['ws-user']['date_birth']!=''){ $complete++; $noFails['dateb']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['personal_messages']) && $_SESSION['ws-tags']['ws-user']['personal_messages']!=''){ $complete++; $noFails['msg']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['profile_image_url']) && $_SESSION['ws-tags']['ws-user']['profile_image_url']!=''){ $complete++; $noFails['photo']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['country']) && $_SESSION['ws-tags']['ws-user']['country']!='' && $_SESSION['ws-tags']['ws-user']['country']!='0'){ $complete++; $noFails['country']=true;  }
		$cant++; if (isset($_SESSION['ws-tags']['ws-user']['city']) && $_SESSION['ws-tags']['ws-user']['city']!=''){ $complete++; $noFails['city']=true;  }
		if ($_SESSION['ws-tags']['ws-user']['type']!='1'){
			$cant++; if (isset($_SESSION['ws-tags']['ws-user']['last_name']) && $_SESSION['ws-tags']['ws-user']['last_name']!=''){ $complete++; $noFails['lname']=true;  }
			$cant++; if (isset($_SESSION['ws-tags']['ws-user']['sex']) && $_SESSION['ws-tags']['ws-user']['sex']!=''){ $complete++; $noFails['sex']=true;  }
			$cant++; if (isset($_SESSION['ws-tags']['ws-user']['interest']) && $_SESSION['ws-tags']['ws-user']['interest']!='' && $_SESSION['ws-tags']['ws-user']['interest']!=0){ $complete++; $noFails['interest']=true;  }
			$cant++; if (isset($_SESSION['ws-tags']['ws-user']['relationship']) && $_SESSION['ws-tags']['ws-user']['relationship']!='' && $_SESSION['ws-tags']['ws-user']['relationship']!=0){ $complete++; $noFails['relation']=true;  }	
			$cant++; if (isset($_SESSION['ws-tags']['ws-user']['wish_to']) && $_SESSION['ws-tags']['ws-user']['wish_to']!='' && $_SESSION['ws-tags']['ws-user']['wish_to']!=0){ $complete++; $noFails['wish']=true;  }	
		}
		//$cant++;  if (!isset($_SESSION['ws-tags']['ws-user']['']) && $_SESSION['ws-tags']['ws-user']['']!=''){ $complete++; $noFails['']=true;  }
		$porcentajePerfil=($complete*100)/$cant;
		/*porcentaje del progreso de las preferencias*/
		$complete=CON::getVal("	SELECT COUNT(id_preference) AS num
								FROM users_preferences
								WHERE id_user=? 
								AND preference!='' 
								AND preference IS NOT NULL;",array($_SESSION['ws-tags']['ws-user']['id']));
		if ($complete>0) $porcentajePrefe=($complete*100)/3;
		else $porcentajePrefe=0;
		return array('profile'=>$porcentajePerfil,'preferences'=>$porcentajePrefe,'noFails'=>$noFails);
	}else return false;
}
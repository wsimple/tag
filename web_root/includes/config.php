<?php
if(defined('__CF__')) return; else define('__CF__',1);
/*
 * Developed By:Websarrollo.com & Maoghost.com
 * Copy Rights :Tagamation, LLc
 * Date        :02/22/2011
 */
$tb_path=preg_replace('/([\/][^\/]*)$/','',dirname(str_replace('\\','/',__FILE__)));
@define('RELPATH',"$tb_path/");
if(!isset($config)) @include("$tb_path/.security/security.php");
if(!isset($config)) @include('security/security.php');
$config->relpath=$tb_path;

global $section,$params;
#con secciones se permite manejar parametros en url (ejem: user/preferences)
if(isset($_GET['hashtag'])){#si se convirtio un hashtag en get
	if(@$_COOKIE['_DEBUG_']=='section') echo 'GET hashtag:'.$_GET['hashtag'].'<br>';
	$section='/'.$_GET['hashtag'];
	unset($_GET['hashtag']);
	if(strpos($section,'?'))
		$_GET=array_merge($_GET,parse_url(end(explode('?',$section))));
}else{
	$section=array_shift(explode('?',$_SERVER['REQUEST_URI']));
	if(strpos($section,'.php')) $section=str_replace($_SERVER['SCRIPT_NAME'],'',$section);
	elseif(strpos($section,$config->base_url)===0) $section=substr($section,strlen($config->base_url));
}
if($section==''){
	$section='home';
	$params=array();
}else{
	while(substr($section,0,1)=='/') $section=substr($section,1);
	$params=explode('/',$section);
	$section=array_shift($params);
}
if(@$_COOKIE['_DEBUG_']=='section') echo "section:$section - params:".implode(',',$params);
// echo '<pre>';print_r($config);echo '</pre>';die();

if($config){
	define('LOCAL',$config->local);
	define('HOST',$config->db->host);
	define('USER',$config->db->user);
	define('PASS',$config->db->pass);
	define('DATA',$config->db->data);
	if(isset($config->ftp)){
		define('NOFTP',false);
		define('FTPSERVER',$config->ftp->host);
		define('FTPACCOUNT',$config->ftp->user);
		define('FTPPASS',$config->ftp->pass);
	}else{
		define('NOFTP',true);
	}
	define('PATH_SITE',$config->path);//ruta de la carpeta de trabajo
	define('DOMINIO',$config->dominio);
	define('DOMINIOSTORE',$config->dominio);
	define('FILESERVER',$config->local?RELPATH:$config->img_server);
}else{
	die('Not configured server.');
}

#Configuración de variables principales del sitio
define('DIRECTORIO','/');
define('CARPETA_ADMIN','wpanel/');
define('RETARDOLOGINREGISTRO',0);
define('SANDBOX','');

#configuraciones de servidor
$_prod=$_SERVER['SERVER_NAME'];//Nombre del dominio principal
//lista de carpetas de sistema
$_folders=array(
	'app',
	'controls',
	'img',
	'imgs',
	'includes',
	'wpanel',
	'wpruebas'
);
$_name=$_SERVER['SERVER_NAME'];
$_path='/';
if(preg_match('/^(local\.|localhost|127\.\d\.\d\.\d|192\.168(\.\d{1,3}){2})/',$_name)){
	$_path=$_local;
	$_site=$_name.$_local;
	$_fserver='';//fileserver para uso local
	//$_fserver='local/fileserver/';//fileserver para uso local
}else{
	//si es produccion
	if(preg_match('/seemytag\.com$/',$_name)) $_prod='seemytag.com';
	$_site=$_prod.$_path;
}

define('PRODUCCION',$_prod);//Nombre del dominio principal
define('PATH',$_SERVER['DOCUMENT_ROOT'].$_path);//ruta de la carpeta de trabajo
//ruta relativa a la carpeta raiz dentro de $_path

#dimensiones de la tag
define('TAGWIDTH',650);
define('TAGHEIGHT',300);

#dimensiones de la imagen para la tag para resoluciones mayores
define('TAGWIDTHHD',1200);
define('TAGHEIGHTHD',round((TAGWIDTHHD/TAGWIDTH)*TAGHEIGHT));

if(!$config->local){
	define('SHOWNOTIFIXTMP',1);//temporal para controlar la muestra de notitificaciones
}
// with_session(function(&$sesion){ $sesion['ws-tags']['developer']=true; });
unset($_pruebas,$_site,$_path,$_sec,$_url,$_prod,$tmp);
define('PAYPAL_PAYMENTS',false);

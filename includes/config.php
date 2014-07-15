<?php
/*
 * Developed By:Websarrollo.com & Maoghost.com
 * Copy Rights :Tagamation, LLc
 * Date        :02/22/2011
 */
	#Configuración principal del sitio
	define('TITLE','Tagbum.com - It\'s Time');
	define('HREF_DEFAULT','javascript:void(0);');
	define('DIRECTORIO','/');
	define('CARPETA_ADMIN','wpanel/');
	define('EMAIL_CONTACTO','contact@Seemytag.com');
	define('EMAIL_NO_RESPONDA','noreply@Seemytag.com');
	define('PERSONA_CONTACTO','The team Tagbum');
	define('RETARDOLOGINREGISTRO',0);
	define('SANDBOX','');
	define('COPYFOOTER','<strong>&copy; 2011 - '.date('Y').' Tagamation</strong>, LLC Patent Pending');

	#Configuración de metas de la pagina principal
	define('COPYRIGHT','Tagamation, LLc');
	define('AUTHOR','Websarrollo.com, Maoghost.com');
	define('DESCRIPTION','Seemytag is the right site to share information, ideas, opinions and thoughts, using short texts, pictures and videos; A multimedia social network, where you can express what you think at the speed of your imagination.');
	define('KEYWORDS','Winning,place for U,I\'ts time to winning,tag,tags,imagination,oftag,urtag,yourtag,geturtag,play,game,business,personal');

	#configuraciones de servidor
	$_prod=$_SERVER['SERVER_NAME'];//Nombre del dominio principal
	$_pruebas='/wpruebas/';//Carpeta de pruebas
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
	$_url=array_shift(explode('?',$_SERVER['REQUEST_URI']));
	$_path='/';
	if(preg_match('/^(localhost|127\.\d\.\d\.\d|192\.168(\.\d{1,3}){2})/',$_name)){
		//si es local
		if(preg_match('/^\/[^\/]+\//',$_url,$_local))
			$_local=$_local[0];
		else
			$_local='/tagbum/';
		$_path=$_local;
		$_site=$_name.$_local;
		$_fserver='';//fileserver para uso local
		//$_fserver='local/fileserver/';//fileserver para uso local
	}else{
		//si es produccion
		if(preg_match('/seemytag\.com$/',$_name)) $_prod='seemytag.com';
		if(strpos(' '.$_url,$_pruebas)) $_path=$_pruebas;
		$_site=$_prod.$_path;
	}
	//redireccionamos si comienza con www
	if(strpos(' '.$_name,'www.')) die('<meta HTTP-EQUIV="REFRESH" content="0;url=http://'.$_site.'">');
	//removemos el ultimo slash si no es una carpeta valida (para evaluarlo como nombre de usuario)
	if(	$_name==$_prod&&
		$_url!='/'&&substr($_url,-1)=='/'&&
		!in_array(current(explode('/',substr($_url,1,-1))),$_folders)
	)	die('<meta HTTP-EQUIV="REFRESH" content="0;url='.substr($_url,0,-1).'">');

	define('PRODUCCION',$_prod);//Nombre del dominio principal
	define('DOMINIO','http://'.$_site);
	define('DOMINIOSTORE',DOMINIO);
	define('PATH',$_SERVER['DOCUMENT_ROOT'].$_path);//ruta de la carpeta de trabajo
	//ruta relativa a la carpeta raiz dentro de $_path
	define('RELPATH',str_repeat('../',substr_count(substr($_url,strlen($_path)),'/')));

	#dimensiones de la tag
	define('TAGWIDTH',650);
	define('TAGHEIGHT',300);

	//definicion de variables que difieren entre produccion y local
	@include(RELPATH.'.security/security.php');
	// echo '<pre>';print_r($config);echo '</pre>';die();
	if($config){
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
		define('FILESERVER','http://'.($config->imgserver?$config->imgserver.'/':$_site.$_fserver));
	}else{
		die('Not configured server.');
	}
	if(in_array($_name,array(PRODUCCION,'64.15.140.154'))||$_cronjob){
		define('HOST','localhost');
		define('LOCAL',false);
		define('NOFPT',false);
		// define('FTPSERVER','10.4.23.10');
		define('SHOWNOTIFIXTMP',1);//temporal para controlar la muestra de notitificaciones
		@include(RELPATH.'.security/security.php');
		// if($_sec!=''){
		// 	$_sec=json_decode(base64_decode(base64_decode(base64_decode($_sec))),true);
		// 	foreach($_sec as $key=>$val) define($key,$val);
		// }
	}else{
		define('HOST','localhost');
		define('LOCAL',true);
		define('NOFPT',true);
		define('USER','root');
		define('PASS','root');
		define('DATA','tagbum');
	}
	$_SESSION['ws-tags']['developer']=true;
	unset($_pruebas,$_site,$_path,$_sec,$_url,$_prod);
	define('PAYPAL_PAYMENTS', false);
?>

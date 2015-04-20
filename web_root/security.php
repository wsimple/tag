<?php
if(!isset($_COOKIE['_DEBUG_'])&&preg_match('/security\.php/',$_SERVER['SCRIPT_NAME'])) die();
$security='security'.(preg_match('/security\.php/',$_SERVER['SCRIPT_NAME'])?'.php':'');
?>
<h1>Generador de archivo de seguridad</h1>
se requiere su ejecucion para acceso a la base de datos.<br/>
<?=$_GET['tipo']?(!is_file('includes/security/security.php')?'No hay configuracion de base de datos.':'Modificar configuracion de base de datos').'<br/>':''?>
<?php
if(!is_file('includes/security/security.php')||isset($_GET['help'])){
$show=isset($_COOKIE['_DEBUG_'])?'&show':'';
?>
<hr/>
<h2>Acceso rapido</h2>
<?php if($show){ ?><p><a href="<?php echo $security; ?>?show">Solo ver datos actuales.</a></p><?php } ?>
<p><a href="<?php echo $security; ?>?tipo=local<?php echo $show;?>">Equipo Local</a></p>
<p><a href="<?php echo $security; ?>?tipo=aws&code<?php echo $show;?>">Servidor AWS</a></p>
<p><a href="<?php echo $security; ?>?tipo=aws&temp<?php echo $show;?>">Servidor AWS (temp)</a></p>
<p><a href="<?php echo $security; ?>?tipo=main&code<?php echo $show;?>">Servidor Principal</a></p>
<hr/>
<?php if($show){ ?>
<h2>Guia detallada:</h2>
Se debe llamar con los siguientes parametros:<br/><br/>
<p><b>help</b>: muestra esta ayuda</p>
<p><b>tipo</b>: debe ser local, main (servidor principal), o sec (servidores secundarios).</p>
<p><b>code</b>: codifica los datos generados para que no sean lejibles</p>
<p><b>show</b>: mostrar los datos generados (si se omite tipo, se muestran los datos actuales)</p>
<p><b>access</b>: activa llamado con archivo .php, valor por default tb.php (en caso de que no funcione con htaccess)</p>
<br/>
<?php }//if show
}//help

$data=new stdClass();
if($_GET['tipo']!='') $data->tipo=$_GET['tipo'];
elseif(isset($_GET['main'])) $data->tipo='main';
elseif(isset($_GET['sec'])) $data->tipo='sec';
elseif(isset($_GET['local'])) $data->tipo='local';

$data->site_name='Tagbum';
if($data->tipo){
	$data->local=($data->tipo=='local');
	if(isset($_GET['access'])) $data->access=($_GET['access']==''?'tb.php':$_GET['access']).'/';
	#rutas de servidores
	$data->path=preg_replace('/[^\/]*$/i','',$_SERVER['SCRIPT_NAME']);
	$data->basedom='http://'.$_SERVER['SERVER_NAME'];
	$data->dominio=$data->basedom.$data->path;

	$relpath=str_replace('\\','/',dirname(__FILE__));
	$relpath=preg_replace('/(\/[^\/]+){2}$/','',$relpath);
	#tipos
	if($data->tipo=='main'||$data->tipo=='sec'){
		$data->base_url='/';
		$data->db['host']='tagbumdb-east.c8ncui6mei6z.us-east-1.rds.amazonaws.com';
		$data->db['user']='tagmaster';
		$data->db['pass']='-t4gvzlA_mysql';
		$data->db['data']='tagbumdb';
		$data->ftp['host']='192.168.57.16';
		$data->ftp['user']='userimg';
		$data->ftp['pass']='-t@gvzlA_ftp';
		$data->facebook['appId']='824519617598722';
		$data->facebook['secret']='9c8ec5500c2426a289e58f5bb61b7b3b';
		$data->paypal['user']='elijose.c-facilitator_api1.gmail.com';
		$data->paypal['pass']='1370289012';
		$data->paypal['signature']='AFcWxV21C7fd0v3bYYYRCpSSRl31AnHjJMUATq-eeXv1ffnS7Is.Qqg6';
		$data->paypal['endpoint']='https://api-3t.sandbox.paypal.com/nvp';
		$data->email['Port']=465;
		$data->email['Host']='mailtagbum.com';
		$data->email['Timeout']=10;
		$data->email['Username']='no-reply@mailtagbum.com';
		$data->email['Password']="Nepali13@!";
		$data->email['SMTPAuth']=true;

		$data->imgserver='http://68.109.244.201/';
		$data->main_server='http://tagbum.com/';
		$data->app_server='http://app.tagbum.com/';
		$data->img_server='http://i.tagbum.com/';
		$data->video_server='http://v.tagbum.com/';
		$data->img_server_path='http://192.168.57.16/';
		$data->video_server_path='http://192.168.57.11/';
		$data->allow_origin='/^https?:\\/\\/(\\\w+\\\.)?tagbum.com$/i';
	}elseif($data->tipo=='aws'){
		$data->base_url='/';
		$data->db['host']='tagbumdb-east.c8ncui6mei6z.us-east-1.rds.amazonaws.com';
		$data->db['user']='tagmaster';
		$data->db['pass']='-t4gvzlA_mysql';
		$data->db['data']='tagbumdb';
		#ftp (servidor de imagenes)
		$data->ftp['host']='172.31.45.136';
		$data->ftp['user']='webapp';
		$data->ftp['pass']='-t@gvzlA_ftp';
		$data->ftp['folder']='img';

		#rutas de acceso entre servidores (local)
		$data->video_server_path='http://172.31.40.43/';
		$data->img_server_path='http://172.31.45.136/';
		#rutas de acceso publico
		$data->main_server='http://tagbum.com/';
		$data->app_server='http://app.tagbum.com/';
		$data->img_server='http://i.tagbum.com/';
		$data->video_server='http://v.tagbum.com/';

		$data->facebook['appId']='824519617598722';
		$data->facebook['secret']='9c8ec5500c2426a289e58f5bb61b7b3b';
		$data->paypal['user']='elijose.c-facilitator_api1.gmail.com';
		$data->paypal['pass']='1370289012';
		$data->paypal['signature']='AFcWxV21C7fd0v3bYYYRCpSSRl31AnHjJMUATq-eeXv1ffnS7Is.Qqg6';
		$data->paypal['endpoint']='https://api-3t.sandbox.paypal.com/nvp';
		$data->email['Port']=465;
		$data->email['Host']='mailtagbum.com';
		$data->email['Timeout']=10;
		$data->email['Username']='no-reply@mailtagbum.com';
		$data->email['Password']="Nepali13@!";
		$data->email['SMTPAuth']=true;
		$data->allow_origin='/^https?:\\/\\/(\\\w+\\\.)?tagbum.com$/i';
	}elseif($data->tipo=='temp'){
		$data->base_url='/';
		$data->db['host']='tagbumdb-east.c8ncui6mei6z.us-east-1.rds.amazonaws.com';
		$data->db['user']='tagmaster';
		$data->db['pass']='-t4gvzlA_mysql';
		$data->db['data']='tagbumdb';
		#ftp (servidor de imagenes)
		$data->ftp['host']='172.31.45.136';
		$data->ftp['user']='webapp';
		$data->ftp['pass']='-t@gvzlA_ftp';
		$data->ftp['folder']='img';

		#rutas de acceso entre servidores (local)
		$data->video_server_path='http://172.31.40.43/';
		$data->img_server_path='http://172.31.45.136/';
		#rutas de acceso publico
		$data->main_server='http://temp.tagbum.com/';
		$data->app_server='http://app.tagbum.com/';
		$data->img_server='http://i.tagbum.com/';
		$data->video_server='http://v.tagbum.com/';

		$data->facebook['appId']='824519617598722';
		$data->facebook['secret']='9c8ec5500c2426a289e58f5bb61b7b3b';
		$data->paypal['user']='elijose.c-facilitator_api1.gmail.com';
		$data->paypal['pass']='1370289012';
		$data->paypal['signature']='AFcWxV21C7fd0v3bYYYRCpSSRl31AnHjJMUATq-eeXv1ffnS7Is.Qqg6';
		$data->paypal['endpoint']='https://api-3t.sandbox.paypal.com/nvp';
		$data->email['Port']=465;
		$data->email['Host']='mailtagbum.com';
		$data->email['Timeout']=10;
		$data->email['Username']='no-reply@mailtagbum.com';
		$data->email['Password']="Nepali13@!";
		$data->email['SMTPAuth']=true;
		$data->allow_origin='/^https?:\\/\\/(\\\w+\\\.)?tagbum.com$/i';
	}elseif($data->tipo=='local'){
		$data->base_url='/tag/';
		$data->dominio=$data->basedom.$data->base_url;

		$data->db['host']='localhost';
		$data->db['user']='root';
		$data->db['pass']='root';
		$data->db['data']='tagbum';
		$data->facebook['appId']='824519617598722';
		$data->facebook['secret']='9c8ec5500c2426a289e58f5bb61b7b3b';

		$data->imgserver=$data->dominio;
		$data->main_server=$data->dominio;
		$data->app_server=$data->basedom.$data->base_url.'app_server/';
		$data->img_server=$data->basedom.$data->base_url.'img_root/';
		$data->video_server=$data->basedom.$data->base_url.'video_root/';

		$data->img_server_path=$relpath.$data->base_url.'img_root/';
		$data->video_server_path=$relpath.$data->base_url.'video_root/';
		// $data->allow_origin='/^https?:\\/\\/(localhost|192\\\.168\\\.)/i';
	}
	$data->dominio=$data->basedom.$data->base_url;
	if($data->db){
		$tipo=$data->tipo;
		if(isset($_GET['code'])) //codifica los datos
			$data='json_decode(base64_decode(base64_decode(\''.base64_encode(base64_encode(json_encode($data))).'\')))';
		else //no codifica
			$data='json_decode(\''.json_encode($data).'\')';
		$txt="<?php //tipo=$tipo\nglobal \$config;\n\$config=$data;";
		echo "Instalando como tipo: $tipo<br/>";
		file_put_contents('.security/security.php',$txt);
	}
}

if(is_file('.security/security.php')){
	if($_GET['tipo']) echo 'instalado<br/>';
	include('.security/security.php');
	if(isset($_GET['show'])){
		echo '<br>security:<pre>';var_dump($config);echo '</pre>';
	}
}
die();
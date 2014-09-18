<?php
$security=preg_match('/security\.php/',$_SERVER['SCRIPT_NAME'])?'security.php':'security';
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
if($data->tipo){
	$data->local=($data->tipo=='local');
	if(isset($_GET['access'])) $data->access=($_GET['access']==''?'tb.php':$_GET['access']).'/';
	#rutas de servidores
	$data->path=preg_replace('/[^\/]*\/[^\/]*$/i','',$_SERVER['SCRIPT_NAME']);
	$data->basedom='http://'.$_SERVER['SERVER_NAME'];
	$data->dominio=$data->basedom.$data->path;
	#tipos
	if($data->tipo=='main'||$data->tipo=='sec'){
		$data->db['host']='192.168.57.15';
		$data->db['user']='uservzla200';
		$data->db['pass']='-t@gvzlA_mysql';
		$data->db['data']='tagbum200';
		$data->ftp['host']='192.168.57.16';
		$data->ftp['user']='userimg';
		$data->ftp['pass']='-t@gvzlA_ftp';
		$data->imgserver='http://68.109.244.201/';
		$data->img_server_path='http://192.168.57.16/';
		$data->video_server_path='http://192.168.57.11/';
		$data->img_server='//i.tagbum.com/';
		$data->video_server='//v.tagbum.com/';
		$data->allow_origin=array(
			'http://tagbum.com',
			'http://i.tagbum.com',
			'http://v.tagbum.com',
		);
	}elseif($data->tipo=='local'){
		$data->db['host']='localhost';
		$data->db['user']='root';
		$data->db['pass']='root';
		$data->db['data']='tagbum';
		$data->imgserver=$data->dominio;
		$data->img_server_path='img_server/';
		$data->video_server_path='video_server/';
		$data->img_server=$data->dominio.$data->img_server_path;
		$data->video_server=$data->dominio.$data->video_server_path;
	}
	if($data->db){
		$tipo=$data->tipo;
		if(isset($_GET['code'])) //codifica los datos
			$data='json_decode(base64_decode(base64_decode(\''.base64_encode(base64_encode(json_encode($data))).'\')))';
		else //no codifica
			$data='json_decode(\''.json_encode($data).'\')';
		$txt="<?php //tipo=$tipo\nglobal \$config;\n\$config=$data;";
		file_put_contents('includes/security/security.php',$txt);
		echo "Instalando como tipo: $tipo<br/>";
	}
}

if(is_file('includes/security/security.php')){
	if($_GET['tipo']) echo 'instalado<br/>';
	include('includes/security/security.php');
	if(isset($_GET['show'])){
		echo '<pre>';var_dump($config);echo '</pre>';
	}
}

<?=!is_file('includes/security/security.php')?'No hay configuracion de base de datos.':'Modificar configuracion de base de datos'?>
<br/>
<?php
if((!is_file('includes/security/security.php')&&!isset($_GET['generate']))||isset($_GET['help'])){ ?>
Generador de archivo de seguridad, se requiere su ejecucion para acceso a la base de datos.<br/>
Se debe llamar de la siguiente manera:<br/><br/>
<b><?=$_SERVER['SERVER_NAME'].preg_replace('/[a-z0-9_-\.]+\.php$/i','new.php',$_SERVER['SCRIPT_NAME'])?>?generate&security&tipo=xxx[&opciones]</b><br/><br/>
<h2>Opciones:</h2>
<p><b>help</b>: muestra esta ayuda</p>
<p><b>tipo</b>: debe ser local, main (servidor principal), o sec (servidores secundarios). Omitir si solo quiere mostrar los valores actuales.</p>
<p><b>code</b>: codifica los datos generados para que no sean lejibles</p>
<p><b>show</b>: mostrar datos generados</p>
<p><b>access</b>: activa llamado con archivo .php, valor por default tb.php (si no hay htaccess)</p>
<br/>
<?php if(preg_match('/^(local|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){ ?>
<h2>Default:</h2>
<p><b>solo ver ayuda: new.php?generate&security&help</b></p>
<p><b>local: new.php?generate&security&tipo=local&show</b></p>
<p><b>local(sin htaccess): new.php?generate&security&tipo=local&show&access</b></p>
<p><b>servidor principal: new.php?generate&security&tipo=main&code&show</b></p>
<?php }//end default ?>
<?php
}

$data=array();
if($_GET['tipo']!='') $data['tipo']=$_GET['tipo'];
elseif(isset($_GET['main'])) $data['tipo']='main';
elseif(isset($_GET['sec'])) $data['tipo']='sec';
elseif(isset($_GET['local'])) $data['tipo']='local';
if($data['tipo']){
	$data['local']=($data['tipo']=='local');
	if(isset($_GET['access'])) $data['access']=($_GET['access']==''?'tb.php':$_GET['access']).'/';
	#rutas de servidores
	$data['path']=preg_replace('/[^\/]+\.php$/i','',$_SERVER['SCRIPT_NAME']);
	$data['basedom']='http://'.$_SERVER['SERVER_NAME'];
	$data['dominio']=$data['basedom'].$data['path'];
	$data['baseurl']=($data['access']?$data['access']:'');
	#tipos
	if($data['tipo']=='main'||$data['tipo']=='sec'){
		$data['db']['host']='192.168.57.15';
		$data['db']['user']='uservzla200';
		$data['db']['pass']='-t@gvzlA_mysql';
		$data['db']['data']='tagbum200';
		$data['ftp']['host']='192.168.57.16';
		$data['ftp']['user']='userimg';
		$data['ftp']['pass']='-t@gvzlA_ftp';
		$data['imgserver']='http://68.109.244.201/';
	}elseif($data['tipo']=='local'){
		$data['db']['host']='localhost';
		$data['db']['user']='root';
		$data['db']['pass']='root';
		$data['db']['data']='tagbum';
		$data['imgserver']=$data['dominio'];
	}
	if($data['db']){
		$tipo=$data['tipo'];
		if(isset($_GET['code'])) //codifica los datos
			$data='json_decode(base64_decode(base64_decode(\''.base64_encode(base64_encode(json_encode($data))).'\')))';
		else //no codifica
			$data='json_decode(\''.json_encode($data).'\')';
		$txt="<?php //tipo=$tipo\nglobal \$config;\n\$config=$data;";
		file_put_contents('includes/security/security.php',$txt);
		echo "Instalando como tipo: $tipo<br/>";
	}
}

No se ha configurado ninguna base de datos.<br/>
<?php
if(isset($_GET['help'])&&!$_GET['install']){ ?>
Para instalar los archivos de configuraci&oacute;n, si se requiere acceso a la base de datos.
<br/>
Se debe llamar al index de la siguiente manera:
<br/><br/>
<b><?=$_SERVER['SCRIPT_NAME']?>?tipo</b>
<br/><br/>
tipos: local, main (servidor principal), sec (servidores secundarios)
<?php
}elseif(count($_GET)>0){
	$config=array();
	if(!is_dir('.security')) mkdir('.security');
	#tipos
	if(isset($_GET['main'])){
		$tipo='main';
	}elseif(isset($_GET['sec'])){
		$tipo='sec';
		$config['db']['host']='192.168.57.15';
		$config['db']['user']='uservzla200';
		$config['db']['pass']='-t@gvzlA_mysql';
		$config['db']['data']='tagbum200';
		$config['ftp']['host']='192.168.57.16';
		$config['ftp']['user']='userimg';
		$config['ftp']['pass']='-t@gvzlA_ftp';
	}elseif(isset($_GET['local'])){
		$tipo='local';
	}
	$config['prueba']=$tipo;

	$txt="<?php //$tipo\n"
		.'$config=json_decode(base64_decode(base64_decode(\''.base64_encode(base64_encode(json_encode($config))).'\')));';
	file_put_contents('.security/security.php',$txt);
	echo 'Instalacion como tipo: '.$tipo;
}
<?=!is_dir('.security')&&!is_file('.security/security.php')?'No hay configuracion de base de datos.':'Modificar configuracion de base de datos'?>
<br/>
<?php
if(isset($_GET['help'])){ ?>
Para instalar los archivos de configuracion, si se requiere acceso a la base de datos.<br/>
Se debe llamar al index de la siguiente manera:<br/><br/>
<b><?=$_SERVER['SCRIPT_NAME']?>?tipo</b><br/><br/>
tipos: local, main (servidor principal), sec (servidores secundarios)<br/>
<?php
}else{
	$tipo=false;
	$data=array();
	if(!is_dir('.security')) mkdir('.security');
	#tipos
	if(isset($_GET['main'])){
		$tipo='main';
	}elseif(isset($_GET['sec'])){
		$tipo='sec';
		$data['path']='/';
		$data['db']['host']='192.168.57.15';
		// $data['db']['host']='68.109.244.200';//ip externo
		$data['db']['user']='uservzla200';
		$data['db']['pass']='-t@gvzlA_mysql';
		$data['db']['data']='tagbum200';
		$data['ftp']['host']='192.168.57.16';
		$data['ftp']['user']='userimg';
		$data['ftp']['pass']='-t@gvzlA_ftp';
		$data['imgserver']='http://68.109.244.201/';
	}elseif(isset($_GET['local'])){
		$tipo='local';
		$data['path']='/tag/';
		$data['db']['host']='localhost';
		$data['db']['user']='root';
		$data['db']['pass']='root';
		$data['db']['data']='tagbum';
	}
	if($tipo){
		$data['tipo']=$tipo;
		if(isset($_GET['comp'])) //compress
			$data='json_decode(base64_decode(base64_decode(\''.base64_encode(base64_encode(json_encode($data))).'\')))';
		else //no compress
			$data='json_decode(\''.json_encode($data).'\')';

		$txt="<?php //$tipo\n\$config=$data;";
		echo 'Instalando como tipo: '.$tipo.'<br/>';
		file_put_contents('.security/security.php',$txt);
	}
}
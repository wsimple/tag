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
	$data=array();
	if($_GET['tipo']!='') $data['tipo']=$_GET['tipo'];
	elseif(isset($_GET['main'])) $data['tipo']='main';
	elseif(isset($_GET['sec'])) $data['tipo']='sec';
	elseif(isset($_GET['local'])) $data['tipo']='local';
	if(!is_dir('.security')) mkdir('.security');
	#tipos
	if($data['tipo']=='main'){
	}elseif($data['tipo']=='sec'){
		$data['path']='/';
		$data['db']['host']='192.168.57.15';
		$data['db']['user']='uservzla200';
		$data['db']['pass']='-t@gvzlA_mysql';
		$data['db']['data']='tagbum200';
		$data['ftp']['host']='192.168.57.16';
		$data['ftp']['user']='userimg';
		$data['ftp']['pass']='-t@gvzlA_ftp';
		$data['imgserver']='http://68.109.244.201/';
	}elseif($data['tipo']=='local'){
		$data['path']='/tag/';
		$data['db']['host']='localhost';
		$data['db']['user']='root';
		$data['db']['pass']='root';
		$data['db']['data']='tagbum';
	}
	if($data['tipo']){
		$data['local']=($data['tipo']=='local');
		$tipo=$data['tipo'];
		if(isset($_GET['comp'])) //compress
			$data='json_decode(base64_decode(base64_decode(\''.base64_encode(base64_encode(json_encode($data))).'\')))';
		else //no compress
			$data='json_decode(\''.json_encode($data).'\')';

		$txt="<?php //tipo=$tipo\n\$config=$data;";
		file_put_contents('.security/security.php',$txt);
		echo "Instalando como tipo: $tipo<br/>";
	}
}
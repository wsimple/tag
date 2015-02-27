<?php
#definicion de RELPATH (ruta relativa de la pagina) y carga de config
if($config){
	$numfolders=substr_count($_SERVER['SCRIPT_NAME'],'/')-substr_count($config->path,'/');
}else{
	$numfolders=substr_count($_SERVER['SCRIPT_NAME'],'/')-1;
	if(preg_match('/^(local|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){
		$numfolders-=2;
	}
}
if($numfolders<1) $relpath='./';
else $relpath=str_repeat('../',$numfolders);
if($_COOKIE['_DEBUG_']=='relpath') echo 'relpath='.$relpath.'<br>';
define('RELPATH',$relpath?$relpath:'./');
unset($numfolders);

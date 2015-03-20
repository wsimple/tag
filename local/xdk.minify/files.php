<?php
/*
 * este archivo agarra todos los archivos php de app
 * y los transforma en html dentro de la carpeta local.
 * Tambien se realiza una limpieza de espacios para reducir de tamaño los archivos.
 */
$path_in='../../../app_root/';
function clean_spaces($match){
	return $match[1];
}
$files=array();
if($handle=opendir($path_in)){
	while(($entry=readdir($handle))!==false){
		if(strpos($entry,'.php')&&$entry!=basename(__FILE__)){
			$files[]=$entry;
		}
	}
	closedir($handle);
}
die(json_encode($files));
?>

<?php
require 'relpath.php';
require 'JSMin.php';
/*
 * este archivo carga todos los archivos js indicados y genera un solo archivo minimizado.
 */
$main_path=$relpath.'app/js/';
$dev_path="js-dev/";
$output_path='../xdk/';
$output_file=$output_path.'js/min.js';

$files=array(
	$dev_path.'path.js',
	$dev_path.'console.js',
	$dev_path.'app.js',
	$dev_path.'device.js',
	'base.js',
	'funciones.js'
);
$data='';
//$f_out=$dev_path.'min.js';
foreach($files as $fn){
	$file=(strpos($fn,$dev_path)!==false?'':$main_path).$fn;
	$tmp=file_get_contents($file);
	if($tmp!==false){
		echo "File $file readed.<br/>";
		$tmp=JSMin::minify($tmp);
//		$tmp=preg_replace('/\/\/.*\n/','',$tmp);
//		$tmp=preg_replace('/\/\*(.|\n)*\*\//','',$tmp);
		$data.=$tmp;
	}else
		echo "File $file not readed.<br/>";
}

$not=!$data||!file_put_contents($output_file,$data)?'not':'';
echo "<hr/>File $output_file $not saved.<hr/>";

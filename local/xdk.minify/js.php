<?php
// require 'relpath.php';
require 'JSMin.php';
/*
 * este archivo carga todos los archivos js indicados y genera un solo archivo minimizado.
 */

$app_path='http://'.$_SERVER['SERVER_NAME'].'/tag/app_root';
$output_path='../xdk';
$output_file="$output_path/js/min.js";

$data=file_get_contents("$app_path/js/min.js?minify&xdk");
if($data){
	echo "File $file readed.<br/>";
	$data=JSMin::minify($data);
}else
	echo "File $file not readed.<br/>";

$not=!$data||!file_put_contents($output_file,$data)?'not':'';
echo "<hr/>File $output_file $not saved.<hr/>";

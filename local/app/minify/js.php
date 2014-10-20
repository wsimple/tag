<?php
/*
 * este archivo agarra todos los archivos js indicados y genera un solo archivo minimizado.
 */
//if(isset($_GET['type'])) $type=$_GET['type']; else die();
$type='dev';

$path_in='../../../app/js/';
$path_out='../js-'.$type.'/';

	require 'JSMin.php';
	$files=array(
		$path_out.'path.js',
		$path_out.'console.js',
		$path_out.'app.js',
		$path_out.'device.js',
		'base.js',
		'funciones.js'
	);
	$data='';
//	$f_out=$path_out.'min.js';
	foreach($files as $fn){
		$file=(strpos($fn,$path_out)!==false?'':$path_in).$fn;
		$tmp=file_get_contents($file);
		if($tmp!==false){
			echo 'File '.$file.' readed.<br/>';
			$tmp=JSMin::minify($tmp);
//			$tmp=preg_replace('/\/\/.*\n/','',$tmp);
//			$tmp=preg_replace('/\/\*(.|\n)*\*\//','',$tmp);
			$data.=$tmp;
		}else
			echo 'File '.$file.' not readed.<br/>';
	}
	$f_out=array('../js/min.js','../../steroids/www/js/min.js');
	foreach($f_out as $path){
		if($data!=''&&file_put_contents($path,$data))
			echo '<hr/>File '.$path.' saved.<hr/>';
		else
			echo '<hr/>File '.$path.' not saved<hr/>.';
	}
?>

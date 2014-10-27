<?php
/*
 * este archivo agarra todos los archivos php de app
 * y los transforma en html dentro de la carpeta local.
 * Tambien se realiza una limpieza de espacios para reducir de tamaño los archivos.
 */
//function clean_spaces($match){
//	return $match[1];
//}
function generatefile($in,$out,$file){
	$data=file_get_contents($in);
	if($data!==false){
		$old=@file_get_contents($out);
		if(isset($_GET['nolog'])) $data=preg_replace('/\s*console\.log\(.*\);\s*/','',$data);
		$data=preg_replace("/[ \t]*\n[ \t]*/","\n",$data);
		$data=preg_replace('/[ \t]+/',' ',$data);
//		$data=preg_replace_callback('/(\\<script[^>]*>)((.*\\n)*)(\\<\\/script>)/','clean_spaces',$data);
		echo 'Archivo '.$file.' leido.<br/>';
		if($old&&$old==$data)
			echo 'Archivo '.$out.' no tiene cambios.<hr/>';
		elseif(file_put_contents($out,$data))
			echo 'Archivo '.$out.' guardado.<hr/>';
		else
			echo 'Archivo '.$out.' no pudo ser guardado.<hr/>';
	}else
		echo 'Archivo '.$file.' no pudo ser leido.<hr/>';
}

$input_path='http://'.$_SERVER['SERVER_NAME'].'/tag/app/';
$output_path='../xdk/';
$file=$_GET['file'];
if($file){
	$file2=preg_replace('/\.php/','.html',$file);
	#generamos minify para app de cordova (normal)
	generatefile($input_path.$file.'?minify',$output_path.$file2,$file);
}
?>

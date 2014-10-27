<?php
/*
 * este archivo agarra todos los archivos js y genera un solo archivo minimizado.
 */
require '../inc/JSMin.php';
$path='http://'.$_SERVER['SERVER_NAME'].'/seemytag/app/js/';
//$files=array();
//if($handle=opendir('.')){
//	while(($entry=readdir($handle))!==false){
//		if(strpos($entry,'.js')&&$entry!=basename(__FILE__)){
//			$files[]=$entry;
//		}
//	}
//	closedir($handle);
//}
//echo "Directory handle: $handle\n<br>";
//echo "This: ".basename(__FILE__)."\n<br>";
//echo "Entries:".count($files)."\n<br>\n<br>";
$files=array(
	"md5.js",
	"console.js",
	"const.js",
	"cordova.js",
	"app.cordova.js",
	"jquery-1.10.2.min.js",
	"jquery.cookie.js",
	"jquery.local.js",
	"device.js",
	"path.js",
	"base.js",
	"jquery.mobile-1.3.2.js",
	"jquery.form.js",
	"jquery.textCounter.js",
	"jquery.Jcrop.js",
	"iScroll.js",
	"jScroll.js",
	"farbtastic.js",
	"colorPicker/colorPicker.js",
	"funciones.js"
);
$data='';
$f_out='min.js';
for($i=0;$i<count($files);$i++){
//	echo $files[$i]."\n<br>";
	$fn=$files[$i];
	$f_in=$path.$fn;
//	$f=fopen($f_in,'r');
//	while(!feof($f)) $data.=fread($f,1024*1024); 
//	fclose($f);
	$data=file_get_contents($fn);
	echo 'File '.$fn.' readed.<br/>';
//	$data=preg_replace('/[ \t]+/',' ',$data);
//	$data=preg_replace_callback('/(\\<script[^>]*>)((.*\\n)*)(\\<\\/script>)/','clean_spaces',$data);
//	echo $data;
}
$data=JSMin::minify($data);
$f=fopen($f_out,'w');
fwrite($f,$data);
fclose($f);
echo '<hr/>File '.$f_out.' saved.';
?>

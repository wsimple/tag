<?php 
include('includes/config.php');
include('includes/functions.php');
include('class/wconecta.class.php');

$languageList=array('en','es');
foreach($languageList as $code){
	$list=CON::getObject("SELECT DISTINCT tt.label, IFNULL(tr.text,tt.text) as `text` FROM translations_template tt LEFT JOIN translations tr ON tr.label=tt.label AND tr.cod='$code'");
	$lang=array();
	foreach($list as $el){
		$lang[$el->label]=preg_replace('/[\r\n]+/',' ',utf8_encode($el->text));
	}
	$lang=array_merge(array('langcode'=>$code),$lang);
	$lang['langcode']=$code;

	$json=json_encode($lang);
	$json=preg_replace('/\\\\u([\d\w]{4})/','&#x$1;',$json);

	#lenguajes en php
	$array=str_replace('":"','"=>"',substr($json, 1, -1));
	$array=str_replace('\\/','/',$array);
	$salida=<<<PHPLANG
<?php
\$lang=array($array);
function lan(\$text='',\$format=false){
	return (isset(\$lang[\$text])?\$lang[\$text]:\$text);
}
PHPLANG;
	file_put_contents("language/$code.php", $salida);

	#lenguajes en js
	$array=array();
	$array['langcode']=$code;
	foreach($lang as $key => $val){
		if(substr($key,0,3)=='JS_'){
			$array[$key]=utf8_encode($val);
		}
	}
	$json=json_encode($array);//comentar para poner TODAS las traducciones en js
	$salida=<<<JSLANG
var lang=$json;
function lan(txt){ return (lang&&lang[txt]||txt||'');}
JSLANG;
	file_put_contents("js/language_$code.js",$salida);

	#funciones en js
	ob_start();
	include("js/funciones.js.php");
	$data=ob_get_contents();
	ob_end_clean();
	file_put_contents("js/funciones_$code.js",trim($data));
}

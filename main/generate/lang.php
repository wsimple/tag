<?php 
include('includes/config.php');
include('includes/functions.php');
include('class/wconecta.class.php');

// function noLineBreak($str){
// 	return preg_replace('/[\r\n]+/',' ', $str);
// }

$languageList=array('en','es');
foreach($languageList as $code){
	$plantillas=CON::query('SELECT id_lenguage,label,text,text_help FROM translations_template');
	$lang=array();
	while($plantilla=CON::fetchObject($plantillas)){
		//verificamos si el lenguaje tiene traduccion
		$lenguajes=CON::query("SELECT label,text,text_help FROM translations WHERE cod='$code' AND label LIKE '$plantilla->label'");
		//si no hay traduccion
		if(CON::numRows($lenguajes)==0){ 
			$lang[$plantilla->label]=noLineBreak($plantilla->text);
		}else{//si hay traduccion
			$lenguaje=CON::fetchObject($lenguajes);//traducciones
			$lang[$lenguaje->label]=noLineBreak($lenguaje->text);
		}
	}

	#lenguajes en php
	$json=json_encode($lang);
	$salida=<<<PHPLAN
<?php
	\$lang=json_decode('$json',true);
PHPLAN;
	// $array=str_replace('":"','"=>"',htmlentities(substr($json, 1, -1),ENT_NOQUOTES));
	$array=str_replace('":"','"=>"',substr($json, 1, -1));
	$array=preg_replace('/\\\\u([\d\w]{4})/','&#x$1;',$array);
	$array=str_replace('<\\/','</',$array);
	$salida=<<<PHPLAN
<?php
\$lang=array($array);
PHPLAN;
	file_put_contents("language/$code.php", $salida);

	#lenguajes en js
	$array=array();
	foreach($lang as $key => $val){
		if(substr($key,0,3)=='JS_'){
			$array[$key]=utf8_encode($val);
		}
	}
	$json=json_encode($array);//comentar para poner TODAS las traducciones en js
	$salida=<<<JSLAN
var lang=$json;
function lan(txt){ return (lang&&lang[txt]||txt||'');}
JSLAN;
	file_put_contents("js/language_$code.js", $salida);
	ob_start();
	require "js/funciones.js.php";
	$data=ob_get_contents();
	ob_end_clean();
	file_put_contents("js/funciones_$code.js",trim($data));
}

<?php 
include('includes/config.php');
include('class/wconecta.class.php');

function noLineBreak($str){
	return preg_replace('/[\r\n]+/',' ', $str);
}

$languageList=array('en','es');
foreach($languageList as $code){
	$plantillas=CON::query('SELECT id_lenguage,label,text,text_help FROM translations_template');
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
	\$lang=json_decode('$json');
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

}

 ?>
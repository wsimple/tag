<?php 

	include('includes/config.php');
	include('includes/functions.php');
	include('class/wconecta.class.php');

	$languagesArray=array('en','es');

	foreach ($languagesArray as $langCode) {
		$plantillas=CON::query('SELECT id_lenguage,label,text,text_help FROM translations_template');
		$txtLanguage='<?php $lang=array(';
		while($plantilla=CON::fetchAssoc($plantillas)){
			
			//verificamos si el lenguaje tiene traduccion

			$lenguajes=CON::query("SELECT label,text,text_help FROM translations WHERE cod='$langCode' AND label LIKE '".$plantilla['label']."'");
			//si no hay traduccion
			if(CON::numRows($lenguajes)==0){ 
				$lang[$plantilla['label']]=noLineBreak($plantilla['text']);
			}else{//si hay traduccion

				$lenguaje=CON::fetchAssoc($lenguajes);//traducciones
				$lang[$lenguaje['label']]=noLineBreak($lenguaje['text']);
				
			}
		}
		$txtLanguage.=str_replace('":"','"=>"',substr(json_encode($lang), 1, -1).");");
		////////Lang js//////
		file_put_contents("language/$langCode.php", $txtLanguage);
		file_put_contents("js/language_$langCode.js", require "js/language.js.php");
		////////////////////

	}

 ?>
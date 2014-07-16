<?php
	//si llego el lenguaje y el usuario esta logueado
	if ($_SESSION['ws-tags']['ws-user']['language']!=''){
		$_SESSION['ws-tags']['language']=$_SESSION['ws-tags']['ws-user']['language'];
	}elseif($_POST['lang']!=''){
		$_SESSION['ws-tags']['language']=$_POST['lang'];
		@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
	}
	$lang=array();
	//detecta el idioma segun la ip del usuario si no esta logeado
	if($_GET['lang']==''&&empty($_SESSION['ws-tags']['language'])){
		if(LOCAL){
			$_SESSION['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}else{
			$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
			$locale=CON::getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
			$_SESSION['ws-tags']['language']=$locale;
		}
		if($_SESSION['ws-tags']['language']=='') $_SESSION['ws-tags']['language']='en';
	}
	$plantillas=CON::query('SELECT id_lenguage,label,text,text_help FROM translations_template');
	while($plantilla=CON::fetchAssoc($plantillas)){
		//verificamos si el lenguaje tiene traduccion
		$lenguajes=CON::query('SELECT label,text,text_help FROM translations WHERE cod=? AND label LIKE ?',
			array($_SESSION['ws-tags']['language'],$plantilla['label']));
		//si no hay traduccion
		if(CON::numRows($lenguajes)==0){
			if($_SESSION['ws-tags']['ws-user']['logins_count']<4&&trim($plantilla['text_help'])!=''){
				$lang[$plantilla['label']]=noLineBreak($plantilla['text_help']);
				define($plantilla['label'],noLineBreak($plantilla['text_help']));
			}else{
				$lang[$plantilla['label']]=noLineBreak($plantilla['text']);
				define($plantilla['label'],noLineBreak($plantilla['text']));
			}
		}else{//si hay traduccion
			$lenguaje=CON::fetchAssoc($lenguajes);//traducciones
			if ($_SESSION['ws-tags']['ws-user']['logins_count']<4&&trim($lenguaje['text_help'])!=''){
				$lang[$lenguaje['label']]=noLineBreak($lenguaje['text_help']);
				define($lenguaje['label'],noLineBreak($lenguaje['text_help']));
				//echo $lenguaje['label'].' = '.noLineBreak($lenguaje['text_help']).'<br/>';
			}else{
				$lang[$lenguaje['label']]=noLineBreak($lenguaje['text']);
				define($lenguaje['label'],noLineBreak($lenguaje['text']));
				//echo $lenguaje['label'].' = '.noLineBreak($lenguaje['text']).'<br/>';
			}
		}
	}//while

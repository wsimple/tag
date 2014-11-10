<?php
# Libreria para manejo de lenguaje
class Lang_lib extends TAG_librarie{
	private $lang,$_code;
	function __construct($control=false){
		#lenguajes permitidos
		$languages=array('en','es');
		parent::__construct($control);
		#deteccion de lenguaje
		$actual='';
		if($_GET['lang']!=''){
			$actual=$_GET['lang'];
		}else{
			#si llego el lenguaje y el usuario esta logueado
			if ($_SESSION['ws-tags']['ws-user']['language']!=''){
				$_SESSION['ws-tags']['language']=$_SESSION['ws-tags']['ws-user']['language'];
			}elseif($_POST['lang']!=''){
				$_SESSION['ws-tags']['language']=$_POST['lang'];
				@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
			}
			#detecta el idioma segun la ip del usuario si no esta logeado
			if($_GET['lang']==''&&empty($_SESSION['ws-tags']['language'])){
				if(preg_match('/^(local\.|localhost|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){
					$_SESSION['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
				}else{
					$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
					$locale=$this->db->getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
					$_SESSION['ws-tags']['language']=$locale;
				}
			}
			$actual=$_SESSION['ws-tags']['language'];
		}
		#si el lenguaje no esta permitido, cargamos el ingles
		if(!in_array($actual,$languages)) $actual='en';
		$this->_code=$actual;
		#carga de traducciones
		$lang=array_merge(
			@include("main/lang/en.php"),
			@include("language/en.php")
		);
		if($actual!='en'){
			$lang=array_merge(
				$lang,
				@include("main/lang/$actual.php"),
				@include("language/$actual.php")
			);
		}
		$this->lang=$lang;
	}
	function code(){
		return $this->_code;
	}
	function get($text='',$format=false){
		return (isset($this->lang[$text])?$this->lang[$text]:$text);
	}
	function dump(){
		echo '<pre>';
		var_dump($this->lang);
		echo '</pre>';
	}
}

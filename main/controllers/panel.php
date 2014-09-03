<?php
class Panel extends TAG_controller{
	function __construct(){
		#validacion: si no esta en modo debug, se retorna error 404
		if(!$this->is_debug()) $this->error_view(404);
		if(!preg_match('/security/i',$_SERVER['REQUEST_URI'])) parent::__construct();
	}
	function __onload($params){
		#desactivamos los metodos para que vaya siempre al index
		$this->disable_methods();
	}
	function index($tipo='menu'){
		switch($tipo){
			case 'menu':
				echo '<br><p><a href="panel/language">Lenguaje</a></p>';
				echo '<p><a href="panel/security">Security</a></p>';
			break;
			case 'language':
				$this->language();
			break;
			case 'security':
				include('security.php');
			break;
			default:
				echo 'Invalid option.';
		}
	}
	function language(){
		if(isset($_GET['wpanel'])) header('Location: '.$this->setting->path.'wpanel/?successlang');
		echo 'Generando Lenguajes...';
		$languageList=array('en','es');
		foreach($languageList as $code){
			echo "<br>LANG: $code";
			$list=$this->db->getObject("SELECT DISTINCT tt.label, IFNULL(tr.text,tt.text) as `text` FROM translations_template tt LEFT JOIN translations tr ON tr.label=tt.label AND tr.cod='$code'");
			$lang=array();
			foreach($list as $el){
				$lang[$el->label]=preg_replace('/[\r\n]+/',' ',$el->text);
			}
			$lang=array_merge(array('langcode'=>$code),$lang);
			$lang['langcode']=$code;

			$json=json_encode($lang);
			$json=preg_replace('/\\\\u([\d\w]{4})/','&#x$1;',$json);

			#lenguajes en php
			$array=str_replace('":"','"=>"',substr($json, 1, -1));
			$array=str_replace(',"',",\n\"",$array);
			$array=str_replace('\\/','/',$array);
			$salida=<<<PHPLANG
<?php
global \$lang;
\$lang=array(

$array,

);
return \$lang;
PHPLANG;
			$file="language/$code.php";
			echo "<br>$file ".(file_put_contents($file,$salida)?'done':'fail');

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
			$file="js/language_$code.js";
			echo "<br>$file ".(file_put_contents($file,$salida)?'done':'fail');

			#funciones en js
			$salida=trim(file_get_contents($this->setting->dominio."js/funciones.js.php?lang=$code"));

			$file="js/funciones_$code.js";
			echo "<br>$file ".(file_put_contents($file,$salida)?'done':'fail');
		}
	}
}

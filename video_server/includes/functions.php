<?php
#accceso a base de datos
require_once('security/security.php');
require_once('TAG_db.php');

#verificacion de datos de usuario
class Client{
	private $_id='',$_code='',$db;
	function __construct($code=0){
		$this->db=new TAG_db();
		$usr=$this->db->getRowObject(
			'SELECT id_user,code,TIMEDIFF(now(),time) as timedif FROM activity_users
			WHERE code=? AND REMOTE_ADDR=? AND HTTP_USER_AGENT=? AND TIMEDIFF(now(),time)<"00:30:00"',
			array($code,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'])
		);
		if($usr&&$usr->code){
			$this->_id=$usr->id_user;
			$this->_code=$usr->code;
		}
	}
	function id(){ return $this->_id; }
	function code(){ return $this->_code; }
	function folder(){ return $this->_code?$this->_code.'/':''; }
}
global $client;
$client=new Client($_GET['code']);

#funciones
function json_headers($cors=false){
	header('Access-Control-Allow-Methods: POST, GET');
	if($cors){
		header('Access-Control-Allow-Origin: '.($cors!=''?$cors:'http://localhost'));
		header('Access-Control-Allow-Credentials: true');
	}
	header('Access-Control-Max-Age: 1000');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/'.(isset($_GET['callback'])?'javascript':'json'));
}

function jsonp($res,$callback=true){
	utf8_encode_all($res);
	$txt=json_encode($res);
	if(isset($_GET['callback'])&&$callback) $txt=$_GET['callback']."($txt)";
	return $txt;
}
function utf8_encode_all(&$var){
	if(is_string($var)&&is_ISO($var))
		$var=utf8_encode($var);
	elseif(is_array($var))
		foreach($var as $id=>&$value)
			utf8_encode_all($value);
	return $var;
}
function strcode($texto,$debug=false){#detecta el tipo de codificacion de una cadena (ASCII=1,UTF8=2,ISO-8859-1=3) (0=no string)
	if(!is_string($texto)) return 0;
	$c=0;
	$ascii=true;
	for($i=0;$i<strlen($texto);$i++){
		$byte=ord($texto[$i]);
		if($debug) echo $texto[$i].'='.$byte.'<br/>';
		if($c>0){
			if(($byte>>6)!=0x2){
				return 3;#ISO_8859_1;
			}else{
				$c--;
			}
		}elseif($byte&0x80){
			$ascii=false;
			if(($byte>>5)==0x6){
				$c=1;
			}elseif(($byte>>4)==0xE){
				$c=2;
			}elseif(($byte>>3)==0x1E){
				$c=3;
			}else{
				return 3;#ISO_8859_1;
			}
		}
	}
	return ($ascii)?1:2;#ASCII:UTF_8;
}
function is_ISO($texto){ return strcode($texto)==3; }
function is_UTF8($texto){ return strcode($texto)==2; }

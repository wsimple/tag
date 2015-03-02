<?php

class appUpload
{
	protected $usr;
	function __construct($initialize = true){
		$this->usr=new validateUser();
		if($initialize){
			$files=$this->files_upload();
			$this->json(array(
				'urls'=>$files,
				'user'=>$user,
				'cookies'=>$_COOKIE,
				'get'=>$_GET,
				'post'=>$_POST,
				'FILES'=>$_FILES,
				'sql'=>$db->lastSql(),
			));
		}
	}
	function files_upload($code=false){
		$files=array();
		if($code) $this->usr->valid_code_user(0,$code);
		if(!$this->usr->code()) return $files;
		if(count($_FILES)){
			foreach($_FILES as $file){
				if($file['error']==0&&rename($file['tmp_name'],"tmp/$myId-".$file['name'])){
					$files[]="tmp/$myId-".$file['name'];
				}
			}
		}
		return $files;
	}
	function json($data){
		header('Access-Control-Allow-Methods: POST, GET');
		header('Access-Control-Allow-Origin: http://localhost');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 1000');
		//header('Access-Control-Max-Age: 86400');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/'.(isset($_GET['callback'])?'javascript':'json'));
		$_head=array();
		if(!function_exists('apache_request_headers')){
			function apache_request_headers(){
				$arh=array();
				$rx_http='/\AHTTP_/';
				foreach($_SERVER as $key=>$val){
					if(preg_match($rx_http,$key)){
						$arh_key=preg_replace($rx_http,'',$key);
						$arh[$arh_key]=$val;
					}
				}
				return($arh);
			}
		}
		$_head=apache_request_headers();
		$mobile=($_POST['CROSSDOMAIN']||$_head['SOURCEFORMAT']=='mobile');
		// $path=str_repeat('../',1+substr_count(end(explode('controls/',$_SERVER['PHP_SELF'])),'/'));
		// utf8_encode_all($data);
		$txt=json_encode($data);
		if(isset($_GET['callback'])) $txt=$_GET['callback']."($txt)";
		die($txt);

	}
}

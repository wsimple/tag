<?php
class APP
{
	protected static function redir($url=''){
		if($url=='') return;
		@header('Location:'.$url);
		die();
	}
	public static function detect($redir=true){
		global $config;
		$detect=new Mobile_Detect;
		if($detect->isMobile()){
			#cambiar entre version full y mobile
			$mobile=false;
			if(isset($_GET['mobileVersion'])){
				setcookie('__FV__',NULL,NULL,'/',NULL,false,false);
				if($redir) self::redir($config->app_server);
			}
			if(isset($_GET['fullVersion'])){
				setcookie('__FV__','1',time()+60*60*24*30,'/',NULL,false,false);
				if($redir) self::redir('.');
			}
			if(!$detect->isTablet()||!$_COOKIE['__FV__'])
				if($redir) self::uri_analice();
		}
		return $detect->isMobile();
	}
	public static function uri_analice(){
		global $config;
		$params=URI::params();
		if(URI::section()=='app'){
			$url='';
			if(strpos($_SERVER['REQUEST_URI'],'?')) $url='?'.end(explode('?',$_SERVER['REQUEST_URI']));
			$url=implode('/',$params).$url;
			if($config->local) $url=$config->path.$config->app_server.$url;
			else $url=$config->app_server.$url;
			self::redir($url);
		}
		#si es un dispositivo mobile, analizamos la url y redireccionamos segun sea necesario 
		switch(URI::section()){
			case 'tag':
				if(preg_match('/^\d+$/i',$params[0]))
					$tid=$params[0];
				elseif(preg_match('/^[0-9a-f]{32}$/i',$params[0]))
					$tid=$params[0];
				else
					$tid=isset($_GET['tag'])?$_GET['tag']:$_GET['id'];
				self::redir($config->app_server."tag.html?id=$tid");
			case 'setting':
				self::redir($config->app_server."setting.html");
			case 'resetPassword':
				$usr='';
				if(preg_match('/^[0-9a-f]{32}$/i',$_GET['usr']))
					$usr=$_GET['tag'];
				self::redir($config->app_server."resendPass.html?usr=$usr");
			case 'home': default:
				self::redir($config->app_server);
		}
	}
}

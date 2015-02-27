<?php
class URI
{
	protected static
		$section='',
		$full_params=array(),
		$params=array(),
		$path='';

	public static function getdata($force=false){
		if(!$force&&self::$section!='') return;
		global $config;
		if(is_string($force)) $section=$force;
		else $section=array_shift(explode('?',$_SERVER['REQUEST_URI']));
		if(strpos($section,'.php')) $section=str_replace($_SERVER['SCRIPT_NAME'],'',$section);
		elseif(strpos($section,$config->path)===0) $section=substr($section,strlen($config->path));
		if($section=='') $section='/home';
		self::$path=$section;
		while($section[0]=='/') $section=substr($section,1);
		$params=explode('/',$section);
		self::$full_params=$params;
		self::$section=array_shift($params);
		self::$params=$params;
	}

	public static function section(){
		self::getdata();
		return self::$section;
	}
	public static function params(){
		self::getdata();
		return self::$params;
	}
	public static function full_params(){
		self::getdata();
		return self::$full_params;
	}
	public static function path(){
		self::getdata();
		return self::$path;
	}
}

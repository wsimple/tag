<?php

class TAG_functions{
	public $setting,$db,$model;
	function __construct(){
		global $config;
		$setting=$config;
		$this->db=new TAG_db($config->db);
		$this->db->showErrors(is_debug());
		$this->model=new stdClass();
	}
	function __destruct(){}

	public static function call_method($object,$name,$params=array()){
		if(method_exists($object,$name)) call_user_func_array(array($object,$name),$params);
		elseif(is_debug()) echo("Error: No existe el metodo '$name' (".get_class($object).').');
		else echo('Page not found.');
	}
	public static function view($___name='',$___var){
		if($___name=='') return;
		extract($___var);
		include("main/views/$___name.php");
	}

	function load_model($name){
		$name=ucfirst($name);
		$classname=$name.'_model';
		if(!$this->model->$name) $this->model->$name=new $classname($this);
	}
	function load_models($names=array()){
		foreach($names as $name) self::load_model($name);
	}
}

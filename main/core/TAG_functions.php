<?php

class TAG_functions{
	public $setting,$db,$model,$lib;
	function __construct(){
		global $config;
		if(!$config) return;
		$this->setting=$config;
		$this->db=new TAG_db($config->db);
		$this->db->showErrors(is_debug());
		$this->lib=new stdClass();
		$this->model=new stdClass();
	}
	function __destruct(){}

	public static function call_method($object,$name,$params=array()){
		if(method_exists($object,$name)) call_user_func_array(array($object,$name),$params);
		elseif(is_debug()) echo("Error: No existe el metodo '$name' (".get_class($object).').');
		else echo('Page not found.');
	}
	public static function view($_n_a_m_e='',$_v_a_r=''){
		if($_n_a_m_e=='') return;
		if(is_string($_v_a_r)) $data=$_v_a_r;
		else extract($_v_a_r);
		include("main/views/$_n_a_m_e.php");
	}
	public static function is_view($_n_a_m_e=''){
		if($_n_a_m_e=='') return false;
		return is_file("main/views/$_n_a_m_e.php");
	}

	function lan($text='',$format=false){
		global $lang;
		return (isset($lang[$text])?$lang[$text]:$text);
	}

	function load_model($name){
		$name=ucfirst($name);
		$classname=$name.'_model';
		if(!$this->model->$name) $this->model->$name=new $classname($this);
	}
	function load_models($names=array()){
		foreach($names as $name) $this->load_model($name);
	}
	function load_lib($name){
		$name=ucfirst($name);
		$classname=$name.'_lib';
		if(!$this->lib->$name) $this->lib->$name=new $classname($this);
	}
	function load_libs($names=array()){
		foreach($names as $name) $this->load_lib($name);
	}
}

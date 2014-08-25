<?php

class BASE_functions{
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
	public static function is_debug($name=''){
		if($name=='') return isset($_COOKIE['_DEBUG_']);
		foreach(split(',',$name) as $value)
			if(in_array($value,split(',',$_COOKIE['_DEBUG_'])))
				return true;
		return false;
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

class BASE_controller extends TAG_functions{
	private $no_method;
	function __construct($params=array()){
		parent::__construct($params);
		$name=strtolower(get_class($this));
		if(is_file("main/models/$name.php")) $this->load_model($name);
	}
	function __destruct(){}
	public function disable_methods(){
		$this->no_method=true;
	}
	public function enable_methods(){
		$this->no_method=false;
	}
	public function use_methods(){
		return !$this->no_method;
	}
}

class BASE_librarie{
	var $parent,$db;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=$control; }
		$this->parent=$parent;
		$this->db=$parent->db;
	}
	function __destruct(){
	}
	function load_lib($name){
		$this->parent->load_lib($name);
	}
	function load_libs($names){
		$this->parent->load_libs($names);
	}
}

class BASE_model{
	var $parent,$db;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=$control; }
		$this->parent=$parent;
		$this->db=$parent->db;
	}
	function __destruct(){
	}
	function load_model($name){
		$this->parent->load_model($name);
	}
	function load_models($names){
		$this->parent->load_models($names);
	}
}

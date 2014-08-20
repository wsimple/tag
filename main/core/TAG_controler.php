<?php
class TAG_controler extends TAG_functions{
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

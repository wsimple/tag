<?php
class TAG_model{
	#configuracion general para todos los modelos
	var $control,$db;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=$control; }
		$this->control=$parent;
		$this->db=$parent->db;
	}
	function __destruct(){
	}
	function load_model($name){
		$this->control->load_model($name);
	}
	function load_models($names){
		$this->control->load_models($names);
	}
}

<?php
class TAG_librarie{
	#configuracion general para todas las librerias
	var $control,$db;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=$control; }
		$this->control=$parent;
		$this->db=$parent->db;
	}
	function __destruct(){
	}
	function load_lib($name){
		$this->control->load_lib($name);
	}
	function load_libs($names){
		$this->control->load_libs($names);
	}
}

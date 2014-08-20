<?php
class TAG_librarie{
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
}

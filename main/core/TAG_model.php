<?php
class TAG_model{
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
}

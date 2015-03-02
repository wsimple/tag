<?php
class TAG_librarie{
	#configuracion general para todas las librerias
	var $control,$db,$load;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=$control; }
		$this->control=$parent;
		$this->load=$parent->load;
		$this->db=$parent->db;
	}
	function __destruct(){
	}
}

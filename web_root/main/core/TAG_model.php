<?php
class TAG_model{
	#configuracion general para todos los modelos
	public $control,$db,$load;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=$control; }
		$this->control=$parent;
		$this->load=$parent->load;
		$this->db=$parent->db;
	}
	function __destruct(){
	}
}

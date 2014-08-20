<?php
class User_model extends TAG_model{
	function __construct($parent){
		parent::__construct($parent);
		var_dump(array(
			$this->db->getVal('select now()'),
			1,
		));
	}
	function __destruct(){
	}
}

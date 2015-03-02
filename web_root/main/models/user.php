<?php
class User_model extends TAG_model{
	var $user;
	function __construct($control=false){
		parent::__construct($control);
	}
	function __destruct(){
	}
	function get_user($id=0){
		if(!$user||$user->id!=$id)
			$user=$this->db->getRowObject('SELECT *,md5(CONCAT(id,"_",email,"_",id)) AS code FROM users WHERE id=?',array($id));
		return $user;
	}
}

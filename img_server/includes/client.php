<?php
#accceso a base de datos
require_once('security/security.php');
require_once('TAG_db.php');

#verificacion de datos de usuario
class Client{
	private $db,$_code;
	function __construct(){
		$this->db=new TAG_db();
	}
	private function validate($usr=false){
		$this->_code='';
		if($usr&&isset($usr->code)){
			$this->_code=$usr->code;
			return true;
		}
		return false;
	}
	function valid_id($id){
		$usr=$this->db->getRowObject(
			'SELECT id_user,code,TIMEDIFF(now(),time) as timedif FROM activity_users
			WHERE id_user=? AND REMOTE_ADDR=? AND HTTP_USER_AGENT=? AND TIMEDIFF(now(),time)<"00:30:00"',
			array($id,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'])
		);
		return $this->validate($usr);
	}
	function valid_code($code){
		$usr=$this->db->getRowObject(
			'SELECT id_user,code,TIMEDIFF(now(),time) as timedif FROM activity_users
			WHERE code=? AND REMOTE_ADDR=? AND HTTP_USER_AGENT=? AND TIMEDIFF(now(),time)<"00:30:00"',
			array($code,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'])
		);
		return $this->validate($usr);
	}
	function code(){ return $this->_code; }
}

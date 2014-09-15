<?php
#accceso a base de datos
require_once('security/security.php');
require_once('TAG_db.php');

#verificacion de datos de usuario
class Client{
	private $usr;
	public $db;
	function __construct(){
		$this->db=new TAG_db();
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
	private function validate($usr=false){
		if($usr&&isset($usr->code)){
			$usr->type=$this->db->getVal('SELECT u.type FROM users u WHERE u.id=?',array($usr->id_user));
			$this->usr=$usr;
			return true;
		}else
			$this->usr=new stdClass();
		return false;
	}
	function get($val){ return isset($this->usr->$val)?$this->usr->$val:''; }
	function code(){ return $this->get('code'); }
	function type(){ return $this->get('type'); }
}

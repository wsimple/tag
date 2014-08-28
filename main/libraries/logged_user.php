<?php
class Logged_user_lib extends TAG_librarie{
	private $user_id,$DATA;
	function __construct($control=false){
		parent::__construct($control);
		$this->control->load_model('user');
		session_start();
		if($_SESSION['ws-tags']['ws-user']['id']!='')
			$this->user_id=$_SESSION['ws-tags']['ws-user']['id'];
		$this->DATA=$this->control->model->User->get_user($this->user_id);
		$this->DATA->is_logged=!!$this->user_id;
		if($this->DATA->is_logged)
			$this->db->insert_or_update('activity_users',
				'id_user=?,code=?,time=now()',
				'REMOTE_ADDR=?,HTTP_USER_AGENT=?,session_id=?',
				'REMOTE_ADDR=? AND HTTP_USER_AGENT=? AND session_id=?',
				array(
					$_SESSION['ws-tags']['ws-user']['id'],$_SESSION['ws-tags']['ws-user']['code'],
					$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],session_id(),
					$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],session_id(),
				)
			);
	}
	function data(){
		return $this->DATA;
	}
}

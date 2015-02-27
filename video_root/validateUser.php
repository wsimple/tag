<?php
class validateUser extends Client
{
	protected $_folder='',$_code='',$_path='/videos/';
	function __construct(){
		parent::__construct();
		$this->validate();
	}
	protected $preloaded,$_valid;
	protected function validate($force=false){
		if(!$force&&$this->preloaded) return $this->_code;
		$code=!empty($_COOKIE['__code__'])?$_COOKIE['__code__']:
			(!empty($_REQUEST['code'])?$_REQUEST['code']:'');
		$id=!empty($_COOKIE['__uid__'])?$_COOKIE['__uid__']:
			(!empty($_REQUEST['id'])?$_REQUEST['id']:'');
		$this->preloaded=true;
		return $this->valid_code_user($id,$code);
	}
	protected function valid_code_user($id=0,$code=0){
		$this->_valid=$this->valid_code($code)||$this->valid_id($id);
		$this->_code=$this->code();
		return $this->_code;
	}
	// Get folder
	protected function folder() {
		if(isset($_REQUEST['folder'])) $this->_folder=$_REQUEST['folder'];
		$folder=$this->_folder?$this->_folder.'/':'';
		return $this->_path.$folder;
	}
	protected function user_folder() {
		return $this->_valid?"$this->folder/$this->_code/":'';
	}
}

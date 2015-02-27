<?php
class MAIN_load{
	var $control;
	function __construct($parent=false){
		if(!$parent){ global $control; $parent=&$control; }
		$this->control=&$parent;
	}
	function model($name){
		if(is_array($name)){
			foreach($name as &$el) $this->model($el);
			return;
		}
		$name=ucfirst($name);
		$classname=$name.'_model';
		if(!isset($this->control->model->$name)) $this->control->model->$name=new $classname($this->control);
	}
	function library($name){
		if(is_array($name)){
			foreach($name as &$el) $this->library($el);
			return;
		}
		$name=ucfirst($name);
		$classname=$name.'_lib';
		if(!isset($this->control->lib->$name)) $this->control->lib->$name=new $classname($this->control);
	}
	private function __view($_n_a_m_e='',$_v_a_r=''){
		if($_n_a_m_e=='') return;
		if(is_string($_v_a_r)){ $data=$_v_a_r; $_v_a_r=array(); }
		else extract($_v_a_r);
		include("main/views/$_n_a_m_e.php");
	}
	public function view($name,$data=array()){
		if(!is_array($data)) $data=array('data'=>$data);
		$data['setting']=$this->control->setting;
		$data['control']=$this->control;
		$data['location']=$this->control->location;
		$data['client']=$this->control->client->data();
		$data['lang']=$this->control->lang;
		if(preg_match('/^partial\/(header|footer)/i',$name)){
			$data['is_logged']=$data['client']->is_logged;
			$data['language']=$this->control->lang->code();
			$data['bg']=($_SESSION['ws-tags']['ws-user']['user_background']==''?'' : ($_SESSION['ws-tags']['ws-user']['user_background'][0]!='#' ? 'style="background-image:url('.$this->control->setting->img_server.'users_backgrounds/'.$_SESSION['ws-tags']['ws-user']['user_background'].')"':''));
		}
		$this->__view($name,$data);
	}
	public function old_view($_n_a_m_e='',$_v_a_r=''){
		#temporales (migracion)
		include('includes/session.php');
		include('includes/functions.php');
		include('class/wconecta.class.php');
		include('includes/languages.config.php');
		#fin temporales (migracion)
		if($_n_a_m_e=='') return;
		if(is_string($_v_a_r)) $data=$_v_a_r;
		else extract($_v_a_r);
		include("views/$_n_a_m_e.php");
	}
}

<?php
class TAG_controller extends TAG_functions{
	#configuracion general para todos los controles
	public $setting,$db,$model,$lib,$location,
		$client,$lang;
	private $echo_data='',$no_method;
	function __construct($params=array()){
		include('includes/security/security.php');
		$detect=new Mobile_Detect();
		$config->is_mobile=$detect->isMobile();
		$this->setting=$config;
		$this->db=new TAG_db($config->db);
		$this->db->showErrors($this->is_debug());
		$this->lib=new stdClass();
		$this->model=new stdClass();
		$this->location=$this->location_data();
		$this->load_lib('error_views');
		$name=strtolower(get_class($this));
		if(is_file("main/models/$name.php")) $this->load_model($name);
		$this->lang=new Lang_lib($this);#libreria para manejo de lenguaje
		$this->client=new Client_lib($this);#libreria para manejo del cliente (usuario logeado)
	}
	function __destruct(){
	}

	public function disable_methods(){
		$this->no_method=true;
	}
	public function enable_methods(){
		$this->no_method=false;
	}
	public function use_methods(){
		return !$this->no_method;
	}
	function load_model($name){
		$name=ucfirst($name);
		$classname=$name.'_model';
		if(!$this->model->$name) $this->model->$name=new $classname($this);
	}
	function load_models($names=array()){
		foreach($names as $name) $this->load_model($name);
	}
	function load_lib($name){
		$name=ucfirst($name);
		$classname=$name.'_lib';
		if(!$this->lib->$name) $this->lib->$name=new $classname($this);
	}
	function load_libs($names=array()){
		foreach($names as $name) $this->load_lib($name);
	}
	public function view($name,$data=array()){
		if(!is_array($data)) $data=array('data'=>$data);
		$data['setting']=$this->setting;
		$data['control']=$this;
		$data['location']=$this->location;
		$data['client']=$this->client->data();
		$data['lang']=$this->lang;
		if(preg_match('/^partial\/(header|footer)/i',$name)){
			$data['is_logged']=$data['client']->is_logged;
			$data['language']=$this->lang->code();
			$data['bg']=($_SESSION['ws-tags']['ws-user']['user_background']==''?'' : ($_SESSION['ws-tags']['ws-user']['user_background'][0]!='#' ? 'style="background-image:url('.$this->setting->img_server.'users_backgrounds/'.$_SESSION['ws-tags']['ws-user']['user_background'].')"':''));
		}
		parent::view($name,$data);
	}
	public function error_view($code=404){
		die('Page not found.');
		// die($this->lib->Error_views->msg($code));
	}
	public function set_echo($html){
		$this->echo_data.=$html;
	}
	public function flush_echo(){
		echo $this->echo_data;
		$this->echo_data='';
	}
	public function dump($data){
		$html=json_encode($data);
		$this->set_echo("<pre>$html</pre>");
	}
}

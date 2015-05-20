<?php
class TAG_controller extends TAG_functions{
	#configuracion general para todos los controles
	public $setting,$db,$model,$lib,$location,$load,
		$client,$lang;
	private $echo_data='',$no_method;
	function __construct($params=array()){
		if(is_file('.security/security.php'))
			include('.security/security.php');
		else 
			include('includes/security/security.php');
		$this->setting=$config;
		$this->lib=new stdClass();
		$this->model=new stdClass();
		$this->load=new MAIN_load($this);
		load_session();
		$this->db=new TAG_db($config->db);
		$this->db->showErrors($this->is_debug());
		$this->lang=new Lang_lib($this);#libreria para manejo de lenguaje
		$detect=new Mobile_Detect();
		$config->is_mobile=$detect->isMobile();
		$this->location=$this->location_data();
		$this->load->library('error_views');
		$name=strtolower(get_class($this));
		if(is_file("main/models/$name.php")) $this->load->model($name);
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

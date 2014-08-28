<?php
class TAG_controller extends TAG_functions{
	#configuracion general para todos los controles
	public $setting,$db,$model,$lib,$location,
		$client,$lang;
	private $echo_data='',$no_method;
	function __construct($params=array()){
		include('includes/security/security.php');
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
			$data['language']=$this->lang['langcode'];
			$data['bg']=($_SESSION['ws-tags']['ws-user']['user_background']==''?'' : ($_SESSION['ws-tags']['ws-user']['user_background'][0]!='#' ? 'style="background-image:url('.$this->setting->img_server.'users_backgrounds/'.$_SESSION['ws-tags']['ws-user']['user_background'].')"':''));
		}
		parent::view($name,$data);
	}
	function location_data(){
		$data=new stdClass();
		$data->uri=$_SERVER['REQUEST_URI'];
		#seccion completa desde la url (ejem: user/preferences)
		$data->full_section=array_shift(explode('?',$data->uri));
		if(strpos($data->full_section,$this->setting->path)===0) $data->full_section=substr($data->full_section,strlen($this->setting->path));
		$data->full_section=preg_replace('/^(.*\.php)?\//','',$data->full_section);
		#seccion (ejem: de full_section, el primero es la seccion, el resto son parametros )
		if($_GET['hashtag']){#si la seccion se convirtio desde un hashtag transformado a get
			$section=array_shift(explode('?',$_GET['hashtag']));
			$data->full_section="$section/$data->full_section";
			if(strpos($_GET['hashtag'],'?'))
				$_GET=array_merge($_GET,parse_url(end(explode('?',$_GET['hashtag']))));
			unset($_GET['hashtag']);
		}
		if($data->full_section=='') $data->full_section='home';
		$data->full_params=explode('/',$data->full_section);
		$data->section=array_shift($data->full_params);
		$data->params=$data->full_params;
		$data->method=count($data->params)>0?array_shift($data->params):'index';

		if($this->is_debug('location'))
			$this->set_echo('<pre id="location" style="display:none;">'.json_encode($data).'</pre>');
		return $data;
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

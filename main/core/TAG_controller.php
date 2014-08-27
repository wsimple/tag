<?php
class TAG_controller extends TAG_functions{
	#configuracion general para todos los controles
	public $setting,$db,$model,$lib,$location,$user;
	private $echo_data='',$no_method,$lang;
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
		$this->load_lang();
		#libreria para manejo del usuario logeado
		$this->user=new Logged_user_lib($this);
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

	function lan($text='',$format=false){
		global $lang;
		return (isset($lang[$text])?$lang[$text]:$text);
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
		if(preg_match('/^partial\/(header|footer)/i',$name)){
			$data['config']=$data['setting']=$this->setting;
			$data['control']=$this;
			$data['location']=$this->location;
			$data['user']=$this->user->data();
			$data['is_logged']=$data['user']->is_logged;
			$data['lang']=$this->lang;
			$data['language']=$this->lang['langcode'];
			$data['bg']=($_SESSION['ws-tags']['ws-user']['user_background']==''?'' : ($_SESSION['ws-tags']['ws-user']['user_background'][0]!='#' ? 'style="background-image:url('.$this->setting->img_server.'users_backgrounds/'.$_SESSION['ws-tags']['ws-user']['user_background'].')"':''));
		}
		parent::view($name,$data);
	}
	function load_lang(){
		#lenguajes permitidos
		$languages=array('en','es');
		#deteccion de lenguaje
		$actual='';
		if($_GET['lang']!=''){
			$actual=$_GET['lang'];
		}else{
			#si llego el lenguaje y el usuario esta logueado
			if ($_SESSION['ws-tags']['ws-user']['language']!=''){
				$_SESSION['ws-tags']['language']=$_SESSION['ws-tags']['ws-user']['language'];
			}elseif($_POST['lang']!=''){
				$_SESSION['ws-tags']['language']=$_POST['lang'];
				@header('Location:'.$_POST['actualUrl']);//Url Actual donde se cambiara el idioma
			}
			#detecta el idioma segun la ip del usuario si no esta logeado
			if($_GET['lang']==''&&empty($_SESSION['ws-tags']['language'])){
				if(preg_match('/^(local\.|localhost|127\.|192\.168\.)/',$_SERVER['SERVER_NAME'])){
					$_SESSION['ws-tags']['language']=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
				}else{
					$ip_num=sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
					$locale=CON::getVal('SELECT idioma FROM geo_ip WHERE ? BETWEEN start AND end',array($ip_num));
					$_SESSION['ws-tags']['language']=$locale;
				}
			}
			$actual=$_SESSION['ws-tags']['language'];
		}
		#si el lenguaje no esta permitido, cargamos el ingles
		if(!in_array($actual,$languages)) $actual='en';
		#carga de traducciones
		$lang=array();
		include("language/$actual.php");
		$this->lang=$lang;
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
		die($this->lib->Error_views->msg($code));
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

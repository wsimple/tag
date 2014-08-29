<?php

class TAG_functions{
	#funciones para todos los controles

	public static function call_method($object,$name,$params=array()){
		if(method_exists($object,$name)) call_user_func_array(array($object,$name),$params);
		elseif(self::is_debug()) echo("Error: No existe el metodo '$name' (".get_class($object).').');
		else echo('Page not found.');
	}
	/*
	public static function call_own_method($object,$name,$params=array()){
		#llama un metodo solo si existe en el objeto (metodos no heredados)
		if(method_exists($object,$name)) call_user_func_array(array($object,$name),$params);
		elseif(self::is_debug()) echo("Error: No existe el metodo '$name' (".get_class($object).').');
		else echo('Page not found.');
	}
	public static function own_method_exists($class_name, $method_name){
		#verificar si un metodo no pertenece al padre
		if (method_exists($class_name, $method_name)){
			$parent_class=get_parent_class($class_name);
			if($parent_class!==false) return !method_exists($parent_class, $method_name);
			return true;
		}else
			return false;
	}
	/**/
	public static function is_debug($name=''){
		if($name=='') return isset($_COOKIE['_DEBUG_']);
		foreach(split(',',$name) as $value)
			if(in_array($value,split(',',$_COOKIE['_DEBUG_'])))
				return true;
		return false;
	}
	public function view($_n_a_m_e='',$_v_a_r=''){
		if($_n_a_m_e=='') return;
		if(is_string($_v_a_r)){ $data=$_v_a_r; $_v_a_r=array(); }
		else extract($_v_a_r);
		include("main/views/$_n_a_m_e.php");
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
	public function is_view($_n_a_m_e=''){
		if($_n_a_m_e=='') return false;
		return is_file("main/views/$_n_a_m_e.php");
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
}

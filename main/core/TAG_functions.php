<?php

class TAG_functions{
	#funciones para todos los controles

	public static function call_method($object,$name,$params=array()){
		if(method_exists($object,$name)) call_user_func_array(array($object,$name),$params);
		elseif(self::is_debug()) echo("Error: No existe el metodo '$name' (".get_class($object).').');
		else echo('Page not found.');
	}
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
}

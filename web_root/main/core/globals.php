<?php

function base_url($url=''){
	return $url;
}

function is_assoc($a){#detecta si un arreglo es asosiativo
	if(!is_array($a)) return false;
    return !!count(array_diff(array_keys($a),range(0,count($a)-1)));
}

function load_session(){
	@session_start();
	session_write_close();
}

function save_in_session($data=array()){
	@session_start();
	$_SESSION=array_merge($_SESSION,$data);
	session_write_close();
}

function with_session($callable){
	@session_start();
	if(is_callable($callable)) $response=$callable($_SESSION);
	if(is_array($response)) $_SESSION=$response;
	session_write_close();
}

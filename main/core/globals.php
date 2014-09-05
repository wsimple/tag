<?php

function base_url($url=''){
	return $url;
}

function is_assoc($a){#detecta si un arreglo es asosiativo
	if(!is_array($a)) return false;
    return !!count(array_diff(array_keys($a),range(0,count($a)-1)));
}

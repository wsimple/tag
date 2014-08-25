<?php

class TAG_functions extends BASE_functions{
	#funciones para todos los controles
	public function __construct(){
		parent::__construct();
		$this->load_lib('error_views');

	}

	function error_view($code=404){
		die($this->lib->Error_views->msg($code));
	}
}

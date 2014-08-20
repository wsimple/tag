<?php
class Ejemplo extends TAG_controler{
	function index(){
		$this->load_model('user');
		echo 'testing index';
	}
	function met(){
		echo 'testing method';
	}
}
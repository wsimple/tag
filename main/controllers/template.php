<?php
class Template extends TAG_controler{
	function __onload(){
		$this->disable_methods();
	}
	function index($name='',$script_name=false){
		if($this->is_view("templates/$name")){
			if($script_name) echo "<script id=\"$script_name\" type=\"text/x-tmpl\">";
			$this->view("templates/$name");
			if($script_name) echo '</script>';
		}else{
			echo '{}';
		}
	}
}
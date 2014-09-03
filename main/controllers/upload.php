<?php
class Upload extends TAG_controller{
	function __onload(){
		$this->disable_methods();
	}
	function index($name='',$mode=false){
		switch($name){
			case 'videos_templates':
				if($mode!='dialog') $this->view('partial/header');
				$this->view('upload/videos_templates');
				if($mode!='dialog') $this->view('partial/footer');
			break;
			default:
				$this->view('partial/header');
				echo 'Page not found.<br>';
				if($this->is_debug()) echo '<a href="upload/videos_templates">Upload videos & templates</a><br>';
				$this->view('partial/footer');
		}
	}
}

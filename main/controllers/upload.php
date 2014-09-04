<?php
class Upload extends TAG_controller{
	function __onload(){
		$this->disable_methods();
	}
	function index($name='',$mode=false){
		switch($name){
			case 'videos_templates':
				if($mode!='dialog') $this->load->view('partial/header');
				$this->load->view('upload/videos_templates');
				if($mode!='dialog') $this->load->view('partial/footer');
			break;
			default:
				$this->load->view('partial/header');
				echo 'Page not found.<br>';
				if($this->is_debug()) echo '<a href="upload/videos_templates">Upload videos & templates</a><br>';
				$this->load->view('partial/footer');
		}
	}
}

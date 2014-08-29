<?php

class Video extends TAG_controller{
	function __onload(){
		// echo 'dir='.dirname($_SERVER['SCRIPT_NAME']).'<br>';
	}
	function index(){
		echo 'Principal. Empty.<br>';
		echo '<a href="video/dialog/upload">Upload</a>';
	}
	function dialog($type=''){
		switch($type){
			case 'upload':
				$this->view('dialogs/video_upload');
			break;
			default:
				echo 'Dialog not exist.';

		}
	}
}
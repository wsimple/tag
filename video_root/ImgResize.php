<?php
/*
 * jQuery File Upload Plugin PHP Class 8.0.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

class ImgResize
{
	function __construct($options = null, $initialize = true) {
		$this->options = array(
			'max_width' => null,
			'max_height' => null,
		);
		if ($options) {
			$this->options = $options + $this->options;
		}
		if ($initialize) {
			$this->initialize();
		}
	}
	protected function resize($file_path) {
		if(!is_file($file_path)) return false;#not found
		if(empty($this->options['max_width'])) return 0;#no need resize
		$data=getimagesize($file_path);
		$error=0;
		$maxwidth=$this->options['max_width'];
		$imagen=false;
		if($data[0]>$maxwidth){
			switch($data[2]){#type:1=gif,2=jpg,3=png
				case 1:$imagen=imagecreatefromgif ($file_path);break;
				case 2:$imagen=imagecreatefromjpeg($file_path);break;
				case 3:$imagen=imagecreatefrompng ($file_path);break;
			}
			if(!$imagen) return false;#error
			$alto=intval(round($maxwidth/$data[0]*$data[1]));
			$img=imagecreatetruecolor($maxwidth,$alto);
			if(imagecopyresized($img,$imagen,0,0,0,0,$maxwidth,$alto,$data[0],$data[1])){
				switch($data[2]){#type:1=gif,2=jpg,3=png
					case 1:return imagegif($img,$file_path);
					case 2:return imagejpeg($img,$file_path,90);
					case 3:return imagepng($img,$file_path,9);
				}
			}
		}
		return 0;
	}
}

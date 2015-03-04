<?php

class VideoCaptures extends UploadHandler
{
	protected $path='videos';

	function __construct($options = null, $initialize = true){
		parent::__construct($options,$initialize&&!isset($_GET['captures']),null);
		if($initialize&&isset($_GET['captures'])){
			$file_name=isset($_REQUEST['file'])?$_REQUEST['file']:'';
			if(!$file_name) return;
			//buscando capturas del video
			$this->get_captures($file_name);
		}
	}

	function get_captures($filename){
		#primero validamos el usuario y que exista el archivo
		$code=$this->get_code();
		if(!strpos($filename,'/')) $filename="$code/$filename";
		$base_file=preg_replace('/[^_]+\.(jpe?g|mp4)$/i','',$filename);
		$data=new stdClass();
		$data->source=array(
			'path'=>$this->path,
			'base_file'=>$base_file,
		);
		if(!is_file("$this->path/{$base_file}0.mp4")){
			$data->error_code=404;
			$data->error='Video not found.';
			$this->json($data);
		}
		$data->video="{$base_file}0.mp4";
		$data->captures=array();
		$i=1;
		while(is_file("$this->path/{$base_file}$i.jpg")){
			$data->captures[]=$base_file.$i++.'.jpg';
		}
		$this->json($data);
	}
}

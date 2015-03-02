<?php

class VideoCaptures extends UploadHandler
{
	protected $path='videos';

	function __construct($initialize = true){
		$options=null;
		$_referer=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'//localhost';
		$_referer=preg_replace('/^(\w+:)\/\/([^\/]+)(\/.*)?$/','$2',$_referer);
		$this->header("data-referer: $_referer");
		if(preg_match('/^(localhost|52(\.\d+){3}|(\w+\.)(tagbum|elasticbeanstalk)\.com)$/',$_referer)){
			$options=array(
				'access_control_allow_origin'=>"http://$_referer",
				'access_control_allow_credentials'=>true
			);
		}
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

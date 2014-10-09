<?php

class VideoCaptures extends UploadHandler
{
	protected $path='videos',$usr;

	function __construct($initialize = true){
		parent::__construct(null,false,null);
		if($initialize){
			if(!isset($_GET['captures'])) return;
			$file_name=isset($_REQUEST['file'])?$_REQUEST['file']:'';
			if(!$file_name) return;
			//buscando capturas del video
			$this->get_captures($file_name);
		}
	}

	protected function get_code(){
		if($this->usr) return $this->usr->code();
		$client=new Client();
		$code=isset($_REQUEST['code'])?$_REQUEST['code']:'';
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
		if($client->valid_code($code)||$client->valid_id($id)){
			$this->usr=$client;
			return $this->usr->code();
		}
		$this->cancel();
	}

	function get_captures($filename){
		#primero validamos el usuario y que exista el archivo
		$code=$this->get_code();
		$base_file=$code.'/'.preg_replace('/^([^\/]+\/)*|[^_]+\.(jpe?g|mp4)$/i','',$filename);
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

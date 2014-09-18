<?php

class VideoConvertion
{
	private $local_time_delay=5;#retraso en respuesta, para pruebas locales.

	private $pending='pending',$path='videos',$_run;

	function __construct(){
		if(!isset($_GET['convert'])) return;
		$file_name=isset($_REQUEST['file'])?$_REQUEST['file']:'';
		if(!$file_name) return;
		//proceso de video
		$data=$this->get_info($file_name);
		$this->video_convert($data);
	}

	// Get folder
	protected function folder() {
		if(isset($_REQUEST['folder'])) $this->_folder=$_REQUEST['folder'];
		$folder=$this->_folder?$this->_folder.'/':'';
		return $this->_path.$folder;
	}
	protected function empty_json(){
		$this->send_content_type_header();
		die('{}');
	}
	private $usr;
	protected function get_code(){
		if($this->usr) return $this->usr->code();
		$client=new Client();
		$code=isset($_REQUEST['code'])?$_REQUEST['code']:'';
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
		if($client->valid_code($code)||$client->valid_id($id)){
			$this->usr=$client;
			return $this->usr->code();
		}
		$this->empty_json();
	}
	protected function send_content_type_header() {
		$this->header('Vary: Accept');
		if (strpos($this->get_server_var('HTTP_ACCEPT'),'application/json') !== false) {
			$this->header('Content-type: application/json');
		} else {
			$this->header('Content-type: text/plain');
		}
	}
	protected function header($str) {
		header($str);
	}
	protected function get_server_var($id) {
		return isset($_SERVER[$id]) ? $_SERVER[$id] : '';
	}

	function run($command,$show=true){
		return preg_replace('/\r?\n/', '<br/>',shell_exec($command.($show?' 2>&1':'')));
	}
	function ffmpeg_encode($origen,$destino,$mas=''){
		if(is_file($destino)) unlink($destino);
		if(preg_match('/\.(mp4|m4[av])$/i',$destino)) $destino="-strict -2 $destino";
		if(preg_match('/\.(mp4|m4v)$/i',$destino)) $origen.=" -s 650*300";
		$run="ffmpeg -i $origen $destino $mas";
		// echo "$run\n";
		$this->_run=array(
			'exec'=>$run,
			'result'=>$this->run($run),
		);
		return $this->_run['result'];
	}
	function get_info($filename){
		#primero validamos el usuario y que exista el archivo
		$code=$this->get_code();
		$origen="$this->pending/$code/$filename";
		if(!is_file("$this->path/$origen")) $this->empty_json();

		$data=new stdClass();
		$code=$this->usr->code();
		$path_dest="$this->path/$code/";
		$data->type=$this->usr->get('type');
		$data->original=$origen;
		$ext=pathinfo($filename,PATHINFO_EXTENSION);
		$base_file="$code/".hash_file('crc32',"$this->path/$origen").'_'.date('YmdHis').'_';
		$data->video=$base_file.'0.mp4';
		$data->captures=array(
			$base_file.'1.jpg',
			$base_file.'2.jpg',
			$base_file.'3.jpg',
		);
		return $data;
	}
	function video_convert($data=false){
		if(!$data) $this->empty_json();
		$usr_path=$this->path.'/'.$this->usr->code();
		$data->usr_path=$usr_path;
		if(!is_dir($usr_path)) {
			mkdir($usr_path,0777,true);
		}
		$origen="$this->path/$data->original -t ".($data->type?'00:00:31':'00:01:01');
		#creacion de video
		$error=$this->ffmpeg_encode($origen,"$this->path/$data->video",'-loglevel error');
		#si no hubo error eliminamos el original
		// echo ($error?"error\n":"no error\n").'ruta: '."$this->path/$data->original"."\n";
		if(!$error) unlink("$this->path/$data->original");
		else unset($data->video,$data->captures);
		#creacion de capturas
		if(!$error){
			$t=$data->type?12:24;
			$origen="$this->path/$data->video";
			for($i=0;$capture=isset($data->captures[$i])?$data->captures[$i]:false;$i++){
				if($error){
					array_splice($data->captures,$i);
					if(count($data->captures)) $error='';
					break;
				}
				$capture="$this->path/$capture";
				$time='00:'.str_pad($i*$t,2,'0',STR_PAD_LEFT).':00';
				$error=$this->ffmpeg_encode($origen,"-ss $time -vframes 1 $capture","-loglevel warning");
			}
			if(!count($data->captures)) $error='Can\'t create any capture.';
		}
		if($error) $data->run=$this->_run;
		if($error) $data->error=$error;

		// unset($data->code,$data->type);
		$this->send_content_type_header();
		exit(json_encode($data));
	}
}

/*
	Conversion (basica):
	ffmpeg -i origen destino
	Conversion (formateada):
	ffmpeg -i origen -s WxH  destino
	Captura:
	ffmpeg -i origen -ss hh:mm:ss -vframes 1 destino
 */
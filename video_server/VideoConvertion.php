<?php

class VideoConvertion extends UploadHandler
{
	private $local_time_delay=5;#retraso en respuesta, para pruebas locales.

	private $pending='pending',$path='videos',$_run;

	function __construct(){
		parent::__construct(null,false,null);
		if(!isset($_GET['convert'])) return;
		$file_name=isset($_REQUEST['file'])?$_REQUEST['file']:'';
		if(!$file_name) return;
		//proceso de video
		$data=$this->get_info($file_name);
		$this->video_convert($data);
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
		$this->cancel();
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
			$captures=is_array($data->captures)?$data->captures:array();
			$data->captures=array();
			for($i=0;$capture=$captures[$i];$i++){
				$capture="$this->path/$capture";
				$time='00:00:'.str_pad($i*$t+4,2,'0',STR_PAD_LEFT);
				$error=$this->ffmpeg_encode($origen,"-ss $time -vframes 1 $capture","-loglevel warning");
				if(!$error)
					$data->captures[]=$captures[$i];
				else
					break;
			}
			if(!count($data->captures)) $error="Can't create any capture.";
		}
		if($error) $data->run=$this->_run;
		if($error) $data->error=$error;

		$this->head();
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
<?php

class VideoConvertion extends VideoCaptures
{
	protected $pending='pending',$_run;

	function __construct($initialize = true){
		#verifica primero si se estan buscando capturas
		parent::__construct(true);
		if($initialize){
			if(!isset($_GET['convert'])) return;
			$file_name=isset($_REQUEST['file'])?$_REQUEST['file']:'';
			if(!$file_name) return;
			//proceso de video
			$data=$this->get_info($file_name);
			$this->video_convert($data);
		}
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
		if(!is_file("$this->path/$origen")) $this->json();

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
		if(!$data) $this->json();
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
		if(!$error){
			#lista de capturas
			$captures=is_array($data->captures)?$data->captures:array();
			#calculamos aproximadamente la duracion del video
			$max=$data->type?31:60;
			$i=$max;
			$error='-';
			$capture=$captures[0];
			if($capture) do{
				$i--;
				$error=$this->ffmpeg_encode($origen,"-ss 00:00:$i -vframes 1 $capture","-loglevel warning");
			}while($error&&$i>$max/3);
			#calculando tiempos de las capturas
			$start=ceil($i/15);
			$t=ceil($i*2/5);
			$i=0;
			#generamos las capturas
			$data->captures=array();
			while(count($captures)>$i){
				$capture=$captures[$i];
				$capture="$this->path/$capture";
				$time='00:00:'.str_pad($i*$t+$start,2,'0',STR_PAD_LEFT);
				$error=$this->ffmpeg_encode($origen,"-ss $time -vframes 1 $capture","-loglevel warning");
				if(!$error)
					$data->captures[]=$captures[$i];
				elseif($i==0&&$start>0){
					$start--;
					continue;
				}else
					break;
				$i++;
			}
			if(!count($data->captures)) $error="Can't create any capture.";
		}
		$data->last_run=array('cmd'=>$this->_run,'error'=>$error);
		if(empty($data->video)||!count($data->captures)) $data->error=$error;

		$this->json($data);
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

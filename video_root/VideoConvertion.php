<?php

class VideoConvertion extends VideoCaptures
{
	protected $pending='pending',$_run=array();

	function __construct($options = null, $initialize = true){
		#verifica primero si se estan buscando capturas
		parent::__construct($options,$initialize&&!isset($_GET['convert'])&&!isset($_GET['app']));
		if($initialize&&isset($_GET['app'])){
			$app=new appUpload();

		}
		if($initialize&&(isset($_GET['convert'])||isset($_GET['app']))){
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
		#video mp4
		if(preg_match('/\.(mp4|m4v)$/i',$destino)) $destino="-strict -2 $destino";
		#video ogg
		if(preg_match('/\.(og[gv])$/i',$destino)) $destino="-acodec vorbis -ac 2 -strict -2 -q:v 8 $destino";
		#tamaño de video
		if(preg_match('/\.(mp4|m4v|og[gv])$/i',$destino)) $origen.=" -s 650*300";
		$run="ffmpeg -i $origen $destino $mas";
		// echo "$run\n";
		$data=array(
			'exec'=>$run,
			'result'=>$this->run($run),
		);
		$this->_run[]=$data;
		return $data['result'];
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
		$data->video2=$base_file.'0.ogg';
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
		$warning='';
		$error=$this->ffmpeg_encode($origen,"$this->path/$data->video",'-loglevel error');
		if(!$error)
			$error=$this->ffmpeg_encode($origen,"$this->path/$data->video2",'-loglevel error');
		if($error){#si hubo error creando videos, eliminamos las variables y los residuos (si hay)
			@unlink("$this->path/$data->video");
			@unlink("$this->path/$data->video2");
			unset($data->video,$data->video2,$data->captures);
		}else{#si no hubo error, eliminamos el original y continuamos
			@unlink("$this->path/$data->original");
			#creacion de capturas
			$captures=is_array($data->captures)?$data->captures:array();
			$max=$data->type?30:60;#duracion maxima de video segun el tipo de usuario
			$i=$max;
			#(a prueba) calculamos aproximadamente la duracion del video
			// $error='-';
			// $capture=$captures[0];
			// if($capture) do{
			// 	$i--;
			// 	$error=$this->ffmpeg_encode($origen,"-ss 00:00:$i -vframes 1 $capture","-loglevel warning");
			// }while($error&&$i>$max/3);
			#calculando tiempos de las capturas
			$start=ceil($i/15);
			$t=ceil($i*2/5);
			$i=0;
			$num_captures=count($captures);
			#generamos las capturas
			$data->captures=array();
			// $img=new ImgResize(array('max_width'=>650));
			while($i<$num_captures){
				$capture=$captures[$i];
				$capture="$this->path/$capture";
				$time='00:00:'.str_pad($i*$t+$start,2,'0',STR_PAD_LEFT);
				$error=$this->ffmpeg_encode("$this->path/$data->video","-ss $time -vframes 1 $capture","-loglevel warning");
				if(!$error||preg_match('/deprecated/i',$error)){
					$data->captures[]=$captures[$i];
					// $img->resize($captures[$i]);
					$i++;
				}elseif($i==0&&$start>0)
					$start--;
				else
					break;
			}
			if(!count($data->captures)){
				$error='';
				$warning="Can't create any capture.";	
			}
		}
		if(isset($_COOKIE['__DEBUG__'])) $data->commands=array('cmd'=>$this->_run,'error'=>$error,'warning'=>$warning);
		if(empty($data->video)) $data->error=$error+$warning;

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

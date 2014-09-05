<?php
class Video extends TAG_controller{
	// function __onload(){
	// 	$this->disable_methods();
	// }
	function validate($is_ajax=0,$url='',$nolocal=0){
		$success=false;$type=false;$test='';
		if ($url==''){
			if (isset($_GET['thisvideo'])) $url=$_GET['thisvideo'];
			if (isset($_POST['thisvideo'])) $url=$_POST['thisvideo'];
		}
		if ($url!=''){
			if ($nolocal===0){
				if (isset($_GET['nolocal'])) $url=$_GET['nolocal'];
				if (isset($_POST['nolocal'])) $url=$_POST['nolocal'];	
			}
			$url=trim($url);
			if(isset($debug) && $debug) $test='video='.$url.',vimeo='.$this->isVideo('vimeo',$url).',youtube='.$this->isVideo('youtube',$url);
			if($this->isVideo('vimeo',$url)){
				if(preg_match('/vimeo.com\\/([^\\?\\&]+)/i',$url,$matches)){
					$type='vimeo';
					$vec=explode('/', $matches[1]);
					$code = end($vec);
					$success=true;
					if (!$mobile) $url='http://player.vimeo.com/video/'.$code.'?byline=0&badge=0&portrait=0&title=0';
					// $url='http://player.vimeo.com/video/'.$code.'?byline=0&badge=0&portrait=0&title=0';
				}
			}elseif($this->isVideo('youtube',$url)){
				if($data['embed'])
					$url=preg_replace($this->regex('youtube'), 'http://youtube.com/embed/$7$9', $url);
				$type='youtube';
				if(preg_match('/(youtube\\S*[\\/\\?\\&]v[\\/=]|youtu.be\\/)([^\\?\\&]+)/i',$url,$matches)){
					$type='youtube';
					$code=$matches[2];
					$success=true;
					if (!$mobile) $url=$code;
					// if (!$mobile) $url='http://www.youtube.com/embed/'.$code.'?rel=0&showinfo=0&cc_load_policy=0&controls=2';
					// $url='http://www.youtube.com/embed/'.$code.'?rel=0&showinfo=0&cc_load_policy=0&controls=2';
				}
			}elseif($nolocal!=0 && $this->isVideo('local',$url)){ $success=true; $type='local'; }
		}
		if ($is_ajax==0) return array('success'=>$success,'urlV'=>$url,'type'=>$type,'test'=>$test);
		else $this->load->view('partial/json',array('json'=>array('success'=>$success,'urlV'=>$url,'type'=>$type,'test'=>$test)));
		// else echo json_encode(array('success'=>$success,'urlV'=>$url,'type'=>$type,'test'=>$test));
		return true;
	}
	function isVideo($type,&$value){
		if($type=='youtube')
			return preg_match('/youtu\\.be|youtube\\.com/i',$value);
		elseif($type=='vimeo')
			return preg_match('/vimeo\\.com/i',$value);
		elseif($type=='local')
			return preg_match('/video/i',$value);
	}
	function regex($name){
		switch($name){
			case 'youtubelong'	:return '/\bhttps?:\\/\\/((m\\.|www\\.)?(youtube\\.com\\/)(embed\\/|watch\\?(.*&)*(v=))(.{11}).*)\b/i';
			case 'youtube'		:return '/\bhttps?:\\/\\/((m\\.|www\\.)?(youtube\\.com\\/)(embed\\/|watch\\?(.*&)*(v=))(.{11})|(youtu\\.be\\/(.{11}))).*\b/i';//code=7&9
			case 'vimeo'		:return '/\bhttps?:\\/\\/(((vimeo\\.com\\/)))((.{8,}))\b/i';//code=5
			case 'video'		:return '/\bhttps?:\\/\\/(vimeo\\.com\\/.{8,}|youtu\\.be\\/.{11}.*|(m\\.|www\\.)?youtube\\.com\\/(.+)(v=.{11}).*)?\b/i';//video=1
			case 'url'			:return '/\b(https?:\/\/\S+|www\.\S+)\b/';
			case 'validurl'		:return '/\b(https?:\\/\\/(www\\.)?([a-z][-a-z0-9]+\\.)?([a-z][-a-z0-9]*)\\.([a-zA-Z]{2}|aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel)(\.[a-z]{2})?(\/.*)?)\b/i';
			default				:return '/.*/i';
		}
	}
}

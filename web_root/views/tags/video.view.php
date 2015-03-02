<div style="padding:30px; margin:0; ">
<!--div style="background-image:url(img/tv.png); background-repeat:no-repeat; padding:30px; margin:0; "-->
<!--<div style="background-image:url(img/tv.png); background-repeat:no-repeat; width:560px; height:420px; padding:30px; margin:0; ">-->
<?php
$url='';
if(preg_match('/(youtube\\S*[\\/\\?\\&]v[\\/=]|youtu.be\\/)([^\\?\\&]+)/i',$_GET['url'],$matches)){
	//url youtube
	//_imprimir($matches);
	$type='youtube';
	$code=$matches[2];
}elseif(preg_match('/vimeo.com\\/([^\\?\\&]+)/i',$_GET['url'],$matches)){
	//url vimeo
	//_imprimir($matches);
	$type='vimeo';
	$code=$matches[1];
}elseif(isset($_GET['id'])){
	$code=$_GET['id'];
	$type=  strtolower(isset($_GET['type'])?$_GET['type']:'youtube');
}
//setting url
if($type=='youtube'||$type=='youtu.be'){
	//id only
	$url='http://www.youtube.com/embed/'.$code.'?autoplay=1';
}elseif($type=='vimeo'){
	$vec=explode('/', $code);
	$code = end($vec);
	$url='http://player.vimeo.com/video/'.$code.'?autoplay=1';
}
//echo $url;

if($url!=''){
?>
<iframe width="560" height="350" src="<?=$url?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
<?php
}
?>
</div>
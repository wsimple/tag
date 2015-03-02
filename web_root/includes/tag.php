<?php
include 'config.php';
include RELPATH.'includes/functions.php';
include RELPATH.'class/wconecta.class.php';
include RELPATH.'includes/languages.config.php';
include RELPATH.'includes/tag.functions.php';

//Informacion basica para crear la imagen de tag
$path='img/tags';
$photo=createTag($_GET['tag'],isset($_GET['force'])).'.jpg';
$photopath=$path.'/'.$photo;

if(isset($_GET['debug'])) echo 'Debuger.';
$_path=LOCAL?RELPATH:FILESERVER;
//Si la imagen de la tag no existe, se crea
$im=imagecreatefromany($_path.$photopath);

//Tag Resize - Cambiar tamaño de la tag.
$_fromFacebook=strpos($_SERVER['HTTP_USER_AGENT'], 'facebook.com')!==false;
if((isset($_GET['width'])&&$_GET['width']<650)||$_fromFacebook){
	//Si viene de facebook se hace de 200px de ancho.
	$x=$_fromFacebook?200:$_GET['width'];
	if($x<100) $x=100;
	$y=$x/650*300;
	$mask=@imagecreatetruecolor($x,$y);
	/*imagealphablending($mask,false);
	$transparent = imagecolorallocatealpha($mask, 0, 0, 0, 127);
	imagefill($mask, 0, 0, $transparent);
	imagealphablending($mask,true);
	imagesavealpha($mask, true);/**/
	@imagecopyresampled($mask, $im, 0,0,0,0, $x, $y, TAGWIDTH,TAGHEIGHT);
	imagedestroy($im);
	$im=$mask;
}

// mostrar imagen, formato png
//header('Content-Type: image/png');
///header('Content-Disposition: attachment; filename="'.$_GET['tag'].'.png"');
//imagepng($im);

// mostrar imagen, formato jpg
if(!isset($_GET['debug'])){
	header('Content-Type: image/jpeg');
	imagejpeg($im,null,90);
	imagedestroy($im);
}
?>
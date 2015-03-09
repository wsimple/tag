<style>span{background:#ddd;}span.block{display:inline-block;}</style>
<?php
$numPanels=1;
global $get;
$PATH = '$PATH';
$HOME = isset($get['path'])?$get['path']:'$HOME';
// $HOME = '/var/www';
ob_start();
?>
<h1>Instalacion de ffmpeg en amazon linux</h1> 
<h2>tutoriales usados:</h2> 
https://gist.github.com/gboudreau/f24aed76b4cc91bfb2c1
https://stavrovski.net/blog/install-ffmpeg-and-ffmpeg-php-in-centos-6-with-virtualmin




<?php
$text=ob_get_contents();
ob_end_clean();

if($HOME!='$HOME') $text=str_replace('$HOME',$HOME,str_replace('~',$HOME,$text));
$text=preg_replace('/\b(https?:\/\/\S*)/','<a href="$1">$1</a>',$text);
$text=preg_replace('/\r?\n/', '<br/>', $text);
$text=preg_replace('/>\s+<br\/>/','>',$text);

echo $text;

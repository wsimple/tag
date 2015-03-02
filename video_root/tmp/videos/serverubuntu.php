<style>span{background:#ddd;}span.block{display:inline-block;}</style>
<?php
$numPanels=1;
global $get;
$PATH = '$PATH';
$HOME = isset($get['path'])?$get['path']:'$HOME';
// $HOME = '/var/www';
ob_start();
?>
<h1>Instalacion de ffmpeg en ubuntu</h1> 
<h2>tutoriales usados:</h2> 
http://www.upubuntu.com/2012/03/how-to-install-ffmpeg-php-libogg.html
https://launchpad.net/~jon-severinsson/+archive/ubuntu/ffmpeg
http://johnvansickle.com/ffmpeg/
http://askubuntu.com/questions/214421/how-to-install-the-mpeg-4-aac-decoder-and-the-h-264-decoder
https://trac.ffmpeg.org/wiki/Encode/AAC


<hr/> 
test server 2: http://68.109.244.196/videos
test server 3: http://68.109.244.197/videos
test server 4: http://68.109.244.198/videos
<hr/>

<b>NOTA:</b> Revisar con cuidado en caso de usarse ya que hay mezclados varias formas de instalacion.
En caso de dudas ver turoriales.


<hr/> 
<h2>Prerequisitos</h2>
sudo apt-get install build-essential libjpeg62 libjpeg-progs libjpeg62-dev php5-dev unzip libsdl1.2-dev

<hr>
sudo add-apt-repository ppa:jon-severinsson/ffmpeg
sudo apt-get install php5-ffmpeg


<hr>
sudo apt-get install ubuntu-restricted-extras
<span>seguir instrucciones (de ser necesario, tab para ver cursor)</span>
sudo apt-get install ffmpeg


<?php
$text=ob_get_contents();
ob_end_clean();

if($HOME!='$HOME') $text=str_replace('$HOME',$HOME,str_replace('~',$HOME,$text));
$text=preg_replace('/\b(https?:\/\/\S*)/','<a href="$1">$1</a>',$text);
$text=preg_replace('/\r?\n/', '<br/>', $text);
$text=preg_replace('/>\s+<br\/>/','>',$text);

echo $text;

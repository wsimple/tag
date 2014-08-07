<?php
function run($command){
	return preg_replace('/\r?\n/', '<br/>',shell_exec($command.' 2>&1'));
}
function ffmpeg_encode($origen,$destino){
	if(strpos($destino,'.mp4')) $destino='-c:v libx264 '.$destino;
	return run("ffmpeg -i $origen $destino");
}
	$video=isset($_GET['name'])?$_GET['name']:'test.mp4';
	error_reporting(E_ALL);
	echo "<p>Starting ffmpeg...</p>";
	echo run("ffmpeg -codecs");
	echo "<p>Converting video homero.mp4 -> $video with ffmpeg...</p>";
	echo ffmpeg_encode('homero.mp4',$video);
?>
<div>
	<video width="320" height="240" controls>
		<source src="<?php echo $video;?>">
		Your browser does not support the video tag.
	</video>
</div>
<p>Done.</p>

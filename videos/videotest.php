<a href="videolist.php"><button>select video</button></a>
<hr/>
<?php
error_reporting(E_ALL);
function run($command){
	return preg_replace('/\r?\n/', '<br/>',shell_exec($command.' 2>&1'));
}
function ffmpeg_encode($origen,$destino){
	// if(strpos($destino,'.mp4')) $destino='-c:v libx264 '.$destino;
	if(is_file($destino)) unlink($destino);
	return run("ffmpeg -i $origen $destino");
}

$input=$_GET['input']!=''?$_GET['input']:'homero.mp4';
$output=$_GET['output']!=''?$_GET['output']:'output.mp4';
$video='output/'.$output;
echo "<p>Starting ffmpeg...</p>";
echo "<p>Encoding <a href='$input'>$input</a> to <a href='$video'>$output</a> with ffmpeg...</p>";
echo ffmpeg_encode($input,$video);
?>
<p>Done.</p>
<hr/>
<div>
	<div style="float:left;display:inline-block;margin:10px;">
		Input video<br/>
		<video width="320" height="240" controls>
			<source src="<?php echo $input;?>">
			Your browser does not support the video tag.
		</video>
	</div>
	<div style="float:left;display:inline-block;margin:10px;">
		Output video<br/>
		<video width="320" height="240" controls>
			<source src="<?php echo $video;?>">
			Your browser does not support the video tag.
		</video>
	</div>
</div>
<div style="clear:both;"></div>
<hr/>
<a href="videolist.php"><button>select video</button></a>
<hr/>
<p>CODECS:</p>
<?php echo run("ffmpeg -codecs"); ?>
<hr/>
<p>HELP:</p>
<?php echo run("ffmpeg --help"); ?>

<div><img src="../img/tags/97f4bed609c869f7.jpg" alt=""></div>

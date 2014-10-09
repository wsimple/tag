<a href="//tagbum.com/upload.php"><button>select video</button></a>
<hr/>
<?php
error_reporting(E_ALL);
function run($command){
	return preg_replace('/\r?\n/', '<br/>',shell_exec($command.' 2>&1'));
}
function ffmpeg_encode($origen,$destino){
	if(is_file($destino)) unlink($destino);
	if(strpos($destino,'.mp4')||strpos($destino,'.m4a')) $destino='-strict -2 '.$destino;
	return run("ffmpeg -loglevel error -i $origen $destino");
}
if($_FILES['video']&&$_FILES['video']['tmp_name']){
	echo 'upload file<br/>';
	$input=md5(time()).'.'.pathinfo($_FILES['video']['name'],PATHINFO_EXTENSION);
	if($_FILES['video']['error']>0){
		die('Error: '.$_FILES['video']['error']);
	}elseif(!is_file($_FILES['video']['tmp_name'])){
		unlink($_FILES['video']['tmp_name']);
		die('Error: File uploaded but damaged.');
	}else{
		copy($_FILES['video']['tmp_name'],$input);
		echo 'Upload: '.$_FILES['video']['name'].'<br/>';
		echo 'Type: '.$_FILES['video']['type'].'<br/>';
		echo 'Size: '.($_FILES['video']['size']/1024).'kB<br/>';
		echo 'Stored in: '.$_FILES['video']['tmp_name'].'<br/>';
		echo 'Moved to: '.$input.'<br/>';
	}
}else{
	$input=$_REQUEST['input']!=''?$_REQUEST['input']:'homero.mp4';
}
$output=$_REQUEST['output']!=''?$_REQUEST['output']:'output.mp4';
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
<a href="//tagbum.com/upload.php"><button>select video</button></a>
<hr/>
<p>CODECS:</p>
<?php echo run("ffmpeg -codecs"); ?>
<hr/>
<p>HELP:</p>
<?php echo run("ffmpeg --help"); ?>

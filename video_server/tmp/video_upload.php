<h1>Upload and convert a video (Server: <?php echo $_SERVER['SERVER_NAME'];?>)</h1>
<p>Select a video and write an output name.</p>
<form action="//v.tagbum.com/videos/upload.php" method="post" enctype="multipart/form-data">
	<div>Select video: <?=file_get_contents('http://v.tagbum.com/videos/list.php')?></div>
	or
	<div>Upload video: <input type="file" name="video"></div>
	<br/>
	<div>File name. Include the extention (recomended <b>.mp4</b> for videos):
	<br/>
	<input type="text" name="output"/></div>
	<br/>
	<input type="submit" value="encode"/>
</form>
<br/>
<hr/>
<h1>Instalacion de ffmpeg</h1>
<div><a href="/videos/servercentos.php">Centos</a></div>
<div><a href="/videos/serverubuntu.php">Ubuntu</a></div>

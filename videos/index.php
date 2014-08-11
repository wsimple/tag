<h1>Convertir video</h1>
<p>Elija un archivo y luego coloque el nombre de destino. Incluya extencion (recomendado <b>.mp4</b> para video)</p>
<form action="videotest.php" method="get">
	<select name="input">
<?php
if(($dir=opendir('.'))){
	$list=array();
	while(($file=readdir($dir))!==false){
		$list[]=$file;
		if(!is_dir($file)&&!strpos($file,'.php')&&!strpos($file,'.swf')){
echo <<<OPC
		<option value="$file">$file</option>
OPC;
		}
	}
	closedir($dir);
}
?>
	</select>
	<input type="text" name="output"/>
	<input type="submit" value="encode"/>
</form>
<hr/>
<h1>Instalacion de ffmpeg</h1>
<div><a href="servercentos.php">Centos</a></div>
<div><a href="serverubuntu.php">Ubuntu</a></div>

<?php if(!strpos(' '.$_SERVER['REMOTE_ADDR'],'192.168.')){ header("HTTP/1.0 404 Not Found"); die(); } ?>
<select name="input">
<?php
if(($dir=opendir('.'))){
	while(($file=readdir($dir))!==false){
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

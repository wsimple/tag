<form action="videotest.php" method="get">
	<select name="input">
<?php
if(($dir=opendir('.'))){
	$list=array();
	while(($file=readdir($dir))!==false){
		$list[]=$file;
		if(!is_dir($file)&&!strpos($file,'.php')&&!strpos($file,'.swf')){
?>
		<option value="<?php echo $file;?>"><?php echo $file;?></option>
<?php
		}
	}
	closedir($dir);
}
?>
	</select>
	<input type="text" name="output">
	<input type="submit" value="encode">
</form>
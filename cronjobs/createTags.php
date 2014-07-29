<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
define('RELPATH','../');
include RELPATH.'includes/config.php';
include RELPATH.'includes/session.php';
include RELPATH.'includes/functions.php';
include RELPATH.'class/wconecta.class.php';
include RELPATH.'includes/languages.config.php';
	$limit=10;
	if(isset($_GET['clear'])){
		$id=$_GET['id']!=''?'id="'.$_GET['id'].'"':'';
		$timeLines = CON::update('tags','img=""',($_GET['id']!=''?'id="'.$_GET['id'].'"':'img!=""'));
	}else{
		$where=$_GET['id']==''?'img=""':'id="'.$_GET['id'].'"';
		$sql='SELECT id FROM tags WHERE '.$where.' ORDER BY id DESC LIMIT 0,'.$limit;
		$timeLines = CON::query($sql);
		$num=CON::numRows($timeLines);
		$html='';
		if($num>0){
			$count=0;
			$html.='<br/>';
			while( $tag=CON::fetchAssoc($timeLines) ){
				$tag['tag']=createTag($tag['id'],true);
				CON::update('tags','img="'.$tag['tag'].'"','id="'.$tag['id'].'"');
				$count++;
				$html.='ID tag: '.$tag['id'].', img: '.$tag['tag'].'<br/>';
			}
			$html.='<hr/>Tags created:'.$count.'<br/>';
		}
	}
	$data=CON::getRow('SELECT (SELECT COUNT(*) FROM tags WHERE img!="") AS done, (SELECT COUNT(*) FROM tags WHERE img="") AS more');
	//die(json_encode($res));
?>
<!DOCTYPE html>
<html>
<head>
	<title>CometChat</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
	if($data['more']>0){
		$pos=strrpos($_SERVER["PHP_SELF"],'/');
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.substr($_SERVER["PHP_SELF"],$pos+1).'">';
	}
?>
</head>
<body>
<?php
	echo $html;
	echo '<hr/>Tags done:'.$data['done'];
	echo '<br/>Tags pending:'.$data['more'];
?>
</body>
</html>

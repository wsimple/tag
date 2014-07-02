<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
$path='../';
include $path.'includes/config.php';
include $path.'includes/session.php';
include $path.'includes/functions.php';
include $path.'class/wconecta.class.php';
include $path.'includes/languages.config.php';
	$limit=10;
	if(isset($_GET['clear'])){
		$id=$_GET['id']!=''?'id="'.$_GET['id'].'"':'';
		$timeLines = $GLOBALS['cn']->query('UPDATE tags SET img="" WHERE '.($_GET['id']!=''?'id="'.$_GET['id'].'"':'img!=""'));
	}else{
		$where=$_GET['id']==''?'img=""':'id="'.$_GET['id'].'"';
		$sql='SELECT id FROM tags WHERE '.$where.' ORDER BY id DESC LIMIT 0,'.$limit;
		$timeLines = $GLOBALS['cn']->query($sql);
		$num=mysql_num_rows($timeLines);
		$html='';
		if($num>0){
			$count=0;
			$html.='<br/>';
			while( $tag=mysql_fetch_assoc($timeLines) ){
				$tag['tag']=createTag($tag['id'],true);
				$GLOBALS['cn']->query('UPDATE tags SET img="'.$tag['tag'].'" WHERE id="'.$tag['id'].'"');
				$count++;
				$html.='ID tag: '.$tag['id'].', img: '.$tag['tag'].'<br/>';
			}
			$html.='<hr/>Tags created:'.$count.'<br/>';
		}
	}
	$data=$GLOBALS['cn']->queryRow('SELECT (SELECT COUNT(*) FROM tags WHERE img!="") AS done, (SELECT COUNT(*) FROM tags WHERE img="") AS more');
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

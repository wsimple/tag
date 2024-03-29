<?php
//**********************************************Create Tag ***************************************************
//
//Sirve para crear todas las tags que no existan o actualizarlas mediante los datos de la tabla Tags 
//
//***********************************************************************************************************

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
$relpath=str_replace('\\','/',dirname(__FILE__));
$relpath=preg_replace('/\/[^\/]+$/','',$relpath);
define('RELPATH',"$relpath/");
include RELPATH.'includes/config.php';
include RELPATH.'includes/session.php';
include RELPATH.'includes/functions.php';
// include 'functions.php';
include RELPATH.'class/wconecta.class.php';
include RELPATH.'includes/languages.config.php';
	$limit=10;
	if(isset($_GET['id'])) $where='id="'.$_GET['id'].'"';
	elseif(isset($_GET['idUser'])) $where='id_user="'.$_GET['idUser'].'" AND img=""';
	else $where='img=""';
	$html='';
	if(isset($_GET['clear'])||isset($_GET['clean'])){
		$timeLines = CON::update('tags','img=""','img!=""');
	}elseif(isset($_GET['from'])){
		$timeLines = CON::update('tags','img=""',"id>=?",array($from));
	// }elseif(isset($_GET['missing'])){
	// 	$json=json_decode(file_get_contents($config->img_server_path.'?folder=tags'));
	// 	foreach($json->files as)
	// 	$timeLines = CON::update('tags','img=""','img!=""');
	}else{
		$timeLines = CON::query("SELECT * FROM tags WHERE $where ORDER BY id DESC LIMIT 0,$limit");
		$num=CON::numRows($timeLines);
		if($num>0){
			$count=0;
			$html.='<br/>';
			while($tag=CON::fetchAssoc($timeLines)){
				$tag['tag']=createTag($tag['id'],true,!empty($_GET['id']));
				CON::update('tags','img="'.$tag['tag'].'"','id="'.$tag['id'].'"');
				$count++;
				$html.="ID tag: {$tag['id']}, img: {$tag['tag']}, matrix:{$tag['bgmatrix']} url: ".tagURL($tag['id'])."<br/>";
			}
			$html.="<hr/>Tags created:$count<br/>";
		}
	}
	$data=CON::getRow('SELECT (SELECT COUNT(*) FROM tags WHERE img!="") AS done, (SELECT COUNT(*) FROM tags WHERE img="") AS more');
	//die(json_encode($res));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Tag</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
	if(empty($_GET['id'])&&$data['more']>0){
		$pos=strrpos($_SERVER["PHP_SELF"],'/');
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.substr($_SERVER["PHP_SELF"],$pos+1).'">';
	}
?>
</head>
<body>
<?php
	echo $html;
	if(is_debug('createtag')) echo '<br/>debug';
	echo '<hr/>Tags done:'.$data['done'];
	echo '<br/>Tags pending:'.$data['more'];
	if(!empty($_GET['id'])){
		echo '<br/>Tag:<br/><img src="'.tagURL($_GET['id']).'" width="650"/>';
		$tagURL=preg_replace('/(\/\w+_root)?\/img/','/img_root/img',tagURL($_GET['id']));
		echo '<br/>Tag:<br/><img src="'.str_replace('img_root','web_root',$tagURL).'" width="650"/>';
		echo '<br/>Tag:<br/><img src="'.$tagURL.'" width="650"/>';
	}
?>
</body>
</html>

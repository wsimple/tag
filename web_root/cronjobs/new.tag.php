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
	
	$users = CON::query("SELECT * FROM users ORDER BY id DESC LIMIT 0, $limit");

	while ($user=CON::fetchAssoc($users)){

		
		


	}









	$where = " id_user='9' AND img='' ";

	$timeLines = CON::query("SELECT * FROM tags WHERE $where ORDER BY id DESC LIMIT 0, $limit");
	echo '<pre>';
	while ($tag=CON::fetchAssoc($timeLines)){

		//echo tagURL($tag['id']).' <br> ';
		
		//_imprimir($tag);

		if (fileExists(tagURL($tag['id'])))
		{
			echo 'Tag ('.$tag['id'].'), yes<br>';
		}	
		else
		{
			echo 'Tag ('.$tag['id'].'), NO >> ';
			$tag['tag'] = createTag($tag['id'],true);
			CON::update('tags','img="'.$tag['tag'].'"','id="'.$tag['id'].'"');
			echo '<br><img src="'.tagURL($tag['id']).'" width="150"/><br>';
		}
		//fileExistsRemote($config->video_server.'videos/'.$value);

		// $tag['tag'] = createTag($tag['id'],true);
		
		// CON::update('tags','img="'.$tag['tag'].'"','id="'.$tag['id'].'"');

		// echo '<br/>Tag ('.$tag['id'].'):<br/><img src="'.tagURL($tag['id']).'" width="150"/>';

	}	

	echo '</pre>';

	$data=CON::getRow('SELECT (SELECT COUNT(*) FROM tags WHERE img!="" ) AS done, (SELECT COUNT(*) FROM tags WHERE img="" ) AS more');
?>


<!DOCTYPE html>
<html>
<head>
	<title>Create Tag</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
	echo '('.$data['more'].')';
	if($data['more']>0){
		$pos=strrpos($_SERVER["PHP_SELF"],'/');
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.substr($_SERVER["PHP_SELF"],$pos+1).'">';
	}
?>
</head>
<body>
<?php echo 'so far: '.$data['done']; ?>
</body>
</html>






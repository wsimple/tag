<?php 
//Constantes usadas
$numero_intentos = 40;
$numero_tags = 2;
$debug=(isset($_GET['debug']));
set_time_limit ( 600 );
//Faker
require_once 'src/autoload.php';
include '../../includes/config.php';
include '../../includes/session.php';
include '../../includes/functions.php';
include '../../class/wconecta.class.php';
include '../../includes/languages.config.php';
include '../../includes/funciones_upload.php';

if($debug)echo '<pre>';

$faker = Faker\Factory::create('en_US');
$tiempoGeneracion=time();

$query=CON::query('SELECT id FROM users WHERE referee_user=? ORDER BY RAND() LIMIT '.$numero_intentos,array('112233'));
$cont=0;
	while($user=CON::fetchAssoc($query)){
		$cont++;
		$id=$user['id'];

		$files = glob('../../img/templates/0/*.jpg');
		$imagesTag = array_rand($files, $numero_tags);

		foreach ($imagesTag as $key  ) {
			$imgTag=$files[$key];
			$args=explode('/',$imgTag);
			$imgTag=strtolower(end($args));
			$imgTag='0/'.$imgTag;
			$idTag=CON::insert('tags','id_user=?,id_creator=?,background=?,profile_img_url=?,code_number="",text="&nbsp",text2="&nbsp",status=1',array($id,$id,$imgTag,$url));
			CON::update('tags', 'source=?', 'id=?',array($idTag, $idTag));
			if($idTag) createTag($idTag,true);
		}
		
		if($debug)echo "<br>#### - Despues de tags ".(time()-$tiempoGeneracion).'s <br>';
		$aSeguir=$faker->numberBetween(50, 100);
		$query2=CON::query('SELECT id FROM users WHERE referee_user=? and id<>? ORDER BY RAND() LIMIT '.$aSeguir,array('112233',$id));

		while($user2=CON::fetchAssoc($query2)){
			$idASeguir=$user2['id'];
			CON::insert('users_links','id_user=?,id_friend=?',array($idASeguir,$id));
			if($debug)echo "<br>#### - Links: ".CON::lastSql().' <br>';;
		}
		CON::update("users","followers_count=followers_count+?","id=?",array($aSeguir,$id));
    }

 	
    $self = $_SERVER['PHP_SELF']; 
	if(!$debug)header("refresh:0; url=$self");
	echo "<br>#### - Total: ".(time()-$tiempoGeneracion).'s '.$cont.'<br>';

?>
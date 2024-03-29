<?php 

//Constantes usadas
//
$src_images = 'images';
$destination = 'done';
$numero_intentos = 40;
$debug=(isset($_GET['debug']));
set_time_limit ( 600 );
//Faker
require_once 'src/autoload.php';

include '../../includes/config.php';
include '../../includes/session.php';
include '../../includes/functions.php';
include '../../class/wconecta.class.php';
include '../../includes/funciones_upload.php';

if($debug)echo '<pre>';

$fakerUS = Faker\Factory::create('en_US');
//if($debug)echo $fakerUS->name."\n";
$fakerVE = Faker\Factory::create('es_VE');
//if($debug)echo $fakerVE->name."\n";
$fakerMX = Faker\Factory::create('es_MX');
//if($debug)echo $fakerMX->name."\n";


if ($gestor = opendir($src_images)) {
 	$contador = 0;$tiempoGeneracion=time();

    while( (false !== ($entrada = readdir($gestor)))) {
    	if(($entrada!='.')&&($entrada!='..')){
    		$args=explode('/',$entrada);
			$entrada=strtolower(end($args));
			if(($entrada!='')&&($entrada!='.ds_store')){
    			$entradas[]=$entrada ;
    		}	
    	}
    }
   closedir($gestor);
    if(!count($entradas)) die('No hay imagenes para generar usuarios.');
    if($numero_intentos>count($entradas))$numero_intentos=count($entradas);

    $entradasRandom = array_rand($entradas, $numero_intentos);	

	foreach ($entradasRandom as $key  ) {
			$entrada=$entradas[$key];
			
		
    		
    		//La cantidad de entradas en el random
    		//marcan la cantidad viable de tipos de usuario 2 US, 2 VE, 1 MX
    		$rdm_locale = $fakerUS->randomElement($array = array ('US','US','US','US','US','VE','VE','MX','MX'));
    		// Se tiene que agrear un faker por cada tipo de usuario a crear
    		$rdm_preferences = array('Carros','Amigos','Compartir','ir Cine','La Comida','Amor','Paseos','Las Motos','Escalar','Manejar Bicicleta','El Futbol','Nadar');
			switch ($rdm_locale) {
			    case 'US': $faker = $fakerUS; $lang = 'en'; $country= 223; 
			    	$rdm_preferences = array('Cars','Friends','Movies','Mood','Love','Rides','Bikes','Fun','Bike','Football','Swimming');break;
			    case 'VE': $faker = $fakerVE; $lang = 'es'; $country= 229; break;
			    case 'MX': $faker = $fakerMX; $lang = 'es'; $country= 131; break;
			}

			//Revisa que los correos generados no esten en la BD
			do {
				$firstName = normalize_special_characters($faker->firstName($gender = null|'male'|'female'));
				$lastName = normalize_special_characters($faker->lastName);
				$rdm_separator = $faker->randomElement(array('','_','.'));
				$name = $faker->randomElement(array($firstName .' '. $lastName, 
												 $lastName.' '.$firstName , 
												 $lastName.$firstName[0].$faker->year(),
												 $firstName.$firstName[0].$faker->year(),
												 $faker->userName
												 ));
				$mail = $name.'@'.$faker->freeEmailDomain;
				$mail = strtolower($mail);
				$mail = str_replace(' ',$rdm_separator,$mail);
				$mail = normalize_special_characters($mail);
				$existEmail=CON::exist('users','email=?',array($mail));
			} while ($existEmail);
        	

			$data['email']=$mail;
			$data['password']=$faker->word.$faker->word;
			$data['screenName']=$firstName;
			$data['first_name']=$firstName;
			$data['last_name']=$lastName;
			$data['birthday']=$faker->date('Y-m-d','-13 years');
			$data['sex']=$faker->randomElement($array = array ('2','1'));
			$data['zipCode']=$faker->postcode;
			$data['lang']=$lang;
			$data['country']=$country;
			$data['address']=$faker->address;
			$data['interest']=$faker->randomElement($array = array ('3','2','1'));
			$data['relationship']=$faker->randomElement($array = array ('1','2','3','4','5','6','7','8'));

			
			$referee_number='112233';
			$referee_user='112233';

			if($debug)echo "<br>#### -  [[email]]: ".$data['email']." [[first_name]]: ".$data['first_name']." [[last_name]]: ".$data['last_name'];

			if($debug)echo "<br>#### - Antes del primer insert ".(time()-$tiempoGeneracion).'s <br>';

			$id=CON::insert('users','
				username="",url="",profile_image_url="",description="",state="",city="",password_system="",
				followers_count=0,friends_count=0,tags_count=0,time_zone="",status=1,created_at=NOW(),last_update=NOW(),show_my_birthday=1,
				email=?,password_user=?,type=?,
				screen_name=?,name=?,last_name=?,
				date_birth=?,sex=?,fbid=?,
				location=?,zip_code=?,language=?,
				referee_number=?,referee_user=?,country=?,address=?,interest=?,relationship=?,wish_to=7
			',array(
				$data['email'],$data['password'],0,
				$data['screenName'],$data['first_name'],$data['last_name'],
				date('Y-m-d',strtotime($data['birthday'])),$data['sex'],$data['fbid'],
				$_SERVER['REMOTE_ADDR'],$data['zipCode'],$data['lang'],
				$referee_number,$referee_user,$data['country'],$data['address'],
				$data['interest'],$data['relationship']

			));
			if($id > 0){

				if($debug)echo "<br>#### - Despues del primer insert, antes de mover img ".(time()-$tiempoGeneracion).'s <br>'; 
				$key=md5($id.'_'.$data['email'].'_'.$id);

				$fullpathLocal='../../img/users/'.$key.'/';

				if(!is_dir($fullpathLocal)){
					$old=umask(0);
					mkdir($fullpathLocal,0777);
					umask($old);
					$fp=fopen($fullpathLocal.'index.html','w');
					fclose($fp);
				}
				
				$data['img']=array(
					'error'    => 1,
					'name'     => $entrada ,
					'tmp_name' => $fullpathLocal.$entrada
				);

				rename ( $src_images.'/'.$entrada , $data['img']['tmp_name']  );

				$url=uploadImage($data['img'],'profile','users',$key,$id);// key = userCode
				if($debug)echo "<br>#### -  [[Url]]: ".$url ." #".$contador."\n";

				if($debug)echo "<br>#### - Despues de mover la img usuario ".(time()-$tiempoGeneracion).'s <br>';
				//numero de usuarios a seguir
				$aSeguir=$faker->numberBetween(30, 100); //##### aca para evitar hacer dos updates

				if($url!='IMAGE_NOT_ALLOWED'){
					CON::update("users","profile_image_url=?,updatePicture=1,following_count=?","id=?",array($url,$aSeguir,$id));
					if($debug)echo "<br>#### - Despues de update Foto de usuario ".(time()-$tiempoGeneracion).'s <br>';
				}else{

					$url='';
				}
				
				//Sets random Preferences
				$preference[1] = $faker->randomElements($rdm_preferences,4);
				$preference[2] = $faker->randomElements($rdm_preferences,4);
				$preference[3] = $faker->randomElements($rdm_preferences,4);

				 
				for ($i=0; $i < $faker->numberBetween(3,15 ); $i++)	array_push ($preference[1],$faker->numberBetween(1, 2500));
				for ($i=0; $i < $faker->numberBetween(3,15 ); $i++)	array_push ($preference[2],$faker->numberBetween(1, 2500));
				for ($i=0; $i < $faker->numberBetween(3,15 ); $i++)	array_push ($preference[3],$faker->numberBetween(1, 2500));
				

				CON::insert('users_preferences','id_user=?,id_preference=1,preference=?',array($id,implode(',',$preference[1])));
				CON::insert('users_preferences','id_user=?,id_preference=2,preference=?',array($id,implode(',',$preference[2])));
				CON::insert('users_preferences','id_user=?,id_preference=3,preference=?',array($id,implode(',',$preference[3])));

				if($debug)echo "<br>#### - Despues de users_preferences ".(time()-$tiempoGeneracion).'s <br>';


				$files = glob('../../img/templates/0/*.jpg');
				$numeroTags=$faker->numberBetween(2, 6);
 				$imagesTag = array_rand($files, $numeroTags);

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


				CON::insert('business_card','id_user=?,email=?,company="Social Media Marketing",middle_text="www.Tagbum.com",type=0',array($id,$data['email']));

				

			   for ($i=0; $i < $aSeguir ; $i++) { 
					$idASeguir=$faker->numberBetween(1, $id); 
					CON::insert('users_links','id_user=?,id_friend=?',array($id,$idASeguir));
					CON::insert('users_notifications','id_type=?,id_source=?,id_user=?,id_friend=?,revised=0',array(11,$id,$id,$idASeguir));
					
				}

				if($debug)echo "<br>#### - Despues de users_links ".(time()-$tiempoGeneracion).'s <br>';
				if($url=='IMAGE_NOT_ALLOWED'){//##### para evitar hacer dos updates
					CON::update("users","following_count=?","id=?",array($aSeguir,$id));
				}	


				//unlink($src_images.'/'.$entrada);
			}//if insert user
    	
    }
 	
    $self = $_SERVER['PHP_SELF']; 
	if(!$debug)header("refresh:0; url=$self");
	echo "<br>#### - Total: ".(time()-$tiempoGeneracion).'s <br>';
}

function normalize_special_characters( $str ) 
{ 
    # Quotes cleanup 
    $str = ereg_replace( chr(ord("`")), "", $str );        # ` 
    $str = ereg_replace( chr(ord("´")), "", $str );        # ´ 
    $str = ereg_replace( chr(ord("„")), "", $str );        # „ 
    $str = ereg_replace( chr(ord("`")), "", $str );        # ` 
    $str = ereg_replace( chr(ord("´")), "", $str );        # ´ 
    $str = ereg_replace( chr(ord("“")), "", $str );        # “ 
    $str = ereg_replace( chr(ord("”")), "", $str );        # ” 
    $str = ereg_replace( chr(ord("´")), "", $str );        # ´ 

    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' ); 
    $str = strtr( $str, $unwanted_array ); 

    # Bullets, dashes, and trademarks 
    $str = ereg_replace( chr(149), "", $str );    # bullet • 
    $str = ereg_replace( chr(150), "", $str );    # en dash 
    $str = ereg_replace( chr(151), "", $str );    # em dash 
    $str = ereg_replace( chr(153), "", $str );    # trademark 
    $str = ereg_replace( chr(169), "", $str );    # copyright mark 
    $str = ereg_replace( chr(174), "", $str );    # registration mark 

    return $str; 
}
?>
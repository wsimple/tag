<?php
include '../header.json.php';
include RELPATH.'includes/funciones_upload.php';
include RELPATH.'class/validation.class.php';

$myId=$_SESSION['ws-tags']['ws-user']['id'];
$code=$_SESSION['ws-tags']['ws-user']['code'];

if ($_POST['disAssociateFB']=='1'){
	$res=array();
	$array = $GLOBALS['cn']->queryRow('SELECT fbid FROM users WHERE id="'.$myId.'" '); 
	if (count($array)>0){
		CON::update("users","fbid=NULL","id=?",array($myId));
		$res['out'] = '1';
	}else{
		$res['out'] = '0';
	}
	die(jsonp($res));
}

if (isset($_GET['skipProgress'])){
	$_SESSION['ws-tags']['ws-user']['progress']['omitir']=1;
	die();
}else unset($_SESSION['ws-tags']['ws-user']['progress']);

#ini
$res=array();
#arreglo de datos que se recibiran
$data=array();
$data['action']=isset($_REQUEST['action'])?$_REQUEST['action']:$_REQUEST['validaActionAjax'];
$data['img64']=$_POST['img64'];
$data['day']=isset($_POST['day'])?$_POST['day']:$_POST['frmProfile_day'];
$data['month']=isset($_POST['month'])?$_POST['month']:$_POST['frmProfile_month'];
$data['year']=isset($_POST['year'])?$_POST['year']:$_POST['frmProfile_year'];
$data['username']=isset($_POST['username'])?$_POST['username']:$_POST['frmProfile_userName'];
$data['firstname']=isset($_POST['firstname'])?$_POST['firstname']:$_POST['frmProfile_firstName'];
$data['lastname']=isset($_POST['lastname'])?$_POST['lastname']:$_POST['frmProfile_lastName'];
$data['lang']=isset($_POST['lang'])?$_POST['lang']:$_POST['frmProfile_cboLanguageUsr'];
$data['screenname']=isset($_POST['screenname'])?$_POST['screenname']:$_POST['frmProfile_screenName'];
$data['personal_messages']=isset($_POST['personal_messages'])?$_POST['personal_messages']:$_POST['frmProfile_messagePersonal'];
$data['showbday']=isset($_POST['showbday'])?$_POST['showbday']:$_POST['frmProfile_showbirthday'];
$data['country']=isset($_POST['country'])?$_POST['country']:$_POST['frmProfile_cboFrom'];
$data['sex']=isset($_POST['sex'])?$_POST['sex']:$_POST['frmProfile_sex'];
$data['interest']=isset($_POST['interest'])?$_POST['interest']:$_POST['frmProfile_interest'];
$data['relationship']=isset($_POST['relationship'])?$_POST['relationship']:$_POST['frmProfile_relationship'];
$data['wish_to']=isset($_POST['wish_to'])?$_POST['wish_to']:$_POST['frmProfile_wish_to'];
$data['taxid']=isset($_POST['taxid'])?$_POST['taxid']:$_POST['frmProfile_taxId'];
$data['zipcode']=isset($_POST['zipcode'])?$_POST['zipcode']:$_POST['frmProfile_zipCode'];
$data['paypal']=isset($_POST['paypal'])?$_POST['paypal']:$_POST['frmProfile_paypal'];
$data['x']=isset($_POST['x'])?$_POST['x']:0;
$data['y']=isset($_POST['y'])?$_POST['y']:0;
$data['w']=$_POST['w'];
$data['h']=$_POST['h'];
$data['size']=$_POST['size'];
$data['home_code']=isset($_POST['home_code'])?$_POST['home_code']:$_POST['frmProfile_home_code'];
$data['work_code']=isset($_POST['work_code'])?$_POST['work_code']:$_POST['frmProfile_work_code'];
$data['mobile_code']=isset($_POST['mobile_code'])?$_POST['mobile_code']:$_POST['frmProfile_mobile_code'];
$data['home_phone']=isset($_POST['home_phone'])?$_POST['home_phone']:$_POST['frmProfile_home'];
$data['work_phone']=isset($_POST['work_phone'])?$_POST['work_phone']:$_POST['frmProfile_work'];
$data['mobile_phone']=isset($_POST['mobile_phone'])?$_POST['mobile_phone']:$_POST['frmProfile_mobile'];
$data['bg_color']=isset($_POST['bg_color'])?$_POST['bg_color']:$_POST['profileHiddenColor'];
if (is_array($_POST['city'])){
	$city=$_POST['city'][0];
	if (is_numeric($city)) $city=CON::getVal("SELECT name FROM cities WHERE id=?",array($city));
}else $city=$_POST['city'];
$data['city']=$city;
if(isset($_FILES['frmProfile_filePhoto'])){
	$data['img']=$_FILES['frmProfile_filePhoto'];

}
if(isset($_FILES['img']))
	$data['img']=$_FILES['img'];
if(isset($_FILES['background']))
	$data['background']=$_FILES['background'];
if(isset($_FILES['profile_background_file']))
	$data['background']=$_FILES['profile_background_file'];
if(isset($_FILES['frmProfile_fileCover']))
	$data['cover']=$_FILES['frmProfile_fileCover'];

#si se estan guardando datos
if($data['action']=='picture'||$data['action']=='filePhoto'){
	#imagen en base64 - se transforma a imagen regular
	if($data['img64']!=''){
		$imgData=base64_decode(preg_replace('/^data:image\/\w*;base64,/i','',$data['img64']));
		$path=RELPATH.'img/temp/';
		$name=md5(date('Ymdgisu')).'.jpg';
		$photo=$path.$name;
		$data['img']=array(
			'error'=>1,
			'name'=>$photo,
			'tmp_name'=>$photo
		);
		$fp=fopen($photo,'w');
		if($fp){
			fwrite($fp,$imgData);
			fclose($fp);
			$data['img']['error']=0;
		}
		unset($imgData,$path,$photo);
	}
	if (isset($data['img']) && $data['img']['error']==4) unset($data['img']);
	#se esta subiendo una imagen
	if(isset($data['img'])){
		if($data['img']['error']==0||!is_array($data['img'])){
			$url=uploadImage($data['img'],'profile','users',$code,$myId);
			$res['img']['url']=$url;
			if($url!='IMAGE_NOT_ALLOWED'){
				CON::update("users","profile_image_url=?,updatePicture=1","id=?",array($url,$myId));
				createSession(array('photo'=>$url,'updatePicture'=>1),FALSE);
			}else{
				$res['upload']='file error';
			}
		}elseif(count($data['img'])){//subio foto pero hubo error
			$res['upload']='error uploading';
		}
	}
	$res['img']=$data['img'];
	#destruir imagen temporal (si fue creada desde un base64)
//	if($data['img64']!=''&&isset($data['img']['tmp_name']))
//		unlink($data['img']['tmp_name']);
	#datos de redimencion
	$photo="img/users/$code/".$_SESSION['ws-tags']['ws-user']['photo'];
	header("data-photo: $photo");
	header("data-photo-path: ".$config->img_server_path.$photo);
	$thumb=generateThumbPath($photo,true);
	header("data-thumb: $thumb");
	#se crea la thumb si se ha subido foto o si se cambio el tamaño
	if(!strpos($thumb,'default')&&in_array($res['upload'],array('','done'))){
		if($data['size']){
			$x=$data['x'];
			$y=$data['y'];
			$size=$data['size'];
		}elseif($data['w']){
			$x=$data['x'];
			$y=$data['y'];
			$size=$data['w']>$data['h']?$data['h']:$data['w'];
		}elseif(isset($data['img'])){
			$is=getimagesize($config->img_server_path.$photo);
			$x=$y=abs($is[0]-$is[1])/2;
			if($is[0]>$is[1]){
				$y=0;
				$size=$is[1];
			}else{
				$x=0;
				$size=$is[0];
			}
		}
		if ($size==''){
			$is=getimagesize($config->img_server_path.$photo);
			$x=$y=abs($is[0]-$is[1])/2;
			if($is[0]>$is[1]){
				$y=0;
				$size=$is[1];
			}else{
				$x=0;
				$size=$is[0];
			}
		}
		$x=$x!=''?$x:0;
		$y=$y!=''?$y:0;
		header("data-beforcreate-photo: ".$config->img_server_path.$photo);
		header("data-beforcreate-thumb: $config->relpath/$thumb");
		CreateThumb($config->img_server_path.$photo,"$config->relpath/$thumb",60,$x,$y,$size,$size);
		header("data-aftercreate: 1");
		FTPupload(end(explode('img/',$thumb)));
		$_SESSION['ws-tags']['ws-user']['updatePicture']=0;
		$GLOBALS['cn']->query("UPDATE users SET updatePicture=0 WHERE id='$myId'");
		$res['resize']='done';
		$res['success']='filePhoto';
	}else{
		unset($photo);
	}
	if($data['action']=='picture') die(jsonp($res));
}

if($data['action']=='save'){
	#fecha de nacimiento
	if(checkdate($data['month'],$data['day'],$data['year'])){
	   $result=$GLOBALS['cn']->queryRow('SELECT now() FROM users WHERE DATE(NOW())>"'.$data['year'].'-'.$data['month'].'-'.$data['day'].'" LIMIT 1;');  
       $row=current($result);
       if ($row){ $bdate=$data['year'].'-'.substr('0'.$data['month'],-2).'-'.substr('0'.$data['day'],-2); }
       else{ 
            $res['error']=lan('SIGNUP_CTRERRORBIRTHDATE'); die(jsonp($res)); 
        }
	}else{
		$res['error']=lan('SIGNUP_CTRERRORBIRTHDATE'); die(jsonp($res));
	}
	#user name
	$sql_userName='';
	if($data['username']){
		if(!valid::isAlphaNumeric($data['username'])){
			$res['error']=lan('USERPROFILE_CTRERRORUSERNAMENOFORMAT'); die(jsonp($res));
		}
		#verificar que no use nombres de carpetas de Tagbum
		$d=dir('.');
		while(($entry=$d->read())!==false){
			if($data['username']==$entry){
				$res['error']=lan('USERPROFILE_CTRERRORUSERNAMEDUPLICATE'); die(jsonp($res));
			}
		}
		$d->close();
		#verificar que el nombre no esta en uso
		if(!existe('users','username'," WHERE username='".$data['username']."' AND id!='$myId'")){
			$sql_userName=",username='".$data['username']."'";
		}else{
			$res['error']=lan('USERPROFILE_CTRERRORUSERNAMEDUPLICATE'); die(jsonp($res));
		}
		$_SESSION['ws-tags']['ws-user']['username']=$data['username'];
	}else $_SESSION['ws-tags']['ws-user']['username']='';
	#si cambia nombre o apellido editamos nombre completo
	if ($_SESSION['ws-tags']['ws-user']['type']!='1'){
		if($data['firstname']==''){
		// if(!valid::isAlpha($data['firstname']) || $data['firstname']==''){
			$res['error']=lan('SIGNUP_CTRERRORNAME'); die(jsonp($res));			
		}
		if($data['lastname']==''){
		// if(!valid::isAlpha($data['lastname']) || $data['lastname']==''){
			$res['error']=lan('SIGNUP_CTRERRORLASTNAME'); die(jsonp($res));			
		}
	}
	$temporal=$data['firstname'].' '.$data['lastname'];
	if( $_SESSION['ws-tags']['ws-user']['full_name']!=$temporal ) {
		$name_change=true;
		$_SESSION['ws-tags']['ws-user']['full_name']=$temporal;
	}
	$_SESSION['ws-tags']['ws-user']['name']=$data['firstname'];
	$_SESSION['ws-tags']['ws-user']['last_name']=$data['lastname'];
	#si se cambia el idioma
	if( $_SESSION['ws-tags']['ws-user']['language']!=$data['lang'] ) {
		$updateLanguage=true;
		$_SESSION['ws-tags']['ws-user']['language']=$data['lang'];
	}
	if (isset($data['wish_to'])) $data['wish_to']=array_sum($data['wish_to']);
	
	$_SESSION['ws-tags']['ws-user']['screen_name']=$data['screenname'];
	$_SESSION['ws-tags']['ws-user']['date_birth']=$bdate;
	$_SESSION['ws-tags']['ws-user']['show_birthday']=$data['showbday'];
	$_SESSION['ws-tags']['ws-user']['country']=$data['country'];
	$_SESSION['ws-tags']['ws-user']['city']=$data['city'];
	$_SESSION['ws-tags']['ws-user']['sex']=$data['sex'];
	$_SESSION['ws-tags']['ws-user']['taxId']=$data['taxid'];
	$_SESSION['ws-tags']['ws-user']['paypal']=$data['paypal'];
	$_SESSION['ws-tags']['ws-user']['interest']=$data['interest'];
	$_SESSION['ws-tags']['ws-user']['relationship']=$data['relationship'];
	$_SESSION['ws-tags']['ws-user']['wish_to']=$data['wish_to'];
	$_SESSION['ws-tags']['ws-user']['personal_messages']=$data['personal_messages'];

	#telefonos
	$home_area=$data['home_code']?current($GLOBALS['cn']->queryRow('SELECT code_area FROM countries WHERE id="'.$data['home_code'].'"')):'';
	$work_area=$data['work_code']?current($GLOBALS['cn']->queryRow('SELECT code_area FROM countries WHERE id="'.$data['work_code'].'"')):'';
	$mobile_area=$data['mobile_code']?current($GLOBALS['cn']->queryRow('SELECT code_area FROM countries WHERE id="'.$data['mobile_code'].'"')):'';
	$_SESSION['ws-tags']['ws-user']['home_phone']=$home_area.'-'.$data['home_phone'];
	$_SESSION['ws-tags']['ws-user']['work_phone']=$work_area.'-'.$data['work_phone'];
	$_SESSION['ws-tags']['ws-user']['mobile_phone']=$mobile_area.'-'.$data['mobile_phone'];

	#telefono en business card
	$bc='
		SELECT id FROM business_card
		WHERE
			id_user				= '.$myId.' AND
			company				= "Social Media Marketing" AND
			middle_text			= "www.Tagbum.com" AND
			address				= "" AND
			specialty			= "" AND
			company_logo_url	= "" AND
			background_url		= "" AND
			type				= 0 AND
			text_color			= "#000000"
	';
	$n_bc=$GLOBALS['cn']->queryRow($bc);
	if(count($n_bc)>0){
		$bc='
			UPDATE business_card SET
				home_phone	="'.$_SESSION['ws-tags']['ws-user']['home_phone'].'",
				work_phone	="'.$_SESSION['ws-tags']['ws-user']['work_phone'].'",
				mobile_phone="'.$_SESSION['ws-tags']['ws-user']['mobile_phone'].'"
			WHERE id="'.$n_bc['id'].'"
		';
		$bc=$GLOBALS['cn']->query($bc);
	}

	#cambio de pais
	$sql_pais=',country="'.($data['country']?$data['country']:'0').'"';

	#cambio de zip code
	if($data['zipcode']!=$_SESSION['ws-tags']['ws-user']['zip_code']){
		$result=current($GLOBALS['cn']->queryRow('SELECT ZIP_CODE FROM zip_codes WHERE ZIP_CODE="'.$data['zipcode'].'"'));
		if($result){
			$updateZipCode='1';
		}else{
			//$updateZipCode='2';//ver luego, esto era validando con la tabla zipcodes de usa solamente
			$updateZipCode='1';
		}
		$_SESSION['ws-tags']['ws-user']['zip_code']=$data['zipcode'];
		$sql_zip_code="zip_code='".$data['zipcode']."',";
	}else{
		$updateZipCode='0';
	}
}

//validating if he comes to save, change background, background by default, or background color
if (($data['action']=='save')||($data['action']=='backgroundFile')||($data['action']=='backgroundDefault')||($data['action']=='HiddenColor')){
	#cambio de fondo
	if($data['action']=='bg_default'){
		$_SESSION['ws-tags']['ws-user']['user_background']='';
	}elseif($data['background']&&$data['background']['error']==0){
		$allowedImages=array('jpg','jpeg','png','gif');
		$parts=explode('.',$data['background']['name']);
		$ext=strtolower(end($parts));
		if(in_array($ext,$allowedImages)){
			$path=RELPATH."img/users_backgrounds/$code/";
			$fondo=md5($data['background']['name']).'.'.$ext;
			$_fondo=$code.'/'.$fondo;
			if(!is_dir($path)){
				$old=umask(0);
				mkdir($path,0777);
				umask($old);
				$fp=fopen($path.'index.html',"w");
				fclose($fp);
			}
			if(copy($data['background']['tmp_name'],RELPATH.'img/users_backgrounds/'.$_fondo)){
				$_SESSION['ws-tags']['ws-user']['user_background']=$_fondo;
				uploadFTP($fondo,'users_backgrounds');
			}
		}else{
			$res['error']=ERROR_UPLOADING_PROFILE_PICTURE;
			die(jsonp($res));
		}
	}elseif($data['bg_color']){
		$_SESSION['ws-tags']['ws-user']['user_background']=$data['bg_color'];
	}
}
//cambiando el cover del external rofile
if ($data['action']=='fileCover'){
	if( $data['cover']['error']==0 ) {
		$imagesAllowed = array('jpg','jpeg','png','gif');
		$parts         = explode('.', $data['cover']['name']);
		$ext           = strtolower(end($parts));
		if( in_array($ext, $imagesAllowed) ) {
			$path  = "$config->relpath/img/users_cover/".$_SESSION['ws-tags']['ws-user']['code'].'/';//ruta para crear dir
			$photo = $_SESSION['ws-tags']['ws-user']['code'].'/'.md5(str_replace(' ', '', $data['cover']['name'])).'.jpg';
			//existencia de la folder
			if(!file_exists($path)){
				mkdir($path,0775,true);
			}
			// if( !is_dir ($path) ) {
			// 	// $old = umask(0);
			// 	mkdir($path,0777);
			// 	umask($old);
			// 	$fp=fopen($path.'index.html',"w");
			// 	fclose($fp);
			// }// is_dir
			if(redimensionar($data['cover']['tmp_name'], "$config->relpath/img/users_cover/".$photo, 845) ) {
				FTPupload('users_cover/'.$photo);
				$res['success']='cover';
				$res['cover']=$photo;
				$_SESSION['ws-tags']['ws-user']['user_cover'] = $photo;
			}else{ $res['error']=lan('ERROR_UPLOADING_PROFILE_PICTURE'); }
		}else{ $res['error']=lan('ERROR_UPLOADING_PROFILE_PICTURE'); }
	}else{ $res['error']=lan('ERROR_UPLOADING_PROFILE_PICTURE'); }
}
$user=$_SESSION['ws-tags']['ws-user'];

switch ($data['action']){
	case 'save':#actualizamos la base de datos
		CON::update("users","screen_name		= ?,
							name				= ?,
							last_name			= ?,
							date_birth			= ?,
							profile_image_url	= ?,
							show_my_birthday	= ?,
							home_phone			= ?,
							mobile_phone		= ?,
							work_phone			= ?,
							language			= ?,
							user_background		= ?,
							country				= ?,
							city				= ?,
							sex					= ?,
							paypal				= ?,
							zip_code			= ?,
							interest			= ?,
							relationship		= ?,
							wish_to				= ?,
							personal_messages	= ?,
							taxId				= ?
							$sql_pais
							$sql_userName","id=?",
				array($user['screen_name'],$user['name'],$user['last_name'],$user['date_birth'],$user['photo'],
				$user['show_birthday'],$user['home_phone'],$user['mobile_phone'],$user['work_phone'],
				$user['language'],$user['user_background'],$user['country'],$user['city'],$user['sex'],
				$user['paypal'],$user['zip_code'],$user['interest'],$user['relationship'],$user['wish_to'],
				$user['personal_messages'],$user['taxId'],$myId));
		$_SESSION['ws-tags']['ws-user']['progress']['value']=calculateProgress();
		$res['noFails']=$_SESSION['ws-tags']['ws-user']['progress']['value']['noFails'];
	break;
	case 'filePhoto':#actualizamos solo la imagen
		CON::update("users","profile_image_url=?","id=?",array($user['photo'],$user['id']));
	break;
	case 'fileCover':#actualizamos solo la imagen
		CON::update("users","user_cover=?","id=?",array($user['user_cover'],$user['id']));
	break;
	case 'backgroundFile': case 'backgroundDefault': case 'HiddenColor':
		CON::update("users","user_background=?","id=?",array($user['user_background'],$user['id']));
		$user_background=$data['action'];
	break;
}

//retornando los cambios del profile
	if($name_change){
		$res['success']=$data['firstname'].' '.$data['lastname'];
	}elseif($updateZipCode=='2'){ //"WRONG_ZIP"
		$res['error']=lan("SIGNUP_CTRMSJERRORZIPCODE");;
	}elseif($updateLanguage){
		$res['success']='updateLanguage';
	}elseif($url){
		if(!fileExists(($config->local?RELPATH:$config->imgserver)."img/users/$code/".$_SESSION['ws-tags']['ws-user']['photo'])){
			$_SESSION['ws-tags']['ws-user']['updatePicture']=0;
			$_SESSION['ws-tags']['ws-user']['photo']='';
			CON::update("users","updatePicture='0'","id=?",array($myId));
			$res['error']=lan('ERROR_UPLOADING_PROFILE_PICTURE');
		}else $res['success']='filePhoto';
	}elseif($error_uploading_pp){
		$res['error']=lan('ERROR_UPLOADING_PROFILE_PICTURE');
	}elseif($user_background){
		$res['success']=$user_background=='backgroundFile'?'pbackg':'backg';
		$res['backg']=$user['user_background'];
	}elseif($data['action']=='save'){
		$res['success']='save';		
	}

$_SESSION['ws-tags']['ws-user']['pic']="img/users/$code/".$_SESSION['ws-tags']['ws-user']['photo'];
$_SESSION['ws-tags']['ws-user']['paypal']=$data['paypal'];

die(jsonp($res));
?>

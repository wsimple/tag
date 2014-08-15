<?php
include 'includes/funciones_upload.php';
include 'class/validation.class.php';
if (quitar_inyect()){
	
	//validating if he comes to save
	if ($_POST['validaActionAjax']=='save'){
		// Birth Date
		if(checkdate($_POST['frmProfile_month'],$_POST['frmProfile_day'],$_POST['frmProfile_year'])){
           $result=$GLOBALS['cn']->queryRow('SELECT now() FROM users WHERE DATE(NOW())>"'.$_POST['frmProfile_year'].'-'.$_POST['frmProfile_month'].'-'.$_POST['frmProfile_day'].'" LIMIT 1;');  
           $row=current($result);
           if ($row){ $date_birth = $_POST['frmProfile_year'].'-'.substr('0'.$_POST['frmProfile_month'],-2).'-'.substr('0'.$_POST['frmProfile_day'],-2); }
           else{ die('SIGNUP_CTRERRORBIRTHDATE'); }
		}else die('SIGNUP_CTRERRORBIRTHDATE');
		// END - Birth Date
		// User Name
		$sql_userName	='';
		$error_username	='';
		if($_POST['frmProfile_userName']){
			if(!valid::isAlphaNumeric($_POST['frmProfile_userName'])){
				$error_username='ERROR_USERNAME_FORMAT';
			}else{
				// verificar que no use nombres de carpetas de Tagbum
				$d=dir('.');
				while(false!==($entry = $d->read())){
					if($_POST['frmProfile_userName']==$entry){ $error_username = "ERROR_USERNAME_DUPLICATE"; }
				}
				$d->close();
				// END - verificar que no use nombres de carpetas de Tagbum
				if( !$error_username ) {
					if( !existe("users", "username", " WHERE username = '".$_POST['frmProfile_userName']."' AND id != '".$_SESSION['ws-tags']['ws-user']['id']."' ") ) {
						$sql_userName = ", username = '".$_POST['frmProfile_userName']."'";
					} else { $error_username = "ERROR_USERNAME_DUPLICATE"; }
				}
			}
		}
		// END - User Name
	}

	//cambiando el cover del external rofile
	if ($_POST['validaActionAjax']=='fileCover'){
		// print_r($_FILES);
		// print_r($_POST);
		if( $_FILES[frmProfile_fileCover][error]==0 ) {
			$imagesAllowed = array('jpg','jpeg','png','gif');
			$parts         = explode('.', $_FILES[frmProfile_fileCover][name]);
			$ext           = strtolower(end($parts));

			if( in_array($ext, $imagesAllowed) ) {
				$path  = RELPATH."users_cover/".$_SESSION['ws-tags']['ws-user'][code].'/';//ruta para crear dir
				$photo = $_SESSION['ws-tags']['ws-user'][code].'/'.md5(str_replace(' ', '', $_FILES[frmProfile_fileCover][name])).'.jpg';
				//existencia de la folder
				if( !is_dir ($path) ) {
					$old = umask(0);
					mkdir($path,0777);
					umask($old);
					$fp=fopen($path.'index.html',"w");
					fclose($fp);
				}// is_dir

				if( redimensionar($_FILES[frmProfile_fileCover][tmp_name], RELPATH."img/users_cover/".$photo, 845) ) {
					FTPupload('users_cover/'.$photo);
					echo $photo;
					$_SESSION['ws-tags']['ws-user']['user_cover'] = $photo;

				}else{
					echo '0';//error redimension
				}//copy

			} else {
				echo '0';//error extension
			}
		}else{
			echo '0'; //error internov
		}//$_FILES
	}

	//validating if he comes to save, or change profile picture
	if (($_POST['validaActionAjax']=='save')||($_POST['validaActionAjax']=='filePhoto')){
		// uploading new profile image
		if($_FILES['frmProfile_filePhoto']['error']==0){
			$profile_image_url=uploadImage($_FILES['frmProfile_filePhoto'],'profile','users',$_SESSION['ws-tags']['ws-user']['code'],$_SESSION['ws-tags']['ws-user']['id']);
			if($profile_image_url!='IMAGE_NOT_ALLOWED'){
				$_SESSION['ws-tags']['ws-user']['updatePicture']=1;
				$GLOBALS['cn']->query("UPDATE users SET updatePicture=1 WHERE id ='".$_SESSION['ws-tags']['ws-user']['id']."'");
				$_SESSION['ws-tags']['ws-user']['photo']=$profile_image_url;
				$profile_image_url=true;
				//thumb image
				$photo='img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'];
				echo $photo."<br>";
				if(($thumb=generateThumbPath($photo,true,''))!=''){
					echo $thumb."<br>";
					$is=getimagesize(FILESERVER.$photo);
					if($is[0]>$is[1]){
						$x=$is[0]-$is[1];
						$y=0;
						$size=$is[1];
					}else{
						$y=$is[1]-$is[0];
						$x=0;
						$size=$is[0];
					}
					CreateThumb(FILESERVER.$photo,$thumb,60,$x,$y,$size,$size);
					FTPupload(end(explode('img/',$thumb)));
					echo '00000';
				}
				echo 'aaaaa';
			}else{
				die('ERROR_UPLOADING_PROFILE_PICTURE');
				echo 'bbbbb';
				$profile_image_url = false;
			}
		}elseif($_FILES['frmProfile_filePhoto']['name']){//subio foto pero hubo error
			echo 'ccc';
			$error_uploading_pp	= true;
		}
		//END - uploading new profile image
	}

	//validating if he comes to save
	if($_POST['validaActionAjax']=='save'){
		//updating $_SESSION var
		//if changing first_name OR last_name
		$temporal = $_POST['frmProfile_firstName'].' '.$_POST['frmProfile_lastName'];
		if( $_SESSION['ws-tags']['ws-user']['full_name'] != $temporal ) {
			$name_change	= true;
			$_SESSION['ws-tags']['ws-user']['full_name']	= $temporal;
		}
		// END - if changing first_name OR last_name
		$_SESSION['ws-tags']['ws-user']['name']			= $_POST['frmProfile_firstName'];
		$_SESSION['ws-tags']['ws-user']['last_name']		= $_POST['frmProfile_lastName'];
		// if changing display languaje
			if( $_SESSION['ws-tags']['ws-user']['language'] != $_POST['frmProfile_cboLanguageUsr'] ) {
				$updateLanguage	= true;
				$_SESSION['ws-tags']['ws-user']['language']	= $_POST['frmProfile_cboLanguageUsr'];
			}
		// END - if changing display languaje
		// if changing username
		if( !$error_username ) {
			$_SESSION['ws-tags']['ws-user']['username']	= $_POST['frmProfile_userName'];
		}
		// END - if changing username
		$_SESSION['ws-tags']['ws-user']['screen_name']   = $_POST['frmProfile_screenName'];
		$_SESSION['ws-tags']['ws-user']['date_birth']    = $date_birth;
		$_SESSION['ws-tags']['ws-user']['show_birthday'] = $_POST['frmProfile_showbirthday'];
		$_SESSION['ws-tags']['ws-user']['country']       = $_POST['frmProfile_cboFrom'];
		$_SESSION['ws-tags']['ws-user']['sex']           = $_POST['frmProfile_sex'];
		$_SESSION['ws-tags']['ws-user']['taxId']         = $_POST['frmProfile_taxId'];
		$_SESSION['ws-tags']['ws-user']['paypal']        = $_POST['frmProfile_paypal'];
		$_SESSION['ws-tags']['ws-user']['personal_messages'] = $_POST['frmProfile_messagePersonal'];

		// phone numbers
		$home_area	= ($_POST['frmProfile_home_code']		? getTableRow('code_area', 'countries', 'id='.$_POST['frmProfile_home_code'])		: "");
		$work_area	= ($_POST['frmProfile_work_code']		? getTableRow('code_area', 'countries', 'id='.$_POST['frmProfile_work_code'])		: "");
		$mobile_area= ($_POST['frmProfile_mobile_code']	? getTableRow('code_area', 'countries', 'id='.$_POST['frmProfile_mobile_code'])	: "");
		$_SESSION['ws-tags']['ws-user']['home_phone']    = ($home_area	&& $_POST['frmProfile_home']		? $home_area	: '').'-'.$_POST['frmProfile_home'];
		$_SESSION['ws-tags']['ws-user']['work_phone']    = ($work_area	&& $_POST['frmProfile_work']		? $work_area	: '').'-'.$_POST['frmProfile_work'];
		$_SESSION['ws-tags']['ws-user']['mobile_phone']  = ($mobile_area	&& $_POST['frmProfile_mobile']	? $mobile_area	: '').'-'.$_POST['frmProfile_mobile'];
		// END - phone numbers
		//updating business card phone
		$bc	= '	SELECT	id
				FROM	business_card
				WHERE	id_user				= '.$_SESSION['ws-tags']['ws-user']['id'].' AND
						company				= "Social Media Marketing" AND
						middle_text			= "www.Tagbum.com" AND
						address				= "" AND
						specialty			= "" AND
						company_logo_url	= "" AND
						background_url		= "" AND
						type				= 0 AND
						text_color			= "#000000"';
		$bc	= $GLOBALS['cn']->query($bc);
		if( mysql_num_rows($bc)==1 ) {
			$n_bc = mysql_fetch_assoc($bc);
			$bc	= '	UPDATE	business_card
					SET		home_phone	= "'.$_SESSION['ws-tags']['ws-user']['home_phone'].'",
							work_phone	= "'.$_SESSION['ws-tags']['ws-user']['work_phone'].'",
							mobile_phone= "'.$_SESSION['ws-tags']['ws-user']['mobile_phone'].'"
					WHERE	id			= '.$n_bc['id'];
			$bc	= $GLOBALS['cn']->query($bc);
		}
		// END - updating $_SESSION var
		// if changing country
		if( $_POST['frmProfile_cboFrom'] ) { $sql_pais = '  , country = "'.$_POST['frmProfile_cboFrom'].'" ';
		} else { $sql_pais = '  , country = "0" '; }
		// END - if changing country
		// if changing or adding zip_code
		if($_POST['frmProfile_zipCode']!=$_SESSION['ws-tags']['ws-user']['zip_code']){
			if($_POST['frmProfile_zipCode']){
				$result = $GLOBALS['cn']->query("SELECT ZIP_CODE     FROM     zip_codes     WHERE     ZIP_CODE = '".$_POST['frmProfile_zipCode']."'");
				if(mysql_num_rows($result)>0){
					$_SESSION['ws-tags']['ws-user']['zip_code'] = $_POST['frmProfile_zipCode'];
					$sql_zip_code = "zip_code = '".$_POST['frmProfile_zipCode']."',";
					$updateZipCode = '1';
				}else{
					//$updateZipCode = '2';  // ver luego, esto era validando con la tabla zipcodes de usa solamente
					$updateZipCode = '1';
					$_SESSION['ws-tags']['ws-user']['zip_code'] = $_POST['frmProfile_zipCode'];
					$sql_zip_code = "zip_code = '".$_POST['frmProfile_zipCode']."',";
				}
			}else{
				$_SESSION['ws-tags']['ws-user']['zip_code'] = '';
				$sql_zip_code = "zip_code = '',";
				$updateZipCode = '1';
			}
		}else{ $updateZipCode = '0'; }
		// END - if changing or adding zip_code
	}

	//validating if he comes to save, change background, background by default, or background color
	if(($_POST['validaActionAjax']=='save')||($_POST['validaActionAjax']=='backgroundFile')||($_POST['validaActionAjax']=='backgroundDefault')||($_POST['validaActionAjax']=='HiddenColor')){
	//when changing background
		if($_POST['user_background_url']=="setDefault"){
			$_SESSION['ws-tags']['ws-user']['user_background']='';
		}elseif($_FILES['profile_background_file']['error']==0){
				$allowedImages = array('jpg', 'jpeg', 'png', 'gif');
				$parts         = explode('.', $_FILES['profile_background_file']['name']);
				$ext           = strtolower( end($parts) );
				if( in_array($ext, $allowedImages) ) {
						$path  = "img/users_backgrounds/".$_SESSION['ws-tags']['ws-user']['code'].'/';
						$fondo = $_SESSION['ws-tags']['ws-user']['code'].'/'.md5($_FILES['profile_background_file']['name']).'.'.$ext;
						$fondo_=md5($_FILES['profile_background_file']['name']).'.'.$ext;
						if( !is_dir($path) ) {
							$old = umask(0);
							mkdir($path, 0777);
							umask($old);
							$fp = fopen($path.'index.html', "w");
							fclose($fp);
						}
						if( copy($_FILES['profile_background_file']['tmp_name'], "img/users_backgrounds/".$fondo) ) {
							$_SESSION['ws-tags']['ws-user']['user_background'] = $fondo;
							uploadFTP($fondo_, "users_backgrounds");
						}
				}else{
					die('ERROR_UPLOADING_PROFILE_PICTURE');
				}
		}elseif($_POST['profileHiddenColor']){
				$_SESSION['ws-tags']['ws-user']['user_background'] = $_POST['profileHiddenColor'];
		}
	// END - when changing background
	}

	switch ($_POST['validaActionAjax']){
		case 'save'		:
			// updating database
				$GLOBALS['cn']->query('
					UPDATE users SET
						screen_name			= "'.$_SESSION['ws-tags']['ws-user']['screen_name'].		'",
						name				= "'.$_SESSION['ws-tags']['ws-user']['name'].				'",
						last_name			= "'.$_SESSION['ws-tags']['ws-user']['last_name'].		'",
						date_birth			= "'.$_SESSION['ws-tags']['ws-user']['date_birth'].		'",
						profile_image_url	= "'.$_SESSION['ws-tags']['ws-user']['photo'].			'",
						show_my_birthday	= "'.$_SESSION['ws-tags']['ws-user']['show_birthday'].	'",
						home_phone			= "'.$_SESSION['ws-tags']['ws-user']['home_phone'].		'",
						mobile_phone		= "'.$_SESSION['ws-tags']['ws-user']['mobile_phone'].		'",
						work_phone			= "'.$_SESSION['ws-tags']['ws-user']['work_phone'].		'",
						language			= "'.$_SESSION['ws-tags']['ws-user']['language'].			'",
						user_background		= "'.$_SESSION['ws-tags']['ws-user']['user_background'].	'",
						country				= "'.$_SESSION['ws-tags']['ws-user']['country'].			'",
						sex					= "'.$_SESSION['ws-tags']['ws-user']['sex'].'",
						paypal				= "'.$_POST['frmProfile_paypal'].'",
						zip_code			= "'.$_SESSION['ws-tags']['ws-user']['zip_code'].'",
						taxId				= "'.$_SESSION['ws-tags']['ws-user']['taxId'].'",
						personal_messages	= "'.$_SESSION['ws-tags']['ws-user']['personal_messages'].'"'.
						$sql_pais.
						$sql_userName.'
					WHERE id = "'.$_SESSION['ws-tags']['ws-user'][id].'"
				');
			// END - updating database
		break;
		case 'filePhoto':
			// updating database
			$GLOBALS['cn']->query('
				UPDATE users SET
					profile_image_url="'.$_SESSION['ws-tags']['ws-user']['photo'].'"
				WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"
			');
		break;
		case 'fileCover':
			// updating database
			$GLOBALS['cn']->query('
				UPDATE users SET
					user_cover="'.$_SESSION['ws-tags']['ws-user']['user_cover'].'"
				WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"
			');
		break;
		case 'backgroundFile':
		case 'backgroundDefault':
		case 'HiddenColor':
			// updating database
			$GLOBALS['cn']->query('
				UPDATE users SET
					user_background="'.$_SESSION['ws-tags']['ws-user']['user_background'].'"
				WHERE id = "'.$_SESSION['ws-tags']['ws-user']['id'].'"
			');
		break;
	}

	//retornando los cambios hechos el profile
	if($name_change){
		echo "UUNN".$_POST['frmProfile_firstName'].' '.$_POST['frmProfile_lastName'];
	}elseif($updateZipCode=='2'){
		echo "WRONG_ZIP";
	}elseif($error_username){
		echo $error_username;
	}elseif($updateLanguage){
		echo 'updateLanguage';
	}elseif($profile_image_url){
		if(file_exists('img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'])){
			echo 'CROP';
		}else{
			$_SESSION['ws-tags']['ws-user']['updatePicture']	= 0;
			$_SESSION['ws-tags']['ws-user']['photo']			= '';
			$GLOBALS['cn']->query("UPDATE `users` SET `updatePicture` = '0' WHERE `users`.`id` ='".$_SESSION['ws-tags']['ws-user']['id']."'");
			echo 'ERROR_UPLOADING_PROFILE_PICTURE';
		}
	}elseif($error_uploading_pp){
		echo 'ERROR_UPLOADING_PROFILE_PICTURE';
	}else{
		switch($_POST[actionAjax]){
			case 'DEFAULT-BG'  :echo "BBGGbg.png";break;
			case 'UPLOADING-BG':echo "BBGG".$_SESSION['ws-tags']['ws-user']['user_background'];break;
			case 'COLOR-BG'    :echo "BBGG".$_SESSION['ws-tags']['ws-user']['user_background'];break;
		}
	}
	// END - retornando los cambios hechos el profile
	createSession(array('paypal'=>$_POST['frmProfile_paypal']),false);
}
?>

<?php
	include '../../includes/session.php';
	include '../../includes/config.php';
	include '../../class/wconecta.class.php';
	include '../../class/validation.class.php';
	include '../../includes/functions.php';
	include '../../includes/languages.config.php';

if(isset($_GET['updateTagLink'])){ //when called from menuBusinessCard
	$GLOBALS['cn']->query('UPDATE tags SET id_business_card="'.(isset($_GET['idBc'])?base64_decode($_GET['idBc']):'').'" WHERE md5(id)="'.$_GET['updateTagLink'].'"');
}elseif(isset($_GET['id_delete_bc'])){ //when called from menuBusinessCard (ajax)
	$GLOBALS['cn']->query('DELETE FROM business_card WHERE md5(id)="'.$_GET['id_delete_bc'].'"');
	$GLOBALS['cn']->query('UPDATE users SET pay_bussines_card=pay_bussines_card-1 WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
	$GLOBALS['cn']->query('UPDATE tags SET id_business_card="" WHERE md5(id_business_card)="'.$_GET['id_delete_bc'].'"');
}elseif(isset($_GET['addBC'])){ //creating a new business card
	$result = $GLOBALS['cn']->query('
		SELECT id
		FROM business_card
		WHERE type = "2"
	');
	if(mysql_num_rows($result)>0){
		$result	= mysql_fetch_assoc($result);
		$bcID	= md5($result['id']);
	}else{
		$result = $GLOBALS['cn']->query('
			INSERT INTO business_card SET
				id_user		= "0",
				`type`		= "2",
				email		= NULL,
				home_phone	= NULL,
				work_phone	= NULL,
				mobile_phone= NULL
		');
		/*$result = $GLOBALS['cn']->query("
		SELECT id
		FROM business_card
		WHERE  type		= '0' AND id_user='".$_SESSION['ws-tags']['ws-user'][id]."'");*/
		$result = $GLOBALS['cn']->query('
			SELECT id
			FROM business_card
			WHERE type = "2"
		');
		$result=  mysql_fetch_assoc($result);
		//$GLOBALS['cn']->query("UPDATE business_card SET type=2 WHERE id='".$result[id]."'");
		$bcID=md5($result['id']);
		
	}

	if( $result ) {
		echo '#profile?sc=3&bc='.$bcID;
		//redirect("?current=profile&activeTab=2&bc=".$bcID);
	}

} else {

	//logo de la compania
	if($_POST['bc_companyLogo_url']=='setDefault'){
		deleteFTP( $_POST[companyLogoUrl] ,'bc_logos');
		$_POST['bc_companyLogo_url'] = '';
	}elseif($_POST['bc_background']=='setDefault'){
		//deleteFTP( $_POST[companyLogoUrl] ,'bc_logos');
		$_POST['bc_background'] = 'defaults/white.png';
	}elseif($_FILES['logoCompany']['error']==0){
		$allowedImages	= array('jpg','jpeg','png','gif');
		$parts			= explode('.',$_FILES['logoCompany']['name']);
		$ext			= strtolower(end($parts));
		if(in_array($ext,$allowedImages)){
			$path  = '../../img/bc_logos/'.$_SESSION['ws-tags']['ws-user']['code'].'/';
			$logo = $_SESSION['ws-tags']['ws-user']['code'].'/'.md5($_FILES['logoCompany']['name']).'.'.$ext;
			$foto_=md5($_FILES['logoCompany']['name']).'.'.$ext;
			if(!is_dir($path)){
				$old = umask(0);
				mkdir($path, 0777);
				umask($old);
				$fp = fopen($path.'index.html','w');
				fclose($fp);
			}
			if(redimensionar($_FILES['logoCompany']['tmp_name'],'../../img/bc_logos/'.$logo, 150)){
				uploadFTP($foto_,'bc_logos','../../');
				if($_POST['bc_companyLogo_url']!='' && $_POST['bc_companyLogo_url']!==$_FILES['logoCompany']['name'].'.'.$ext){
					deleteFTP($_POST['companyLogoUrl'],'bc_logos');
				}
				$_POST['bc_companyLogo_url'] = md5($_FILES['logoCompany']['name']).'.'.$ext;
			}
		}
	}//if error logoCompany
	//when uploading a background
	if($_FILES['newBackground']['error']==0){
		$allowedImages = array('jpg','jpeg','png','gif');
		$parts         = explode('.',$_FILES['newBackground']['name']);
		$ext           = strtolower(end($parts));
		if(in_array($ext,$allowedImages)){
			$path  = '../../img/bc_templates/'.$_SESSION['ws-tags']['ws-user']['code'].'/';
			$fondo = $_SESSION['ws-tags']['ws-user']['code'].'/'.md5($_FILES['newBackground']['name']).'.'.$ext;
			$fondo_=md5($_FILES['newBackground']['name']).'.'.$ext;
			if(!is_dir($path)){
				$old = umask(0);
				mkdir($path, 0777);
				umask($old);
				$fp = fopen($path.'index.html', 'w');
				fclose($fp);
			}
			if(redimensionar($_FILES['newBackground']['tmp_name'],'../../img/bc_templates/'.$fondo,350)){
				$_POST['bc_background'] = $fondo;
				uploadFTP($fondo_,'bc_templates','../../');
			}
		}
	}
	if($_POST['bc_mobilePhone']	== BC_MOBILEPHONE_NOTEXT)	$_POST['bc_mobilePhone']= '';
	if($_POST['bc_middleText']	== BC_MIDDLETEXT_NOTEXT)	$_POST['bc_middleText']	= '';
	if($_POST['bc_specialty']	== BC_SPECIALTY_NOTEXT)		$_POST['bc_specialty']	= '';
	if($_POST['bc_homePhone']	== BC_HOMEPHONE_NOTEXT)		$_POST['bc_homePhone']	= '';
	if($_POST['bc_workPhone']	== BC_WORKPHONE_NOTEXT)		$_POST['bc_workPhone']	= '';
	if($_POST['bc_address']		== BC_ADDRESS_NOTEXT)		$_POST['bc_address']	= '';
	if($_POST['bc_company']		== BC_COMPANY_NOTEXT)		$_POST['bc_company']	= '';
	if($_POST['bc_email']		== BC_EMAIL_NOTEXT)			$_POST['bc_email']		= '';

	//INSERT NEW BC
	if ($_POST['type']==2){
		$GLOBALS['cn']->query('
			INSERT INTO business_card SET
				id_user				= "'.$_SESSION['ws-tags']['ws-user']['id'].'",
				`type`				= "1",
				address				= "'.$_POST['bc_address'].'",
				company				= "'.$_POST['bc_company'].'",
				specialty			= "'.$_POST['bc_specialty'].'",
				email				= "'.$_POST['bc_email'].'",
				middle_text			= "'.$_POST['bc_middleText'].'",
				home_phone			= "'.$_POST['bc_homePhone'].'",
				work_phone			= "'.$_POST['bc_workPhone'].'",
				mobile_phone		= "'.$_POST['bc_mobilePhone'].'",
				company_logo_url	= "'.$_POST['bc_companyLogo_url'].'",
				background_url		= "'.$_POST['bc_background'].'",
				text_color			= "'.$_POST['hiddenColor'].'"
		');
		$result = $GLOBALS['cn']->query('UPDATE users SET pay_bussines_card=pay_bussines_card+1 WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
	}else{
		//UPDATING DATA INTO business_card TABLE
		$GLOBALS['cn']->query('
			UPDATE business_card SET
				address			= "'.$_POST['bc_address'].'",
				company			= "'.$_POST['bc_company'].'",
				specialty		= "'.$_POST['bc_specialty'].'",
				email			= "'.$_POST['bc_email'].'",
				middle_text		= "'.$_POST['bc_middleText'].'",
				home_phone		= "'.$_POST['bc_homePhone'].'",
				work_phone		= "'.$_POST['bc_workPhone'].'",
				mobile_phone	= "'.$_POST['bc_mobilePhone'].'",
				company_logo_url= "'.$_POST['bc_companyLogo_url'].'",
				background_url	= "'.$_POST['bc_background'].'",
				text_color		= "'.$_POST['hiddenColor'].'"
			WHERE md5(id)		= "'.$_POST['idBc'].'"
		');
	}

//					0							1						2							3							4						5								6						7						8									9					10
	echo $_POST['bc_specialty'].'|'.$_POST['bc_company'].'|'.$_POST['bc_middleText'].'|'.$_POST['bc_address'].'|'.$_POST['bc_homePhone'].'|'.$_POST['bc_workPhone'].'|'.$_POST['bc_mobilePhone'].'|'.$_POST['bc_email'].'|'.$_POST['bc_companyLogo_url'].'|'.$_POST['hiddenColor'].'|'.$_POST['bc_background'];
	//redirect("?current=profile&activeTab=2&bc=".$_POST[idBc]);
}
?>

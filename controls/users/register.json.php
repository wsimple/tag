<?php
include '../header.json.php';

function register_json($data){
	$res=array();
	$defaultTag='defaults/346f3ee097c010b4ed71ce0fb08bbaf2.jpg';
	include(RELPATH.'class/validation.class.php');
	include(RELPATH.'class/class.phpmailer.php');
	sleep(RETARDOLOGINREGISTRO);
	$paso=0;
	if($data['fbid']!=''&&CON::exist('users','fbid=?',array($data['fbid']))) $data['fbid']='';
	$res['fbid']=$data['fbid'];
	$res['email']=0;
	$existEmail=CON::exist('users','email=?',array($data['email']));
	$fb_mail='';#se le envia por correo la clave de usuario
	if($data['company']!=1){
		$res['comp']=0;
		if(!$data['fbid']){
			if(!validaMobile($data['first_name'],'text')){
				$res['msg'][]='1';
				$res['error']='Nombre MALO';
			}elseif(!validaMobile($data['last_name'],'text')){
				$res['msg'][]='2';
				$res['error']='Apellido MALO';
			}elseif(($data['email']=='')||!validaMobile($data['email'],'email')){
				$res['msg'][]='3';
				$res['error']='email MALO';
			}elseif($data['password']==''){
				$res['msg'][]='4';
				$res['error']='pass vacio';
			}elseif($existEmail){
				$res['msg'][]='5';
				$res['error']='email duplicado';
			}elseif(validaMobile($data['birthday'],'fecha')){
				$res['msg'][]='6';
				$res['error']='fecha vacio';
			}elseif(strlen($data['password'])<6){
				$res['msg'][]='7';
				$res['error']='pass vacio';
			}elseif($data['repassword']==''){
				$res['msg'][]='8';
				$res['error']='confi pass vacio';
			}elseif($data['password']!=$data['repassword']){
				$res['msg'][]='9';
				$res['error']='no coincidencias de password';
			}else{
				$paso=1;
				$lang=$_SESSION['ws-tags']['language']!=''?$_SESSION['ws-tags']['language']:'en';
			}
		}else{
			if($existEmail){
				$res['msg'][]='5';
				$res['error']='email duplicado';
			}else{
				$paso=1;
				$lang=substr($data['location'],0,2);
				if($lang!='en'&&$lang!='es') $lang='en';
				#si el registro es por facebook, le generamos una contraseña automatica de 10 caracteres al azar
				$data['password']=substr(md5(time()),rand(0,20),10);
				$fb_mail='<tr style="color:#666;"><td>'.LBL_PASS.': '.$data['password'].'</td></tr>';
			}
		}
	}else{
		$res['comp']=1;
		if($data['first_name']==''){
			$res['msg'][]='1';
			$res['error']='Nombre empresa MALO';
		}elseif($data['email']==''||!validaMobile($data['email'],'email')){
			$res['msg'][]='3';
			$res['error']='email MALO';
		}elseif($data['password']==''){
			$res['msg'][]='4';
			$res['error']='pass vacio';
		}elseif($existEmail){
			$res['msg'][]='5';
			$res['error']='duplicate email';
		}elseif(validaMobile($data['birthday'],'fecha')){
			$res['msg'][]='6';
			$res['error']='fecha vacio';
		}elseif(strlen($data['password'])<6){
			$res['msg'][]='7';
			$res['error']='pass vacio';
		}elseif($data['repassword']==''){
			$res['msg'][]='8';
			$res['error']='confi pass vacio';
		}elseif($data['password']!=$data['repassword']){
			$res['msg'][]='9';
			$res['error']='no coincide el password';
		}else{
			$paso=1;
		}
	}
	#Executes SQLS
	if($paso==1){
		CON::update('users','references_count=references_count+1','referee_number LIKE ? LIMIT 1',array($data['numberReference']));
		$referee_number='';//refereeNumber($data[email]);
		$referee_user='';//$data[numberReference];
		#cuando exista $data['fbid'], al usuario se le genera una clave automatica
		$id=CON::insert('users','
			username="",profile_image_url="",url="",description="",country="",state="",city="",address="",password_system="",
			followers_count=0,friends_count=0,tags_count=0,time_zone="",status=2,created_at=NOW(),last_update=NOW(),show_my_birthday=1,
			email=?,password_user=?,type=?,
			screen_name=?,name=?,last_name=?,
			date_birth=?,sex=?,fbid=?,
			location=?,zip_code=?,language=?,
			referee_number=?,referee_user=?
		',array(
			$data['email'],$data['password'],($data['company']==1?1:0),
			$data['screenName'],$data['first_name'],$data['last_name'],
			date('Y-m-d',strtotime($data['birthday'])),$data['sex'],$data['fbid'],
			$_SERVER['REMOTE_ADDR'],$data['zipCode'],$lang,
			$referee_number,$referee_user
		));
		$res['sql']=CON::lastSql();
		$key=md5(md5($id.'+'.$data['email'].'+'.$id));
		$idTag=CON::insert('tags','id_user=?,id_creator=?,background=?,code_number="",text="&nbsp",text2="&nbsp",status=1',array($id,$id,$defaultTag));
		if($idTag) createTag($idTag);
		#cuando el usuario se registra se le crea una business card simple
		CON::insert('business_card','id_user=?,email=?,company="Social Media Marketing",middle_text="www.Tagbum.com",type=0',array($id,$data['email']));
		#envio del email
		$nombreCompleto=$data['first_name'].' '.$data['last_name'];
		$body='
			<table width="700" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana,Geneva,sans-serif;font-size:12px;text-align:left">
				<tr>
					<td style="color:#ff8a28;"><strong>'.SIGNUP_BODYEMAIL1.', '.formatoCadena($nombreCompleto).'</strong></td>
				</tr>
				<tr>
					<td style="color:#666;">'.SIGNUP_BODYEMAIL2.':</td>
				</tr>
				'.$fb_mail.'
				<tr>
					<td><a href="'.base_url('?keyusr='.$key).'">'.DOMINIO.'?keyusr='.$key.'</a></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td style="color:#666;">'.SIGNUP_BODYEMAIL3.'.</td>
				</tr>
				<tr>
					<td><em style="font-size:10px;color:#999;">'.SIGNUP_BODYEMAIL4.'</em></td>
				</tr>
			</table>
		';
		if(sendMail(formatMail($body,'800'),EMAIL_NO_RESPONDA,'Tagbum.com',SIGNUP_ASUNTOEMAIL.', '.$nombreCompleto.'!',$data['email'],'../../')){
			$res['email']=1;
		}
		$res['ok']='si';
		$res['msg']='success.';
		$res['done']=true;
	}else{
		$res['ok']='no';
		$res['done']=false;
	}
	return $res;
}
if(!$notAjax){
	$data=array();
	$data['first_name']=cls_string(isset($_POST['first_name'])?$_POST['first_name']:$_POST['name']);
	$data['last_name']=cls_string(isset($_POST['last_name'])?$_POST['last_name']:$_POST['lastName']);
	$data['email']=cls_string(strtolower($_POST['email']));
	$data['birthday']=isset($_POST['birthday'])?$_POST['birthday']
		:(isset($_POST['date'])?$_POST['date']
		:(isset($_POST['day'])?$_POST['month'].'/'.$_POST['day'].'/'.$_POST['year']
		:''));
	$data['screenName']=$data['first_name'];
	$data['password']=$_POST['password'];
	$data['repassword']=$_POST['repassword'];
	$data['company']=$_POST['company'];
	$data['fbid']=$_POST['fbid'];
//	$data['zipCode']=cls_string($_POST['zipCode'.$data['company']]);
//	$data['txtCaptcha']=str_replace('-',' ',strtolower($_REQUEST['txtCaptcha'.$data['company']]));
//	$data['numberReference']=cls_string($_POST['numberReference']);
	die(jsonp(register_json($data)));
}
?>

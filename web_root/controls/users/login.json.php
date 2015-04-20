<?php
include '../header.json.php';

function login_json($data){
	//se definen los parametros
	$login=cls_string($data['login']);
	$pass=cls_string($data['pwd']);
	$captcha=cls_string($data['recaptcha']);
	$iscaptcha=$data['iscaptcha'];
	$res=array('logged'=>false);
	if($login==''&&$pass==''){#can't login
		$res['msg']=MSGERROR_USERPASSBLANK;
		$res['from']=1;
		return $res;
	}

	//Captcha reCaptcha
	if($iscaptcha){
		//Parameters
		//--- secret: Token suministrado por google. Se debe asocial todos los dominios y subdominios a una cuenta gmail.
		//--- response: es lo que envia google luego de responder el Captcha. Este valor se toma de control con ID=g-recaptcha-response. Se envia a esta funcion via JSON
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcziQUTAAAAAOk904s3VLveP2D5bSiV-3qH_LYJ&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		/*$res=array(
					'logged'=>false,
					'msg'=>$response,
					'from'=>4
				);
		return $res;*/
		if($response.success==false){
			$res=array(
					'logged'=>false,
					'msg'=>MSGERROR_CAPTCHAINVALID,
					'from'=>4
				);
			return $res;
		}
	}

	// $sesion=CON::getRow('
	// 	SELECT *,CONCAT(name," ",last_name) AS full_name,md5(concat(id,"_",email,"_",id)) AS code,profile_image_url AS display_photo
	// 	FROM users
	// 	WHERE email=? AND password_user=?
	// ',array($login,$pass));
	$sesion=CON::getRow('
		SELECT *,
			CONCAT(name," ",last_name) AS full_name,
			md5(concat(id,"_",email,"_",id)) AS code,
			profile_image_url AS display_photo,
			(UNIX_TIMESTAMP() - UNIX_TIMESTAMP(users.login_lasttime))/60 as minutes_lastlogin
		FROM users
		WHERE email=? 
	',array($login));
	if($sesion['id']!=''){
		//Si la contrasena es la correcta, continuar el proceso
		if($sesion['password_user']==$pass)
		{
			//acciones del login
			switch($sesion['status']){
				case '3':
					createSession($sesion);

					$res['uid']=md5($sesion['id']);
					$res['code']=$sesion['code'];
					$res['msg']=$sesion['code'];
					if (PAYPAL_PAYMENTS) {
						$_SESSION['business_payment']=$_SESSION['ws-tags'];
						$res['from']='paypal';
						unset($_SESSION['ws-tags']);
					}else{
						$res['logged']=true;
						CON::update('users','type=1,status=1','id=?',array($_SESSION['ws-tags']['ws-user']['id']));
						$idPlan=CON::getVal('SELECT id FROM users_plan_purchase WHERE id_user=? LIMIT 1',array($_SESSION['ws-tags']['ws-user']['id']));
						if($idPlan!=''){
							CON::update('users_plan_purchase','init_date=NOW()',"id=$idPlan");
						}else{
							CON::insert('users_plan_purchase','id_user=?,id_plan=1,init_date=NOW(),end_date=DATE_ADD(NOW(),INTERVAL 15 DAY)',
								array($_SESSION['ws-tags']['ws-user']['id']));
						}
					}
					
					ifIsLogged();
					return $res;
				break;
				case '1':case '5':#Status 5=Cuenta pendiente por revision(solo nonprofit accounts)
					$access=true;
					#Control de acceso en cuentas business, verifica fecha limite para conceder acceso
					if (PAYPAL_PAYMENTS) {
						if($sesion['type']==1||$sesion['type']==2){
							$access=CON::getVal('
								SELECT IF(NOW()>=u.end_date,0,1)
								FROM users_plan_purchase u
								JOIN subscription_plans s ON u.id_plan=s.id
								WHERE u.id_user=?
								ORDER BY u.end_date DESC
								LIMIT 1
							',array($sesion['id']));
						}
					}else  $access=1;
					if($access==0){
						#Pasamos status a 3
						CON::update('users','status=3','id=?',array($sesion['id']));
						#Devolvemos json con no login + data redirect
						$res['uid']=md5($sesion['id']);
						$res['code']=$sesion['code'];
						$res['msg']=$sesion['code'];
						$res['from']='renewaccount';
						createSession($sesion);
						$_SESSION['business_payment']=$_SESSION['ws-tags'];
						unset($_SESSION['ws-tags']);
						ifIsLogged();
						return $res;
					}else{
						createSession($sesion);
						$myId=$_SESSION['ws-tags']['ws-user']['id'];
						$res['numFriends']=CON::getVal('SELECT COUNT(id_user) as num from users_links where id_user = ?',array($_SESSION['ws-tags']['ws-user']['id']));
						//Aumentamos el contador de login
						CON::update('users','logins_count=logins_count+1,login_lasttime=NOW(),login_count_fail=0','id=?',array($sesion['id']));
						$_SESSION['ws-tags']['ws-user']['logins_count']++;
						#Guardamos el device del ususario.
						$device=saveDevice($data['mobile']);
						#enviar resultados de login
						$res['logged']=true;
						$res['from']=2;
						$res['locals']=array(
							'full_name'=>$sesion['full_name'],
							'display_photo'=>FILESERVER.getUserPicture($sesion['code'].'/'.$sesion['display_photo'],'img/users/default.png'),
							'code'=>$_SESSION['ws-tags']['ws-user']['code'],
							'lang'=>$_SESSION['ws-tags']['language'],
							'email'=>$sesion['email']
						);
						cookie('last',$sesion['email'],90);
					}
					if(preg_match('/tagbum/i',$_SERVER['HTTP_USER_AGENT'])){//app
						$res['locals']['kldata']=keepLogin($device);
					}
					if($data['mobile']||$data['keep']){
						keepLogin($device);
					}
					ifIsLogged();
					return $res;
				break;#1,5
				#el usuario esta registrado, pero aun no ha confirmado su suscripcion
				case '2':
					$res=array(
						'logged'=>false,
						'confirm'=>true,
						'msg'=>MSG_DATAERROR2,
						'from'=>3
					);
					ifIsLogged();
					return $res;
				break;#2
				default: return $res;
			}#switch (status)
		}
		else
		{
			//PROCESO DE SEGURIDAD
			//Registro el intento de login
			$updtime = 'login_lasttime='.(($sesion['login_count_fail']==0) ? 'NOW()': 'login_lasttime');
			CON::update('users','login_count_fail=login_count_fail+1,'.$updtime,'id=?',array($sesion['id']));

			if ($sesion['login_count_fail']<=5)
			{
				$res=array(
					'logged'=>false,
					'msg'=>MSGERROR_PASSWINVALID,
					'from'=>4
				);
			}
			else
			{
				//Si sobrepaso el numero de intentos, validar el tiempo transcurrido 
				if ($sesion['minutes_lastlogin']<=2)
				{
					//Se asume que ya ha intentado mas de 5 veces en un tiempo de 2 min
					$res=array(
						'logged'=>false,
						'msg'=>MSGERROR_MAXNUMATTEMPTS,
						'from'=>4
					);
				}
				else
				{
					//Reinicio el conteo en BD pasados 2 minutos desde el ultimo intento
					if ($sesion['minutes_lastlogin']>2)
					{
						CON::update('users','login_count_fail=1,login_lasttime=NOW()','id=?',array($sesion['id']));
						$res=array(
							'logged'=>false,
							'msg'=>MSGERROR_PASSWINVALID,
							'from'=>$sesion['minutes_lastlogin']
						);
					}
				}
			}
			return $res;
		}
	}else{#validacion de login y passowrd
		#can't login
		$res=array(
			'logged'=>false,
			'msg'=>MSGERROR_USERNOTEXIST,
			'from'=>4
		);
		//_imprimir($res);
		ifIsLogged();
		return $res;
	}
}
if(!$notAjax){
	$data=array();
	$data['keep']=isset($_REQUEST['keep'])||isset($_REQUEST['keepLogin']);
	$data['login']=$_POST['login']!=''?$_POST['login']:$_POST['txtLogin'];
	$data['pwd']=$_POST['pwd']!=''?$_POST['pwd']:($_POST['pass']!=''?$_POST['pass']:$_POST['txtPass']);
	$data['recaptcha']=$_POST['recaptcha']!=''?$_POST['recaptcha']:'';
	$data['iscaptcha']=$_POST['iscaptcha'];
	$data['mobile']=isset($_REQUEST['mobile']);
	die(jsonp(login_json($data)));
}
?>
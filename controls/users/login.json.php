<?php
include '../header.json.php';

function login_json($data){
	//se definen los parametros
	$login=cls_string($data['login']);
	$pass=cls_string($data['pwd']);
	$res=array('logged'=>false);
	if($login==''||$pass==''){#can't login
		$res['msg']=MSG_DATAERROR1;
		$res['from']=1;
		return $res;
	}
	$sesion=CON::getRow('
		SELECT *,CONCAT(name," ",last_name) AS full_name,md5(concat(id,"_",email,"_",id)) AS code
		FROM users
		WHERE email=? AND password_user=?
	',array($login,$pass));
	if($sesion['id']!=''){
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
					//Aumentamos el contador de login
					CON::update('users','logins_count=logins_count+1','email=?',array($login));
					$_SESSION['ws-tags']['ws-user']['logins_count']++;
					#Guardamos el device del ususario.
					$device=saveDevice($data['mobile']);
					#enviar resultados de login
					$res['logged']=true;
					$res['from']=2;
					$res['locals']=array(
						'full_name'=>$sesion['full_name'],
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
	}else{#validacion de login y passowrd
		#can't login
		$res=array(
			'logged'=>false,
			'msg'=>MSG_DATAERROR1,
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
	$data['mobile']=isset($_REQUEST['mobile']);
	die(jsonp(login_json($data)));
}
?>
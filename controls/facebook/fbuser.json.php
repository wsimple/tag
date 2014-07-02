<?php 
include '../header.json.php';
require_once 'facebook.php';

$res=array();
$res['success']=0;
$user=$facebook->getUser();
$res['FBuser']=$user;
if($user){
	try {
		$fbdata=$facebook->api('/me/?fields=id,first_name,last_name,email,birthday,gender,locale');
		$res['FBdata']=$fbdata;
		$fbdata['fbid']=$fbdata['id'];
		#facebook retorna genero male/female, si es female guardaremos 2
		$fbdata['sex']=substr($fbdata['gender'],0,1)!='f'?1:2;

		$uid=$_SESSION['ws-tags']['ws-user']['id'];
		$email=$_SESSION['ws-tags']['ws-user']['email'];
		$forced=$_POST['forced'];
		$res['logged']=($uid!='');
		if($uid){#si esta logeado
			$res['from'][]='1-esta logeado';
			#buscamos si el id ya fue registrado por otro usuario
			$sql='SELECT fbid FROM users WHERE fbid="'.$fbdata['id'].'" AND id!="'.$uid.'" LIMIT 1';
			$fbid_exist=current($GLOBALS['cn']->queryRow($sql))!='';
			if($fbid_exist){
				$res['from'][]='2-el id ya fue registrado por otro usuario';
				$res['msg']=FBID_REGISTERED;
				 die(jsonp($res));
			}
			#si no ha sido registrado antes, lo guardamos si es el mismo correo o si forzamos el guardado
			if( $forced||$email==$fbdata['email'] ){
				$res['from'][]='3-se esta asignando id al usuario actual';
				$sql='UPDATE users SET fbid="'.$fbdata['id'].'" WHERE id="'.$uid.'" LIMIT 1';
				$GLOBALS['cn']->query($sql);
				$res['success']=1;
				die(jsonp($res));
			}else{#si el correo no coincide y no se ha forzado, se retorna el de FB para confirmacion
				$res['from'][]='4-el id no ha sido registrado pero el correo no coincide';
				$res['email']=$fbdata['email'];
			}
		}else{#si no esta logeado
			$res['from'][]='5-no esta logeado';
			$sql='SELECT * FROM users WHERE fbid="'.$fbdata['id'].'" LIMIT 1';
			$user=$GLOBALS['cn']->queryRow($sql);
			if(!$user['id']){
				#si el correo esta registrado pero no tiene el id de facebook, se lo agregamos y logeamos
				$sql='SELECT * FROM users WHERE email="'.$fbdata['email'].'" LIMIT 1';
				$user=$GLOBALS['cn']->queryRow($sql);
				if($user['id']){
					$res['from'][]='6-el correo esta registrado, le asignamos el id de fb';
					$sql='UPDATE users SET fbid="'.$fbdata['id'].'" WHERE email="'.$fbdata['email'].'" LIMIT 1';
					$GLOBALS['cn']->query($sql);
				}
			}
			if(!$user['id']){
				$res['from'][]='7-el correo no esta registrado';
				#si no esta registrado ni el ID ni el correo, creamos una cuenta nueva
				$tmp=$notAjax;
				$notAjax=true;
				include RELPATH.'controls/users/register.json.php';
				if($tmp) $notAjax=$tmp;
				unset($tmp);
				$res['from'][]='8-registramos el usuario';
				$reg=register_json($fbdata);
				$res['registered']=$reg['done'];
				if($reg['done']){
					$_data=array(
						'fbdata'=>$fbdata,
						'register'=>$reg
					);
					$res['first']=true;
					$sql='SELECT * FROM users WHERE email="'.$fbdata['email'].'" LIMIT 1';
					$user=$GLOBALS['cn']->queryRow($sql);
					$_data['sql']=$sql;
					$_data['user']=$user;
					$res['from'][]=$_data;
					if($user['email'])
						$GLOBALS['cn']->query('UPDATE users SET logins_count=1 WHERE email="'.$user['email'].'"');
				}
			}
			#si un usuario fue registrado con este id, lo logeamos
			if($user['id']){
				$res['from'][]='9-registro o logeo exitoso';
				createSession($user);
				$mobile=isset($_GET['mobile'])||$_POST['mobile'];
				$device=saveDevice($mobile);
				keepLogin($device);
				if($user['status']=='2') $_SESSION['ws-tags']['ws-user']['rgfb']=true;
				$res['success']=1;
				$res['logged']=true;
			}
		}
	}catch(FacebookApiException $e){}
}
die(jsonp($res));
?>
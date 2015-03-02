<?php
#//probando commit mientras se este migrando a modelo-vista-controlador, se trabaja paralelo con la interfaz antigua. desactivar esta variable para trabajar unicamente con MVC
$migrating=TRUE;
#si la web se llama con "www." se remueve el subdominio
if(substr($_SERVER['SERVER_NAME'],0,4)=='www.'){
	header('Location: http://'.substr($_SERVER['SERVER_NAME'],4).$_SERVER['REQUEST_URI']);
	die();
}

if(isset($_COOKIE['_DEBUG_']))
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
else
	error_reporting(0);
#precarga de mvc
include('autoload.php');

########## validaciones especiales ##########
#confirmacion del correo
if($_GET['keyusr']!=''){
	$db=new DB_sql($config->db);
	//se busca el usuario
	$keyUserEmail=$db->getRow('
		SELECT id,email,password_user,type
		FROM users
		WHERE md5(md5(CONCAT(id,"+",email,"+",id)))=?
	',array($_GET['keyusr']));
	if($keyUserEmail['type']==0){ $typeUserStatus=1; }
	elseif($keyUserEmail['type']==1){ $typeUserStatus=3; }
	//se actualiza el status del usuario
	$query=$db->update('users','status=?','id=?',array($typeUserStatus,$keyUserEmail['id']));
	//echo $db->lastSql();
	//se asignan el login y el password para iniciar sesion automaticamente
	//$_POST['txtLogin'] = $keyUserEmails[email];
	//$_POST['txtPass'] = $keyUserEmails[password_user];
	$db->close();
	unset($db);
	if(false){//si se hace login, se omiten ya que se realiza por ajax.
		include('controls/users/login.json.php');
		$data=array();
		$data['keep']=isset($_GET['keep'])||isset($_POST['keep'])||isset($_GET['keepLogin'])||isset($_POST['keepLogin']);
		$data['login']=$_POST['login']!=''?$_POST['login']:$_POST['txtLogin'];
		$data['pwd']=$_POST['pwd']!=''?$_POST['pwd']:($_POST['pass']!=''?$_POST['pass']:$_POST['txtPass']);
		$data['mobile']=APP::detect(false);
		echo 'data:';
		_imprimir($data);
		$res=login_json($data);
		if($res['logged']){
			/*?><script>
				var cookies=<?=json_encode($res['cookies'])?>;
				console.log('cookies');
				console.log(cookies);
				setAllCookies(cookies);
				<?=$_POST['hash']==''?'':'$.cookie("hash","'.$_POST['hash'].'");'?>
				redir('.');
			</script><?php /**/
			@header('Location:.');
			die();
		}elseif(APP::detect(false)){
			@header('Location:.');
			die();
		}else{
			?><script>
				$(function(){
					message('messages','Error<?=$res['from']?>','<?=$res['msg']?>','',350,200,'','');
				});
			</script><?php
		}
	}else{
		@header('Location:.');
	}
}
########## fin de validaciones especiales ##########

#mobile detection
APP::detect();

if($migrating){
	include('includes/config.php');
	if(!is_file('main/controllers/'.$section.'.php')){
		include('index_old.php');
		die();
	}
}

include 'main/core/globals.php';

global $section,$params,$control;
$control=new $section($params);
if(method_exists($control,'__onload')) $control->__onload($params);
$function='index';
if($control->use_methods()&&count($params)>0){
	if(method_exists($control,$params[0])) $function=array_shift($params);
	elseif(method_exists($control,'error')) $function='error';
	elseif(TAG_functions::is_debug()) die("No existe el metodo '{$params[0]}' ($section).");
	else die('Page not found.');
}
TAG_functions::call_method($control,$function,$params);

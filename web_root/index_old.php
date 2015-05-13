<?php
	include('includes/config.php');
	if($section=='image'){ include 'includes/imagen.php'; }
	// die($_SERVER['SERVER_NAME'].array_shift(split(basename(__DIR__),$_SERVER['REQUEST_URI'])).basename(__DIR__));
	if (isset($_GET['resizeimg'])) {
		include('includes/imagen.php');
		die();
	}
	if(strpos(' '.$_SERVER['HTTP_USER_AGENT'],'facebook.com'))
		include('includes/facebook.php');
	if(strpos($_SERVER['REQUEST_URI'],'index.php')&&!isset($_GET['source']))
	{@header('Location:'.str_replace('/index.php','',$_SERVER['REQUEST_URI']));die();}
	setcookie('__logged__',NULL,time()-3600,'/',$_SERVER['SERVER_NAME']);
	setcookie('__logged__',NULL,time()-3600,'/','.tagbum.com');
	include_once('includes/config.php');
	include('includes/session.php');
	include('includes/functions.php');
	include('class/wconecta.class.php');
	include('includes/languages.config.php');
	include('class/forms.class.php'); 
	if($section=='dialog'){
		header('Content-type: text/html; charset=utf-8');
		global $dialog;
		$dialog=true;
		include 'view.php';
		die();
	}
	keepLogin();
	//se detecta si se navega desde un mobile
	$detect=new Mobile_Detect();
	if($detect->isMobile()&&$_GET['ref']!=''){
		$ref=$_GET['ref'];
		unset($_GET['ref']);
		$get=array();
		foreach($_GET as $key=>$value) $get[]=$key.($value==''?'':"=$value");
		@header('Location:'.DOMINIO."app/$ref.php?".implode('&',$get));
		die();
	}

	$notAjax=true;

	//$notAjax=true;
	//verificamos si se desea crear una tag desde el wpanel
//	if($_GET['wpAddTag']==1){
//		$wpanel_login=CON::getRow('
//			SELECT '.fieldsLogin().'
//			FROM users
//			WHERE email="wpanel@tagbum.com" AND password_user="5a10d2e35f21dbab3e082e5732c69283"
//		');
//		createSession($wpanel_login);
//
//		//_imprimir($_SESSION);
//		//die();
//
//	}
	switch($_GET['current']){
		case 'newTag'		:include('controls/tags/newTag.controls.php');		die();//proceso de las nuevas tags
		case 'signIn'		:include('controls/users/login.control.php');		die();//login de los usuarios
		case 'resendPass'	:include('controls/users/resendPass.control.php');	die();//envio de link para resetear un clave de login
		case 'updateProfile':include('controls/users/profile.control.php');		die();//actualizacion de los perfiles de usuarios
	}

	//se logea automatico si viene de paypal y esta validado
	if( $_GET['current']=='payment' && $_GET['code']==$_SESSION['business_payment']['ws-user']['code'] ){
		$txnId=true;
		$status=CON::getRow('SELECT status,txn_id FROM paypal WHERE id_user=?',array($_SESSION['business_payment']['ws-user']['id']));
		if(count($status)>0){
			$txnId=$status['txn_id'];
			$status=$status['status'];
			//Dias de acceso
			$result=CON::getRow('
				SELECT end_date,IF(NOW()>=end_date,0,1) AS access
				FROM users_plan_purchase
				WHERE id_user=?
				ORDER BY end_date DESC
			',array($_SESSION['business_payment']['ws-user']['id']));
			//status = 1 = active, status = 5 = pending ambos tienen acceso
			if($status==1&&$result['access']==1){
				with_session(function($sesion){
					$sesion['ws-tags']=$sesion['business_payment'];
					unset($sesion['business_payment']);
					CON::update('users','logins_count=logins_count+1','email=?',array(cls_string($sesion['ws-tags']['ws-user']['email'])));
					$sesion['ws-tags']['ws-user']['logins_count']++;
					header('Location: login.php');
					return $sesion;
				});
			}
		}

	}
	//se actualiza la variable de session (status, pay_personal_tag) luego de venir de paypal
	//if( $_GET['current']=='paypalpayment' ){
	//$active_pay=CON::getRow('SELECT status,pay_personal_tag FROM users WHERE id=?',array($_SESSION['ws-tags']['ws-user']['id']));
	//$_SESSION['ws-tags']['ws-user']['status']=$active_pay['status'];
	//$_SESSION['ws-tags']['ws-user']['pay_perso_tag']=$active_pay['pay_personal_tag'];
	//}
	//mantiene el login si se perdio la sesion y se configuro para mantenerla
	$logged=$_SESSION['ws-tags']['ws-user']['id']!='';

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<!DOCTYPE html>
<html>
	<head>
	<base href="<?='http://'.$_SERVER['SERVER_NAME'].$config->base_url?>" />
	<title><?=TITLE?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=.5,maximum-scale=1.13,user-scalable=1"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<?php if ($txnId === true) {
	?>
		<meta HTTP-EQUIV="REFRESH" content="10;url=.?<?=end( explode( '?', $_SERVER["REQUEST_URI"]) )?>">
	<?php
	} ?>
<?php
//corrigiendo links dañados
if($_GET['tag']=='5de743f134186ab'){
	die('<META HTTP-EQUIV="refresh" CONTENT="0;URL=.">');
}
//redireccion si es mobile
//if($detect->isMobile()&&!$_SESSION['ws-tags']['ws-user']['fullversion']){
if($detect->isMobile()&&!$_COOKIE['__FV__']){?>
<script>(function(){
	var $_GET=<?=json_encode($_GET)?>;
	console.log($_GET);
	var url='<?=DOMINIO?>app/';
	if($_GET['tag']){
		url+='tag.php?id='+$_GET['tag']+'&referee='+($_GET['referee']||'');
	}else if($_GET['cordova']||$_GET['app']){
		url+='?cordova='+($_GET['cordova']||'')+'&app='+($_GET['app']||'');
	}else if($_GET['usr']){
		url+='resendPass.php?usr='+($_GET['usr']);
	}
	document.location=url;
})();</script>
<?php }
	//headers: js y css
	include('templates/css_js.php');
?>
<script>
	$(function(){
		<?php if($txnId===true){ ?>
			message('messages','<?=NEWTAG_LBLTEXT?>','<?=SIGNUP_WAITINGPAYPAL?>','','','','');
		<?php } ?>
		$(document).on('click','a,[onclick],button,input:submit,input:reset,input:button',function(){
			this.blur();
		});
		<?php if(isset($txnId)&&$txnId!==true){ ?>
			$.session('<?=$_SESSION['business_payment']['ws-user']['code']?>',true);
			document.location='.';
		<?php }else{ ?>
			if($.session('<?=$_SESSION['business_payment']['ws-user']['code']?>')){
				console.log(<?=json_encode($_SESSION)?>);
				$.session('<?=$_SESSION['business_payment']['ws-user']['code']?>',null);
				message('messages','<?=NEWTAG_LBLTEXT?>','<?=SIGNUP_ORDERINFO?>','','','','');
			}
		<?php } ?>
		<?php if (isset($_SESSION['ws-tags']['ws-user']['rgfb'])){
			unset($_SESSION['ws-tags']['ws-user']['rgfb']);
		?>
			$.dialog({
				title	:'<logo style="width: 130px;height: 50px;"></logo>',
				content	:'<div style="text-align:center;"><strong><?=SMT_SIGNUP_SUCCESS_TRUE_FACEB?></strong></div>',
				height	:300,
				width	:300
			});
		<?php } ?>

	});
</script>
<!-- Facebook Conversion Code for Tagbum -->
<script>(function() {
	var _fbq = window._fbq || (window._fbq = []);
	if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
	}
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6018767308743', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6018767308743&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
<!-----------------------------End facebook ---------------------------->
<meta name="alexaVerifyID" content="8YYp0pS3o8YkprRdkaeFqitio5Q"/>
</head>
<?php
	$background='';
	if ($_SESSION['ws-tags']['ws-user']['user_background']!='')
		if ($_SESSION['ws-tags']['ws-user']['user_background'][0]!='#')	$background='style="background-image:url('.($config->local?$config->main_server:$config->img_server).'img/users_backgrounds/'.$_SESSION['ws-tags']['ws-user']['user_background'].')"';
		else $background='style="background:'.$_SESSION['ws-tags']['ws-user']['user_background'].';"';
?>
<body lang="<?=$_SESSION['ws-tags']['language']?>" <?=$background?>>
<?php include_once("analyticstracking.php") ?>
<?php if(is_debug('show_data')){//Debugger: imprime variables para verificarlas ?>
	<div id="debug" style="position:absolute;z-index:1000000;top:0;background:#fff;display:none;">
		DOMINIO: <?=DOMINIO?><br/>
		FILESERVER: <?=FILESERVER?><br/>
		Seccion: <?=$section?><br/>
		$config: <?php _imprimir($config); ?>
		GET: <?php _imprimir($_GET); ?>
		POST: <?php _imprimir($_POST); ?>
		COOKIES: <?php _imprimir($_COOKIE); ?>
		SESSION: <?php is_debug('fullsession')?_imprimir($_SESSION):_imprimir($_SESSION['ws-tags']); ?>
	</div>
<?php }
	if(isset($_GET['command'])){
		include('templates/commands.php');
	}else{
		include('templates/page.php');
	}
?>
</body>
</html>

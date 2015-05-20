<?php
if($___session___) return;
$___session___=true;

/**
 * inicia la sesion y la deja en modo lectura solamente
 * @return void
 */
function load_session(){
	@session_start();
	session_write_close();
}
/**
 * permite trabajar con la variable de sesion en modo de escritura
 * @param  function $callable: funcion donde se trabaja con la sesion en modo escritura
 * -- la funcion puede recibir como parametro el contenido de la sesion
 * -- si se trabaja con el parametro de la funsion, este debe pasar por referencia o se retorna un array.
 * @return array (opcional): un arreglo que sustituira la sesion actual
 */
function with_session($callable){
	@session_start();
	if(is_callable($callable)) $response=$callable($_SESSION);
	if(is_array($response)) $_SESSION=$response;
	session_write_close();
}

with_session(function(&$sesion){
	$__val=$sesion['ws-tags']['ws-user']['id']!=''?md5($sesion['ws-tags']['ws-user']['id']):NULL;
	$__code=$sesion['ws-tags']['ws-user']['code']!=''?$sesion['ws-tags']['ws-user']['code']:NULL;
	$__t=$__val?60*30:-3600;
	$__time=time()+$__t;
	if( $sesion['ws-tags']['ws-user']['id']=='' xor $_COOKIE['__logged__']=='' ){
		setcookie('__logged__',$__val?md5($sesion['ws-tags']['ws-user']['time']):NULL,$__time,'/');
	}
	#guardar cookies para subdominios. Solo en el dominio principal.
	$__dominio='tagbum.com';
	if(isset($sesion['ws-tags'])&&strpos($_SERVER['SERVER_NAME'],$__dominio)!==FALSE){
		$__dominio='.'.$__dominio;
	}else{
		$__dominio='';
	}
	setcookie('__uid__',$__val?$__val:NULL,$__time,'/',$__dominio);
	setcookie('__code__',$__code?$__code:NULL,$__time,'/',$__dominio);

	if(	!strpos($_SERVER['PHP_SELF'],'carouselTags.view.php')	&&	!strpos($_SERVER['PHP_SELF'],'registerTabs.view.php') &&
		!strpos($_SERVER['PHP_SELF'],'resendPassword.view.php')	&&	!$sesion['ws-tags']['ws-user']['id'] &&
		$_POST['asyn']=='1' ){
			die('1');
	}
	#regex dominios: /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/
});

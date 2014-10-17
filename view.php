<?php
global $config,$dialog,$notAjax,$bodyPage,$setting;
$setting=$config;
if(!$config){
include('includes/config.php');
include('includes/session.php');
include('includes/functions.php');
include('class/wconecta.class.php');
include('class/Mobile_Detect.php');
include('includes/languages.config.php');
include('class/forms.class.php');
header('Cache-Control:no-cache,must-revalidate');
header('Expires:Mon, 26 Jul 1997 05:00:00 GMT');
}
//id de pagina
if(isset($_GET['pageid'])) $idPage=$_GET['pageid'];
//nombre de la pagina a abrir
$currentPage=404;
if(isset($_GET['page'])) $currentPage=$_GET['page'];
//Logged: verificar si esta logeado
$logged=$_SESSION['ws-tags']['ws-user']['id']!='';
#local o servidor
$local=!!preg_match('/^(local|127\.|192\.168\.)/',$_SERVER['SERVER_NAME']);
//paginas que se pueden abrir sin logear
$f_unlogged=array(
	'main/home.php',
	'main/signUp.php',
	'main/resendPassword.php',
	'main/resetPassword.php',
	'main/dialogs.php',
    'users/eprofile.php',
    'user.php',
    'users/account.php',
	'tags/comment.php',
	'users/business.paypal.php',
	'tags/tag.php'
);
//cantidad de paneles, default:3
$numPanels=isset($numPanels)?$numPanels:3;
//nombre del archivo con el contenido principal de la pagina
$bodyPage=false;
/*---------hashtags antiguos
	profile				*	views/users/account.view.php
	timeLine			*	views/tags/timeLine.view.php
	creation			*	views/tags/newTag.view.php
	friends				*	views/users/friends.view.php
	products			*	views/products/lstProducts.view.php
	signup				*	views/users/registerTabs.view.php
	update				*	views/tags/update.view.php
	resendPassword		*	views/users/resendPassword.view.php
	groups				*	views/groups/list.view.php
	home				*	views/tags/carouselTags.view.php
	carousel			*	views/tags/carouselTags.view.php
	preferences				views/users/account.view.php'+get+'&activeTab=1
	businessCardEdit		views/users/account.view.php?activeTab=2
	businessCard			views/users/account.view.php'+get+'&activeTab=2
	changePassword			views/users/account.view.php'+get+'&activeTab=3
	privacy					views/users/account.view.php'+get+'&activeTab=4
	MytimeLine				views/tags/timeLine.view.php'+get+'&activeTab=3
	notifications			views/users/notifications.view.php
	tagsOfMonth				views/tags/carouselTags.view.php'+get+'&current=hits&range=1
	tagsOfWeek				views/tags/carouselTags.view.php'+get+'&current=hits&range=2
	tagsOfDay				views/tags/carouselTags.view.php'+get+'&current=hits&range=3
	myPubli					views/publicity/lstPublicity.view.php
	cropThumb				views/users/foto.view.php
	personalTag				views/tags/newTag.view.php
	personalTagBC			views/tags/newTag.view.php
	loadExternalProfile		views/external_profile/externalProfile.view.php
	externalProfile			views/external_profile/externalProfile.view.php
	view					views/tags/viewTag.view.php
	news					views/news/timeLineNews.view.php
	test gustavo
 */
if( isset($_GET['tag'])&&( (!$logged&&$idPage=='home')||($logged&&$idPage=='carousel') ) )
	$idPage='comment';
if($idPage=='term') $idPage='terms';
if($notAjax&&($idPage==''||$idPage=='/')) $idPage='home';
$go_switch=true;
if($idPage!=''){#paginas
	if(is_file("views/temp/$idPage.php")&&(/*$local||*/is_debug())){
		$currentPage="temp/$idPage.php";
		$go_switch=false;
	}elseif(is_file("views/$idPage.php")){
		$currentPage="$idPage.php";
		$go_switch=false;
	}
}
if($go_switch) switch($idPage){
	case 'home':case 'WhatIsIt':case 'HowDoesWork':case 'HowDoesWork/1':case 'HowDoesWork/2':case 'App':
		$bodyPage='main/home.php'; $numPanels=1; break;
	case 'signup'			:$currentPage=$logged?'main/redir.php':'main/signUp.php'; break;
	case 'resendPassword'	:$currentPage=$logged?'main/redir.php':'main/resendPassword.php';break;
	case 'resetPassword'	:$currentPage='main/resetPassword.php';break;
	case 'paybusiness'		:$currentPage=$logged?'main/redir.php':'users/business.paypal.php';break;
	case 'profile'			:$bodyPage='users/account.php';$numPanels=2;break;
	case 'eprofile'			:$bodyPage='users/eprofile.php';$numPanels=2;break;
	case 'creation':case 'update':
		$bodyPage='tags/new/newTag.php';break;
	case 'friends'			:$bodyPage='users/friends.php';break;
	case 'tags':case 'tagslist':case 'timeline':
		$bodyPage='tags/tagsList.php';break;
	case 'tag'			    :$bodyPage='tags/tag.php';break;
	case 'toptag'			:$bodyPage='tags/tagsList.php';$cache=true;break;
	case 'comment'			:$bodyPage='tags/tag.php';break;
	case 'carousel'			:$bodyPage='tags/carousel.php';break;
	case 'news'				:$bodyPage='news/news.php';break;
	case 'groups'			:$bodyPage='users/groups/allGroups.php';$rightPanel='users/groups/panel.php';break;
	case 'groupsDetails'	:$bodyPage='users/groups/profileGroup.php';break;
	case 'products'			:$bodyPage='products/products.php';break;
	case 'publicity'		:$bodyPage='publicity/lstPublicity.view.php';break;
	case 'setting'			:$bodyPage='users/settings/mailNotifications.php';$numPanels=2;break;
	case 'searchall'		:$bodyPage='main/searchAll.php';break;
	case 'about':case 'blog':case 'help':case 'terms':
	case 'cookies':case 'developers':case 'privacity':
		$currentPage='main/dialogs.php';break;
	case 'welcome'			:$bodyPage='main/welcome.php';$numPanels=1;break;
	case 'mypublications'   :case 'freeproducts':case 'myfreeproducts'	:case 'myparticipation'	:
	case 'store'            :$bodyPage='store/productList.php'; $rightPanel='store/panel.php'; break;
	case 'detailprod'       :$bodyPage='store/detailProd.php';$numPanels=2;break;
	case 'newproduct'       :$bodyPage='store/newProduct.php';break;
    case 'orders':case 'sales': case 'wishList':
	case 'shoppingcart'		:$bodyPage='store/shoppingCart.php';$rightPanel='store/panel.php'; break;
	case 'shippingaddress'	:$bodyPage='store/user_ShoppingCart.php';break;
	case 'wpanel'			:
		$url=end(split('wpanel',$_SERVER['REQUEST_URI']));
		$url=preg_replace('/[\?&]/','?',$url,1);
		die('<script>document.location="wpanel'.$url.'";</script>');break;
	default:
		$bodyPage='users/eprofile.php';$numPanels=2;
}

if($bodyPage) $currentPage='main/wrapper.php';

if($currentPage==404){
	$currentPage='main/wrapper.php';
	$numPanels=2;
	$bodyPage='main/failure.php';
}

if($logged){
	// if($currentPage==$f_unlogged[0]||$currentPage==$f_unlogged[1])
	// 	$currentPage='main/wrapper.php';
	
	//STORE se verifica si la orden de la variable session ya esta paga 
	//(esto es en caso de que el pago se realizo por paypal para borrar la variable session car)
	$numIt=createSessionCar('','','count');
	if ($numIt!='0'&&$numIt !=''){
		$GLOBALS['cn']->query('UPDATE store_orders SET date=NOW() WHERE id_status="1" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'"');
	}
}else{
	if(!in_array($currentPage,$f_unlogged)&&!in_array($bodyPage,$f_unlogged)){
		//die('404');
		$currentPage='main/wrapper.php';
		$bodyPage='main/failure.php';
	}
}
unset($f_unlogged);
echo '<!--views: '.$_SERVER['SCRIPT_NAME'].','.$_SERVER['REQUEST_URI'].','.'logged='.($logged?'true':'false').", id=$idPage, body=$bodyPage, page=$currentPage, -->";
if($dialog){
	if($bodyPage) include('views/'.$bodyPage);
	else include('views/'.$currentPage);
}else{
	if($notAjax&&$currentPage!='main/wrapper.php'){ $bodyPage=$currentPage; $currentPage='main/wrapper.php'; }
	include('views/'.$currentPage);
}
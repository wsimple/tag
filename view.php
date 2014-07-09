<?php
global $dialog;
if($idPage==''){
include('includes/session.php');
include('includes/config.php');
include('class/Mobile_Detect.php');
include('includes/functions.php');
include('class/wconecta.class.php');
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
//paginas que se pueden abrir sin logear
$f_unlogged=array(
	'main/home.php',
	'main/signUp.php',
	'main/resendPassword.php',
	'main/resetPassword.php',
	'main/dialogs.php',
    'users/eprofile.php',
    'users/account.php',
	'tags/comment.php',
	'users/business.paypal.php'
);
//cantidad de paneles, default:3
$numPanels=isset($numPanels)?$numPanels:3;
//nombre del archivo con el contenido principal de la pagina
$bodyPage=false;
//panel derecho (si son 3 paneles)
$rightPanel='users/newsUsers.php';
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
 */
if( isset($_GET['tag'])&&( (!$logged&&$idPage=='home')||($logged&&$idPage=='carousel') ) )
	$idPage='comment';
if($idPage=='term') $idPage='terms';
if(!isset($idPage)&&$currentPage==404) $idPage='home';
switch($idPage){
	case 'home':case 'whatIsIt':case 'howDoesWork':case 'howDoesWork/1':case 'howDoesWork/2':case 'app':
		$currentPage=$logged?'main/redir.php':'main/home.php'; break;
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
	case 'comment'			:$bodyPage='tags/comment.php';break;
	case 'carousel'			:$bodyPage='tags/carousel.php';break;
	case 'groups'			:$bodyPage='users/groups/allGroups.php';$rightPanel='users/groups/panel.php';break;
	case 'groupsDetails'	:$bodyPage='users/groups/profileGroup.php';break;
	case 'products'			:$bodyPage='products/products.php';break;
	case 'publicity'		:$bodyPage='publicity/lstPublicity.view.php';break;
	case 'setting'			:$bodyPage='users/settings/mailNotifications.php';$numPanels=2;break;
	case 'searchall'		:$bodyPage='main/searchAll.php';break;
	case 'about':case 'blog':case 'help':case 'terms':
	case 'cookies':case 'developers':case 'privacity':
		$currentPage='main/dialogs.php';break;
	case 'welcome'			:$currentPage='main/welcome.php';break;
	case 'mypublications'   :case 'freeproducts':case 'myfreeproducts'	:case 'myparticipation'	:
	case 'store'            :$bodyPage='store/productList.php'; $rightPanel='store/panel.php'; break;
	case 'detailprod'       :$bodyPage='store/detailProd.php';$numPanels=2;break;
	case 'newproduct'       :$bodyPage='store/newProduct.php';break;
    case 'orders':case 'sales': case 'wishList':
	case 'shoppingcart'		:$bodyPage='store/shoppingCart.php';$rightPanel='store/panel.php'; break;
	case 'shippingaddress'	:$bodyPage='store/user_ShoppingCart.php';break;
	default:
		if(file_exists("views/$idPage.php")){
			$currentPage="$idPage.php";
		}elseif(file_exists("views/$idPage.2.php")){
			$bodyPage="$idPage.2.php";$numPanels=2;
		}elseif(file_exists("views/$idPage.3.php")){
			$bodyPage="$idPage.3.php";$numPanels=3;
		}elseif(LOCAL){
			if(file_exists("views/temp/$idPage.php")){
				$currentPage="temp/$idPage.php";
			}elseif(file_exists("views/temp/$idPage.2.php")){
				$bodyPage="temp/$idPage.2.php";$numPanels=2;
			}elseif(file_exists("views/temp/$idPage.3.php")){
				$bodyPage="temp/$idPage.3.php";$numPanels=3;
			}else{
				$bodyPage='users/eprofile.php';$numPanels=2;
			}
		}else{
			$bodyPage='users/eprofile.php';$numPanels=2;
		}
}

if($bodyPage) $currentPage='main/wrapper.php';

if($currentPage==404){
	$currentPage='main/wrapper.php';
	$numPanels=2;
	$bodyPage='main/failure.php';
}

if($logged){
	if($currentPage==$f_unlogged[0]||$currentPage==$f_unlogged[1])
		$currentPage='main/wrapper.php';
	
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
if($dialog){
	if($bodyPage) include('views/'.$bodyPage);
	else include('views/'.$currentPage);
}else{
include('views/'.$currentPage);
?>
<script>
	$('body').css('background','<?=($_SESSION['ws-tags']['ws-user']['user_background']==''?'':($_SESSION['ws-tags']['ws-user']['user_background'][0]!='#' ?
		'url('.FILESERVER.'img/users_backgrounds/'.$_SESSION['ws-tags']['ws-user']['user_background'].')' :
		$_SESSION['ws-tags']['ws-user']['user_background']
	))?>');
</script>
<?php } ?>
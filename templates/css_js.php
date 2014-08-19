<?php global $section; $minify=!$config->local&&!is_debug('minify'); ?>
<?php if(preg_match('/msie [6-8]/i',$_SERVER['HTTP_USER_AGENT'])&&preg_match('/chromeframe/i',$_SERVER['HTTP_USER_AGENT'])) { ?>
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?php } ?>
<link rel="apple-touch-startup-image" href="css/smt/main_bg.png"/>
<link rel="icon" href="css/smt/icon.png" type="image/png"/>
<meta http-equiv="cache-control" content="no-cache"/>
<meta name="robots" content="all,index,follow"/>
<meta name="rating" content="General"/>
<meta name="reply-to" content="<?=EMAIL_CONTACTO?>"/>
<meta name="copyright" content="<?=COPYRIGHT?>"/>
<meta name="Author" content="<?=AUTHOR?>"/>
<meta name="description" content="<?=DESCRIPTION?>"/>
<meta name="google-site-verification" content="OVxfKydQKcISwAEi9um6hz88kHTvsjXhay_PTsbMC1I"/>
<link rel="shortcut icon" href="css/smt/icon.png"/>
<link rel="apple-touch-icon" href="css/smt/icon.png"/>
<script>
var BASEURL='<?=base_url()?>',
	FILESERVER='<?=FILESERVER?>',
	DOMINIO='<?=DOMINIO?>',
	SECTION='<?=$section?>',
	ISLOGGED=<?=$_SESSION['ws-tags']['ws-user']['id']!=''?'true':'false'?>;
if(!ISLOGGED &&'localStorage' in window && window['localStorage']!==null) localStorage.removeItem('logged');
(function(l){ if(!l.search.match(/hashtag=/)&&l.hash.match(/#[a-z]/)) l.href=BASEURL+'?'+l.search.substr(1)+'&hashtag='+l.hash.substr(1); })(document.location);
</script>
<script src="min/?f=js/language_<?=$lang['langcode']?>.js" charset="utf-8"></script>
<?php if($minify){ ?>
	<link href="min/?g=css" rel="stylesheet"/>
	<script src="min/?g=js" charset="utf-8"></script>
	<script src="http://www.youtube.com/iframe_api"></script>
	<script src="min/?f=js/funciones_<?=$lang['langcode']?>.js" charset="utf-8"></script>
<?php }else{
	$cssJsLocal= (require 'min/groupsConfig.php');
	$cssLocal=$cssJsLocal['css'];
	$jsLocal=$cssJsLocal['js'];
	foreach ($cssLocal as $css) {
		echo '<link href="'.str_replace('//', '', $css).'" rel="stylesheet">';
	}
	foreach ($jsLocal as $js) {
		echo '<script src="'.str_replace('//', '', $js).'" charset="utf-8"></script>';
	}?>
	<script src="http://www.youtube.com/iframe_api"></script>
	<script src="js/funciones.js.php" charset="utf-8"></script>
<?php } ?>

<?php	if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
<script type="text/javascript" src="<?=$minify?"min/?f=":""?>js/jquery.tipsy.js"></script>
<?php	}
		if ( $_SESSION['ws-tags']['ws-user']['id']!='' && !$config->local){ ?>
<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8" />
<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<?php	} ?>

<?php if($lang['langcode']=='es') { ?><script src="js/chosen.es.js"></script><?php } ?>

<?php if($_SESSION['ws-tags']['ws-user']['id']!=''){//si esta loggeado ?>
<script	type="text/javascript"	src="<?=$minify?"min/?f=":""?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link	type="text/css"			href="<?=$minify?"min/?f=":""?>css/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet"/>
<?php }else{//deslogeado ?>
<link rel="stylesheet" type="text/css" href="<?=$minify?"min/?f=":""?>css/jquery.fullPage.css" />
<script type="text/javascript" src="<?=$minify?"min/?f=":""?>js/jquery.fullPage.js"></script>
<?php } ?>
<!-- Compliance patch for Microsoft browsers -->
<!--[---if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE9.js"></script><![endif]-->

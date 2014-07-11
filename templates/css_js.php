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

<link href="css/normalize.css" rel="stylesheet">
<link href="css/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
<link href="css/jquery-ui.smt.css" rel="stylesheet"/>
<link href="css/farbtastic.css" rel="stylesheet"/>
<link href="css/jquery.ui.selectmenu.css" rel="stylesheet" media="all"/>
<link href="css/autocompleter.css" rel="stylesheet" media="all"/>
<link href="css/jquery-te-1.4.0.css" rel="stylesheet" media="all"/>
<link href="css/mainMenu.css" rel="stylesheet"/>
<link href="css/guidely/guidely.css" rel="stylesheet" type="text/css" />
<?php global $section,$noHash; ?>
<script> var FILESERVER='<?=FILESERVER?>',DOMINIO='<?=DOMINIO?>',SECTION='<?=$section?>',BASEURL='<?=base_url()?>'; </script>
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.cookie.js" ></script>
<script src="js/jquery.local.js" ></script>
<script src="js/session.js" ></script>
<script>
	isLogged(<?=$_SESSION['ws-tags']['ws-user']['id']!=''?'true':'false'?>);
	<?php if($_SESSION['ws-tags']['ws-user']['id']==''&&$_COOKIE['__logged__']!=''){?>$.cookie('__logged__',null);<?php } ?>
</script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.ba-hashchange.min.js"></script>
<script src="js/jquery.placeholder-1.01.js"></script>
<script src="js/jquery.form.js" ></script>
<script src="js/jquery.qajax.js"></script>
<script src="js/carousels/jquery.carouFredSel.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/language.js.php"></script>
<script src="js/jquery.textCounter.js"></script>
<script src="js/farbtastic.js"></script>
<script src="js/jquery.ui.selectmenu.js"></script>
<script src="js/jquery.fcbkcomplete.js"></script>
<script src="js/jQuery.fileinput.js"></script>
<script src="js/jquery-te-1.4.0.js"></script>
<script src="js/mainMenu.js"></script>
<script src="js/currency/jquery.formatCurrency-1.4.0.js"></script>
<script src="js/currency/jquery.formatCurrency.all.js"></script>
<script src="js/guidely.js" charset="utf-8"></script>
<script src="js/md5.js" charset="utf-8"></script>
<script src="js/console.js" charset="utf-8"></script>

<?php	if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
<script type="text/javascript" src="js/jquery.tipsy.js"></script>
<?php	}
		if ( $_SESSION['ws-tags']['ws-user']['id']!='' && !LOCAL){ ?>
<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8" />
<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<?php	} ?>

<link rel="stylesheet" href="css/old.css" type="text/css"/>
<link href="css/seemytag.css" rel="stylesheet"/>
<link href="css/portrait.css" rel="stylesheet" media="screen and (orientation:portrait)"/>
<link href="css/browser.css" rel="stylesheet"/>
<?php if(!isset($_GET['command'])) { ?>
	<?php if(!$noHash){ ?>
	<script src="js/conhash.js.php"></script>
	<?php } ?>
<script src="js/base.js.php"></script>
<script src="js/funciones.js.php"></script>
<?php } ?>

<link href="css/chosen.css" rel="stylesheet"/>
<script src="js/chosen.jquery.js"></script>
<?php if($_SESSION['ws-tags']['language']=='es') { ?><script src="js/chosen.es.js"></script><?php } ?>

<?php if($_SESSION['ws-tags']['ws-user']['id']!=''){//si esta loggeado ?>
<script	type="text/javascript"	src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link	type="text/css"			href="css/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet"/>
<?php }else{//deslogeado ?>
<!--<link rel="stylesheet" href="css/website.css" type="text/css" media="screen"/>
<script type="text/javascript" src="js/jquery.tinycarousel.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
<script type="text/javascript" src="js/jquery.fullPage.js"></script>
<?php } ?>

<!-- Compliance patch for Microsoft browsers -->
<!--[---if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE9.js"></script><![endif]-->

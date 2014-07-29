<?php
	global $noHash;
	$noHash=true;
	include ('../../../includes/config.php');
	include ('../../../includes/session.php');
	include ('../../../includes/functions.php');
	include ('../../../class/wconecta.class.php');
	include ('../../../includes/languages.config.php');
?>
<html>
<head></head>
<body style="margin:5px 0 0 0;">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=141402139297347&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-share-button" data-href="<?=DOMINIO.base_url('tag?tag='.$_GET['tag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code'])?>"></div>
</body>
</html>

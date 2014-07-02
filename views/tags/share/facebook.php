<?php
	include ('../../../includes/session.php');
	include ('../../../includes/functions.php');
	include ('../../../includes/config.php');
	include ('../../../class/wconecta.class.php');
	include ('../../../includes/languages.config.php');
?>
<html>
<head></head>
<body style="margin:5px 0 0 0;">
	<a name="fb_share" type="button" share_url="<?=DOMINIO.'#tag?tag='.$_GET['tag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code']?>">&nbsp;</a>
	<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
	<!--
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-like" data-href="<?=DOMINIO.'?tag='.substr(md5($_GET['tag']),-15)?>" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div>
	-->
</body>
</html>

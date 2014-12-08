<?php
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
	  js.src = "//connect.facebook.net/<?=lan('fb_lang')?>/sdk.js#xfbml=1&appId=141402139297347&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<!-- <div class="fb-share-button" data-href="<?=DOMINIO.'tag/'.$_GET['tag']?>"></div> -->
	<style>
  .fb-share-button{
	transform: scale(1.5);
	-ms-transform: scale(1.5);
	-webkit-transform: scale(1.5);
	-o-transform: scale(1.5);
	-moz-transform: scale(1.5);
	transform-origin: top left;
	-ms-transform-origin: top left;
	-webkit-transform-origin: top left;
	-moz-transform-origin: top left;
	-webkit-transform-origin: top left;
	}
  </style>
	<div class="fb-share-button" data-href="<?=DOMINIO.base_url('tag?tag='.$_GET['tag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code'])?>" data-layout="button"></div>
</body>
</html>


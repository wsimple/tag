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
	<style>
  .twitter-share-button{
	transform: scale(1.1);
	-ms-transform: scale(1.1);
	-webkit-transform: scale(1.1);
	-o-transform: scale(1.1);
	-moz-transform: scale(1.1);
	transform-origin: top left;
	-ms-transform-origin: top left;
	-webkit-transform-origin: top left;
	-moz-transform-origin: top left;
	-webkit-transform-origin: top left;
	}
  </style>
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=DOMINIO.'tag/'.$_GET['tag']?>" data-via="tgbum" data-size="large" data-text="<?=$lang['TW_DATATEXT']?>" <?=$lagn['TW_DATALANG']?> data-count="none"><?=$lang['TW_TWEET']?></a>
	<!-- <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=DOMINIO.'#tag?tag='.$_GET['tag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code']?>" data-via="tagbum" data-text="<?=TW_DATATEXT?>" <?=TW_DATALANG?>><?=TW_TWEET?></a> -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</body>
</html>

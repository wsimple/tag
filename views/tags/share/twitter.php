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
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=DOMINIO.'tag/'.$_GET['tag']?>" data-via="tagbum" data-text="<?=$lang['TW_DATATEXT']?>" <?=$lagn['TW_DATALANG']?>><?=$lang['TW_TWEET']?></a>
	<!-- <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=DOMINIO.'#tag?tag='.$_GET['tag'].'&referee='.$_SESSION['ws-tags']['ws-user']['code']?>" data-via="tagbum" data-text="<?=TW_DATATEXT?>" <?=TW_DATALANG?>><?=TW_TWEET?></a> -->
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</body>
</html>

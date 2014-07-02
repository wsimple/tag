<div class="ui-single-box _tt" style="min-height:500px;"><div class="_tc">
	<div class="warning-box">
		<?php if($_SESSION['ws-tags']['ws-user']['id']!=''){//logged ?>
			<?=CONTENT_NOT_AVAILABLE?>
		<?php }else{//not logged ?>
			<p><?=CONTENT_NEED_LOGIN?></p>
			<a class="prinTitle iconLogin" id="login"><?=LANDING_LOGIN?></a>
		<?php } ?>
	</div>
</div></div>

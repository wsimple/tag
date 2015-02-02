<?php if ($_SESSION['ws-tags']['ws-user']['id']!=''&&is_debug()){
	if (!isset($_SESSION['ws-tags']['ws-user']['progress']) 
		|| (isset($_SESSION['ws-tags']['ws-user']['progress']) && !isset($_SESSION['ws-tags']['ws-user']['progress']['omitir']))){
		if (!isset($_SESSION['ws-tags']['ws-user']['progress']['value']) 
			&& $_SESSION['ws-tags']['ws-user']['progress']['value']!==false)
			$_SESSION['ws-tags']['ws-user']['progress']['value']=calculateProgress();
		$value=$_SESSION['ws-tags']['ws-user']['progress']['value'];
		$active=true;
	}else $active=false;
	if (isset($_SESSION['ws-tags']['ws-user']['progress']['omitir'])){
		$_SESSION['ws-tags']['ws-user']['progress']['omitir']++;
		if ($_SESSION['ws-tags']['ws-user']['progress']['omitir']>=50) unset($_SESSION['ws-tags']['ws-user']['progress']['omitir']);
	}
?>
<?php if ($active): ?>
<div class="ui-single-box topBanner progress">
	<?php if ($value['profile']<100): ?>
		<div>
			<div id="p-profile" class="s"></div><span>%<?=round($value['profile'])?></span>
			<strong><?=lan('INCONPLETE_INFORMATION_PROFILE')?></strong>
			<a href="<?=base_url('profile')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
		</div>
	<?php endif; ?>
	<?php if ($value['preferences']<100): ?>
		<div>
			<div id="p-preferences" class="s"></div><span>%<?=round($value['preferences'])?></span>
			<strong><?=lan('USER_PREFERENCES_INCOMPLETE')?></strong>
			<a href="<?=base_url('user/preferences')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
		</div>
	<?php endif; ?>
	<a href="<?=DOMINIO?>" class="skip"><?=lan('skip')?></a>
	<div class="clearfix"></div>
</div>
<script>
	(function(){
		var profile=("<?=$value['profile']?>")*1,preferences=("<?=$value['preferences']?>")*1;
		$("#p-profile").progressbar({
			value:profile
		});
		$("#p-preferences").progressbar({
			value:preferences
		});
		$('.ui-single-box.topBanner.progress a.skip').click(function(event){
			event.preventDefault();
			$(this).parents('.ui-single-box.topBanner.progress').remove();
			$.ajax({
				url:"controls/users/profile.json.php?skipProgress=1",
			});
		});
	})();
</script>
<?php endif; ?>
<?php } ?>
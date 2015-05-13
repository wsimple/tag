<?php if($_SESSION['ws-tags']['ws-user']['id']=='') return;

if(!isset($_SESSION['ws-tags']['ws-user']['progress']) 
	|| (isset($_SESSION['ws-tags']['ws-user']['progress']) && !isset($_SESSION['ws-tags']['ws-user']['progress']['omitir']))){
	if(!isset($_SESSION['ws-tags']['ws-user']['progress']['value']) 
		&& $_SESSION['ws-tags']['ws-user']['progress']['value']!==false)
		with_session(function($sesion){
			$sesion['ws-tags']['ws-user']['progress']['value']=calculateProgress();
			return $sesion;
		});
	$value=$_SESSION['ws-tags']['ws-user']['progress']['value'];
	if(($value['profile']<100 && ($section!='user' && $params[0]!='preferences')) || 
		($value['preferences']<100 && $section!='profile')) $active=true;
	else $active=false;
}else $active=false;
if(isset($_SESSION['ws-tags']['ws-user']['progress']['omitir'])){
	with_session(function(){
		$_SESSION['ws-tags']['ws-user']['progress']['omitir']++;
		if($_SESSION['ws-tags']['ws-user']['progress']['omitir']>=50) unset($_SESSION['ws-tags']['ws-user']['progress']['omitir']);
	});
}

if ($active && $section!='creation'): ?>
<div class="ui-single-box topBanner progress">
	<?php if($value['profile']<100 && ($section!='user' && $params[0]!='preferences')): ?>
		<div>
			<div id="p-profile" class="s"></div><em>%<?=round($value['profile'])?></em>
			<div>
				<span><?=lan('INCONPLETE_INFORMATION_PROFILE')?></span>
				<a href="<?=base_url('profile')?>" class="color-pro"><?=lan('TO_COMPLETE','ucw').' '.lan('SIGNUP_H5TITLE1')?></a>
			</div>
		</div>
	<?php endif; ?>
	<?php if($value['preferences']<100 && $section!='profile'): ?>
		<div>
			<div id="p-preferences" class="s"></div><em>%<?=round($value['preferences'])?></em>
			<div>
				<span><?=lan('USER_PREFERENCES_INCOMPLETE')?></span>
				<a href="<?=base_url('user/preferences')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
			</div>
		</div>
	<?php endif; ?>
	<a href="<?=DOMINIO?>" class="skip"><?=lan('skip','ucw')?></a>
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
<?php
endif;

<?php if ($_SESSION['ws-tags']['ws-user']['id']!=''){
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
			<!-- <progress id="p-profile" value="0" max="100"></progress><span></span><br/> -->
			<!-- <progress id="p-profile" value="<?=$value['profile']?>" max="100"></progress> -->
			<strong><?=lan('INCONPLETE_INFORMATION_PROFILE')?></strong>
			<a href="<?=base_url('profile')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
		</div>
	<?php endif; ?>
	<?php if ($value['preferences']<100): ?>
		<div>
			<div id="p-preferences" class="s"></div><span>%<?=round($value['preferences'])?></span>
			<!-- <progress id="p-preferences" value="0" max="100"></progress><span></span><br/> -->
			<!-- <progress id="p-preferences" value="<?=$value['preferences']?>" max="100"></progress> -->
			<strong><?=lan('USER_PREFERENCES_INCOMPLETE')?></strong>
			<a href="<?=base_url('user/preferences')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
		</div>
	<?php endif; ?>
	<a href="<?=DOMINIO?>" ><?=lan('skip')?></a>
	<div class="clearfix"></div>
</div>
<?php endif; ?>
<script>
	window.onload = function() { 
		var active=('<?=$active?>')*1;
		if (active==1){
			var profile=("<?=$value['profile']?>")*1,preferences=("<?=$value['preferences']?>")*1;
			$("#p-profile").slider({
				min:0,
				max:100,
				range:true,
				step:1,
				values:[0,profile],
				disabled:true
			});
			$("#p-preferences").slider({
				min:0,
				max:100,
				range:true,
				step:1,
				values:[0,preferences],
				disabled:true
			});
			$('.ui-single-box.topBanner.progress a').click(function(event){
				event.preventDefault();
				$(this).parents('.ui-single-box.topBanner.progress').remove();
				$.ajax({
					url:"controls/users/profile.json.php?skipProgress=1",
				});
			});
			// $('.ui-single-box.progress').show();		
			// animateprogress("#p-profile",profile);
			// animateprogress("#p-preferences",preferences);
		}
	}
// 	/*@ Barras de progreso HTML5 animadas con Javascript
//     @ author Agustín Baraza (contacto@nosolocss.com)
//     @ Copyright 2014 nosolocss.com. All rights reserved
//     @ http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
//     @ link http://www.nosolocss.com 	*/
// function animateprogress (id, val){
// 	var getRequestAnimationFrame = function () { 
// 		return window.requestAnimationFrame ||
// 		window.webkitRequestAnimationFrame ||   
// 		window.mozRequestAnimationFrame ||
// 		window.oRequestAnimationFrame ||
// 		window.msRequestAnimationFrame ||
// 		function ( callback ){
// 			window.setTimeout(enroute, 1 / 60 * 1000);
// 		};
// 	};
// 	var fpAnimationFrame = getRequestAnimationFrame();   
// 	var i = 0;
// 	var animacion = function () {		
// 		if (i<=val){
// 			document.querySelector(id).setAttribute("value",i);     
// 			document.querySelector(id+"+ span").innerHTML = i+"%";    
// 			i++;
// 			fpAnimationFrame(animacion);          
// 		}									
// 	}
// 	fpAnimationFrame(animacion);
// }
</script>
<?php } ?>
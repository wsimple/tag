<?php if ($_SESSION['ws-tags']['ws-user']['id']!=''){
	unset($_SESSION['ws-tags']['ws-user']['progress']);
	if (!isset($_SESSION['ws-tags']['ws-user']['progress']) 
		|| (isset($_SESSION['ws-tags']['ws-user']['progress']) && !isset($_SESSION['ws-tags']['ws-user']['progress']['omitir']))){
		if (!isset($_SESSION['ws-tags']['ws-user']['progress']['value']) 
			&& $_SESSION['ws-tags']['ws-user']['progress']['value']!==false)
			$_SESSION['ws-tags']['ws-user']['progress']['value']=calculateProgress();
		$value=$_SESSION['ws-tags']['ws-user']['progress']['value'];
		$active=true;
	}else $active=false;
	//INCONPLETE_INFORMATION_PROFILE
	//USER_PREFERENCES_INCOMPLETE
	//TO_COMPLETE
	//SIGNUP_H5TITLE1
?>
<?php if ($active): ?>
<div class="ui-single-box topBanner progress">
<div>
	<?php if ($value['profile']<100): ?>
		<div>
			<progress id="p-profile" value="0" max="100"></progress>
			<!-- <progress id="p-profile" value="<?=$value['profile']?>" max="100"></progress> -->
			<span></span><br/>
			<strong>Disculpe, su perfil no está completo. Completa tu información de perfil para prestarle un mejor servicio.</strong>
			<a href="<?=base_url('profile')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
		</div>
	<?php endif; ?>
	<?php if ($value['preferences']<100): ?>
		<div>
			<progress id="p-preferences" value="0" max="100"></progress>
			<!-- <progress id="p-preferences" value="<?=$value['preferences']?>" max="100"></progress> -->
			<span></span><br/>
			<strong>No has terminado decirnos sus preferencias. indicar sus preferencias para ofrecer lo que estás buscando.</strong>
			<a href="<?=base_url('user/preferences')?>" class="color-pro"><?=lan('TO_COMPLETE').' '.lan('SIGNUP_H5TITLE1')?></a>
		</div>
	<?php endif; ?>
</div></div>
<?php endif; ?>
<script>
	window.onload = function() { 
		var active=('<?=$active?>')*1;
		if (active==1){
			var profile=("<?=$value['profile']?>")*1,preferences=("<?=$value['preferences']?>")*1;
			// $('.ui-single-box.progress').show();		
			animateprogress("#p-profile",profile);
			animateprogress("#p-preferences",preferences);
		}
	}
	/*@ Barras de progreso HTML5 animadas con Javascript
    @ author Agustín Baraza (contacto@nosolocss.com)
    @ Copyright 2014 nosolocss.com. All rights reserved
    @ http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
    @ link http://www.nosolocss.com 	*/
function animateprogress (id, val){
	var getRequestAnimationFrame = function () { 
		return window.requestAnimationFrame ||
		window.webkitRequestAnimationFrame ||   
		window.mozRequestAnimationFrame ||
		window.oRequestAnimationFrame ||
		window.msRequestAnimationFrame ||
		function ( callback ){
			window.setTimeout(enroute, 1 / 60 * 1000);
		};
	};
	var fpAnimationFrame = getRequestAnimationFrame();   
	var i = 0;
	var animacion = function () {		
		if (i<=val){
			document.querySelector(id).setAttribute("value",i);     
			document.querySelector(id+"+ span").innerHTML = i+"%";    
			i++;
			fpAnimationFrame(animacion);          
		}									
	}
	fpAnimationFrame(animacion);
}
</script>
<?php } ?>
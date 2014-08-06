<?php
//obtemgo el nombre de usuario
$epro = $_SERVER['REQUEST_URI'];
$userp = explode("/", $epro);

?>
<div class="fleft loader"><loader class="page" style="display:none;"></loader></div>
<div class="logoTbum"></div>
<menu class="fright">
	<div class="_tt">
		<div class="_tc">
			<div id="titleNormal">
				<a href="#WhatIsIt" class="prinTitle prinTitleActive" id="1"><?=LANDING_WHATITIS?></a>
				<a href="#HowDoesWork" class="prinTitle" id="2"><?=LANDING_HOWDOESIT?></a>
				<a href="#App" class="prinTitle" id="3"><?=LANDING_APPDOWN?></a>
				<a class="prinTitle iconLogin" id="login" style="padding-right: 20px;margin-right: 5px;"><?=LANDING_LOGIN?></a>
			</div>
		</div>
	</div>
</menu>
<?php 
	$languages = CON::query("SELECT cod,id, name FROM languages");
?>
<div class="langOut">

	<form method="post" action="." id="formLang">
		<input name="lang" type="hidden" value="<?=$language['cod']?>" />
	</form>
	<select name="languajeOut" id="languajeOut" >
		<option value="none" selected><?=FOOTMENU_LANGUAGES?></option>
		<?php while ($language = CON::fetchObject($languages)) { ?>
			<option value="<?=$language->cod?>">
				<?=$language->name?>
			</option>
		<?php } ?>
	</select>
</div>
<div class="dnone" id="logindialog"><?php include 'templates/login.box.php'; ?></div>
<?php 

?>
<script>
	$(function(){

		var vec = '';
		<?php $detect=new Mobile_Detect();
		if($detect->isMobile()){
		?> 
			vec = {disableSearch:true,width:86,top:9,left:-5};
			console.log('si es')
		<?php	
		}else{
		?>
			vec = {disableSearch:true,width:110,top:9};
			console.log('no es')
		<?php	
		}
		?>
		$('select').chosen(vec);
		var menu='#titleNormal a';
		$('page>header menu').on('click',menu,function(){
			//console.log('esta ahora en: '+this.id);
			$(menu).removeClass('prinTitleActive');
			$(this).addClass('prinTitleActive');
		});
		$('page').on('click','a#login',function(){
			$('#logindialog').dialog({
				title: 'Login',
				resizable: false,
				width:360,
				modal: true,
				show: 'fade',
				hide: 'fade',
				close:function() {
					$(this).dialog('close');
				}
			});
		});
		$('#languajeOut').on('change',function(){
			//console.log('lang: '+this.value);
			if(this.value!=='none'){
				$('#formLang input').val(this.value);
				$('#formLang').submit();
			}
		});
		
		$(window).hashchange(function(){
			//alert(document.location.hash);
			var hash = document.location.hash.split('/')[0];
			
			if((hash=='#')||(hash=='')||(hash=='#WhatIsIt')){
				if ('<?=$userp[1]?>'!=''){
					$('.logoTbum').fadeIn('slow');
				}else{
					$('.logoTbum').fadeOut('slow');
				}
			}else{
				$('.logoTbum').fadeIn('slow');
			}
			
			if((hash=='#')||(hash=='')){
				hash = '#WhatIsIt';
			}
			$(menu).removeClass('prinTitleActive');
			$(menu).filter('[href="'+hash+'"]').addClass('prinTitleActive');
		});
	});
</script>

<?php
//obtemgo el nombre de usuario
$epro = $_SERVER['REQUEST_URI'];
$userp = explode("/", $epro);

$languages=CON::getObject('SELECT cod,name FROM languages');
?>
<div class="fleft loader"><loader class="page" style="display:none;"></loader></div>
<menu class="fleft">
	<div class="_tt">
		<div class="_tc">
			<div id="titleNormal">
				<a href="#WhatIsIt" class="prinTitle <?php if ($_GET['referee']==''){ ?> prinTitleActive <?php } ?> " id="1"><?=LANDING_WHATITIS?></a>
				<a href="#HowDoesWork" class="prinTitle" id="2"><?=LANDING_HOWDOESIT?></a>
				<a href="#App" class="prinTitle" id="3"><?=LANDING_APPDOWN?></a>
				<a class="prinTitle" id="login"><span class=" iconLogin"></span><?=LANDING_LOGIN?></a>
				<form method="post" action="//<?=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>">
					<select name="lang" id="lang_list" onchange="this.form.submit();">
						<option value="none" selected><?=FOOTMENU_LANGUAGES?></option>
						<?php foreach($languages as $_lan){ ?>
							<option value="<?=$_lan->cod?>"><?=$_lan->name?></option>
						<?php } ?>
					</select>
				</form>
			</div>
		</div>
	</div>
</menu>
<div class="dnone" id="logindialog"><?php include 'templates/login.box.php'; ?></div>
<script>
	$(function(){
		$('#lang_list').chosen({disableSearch:true, width:100});
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
				close:function(){
					$(this).dialog('close');
				}
			});
		});
		$(window).hashchange(function(){
			//alert(document.location.hash);
			var hash = document.location.hash.split('/')[0];
			if((hash=='#')||(hash=='')){
				hash = '#WhatIsIt';
			}
			$(menu).removeClass('prinTitleActive');
			<?php if ($_GET['referee']==''){ ?>
			$(menu).filter('[href="'+hash+'"]').addClass('prinTitleActive');
			<?php } ?>
		});
	});
</script>

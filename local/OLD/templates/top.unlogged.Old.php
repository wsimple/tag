<!--<div class="fleft loader"><loader class="page" style="display:none;"></loader></div>-->
<menu class="fright"><div class="_tt"><div class="_tc">
	<strong id="signup_menu"></strong>
	<div id="titleTag" style="display: none">
		<strong><a href="#signup"><?=SIGNUP_BTNNEXT?></a></strong>&nbsp;&nbsp;&nbsp;<strong><a href="#"><?=MNUUSER_TITLEHOME?></a></strong>
	</div>
	<div id="titleNormal">
		<div class="prinTitle prinTitleActive" id="1">what is it</div>
		<div class="prinTitle" id="2">how does it work</div>
		<div class="prinTitle" id="5">app download</div>
		<div class="prinTitle iconLogin" id="6">login</div>
	</div>
</div></div></menu>
<div class="dnone" id="logindialog"><?php include 'templates/login.box.php'; ?></div>
<script>
	$(function(){
				$('body').css('background','#fff');
				$('body').on('click','.slides-pagination a',function(){
					
					var href=$(this).attr('href');
					console.log(href);
					$('#titleNormal div').removeClass('prinTitleActive');

					var el=$('#titleNormal div');

					switch(href){
						case '#2':case '#3':case '#4': 
							console.log('sec2');
							$(el[1]).addClass('prinTitleActive');
							$('container#home').css('background-image','');

						break;
						case '#5': //insert
							console.log('sec5');
							$(el[2]).addClass('prinTitleActive');
							$('container#home').css('background','');
						break;
						case '#1': //insert
							console.log('sec1');
							$(el[0]).addClass('prinTitleActive');
							$('container#home').css('background-image','url("css/tbum/home_what_is_it.png")');
						break;
					}						
				});
				
				$('#titleNormal div').on('click',function(){
					if($('container#home').length>0){
				
						console.log(this.id);
						console.log($('nav.slides-pagination a[href="#'+this.id+'"]').length);
						$('nav.slides-pagination a[href="#'+this.id+'"]').click();

						if(this.id=='6'){
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
						}
						console.log('elementos');
					}else{
						console.log('registro');
						document.location.hash='#home';
					}
				});							
	});
</script>

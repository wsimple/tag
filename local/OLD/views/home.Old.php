<container id="home" class="cache">
	<content class="home2">
		<div id="slides">
			<div class="slides-container">
				<div>
					<img src="css/tbum/tbum.png" width="1024" id="sec1">
				</div>
				<div>
					<img src="css/tbum/sec1.png" width="1024" id="sec2">
				</div>
				<div>
					<img src="css/tbum/sec2.png" width="1024" id="sec3">
				</div>
				<div>
					<img src="css/tbum/sec3.png" width="1024" id="sec4">
				</div>
				<div>
					<img src="css/tbum/sec3_bgn3.png" width="1024" id="sec5">
				</div>
			</div>
			<nav class="slides-navigation">
			  <a href="#" class="next"><img src="css/tbum/orange_arrow_right.png" width="40" height="40"></a>
			  <a href="#" class="prev"><img src="css/tbum/orange_arrow_left.png" width="40" height="40"></a>
			</nav>
		</div>
	</content>
	<div class="homeFooter">
		<div id="joinus"></div>
	</div>
	<div class="clearfix"></div>
	
</container>
<script>
	$(function(){
		$('container#home').css('background',"url('css/tbum/home_what_is_it.png')");
		
		$('#slides').superslides({
			 inherit_width_from: 'content'
		});
		$('#joinus').click(function(){
			redirect('#signup');
		})
		
		$('.next').click(function(e){
			
			$('#titleNormal div').removeClass('prinTitleActive');
			var el=$('#titleNormal div');
			
			var sec = $('.slides-container img:visible')[0].id;
			switch(sec){
				case 'sec1':case 'sec2':case 'sec3': 
					console.log('sec2');
					$(el[1]).addClass('prinTitleActive');
				
					$('container#home').css('background-image','');
				
				break;
				case 'sec4': //insert
					console.log('sec5');
					$(el[2]).addClass('prinTitleActive');
					$('container#home').css('background','');
				break;
				case 'sec5': //insert
//					console.log('sec1');
//					$(el[0]).addClass('prinTitleActive');
//					$('container#home').css('background-image','url("css/tbum/home_what_is_it.png")');
					e.preventDefault();
					$('#logindialog').dialog({
								title: 'Login',
								resizable: false,
								width:360,
								modal: true,
								show: 'fade',
								hide: 'fade',
								close:function() {
										$(this).dialog('close');
										$('#titleNormal div').removeClass('prinTitleActive');
										$(el[2]).addClass('prinTitleActive');
									}
							});
					$(el[3]).addClass('prinTitleActive');
					return false;
				break;
			}
		});
		
		$('.prev').click(function(){
			//console.log('estaba '+$('.slides-container img:visible')[0].id);
			
			$('#titleNormal div').removeClass('prinTitleActive');
			var el=$('#titleNormal div');
			
			var sece = $('.slides-container img:visible')[0].id;
			switch(sece){
				case 'sec1': //insert
//					console.log('sec5');
//					$(el[2]).addClass('prinTitleActive');
//					$('container#home').css('background','');
					$('#logindialog').dialog({
								title: 'Login',
								resizable: false,
								width:360,
								modal: true,
								show: 'fade',
								hide: 'fade',								
								close:function() {
										$(this).dialog('close');
										$('#titleNormal div').removeClass('prinTitleActive');
										$(el[0]).addClass('prinTitleActive');
									}
							});
					$(el[3]).addClass('prinTitleActive');
					return false;
				break;
				case 'sec2': //insert
					console.log('sec1');
					$(el[0]).addClass('prinTitleActive');
					$('container#home').css('background-image','url("css/tbum/home_what_is_it.png")');
				break;
				case 'sec3':case 'sec4':case 'sec5': //insert
					console.log('sec2');
					$(el[1]).addClass('prinTitleActive');
					$('container#home').css('background','');
				
				break;
			}
		});
		
		
	});
</script>
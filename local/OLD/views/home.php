<container id="home" class="cache">
	<content class="home">
		<div class="e1">
			<div class="color-d topBanner"><?php include('templates/banner.box.php'); ?></div>
			<script>$(function(){ $$('.tag-container').addClass('noMenu'); });</script>
			<?php include 'templates/tags/carousel.php'; ?>
		</div>
		<div class="e e2 ui-box-outline right">
			<div class="ui-box">
				<?php include 'views/main/login.box.php'; ?>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="e e3 ui-box-outline" style="width:235px;float:left;">
			<div class="ui-box">
				<div id="whatsInForMe" class="color-c">
					<?php $whatsForMe = explode('*', HOME_WHATSINITFORME); ?>
					<p><strong><?=$whatsForMe[0]?></strong></p>
					<p><strong><?=$whatsForMe[1]?></strong><?=$whatsForMe[2]?></p>
					<p><?=$whatsForMe[3]?></p>
					<p><?=$whatsForMe[4]?></p>
					<p>
						<?=$whatsForMe[5]?>
						<span class="color-a whatsInForMe_orange"><?=$whatsForMe[6]?></span>
					</p>
				</div>
			</div>
		</div>
		<div class="e e4 font-b cond">
			<img src="css/smt/home/phones_app_icon.png" width="232" height="213" border="0"/>
			<?php $dwnOurApp = explode('*', HOME_DOWNLOADOURAPP); ?>
			<h1><?=$dwnOurApp[0]?><div class="color-d bold"><?=$dwnOurApp[1]?></div></h1>
			<h2><?=$dwnOurApp[2]?><span class="color-d"><?=$dwnOurApp[3]?></span><?=$dwnOurApp[4]?><span class="color-d"><?=$dwnOurApp[5]?></span></h2>
			<h4><?=$dwnOurApp[6]?>
				<span class="color-a"><?=$dwnOurApp[7]?></span><?=$dwnOurApp[8]?>
				<?php if($_SESSION['ws-tags']['language']!="en"){?><br><?php } ?><span class="spaceSpanish"><?=$dwnOurApp[9]?></span>
				<div class="home_click_orange"><?=$dwnOurApp[10]?></div><?=$dwnOurApp[11]?>
			</h4>
			<div class="icon_app_store" style=" left: 550px; top: 120px;">
				<a href="https://itunes.apple.com/us/app/semytag/id658430038?ls=1&mt=8" target="_blank"><div class="divItunes"></div></a>
				<a href="https://play.google.com/store/apps/details?id=org.app.seemytag" target="_blank"><div class="divGoogleplay"></div></a>
			</div>
		</div>
		<div class="clearfix"></div>
	</content>
	<script>
		$(function(){
			//console.log($("button, input:submit, input:reset, input:button"));
//			$('button, input:submit, input:reset, input:button','page#smt container').button();
			//placeholder
			$('input[placeholder]').placeholder({ color: '#ccc', height:'20px' });
			//cargando tags
			$$.ajax({
				type	: 'GET',
				dataType: 'json',
				url		: 'controls/tags/tagsList.json.php?current=wpanel&limit=15',
				success	: function(data){
					if(data['tags']&&data['tags'].length>0){
//						$('.tag-container').html(showTags(data['tags'],false,false));
						showCarousel(data['tags'],$('page .tag-container'));
					}
				}
			});
			$('#carousel-box').height(300);
		});
	</script>
</container>
<?php if($notAjax){?>
<script>
	$('container').data('id','home');
</script>
<?php }?>

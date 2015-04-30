<?php
if($logged){
	$idPage='timeline';
	$section='timeline';
	$numPanels=3;
	$bodyPage='tags/tagsList.php';
}else{ ?>
<container id="home" class="cache">
	<content class="home2">
		<div id="superContainer">
			<div class="section active" id="section0">
				<img src="css/tbum/tbum.png" width="1024" id="sec1">
				<div class="textHome">
					<?=ucfirst(LANDING_WHAT_SOCIALMEDIA)?>
					<?php if($_SESSION['ws-tags']['language']=='en'){?>
						<br><span class="bold"><?=LANDING_WHAT_REDEEM?></span>
					<?php } ?>
				</div>
			</div>
			<div class="section" id="section1">
				<div class="slide active" style="position:relative;">
					<div class="wrap">
						<div class="textPage1"><?=ucfirst(LANDING_HOW_CREATE)?><br><?=LANDING_HOW_PERBUSI?></div>
						<img src="css/tbum/sec1.png" width="1024">
					</div>
				</div>
				<div class="slide" style="position:relative;">
					<div class="textPage2"><?=ucfirst(LANDING_HOW_CREATETAG)?></div>
					<img src="css/tbum/sec2.png" width="1024">
					<div class="textPage3"><?=ucfirst(LANDING_HOW_ADDPOINTS)?>,<br><?=LANDING_HOW_CREATEPUBLISH?><br><?=LANDING_HOW_ANDMORE?>.</div>
				</div>
				<div class="slide" style="position:relative;">
					<div class="textPage4"><?=ucfirst(LANDING_HOW_TAGSTORE)?><br><?=LANDING_HOW_PRODUCTS?><br><?=LANDING_HOW_MYORDERS?><br><?=LANDING_HOW_BUYPOINTS?></div>
					<img src="css/tbum/sec3.png" width="1024">
					<div class="textPage5"><?=ucfirst(LANDING_HOW_LIKEWANT)?><br><?=LANDING_HOW_YOUNEED?><br><?=LANDING_HOW_ALLJUST?></div>
				</div>
			</div>
			<div class="section" id="section2">
				<div class="textPage6"><?=ucfirst(LANDING_APP_FORWEB)?><br>www.tagbum.com</div>
				<img src="css/tbum/sec3_bgn3.png" width="1024">
				<div class="textPage7"><?=ucfirst(LANDING_APP_FORIPHONEIPAD)?><br><?=LANDING_APP_FORIPODTOUCH?><br><?=LANDING_APP_ITUNES?></div>
				
				<div class="appLinks">
					<div id="titleApp"><?php echo ucfirst(LANDING_APP_LINKDOWNLOAD); ?></div>
					<div >
						<a href="https://itunes.apple.com/us/app/tagbum/id938965981?mt=8" target="blank" >
							<img src="<?=DOMINIO?>css/tbum/icon_appStore.svg" id="iTunes" alt="">
						</a>
						<a href="https://play.google.com/store/apps/details?id=com.tagbum.tagbum" target="blank">
							<img src="<?=DOMINIO?>css/tbum/icon_googlePlay.svg" id="gPlay" alt="">
						</a>
					</div>
				</div>
			</div>
		</div>
	</content>
</container>
<script>
	$(function(){
		var $co=$(container),
			$c=$('content',container);
		$co.data('id',container.id);
		$.on({
			open:function(){
				$.hashExceptions = ['WhatIsIt', 'HowDoesWork', 'App'];
				$('footer').show();
				$c.fullpage({
					anchors: $.hashExceptions
				});
				setTimeout(function(){
					$(window).trigger('hashchange.fullPage',true);
				},300);
			},
			close:function(){
				$c.fullpage('remove');
				$.hashExceptions = null;
			}
		});
		//$co.css({'background':"#fff url('css/tbum/tbum.png') no-repeat",'background-size':'100%'});
		$('#joinus').click(function(){
			redirect('#signup');
		});
		$(window).hashchange(function(){
			var hash = document.location.hash,
				$scroll=$('#keepscroll');
				switch(hash){
					case '#WhatIsIt':
						//$co.css('background-image','url("css/tbum/tbum.png")');
						$scroll.css('background-image',"url('css/tbum/footerkeep.png')");
					break;
					case '#HowDoesWork':
						$co.css('background-image','');
						$scroll.fadeIn('slow').css('background-image',"url('css/tbum/footerkeep.png')");
					break;
					case '#App':
						$co.css('background-image','');
						$scroll.css({
							'background-image':"url('css/tbum/footerkeepup.png')",
							'display':'inline-block'
						});
					break;
				}
		});
	});
</script>
<?php } ?>
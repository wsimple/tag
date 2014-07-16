<?php
if($logged){
	$idPage='timeline';
	$currentPage='main/wrapper.php';
	$numPanels=3;
	$bodyPage='tags/tagsList.php';
	include('views/'.$currentPage);
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
					<div id="titleApp"><?=LANDING_APP_LINKDOWNLOAD?></div>
					<div>
						<a href="https://itunes.apple.com/sv/app/seemytag/id658430038?mt=8" target="blank"><div id="iTunes"></div></a>
						<a href="https://play.google.com/store/apps/details?id=org.app.seemytag&hl=es_419" target="blank"><div id="gPlay"></div></a>
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
				$.hashExceptions = ['whatIsIt', 'howDoesWork', 'app'];
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
					case '#whatIsIt':
						//$co.css('background-image','url("css/tbum/tbum.png")');
						$scroll.css('background-image',"url('css/tbum/footerkeep.png')");
					break;
					case '#howDoesWork':
						$co.css('background-image','');
						$scroll.fadeIn('slow').css('background-image',"url('css/tbum/footerkeep.png')");
					break;
					case '#app':
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
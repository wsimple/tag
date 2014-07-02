<footer class="ui-single-box">
<?php
	if(!$logged){
	?>
	<div>
		<div id="joinus">
			<div id="text"><?=LANDING_FOOTER_JOINUS?> <span><?=LANDING_FOOTER_TOODAY?></span></div>
		</div>
		<div id="keepscroll">
			<div id="text"><?=LANDING_FOOTER_KEEP?> <span><?=LANDING_FOOTER_SCROLLING?></span></div>
		</div>
	</div>
		
	<?php
	}else{
	?>
		<div>
			<a href="#about">About</a>&nbsp;-&nbsp; 
			<a href="<?=HREF_DEFAULT?>" action="tourActive"><?=HELP?></a>&nbsp;-&nbsp;
			<!-- <a href="#blog">Blog</a>&nbsp;-&nbsp; -->
			<a href="#terms"><?=TERMSOFUSE?></a>&nbsp;-&nbsp;
			<a href="#privacity"><?=PRIVACY?></a>&nbsp;-&nbsp;
			<a href="#cookies">Cookies</a>
		</div>
		<div class="copy" align="center">
			<?=COPYFOOTER?>
		</div>
	<?php
	}
?>	
</footer>
<script>
	
$(function(){
			$('#keepscroll').click(function(){
			var keep = document.location.hash;
			console.log(keep);
			switch(keep){
				case '#whatIsIt': case '#': case '':
					document.location.hash = '#howDoesWork';
				break;
				case '#howDoesWork':case '#howDoesWork/1':case '#howDoesWork/2':
					document.location.hash = '#app';
				break;
				case '#app':
					document.location.hash = '#whatIsIt';
				break;
			}
		});
});
</script>
<?php $control->flush_echo(); ?>
</wrapper>

<footer class="ui-single-box">
<?php if(!$client->is_logged&&$location->section=='home'){ ?>
	<div>
		<div id="joinus">
			<div id="text"><?=$lang->get('LANDING_FOOTER_JOINUS')?> <span><?=$lang->get('LANDING_FOOTER_TOODAY')?></span></div>
		</div>
		<div id="keepscroll">
			<div id="text"><?=$lang->get('LANDING_FOOTER_KEEP')?> <span><?=$lang->get('LANDING_FOOTER_SCROLLING')?></span></div>
		</div>
	</div>
	<script type="text/javascript">
	$(function(){
		$('#keepscroll').click(function(){
			var keep = document.location.hash;
			$.debug().log('keepscroll',keep);
			switch(keep){
				case '#WhatIsIt':case '#':case '':
					document.location.hash='#HowDoesWork';
				break;
				case '#HowDoesWork':case '#HowDoesWork/1':case '#HowDoesWork/2':
					document.location.hash='#App';
				break;
				case '#App':
					document.location.hash='#WhatIsIt';
				break;
			}
		});
	});
	</script>
<?php }else{ ?>
	<div>
		<a href="about"><?=$lang->get('About')?></a>&nbsp;-&nbsp; 
		<span id="tHf" style="display:none;"><a href="javascript:void(0)" action="tourActive"><?=$lang->get('HELP')?></a>&nbsp;-&nbsp;</span>
		<!-- <a href="blog"><?=$lang->get('Blog')?></a>&nbsp;-&nbsp; -->
		<a href="terms"><?=$lang->get('Terms')?></a>&nbsp;-&nbsp;
		<a href="privacity"><?=$lang->get('PRIVACY')?></a>&nbsp;-&nbsp;
		<a href="cookies">Cookies</a>
	</div>
	<div class="copy" align="center"><?=$lang->get('COPYFOOTER')?></div>
	<script>
	$.ajax({
		type	: 'GET',
		url		: 'controls/tour/tourHelp.json.php?section=<?=$location->section?>',
		dataType: 'json',
		success	: function (data){
			$('#tHf')[data=='no'?'remove':'show']();
		}
	});
	</script>
<?php } ?>
</footer>
</page>
</body>
</html>

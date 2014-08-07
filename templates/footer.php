<footer class="ui-single-box">
<?php
	global $section;
	// if(!$logged&&($section!='tag'&&$section!='home')){
	if(!$logged&&$section=='home'){
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
			<a href="<?php echo base_url('about'); ?>">About</a>&nbsp;-&nbsp; 
			<a id="tHf" href="<?=HREF_DEFAULT?>" action="tourActive"><?=HELP?></a><span id="tHfs">&nbsp;-&nbsp;</span>
			<!-- <a href="<?=base_url('blog')?>">Blog</a>&nbsp;-&nbsp; -->
			<a href="<?php echo base_url('terms'); ?>"><?=TERMSOFUSE?></a>&nbsp;-&nbsp;
			<a href="<?php echo base_url('privacity') ?>"><?=PRIVACY?></a>&nbsp;-&nbsp;
			<a href="<?php echo base_url('cookies')?>">Cookies</a>
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

	$$.ajax({
			type	: 'GET',
			url		: 'controls/tour/tourHelp.json.php?section='+SECTION,
			dataType: 'json',
			success	: function (data){
			    // console.log(data);
				if (data=='no') {
					$('#tHf,#tHfs').hide();	
				};
			}
		});


});
</script>

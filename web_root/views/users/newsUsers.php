<?php if($logged){ ?>
	<!--div id="adsListPubliNew">
		<a href="<?=base_url('creation')?>">
			<div class="btnCreatetag" id="btnCreatetag"></div>
		</a>
	</div-->
	<?php
	include ('views/rightside/suggestRight.php');
	(isset($_REQUEST['ActTypePubli']))? $type = 1: $type = 2;
	$typePublicity = $type;
	$limit_p = 5; //limite de registro por consulta
	include ('views/publicity/publicity.php');
?>
<script type="text/javascript">
	$(function() {
		if((document.location.hash=="#friends?sc=1")||(document.location.hash=="#friends?sc=2")||(document.location.hash=="#friends?sc=3")){
			$('#title-news-suggest').hide();
		}
	});
</script>
<?php } ?>
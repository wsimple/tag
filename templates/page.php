<page id="smt"<?=$logged?'':' class="unlogged"'?>>
	<?php include('templates/header.php'); ?>
	<wrapper>
		<?php
			if(!$logged && $_GET['tag']==''){
				include('views/main/home.php');
			}else{
				global $section,$notAjax;
				if($notAjax){
					if($section){
						$idPage=$section;
						include('view.php');
					}
				}else{
					echo '<container><content></content></container>';
				}
			}
		?>
	</wrapper>
	<?php include('templates/footer.php'); ?>
</page>
<script type="text/javascript">
	beforeInit();
	$(function(){
		pageInit();
		<?=isset($_GET['noconsole'])?'disableLogs();':''?>
		<?=isset($_GET['console'])?'enableLogs();':''?>
		if($.cookie('hash')){
			document.location.hash=$.cookie('hash');
			$.cookie('hash',null);
		}else{
			var h=document.location.hash;
			if(isLogged()||(h!='#home'&&h!='#main')) $(window).hashchange();
		}
		<?=isset($_SESSION['ws-tags']['wpAddTag'])?'redir("#creation")':''?>
		
		if(document.location.hash=='#signup'){
			$('page').css('padding-bottom','0');
		}else{
			$('page').css('padding-bottom','30px');
		}
		
	});
</script>

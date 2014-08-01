<?php
if(strpos($bodyPage,'.2.php')) $numPanels=2;
if(strpos($bodyPage,'.3.php')) $numPanels=3;
#output buffering
ob_start();
@include('views/'.$bodyPage);
$content=ob_get_contents();
ob_end_clean();
#end output buffering
if($logged){
	if($numPanels>2&&!$rightPanel) $rightPanel='users/newsUsers.php';
?>
<container id="<?=$idPage?>" class="wrapper<?=$cache?' cache':''?>" data-section="<?=$section?>">
	<content class="num-pannels-<?=$numPanels?> clearfix">
		<?php if($numPanels>1){ ?>
			<div class="left-panel">
				<?php include('templates/leftBar.php'); ?>
				<div class="clearfix"></div>
			</div>
		<?php } ?>
		<div class="mid-pannel" data-view="<?=$bodyPage?>">
			<?php if($numPanels==3&&$logged){?>
				<div class="ui-single-box topBanner"><?php include('templates/banner.box.php'); ?></div>
			<?php }
				if($content) echo $content;
				else @include('views/'.$bodyPage);
			?>
		</div>
		<?php if($numPanels==3){ ?>
			<div class="right-panel"><?php include('views/'.$rightPanel); ?></div>
		<?php } ?>
	</content>
</container>
<?php
}else{
	echo $content;
}

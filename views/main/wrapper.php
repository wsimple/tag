<?php if($logged){ ?>
<container id="<?=$idPage?>" class="wrapper<?=$cache?' cache':''?>">
	<content class="num-pannels-<?=$numPanels?>">
		<?php if($numPanels>1){ ?>
			<div class="left-panel">
				<?php include('templates/leftBar.php'); ?>
				<div class="clearfix"></div>
			</div>
		<?php } ?>
		<div class="mid-pannel">
			<?php if($numPanels==3&&$logged){?>
				<div class="ui-single-box topBanner"><?php include('templates/banner.box.php'); ?></div>
			<?php }?>
			<?php include ('views/'.$bodyPage); ?>
		</div>
		<?php if($numPanels==3){ ?>
			<div class="right-panel"><?php include ('views/'.$rightPanel); ?></div>
		<?php } ?>
		<div class="clearfix"></div>
	</content>
</container>
<?php }else{ ?>
<container id="<?=$idPage?>" class="wrapper<?=$cache?' cache':''?>">
	<content>
		<?php include('views/'.$bodyPage); ?>
		<div class="clearfix"></div>
	</content>
</container>
<?php } ?>

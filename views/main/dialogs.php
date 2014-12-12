<?php
$sc = ( isset($idPage) ) ? $idPage : $title[0];
$query = 'SELECT '.$sc.' AS dato FROM dialogs WHERE id = 1';

?>
<container id="<?=$idPage?>" class="bg dialog">
	<content class="ui-box-outline" style="display: block;">
		<div class="ui-box" id="dialog-<?=$idPage?>" style="min-height: 500px;">
			<h3 class="ui-single-box-title color-a"><?=ucwords($idPage)?>
			<?php
				if(isset($_GET[sign])){
				?>
				<a href="<?=base_url('signup')?>" class="fright" style="margin-right: 5px"><?=DIALOGS_BACKSIGNUP?></a>
				<?php } ?>
			</h3>
			<?php
			$rs = $GLOBALS['cn']->query( $query );
			if ( $row = mysql_fetch_assoc( $rs ) ){
				if (lan( $row['dato'] ) != NULL ) echo lan($row['dato']);
				else echo DIALOG_NOTFOUND;
			}else{
				echo INDEX_DIALOGSORRYUNDER;
			}
			?>
		</div>
	</content>
</container>
<script>
	$(document).ready(function() {
		$('html, body').animate({scrollTop: 0},"slow");
	});
</script>

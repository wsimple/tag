<?php if ($logged) {
$points = mskPoints(campo("users", "id", $_SESSION['ws-tags']['ws-user'][id], "current_points"));
?>
<div class="points_box">
	<div class="acumulate_box font-b cond">
		<div class="number" id="mskPoints"><?=$points?></div>
		<div class="text"><?=MNUUSER_LABELPOINTER?></div>
	</div>
	<div class="menu_box">
		<a action="redeemPoinst"><?=MNUUSER_REDEEMPOINTS?></a>
		<a action="increasePoints"><?=MNUUSER_INCREASEOINTS?></a>
	</div>
    <div class="clearfix"></div>
</div>
<div class="menus"><?php include ('templates/menu/left.php'); ?></div>

<?php }?>
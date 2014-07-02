<header>
<content>
	<!--<a href="."><logo></logo></a>-->
	<?php
		if(!$logged){
			include('templates/menu/top.unlogged.php');
		}else{
			echo '<a href="."><logo></logo></a>';
			include('templates/menu/top.logged.php');
		}
	?>
</content>
<!--<dialog class="alerts">
	<content>
		<icon></icon>
		<span></span>
	</content>
</dialog>-->
</header>

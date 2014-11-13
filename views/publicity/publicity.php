<article id="adsListPublicity" class="side-box imagenPub">
	<header><span><?=$lang["USERPUBLICITY_ABSINDEX"]?></span></header>
	<?php  //$borde = ($i==4)?'style="border-bottom:0"':''
	$prefe=users_publicity(5,'',$typePublicity);
	if (count($prefe)>0)
		foreach ($prefe as $key) {
			$messagePubli=(strlen($key['message'])>90)? substr($key['message'], 0,90)."..." : $key['message'];
	?>
		<div id="bordePublicity" <?=$borde?>>
			<a href="<?=$key['link']?>" target="_blank" onclick="showPublicityWb('<?=$key['id']?>')" onfocus="this.blur()">
				<div id="imgPublicity">
				<img src="<?='.?resizeimg&ancho=70&tipo=3&img='.$key['picture']?>"/>
				</div>
			</a>
			<div id="namePublicity">
				  <strong><div style="text-align: left"><a href="<?=$key['link']?>" target="_blank" onclick="showPublicityWb('<?=$key['id']?>')" onfocus="this.blur()"><?=$key['title']?></a></div></strong>
				  <br />
				  <?=$messagePubli?>
			</div>
			<div class="linkPubliseemore"><a href="<?=$key['link']?>" target="_blank" onclick="showPublicityWb('<?=$key['id']?>')" onfocus="this.blur()"><?=USER_BTNSEEMORE?>...</a></div>
		</div>
	<?php }
	else{ ?>
		<img src="imgs/banner_publicity_mini.png" style="-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; border: 1px solid #ddd; margin: 0 0 10px 14px;" />
	<?php }	?>
	<div class="clearfix"></div>
</div>
</article>

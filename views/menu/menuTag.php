<?php
	if ($_SESSION['ws-tags']['ws-user'][id]!=''){
		$eventos = '';
		if ($_GET['current']==''){ //if estamos en el carrusel
		$eventos = 'onmousemove="pauseCarousels(\'#tagLineFavorites\', \'stop\', true);" onmouseout="pauseCarousels(\'#tagLineFavorites\', \'play\', true);"';
	}
?>
<!--
	 ul = menu de opciones
	 li = submenu de opciones
-->
<ul id="menuTag" class="menuTag" style="z-index:1000;">

    <?php
	
	
		//IF COMES FROM menuBusinessCard, THIS IS FOR SELECTING THE RIGHT IMAGE
		if (isset ($_GET['select'])) { 
			$result = $GLOBALS['cn']->query('SELECT status FROM tags WHERE id="'.$time[idTag].'" AND id_business_card !="" ');
			$make = (mysql_num_rows($result) > 0) ? 'd' : 'makeD';
	?>

				<li id="selected_tag_<?=md5($time[idTag])?>" onclick="actionsBusinessCard(3, '<?=md5($time[idTag]).'|'.$_GET['select']?>');" <?=$eventos?> title="<?=$make=='d' ? 'Unl' : 'L' ?>ink" style="margin-right: 20px; margin-left: 20px">
					<img src="img/menu_businessCard/<?=$make?>efault.png"/>
				</li>

				<li id="bc_tag_<?=md5($time[idTag])?>" title="<?=USERPROFILE_BUSINESSCARD?>">
					<?php // button business card
					$result = $GLOBALS['cn']->query('SELECT id_business_card FROM tags WHERE id="'.$time[idTag].'" AND id_business_card!=""');
					if (mysql_num_rows( $result ) > 0) {
						$result= mysql_fetch_assoc($result); ?>
							<img src="img/menu_tag/business_card.png" border="0" onclick="message('messages', '<?=str_replace(chr(13), " ",str_replace(chr(10), " ", USERPROFILE_TITLEBUSINESSCARD))?>', '', '',  430, 300, 'views/business_card/businessCard_dialog.view.php?bc=<?=md5($result[id_business_card])?>');" />
						<?php
					} else { ?>

						<img src="img/menu_tag/no_business_card.png" border="0"/>
						<?php
					}
					?>
				</li>
    <?php
		
	 }else {
	
				$result = $GLOBALS['cn']->query('SELECT id_business_card FROM tags WHERE id="'.$time[idTag].'" AND id_business_card!=""');
				//HAS A LINKED BUSINESS CARD
				if (mysql_num_rows( $result ) > 0) {
					$result= mysql_fetch_assoc($result);
		?>
					<li onclick="message('messages', '<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', USERPROFILE_TITLEBUSINESSCARD))?>', '', '',  430, 300, 'views/business_card/businessCard_dialog.view.php?bc=<?=md5($result['id_business_card'])?>');" title="<?=USERPROFILE_BUSINESSCARD?>">
					<img src="img/menu_tag/business_card.png" border="0"/>
					</li>
	
		<?php }
	
			  if ($_GET['current']!='privateTags'&&$_GET['current']!='groups'&& $time[status]!=4){ //redistribuir ?>
	
			  <li onclick="actionsTags(3,  '<?=(($_GET['current']!="")?$time[idTag].'|0':'current_tag|1')?>', 'controls/tags/actionsTags.controls.php',	'<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLEREDISTRIBUTION))?>|<?=$_GET["current"]?>');"	<?=$eventos?> title="<?=MNUTAG_TITLEREDISTRIBUTION?>" >	<img src="img/menu_tag/re-distribuir.png" border="0" />	</li>
	
		<?php }//Like ?>
	
			  <li onclick="actionsTags(4,  '<?=(($_GET['current']!="")?$time[idTag].'|0':'current_tag|1')?>', 'controls/tags/actionsTags.controls.php',	'<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLEFAVORITE))?>|<?=$_GET["current"]?>|<?=$view_comment?>');"				<?=$eventos?> title="<?=MNUTAG_TITLEFAVORITE?>" >				<img src="img/menu_tag/favorito.png" border="0"  />				</li>
		<?php if($_GET['current']!="comments"&&$_GET['current']!='groups'){?>
	
			  <li onclick="actionsTags(2,  '<?=(($_GET['current']!="")?$time[idTag].'|0':'current_tag|1')?>', 'views/tags/comment.php',	'<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLEMSGCOMMENTS))?>|<?=$_GET["current"]?>');"				<?=$eventos?> title="<?=MNUTAG_TITLEMSGCOMMENTS?>" >				<img src="img/menu_tag/comment.png" border="0"  /></li>
	
		<?php } 
        
              //compartir
              if ($time[status]!=4){
        ?>
                  <li onclick="actionsTags(5,  '<?=(($_GET['current']!="")?$time[idTag].'|0':'current_tag|1')?>', 'views/tags/shareTag.view.php', '<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLESHARE))?>');"	<?=$eventos?> title="<?=MNUTAG_TITLESHARE?>"><img src="img/menu_tag/share.png" border="0" /></li> 
        <?php                        
              }elseif($time[status] == 4 && $_SESSION['ws-tags']['ws-user'][id] == $time[idUser]){
        ?>
                 <li onclick="actionsTags(5,  '<?=(($_GET['current']!="")?$time[idTag].'|0':'current_tag|1')?>', 'views/tags/shareTag.view.php', '<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLESHARE))?>');"	<?=$eventos?> title="<?=MNUTAG_TITLESHARE?>"><img src="img/menu_tag/share.png" border="0" /></li>      
        <?php                                     
              }//if compartir
        
        
			//patrocinar
			if( $time[status]!=4&&$_GET['current']!='groups') { ?>
	
				<li onclick="actionsTags(9, '<?=($_GET['current']?$time[idTag].'|0':'current_tag|1')?>', 'controls/tags/actionsTags.controls.php', '<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLESPONSOR))?>');"
					<?=$eventos?> title="<?=MNUTAG_TITLESPONSOR?>">
	
						<img src="img/menu_tag/patrocinar.png" border="0"/>
				</li>
	
		<?php }
			

              //denunciar
			  if( $time[idCreator]!=$_SESSION['ws-tags']['ws-user'][id]&&$_GET['current']!='groups') { ?>
	
			  <li onclick="actionsTags(8,  '<?=(($_GET['current']!="")?$time[idTag].'|0':'current_tag|1')?>', 'views/tags/reportTags.view.php', '<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLEABUSE))?>|<?=$_GET["current"]?>');" <?=$eventos?> title="<?=MNUTAG_TITLEABUSE?>"><img src="img/menu_tag/denunciar.png" border="0" /></li>
	
		<?php }
	
			  if ($time[idCreator]==$_SESSION['ws-tags']['ws-user'][id] || $time[status]==4){//borrar
	
			  //borrar y editar
		?>
			  <li onclick="actionsTags(6,  '<?=$time[idTag].'|0'?>', 'controls/tags/actionsTags.controls.php', '<?=str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_TITLEREMOVESSSS))?>|<?=$_GET["current"]?>');" <?=$eventos?> title="<?=MNUTAG_TITLEREMOVE?>"><img src="img/menu_tag/trash.png" border="0" /></li>
	
			<?php
	
			  }//else edit
	
			  if ($time[idCreator]==$_SESSION['ws-tags']['ws-user'][id]){//editar
			?>
			  <li onclick="actionsTags(10, '<?=$time[idTag].'|0'?>', 'controls/tags/actionsTags.controls.php', '<?=$_SESSION['ws-tags']['ws-user'][code]."|".str_replace(chr(13), ' ',str_replace(chr(10), ' ', MNUTAG_ERRORNOISMYTAG))."|".str_replace(chr(13), " ",str_replace(chr(10), " ", INDEX_ERRORHUBOHACK))?>');"  <?=$eventos?> title="<?=MNUTAG_TITLEEDIT?>"><img src="img/menu_tag/edit.png" border="0"  /></li>
			<?php  
			  }
	
	 }//else if get[select]
	?>
</ul>
<?php }// if id session user ?>

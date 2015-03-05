<div style="height:33px;z-index:20;float:right;padding-bottom:5px;">
	<ul id="menuBusinessCard" class="menuBusinessCard">
		<?php if(!$listAddToTag){ ?>
			<?php /* Default Business Card */ ?>
			<li id="liDefaultBc_<?=md5($bc[id])?>" onclick="actionsBusinessCard(0, '<?=md5($bc['id'])?>');" title="<?=($bc['type'] ? MENU_NO_DEFAULT : MENU_DEFAULT )?>">
				<img class="imgMakeDefault" style="<?=($bc['type']?'cursor:pointer;':'')?>"
					 src="<?=($bc['type']?'css/menu_businessCard/makeDefault.png':'css/menu_businessCard/default.png')?>"/>
			</li>
			<?php //delete business card ?>
			<li onclick="actionConfirm('<?=BUSINESSCARD_DELETE_CONTENT?>','<?=BUSINESSCARD_DELETE_TITTLE?>','url','<?=md5($bc[id])?>|bc');" title="<?=NEWTAG_HELPDELETEBACKGROUNDTEMPLATE?>"
				style="<?=($bc['type']?'':'display:none;')?>">
				<img style="cursor:pointer;" src="css/menu_businessCard/trash.png"/>
			</li>
			<?php /* Add to an Existing Tag */ ?>
			<li onclick="tagsUser('<?=$_SESSION['ws-tags']['ws-user'][screen_name].' : Tags'?>', '&current=personal&bc_list&edit=0&uid=<?=md5($_SESSION['ws-tags']['ws-user'][id])?>&select=<?=$bc['id']?>');" title="<?=MENU_ADD_TO_TAG?>">
				<img style="cursor:pointer;" src="css/menu_businessCard/addToTag.png"/>
			</li>
			<?php /* Edit Business Card*/ ?>
			<li onclick = "actionsBusinessCard(1,'<?=md5($bc['id'])?>');" title="Edit">
				<img style="cursor:pointer;" src="css/menu_businessCard/edit.png"/>
			</li>
			<?php if( $_SESSION['ws-tags']['ws-user'][pay_personal_tag]=='1' || $_SESSION['ws-tags']['ws-user'][super_user]=='1' || $_SESSION['ws-tags']['ws-user'][type]=='0' ) { ?>
				<?php /* Create a tag to this Business Card */ ?>
				<li onclick="actionsBusinessCard(4, '<?=$bc['id']?>');" title="<?=MENU_CREATE_TAG_TO_BC?>">
					<img style="cursor:pointer;" src="img/menu_users/creation.png"/>
				</li>
			<?php } ?>
		<?php }else{ //if launching BC list
			include("../../includes/config.php");
			include("../../includes/languages.config.php");
		?>
			<li id="bc_tag_<?=md5($bc['id'])?>">
				<img id="makeDefault_<?=$bc['id']?>"
					 src="css/menu_businessCard/makeDefault.png"
					 border="0"
					 title="Link to this BC"
					 style="cursor:pointer;"
					 onclick="	if($('#idBusinessC').val()){
									showAndHide('makeDefault_'+$('#idBusinessC').val(),'default_'+$('#idBusinessC').val(),500);
								}
								$('#idBusinessC').val('<?=$bc[id]?>');
								showAndHide('default_<?=$bc['id']?>', 'makeDefault_<?=$bc['id']?>', 500);
								updateBCTagLink('<?=md5($_GET[id_tag])?>','<?=base64_encode($bc['id'])?>')"/>
				<img id="default_<?=$bc['id']?>"
					 src="css/menu_businessCard/default.png"
					 border="0"
					 title="Unlink from this BC"
					 style="cursor:pointer;display:none;"
					 onclick="	$('#idBusinessC').val('');
								showAndHide('makeDefault_<?=$bc['id']?>','default_<?=$bc['id']?>',500);
								updateBCTagLink('<?=md5($_GET[id_tag])?>','')"/>
			</li>
		<?php } ?>
	</ul>
</div>
<script type="text/javascript">
	$(function(){
		if($('#idBusinessC').val()){
			showAndHide('default_'+$('#idBusinessC').val(),'makeDefault_'+$('#idBusinessC').val(),500);
		}else{
			<?php if($markThisBC){ ?>
				$('#idBusinessC').val("<?=$bc['id']?>");
				showAndHide('default_<?=$bc['id']?>','makeDefault_<?=$bc['id']?>',500);
			<?php } ?>
		}
	});
</script>

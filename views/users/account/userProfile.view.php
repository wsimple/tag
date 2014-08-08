<?php
session_start();
include ("../../../includes/functions.php");
include ("../../../includes/config.php");
include ("../../../class/wconecta.class.php");
include ("../../../includes/languages.config.php");
$sql = "
		SELECT
			concat(name, ' ', last_name) AS nameUsr,
			screen_name,
			date_birth,
			followers_count,
			following_count,
			tags_count,
			profile_image_url,
			id,
			pay_bussines_card,
			md5(CONCAT(id, '_', email, '_', id)) AS code_friend,
			show_my_birthday,
			username,
			country
		FROM users
		WHERE md5(id)='".$_GET['id']."'
	";
$idUserprodile = campo('users', 'md5(id)', $_GET['id'], 'id');
$friend        = $GLOBALS['cn']->queryRow($sql);
?>
<script type="text/javascript">
	$(function(){
//		$('#userProfileDialog [onclick],#userProfileDialog [action],#userProfileDialog a').button();
	});
</script>
<div data-role="page" id="userProfileDialog">
	<div data-role="content" id="userProfile" class="userProfileStyle">
		<img src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['profile_image_url'], 'img/users/default.png')?>" width="60" height="60" style="float:right" />
		<ul class="list_inline">
			<li style="margin-bottom:10px;">
				<strong><?=USER_LBLNAME?>:</strong> <?=$friend['nameUsr']?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=SIGNUP_LBLSCREENNAME?>: </strong> <?=$friend['screen_name']?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=USER_LBLBIRTHDATE?>: </strong> <?=maskBirthday($friend['date_birth'], (($_SESSION['ws-tags']['ws-user']['show_birthday'] != '')?$_SESSION['ws-tags']['ws-user']['show_birthday']:$friend['show_my_birthday']))?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=USER_LBLFOLLOWERS?>: </strong>
				<input type="button" id="followers" onclick="<?php if ($friend['followers_count'] > 0) {?>friendsUser('<?=$friend[screen_name].' : '.USER_LBLFOLLOWERS?>','?uid=<?=md5($friend[id])?>&follower=1&fid=<?=md5($idUserprodile)?>'); <?php }?>"
					value="<?=mskPoints($friend['followers_count'])?>"/>

				<strong><?=USER_LBLFRIENDS?>: </strong>
				<input type="button" id="friends" onclick="<?php if ($friend['following_count'] > 0) {?>friendsUser('<?=$friend[screen_name].' : '.USER_LBLFRIENDS?>','?uid=<?=md5($friend[id])?>&fid=<?=md5($idUserprodile)?>'); <?php }?>"
					value="<?=mskPoints($friend['following_count'])?>"/>
<?php
$nTags = current($GLOBALS['cn']->queryRow('
						SELECT count(id) AS nTags
						FROM tags
						WHERE md5(id_user)="'.$_GET['id'].'" AND status = 1
					'));
?>
				<strong><?=MAINMNU_HOME?>: </strong>
				<input type="button" id="tags" action="tagsUser,<?=$nTags?>,<?=$friend['screen_name']?>:Tags,<?=md5($friend['id'])?>"
					value="<?=$nTags//mskPoints($friend[tags_count])?>"/>
			</li>
			<li style="padding-top:10px;margin-bottom:10px;text-align:center;">
<?php
$tagStatus = $GLOBALS['cn']->query("SELECT status FROM tags WHERE id_creator='".$friend['id']."' AND  status = '1'");
if (mysql_num_rows($tagStatus) > 0) {
	?>
						<input type="button" id="Mytag" action="personalTags,<?=$friend['screen_name'].' : '.USERPROFILE_TITLEMYUNIQUETAG?>,<?=md5($friend['id'])?>"
							value="<?=USERPROFILE_LABLEBTNVIEWMYTAGS?>"/>
	<?php
}
//IF HAS PAID AND DEFINED PERSONAL BUSINESS CARD -> SHOW BUTTON ON PROFILE
$haveBusinessCard = $GLOBALS['cn']->query("SELECT type FROM business_card WHERE id_user = '".$friend['id']."' AND type=0");
if (mysql_num_rows($haveBusinessCard) > 0 && !isset($_GET['calledProfile'])) {?>
						<input type="button" id="bussi" onclick="message('messages','<?=USERPROFILE_TITLEBUSINESSCARD?>','','',430,300,DOMINIO+'views/users/account/business_card/businessCard_dialog.view.php?uid=<?=md5($friend['id'])?>');"
							value="<?=USERPROFILE_LINKSHOWBUSINESSCARD?>"/>
	<?php
}?>
</li>
		</ul>
		<br/>
<?php
if ($_SESSION['ws-tags']['ws-user']['id'] && $_SESSION['ws-tags']['ws-user']['id'] != $friend['id']) {
	$sql = "
				SELECT id_user
				FROM users_links
				WHERE id_friend='".$friend['id']."' AND id_user='".$_SESSION['ws-tags']['ws-user']['id']."'
				LIMIT 1
			";
	$follower = (mysql_num_rows($GLOBALS['cn']->query($sql)) == 1);
	?>
					<div style="width:100%; text-align:center;">
						<input type="button" id="dialog_btn_link_<?=md5($friend['id'])?>" <?=$follower?'style="display:none; margin-right: 20px;color: white;"':'style="color: white;"'?> action="linkUser,#div_<?=md5($friend['id'])?>,<?=md5($friend['id'])?>,,,true"
							value="<?=USER_BTNLINK?>"/>
						<input type="button" id="dialog_btn_unlink_<?=md5($friend['id'])?>" <?=$follower?'style="color: white;"':'style="display:none; margin-right: 20px;color: white;"'?> action="linkUser,#div_<?=md5($friend['id'])?>,<?=md5($friend['id'])?>,animate,,true"
							value="<?=USER_BTNUNLINK?>"/>
	<?php
	if ($friend['username'] != '') {
		$externalProfileId = 'eprofile?usr='.$friend['username'];
	} else {
		$externalProfileId = "profile?sc=6&userIdExternalProfile=".md5($friend['id']);
	}
	?>
						<input type="button" id="externalProfile" action="exProfile,<?=$externalProfileId?>" style="margin: 0px 25px; color: white;"
							value="<?=EXTERNALPROFILE?>"/>
					</div>
					<div id="error"></div>
	<?php }?>
</div><!-- /content -->
</div><!-- /page -->
<script type="text/javascript">
$(function(){
	var isOpen=$('#tagsUser').dialog("isOpen");
});
</script>

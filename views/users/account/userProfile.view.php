<?php
session_start();
include ("../../../includes/functions.php");
include ("../../../includes/config.php");
include ("../../../class/wconecta.class.php");
include ("../../../includes/languages.config.php");

$friend = CON::getRow("SELECT 
						concat(u.name, ' ', u.last_name) AS nameUsr,
						u.screen_name,
						u.date_birth,
						u.followers_count,
						u.following_count,
						u.tags_count,
						u.profile_image_url,
						(SELECT count(t.id) FROM tags t WHERE t.id_user=u.id AND t.status = 1) AS nTags,
						(SELECT count(t.id) FROM tags t WHERE t.id_creator=u.id AND t.status = 1) AS nPTags,
						(SELECT count(b.id) FROM business_card b WHERE b.id_user = u.id AND b.type=0 ) AS nBCar,
						(SELECT ul.id_user FROM users_links ul WHERE ul.id_friend=u.id AND ul.id_user=? LIMIT 1) AS follower,
						u.id,
						u.pay_bussines_card,
						md5(CONCAT(u.id, '_',u.email, '_',u.id)) AS code_friend,
						u.show_my_birthday,
						u.username,
						u.country FROM users u
						WHERE md5(u.id)=?",array($_SESSION['ws-tags']['ws-user']['id'],$_GET['id']));

?>
<div data-role="page" id="userProfileDialog">
	<div data-role="content" id="userProfile" class="userProfileStyle">
		<img src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['profile_image_url'], 'img/users/default.png')?>" width="60" height="60" style="float:right;border-radius:50%;" />
		<ul class="list_inline">
			<li style="margin-bottom:10px;">
				<strong><?=USER_LBLNAME?>:</strong> <?=$friend['nameUsr']?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=SIGNUP_LBLSCREENNAME?>: </strong> <?=$friend['screen_name']?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=USER_LBLBIRTHDATE?>: </strong> <?=maskBirthday($friend['date_birth'],$friend['show_my_birthday'])?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=USER_LBLFOLLOWERS?>: </strong>
				<input type="button" id="followers" onclick="<?php if ($friend['followers_count'] > 0) {?>friendsUser('<?=$friend[screen_name].' : '.USER_LBLFOLLOWERS?>','?uid=<?=md5($friend[id])?>&follower=1&fid=<?=md5($friend['id'])?>'); <?php }?>"
					value="<?=mskPoints($friend['followers_count'])?>"/>

				<strong><?=USER_LBLFRIENDS?>: </strong>
				<input type="button" id="friends" onclick="<?php if ($friend['following_count'] > 0) {?>friendsUser('<?=$friend[screen_name].' : '.USER_LBLFRIENDS?>','?uid=<?=md5($friend[id])?>&fid=<?=md5($friend['id'])?>'); <?php }?>"
					value="<?=mskPoints($friend['following_count'])?>"/>
				<strong><?=MAINMNU_HOME?>: </strong>
				<input type="button" id="tags" action="tagsUser,<?=$friend['nTags']?>,<?=$friend['screen_name']?>:Tags,<?=md5($friend['id'])?>"
					value="<?=$friend['nTags']?>"/>
			</li>
			<li style="padding-top:10px;margin-bottom:10px;text-align:center;">
				<?php if ($friend['nPTags']> 0){ ?>
					<input type="button" id="Mytag" action="tagsUser,1,1,<?=md5($friend['id'])?>" value="<?=MAINMNU_MYTAGS?>"/>
				<?php }
				//IF HAS PAID AND DEFINED PERSONAL BUSINESS CARD -> SHOW BUTTON ON PROFILE
				if ($friend['nBCar']> 0 && !isset($_GET['calledProfile'])) {?>
					<input type="button" id="bussi" onclick="message('messages','<?=USERPROFILE_TITLEBUSINESSCARD?>','','',430,300,DOMINIO+'views/users/account/business_card/businessCard_dialog.view.php?uid=<?=md5($friend['id'])?>');" value="<?=USERPROFILE_LINKSHOWBUSINESSCARD?>"/>
				<?php } ?>
			</li>
		</ul>
		<br/>
<?php if ($_SESSION['ws-tags']['ws-user']['id'] != $friend['id']) { ?>
		<div style="width:100%; text-align:center;">
			<input type="button" id="dialog_btn_link_<?=md5($friend['id'])?>" <?=$friend['follower']?'style="display:none; margin-right: 20px;color: white;"':'style="color: white;"'?> action="linkUser,#div_<?=md5($friend['id'])?>,<?=md5($friend['id'])?>,,,true"
				value="<?=USER_BTNLINK?>"/>
			<input type="button" id="dialog_btn_unlink_<?=md5($friend['id'])?>" <?=$friend['follower']?'style="color: white;"':'style="display:none; margin-right: 20px;color: white;"'?> action="linkUser,#div_<?=md5($friend['id'])?>,<?=md5($friend['id'])?>,animate,,true"
				value="<?=USER_BTNUNLINK?>"/>
	<?php
	if ($friend['username'] != '') $externalProfileId = $friend['username'];
	else $externalProfileId = "user/".md5($friend['id']);
	?>
			<input type="button" id="externalProfile" action="exProfile,<?=$externalProfileId?>" style="margin: 0px 25px; color: white;"
				value="<?=EXTERNALPROFILE?>"/>
		</div>
		<div id="error"></div>
	<?php } ?>
</div><!-- /content -->
</div><!-- /page -->
<script type="text/javascript">
$(function(){
	var isOpen=$('#tagsUser').dialog("isOpen");
});
</script>

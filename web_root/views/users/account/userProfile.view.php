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
						(SELECT COUNT(*) FROM users_links ul WHERE u.id=ul.id_user	) AS following_count,
						(SELECT COUNT(*) FROM users_links ul WHERE u.id=ul.id_friend	) AS followers_count,
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
			<li style="margin-bottom:10px;"><strong><?=lan('USER_LBLNAME')?>:</strong> <?=formatoCadena($friend['nameUsr'])?></li>
			<li style="margin-bottom:10px;"><strong><?=lan('SIGNUP_LBLSCREENNAME')?>: </strong> <?=formatoCadena($friend['screen_name'])?></li>
			<li style="margin-bottom:10px;">
				<strong><?=lan('USER_LBLBIRTHDATE')?>: </strong> <?=maskBirthday($friend['date_birth'],$friend['show_my_birthday'])?>
			</li>
			<li style="margin-bottom:10px;">
				<strong><?=lan('USER_LBLFOLLOWERS')?>: </strong>
				<input userF="followers" type="button" id="followers" value="<?=mskPoints($friend['followers_count'])?>"/>
				<strong><?=lan('USER_LBLFRIENDS')?>: </strong>
				<input userF="followed" type="button" id="followed" value="<?=mskPoints($friend['following_count'])?>"/>
				<strong><?=lan('MAINMNU_HOME')?>: </strong>
				<input type="button" id="tags" action="tagsUser,<?=$friend['nTags']?>,<?=formatoCadena($friend['screen_name'])?>:Tags,<?=md5($friend['id'])?>" value="<?=$friend['nTags']?>"/>
			</li>
			<li style="padding-top:10px;margin-bottom:10px;text-align:center;">
				<?php if ($friend['nPTags']> 0){ ?>
					<input type="button" id="Mytag" action="tagsUser,1,1,<?=md5($friend['id'])?>" value="<?=lan('MAINMNU_MYTAGS')?>"/>
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
			<input type="button" style="<?=$friend['follower']?'display:none;':''?> margin-right: 20px;color: white;"  action="linkUser,<?=md5($friend['id'])?>,2" value="<?=lan('USER_BTNLINK')?>"/>
			<input type="button" style="<?=$friend['follower']?'':'display:none;'?> margin-right: 20px;color: white;" action="linkUser,<?=md5($friend['id'])?>,2" value="<?=lan('USER_BTNUNLINK')?>" class="btn btn-disabled"/>
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
	$('#userProfileDialog li input[userF]').click(function(){
		if ($(this).val().replace(/K|M|car/gi,'')*1>0){
			var title=$(this).attr('id')=='follower'?'<?=USER_LBLFRIENDS?>':'<?=USER_LBLFOLLOWERS?>';
			friendsUser('<?=$friend["screen_name"]?>: '+title,'<?=md5($friend["id"])?>',$(this).attr('id'));
		}
	});
});
</script>

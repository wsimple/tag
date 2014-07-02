<?php
	    session_start();

	    include ("../../../includes/functions.php");
		include ("../../../includes/config.php");
		include ("../../../class/wconecta.class.php");
		include ("../../../includes/languages.config.php");

 //USER_FINDFRIENDSTITLELINKS ?>
<script type="text/javascript">
	$(document).ready(function(){
//		$("button, input:submit, input:reset, input:button").button();
	});
</script>

	<div >
		<?php
			 $friends = $_GET['follower']!=''?followers($_GET['uid']):following($_GET['uid']);
			 $uid=$_SESSION['ws-tags']['ws-user']['id'];
			 while($friend=mysql_fetch_assoc($friends)){
				if ($_GET['follower'] != '') $idFriends=$friend['id_user'];
				else $idFriends=$friend['id_friend'];
				if (!isFriend($_GET['fid'],$idFriends)){
				$follower = $GLOBALS['cn']->query("SELECT `id_user` AS `id_user` FROM users_links WHERE `id_friend`=".$idFriends." AND `id_user`=".$uid);
				$follower= mysql_fetch_assoc($follower);
		?>

			<!--<div id="div_<?=md5($friend['id_friend'])?>" class="divYourFriends">-->
			<div  class="divYourFriends">
				<div style="float:left; width:80px;">
				<?php 
					$fot_	=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png');
				?>
				<img onclick="$('#default-dialog').dialog('close'); $('#friendsUser').dialog('close'); userProfile('<?=$friend['name_user']?>','Close','<?=md5($idFriends)?>')" src="<?=$fot_?>" width="60" height="60" />
				</div>

				<div class="divYourFriendsDetails">
					<a href="javascript:void(0);" onclick="$('#default-dialog').dialog('close'); $('#friendsUser').dialog('close'); userProfile('<?=$friend['name_user']?>','Close','<?=md5($idFriends)?>')">
						<?=  formatoCadena($friend['name_user'])?>
					</a><br>
					<span class="titleField">Email: </span><?=$friend['email']?> <br>
					<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$friend['followers_count']?>)</span> 
					<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$friend['friends_count']?>)</span><br>
					<?php  if ($friend['country']!= 0) {
						$countryFriend = $GLOBALS['cn']->query('
								SELECT name
								FROM countries
								WHERE id='.$friend['country'].'
								');
						$countryFriend= mysql_fetch_array($countryFriend);
					?>
					<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>: </span><?=$countryFriend['name']?><br>
					<?php }  ?>

				</div>
				<?php if ($idFriends!=$_SESSION['ws-tags']['ws-user'][id]){ ?>
				<div style="float:right;">
						<input name="btn_link_<?=md5($idFriends)?>" 
							   id="dialog_btn_link_<?=md5($idFriends)?>" 
							   type="button" value="<?=USER_BTNLINK?>" 
							   action="linkUser,#div_<?=md5($idFriends)?>,<?=md5($idFriends)?>,,,true" <?=$follower['id_user']?'style="display:none"':''?>/>
						<input name="btn_unlink_<?=md5($idFriends)?>" 
							   id="dialog_btn_unlink_<?=md5($idFriends)?>" 
							   type="button" value="<?=USER_BTNUNLINK?>" 
							   action="linkUser,#div_<?=md5($idFriends)?>,<?=md5($idFriends)?>,animate,,true" <?=$follower['id_user']?'':'style="display:none"'?>/>
				</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<?php
				 }
			 }
		?>
   </div>

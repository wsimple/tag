<div id="friendsTabs">
<?php
if ($friends_count == 0) {
	mysqli_data_seek($friends, 0);
	$friendsAll = $friends;
	echo '<div class="messageNoResultSearch">'.SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span></div><div class="ui-single-box-title">'.EDITFRIEND_VIEWTITLESUGGES.'</div>';
}else{
	$friendsAll=users($whereFriends,5);
}
while($friend=mysql_fetch_assoc($friendsAll)):
	$nameCountryUser=$GLOBALS['cn']->queryRow("SELECT name FROM countries WHERE id = '".$friend['country']."'");
	$follower=$friend['follower'];
?>
	<div id="div_<?=md5($friend[id_friend])?>" class="divYourFriends">
		<div style="float:left;width:65px;cursor:pointer;">
			<img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="50" height="50" style="border:1px solid #ccc" />
		</div>
		<div style="float:left;width:480px;">
			<div style="width:450px;float:left;">
				<a href="javascript:void(0);" onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" style="font-size:14px;">
					<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">
					<?=formatoCadena($friend['name_user'])?>
				</a><br/>
				<?php if($friend['username']!=''){?>
				<span class="titleField"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc;font-size:12px;" href="<?=base_url($friend['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$friend['username']?></a>
				<div class="clearfix"></div>
				<?php }?>
				<span class="titleField"><?=SIGNUP_LBLEMAIL?>:</span> <?=$friend['email']?>
				<div class="clearfix"></div>
				<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$friend['followers_count']?>)</span>
				<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$friend['friends_count']?>)</span><div class="clearfix"></div>
				<?php if($nameCountryUser!=''){?>
				<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?>
				<div class="clearfix"></div><br>
				<?php }?>
			</div>
			<div class="btnFriendsSearch" style="height:70px;width:0px;float:right;text-align:right;">
				<input style="margin-top:20px;<?=$follower?'display:none;':''?>" name="btn_link_<?=md5($friend['id_friend'])?>" id="btn_link_<?=md5($friend['id_friend'])?>" type="button" value="<?=USER_BTNLINK?>" action="linkUser,,<?=md5($friend['id_friend'])?>" />
				<input style="margin-top:20px;<?=$follower?'':'display:none;'?>" name="btn_unlink_<?=md5($friend['id_friend'])?>" id="btn_unlink_<?=md5($friend['id_friend'])?>" type="button" value="<?=USER_BTNUNLINK?>" action="linkUser,,<?=md5($friend['id_friend'])?>,animate" />
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
<?php
endwhile; 
?>
</div>
<?php if($friends_count==5){ ?>
<div id="smTabsFriends" class="seemoreSearch"><?=USER_BTNSEEMORE?></div>
<div class="clearfix"></div>
<div id="loading_friends"></div>
<?php } ?>
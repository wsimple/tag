<article id="title-news-suggest" class="side-box imagenSug">
	<header><span><?=HOME_SUGGESTFRIENDS?></span></header>
	<?php
	$friends=suggestionFriends('',12); $display="";
	if(count($friends)){ $display='style="display:none"'; $coma="";$ids=""; ?>
	<div class="suggest-friends">
	<?php foreach($friends as $friend){ $ids.=$coma.$friend['id_friend']; $coma=","; ?>
		<div class="contentSuggestFriends thisPeople">
			<div class="divYourFriendsSuggest" >
				<div class="divYourFriendsSuggestPhoto">
					<img action="profile,<?=md5($friend['id_friend'])?>,<?=$friend['name_user']?>" border="0"
						src="<?=FILESERVER.getUserPicture('img/users/'.$friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>"/>
				</div>
				<div class="divYourFriendsSuggestInfo">
					<div class="left">
						<a href="javascript:void(0);" action="profile,<?=md5($friend['id_friend'])?>,<?=$friend['name_user']?>">
							<?=ucwords($friend['name_user'])?>
						</a>
					</div>
					<div class="left" style="width:100%;"></div>
					<input class="left" type="button" value="<?=$lang['USER_BTNLINK']?>" action="linkUser,<?=md5($friend['id_friend'])?>,2" style="padding: 5px 8px; margin-top: 5px;float: none;margin-left: 30%;"/>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	<?php } ?>
	<input type="hidden" name="no_id_s" value="<?=$ids?>">
	</div>
	<div id="seeMoreSuggest" ><a href="<?=base_url('friends?sc=2')?>"><?=$lang["USER_BTNSEEMORE"].'...'?></a></div>
	<?php } ?>
	<div class="messageInviteSuggest" <?=$display?> ><?=$lang["INVITED_SUGGETSFRIENDS"]?></div>
	<div id="inviteSuggest" <?=$display?>><a href="<?=base_url('friends?sc=3')?>"><?=$lang["GROUPS_MENUINVITEFRIENDS"]?></a></div>
	<div class="clearfix"></div>
</article>

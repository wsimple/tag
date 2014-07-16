<article id="title-news-suggest" class="side-box imagenSug">
	<header><span><?=HOME_SUGGESTFRIENDS?></span></header>
	<?php
	//relleno de sugerencias, por rand
	$friends=randSuggestionFriends('',12); //incremetar el 0 por si se necesita relleno
	if($numfriends=mysql_num_rows($friends)!=0){
		echo '<div class="suggest-friends">';
		while($friend=mysql_fetch_assoc($friends)){
		?>
		<div class="contentSuggestFriends">
			<div id="div_<?=md5($friend['id_friend'])?>" class="divYourFriendsSuggest" >
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
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<?php
		}
		echo '</div>';
	}else{?>
		<div class="messageInviteSuggest"><?=INVITED_SUGGETSFRIENDS?></div>
		<div id="inviteSuggest"><a href="<?=base_url('friends?sc=3')?>"><?=GROUPS_MENUINVITEFRIENDS?></a></div>
	<?php } ?>
	<div id="seeMoreSuggest" style="display:none"><a href="<?=base_url('friends?sc=2')?>"><?=USER_BTNSEEMORE.'...'?></a></div>
	<div id="inviteSuggest" style="display:none"><a href="<?=base_url('friends?sc=3')?>"><?=GROUPS_MENUINVITEFRIENDS?></a></div>
	<div class="clearfix"></div>
</article>

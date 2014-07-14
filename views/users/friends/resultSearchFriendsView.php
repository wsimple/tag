<?php
	include('../../../includes/session.php');
	include('../../../includes/config.php');
	include('../../../includes/functions.php');
	include('../../../class/wconecta.class.php');
	include('../../../includes/languages.config.php');
	$where = " WHERE u.id!='".$_SESSION['ws-tags']['ws-user']['id']."' ";

	if ($_GET['dato']!="")
	    $where .= " AND (email LIKE '%".$_GET['dato']."%' OR
		                 name LIKE '%".$_GET['dato']."%' OR
						 last_name LIKE '%".$_GET['dato']."%') ";

	$friends = users($where);

	if (mysql_num_rows($friends)>0){
		while ($friend = mysql_fetch_assoc($friends)){
			$follower=$friend['follower'];
			$countryUser = $GLOBALS['cn']->query("SELECT name FROM countries WHERE id = '".$friend['country']."'");
			$nameCountryUser  = mysql_fetch_assoc($countryUser);
?>
		<div class="divYourFriends">
            <div style="float:left; width:80px; cursor:pointer;">
                <img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="62" height="62" style="border: 1px solid #ccc" />
            </div>
            <div style="float:left; width:450px; height:73px;">
                <div style="height:70px; width:450px; float: left;">
                    <a href="javascript:void(0);" onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
                        <?=$friend['name_user']?>
                    </a><br>
					<?php if($friend['username']!=''){?>
					<span style="color:#000"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc" href="<?=DOMINIO.$friend['username']?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$friend['username']?></a><br>

					<?php }?>
					<span style="color:#000"><?=SIGNUP_LBLEMAIL?>: </span> <?=$friend['email']?><br>
					<?php if($nameCountryUser!=''){?>
					<span style="color:#000"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?><br>
					<?php }?>
                </div>
                <div style="height:70px; width:0px;float: right; text-align: right;">
                        <input style="margin-top: 20px;<?=$follower?'display:none;':''?>" name="btn_link_<?=md5($friend['id_friend'])?>" id="btn_link_<?=md5($friend['id_friend'])?>" type="button" value="<?=USER_BTNLINK?>" action="linkUser,,<?=md5($friend['id_friend'])?>" />
                        <input style="margin-top: 20px;<?=$follower?'':'display:none;'?>" name="btn_unlink_<?=md5($friend['id_friend'])?>" id="btn_unlink_<?=md5($friend['id_friend'])?>" type="button" value="<?=USER_BTNUNLINK?>" action="linkUser,,<?=md5($friend['id_friend'])?>,animate"/>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
<?php
		}
	} else { ?>
		<div class="messageAdver messageNoFindFriends"><?=FRIENDS_NORESULTS?></div>
<?php } ?>

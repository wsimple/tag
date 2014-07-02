<?php
	include('../../../includes/session.php');
	include('../../../includes/functions.php');
	include('../../../includes/config.php');
	include('../../../class/wconecta.class.php');
	include('../../../includes/languages.config.php');
 ?>
<link rel="stylesheet" type="text/css" href="<?=DOMINIO?>css/browser.css" media="all" />
<script type="text/javascript">
	$(document).ready(function(){
		$("#msgBoxGroupInviteFriends").html('');
		var options = {	};//options
		$("#frmInviteGroup").ajaxForm(options);
		$("#seek_friends").focus(function() {
			if ($.trim($("#seek_friends").val())=="<?=FRIENDS_FINDFRIEND_SEARCH?>")
				$("#seek_friends").val("");
		});
		$("#seek_friends").blur(function() {
			if ($.trim($("#seek_friends").val())=="")
				$("#seek_friends").val("<?=FRIENDS_FINDFRIEND_SEARCH?>");
		});
//		$("button, input:submit, input:reset, input:button").button();
			$("#seekUserLstSeemytag")
			.focus(function() {
				if ($.trim($(this).val())=="<?=$labelTxtBroswer?>")
					$(this).val("");
			})
			.blur(function() {
				if ($.trim($(this).val())=="")
					$(this).val("<?=$labelTxtBroswer?>");
			})
			.keyup(function() {
				var txt=$.trim($(this).val());
				var like = new RegExp(txt,"i");
				$("#boxUserLstSeemytag li").each(function(i, li){
					if( txt=="" || like.test($("strong",li).text()) || like.test($(":checkbox",li).val()) )
						$(li).show();
					else
						$(li).hide();
				});
			});

			$("#hrefNoneBoxLstSeemytag").click(function(){
				$("#contentLstUsersSeemytag :checkbox").attr("checked", false).change();
			});

			$("#hrefAllBoxLstSeemytag").click(function(){
				$("#contentLstUsersSeemytag :checkbox").attr("checked", true).change();
			});
		});
	</script>
<form id="frmInviteGroup" name="frmInviteGroup" method="post" action="controls/groups/actionsGroups.control.php">
<div class="ui-single-box" style="height:auto; min-height: 449px;">
	<?php
		$friends = $GLOBALS['cn']->query('
			SELECT		u.id_user,
						f.id,
						CONCAT(f.name, " ", f.last_name) AS name_user,
						f.profile_image_url  AS photo_friend,
						f.email,
						f.home_phone,
						f.screen_name,
						f.mobile_phone,
						f.work_phone
			FROM users_groups u JOIN users f ON u.id_user=f.id
			WHERE md5(id_group) = "'.$_GET['grp'].'" AND u.id_user != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
			GROUP BY u.id_user
		');

		$friends =view_friends();
		$title = USERS_BROWSERFRIENDSTITLEOP1;

		$labelTxtBroswer = USERS_BROWSERFRIENDSLABELTXT1;
	?>
	<img src="img/menu_groups/friends.png" width="16" height="16" border="0" />
	<?=$title?>&nbsp;(<?=mysql_num_rows($friends)?>)
	<span style="font-weight:normal; float:right;" id="loaderUserLstSeemytag">
		<span><?=GROUPSSELECTOPTION?></span>
		<a href="javascript:void(0);" onfocus="this.blur()" id="hrefNoneBoxLstSeemytag"><?=GROUPSNONESELECT?></a>
		<a href="javascript:void(0);" onfocus="this.blur()" id="hrefAllBoxLstSeemytag"><?=GROUPSALLSELECT?></a>
	</span>
	<input name="seekUserLstSeemytag" id="seekUserLstSeemytag" type="text" class="txt_box_seekFriendsBrowsers" style="width:95%; margin-top: 15px; background-image: none;" placeholder="<?=$labelTxtBroswer?>">
	<div id="contentLstUsersSeemytag">
		<ul id="boxUserLstSeemytag">
			<?php
				$found_mails=array();
				while ($friend = mysql_fetch_assoc($friends)){
					$query = $GLOBALS['cn']->query('
						SELECT	u.username AS username,
								(SELECT a.name FROM countries a WHERE a.id=u.country) AS pais,
								u.followers_count AS followers,
								u.friends_count AS friends
						FROM users u
						WHERE u.id = "'.$friend['id_friend'].'"
					');
					$array = mysql_fetch_assoc($query);
					$id_layer = md5($friend['id_friend']);
					$val_layer =  $id_layer;
					$codeFriend = md5($friend['id_friend'].'_'.$friend['email'].'_'.$friend['id_friend']);
			?>
			<li id="liBoxUserLstSeemytag_<?=$id_layer?>" style="border-bottom: 1px solid #CCC;">
				<div class="divYourFriends" style="border-bottom:none; margin-left: 85px;">
					<!--strong><?=$friend['name_user']?></strong><br/-->
					<a href="javascript:void(0);" onclick="$('#userProfile').dialog('close'); $('#friendsUser').dialog('close'); userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
							<strong><?=$friend['name_user']?></strong>
					</a><br>
					<?php
					if($brower_type==2){
					?>
						<span class="titleField" style="color: #252525;"><?=SIGNUP_LBLEMAIL?>:&nbsp;</span><?=$val_layer?><br>
					<?php
					}
					if (trim($array['username'])!='' && $brower_type==1){
					?>
						<span class="titleField" style="color: #252525;"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:&nbsp;</span><a href="<?=DOMINIO.$array['username']?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$array['username']?></a><br/>
					<?php
					}
					if (trim($array['pais'])!=''){
					?>
						<span class="titleField" style="color: #252525;"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$array['pais']?><br/>
					<?php } ?>
					<span class="titleField" style="color: #252525;"><?=USERS_BROWSERFRIENDSLABELFRIENDS?>(<?=$array['friends']?>),&nbsp;<?=USERS_BROWSERFRIENDSLABELADMIRERS?>(<?=$array['followers']?>)</span>
				</div>
				<?php $fot_=FILESERVER.getUserPicture($codeFriend.'/'.$friend['photo_friend'],'img/users/default.png'); ?>
				<img src="<?=$fot_?>" border="0"  width="60" height="60" style=" margin:3px; border:1px solid #6DA916; background-color:#D3ED72; padding:3px;" />
				<p>
					<?php $checked=''; ?>
					<input type="checkbox" <?=$checked?> id="chkLstUsersBroswer_<?=$id_layer?>"  name="chkLstUsersBroswer_<?=$id_layer?>" value="<?=$id_layer?>" />
					<label for="chkLstUsersBroswer_<?=$id_layer?>"></label>
				</p>
			</li>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#chkLstUsersBroswer_<?=$id_layer?>").button().change(function() {
						var li=$(this).parent().parent();//checkbox < p < li
						if ($(this).is(':checked')){
							li.css('background-color','FFFEE0');
							li.find('label span').text("<?=GROUPS_BROWSERUSERSADMINBTNNOSELECT?>");
						}else{
							li.css('background-color','FFF');
							li.find('label span').text("<?=GROUPS_BROWSERUSERSADMINBTNSELECT?>");
						}
					}).change();
				});
			</script>
			<?php
				}
			?>
		</ul>
	</div>
</div>
<input name="action" id="action" type="hidden" value="6" />
<input name="grp" id="grp" type="hidden" value="<?=$_GET['grp']?>" />
</form>

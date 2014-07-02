<?php
	switch ($brower_type){
		case 1:
			$lstUsrs = $GLOBALS['cn']->query('
				SELECT id_user
				FROM users_groups
				WHERE md5(id_group) = "'.$_GET['grp'].'" AND id_user != "'.$_SESSION['ws-tags']['ws-user']['id'].'"
				GROUP BY id_user
			');

			$arrayMembersGroup = mysqlFetchAssocToArray($lstUsrs, 'id_user'); //array de miembros del grupo

			//_imprimir($arrayMembersGroup);
			if (count($arrayMembersGroup)>0){
				$idsNotIn = '';
				foreach ($arrayMembersGroup as $id_menber) $idsNotIn .= "'".$id_menber."',";
				$friends = view_friends('','', " AND f.id_friend NOT IN (".rtrim($idsNotIn,',').") ");
			}else{ $friends = view_friends(); }

			$title = USERS_BROWSERFRIENDSTITLEOP1;
			$labelTxtBroswer = USERS_BROWSERFRIENDSLABELTXT1;
			$fieldWhereDatail = 'id_friend';

		break;
		case 2:
			//echo $_GET['mails'];
			$share=false;
			if(isset($_GET['share'])) $share=true;
			$arrayMembersGroup = array();
			foreach(explode(';',$_GET['mails']) as $item){	
				$_email = end(explode(',',$item));
				//if (is_numeric($_email)){
				if (!strpos($_email,'@')){
					$_email = campo("users", "md5(id)", $_email, "email");
					$arrayMembersGroup[] = $_email;
				}else{ $arrayMembersGroup[] = $_email; }	
			}
			$friends = view_friends();
			$title = USERS_BROWSERFRIENDSTITLEOP1;
			$labelTxtBroswer = USERS_BROWSERFRIENDSLABELTXT1;
			$fieldWhereDatail = 'id_friend';
		break;
	}
?>
<script type="text/javascript">
	$(document).ready(function(){
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

			/*("#loaderUserLstSeemytag").html('<img src="css/smt/loader.gif" width="12" height="12" border="0" />');
			$.ajax({
				type: "GET",
				url: "views/users/browser/ajax.view.php?brower_type=<?=$brower_type?>&like="+like,
				dataType: "html",
				success: function (data)
				{
					$("#boxUserLstSeemytag").html(data);
				}
			});

			$("#loaderUserLstSeemytag").html("");
			/**/
		});

		$("#hrefNoneBoxLstSeemytag").click(function(){
			$("#contentLstUsersSeemytag :checkbox").attr("checked", false).change();
		});

		$("#hrefAllBoxLstSeemytag").click(function(){
			$("#contentLstUsersSeemytag :checkbox").attr("checked", true).change();
		});
	});
</script>

<tr>
	<td width="18" style="padding-bottom:5px"><img src="css/smt/menu_left/friends.png" width="16" height="16" border="0" /></td>
	<td style="padding-bottom:5px; font-size:12px">
		<?=$title?>&nbsp;(<?=$friend_total = mysql_num_rows($friends)?>)
		<span id="loaderUserLstSeemytag" style="float: right;"><?=GROUPSSELECTOPTION?>:&nbsp;&nbsp;
			<a href="javascript:void(0);" onfocus="this.blur()" id="hrefNoneBoxLstSeemytag"><?=GROUPSNONESELECT?></a>&nbsp;&nbsp;
			<a href="javascript:void(0);" onfocus="this.blur()" id="hrefAllBoxLstSeemytag"><?=GROUPSALLSELECT?></a>
		</span>
	</td>
</tr>

<tr>
	<td colspan="2" style="padding:3px 0 5px 5px; border-top:1px solid #CCC; background-color:#F4F4F4;">
		<input name="seekUserLstSeemytag" id="seekUserLstSeemytag" type="text" class="txt_box_seekFriendsBrowsers" style="width:95%; background-image: none;" value="<?=$labelTxtBroswer?>">
	</td>
</tr>

<tr>
	<td colspan="2" valign="top">
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
						WHERE u.id = "'.$friend[$fieldWhereDatail].'"
					');
					$array = mysql_fetch_assoc($query);
					$id_layer = md5($friend['id_friend']);
					$val_layer = ($brower_type==2) ? $friend['email'] : $id_layer;
			?>
			<li id="liBoxUserLstSeemytag_<?=$id_layer?>">
				<div>
					<strong style="color:#E78F08"><?=$friend['name_user']?></strong><br/>
					<?php if($brower_type==2){ ?>
						<?=SIGNUP_LBLEMAIL?>:&nbsp;<span style="color:#E78F08"><?=$val_layer?></span><br>
					<?php }
					if(trim($array['username'])!='' && $brower_type==1){ ?>
						<?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:&nbsp;<span><a href="<?=DOMINIO.$array['username']?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$array['username']?></a></span><br/>
					<?php }
					if(trim($array['pais'])!=''){ ?>
						<?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;<span><?=$array['pais']?></span><br/>
					<?php } ?>
					<?=USERS_BROWSERFRIENDSLABELFRIENDS?>(<?=$array['friends']?>),&nbsp;<?=USERS_BROWSERFRIENDSLABELADMIRERS?>(<?=$array['followers']?>)
				</div>
				<?php $photoUser=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend']); ?>
				<img src="<?=$photoUser?>" border="0"  width="60" height="60" />
				<p>
					<?php
						$checked = '';
						if ($brower_type==1 && @in_array($friend['id_friend'], $arrayMembersGroup)) $checked = 'checked="checked"';
						if ($brower_type==2){
							if(@in_array($friend['email'], $arrayMembersGroup)){
								$checked = 'checked="checked"';
								$found_mails[]=$friend['email'];
							}
						}
					?>
					<input type="checkbox" <?=$checked?> id="chkLstUsersBroswer_<?=$id_layer?>"  name="chkLstUsersBroswer_<?=$id_layer?>" value="<?=$id_layer?>" />
					<label for="chkLstUsersBroswer_<?=$id_layer?>"></label>
				</p>
			</li>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#chkLstUsersBroswer_<?=$id_layer?>").button()
					$("#chkLstUsersBroswer_<?=$id_layer?>").change(function() {
						var li=$(this).parent().parent();// checkbox < p < li
						if ($(this).is(':checked')){
							li.css("background-color","FFFEE0");
							li.find("label span").text("<?=$share?TAGS_OPTIONSHARENO:USERS_BROWSERFRIENDSLABELBTNUNINVITE?>");
						}else{
							li.css("background-color","FFF");
							li.find("label span").text("<?=$share?TAGS_OPTIONSHARE:USERS_BROWSERFRIENDSLABELBTNINVITE?>");
						}
					}).change();
				});
			</script>
			<?php }//while friends ?>
		</ul>
		<?php if($brower_type==2){ ?>
			<input name="extramails" id="extramails" type="hidden" value="<?=  implode(',', array_diff($arrayMembersGroup, $found_mails))?>" />
		<?php } ?>
	</div>
	<?php if($friend_total <= 0){?>
	<div>
		<?=USER_FINDMOREFRIENDS?>&nbsp;
		<a href="javascript:void(0);" onfocus="this.blur();"  onclick="onClickFriends('friends'); $('#viewsGroups').dialog('destroy');"><?=USER_FINDHERE?></a>
	</div>
	<?php }?>
	</td>
</tr>
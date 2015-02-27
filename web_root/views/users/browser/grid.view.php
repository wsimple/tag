<?php
	$title = USERS_BROWSERFRIENDSTITLEOP1;
	$labelTxtBroswer = USERS_BROWSERFRIENDSLABELTXT1;
	switch ($brower_type){
		case 1:
			$lstUsrs=CON::getArray('SELECT id_user FROM users_groups
									WHERE md5(id_group)=? AND id_user !=? AND (status=1 OR status=2)
									GROUP BY id_user',array(intToMd5($_GET['grp']),$_SESSION['ws-tags']['ws-user']['id']));
			if (count($lstUsrs)>0){
				$idsNotIn = '';
				for ($i=0;$i<count($lstUsrs);$i++) $idsNotIn .= "'".$lstUsrs[$i][0]."',";
				$friends = view_friends('','', " AND f.id_friend NOT IN (".rtrim($idsNotIn,',').") ");
			}else{ $friends = view_friends(); }
		break;
		case 2:
			$share=false;
			if(isset($_GET['share'])) $share=true;
			$arrayMembersGroup = array();
			foreach(explode(',',$_GET['mails']) as $item){	
				if ($item!=''){
					if (!isValidEmail($item,'@')){
						$i=CON::getVal("SELECT email FROM users WHERE md5(id)=?",array($item));
						$arrayMembersGroup[] =$i?$i:$item;
					}else{ $arrayMembersGroup[] = $item; }	
				}
			}
			$found_mails=array();
			$friends = view_friends();
		break;
	}
?>
<tr>
	<td width="18" style="padding-bottom:5px"><img src="css/smt/menu_left/friends.png" width="16" height="16" border="0" /></td>
	<td style="padding-bottom:5px; font-size:12px">
		<?=$title?>&nbsp;(<?=$friend_total = mysql_num_rows($friends)?>)
		<span id="loaderUserLstSeemytag" style="float: right;"><?=$lang['GROUPSSELECTOPTION']?>:&nbsp;&nbsp;
			<a href="javascript:void(0);" onfocus="this.blur()" id="hrefNoneBoxLstSeemytag"><?=$lang['GROUPSNONESELECT']?></a>&nbsp;&nbsp;
			<a href="javascript:void(0);" onfocus="this.blur()" id="hrefAllBoxLstSeemytag"><?=$lang['GROUPSALLSELECT']?></a>
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
					 while ($array = mysql_fetch_assoc($friends)){
						$id_layer = md5($array['id_friend']);
						$val_layer = ($brower_type==2) ? $array['email'] : $id_layer;
				?>
				<li>
					<div>
						<strong style="color:#E78F08"><?=$array['name_user']?></strong><br/>
						<?php if($brower_type==2){ 
							echo $lang['SIGNUP_LBLEMAIL']?>:&nbsp;<span style="color:#E78F08"><?=$val_layer?></span><br>
						<?php }
						if(trim($array['username'])!='' && $brower_type==1){ 
							echo $lang['USERS_BROWSERFRIENDSLABELEXTERNALPROFILE']?>:&nbsp;<span><a href="<?=base_url($array['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$array['username']?></a></span><br/>
						<?php }
						if(trim($array['country'])!=''){ 
							echo $lang['USERS_BROWSERFRIENDSLABELCOUNTRY']?>:&nbsp;<span><?=$array['country']?></span><br/>
						<?php } 
							echo $lang['USERS_BROWSERFRIENDSLABELFRIENDS'].'('.$array['friends_count'].'), '.$lang['USERS_BROWSERFRIENDSLABELADMIRERS'].'('.$array['followers_count'].')'; ?>
					</div>
					<?php $photoUser=FILESERVER.getUserPicture($array['code_friend'].'/'.$array['photo_friend']); ?>
					<img src="<?=$photoUser?>" border="0"  width="60" height="60" />
					<p>
						<?php
							$checked = '';
							if ($brower_type==1 && @in_array($array['id_friend'], $arrayMembersGroup)) $checked = 'checked="checked"';
							if ($brower_type==2){
								if(in_array($array['email'], $arrayMembersGroup)){
									$checked = 'checked="checked"';
									$found_mails[]=$array['email'];
								}
							}
						?>
						<input type="checkbox" <?=$checked?> id="chkLstUsersBroswer_<?=$id_layer?>"  name="chkLstUsersBroswer_<?=$id_layer?>" value="<?=$id_layer?>" />
						<label for="chkLstUsersBroswer_<?=$id_layer?>"></label>
					</p>
				</li>
				<?php }//while friends ?>
			</ul>
			<?php if($brower_type==2){ ?>
				<input name="extramails" id="extramails" type="hidden" value="<?=  implode(',', array_diff($arrayMembersGroup, $found_mails))?>" />
			<?php } ?>
		</div>
		<?php if($friend_total <= 0){?>
			<div><?=$lang['USER_FINDMOREFRIENDS']?>&nbsp;<a href="<?=base_url('friends?sc=2')?>" ><?=$lang['USER_FINDHERE']?></a></div>
		<?php }?>
	</td>
</tr>
<script type="text/javascript">
	$(document).ready(function(){
		$("#seekUserLstSeemytag").focus(function() {
			if ($.trim($(this).val())=="<?=$labelTxtBroswer?>") $(this).val("");
		}).blur(function() {
			if ($.trim($(this).val())=="") $(this).val("<?=$labelTxtBroswer?>");
		}).keyup(function() {
			var txt=$.trim($(this).val());
			var like = new RegExp(txt,"i");

			$("#boxUserLstSeemytag li").each(function(i, li){
				if(txt=="" || like.test($("strong",li).text()) || like.test($(":checkbox",li).val())) $(li).show();
				else $(li).hide();
			});
		});

		$("#hrefNoneBoxLstSeemytag").click(function(){
			$("#contentLstUsersSeemytag :checkbox").attr("checked", false).change();
		});
		$("#hrefAllBoxLstSeemytag").click(function(){
			$("#contentLstUsersSeemytag :checkbox").attr("checked", true).change();
		});
		$('input[type="checkbox"]').button().change(function(){
			var li=$(this).parents('li');// checkbox < p < li
			if ($(this).is(':checked')){
				li.css("background-color","FFFEE0");
				li.find("label span").text("<?=$share?$lang['TAGS_OPTIONSHARENO']:$lang['USERS_BROWSERFRIENDSLABELBTNUNINVITE']?>");
			}else{
				li.css("background-color","FFF");
				li.find("label span").text("<?=$share?$lang['TAGS_OPTIONSHARE']:$lang['USERS_BROWSERFRIENDSLABELBTNINVITE']?>");
			}
		}).change();
	});
</script>
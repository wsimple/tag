<div id="findFriends" class="ui-single-box">
	<div>
		<h3 class="ui-single-box-title">
			&nbsp;<?=EDITFRIEND_VIEWLABELSEARCH?>
		</h3>
		<input name="txtSearchFriend" id="txtSearchFriend" type="text" class="txt_box_seekFriendsBrowsers" placeholder="<?=USERS_BROWSERFRIENDSLABELTXT1?>" style="width:200px;position: relative;z-index: 200;left: 430px;top: -72px;background-repeat: no-repeat;">
		<h6  style="top: -10px;">
			<?=FINDFRIENDS_LEGENDOFSEARCHBAR?>
		</h6>
		<div id="amigosSearch" class="scroll-pane" >
			<div id="content_friends_search">
				<?php
			       $idsNotIn = "";
				   $friends  = view_friendsOfFriends(); //listado de sugerencias

			       while ($friend = mysql_fetch_assoc($friends)){
				   $countryUser = $GLOBALS['cn']->query("SELECT name FROM countries WHERE id = '".$friend['country']."'");
				   $nameCountryUser  = mysql_fetch_assoc($countryUser);
				?>
					<div id="div_<?=md5($friend['id_friend'])?>" class="divYourFriends">
                        <div style="float:left; width:80px; cursor:pointer;">
                            <img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="62" height="62" style="border: 1px solid #ccc" />
                        </div>
                        <div style="float:left; width:450px;">
                            <div style="width:420px; float: left;">
                                <a href="javascript:void(0);" onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
                                	<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">
                                    <?=ucwords($friend['name_user'])?>
                                </a><br>
								<?php if($friend['username']!=''){?>
								<span class="titleField"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc; font-size:12px;" href="<?=base_url($friend['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$friend['username']?></a>
								<div class="clearfix"></div>

								<?php } ?>
								<span class="titleField"><?=SIGNUP_LBLEMAIL?>: </span> <?=$friend['email']?>
								<div class="clearfix"></div>
								<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$friend['followers_count']?>)</span> 
								<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$friend['friends_count']?>)</span><div class="clearfix"></div>
								<?php if($nameCountryUser!=''){?>
								<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?><div class="clearfix"></div><br>
								<?php }?>
                            </div>
                            <div style="height:70px; width:0px;float: right; text-align: right;">
                                    <input style="margin-top: 20px" name="btn_link_<?=md5($friend['id_friend'])?>" id="btn_link_<?=md5($friend['id_friend'])?>" type="button" value="<?=USER_BTNLINK?>" action="linkUser,#div_<?=md5($friend['id_friend'])?>,<?=md5($friend['id_friend'])?>" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

				<?php
		            $idsNotIn .= "'".$friend['id_friend']."',"; //ids de los usuarios listado
				   }
				   $idsNotIn = rtrim($idsNotIn,',');// echo "relleno";
				   $friends = ($idsNotIn=="") ? randSuggestionFriends("", 50) : randSuggestionFriends($idsNotIn, 0); //incremetar el 0 por si se necesita relleno
				   while ($friend = mysql_fetch_assoc($friends)){
				   $countryUser = $GLOBALS['cn']->query("SELECT name FROM countries WHERE id = '".$friend['country']."'");
				   $nameCountryUser  = mysql_fetch_assoc($countryUser);
                ?>
            		<div id="div_<?=md5($friend['id_friend'])?>" class="divYourFriends">
                        <div style="float:left; width:80px; cursor:pointer;">
                            <img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="62" height="62" style="border: 1px solid #ccc" />
                        </div>
                        <div style="float:left; width:450px;">
                            <div style="width:450px; float: left;">
                                <a href="javascript:void(0);" onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
                                    <?=ucwords($friend['name_user'])?>
                                </a><br>
								<?php if($friend['username']!=''){?>
								<span class="titleField"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc" href="<?=base_url($friend['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$friend['username']?></a>
								<div class="clearfix"></div>

								<?php }?>
								<span class="titleField"><?=SIGNUP_LBLEMAIL?>: </span> <?=$friend['email']?>
								<div class="clearfix"></div>
								<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$friend['followers_count']?>)</span> 
								<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$friend['friends_count']?>)</span><div class="clearfix"></div>
								<?php if($nameCountryUser!=''){?>
								<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?><div class="clearfix"></div><br>
								<?php }?>
                            </div>
                            <div style="height:70px; width:0px;float: right; text-align: right;">
                                    <input style="margin-top: 20px" name="btn_link_<?=md5($friend['id_friend'])?>" id="btn_link_<?=md5($friend['id_friend'])?>" type="button" value="<?=USER_BTNLINK?>" action="linkUser,#div_<?=md5($friend['id_friend'])?>,<?=md5($friend['id_friend'])?>" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php
				   }//fin while de relleno
				   $viewsMySql = array("view_friends_level01",
									   "view_friends_level02",
									   "view_friends_level03",
									   "view_friends_level04",
									   "view_friends_level05",
									   "view_friends_level06",
									   "view_friends_level07"
									);

				   dropViews($viewsMySql);
				?>
			</div>
		</div>
	</div>
</div>
<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
<script type="text/javascript">
	$(function() {
		$('#txtSearchFriend').keyup(function() {
			var dato = $.trim($(this).val());
			// alert(dato);
			if (dato!="" && $(this).val().length>2 || dato=="")	{
				var $cont=$.div("#content_friends_search");
				$cont.fadeOut(200).html('<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="margin: 0 auto;display:block;">').fadeIn(200);
				$.ajax({
					type:"POST",
					url:"views/users/friends/resultSearchFriendsView.php?dato="+dato,
					dataType:"html",
					success:function(data){
						$cont.html(data).fadeIn(200);
					}
				});
			}
		});

	});
</script>
<?php }else{ ?> <script type="text/javascript"></script><?php } ?>
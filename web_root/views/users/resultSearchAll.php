<?php
if(isset($_GET['srh'])) $srh=$_GET['srh'];
if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){
?>
<script>
	$(function(){
		var search=$.trim('<?=$srh?>');
//		$("button, input:submit, input:reset, input:button").button();
		$('#txtSearchAll').val(search);
		if(search.length>2) searchAll(search);
		/*$('#txtSearchAll').keyup(function(e) {
			search=$.trim($(this).val());
			var keyCode=e.keyCode;
			if(keyCode<=90&&keyCode>=48||keyCode==32||keyCode==8||keyCode==190){
				if(search.length>2||search==""){
					searchAll(search);
				}
			}
		});/**/
	});
</script>
<?php } ?>
<!-- RUSLTADO AMIGOS -->
<div class="ui-single-box">
	<div id="searchAll">
		<?php //Resultado Busqueda ?>
		<div>
			<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
			<h3 class="ui-single-box-title">
				&nbsp;<!--?=EDITFRIEND_VIEWLABELSEARCH?--><?=SEARCHALL_SEARCHALL?>
			</h3>
			<!-- FIN BARRA TITULO Y BUSQUEDA DE AMIGO -->
			<div id="resultSearch" class="scroll-pane">
				<div id="content_result_search">
					<?php
						$idsNotIn='';
						$friends=view_friendsOfFriends();//listado de sugerencias
						$uid=$_SESSION['ws-tags']['ws-user']['id'];
						while($friend=mysql_fetch_assoc($friends)){
							$nameCountryUser=$GLOBALS['cn']->queryRow('SELECT name FROM countries WHERE id="'.$friend['country'].'"');
						$follower=$GLOBALS['cn']->queryRow('SELECT `id_user` AS `id_user` FROM users_links WHERE `id_friend`='.$friend['id_friend'].' AND `id_user`='.$uid);
					?>
						<div id="div_<?=md5($friend['id_friend'])?>" class="divYourFriends">
							<div style="float:left;width:80px;cursor:pointer;">
								<img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="62" height="62" style="border:1px solid #ccc;"/>
							</div>
							<div style="float:left;width:500px;">
								<div style="width:450px; float: left;">
									<a href="javascript:void(0);" onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
										<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">
										<?=ucwords($friend['name_user'])?>
									</a><br>
									<?php if($friend['username']!=''){?>
									<span class="titleField"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc; font-size:12px;" href="<?=base_url($friend['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$friend['username']?></a><div class="clearfix"></div>
									<?php }?>
									<span class="titleField"><?=SIGNUP_LBLEMAIL?>: </span> <?=$friend['email']?>
									<div class="clearfix"></div>
									<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$friend['followers_count']?>)</span> 
									<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$friend['friends_count']?>)</span><br>
									<?php if($nameCountryUser!=''){?>
									<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?>
									<div class="clearfix"></div><br>
									<?php } ?>
								</div>
								<div style="height:70px; width:0px;float: right; text-align: right;">
								<input style="margin-top:20px;<?=$follower['id_user']?'display:none;':''?>" type="button" value="<?=USER_BTNLINK?>" action="linkUser,<?=md5($friend['id_friend'])?>,2"/>
								<input style="margin-top: 20px;<?=$follower['id_user']?'':'display:none;'?>" type="button" value="<?=USER_BTNUNLINK?>" action="linkUser,<?=md5($friend['id_friend'])?>,2" class="btn btn-disabled"/>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					<?php
						$idsNotIn .= "'".$friend['id_friend']."',"; //ids de los usuarios listado
					}//fin while sugerencias
					//relleno de sugerencias, por rand
					$idsNotIn = rtrim($idsNotIn,',');// echo "relleno";
					$friends = ($idsNotIn=="") ? suggestionFriends("", 50) : suggestionFriends($idsNotIn, 0); //incremetar el 0 por si se necesita relleno
					foreach($friends as $friend){
					$nameCountryUser=$GLOBALS['cn']->queryRow("SELECT name FROM countries WHERE id = '".$friend['country']."'");
					$follower=$GLOBALS['cn']->queryRow("SELECT `id_user` AS `id_user` FROM users_links WHERE `id_friend`=".$friend['id_friend']." AND `id_user`=".$uid);
					?>
						<div id="div_<?=md5($friend['id_friend'])?>" class="divYourFriends">
							<div style="float:left;width:80px;cursor:pointer;">
								<img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="62" height="62" style="border: 1px solid #ccc"/>
							</div>
							<div style="float:left;width:500px;height:73px;">
								<div style="height:70px;width:450px;float:left;">
									<a href="javascript:void(0);" onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
										<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">
										<?=ucwords($friend['name_user'])?>
									</a><br>
									<?php if($friend['username']!=''){?>
									<span class="titleField"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc" href="<?=base_url($friend['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$friend['username']?></a><br>
									<?php }?>
									<span class="titleField"><?=SIGNUP_LBLEMAIL?>: </span> <?=$friend['email']?><br>
									<span class="titleField"><?=USER_LBLFOLLOWERS?></span> (<?=$friend['followers_count']?>)
									<span class="titleField"><?=USER_LBLFRIENDS?></span> (<?=$friend['friends_count']?>)<br>
									<?php if($nameCountryUser!=''){?>
									<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?><br>
									<?php }?>
								</div>
								<div style="height:70px; width:0px;float: right; text-align: right;">
								<input style="margin-top: 20px;<?=$follower['id_user']?'display:none;':''?>" type="button" value="<?=USER_BTNLINK?>" action="linkUser,<?=md5($friend['id_friend'])?>,2" />
								<input style="margin-top: 20px;<?=$follower['id_user']?'':'display:none;'?>"
								type="button" value="<?=USER_BTNUNLINK?>" action="linkUser,<?=md5($friend['id_friend'])?>,2" class="btn btn-disabled"/>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					<?php
						}//fin while de relleno
						$viewsMySql=array(
							"view_friends_level01","view_friends_level02","view_friends_level03","view_friends_level04",
							"view_friends_level05","view_friends_level06","view_friends_level07"
						);
						dropViews($viewsMySql);
					?>
				</div>
			</div>
		</div>
	</div>
</div>

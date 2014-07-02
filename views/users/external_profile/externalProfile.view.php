<?php
	include_once 'includes/funciones_upload.php';
	include_once 'includes/funciones_images.php';

	$primerSQL='
		SELECT x.id_friend as amigo,x.id_user as yo
		FROM users_links x
		JOIN users_links y ON y.id_friend=x.id_user
		WHERE y.id_user=x.id_friend
	';
	$query=$GLOBALS['cn']->query($primerSQL);
	while($array=mysql_fetch_assoc($query)){
		$GLOBALS['cn']->query('
			UPDATE users_links SET is_friend=1
			WHERE (id_user="'.$array['yo'].'" AND id_friend="'.$array['amigo'].'")
		');
	}
	//_imprimir($_GET);
	if(isset($_GET['userIdExternalProfile'])){
		$whereQuery="md5(id) = '".$_GET['userIdExternalProfile']."'";
		$showEditImages=false;
	}elseif(isset($_GET['usr'])){
		$buttonBackDisplay='display:none;';
		$whereQuery="username='".$_GET['usr']."'";
		$showEditImages=false;
	}else{
		$whereQuery="id='".$_SESSION['ws-tags']['ws-user']['id']."'";
		$showEditImages=true;
	}
	if(!$_SESSION['ws-tags']['ws-user']['id']){
		$buttonBackDisplay='display:none;';
	}
	$query="
		SELECT
			id,
			email,
			home_phone,
			mobile_phone,
			work_phone,
			user_background,
			profile_image_url,
			username,
			screen_name,
			sex,
			CONCAT(name,' ',last_name)							AS nameUser,
			md5(CONCAT(id,'_',email,'_',id))					AS code,
			(SELECT c.name FROM countries c WHERE c.id=country)	AS country,
			(SELECT s.label FROM sex s WHERE s.id=sex)			AS sex
		FROM users
		WHERE ".$whereQuery;
	$query=$GLOBALS['cn']->query($query);
	if(mysql_num_rows($query)=='1'){
		$userInfo=mysql_fetch_assoc($query);
	?>
	<script>
		$(function(){
			setTimeout(function(){
				$('body').css('background','<?=$userInfo['user_background'][0]=='#'?$userInfo['user_background']:'url('.FILESERVER.'img/users_backgrounds/'.$userInfo['user_background'].')'?>');
			},100);
			//$('#userProfileDialog a').button();
		});
	</script>
	<div class="ui-single-box">
		<div id="externalProfile">
			<?php if(!$_SESSION['ws-tags']['ws-user']['id']){ ?>
			<div id="backButton">
				<input type="button" value="<?=EXTERNALPROFILE_BTNBACK?>" action="goHome"/>
			</div>
		    <?php }
			if($_SESSION['ws-tags']['ws-user']['id']&&$_SESSION['ws-tags']['ws-user']['id']!=$userInfo['id']){//link unlink
				$followers="
					SELECT id_user
					FROM users_links
					WHERE id_friend='".$userInfo['id']."' AND id_user='".$_SESSION['ws-tags']['ws-user']['id']."'
					LIMIT 1
				";
				$follower=$GLOBALS['cn']->query($followers);
				$follower=(mysql_num_rows($follower)==1)?true:false;
				?>
				<div id="userProfileDialog" style="float:right;">
					<input type="button" id="btn_link_<?=md5($userInfo['id'])?>" <?=$follower?'style="display:none;margin-right:20px;"':''?> action="linkUser,,<?=md5($userInfo['id'])?>"
						value="<?=USER_BTNLINK?>"/>
					<input type="button" id="btn_unlink_<?=md5($userInfo['id'])?>" <?=$follower?'':'style="display:none;margin-right:20px;"'?> action="linkUser,,<?=md5($userInfo['id'])?>,animate"
						value="<?=USER_BTNUNLINK?>"/>
				</div>
			<?php }//link unlink ?>
			<h3 class="ui-single-box-title"><?=$userInfo['nameUser'].'\'s profile'?></h3>
			<div id="externalProfileInfo">
				<div class="photoProfile">
				<?php //Profile Picture
					//echo $userInfo[code].'<br>';
					$img_thumb_src=FILESERVER.getUserPicture($userInfo['code'].'/'.$userInfo['profile_image_url'],'img/users/default.png');
					$img_full_src=FILESERVER.'img/users/'.$userInfo['code'].'/'.$userInfo['profile_image_url'];
					//echo str_replace(FILESERVER."img/users/",'',$img_thumb_src.'<br>'.$img_full_src);
					if($img_full_src!=$img_thumb_src){ ?>
						<a class="grouped_PP" rel="PP_1" onfocus="this.blur()"
							href="views/photos/picture.view.php?src=<?=$img_full_src?>&default&id_user=<?=$userInfo[id]?>">
							<?php $imgDetails='class="imgWithMouseOverEfect" title="'.EXTERNALPROFILE_VIEWPICTUREALBUM.'"';
					} ?>
							<img <?=$imgDetails?> src="<?=$img_thumb_src?>" width="70px"/>
					<?php if($img_full_src!=$img_thumb_src){ ?>
						</a>
					<?php } ?>
				</div>
				<?php //armando las fotos de perfil
					if(getTableRow('*','images','id_user='.$userInfo['id'].' AND id_images_type=2')!='No-results'){
						echo generateAlbumView($userInfo['id'],$showEditImages,'PP_1','profile');
					}
					// FIN - armando las fotos de perfil
				?>
				<div class="bussinesCard">
					<?php if($showEditImages){ ?>
						<img class="imgWithMouseOverEfect" style="margin-bottom:-100px;margin-top:5px;margin-right:5px;"
							title="<?='Edit your Default Business Card'?>"
							src="img/menu_businessCard/edit.png"
							onclick="document.location.hash='#profile?sc=3&bc=<?=campo('business_card','id_user',$userInfo['id'],'md5(id)','AND type=0')?>';"/>
					<?php } ?>
					<?php
						$exclude=$noMenu=true;
						include('views/users/account/business_card/businessCard_dialog.view.php');
					?>
				</div>
				<div>
					<?php if($showEditImages){ ?>
						<img class="imgWithMouseOverEfect"
							title="<?='Edit your Profile'?>"
							src="img/menu_businessCard/edit.png"
							onclick="document.location.hash='#profile';"/>
					<?php } ?>
					<label><?=INVITEUSERS_FROM?> : </label><?=$userInfo['country']?><br/>
					<label><?=SIGNUP_LBLEMAIL?> : </label><?=$userInfo['email']?><br/>
					<?php echo ($userInfo[sex]!='')? '<label>'.SEX_TITLE.': </label> '.constant($userInfo['sex']):''; ?>
				</div>
				<div>
					<label><?=USERPROFILE_LBLHOMEPHONE." : "?></label><?=( $userInfo['home_phone'] ? $userInfo['home_phone'] : '---' )?>
				</div>
				<div>
					<label><?=USERPROFILE_LBLWORKPHONE." : "?></label><?=($userInfo['work_phone'] ? $userInfo['work_phone'] : '---')?>
				</div>
				<div>
					<label><?=USERPROFILE_LBLMOBILEPHONE." : "?></label><?=($userInfo['mobile_phone'] ? $userInfo['mobile_phone'] : '---')?>
				</div>
				<div class="preferences">
					<?php if($showEditImages){ ?>
						<div>
							<img class="imgWithMouseOverEfect"
								title="<?='Edit your Preferences'?>"
								src="img/menu_businessCard/edit.png"
								onclick="document.location.hash='#profile?sc=2'"/>
						</div>
					<?php }
					$titles=array(EXTERNALPROFILE_LIKES,EXTERNALPROFILE_NEEDS,EXTERNALPROFILE_WANTS);
					$i=0;
					$query=$GLOBALS['cn']->query("SELECT preference FROM users_preferences WHERE id_user = '".$userInfo['id']."'");
					while($detalles=mysql_fetch_assoc($query)){
						$detalles=($detalles['preference']!='' ? explode(',', $detalles['preference']) : array()); ?>
						<div></div>
						<div>
							<label> <?=$titles[$i]?> : </label>
							<?php if(count($detalles)>0){
							$print='';
							foreach($detalles as $preferencia){
								if(trim($preferencia)!=''){
									$detalle=$GLOBALS['cn']->query("SELECT detail FROM preference_details WHERE id='".$preferencia."'");
									if(mysql_num_rows($detalle)>0){
										$detalle=mysql_fetch_assoc($detalle);
										$detalle=$detalle['detail'];
									}else{
										$detalle=$preferencia;
									}
								}
								$print.=" - ".str_replace("\\","",$detalle);
							}
							echo substr($print,3);
						}else{ echo "---"; }?>
						</div>
						<?php
						if(++$i>2) break;
					} ?>
				</div>
				<div class="tags">
					<?php //EDITAR TAGS
						if($showEditImages){ ?>
						<div>
							<img class="imgWithMouseOverEfect"
								title="<?='Edit your Personal Tags'?>"
								src="img/menu_businessCard/edit.png"
								onclick="document.location.hash='#timeline?current=personalTags'"/>
						</div>
					<?php }
						include 'templates/tags/carousel.php';
					?>
					<script>
						$(function(){
							if(!isLogged()) $('.tag-container').addClass('noMenu');
							$$.ajax({
								type	:'GET',
								dataType:'json',
								url		:'controls/tags/tagsList.json.php?current=personalTags&uid=<?=$userInfo['id']?>',
								success	:function(data){
									if(data['tags']&&data['tags'].length>0){
										//$('.tag-container',container).html(showTags(data['tags'],false,false));
										showCarousel(data['tags'],$$('.tag-container'));
										if(data['tags'].length<2) $$('.tag-container').trigger('stop',true);
									}else{
										$('.tag-container').html(<?=NORESULT_TIMELINE?>);
									}
								}
							});
						});
					</script>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<!-- users tags -->
		<div class="externalProfileSeeMoreTags color-a">
			<?php
				$nTags = $GLOBALS['cn']->query('
					SELECT count(id) AS nTags
					FROM tags
					WHERE id_creator = "'.$userInfo['id'].'" AND
							id_user = id_creator AND
							status = 1
				');
				$nTags = mysql_fetch_assoc($nTags);
			?>
			<a href="<?=HREF_DEFAULT?>" action="tagsUser,<?=$nTags['nTags']?>,<?=$userInfo['screen_name']?>: Tags,<?=$userInfo['id']?>"><?=USER_BTNSEEMORE?></a>

		</div>
		<!-- end users tags -->
		<div class="clearfix"></div>
	</div>
	<?php }else{ ?>
		<script>
			document.location.hash='home';
		</script>
	<?php }  ?>
	<script type="text/javascript">
		$(function(){
			$('a.grouped_PP').fancybox({
				type			:'ajax',
				transitionIn	:'fade',
				transitionOut	:'elastic',
				title			:"<?=$userInfo['nameUser']?>'s Profile Pictures",
				onClosed		:function() {/*alert('aaa');*/}
			});
		});
		<?php if($_SESSION['ws-tags']['ws-user']['showPhotoGallery']){
			$_SESSION['ws-tags']['ws-user']['showPhotoGallery'] = false; ?>
			$('a.grouped_PP').click();
		<?php } ?>
	</script>

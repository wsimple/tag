<?php
global $section;
if($section && $section!='profile') $where = "username!='' AND username LIKE '$section'";
elseif ($_GET['uid']!='') { $where = "md5(id) = '".$_GET['uid']."'"; }
elseif ($_GET['userIdExternalProfile']!='') { $where = "md5(id) = '".$_GET['userIdExternalProfile']."'"; }
elseif(isset($_GET['usr'])){ $where = "username LIKE '".$_GET['usr']."'"; }
else{ $where = "id = ".$_SESSION['ws-tags']['ws-user']['id']; }

$sid=$_SESSION['ws-tags']['ws-user']['id']!=''?"'".$_SESSION['ws-tags']['ws-user']['id']."'":"id";
$query = $GLOBALS['cn']->query("
	SELECT
		id,
		email,
		home_phone,
		mobile_phone,
		work_phone,
		user_background,
		profile_image_url,
		username,
		type,
		screen_name,
		sex,
		CONCAT(name,' ',last_name) AS nameUser,
		md5(CONCAT(id,'_',email,'_',id)) AS code,
		(SELECT c.name FROM countries c WHERE c.id=country) AS country,
		(SELECT s.label FROM sex s WHERE s.id=sex) AS sex,
		followers_count,
		friends_count,
		(SELECT id_user FROM users_links WHERE id_friend=id AND id_user=".$sid." LIMIT 1) AS follower,
		(SELECT count(id) FROM tags WHERE id_creator = ".$sid." AND id_user = id_creator AND status = 1) AS nTags
	FROM users
	WHERE "
.$where);
if (mysql_num_rows($query)>0){
$array = mysql_fetch_assoc($query);
$edit='<div class="edit"></div>';
$edit=$array['id']==$_SESSION['ws-tags']['ws-user']['id']?$edit:false;
?>
<div id="externalProfile" class="ui-single-box">
	<div class="ui-single-box-title">
		<div class="photoProfile">
		<?php //Profile Picture
			$photoT=FILESERVER.getUserPicture($array['code'].'/'.$array['profile_image_url'],'img/users/default.png');
			$photoF=FILESERVER.'img/users/'.$array['code'].'/'.$array['profile_image_url'];
			if($photoF!=$photoT && $logged){ 
				$imgDetails='class="imgWithMouseOverEfect" title="'.EXTERNALPROFILE_VIEWPICTUREALBUM.'"';
		?>
				<a class="grouped_PP" rel="PP_1" onfocus="this.blur()"
					href="views/photos/picture.view.php?src=<?=$photoF?>&default&id_user=<?=$array['id']?>">
		<?php } ?>
					<img <?=$imgDetails?> src="<?=$photoT?>" width="70px"/>
		<?php if($photoF!=$photoT && $logged){ ?> </a> <?php } ?>
		</div>
		<?php if(numRecord('images','WHERE id_user='.$array['id'].' AND id_images_type=2')>0 && $logged){
				echo generateAlbumView($array['id'],$edit,'PP_1','profile');
			  } ?>
		<h3><?=formatoCadena($array['nameUser'].'\'s '.USERPROFILE_PERSONALINFO)?></h3>
		<a href="javascript:void(0)" id="seeBusiness" ><?=formatoCadena(SEE_BUSINESS_CARD)?></a>
		<?php if (!$edit && $logged){ ?>
			<div id="userProfileDialog" style="float:right;">
				<input type="button" id="btn_link_<?=md5($array['id'])?>" <?=$array['follower']?'style="display:none;margin-right:20px;"':''?> 
					action="linkUser,,<?=md5($array['id'])?>" value="<?=USER_BTNLINK?>"/>
				<input type="button" id="btn_unlink_<?=md5($array['id'])?>" <?=$array['follower']?'':'style="display:none;margin-right:20px;"'?> 
					action="linkUser,,<?=md5($array['id'])?>,animate" value="<?=USER_BTNUNLINK?>"/>
			</div>
		<?php } ?>
	</div>	
	<div id="eProfileInfo">
		<article id="externalProfileInfo" class="side-box imagenSug">
			<?=$edit?$edit:''?>
			<header><span style="background-image: url('<?=$photoT?>');"><?=INFO_PER?></span></header>
			<div>
				<ul>
					<li><label><?=SIGNUP_LBLSCREENNAME_FIELD?>: </label><?=$array['screen_name']?></li>
					<li><label><?=SIGNUP_LBLEMAIL?>: </label><?=$array['email']?></li>
					<li><label><?=INVITEUSERS_FROM?>: </label><?=$array['country']?></li>
					<li><label><?=USER_LBLFOLLOWERS.' (</label>'.$array['followers_count'].'<label>) - '.USER_LBLFRIENDS.' (</label>'.$array['friends_count'].'<label>)'?></label></li>
					<?php if($array['type']=='0'){ ?>
					<li><label><?=USERPROFILE_LBLHOMEPHONE?>: </label><?=($array['home_phone']?$array['home_phone']:'---')?></li>
					<?php } ?>
					<li><label><?=USERPROFILE_LBLWORKPHONE?>: </label><?=($array['work_phone']?$array['work_phone']:'---')?></li>
					<li><label><?=USERPROFILE_LBLMOBILEPHONE?>: </label><?=($array['mobile_phone']?$array['mobile_phone']:'---')?></li>
					<!--li><a href="#">My Business card</a></li-->
				</ul>
			</div>
			<div class="clearfix"></div>
		</article>
		<article id="externalProfilePrefe" class="side-box imagenSug">
			<?=$edit?$edit:''?>
			<header><span><?=USERPROFILE_PREFERENCES?></span></header>
			<div>
				<ul>
			   		<?php 
						$titles=array(EXTERNALPROFILE_LIKES,EXTERNALPROFILE_NEEDS,EXTERNALPROFILE_WANTS);
						$i=0;$queprueba='';
						$query=$GLOBALS['cn']->query("SELECT preference FROM users_preferences WHERE id_user = '".$array['id']."'");
						if (mysql_num_rows($query)>0){
							while($detalles=mysql_fetch_assoc($query)){ ?> 
								  <li></a><label> <?=$titles[$i]?> : </label>
						<?php	   if($detalles['preference']!=''){ $links='';$strIN='';
										foreach(explode(',',$detalles['preference']) as $value){
											$strIN.=($strIN==''?"'":"','").$value;
										}
										$strIN.="'";
										$detalle=$GLOBALS['cn']->query("SELECT detail,id FROM preference_details WHERE id IN (".$strIN.");");
										if (mysql_num_rows($detalle)>0){
											while($row=mysql_fetch_assoc($detalle)){
												$detalles['preference']=str_replace($row['id'],"",$detalles['preference']);
												$detalles['preference'].=($detalles['preference']==''?'':',').$row['detail'];
											}
										}
										$detalles['preference']=explode(',',$detalles['preference']);
										for ($e=0;$e<count($detalles['preference']);$e++)
											if($detalles['preference'][$e]!='') $links.=($links==''?'':' - ').'<a href="'.base_url('searchall?srh='.preg_replace('/ +/','%20',$detalles['preference'][$e])).'">'.$detalles['preference'][$e].'</a>';
										echo $links;
								}else{ echo "---"; } ?>
								</li>
						<?php  if(++$i>2) break;
						   }  
					   }else{ for($i=0;$i<=2;$i++) echo '<li><label>'.$titles[$i].'</label>: ---</li>'; }
					?>
				</ul>
			</div>
			<div class="clearfix"></div>
		</article>
		<div class="clearfix"></div>
	</div>
	<div id="eProfileTag" class="tags">
		<?php echo $edit?$edit:'';
		include 'templates/tags/carousel.php'; 
		if ($array['nTags']>0){ ?>
		<a href="<?=HREF_DEFAULT?>" action="personalTags,5,<?=$array['id']?>"><?=USER_BTNSEEMORE?></a>
		<div class="clearfix"></div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		if(!isLogged()) $('.tag-container').addClass('noMenu');
		else 
			$('a.grouped_PP').fancybox({
				type			:'ajax',
				transitionIn	:'fade',
				transitionOut	:'elastic',
				title			:"<?=$array['nameUser']?>'s <?=USERPROFILE_PHOTOPROFILE?>",
				onClosed		:function() {/*alert('aaa');*/}
			});
		$$.ajax({
			type	:'GET',
			dataType:'json',
			url		:'controls/tags/tagsList.json.php?current=personalTags&uid=<?=$array['id']?>',
			success	:function(data){
				if(data['tags']&&data['tags'].length>0){
					showCarousel(data['tags'],$$('.tag-container'));
					if(data['tags'].length<2) $$('.tag-container').trigger('stop',true);
				}else{ $('.tag-container').html('<div class="messageNoResultSearch more"><?=NORESULT_TIMELINE?></div>'); }
			}
		});

		$('#seeBusiness').click(function(){
			$.dialog({
					id:'default',
					title: '<?=USERPROFILE_LINKSHOWBUSINESSCARD?>',
					width: 400,
					height: 270,
					content:'<div class="bussinesCard"></div>',
					open		: function() {
						$(this).load('views/users/account/business_card/businessCard_dialog.view.php?uid=<?=md5($array['id'])?>');
					}
				});
		});
		$('.edit').click(function(){
			var id=$(this).parents('[id]').attr('id'),destino='';
			switch(id){
				case 'eProfileTag':			 destino='timeline?current=personalTags'; break;
				case 'externalProfilePrefe':	destino='profile?sc=2'; break;
				case 'externalProfileInfo':	 destino='profile'; break;
			}
			if (destino!='') redir(destino);
		});
	});
</script>
<?php }else{ ?>
<script type="text/javascript">
	redir('');
</script>
<?php } ?>

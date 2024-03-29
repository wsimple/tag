<?php
global $section,$params;

$myId=$_SESSION['ws-tags']['ws-user']['id']!=''?$_SESSION['ws-tags']['ws-user']['id']:0;
if(isset($_GET['sc']) && $_GET['sc']=='6'){
	if(isset($_GET['userIdExternalProfile'])) $where="md5(u.id)='".$_GET['userIdExternalProfile']."'";
	else $where = "u.id = $myId";
}elseif($_GET['uid']!=''){ $where="md5(u.id)='".intToMd5($_GET['uid'])."'"; }
elseif($_GET['userIdExternalProfile']!='') { $where="md5(u.id)='".$_GET['userIdExternalProfile']."'"; }
elseif(isset($_GET['usr'])){ $where="u.username LIKE '".$_GET['usr']."'"; }
elseif($section=='user'||$section=='profile'){
	if($params[0]!='' && strlen($params[0])==32) $where="md5(u.id)='".$params[0]."'";
	else $where="id=$myId";
}elseif($section!='') $where="u.username!='' AND u.username LIKE '$section'";
else{ $where="id=$myId"; }

//echo $myId.'--'.$_SESSION['ws-tags']['ws-user']['id'];
$query=CON::query("
	SELECT
		u.id,
		u.email,
		u.home_phone,
		u.mobile_phone,
		u.work_phone,
		u.user_background,
		u.profile_image_url,
		u.username,
		u.type,
		u.screen_name,
		u.sex,
		u.url,
		u.personal_messages,
		u.user_cover,
		CONCAT(u.name,' ',u.last_name) AS nameUser,
		md5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code,
		(SELECT c.name FROM countries c WHERE c.id=u.country) AS country,
		(SELECT s.label FROM sex s WHERE s.id=u.sex) AS sex,
		u.followers_count,
		u.following_count,
		(SELECT id_user FROM users_links WHERE id_friend=u.id AND id_user=$myId LIMIT 1) as follower,
		(SELECT count(id) FROM tags WHERE id_creator=$myId AND id_user=id_creator AND status=1) AS nTags
	FROM users u
	WHERE $where
");
if(CON::numRows($query)>0){
	if(is_debug('user')) echo CON::lastSql();

$obj=CON::fetchObject($query);
if(is_debug('profile')) echo str_replace(',"',',<br>"',json_encode($obj));
$edit='<div class="edit"></div>';
$edit=$obj->id==$_SESSION['ws-tags']['ws-user']['id']?$edit:false;
$styleCon=!$logged?'style="margin-left:100px;"':'';
?>
<?php include('views/users/progress.php'); ?>
<div id="externalProfile" class="ui-single-box" <?=$styleCon?>>
	<div id="coverExpro" style="<?= $obj->user_cover!=''?"background-image: url('".FILESERVER."img/users_cover/".$obj->user_cover."');":''; ?> height:196px;width:846px;position:absolute;top:0;left:0;">
		<div class="ui-single-box-title">
			<div class="photoProfile" id="photoProfileChange"><?=$edit?$edit:''?>
				<form action="controls/users/profile.json.php?action=picture" id="frmChangePhoto" name="frmChangePhoto" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
					<input type="hidden" id="validaActionAjax" name="validaActionAjax" value="save"/>
					<div id="frmProfile_changePhotoDiv">
						<input name="frmProfile_filePhoto" type="file" id="frmProfile_filePhoto"/>
					</div>
				</form>
				<?php //Profile Picture
				$photoT=FILESERVER.getUserPicture("$obj->code/$obj->profile_image_url",'img/users/default.png');
				$photoF=FILESERVER."img/users/$obj->code/$obj->profile_image_url";
				if($photoF!=$photoT && $logged){
					$imgDetails='class="imgWithMouseOverEfect" title="'.lan('EXTERNALPROFILE_VIEWPICTUREALBUM').'"';
				?>
				<a href="views/photos/picture.view.php?src=<?=$photoF?>&default&id_user=<?=$obj->id?>" class="grouped_PP" rel="PP_1"/>
				<?php } ?>
				<img <?=$imgDetails?> src="<?=$photoT?>" width="70px"/>
				<?php if($photoF!=$photoT && $logged){ ?> </a> <?php } ?>
			</div>
			<?php if(numRecord('images',"WHERE id_user=$obj->id AND id_images_type=2")>0 && $logged){
					echo generateAlbumView($obj->id,$edit,'PP_1','profile');
			} ?>
			<h3 style="text-shadow:4px 4px 7px #000; color:#fff"><?=formatoCadena("$obj->nameUser's ".lan('USERPROFILE_PERSONALINFO'))?></h3>
			<a href="javascript:void(0)" id="seeBusiness" style="text-shadow:4px 4px 7px #000; color:#fff"><?=formatoCadena(lan('SEE_BUSINESS_CARD'))?></a>
			<?php if (!$edit && $logged){ ?>
			<div id="userProfileDialog" style="float:right; margin-top: 43px">
				<input type="button" <?=$obj->follower?'style="display:none;"':''?> action="linkUser,<?=md5($obj->id)?>" value="<?=lan('USER_BTNLINK')?>"/>
				<input type="button" <?=$obj->follower?'':'style="display:none;"'?>  action="linkUser,<?=md5($obj->id)?>" value="<?=lan('USER_BTNUNLINK')?>" class="btn btn-disabled"/>
			</div>
			<?php } ?>
			<div id="coverExternalProfile">
				<?=$edit?$edit:''?>
				<form action="controls/users/profile.json.php?action=fileCover" id="frmChangeCover" name="frmChangeCover" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
					<input type="hidden" id="validaActionAjax" name="validaActionAjax" value="fileCover"/>
					<div id="frmProfile_changeCoverDiv">
						<input name="frmProfile_fileCover" type="file" id="frmProfile_fileCover"/>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?=generateDivMessaje('divSuccess','250',lan('NEWTAG_CTRMSGDATASAVE'))?>
	<?=generateDivMessaje('divError','300',lan('USERPROFILE_ERROR_SAVING'),false)?>
	<div id="eProfileInfo">
		<div style="float:left;width:380px;">
			<article id="externalProfileInfo" class="side-box imagenSug">
				<header><span><?=lan('INFO_PER')?></span><?=$edit?$edit:''?></header>
				<div>
					<ul>
						<li class="tituloName"><?=$obj->screen_name?></li>
						<?php
							echo ($obj->personal_messages!='')?'<li class="infoPerExter color">'.$obj->personal_messages.'</li>':'';
						?>
						<!-- <li style="padding:3px 0"><?=''//$obj->email?></li> -->
						<?php
							echo ($obj->country!='')?'<li class="infoPerExter">'.$obj->country.'</li>':'';
							echo ($obj->url!='')?'<li class="peddingEx"><a target="_blank" href="'.$obj->url.'">'.$obj->url.'</a></li>':'';
						?>
						<li >
									<strong><?=lan('USER_LBLFOLLOWERS')?>: </strong>
									<input userF="followers" type="button" id="followers" value="<?=mskPoints($obj->followers_count)?>"/>
									<strong><?=lan('USER_LBLFRIENDS')?>: </strong>
									<input userF="followed" type="button" id="followed" value="<?=mskPoints($obj->following_count)?>"/>
						</li>
						<?php 

							$patern='/^(?:\+?(\d{1,3}))?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i';


								if($obj->type=='0'&&preg_match($patern,$obj->home_phone)){
									echo '<li><label>'.lan("USERPROFILE_LBLHOMEPHONE").': </label><a href="tel:'.$obj->home_phone.'">'.$obj->home_phone.'</a></li>';
							  	}
								if(preg_match($patern,$obj->work_phone)){
									echo '<li><label>'.lan('USERPROFILE_LBLWORKPHONE').': </label><a href="tel:'.$obj->work_phone.'">'.$obj->work_phone.'</a></li>';
								}	
								if(preg_match($patern,$obj->mobile_phone)){
									echo '<li><label>'.lan('USERPROFILE_LBLMOBILEPHONE').': </label><a href="tel:'.$obj->mobile_phone.'">'.$obj->mobile_phone.'</a></li>';
								}	
						?>

					</ul>
				</div>
				<div class="clearfix"></div>
			</article>
			<article id="externalProfilePrefe" class="side-box imagenSug">
				<header><span style="background-image: url('css/tbum/box-title/preferences.png')"><?=lan('USERPROFILE_PREFERENCES')?></span><?=$edit?$edit:''?></header>
				<div>
					<ul>
						<?php
							$titles=array(null,lan('EXTERNALPROFILE_LIKES'),lan('EXTERNALPROFILE_WANTS'),lan('EXTERNALPROFILE_NEEDS'));
							$prefe=users_preferences($obj->id);
							if(count($prefe)){
								for($i=1;$i<4;$i++){
									if(!isset($prefe[$i])) continue;
								?>
								<li  ><label ><?=$titles[$i].':'?></label>
								<?php
									foreach($prefe[$i] as $key=>$value)
									if($logged): ?>
										<a class="externalPre" href="<?=base_url('searchall?srh='.preg_replace('/ +/','%20',$value->text))?>"><?=$value->text?></a>
									<?php else: ?>
										<a class="externalPre"><?=$value->text?></a>
									<?php endif; ?>
								</li><br>
						<?php	}
							}else echo lan('SOONEXTERPREFERENCES').' '.formatoCadena("$obj->nameUser").' '.lan('SOONEXTERPREFERENCES2');
						?>
					</ul>
				</div>
				<div class="clearfix"></div>
			</article>
		</div>
		<div id="taglist-box" class="tags mini side-box imagenSug">
			<header><span style="background-image: url('css/tbum/box-title/tags.png')"><?=lan('MAINMNU_HOME')?></span></header>
			<?php //echo $edit?$edit:'';?>
			<div class="tags-list">
				<div class="tag-container"></div>
				<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="display:none;"/>
			</div>
			<div class="clearfix"></div>
			<!-- include 'templates/tags/carousel.php';  -->
			<?php if($logged){ ?>
			<div style="text-align: center">
				<a href="<?=lan('HREF_DEFAULT')?>" class="color-pro" action="tagsUser,1,'',<?=md5($obj->id)?>"><?=lan('ALL_TAGS')?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="<?=lan('HREF_DEFAULT')?>" class="color-pro" action="personalTags,5,<?=md5($obj->id)?>">
				<?=lan('MAINMNU_PERSONALTAGS')?>
				</a>
			</div>
			<div class="clearfix"></div>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	if(!isLogged()){
		$('wrapper').css('width','947px');
		$('.tag-container').addClass('noMenu');
	}else
		$('a.grouped_PP').fancybox({
			type:'ajax',
			transitionIn:'fade',
			transitionOut:'elastic',
			scrolling:'no',
			title:"<?=$obj->nameUser?>'s <?=USERPROFILE_PHOTOPROFILE?>"
		});

		var $box=$('#taglist-box').last(),
			//ns='.tagsList',//namespace
			layer=$box.find('.tag-container')[0],
			opc={
				limit:'8',
				current:'myTags',
				layer:layer
			};
			opc['get']='&uid=<?=md5($obj->id)?>';
		$.on({
			open:function(){
				updateTags('reload',opc);
			},
			close:function(){
				$('#taglist-box').removeClass('mini');
				$(window).off(ns);
				$box.off();
				clearInterval(interval);
			}
		});

	$('#seeBusiness').click(function(){
		// console.log('<?=md5($obj->id)?>');
		$.dialog({
			id:'default',
			title:'<?=USERPROFILE_LINKSHOWBUSINESSCARD?>',
			width:400,
			height:270,
			content:'<div class="bussinesCard"></div>',
			open:function(){
				$(this).load('views/users/account/business_card/businessCard_dialog.view.php?uid=<?=md5($obj->id)?>');
			}
		});
	});
	$('.edit').click(function(){
		var id=$(this).parents('[id]').attr('id'),destino='';
		switch(id){
			case 'eProfileTag':			destino='timeline?current=personalTags'; break;
			case 'externalProfilePrefe':destino='profile?sc=2'; break;
			case 'externalProfileInfo':	destino='profile'; break;
			case 'photoProfileChange':	$('#frmProfile_filePhoto').click(); break;
			case 'coverExternalProfile':$('#frmProfile_fileCover').click(); break; /*alert('change Cover'); break;*/
		}
		if (destino!='') redir(destino);
	});

	$('#frmProfile_filePhoto').bind('change',function(){
		if ($(this).val()!=''){
			$("#validaActionAjax").val("filePhoto");
			$('loader.page',PAGE).show();
			$("#frmChangePhoto").submit();
		}
	});

	$('#frmProfile_fileCover').bind('change',function(){
		if ($(this).val()!=''){
			$('loader.page',PAGE).show();
			$("#frmChangeCover").submit();
		}
	});

	$('#frmChangePhoto,#frmChangeCover').ajaxForm({
		dataType:'json',
		success:function(data){
			$('loader.page',PAGE).hide();
			if (!data['error']){
				console.log(data['success']);
				switch(data['success']){
					// case 'updateLanguage': location.reload(); break;
					case 'filePhoto': redir('user/mini?ep'); break;
					// case 'backg': $('body').css('background',data['backg']); break;
					case 'cover': $('#coverExpro').css('background-image', 'url("<?=FILESERVER?>img/users_cover/'+data['cover']+'")'); break;
					// case 'pbackg':  
					// 	$('#profileHiddenColor').val('#fff');
					// 	<?php if ($config->local){ ?>
					// 	$('body').css('background','')
					// 	.css('background-image', 'url('+(DOMINIO)+'img/users_backgrounds/'+data['backg']+')');
					// 	<?php }else{ ?>
					// 	$('body').css('background','')
					// 	.css('background-image', 'url('+(SERVERS.img)+'img/users_backgrounds/'+data['backg']+')');
					// 	<?php } ?>
					// break;
					default: showAndHide('divSuccess','divSuccess',1500,true); break;
				}
			}else{ 
				$('#divError').html(data['error']);
				showAndHide('divError','divError',1500,true);
			}
		}
	});
});
$('#externalProfileInfo li input[userF]').click(function(){
		if ($(this).val().replace(/K|M|car/gi,'')*1>0){
			var title=$(this).attr('id')=='followers'?'<?=USER_LBLFRIENDS?>':'<?=USER_LBLFOLLOWERS?>';
			friendsUser('<?=$obj->screen_name?>: '+title,'<?=md5($obj->id)?>',$(this).attr('id'));
		}
	});
</script>
<?php
}else{ $bodyPage='main/failure.php'; }

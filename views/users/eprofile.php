<?php
global $section,$params;
// if($section && $section!='profile') $where = "username!='' AND username LIKE '$section'";
// elseif ($_GET['uid']!='') { $where = "md5(id) = '".$_GET['uid']."'"; }
// elseif ($_GET['userIdExternalProfile']!='') { $where = "md5(id) = '".$_GET['userIdExternalProfile']."'"; }
// elseif(isset($_GET['usr'])){ $where = "username LIKE '".$_GET['usr']."'"; }
// else{ $where = "id = ".$_SESSION['ws-tags']['ws-user']['id']; }

if(isset($_GET['sc']) && $_GET['sc']=='6'){
	if (isset($_GET['userIdExternalProfile'])) $where = "md5(id) = '".$_GET['userIdExternalProfile']."'";
	else $where = "id = ".$_SESSION['ws-tags']['ws-user']['id'];
}elseif ($_GET['uid']!='') { $where = "md5(id) = '".intToMd5($_GET['uid'])."'"; }
elseif ($_GET['userIdExternalProfile']!='') { $where = "md5(id) = '".$_GET['userIdExternalProfile']."'"; }
elseif(isset($_GET['usr'])){ $where = "username LIKE '".$_GET['usr']."'"; }
elseif($section=='user'||$section=='profile'){
	if($params[0]!='' && strlen($params[0])==32) $where="md5(id)='".$params[0]."'";
	else $where='id='.$_SESSION['ws-tags']['ws-user']['id'];
}elseif($section!='') $where = "username!='' AND username LIKE '$section'";
else{ $where='id='.$_SESSION['ws-tags']['ws-user']['id']; }
$sid=$_SESSION['ws-tags']['ws-user']['id']!=''?"'".$_SESSION['ws-tags']['ws-user']['id']."'":"id";
$query = CON::query("
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
	WHERE $where
");
if(CON::numRows($query)>0){
	if(is_debug('user')) echo CON::lastSql();
// $array = CON::fetchArray($query);
$obj=CON::fetchObject($query);
$edit='<div class="edit"></div>';
$edit=$obj->id==$_SESSION['ws-tags']['ws-user']['id']?$edit:false;
?>
<div id="externalProfile" class="ui-single-box">
	<div class="ui-single-box-title">
		<div class="photoProfile">
		<?php //Profile Picture
			$photoT=FILESERVER.getUserPicture("$obj->code/$obj->profile_image_url",'img/users/default.png');
			$photoF=FILESERVER."img/users/$obj->code/$obj->profile_image_url";
			if($photoF!=$photoT && $logged){ 
				$imgDetails='class="imgWithMouseOverEfect" title="'.EXTERNALPROFILE_VIEWPICTUREALBUM.'"';
		?>
			<a href="views/photos/picture.view.php?src=<?=$photoF?>&default&id_user=<?=$obj->id?>" class="grouped_PP" rel="PP_1"/>
		<?php } ?>
			<img <?=$imgDetails?> src="<?=$photoT?>" width="70px"/>
		<?php if($photoF!=$photoT && $logged){ ?> </a> <?php } ?>
		</div>
		<?php if(numRecord('images',"WHERE id_user=$obj->id AND id_images_type=2")>0 && $logged){
				echo generateAlbumView($obj->id,$edit,'PP_1','profile');
		} ?>
		<h3><?=formatoCadena("$obj->nameUser's ".USERPROFILE_PERSONALINFO)?></h3>
		<a href="javascript:void(0)" id="seeBusiness"><?=formatoCadena(SEE_BUSINESS_CARD)?></a>
		<?php if (!$edit && $logged){ ?>
			<div id="userProfileDialog" style="float:right;">
				<input type="button" id="btn_link_<?=md5($obj->id)?>" <?=$obj->follower?'style="display:none;margin-right:20px;"':''?>
					action="linkUser,,<?=md5($obj->id)?>" value="<?=USER_BTNLINK?>"/>
				<input type="button" id="btn_unlink_<?=md5($obj->id)?>" <?=$obj->follower?'':'style="display:none;margin-right:20px;"'?> 
					action="linkUser,,<?=md5($obj->id)?>,animate" value="<?=USER_BTNUNLINK?>"/>
			</div>
		<?php } ?>
	</div>
	<div id="eProfileInfo">
		<article id="externalProfileInfo" class="side-box imagenSug">
			<header><span><?=INFO_PER?></span><?=$edit?$edit:''?></header>
			<div>	
				<ul>
					<li><label><?=SIGNUP_LBLSCREENNAME_FIELD?>: </label><?=$obj->screen_name?></li>
					<li><label><?=SIGNUP_LBLEMAIL?>: </label><?=$obj->email?></li>
					<li><label><?=INVITEUSERS_FROM?>: </label><?=$obj->country?></li>
					<li><label><?=USER_LBLFOLLOWERS." (</label>$obj->followers_count<label>) - ".USER_LBLFRIENDS." (</label>$obj->friends_count<label>)"?></label></li>
					<?php if($obj->type=='0'){ ?>
					<li><label><?=USERPROFILE_LBLHOMEPHONE?>: </label><?=($obj->home_phone?$obj->home_phone:'---')?></li>
					<?php } ?>
					<li><label><?=USERPROFILE_LBLWORKPHONE?>: </label><?=($obj->work_phone?$obj->work_phone:'---')?></li>
					<li><label><?=USERPROFILE_LBLMOBILEPHONE?>: </label><?=($obj->mobile_phone?$obj->mobile_phone:'---')?></li>
					<!--li><a href="#">My Business card</a></li-->
				</ul>
			</div>
			<div class="clearfix"></div>
		</article>
		<article id="externalProfilePrefe" class="side-box imagenSug">
			<header><span><?=USERPROFILE_PREFERENCES?></span><?=$edit?$edit:''?></header>
			<div>
				<ul>
			   		<?php 
						$titles=array(EXTERNALPROFILE_LIKES,EXTERNALPROFILE_NEEDS,EXTERNALPROFILE_WANTS);
						$i=0;$queprueba='';
						$query=CON::query("SELECT preference FROM users_preferences WHERE id_user='$obj->id'");
						if(CON::numRows($query)>0){
							while($detalles=CON::fetchObject($query)){ ?> 
								  <li></a><label> <?=$titles[$i]?> : </label>
						<?php	   if($detalles->preference!=''){ $links='';$strIN='';
										foreach(explode(',',$detalles->preference) as $value){
											$strIN.=($strIN==''?"'":"','").$value;
										}
										$strIN.="'";
										$detalle=CON::query("SELECT detail,id FROM preference_details WHERE id IN (".$strIN.");");
										if (CON::numRows($detalle)>0){
											while($row=CON::fetchObject($detalle)){
												$detalles->preference=str_replace($row->id,"",$detalles->preference);
												$detalles->preference.=($detalles->preference==''?'':',').$row->detail;
											}
										}
										$detalles->preference=explode(',',$detalles->preference);
										for ($e=0;$e<count($detalles->preference);$e++)
											if($detalles->preference[$e]!='') $links.=($links==''?'':' - ').'<a href="'.base_url('searchall?srh='.preg_replace('/ +/','%20',$detalles->preference[$e])).'">'.$detalles->preference[$e].'</a>';
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
		if ($obj->nTags>0){ ?>
		<a href="<?=HREF_DEFAULT?>" action="personalTags,5,<?=$obj->id?>"><?=USER_BTNSEEMORE?></a>
		<div class="clearfix"></div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
$(function(){
	if(!isLogged()) $('.tag-container').addClass('noMenu');
	else
		$('a.grouped_PP').fancybox({
			type:'ajax',
			transitionIn:'fade',
			transitionOut:'elastic',
			title:"<?=$obj->nameUser?>'s <?=USERPROFILE_PHOTOPROFILE?>",
			onClosed:function() {/*alert('aaa');*/}
		});
	$$.ajax({
		type:'GET',
		dataType:'json',
		url:'controls/tags/tagsList.json.php?current=personalTags&uid=<?=$obj->id?>',
		success:function(data){
			if(data['tags']&&data['tags'].length>0){
				showCarousel(data['tags'],$$('.tag-container'));
				if(data['tags'].length<2) $$('.tag-container').trigger('stop',true);
			}else{ 
				$$.ajax({
					type:'GET',
					dataType:'json',
					url:'controls/tags/tagsList.json.php?current=myTags&uid=<?=$obj->id?>',
					success:function(data){
						if(data['tags']&&data['tags'].length>0){
							showCarousel(data['tags'],$$('.tag-container'));
							if(data['tags'].length<2) $$('.tag-container').trigger('stop',true);
						}else{ $('.tag-container').html('<div class="messageNoResultSearch more"><?=NORESULT_TIMELINE?></div>'); }
					}
				});				
			}
		}
	});

	$('#seeBusiness').click(function(){
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
			case 'eProfileTag':			 destino='timeline?current=personalTags'; break;
			case 'externalProfilePrefe':	destino='profile?sc=2'; break;
			case 'externalProfileInfo':	 destino='profile'; break;
		}
		if (destino!='') redir(destino);
	});
});
</script>
<?php
}else{
	$bodyPage='main/failure.php';
}

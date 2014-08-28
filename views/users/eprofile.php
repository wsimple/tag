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
$sid=$_SESSION['ws-tags']['ws-user']['id']!=''?$_SESSION['ws-tags']['ws-user']['id']:"id";

//echo $sid.'--'.$_SESSION['ws-tags']['ws-user']['id'];
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
		url,
		personal_messages,
		user_cover,
		CONCAT(name,' ',last_name) AS nameUser,
		md5(CONCAT(id,'_',email,'_',id)) AS code,
		(SELECT c.name FROM countries c WHERE c.id=country) AS country,
		(SELECT s.label FROM sex s WHERE s.id=sex) AS sex,
		followers_count,
		friends_count,
		(SELECT id_user FROM users_links WHERE id_friend=id AND id_user=".$sid." LIMIT 1) as follower,
		(SELECT count(id) FROM tags WHERE id_creator = ".$sid." AND id_user = id_creator AND status = 1) AS nTags
	FROM users
	WHERE $where
");

if(CON::numRows($query)>0){
	if(is_debug('user')) echo CON::lastSql();

$obj=CON::fetchObject($query);
$edit='<div class="edit"></div>';
$edit=$obj->id==$_SESSION['ws-tags']['ws-user']['id']?$edit:false;
$styleCon = !$logged?'style="margin-left: 100px;"':'';

$follo = $GLOBALS['cn']->query("SELECT id_user FROM users_links WHERE id_friend='".$obj->id."' AND id_user='".$sid."' LIMIT 1");

$follower = mysql_fetch_array($follo);
if (isset($follower['id_user'])) {
	$is = $follower['id_user'];
}
// echo 'idSe: '.$sid.' idExt: '.$obj->id.' follower: '.$obj->follower.', is: '.$is;
?>
<div id="externalProfile" class="ui-single-box" <?=$styleCon?>>
	<div id="coverExpro" style="background-image: url('<?=FILESERVER?>img/users_cover/<?=$obj->user_cover?>');height: 196px;width: 846px;position: absolute;top: 0;left: 0;">
		<div class="ui-single-box-title">
			<div class="photoProfile" id="photoProfileChange"><?=$edit?$edit:''?>
				<form action="?current=updateProfile" id="frmChangePhoto" name="frmChangePhoto" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
					<input type="hidden" id="actionAjax" name="actionAjax"/>
					<input type="hidden" id="validaActionAjax" name="validaActionAjax" value="save"/>
					<div id="frmProfile_changePhotoDiv">
						<input name="frmProfile_filePhoto" type="file" id="frmProfile_filePhoto"/>
					</div>
				</form>
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
			<h3 style="text-shadow:4px 4px 7px #000; color:#fff"><?=formatoCadena("$obj->nameUser's ".USERPROFILE_PERSONALINFO)?></h3>
			<a href="javascript:void(0)" id="seeBusiness" style="text-shadow:4px 4px 7px #000; color:#fff"><?=formatoCadena(SEE_BUSINESS_CARD)?></a>
			<?php if (!$edit && $logged){ ?>
			<div id="userProfileDialog" style="float:right; margin-top: 43px">
				<input type="button" id="btn_link_<?=md5($obj->id)?>" <?=$is?'style="display:none;"':''?>
					action="linkUser,,<?=md5($obj->id)?>" value="<?=USER_BTNLINK?>"/>
				<input type="button" id="btn_unlink_<?=md5($obj->id)?>" <?=$is?'':'style="display:none;"'?> 
					action="linkUser,,<?=md5($obj->id)?>,animate" value="<?=USER_BTNUNLINK?>"/>
			</div>
			<?php } ?>
			<div id="coverExternalProfile">
				<?=$edit?$edit:''?>
				<form action="?current=updateProfile" id="frmChangeCover" name="frmChangeCover" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
					<input type="hidden" id="validaActionAjax" name="validaActionAjax" value="fileCover"/>
					<div id="frmProfile_changeCoverDiv">
						<input name="frmProfile_fileCover" type="file" id="frmProfile_fileCover"/>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="eProfileInfo">
		<div style="float: left;width: 380px;">
			<article id="externalProfileInfo" class="side-box imagenSug">
				<header><span><?=INFO_PER?></span><?=$edit?$edit:''?></header>
				<div>	
					<ul>
						<li class="tituloName"><?=$obj->screen_name?></li>
						<?php 
							echo ($obj->personal_messages!='')?'<li class="infoPerExter color">'.$obj->personal_messages.'</li>':'';
						?>
						<li style="padding:3px 0"><?=$obj->email?></li>
						<?php 
							echo ($obj->country!='')?'<li class="infoPerExter">'.$obj->country.'</li>':'';

							echo ($obj->url!='')?'<li class="peddingEx"><a target="_blank" href="'.$obj->url.'">'.$obj->url.'</a></li>':'';
						?>

						<li><label><?=USER_LBLFOLLOWERS." (</label>$obj->followers_count<label>) - ".USER_LBLFRIENDS." (</label>$obj->friends_count<label>)"?></label></li>
						<?php if($obj->type=='0'){ 
							echo ($obj->home_phone!=''&&$obj->home_phone!='-')?'<li><label>'.USERPROFILE_LBLHOMEPHONE.': </label>'.$obj->home_phone.'</li>':'';
						} 
						echo ($obj->work_phone!=''&&$obj->work_phone!='-')?'<li><label>'.USERPROFILE_LBLWORKPHONE.': </label>'.$obj->work_phone.'</li>':'';

						echo ($obj->mobile_phone!=''&&$obj->mobile_phone!='-')?'<li><label>'.USERPROFILE_LBLMOBILEPHONE.': </label>'.$obj->mobile_phone.'</li>':'';
						?>
					</ul>
				</div>
				<div class="clearfix"></div>
			</article>
			<article id="externalProfilePrefe" class="side-box imagenSug">
				<header><span style="background-image: url('css/tbum/box-title/preferences.png')"><?=USERPROFILE_PREFERENCES?></span><?=$edit?$edit:''?></header>
				<div>
					<ul>
				   		<?php 
							$titles=array(EXTERNALPROFILE_LIKES,EXTERNALPROFILE_NEEDS,EXTERNALPROFILE_WANTS);
							$i=0; 
							$query=CON::query("SELECT preference FROM users_preferences WHERE id_user='$obj->id'");
							if(CON::numRows($query)>0){
								while($detalles=CON::fetchObject($query)){  ?> 
									  <li>
							<?php	   if($detalles->preference!=''){ $links='';$strIN='';
											foreach(explode(',',$detalles->preference) as $value){
												$strIN.=($strIN==''?"'":"','").$value;
											}
											$strIN.="'";
											$detalle=CON::query("SELECT detail,id FROM preference_details WHERE id IN (".$strIN.");");
											echo '<label>'.$titles[$i].' : </label>';
											if (CON::numRows($detalle)>0){

												while($row=CON::fetchObject($detalle)){
													$detalles->preference=str_replace($row->id,"",$detalles->preference);
													$detalles->preference.=($detalles->preference==''?'':',').$row->detail;
												}
											}
											$detalles->preference=explode(',',$detalles->preference);
											for ($e=0;$e<count($detalles->preference);$e++)
												if($detalles->preference[$e]!='') $links.=($links==''?'':' , ').''.($logged?'<a class="externalPre" href="'.base_url('searchall?srh='.preg_replace('/ +/','%20',$detalles->preference[$e])).'">'.$detalles->preference[$e].'</a>':'<a class="externalPre">'.$detalles->preference[$e].'</a>');
											echo $links;
									}else{ echo ""; } ?>
									</li><br>
							<?php  if(++$i>2) break;
							   }  
						    }else{ //for($i=0;$i<=2;$i++) echo '<li><label>'.$titles[$i].'</label>: ---</li><br>'; 
						    	echo SOONEXTERPREFERENCES.' '.formatoCadena("$obj->nameUser").' '.SOONEXTERPREFERENCES2;
							}
						?>
					</ul>
				</div>
				<div class="clearfix"></div>
			</article>
		</div>
		<div id="taglist-box" class="tags mini side-box imagenSug" >
			<header><span style="background-image: url('css/tbum/box-title/tags.png')"><?=MAINMNU_HOME?></span></header>
			<?php //echo $edit?$edit:'';?>
			<div class="tags-list">
				<div class="tag-container" ></div>
				<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="display: none;"/>
			</div>
			<div class="clearfix"></div>
			<!-- include 'templates/tags/carousel.php';  -->
			<?php if($logged){?>
			<div style="text-align: center">
				<a href="<?=HREF_DEFAULT?>" class="color-pro" action="tagsUser,1,'',<?=md5($obj->id)?>"><?=ALL_TAGS?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="<?=HREF_DEFAULT?>" class="color-pro" action="personalTags,5,<?=md5($obj->id)?>">
				<?=MAINMNU_PERSONALTAGS?>
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
	!isLogged()?$('wrapper').css('width', '947px'):'';

	if(!isLogged()) $('.tag-container').addClass('noMenu'); 
	else
		$('a.grouped_PP').fancybox({
			type:'ajax',
			transitionIn:'fade',
			transitionOut:'elastic',
			scrolling : 'no',
			title:"<?=$obj->nameUser?>'s <?=USERPROFILE_PHOTOPROFILE?>",
			onClosed:function() {/*alert('aaa');*/}
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
			case 'eProfileTag':			    destino='timeline?current=personalTags'; break;
			case 'externalProfilePrefe':	destino='profile?sc=2'; break;
			case 'externalProfileInfo':	    destino='profile'; break;
			case 'photoProfileChange':	    $('#frmProfile_filePhoto').click(); break;
			case 'coverExternalProfile':	$('#frmProfile_fileCover').click(); break; /*alert('change Cover'); break;*/
		}
		if (destino!='') redir(destino);
	});

	$('#frmProfile_filePhoto').bind('change',function(){
		
		$("#actionAjax").val("UPLOADING-PROFILE-PICTURE");
		$("#validaActionAjax").val("filePhoto");
		$('loader.page',PAGE).show();
		$("#frmChangePhoto").submit();
	});

	$('#frmProfile_fileCover').bind('change',function(){
		$('loader.page',PAGE).show();
		$("#frmChangeCover").submit();
	});

	$('#frmChangePhoto,#frmChangeCover').ajaxForm({
		success:function(data){
			if(data.indexOf('CROP')>=0){// going crop before changing profile picture
				redir('user/mini?ep');
			}else if (data!=0) {
				console.log(data);
				$('loader.page',PAGE).hide();
				$('#coverExpro').css('background-image', 'url("<?=FILESERVER?>img/users_cover/'+data+'")');	
			}else{
				$.dialog({
					title:'<?=$lang["ERROR_COVER"]?>',
					content:'<?=$lang["ERROR_UPLOADING_PROFILE_PICTURE"]?>',
					close:function(){
						$(this).off();
					},				
					width:350,
					height:200,
					modal:true,
					buttons:{
						Ok:function(){
							$(this).dialog('close');
						}
					}
				});
			}
		}
	});


});
</script>
<?php
}else{
	$bodyPage='main/failure.php';
}

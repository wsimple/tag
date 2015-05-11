<?php
	$wid=CON::getVal('SELECT users.id FROM users JOIN store_raffle_users ON users.email=store_raffle_users.email WHERE store_raffle_users.email = "'.$_SESSION['ws-tags']['ws-user']['email'].'";');
	$frmProfile=new forms();
	//opciones de muestra de la fecha de nacimiento
	$shows_birthday=$GLOBALS['cn']->query("SELECT * FROM users_profile_showbirthday ORDER BY id ASC");
	//codigos de area por pais
	$countries = CON::getArray("SELECT id,code,code_area,name FROM countries ORDER BY name ASC");
	//codigos de area por pais
	if(isset($_GET['showUploadError'])){
		mensajes(lan('UPLOAD_IMAGE_ERROR'),lan('PUBLICITY_TITLEMSGSUCCfrmProfileBackgroundESS')." ..!","");
	}
	//to fill language list
	$languages = CON::query("SELECT cod,id, name FROM languages");
	$sex=$_SESSION['ws-tags']['ws-user']['sex'];
	$relationship=CON::getArray("SELECT id,label FROM users_relations");
	$wish=CON::getArray("SELECT id,label FROM users_wish_to WHERE id>0");
	if (!isset($_SESSION['ws-tags']['ws-user']['progress'])) $_SESSION['ws-tags']['ws-user']['progress']['value']=calculateProgress();
	$value=$_SESSION['ws-tags']['ws-user']['progress']['value']['preferences'];
	$noFails=$_SESSION['ws-tags']['ws-user']['progress']['value']['noFails'];
?>
<?php include('views/users/progress.php'); ?>
<div id="frmProfile_View" class="ui-single-box clearfix">
	<?php //user messages (top) ?>
		<?=generateDivMessaje('divSuccess','250',lan('NEWTAG_CTRMSGDATASAVE'))?>
		<?=generateDivMessaje('divError','300',lan('USERPROFILE_ERROR_SAVING'),false)?>
	<!-- BARRA TITULO -->
	<h3 class="ui-single-box-title">&nbsp;<?=lan('USERPROFILE_TITLEFIELDSET')?></h3>
	<form action="controls/users/profile.json.php?action=picture" id="frmChangePhoto" name="frmChangePhoto" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
		<div id="frmProfile_changePhotoDiv">
			<input name="frmProfile_filePhoto" type="file" id="frmProfile_filePhoto"/>
		</div>
	</form>
	<form action="controls/users/profile.json.php" id="frmProfile_" name="frmProfile_" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
	<input type="hidden" id="validaActionAjax" name="validaActionAjax" value="save"/>
	<div id="frmProfilePhotoContainer">
		<?php //profile picture, change button, business card button
			$foto=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['pic'],'img/users/default.png');
		?>
		<div><img width="60" height="60" src="<?=$foto?>" style="border-radius: 50%;"/></div>
		<?php /* BUTTON CHANGE - BUSINESS CARD - VIEW PROFILE */?>
		<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
			<div id="frmProfile_changePhotoButton" >
				<a href="javascript:void(0);" class="color-pro <?=!isset($noFails['photo'])?'no-complete':''?>" <?php if(lan('RESETPASS_BTN1_TITLE')!=""){?> title="<?=lan('RESETPASS_BTN1_TITLE')?>"<?php }?>><?=lan('RESETPASS_BTN1')?></a><br><br>
			</div>
			<div id="frmProfile_businessCardDiv">
				<?php if(!strpos($foto,"default.png")){ ?>
				<a href="<?=base_url('user/mini')?>" class="color-pro" <?php if(lan('USER_CROPPROFILE_TITLE')!=""){?> title="<?=lan('USER_CROPPROFILE_TITLE')?>"<?php } ?>>
					<?=lan('USER_CROPPROFILE')?>
				</a><br><br>
				<?php } ?>
				<a href="<?=base_url('user/preferences')?>" class="color-pro <?=($value<100?'no-complete':'')?>"><?=lan('USERPROFILE_PREFERENCES')?><?=($value<100?' ('.round($value).'%)':'')?></a><br><br>
				<a href="<?=base_url('user/password')?>" class="color-pro"><?=lan('MAINSMNU_PASSWORD')?></a><br><br>
				<a href="<?=base_url('user/cards')?>" class="color-pro"><?=lan('USERPROFILE_BUSINESSCARD')?></a><br><br>
				<a href="<?=base_url('setting?sc=1')?>" class="color-pro"><?=lan('NOTIFICATIONS_CONFIGURATIONSECTION')?></a>
			</div>
		<?php } ?>
	</div>
	<div id="frmProfileFormContainer">
		<div>
			<div class="left">
				<?php //first name OR Company Name ?>
				<label <?=!isset($noFails['name'])?'class="no-complete"':''?>><strong>(*)&nbsp;<?=(($_SESSION['ws-tags']['ws-user']['type']=='1')?lan('SIGNUP_LBLADVERTISERNAME_FIELD'):lan('SIGNUP_LBLFIRSTNAME_FIELD'))?>:</strong></label>
				<?=$frmProfile->imput(
					'frmProfile_firstName',
					$_SESSION['ws-tags']['ws-user']['name'],
					$anchoImput,'text','','',
					(($_SESSION['ws-tags']['ws-user']['type']==1)?lan('SIGNUP_LBLADVERTISERNAME'):lan('SIGNUP_LBLFIRSTNAME')).'|string|3')
				?>
			</div>
			<?php if( $_SESSION['ws-tags']['ws-user']['type']=='0') { ?>
			<div class="left"><?php //last name ?>
				<label <?=!isset($noFails['lname'])?'class="no-complete"':''?>><strong>(*)&nbsp;<?=lan('SIGNUP_LBLLASTNAME_FIELD')?>:</strong></label>
				<?=$frmProfile->imput('frmProfile_lastName', $_SESSION['ws-tags']['ws-user']['last_name'],$anchoImput,'text','','imputs_wrap_register',lan('SIGNUP_LBLLASTNAME').'|string|3')?>
			</div>
			<?php } ?>
			<div class="left"><?php //nick name ?>
				<label <?=!isset($noFails['sname'])?'class="no-complete"':''?>><strong>(*)&nbsp;<?=lan('SIGNUP_LBLSCREENNAME_FIELD')?>:</strong></label>
				<?=$frmProfile->imput("frmProfile_screenName", $_SESSION['ws-tags']['ws-user']['screen_name'],$anchoImput, "text", "", "imputs_wrap_register", lan('SIGNUP_LBLSCREENNAME')."|string")?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<label id="uname" <?=!isset($noFails['uname'])?'class="no-complete"':''?>><strong><?=lan('USERPROFILE_LBLPROFILEUSERNAME')?>:</strong></label>
			<div><?php //username ?>
				<input type="text" tipo="string" value="<?=$_SESSION['ws-tags']['ws-user']['username']?>" id="frmProfile_userName" name="frmProfile_userName"/>
				<em class="font-size3 color-d">(<?=lan('USERPROFILE_LBLHELPUSERNAME1')?>)</em>
			</div>
			<em class="font-size3 color-d "><?=(($_SESSION['ws-tags']['ws-user']['username']!='') ? str_replace('*', $_SESSION['ws-tags']['ws-user']['username'], lan('USERPROFILE_LBLHELPUSERNAME2')) : str_replace('*', lan('USER_PROFILE'), lan('USERPROFILE_LBLHELPUSERNAME2')))?></em>
			<label id="msg-personal" <?=!isset($noFails['msg'])?'class="no-complete"':''?> style="margin-top: 10px;"><strong><?=lan('BIOMESSAGE')?>:</strong></label>
			<div style="font-size: 10px"><?php //message personal ?>
				<input type="text" tipo="string" size="100" value="<?=$_SESSION['ws-tags']['ws-user']['personal_messages']?>" id="frmProfile_messagePersonal" name="frmProfile_messagePersonal"/>
				<span id="theCounter" ></span>&nbsp;max
			</div>
		</div>
		<div><?php //birth day ?>
			<label <?=!isset($noFails['dateb'])?'class="no-complete"':''?> id="dateb">
				<strong>(*)&nbsp;<?=($_SESSION['ws-tags']['ws-user']['type']=='1')?lan('SIGNUP_LBLBUSINESSSINCE'):lan('SIGNUP_LBLBIRTHDATE')?>:</strong>
			</label>
			<div>
				<?php list($year,$month,$day)=explode('-',$_SESSION['ws-tags']['ws-user']['date_birth']); ?>
				<select name="frmProfile_month" id='frmProfile_month' requerido="Month">
					<option value="" ><?=lan('SIGNUP_LBLMONTH')?></option>
					<?php for($i=1;$i<13;$i++){ ?>
						<option <?=($month==$i?"selected='selected'":'')?>><?=$i?></option>
					<?php } ?>
				</select>
				<select name="frmProfile_day" id='frmProfile_day' requerido="Day">
					<option value=""><?=lan('SIGNUP_LBLDAY')?></option>
					<?php for($i=1; $i<32; $i++) { ?>
							<option <?=($day==$i ? "selected='selected'" : '')?>> <?=$i?> </option>";
					<?php } ?>
				</select>
				<select name="frmProfile_year" id='frmProfile_year' requerido="Year">
					<option value=""><?=lan('SIGNUP_LBLYEAR')?></option>
					<?php
					$rango=($_SESSION['ws-tags']['ws-user']['type']=='1'?0:13);
					for($i=date('Y')-$rango; $i>1930; $i--){ ?>
							<option <?=($year==$i ? "selected='selected'" : '')?>> <?=$i?> </option>";
					<?php } ?>
				</select>
				<?php if($_SESSION['ws-tags']['ws-user']['type']=='0'){ ?>
				<select name="frmProfile_showbirthday" id="frmProfile_showbirthday">
					<?php while ($show_birthday=mysql_fetch_assoc($shows_birthday)){ ?>
						<option value="<?=$show_birthday['id']?>" <?php if($_SESSION['ws-tags']['ws-user']['show_birthday']==$show_birthday['id']) echo "selected"; ?> ><?=lan($show_birthday['label'])?></option>
					<?php } ?>
				</select>
				<?php } ?>
			</div>
			<?php if($_SESSION['ws-tags']['ws-user']['type']=='0'){ ?>
			<a class="font-size3 color-d" href="javascript:void(0);" onclick="message('messages','<?=lan('WHYDOIPROVIDEMYBIRTHDAY')?>','<?=lan('SIGNUP_MSJBIRTHDATEWARNING')?>','',400,200);" onFocus="this.blur();"><?=lan('WHYDOIPROVIDEMYBIRTHDAY')?></a>
			<?php } ?>
		</div>
		<div class="clearfix">
			<div class="left"><?php //language ?>
				<label><strong><?=lan('USERPROFILE_LBLLANGUAGE')?>:</strong></label>
				<select name="frmProfile_cboLanguageUsr" id="frmProfile_cboLanguageUsr" w="150">
					<?php while($language=CON::fetchObject($languages)){ ?>
						<option value="<?=$language->cod?>" <?=($_SESSION['ws-tags']['ws-user']['language']!=$language->cod?'':'selected')?>><?=$language->name?></option>
					<?php } ?>
				</select>
			</div>
			<div class="left"><?php //country ?>
				<label <?=!isset($noFails['country'])?'class="no-complete"':''?>><strong><?=lan('BUSINESSCARD_LBLCOUNTRY')?>:</strong></label>
				<select name="frmProfile_cboFrom" id="cbo_from_search" w="150">
					<option value="" ></option>
					<?php foreach ($countries as $row) { ?>
						<option value="<?=$row['id']?>" <?=($_SESSION['ws-tags']['ws-user']['country']==$row['id'] ? "selected" : '')?>>
							<?=$row['name']?>
						</option>
					<?php } ?>
				</select>
			</div class="left">
			<div><?php //zip code ?>
				<label ><strong><?=lan('SIGNUP_ZIPCODE')?></strong></label>
				<input name="frmProfile_zipCode" type="text" id="frmProfile_zipCode" value="<?=$_SESSION['ws-tags']['ws-user']['zip_code']?>"/>
			</div>
		</div>
		<div class="clearfix">
			<div id="setCitys">
				<label <?=!isset($noFails['city'])?'class="no-complete"':''?>><strong><?=lan('BUSINESSCARD_LBLCITY')?>:</strong></label>
				<select name="city" id="city" requerido="<?=lan('BUSINESSCARD_LBLCITY')?>" autocomplete="off" ></select>
			</div>
		</div>
		<?php if($_SESSION['ws-tags']['ws-user']['type']=='0'){ ?>
		<div><?php //home phone ?>
			<label><strong><?=lan('USERPROFILE_LBLHOMEPHONE')?>:</strong></label>
			<select id="home_code_search" name="frmProfile_home_code" w="150">
				<option value=""><?=lan('USERPROFILE_LBLCBOAREASCODE')?></option>
				<?php $number=explode('-',$_SESSION['ws-tags']['ws-user']['home_phone']);
				foreach ($countries as $row) { ?>
					<option value="<?=$row['id']?>" <?=($number[0]==$row['code_area']?'selected="1"':'')?>>
						<?=$row['name'].'&nbsp;('.$row['code_area'].')'?>
					</option>
				<?php } ?>
			</select>
			<input name="frmProfile_home" type="text" id="frmProfile_home" value="<?=$number[1]?>" tipo="integer"/>
			<em class="font-size3 color-d"><?=lan('PROFILE_PHONELEYEND')?></em>
		</div>
		<?php } ?>
		<div><?php // work phone ?>
			<label><strong><?=lan('USERPROFILE_LBLWORKPHONE')?>:</strong></label>
			<select name="frmProfile_work_code" id="work_code_search" w="150">
				<option value=""><?=lan('USERPROFILE_LBLCBOAREASCODE')?></option>
				<?php $number=explode('-',$_SESSION['ws-tags']['ws-user']['work_phone']);
				foreach ($countries as $row) { ?>
					<option value="<?=$row['id']?>" <?=($number[0]==$row['code_area']?'selected="1"':'')?>>
						<?=$row['name'].'&nbsp;('.$row['code_area'].')'?>
					</option>
				<?php } ?>
			</select>
			<input name="frmProfile_work" type="text" id="frmProfile_work" value="<?=$number[1]?>" tipo="integer"/>
			<em class="font-size3 color-d "><?=lan('PROFILE_PHONELEYEND')?></em>
		</div>
		<div><?php //mobile phone ?>
			<label><strong><?=lan('USERPROFILE_LBLMOBILEPHONE')?>:</strong></label>
			<select name="frmProfile_mobile_code" id="mobile_code_search" w="150">
				<option value=""><?=lan('USERPROFILE_LBLCBOAREASCODE')?></option>
				<?php $number=explode('-',$_SESSION['ws-tags']['ws-user']['mobile_phone']);
				foreach ($countries as $row) { ?>
					<option value="<?=$row['id']?>" <?=($number[0]==$row['code_area'] ? 'selected="1"' : '') ?> >
						<?=$row['name'].'&nbsp;('.$row['code_area'].')'?>
					</option>
				<?php } ?>
			</select>
			<input name="frmProfile_mobile" type="text" id="frmProfile_mobile" value="<?=$number[1]?>" tipo="integer" />
			<em class="font-size3 color-d"><?=lan('PROFILE_PHONELEYEND')?></em>
		</div>
		<?php if( $_SESSION['ws-tags']['ws-user']['type']!='1' ){ ?>
		<div class="ui-single-box">
			<h3 class="ui-single-box-title"><?=lan('date','ucw')?></h3>
			<div class="clearfix">
				<div class="left"><?php //sexo ?>
					<label <?=!isset($noFails['sex'])?'class="no-complete"':''?>><strong><?=lan('SEX_TITLE')?>:</strong></label>
					<select name="frmProfile_sex" id="frmProfile_sex" w="150">
						<option value="" >...</option>
						<option value="1" <?=($sex==1?"selected":'')?>><?=lan('SEX_MALE')?></option>
						<option value="2" <?=($sex==2?"selected":'')?>><?=lan('SEX_FEMALE')?></option>
					</select>
				</div>
				<div class="left"><?php //interes ?>
					<label <?=!isset($noFails['interest'])?'class="no-complete"':''?>><strong><?=lan('INTERESTED_IN')?>:</strong></label>
					<select name="frmProfile_interest" id="frmProfile_interest" w="150">
						<option value="" >...</option>
						<option value="1" <?=($_SESSION['ws-tags']['ws-user']['interest']==1?"selected":'')?>><?=lan('men','ucw')?></option>
						<option value="2" <?=($_SESSION['ws-tags']['ws-user']['interest']==2?"selected":'')?>><?=lan('women','ucw')?></option>
						<option value="3" <?=($_SESSION['ws-tags']['ws-user']['interest']==3?"selected":'')?>><?=lan('both','ucw')?></option>
					</select>
				</div>
				<div class="left"><?php //relations  ?>
					<label <?=!isset($noFails['relation'])?'class="no-complete"':''?>><strong><?=lan('relationship','ucw')?>:</strong></label>
					<select name="frmProfile_relationship" id="frmProfile_relationship" w="150">
						<!-- <option value="" >...</option> -->
						<?php foreach ($relationship as $row) { ?>
							<option value="<?=$row['id']?>" <?=($_SESSION['ws-tags']['ws-user']['relationship']==$row['id']?'selected':'')?>><?=lan($row['label'],'ucw')?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div><?php //wish  ?>
				<label <?=!isset($noFails['wish'])?'class="no-complete"':''?>><strong><?=lan('wish to','ucw')?>:</strong></label>
				<div id="wish_to" style="margin: 0px 5px;">
					<?php foreach ($wish as $row) {?>
						<input type="checkbox" id="check<?=$row['id']?>" name="frmProfile_wish_to[]" value="<?=$row['id']?>" <?=($row['id']&$_SESSION['ws-tags']['ws-user']['wish_to'])?'checked':''?> />
						<label for="check<?=$row['id']?>"><?=lan($row['label'],'ucw')?></label>
					<?php } ?>
				</div>
			</div>
			<div>
				<em class="color-d font-size3"><?=lan('NOTE_DATES')?></em>
			</div>
		</div>
		<?php }
		if($_SESSION['ws-tags']['ws-user']['type']=='1'){ ?>
			<?php if(PAYPAL_PAYMENTS): ?>
			<div class="frmProfilePaypalAccount" style="height: 45px">
				<label><strong><?=lan('PROFILE_PAYINFO')?> <a href="https://www.paypal.com/ve/cgi-bin/webscr?cmd=_registration-run&from=PayPal" title="" target="_blank">paypal</a> (Paypal ID <?=lan('PROFILE_OREMAILPAY')?>):</strong></label>
				<input name="frmProfile_paypal" type="text" id="frmProfile_paypal"  value="<?=$_SESSION['ws-tags']['ws-user']['paypal']?>" style="width:300px;" /><span class="paypal_info help_info">?</span>
				<?php //requerido="FRMPROFILE_PAYPAL" ?>
				<div><div class="messageHelp arrowLeft"><span><?=lan('DIALOG_PAYPAL')?></span></div></div>
			</div>
			<div><?php //tax id ?>
				<label><strong>(*)&nbsp;<?=lan('USERPROFILE_TAXID')?>:</strong></label>
				<div><input type="text" name="frmProfile_taxId" id="frmProfile_taxId" value="<?=$_SESSION['ws-tags']['ws-user']['taxId']?>" onkeyup="mascara(this,'-',patron,true)" maxlength="11" /></div>
			</div>
			<?php else: ?>
			<input type="hidden" name="frmProfile_paypal" id="frmProfile_paypal" value="test@paypal.com">
			<input type="hidden" name="frmProfile_taxId" id="frmProfile_taxId" value="100">
			<?php endif ?>
		<?php } ?>
		<div class="color-a font-size3" id="frmProfileRequiredMessaje"><?=lan('REQUIRED')?></div>
		<div>
			<div id="frmProfileBackground"><?php //personal page color and background image ?>
				<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
				<div style="width:500px;" class="left">
					<label><strong><?=lan('USERPROFILE_SELCUSTOMBACKGROUND')?></strong></label>
					<div id="profileChangeBgButtonDiv" class="left" style="width:225px"><?php // background image chooser?>
						<input type="button" value="<?=lan('USERPROFILE_UPLOADBGTITTLE')?>"/>
					</div>
					<div id="setDefaultBgDiv" name="setDefaultBgDiv" class="left">
						<input id="setDefaultBgButton" type="button" value="<?=lan('USERPROFILE_USEDEFAULTBG')?>"/>
					</div>
					<div id="profileChangeBgDiv" class="invisible left">
						<input id="profile_background_file" name="profile_background_file" type="file" class="invisible"/>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="left">
					<label><strong><?=lan('USERPROFILE_SELCOLORBACKGROUND')?></strong></label>
						<input type="text" id="profileHiddenColor" class="colorBG" readonly="readonly" name="profileHiddenColor" value="<?=($_SESSION['ws-tags']['ws-user'][user_background] ? ($_SESSION['ws-tags']['ws-user'][user_background][0]=="#" ? $_SESSION['ws-tags']['ws-user'][user_background] : '#fff') : '#fff')?>"/>
					<div id="profileHiddenColorDiv"></div>
				</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
		<div>
			<div id="facebook-dialog" style="display:none;"><?=lan('FACEBOOK_NOTMATCHEMAIL')?></div>
			<div class="frmProfileBotones">
				<input name="frmProfile_btnSend" type="button" id="frmProfile_btnSend" value="<?=lan('USERPROFILE_SAVE')?>" />
				<?php 
					$fbid = current($GLOBALS['cn']->queryRow('SELECT fbid FROM users WHERE id="'.$_SESSION['ws-tags']['ws-user']['id'].'"'));
					$none[0] = ($fbid!='') ? 'style="display: none;"':''; 
					$none[1] = ($fbid=='') ? 'style="display: none;"':''; 
				?>
				<input name="frmProfile_btnDelfcId" type="button" class="fb-buttom" <?php echo $none[1]; ?> id="frmProfile_btnDelfcId" value="<?=lan('disassociate','ucw')?>" />
				<input type="button" class="fb-buttom" name="btnFacebook" <?php echo $none[0]; ?> id="btnFacebook" value="<?=lan('USERPROFILE_ASSOCFB')?>">
				<div id="fb-root"></div>
			</div>
		</div>
	</div><?php // fin contenedor ?>
	</form>
</div>

<script>
	$('#frmProfile_cboLanguageUsr').change(function(event){
		if ($('#frmProfile_cboLanguageUsr').val()!='<?=$_SESSION['ws-tags']['ws-user']['language']?>') {
			$("#frmProfile_").submit();
		};
	});

	$('#theCounter').textCounter({
		target:'#frmProfile_messagePersonal',//required: string
		count:160,//optional: integer [defaults 140]
		alertAt:20,//optional: integer [defaults 20]
		warnAt:10,//optional: integer [defaults 0]
		stopAtLimit:true //optional: defaults to false
	});

	$('[title]').tipsy({html:true,gravity:'n'});
	var band=false, typeUser=<?=$_SESSION['ws-tags']['ws-user']['type']?>;

	//Para login con facebook
	window.fbAsyncInit = function() {
		FB.init({
			appId: '<?=isset($config->facebook->appId)?$config->facebook->appId:''?>',
			cookie: true,
			xfbml: true,
			oauth: true,
			status: true
		});
	};
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_Us/all.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	function callFbApi(forced){
		$.ajax({
			url:DOMINIO+'controls/facebook/fbuser.json.php',
			data:{'forced':forced},
			type:'POST',
			dataType:'json',
			success:function(data){
				if(data['success']==1){
					showAndHide('divSuccess','divSuccess',1500,true);
				}else if(data['success']===0 && !forced){
					$('#facebook-dialog').dialog({
						title:'data.email',
						buttons:{
							'<?=JS_OK?>':function(){
								callFbApi(true);
								$(this).dialog('close');
							},
							'<?=JS_NO?>':function(){
								$(this).dialog('close');
							}
						}
					});
				}else{
					showAndHide('divError','divError',1500,true);
				}
			}
		});
	}
	$('#btnFacebook').click(function(event){
		FB.login(function(response){
			if(response.authResponse){
				FB.api('/me', function(response) {
					callFbApi();
				});
			} else {
				console.log('No has logueado correcatmente con fbb.');
			}
		}, {scope: 'email'});
	});	
	$('#frmProfile_btnDelfcId').click(function(event){
		showAndHide('btnFacebook','frmProfile_btnDelfcId','1000');
		$.ajax({
			url:DOMINIO+'controls/users/profile.json.php',
			data:{'disAssociateFB':'1'},
			type:'POST',
			dataType:'json',
			success:function(data){
				if (data['out']==1)
					showAndHide('btnFacebook','frmProfile_btnDelfcId','1000');
			}
		});
	});
	$('#frmProfile_,#frmChangePhoto').ajaxForm({
		dataType:'json',
		success:function(data){
			$('loader.page',PAGE).hide();
			if (!data['error']){
				switch(data['success']){
					case 'updateLanguage': location.reload(); break;
					case 'filePhoto': redir('user/mini'); break;
					case 'backg': $('body').css('background',data['backg']); break;
					case 'pbackg':  
						$('#profileHiddenColor').val('#fff');
						<?php if ($config->local){ ?>
						$('body').css('background','')
						.css('background-image', 'url('+(DOMINIO)+'img/users_backgrounds/'+data['backg']+')');
						<?php }else{ ?>
						$('body').css('background','')
						.css('background-image', 'url('+(SERVERS.img)+'img/users_backgrounds/'+data['backg']+')');
						<?php } ?>
					break;
					default: 
						showAndHide('divSuccess','divSuccess',1500,true); 
						var getStore="<?=isset($_GET['store'])?'store':''?>",idUser="<?=$_SESSION['ws-tags']['ws-user']['id']?>",here='<?=$wid?>';
						if (band && getStore!='' && (typeUser=='1' || idUser==here)){
							redir('newproduct');
						}
					break;
				}
				updateLabels(data['noFails']);
			}else{ 
				$('#divError').html(data['error']);
				showAndHide('divError','divError',1500,true);
			}
		}
	});
	//patron tax id
	var patron = new Array(3,2,4);
		$(function(){
		//TTHHUMMBB
		<?php if( $_SESSION['ws-tags']['ws-user']['photo']!="" ) { ?>
				$('header menu a.user img',PAGE).attr('src','<?=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['pic'],'img/users/default.png').'?'.time()?>');
		<?php } ?>
		//control de los botones send y back
		$('#frmProfile_btnSend').click(function(){
				if( valida('frmProfile_') ) {

					var stri='',select='';
					if ($('#frmProfile_mobile').val()!='' || $('#frmProfile_work').val()!='' || (typeUser=='0' && $('#frmProfile_home').val()!='')){
						band=true;
						if ($('#frmProfile_mobile').val()!='' && !validateForm('frmProfile_mobile'))	stri+='<?=USERPROFILE_LBLMOBILEPHONE?>';
						if ($('#frmProfile_work').val()!='' && !validateForm('frmProfile_work')){	stri+=stri!=''?', <?=USERPROFILE_LBLWORKPHONE?>':'<?=USERPROFILE_LBLWORKPHONE?>';}
						if (typeUser=='0' && $('#frmProfile_home').val()!='' && !validateForm('frmProfile_home')){	stri+=stri!=''?' <?=ORLABEL?> <?=USERPROFILE_LBLHOMEPHONE?>':'<?=USERPROFILE_LBLHOMEPHONE?>';}
						if ($('#frmProfile_work').val()!='' && $('#work_code_search').val()==''){ select+='<?=USERPROFILE_LBLWORKPHONE?>'; }
						if (typeUser=='0' && ($('#frmProfile_home').val()!='' && $('#home_code_search').val()=='')){ select+=select!=''?', <?=USERPROFILE_LBLHOMEPHONE?>':'<?=USERPROFILE_LBLHOMEPHONE?>'; }
						if ($('#frmProfile_mobile').val()!='' && $('#mobile_code_search').val()==''){ select+=select!=''?' <?=ORLABEL?> <?=USERPROFILE_LBLMOBILEPHONE?>':'<?=USERPROFILE_LBLMOBILEPHONE?>'; }
					}
					if (stri=='' && select==''){
						var val = $('#frmProfile_userName').val(),n='';
						n = val.indexOf(" ");

						if (n<0) {
							$('loader.page',PAGE).show();
							$("#validaActionAjax").val('save');
							$('#frmProfile_').submit();	
						}else{
							$.dialog({
								title:'Alert',
								content:'<span style="font-weight: bold"><?=USERPROFILE_LBLPROFILEUSERNAME?></span>: <?=USERPROFILE_LBLHELPUSERNAME1?>',
								focus:$('#frmProfile_userName')
							});
						}
					}else{
						band=false;
						
						if(select!=''){
							$('div#divError').html('<?=lan("PLEASE_INDICATE")?> '+select);
							// showAndHide('divErroPhoneCode','divErroPhoneCode',1500,true);
						}else{
							$('div#divError').html('<?=lan("PLEASE_INDICATE")?> '+stri);
							// showAndHide('divErroPhone',	'divErroPhone',	1500, true);
						}
						showAndHide('divError','divError',2500,true);
					}
				$.loader('hide');
		});
		//FIN control de los botones send y back
		//control del formulario perfil
		//calendario
		$('select').each(function(){
			if (this.id!="city" && this.id!="frmProfile_wish"){
				var w=$(this).attr('w'),opc={};
				if(w) opc['menuWidth']=opc['width']=w;
				if(!this.id.match('_search')) opc['disableSearch']=true;
				$(this).chosen(opc);
			}
		});
		var city="<?=$_SESSION['ws-tags']['ws-user']['city']?>";
        $('#city').fcbkcomplete({
	        json_url: 'controls/store/shoppingCart.json.php?action=11',
	        newel:true,
	        filter_selected:true,
	        firstselected: true,
	        addontab : false,
	        filter_hide: true,
	        maxitems:1
	    });
	    $('#setCitys').on('keydown','ul.holder li input',function(e){
	        var a=$('#setCitys select#city option').val();
	        if ((a)&&(!validaKeyCode('del',e.heyCode)))
	            e.preventDefault();
	    });
	    if (city && city!=''){ getCitys('#city',city); }
		$( "#wish_to" ).buttonset();
	   
		<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
			$("#frmProfile_changePhotoButton").click(function() {
				$('#frmProfile_filePhoto').click();
			});
			$('#frmProfile_filePhoto').bind('change',function(){
				if ($(this).val()!=''){
					$("#validaActionAjax").val("filePhoto");
					$('loader.page',PAGE).show();
					$("#frmChangePhoto").submit();
				}
			});
			$("#profileHiddenColor").click(function() {
				$("#profile_background_file").val('');
			});
			$("#profileChangeBgButtonDiv").click(function() {
				$('#profile_background_file').click();
				$("#profileHiddenColor").val('');
			});
			$('#profile_background_file').bind('change',function(){
				if ($(this).val()!=''){
					$("#validaActionAjax").val("backgroundFile");
					$('loader.page',PAGE).show();
					$("#frmProfile_").submit();
				}
			});
			$("#setDefaultBgDiv").click(function() {
				$("#validaActionAjax").val("HiddenColor");
				$("#profileHiddenColor").val("#fff").css({
					background: "#fff",color:'#000'
				});
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
			});
			colorSelector('profileHiddenColorDiv','profileHiddenColor');
			$('#profileHiddenColor').blur(function() {
				$("#validaActionAjax").val("HiddenColor");
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
			});
		<?php } ?>
		});
function updateLabels(data){
	var preferences=false;
	if ($('#frmProfile_businessCardDiv a:nth-child(4)').hasClass('no-complete')){ preferences=true;}
	$('.no-complete').removeClass('no-complete');
	if (!data['name']) $('#frmProfile_firstName').prev('label').addClass('no-complete');
	if (!data['sname']) $('#frmProfile_screenName').prev('label').addClass('no-complete');
	if (!data['uname']) $('#uname').addClass('no-complete');
	if (!data['lname']) $('#frmProfile_lastName').prev('label').addClass('no-complete');
	if (!data['dateb']) $('#dateb').addClass('no-complete');
	if (!data['country']) $('#cbo_from_search').prev('label').addClass('no-complete');
	if (!data['city']) $('#setCitys label').addClass('no-complete');
	if (!data['sex']) $('#frmProfile_sex').prev('label').addClass('no-complete');
	if (!data['interest']) $('#frmProfile_interest').prev('label').addClass('no-complete');
	if (!data['relation']) $('#frmProfile_relationship').prev('label').addClass('no-complete');
	if (!data['wish']) $('#wish_to').prev('label').addClass('no-complete');
	if (!data['wish']) $('#wish_to').prev('label').addClass('no-complete');
	if (!data['msg']) $('#msg-personal').addClass('no-complete');
	if (!data['photo']) $('#frmProfile_changePhotoButton a').addClass('no-complete');
	if (preferences) $('#frmProfile_businessCardDiv a:nth-child(4)').addClass('no-complete');
}
</script>

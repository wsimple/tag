<?php
	$paypalMsg=DIALOG_PAYPAL;
	$wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
	if (!$wid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@seemytag.com";');
	$frmProfile=new forms();
	//opciones de muestra de la fecha de nacimiento
	$shows_birthday=$GLOBALS['cn']->query("SELECT * FROM users_profile_showbirthday ORDER BY id ASC");
	//codigos de area por pais
	$countries = $GLOBALS['cn']->query("SELECT id,code,code_area,name FROM countries ORDER BY name ASC");
	//codigos de area por pais
	$sex = $GLOBALS['cn']->query("SELECT * FROM sex ORDER BY id ASC");
    if(isset($_GET['showUploadError'])){
		mensajes(UPLOAD_IMAGE_ERROR,PUBLICITY_TITLEMSGSUCCfrmProfileBackgroundESS." ..!","");
	}
	$all='frmProfile_btnSend';
	//to fill language list
	$languages = $GLOBALS['cn']->query("SELECT cod,id, name FROM languages");
	//to fill countries list
	$froms = $GLOBALS['cn']->query('SELECT id, name FROM countries');
?>
<div id="frmProfile_View" class="ui-single-box">
	<?php //user messages (top) ?>
		<?=generateDivMessaje('divSuccess',			'250',NEWTAG_CTRMSGDATASAVE					)?>
		<?=generateDivMessaje('divErroZip',			'300',SIGNUP_CTRMSJERRORZIPCODE,			false)?>
		<?=generateDivMessaje('divErroImagen',		'200',ERROR_UPLOADING_PROFILE_PICTURE,		false)?>
		<?=generateDivMessaje('divErroBirthDate',	'200',SIGNUP_CTRERRORBIRTHDATE,				false)?>
		<?=generateDivMessaje('divErrorUsernameF',	'400',USERPROFILE_CTRERRORUSERNAMENOFORMAT,	false)?>
		<?=generateDivMessaje('divErrorUsernameD',	'300',USERPROFILE_CTRERRORUSERNAMEDUPLICATE,false)?>
		<?=generateDivMessaje('divErroUploadingPP',	'300',USERPROFILE_CTRERRORUSERBIGIMAGE,		false)?>
		<?=generateDivMessaje('divErroPhone',		'300',USERPROFILE_ERRORNUMBERSPHONE,		false)?>
		<?=generateDivMessaje('divErroPhoneCode',	'300',USERPROFILE_ERRORCODENUMBERS,			false)?>
		<?=generateDivMessaje('divError',	        '300',USERPROFILE_ERROR_SAVING,			    false)?>
	<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
	<h3 class="ui-single-box-title">
		&nbsp;<?=USERPROFILE_TITLEFIELDSET?>
	</h3>
	<form action="?current=updateProfile" id="frmProfile_" name="frmProfile_" method="post" style="padding:0;margin:0;" enctype="multipart/form-data">
	<input type="hidden" id="actionAjax" name="actionAjax"/>
	<input type="hidden" id="validaActionAjax" name="validaActionAjax" value="save"/>
	<div id="frmProfilePhotoContainer">
		<?php //profile picture, change button, business card button
			$foto=FILESERVER.getUserPicture($_SESSION['ws-tags']['ws-user']['pic'],'img/users/default.png');
		?>
		<div><img width="60" height="60" src="<?=$foto?>" style="border-radius: 50%;"/></div>
		<?php /* BUTTON CHANGE - BUSINESS CARD - VIEW PROFILE */?>
		<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
			<div id="frmProfile_changePhotoButton" <?php if(RESETPASS_BTN1_TITLE!=""){?> title="<?=RESETPASS_BTN1_TITLE?>"<?php }?>>
				<a href="javascript:void(0);" class="color-a font-size3" ><?=RESETPASS_BTN1?></a>
			</div>
			<div id="frmProfile_changePhotoDiv">
				<input name="frmProfile_filePhoto" type="file" id="frmProfile_filePhoto"/>
			</div>
			<div id="frmProfile_businessCardDiv">
				<?php if(!strpos($foto,"default.png")){ ?>
				<a href="<?=base_url('profile?sc=5')?>" class="color-a font-size3" <?php if(USER_CROPPROFILE_TITLE!=""){?> title="<?=USER_CROPPROFILE_TITLE?>"<?php } ?>>
					<?=USER_CROPPROFILE?>
				</a>
				<?php } ?>
				<a href="<?=base_url('profile?sc=6')?>" class="color-a font-size3" <?php if(USER_HELPPREVIEWPROFILE_TITLE!=""){?> title="<?=USER_HELPPREVIEWPROFILE_TITLE?>"<?php } ?>>
					<?=USER_HELPPREVIEWPROFILE?>
				</a>
			</div>
		<?php } ?>
	</div>
	<div id="frmProfileFormContainer">
		<div>
			<div class="left">
				<?php //first name OR Company Name ?>
				<label><strong>(*)&nbsp;<?=(($_SESSION['ws-tags']['ws-user']['type']=='1')?SIGNUP_LBLADVERTISERNAME_FIELD:SIGNUP_LBLFIRSTNAME_FIELD)?>:</strong></label>
				<?=$frmProfile->imput(
					"frmProfile_firstName",
					$_SESSION['ws-tags']['ws-user']['name'],
					$anchoImput,"text","","",
					(($_SESSION['ws-tags']['ws-user']['type']=='1')?SIGNUP_LBLADVERTISERNAME:SIGNUP_LBLFIRSTNAME)."|string|3")
				?>
			</div>
			<?php if( $_SESSION['ws-tags']['ws-user']['type']=='0' ) { ?>
				<div class="left"><?php //last name ?>
					<label ><strong>(*)&nbsp;<?=SIGNUP_LBLLASTNAME_FIELD?>:</strong></label>
					<?=$frmProfile->imput( "frmProfile_lastName", $_SESSION['ws-tags']['ws-user']['last_name'],$anchoImput, "text", "", "imputs_wrap_register", SIGNUP_LBLLASTNAME."|string|3")?>
				</div>
			<?php } ?>
			<div class="left"><?php //screen name ?>
				<label><strong>(*)&nbsp;<?=SIGNUP_LBLSCREENNAME_FIELD?>:</strong></label>
				<?=$frmProfile->imput("frmProfile_screenName", $_SESSION['ws-tags']['ws-user']['screen_name'],$anchoImput, "text", "", "imputs_wrap_register", SIGNUP_LBLSCREENNAME."|string")?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div><?php //username ?>
				<label><strong><?=USERPROFILE_LBLPROFILEUSERNAME?>:</strong></label>
				<input type="text" tipo="string" value="<?=$_SESSION['ws-tags']['ws-user'][username]?>" id="frmProfile_userName" name="frmProfile_userName"/>
				<?=generateDivMessaje('divCheckingUsername','250', 'revisando el username', 'left')?>
				<?=generateDivMessaje('divValidUsername',	'250', 'username disponible', 'left')?>
				<em class="font-size3 color-d">(<?=USERPROFILE_LBLHELPUSERNAME1?>)</em>
				<em class="font-size3 color-d "><?=(($_SESSION['ws-tags']['ws-user'][username]!='') ? str_replace('*', $_SESSION['ws-tags']['ws-user'][username], USERPROFILE_LBLHELPUSERNAME2) : str_replace('*', USER_PROFILE, USERPROFILE_LBLHELPUSERNAME2))?></em>
			</div>
		</div>
		<div>		
			<div class="left"><?php //birth day ?>
				<label>
					<strong>(*)&nbsp;<?=($_SESSION['ws-tags']['ws-user'][type]=='1')?SIGNUP_LBLBUSINESSSINCE:SIGNUP_LBLBIRTHDATE?>:</strong>
				</label>
				<?php list($year,$month,$day)=explode('-',$_SESSION['ws-tags']['ws-user']['date_birth']); ?>
				<select name="frmProfile_month" id='frmProfile_month' requerido="Month">
					<option value="" ><?=SIGNUP_LBLMONTH?></option>
					<?php for($i=1;$i<13;$i++){ ?>
						<option <?=($month==$i?"selected='selected'":'')?>><?=$i?></option>
					<?php } ?>
				</select>
				<select name="frmProfile_day" id='frmProfile_day' requerido="Day">
					<option value=""><?=SIGNUP_LBLDAY?></option>
					<?php for($i=1; $i<32; $i++) { ?>
							<option <?=($day==$i ? "selected='selected'" : '')?>> <?=$i?> </option>";
					<?php } ?>
				</select>
				<select name="frmProfile_year" id='frmProfile_year' requerido="Year">
					<option value=""><?=SIGNUP_LBLYEAR?></option>
					<?php
					$rango = ($_SESSION['ws-tags']['ws-user'][type]=='1' ? 0 : 13);
					for($i=date('Y')-$rango; $i>1930; $i--) { ?>
							<option <?=($year==$i ? "selected='selected'" : '')?>> <?=$i?> </option>";
					<?php } ?>
				</select>
				<div class="clearfix"></div>
			</div>
			<div class="left">
				<!--<a class="font-size3 color-d" href="javascript:void(0);" onclick="message('messages','<?=WHYDOIPROVIDEMYBUSINESSSINCE?>','<?=SIGNUP_MSJBIRTHDATEWARNING?>','',400,200);" onFocus="this.blur();"><?=WHYDOIPROVIDEMYBUSINESSSINCE?></a>
				-->
				<?php if($_SESSION['ws-tags']['ws-user']['type']=='0'){ ?>
					<a class="font-size3 color-d" href="javascript:void(0);" onclick="message('messages','<?=WHYDOIPROVIDEMYBIRTHDAY?>','<?=SIGNUP_MSJBIRTHDATEWARNING?>','',400,200);" onFocus="this.blur();"><?=WHYDOIPROVIDEMYBIRTHDAY?></a>
					<select name="frmProfile_showbirthday" id="frmProfile_showbirthday">
						<?php while ($show_birthday=mysql_fetch_assoc($shows_birthday)){ ?>
							<option value="<?=$show_birthday['id']?>" <?php if($_SESSION['ws-tags']['ws-user']['show_birthday']==$show_birthday[id]) echo "selected"; ?> ><?=constant($show_birthday['label'])?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<div class="left"><?php //language ?>
				<label><strong><?=USERPROFILE_LBLLANGUAGE?>:</strong></label>
				
				<select name="frmProfile_cboLanguageUsr" id="frmProfile_cboLanguageUsr" w="150">
					<?php while ($language = mysql_fetch_assoc($languages)) { ?>
						<option value="<?=$language[cod]?>" <?=($_SESSION['ws-tags']['ws-user'][language]==$language[cod] ? "selected" : '')?> >
							<?=$language[name]?>
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="left"><?php //country ?>
				<label><strong><?=BUSINESSCARD_LBLCOUNTRY?>:</strong></label>
				
				<select name="frmProfile_cboFrom" id="cbo_from_search" w="150">
					<option value="" ></option>
					<?php while( $from = mysql_fetch_assoc($froms) ) { ?>
						<option value="<?=$from[id]?>" <?=($_SESSION['ws-tags']['ws-user'][country]==$from[id] ? "selected" : '')?>>
							<?=$from[name]?>
						</option>
					<?php } ?>
				</select>
			</div class="left">
			<div><?php //zip code ?>
				<label ><strong><?=SIGNUP_ZIPCODE?></strong></label>
				<input name="frmProfile_zipCode" type="text" id="frmProfile_zipCode" value="<?=$_SESSION['ws-tags']['ws-user']['zip_code']?>"/>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php if( $_SESSION['ws-tags']['ws-user'][type]=='0' ) { ?>
			<div><?php //home phone ?> 
				<label><strong><?=USERPROFILE_LBLHOMEPHONE?>:</strong></label>
				<select name="frmProfile_home_code" id="home_code_search" w="150">
					<option value=""><?=USERPROFILE_LBLCBOAREASCODE?></option>
					<?php
					$number=explode('-',$_SESSION['ws-tags']['ws-user']['home_phone']);
					while($country=mysql_fetch_assoc($countries)) { ?>
						<option value="<?=$country['id']?>" <?=($number[0]==$country['code_area']?'selected="1"':'')?>>
							<?=$country[name].'&nbsp;('.$country[code_area].')'?>
						</option>
					<?php }
					mysql_data_seek($countries, 0);
					?>
				</select>
				<input name="frmProfile_home" type="text" id="frmProfile_home" value="<?=$number[1]?>" tipo="integer"/>
				<em class="font-size3 color-d "><?=PROFILE_PHONELEYEND?></em>
			</div>
		<?php } ?>
		<div><?php // work phone ?>
			<label><strong><?=USERPROFILE_LBLWORKPHONE?>:</strong></label>
			 
			<select name="frmProfile_work_code" id="work_code_search" w="150">
				<option value=""><?=USERPROFILE_LBLCBOAREASCODE?></option>
				<?php
				$number=explode('-',$_SESSION['ws-tags']['ws-user']['work_phone']);
				while ($country=mysql_fetch_assoc($countries)){ ?>
					<option value="<?=$country[id]?>" <?=($number[0]==$country['code_area']?'selected="1"':'')?>>
						<?=$country['name'].'&nbsp;('.$country['code_area'].')'?>
					</option>
				<?php }
				mysql_data_seek($countries,0);
				?>
			</select>
			<input name="frmProfile_work" type="text" id="frmProfile_work" value="<?=$number[1]?>" tipo="integer"/>
			<em class="font-size3 color-d "><?=PROFILE_PHONELEYEND?></em>
		</div>
		<div><?php //mobile phone ?>
			<label><strong><?=USERPROFILE_LBLMOBILEPHONE?>:</strong></label>
			 
			<select name="frmProfile_mobile_code" id="mobile_code_search" w="150">
				<option value=""><?=USERPROFILE_LBLCBOAREASCODE?></option>
				<?php
				$number=explode('-',$_SESSION['ws-tags']['ws-user']['mobile_phone']);
				while($country=mysql_fetch_assoc($countries)){ ?>
					<option value="<?=$country['id']?>" <?=($number[0]==$country['code_area'] ? 'selected="1"' : '') ?> >
						<?=$country['name'].'&nbsp;('.$country['code_area'].')'?>
					</option>
				<?php }
				mysql_data_seek($countries,0);
				?>
			</select>
			<input name="frmProfile_mobile" type="text" id="frmProfile_mobile"  value="<?=$number[1]?>" tipo="integer" />
			<em class="font-size3 color-d"><?=PROFILE_PHONELEYEND?></em>
		</div>
		<?php if( $_SESSION['ws-tags']['ws-user']['type']!='1' ){ ?>
			<div><?php //sexo ?>
				<label><strong><?=SEX_TITLE?>:</strong></label>
				<select name="frmProfile_sex" id="frmProfile_sex" w="150">
				<?php if($_SESSION['ws-tags']['ws-user']['sex']==''){ ?>
					<option value="" selected>...</option>
				<?php }
				while($sexo=mysql_fetch_assoc($sex)){ ?>
				   <option value="<?=$sexo['id']?>" <?=($_SESSION['ws-tags']['ws-user']['sex']==$sexo['id']?"selected":'')?>>
					   <?=constant($sexo['label'])?>
				   </option>
				<?php } ?>
				</select>
			</div>
		<?php }
		if($_SESSION['ws-tags']['ws-user']['type']=='1'){ ?>
			<?php if (PAYPAL_PAYMENTS): ?>
			<div class="frmProfilePaypalAccount" style="height: 45px">
					<label ><strong><?=PROFILE_PAYINFO?> <a href="https://www.paypal.com/ve/cgi-bin/webscr?cmd=_registration-run&from=PayPal" title="" target="_blank">paypal</a> (Paypal ID <?=PROFILE_OREMAILPAY?>):</strong></label>
					<input name="frmProfile_paypal" type="text" id="frmProfile_paypal"  value="<?=$_SESSION['ws-tags']['ws-user'][paypal]?>" style="width:300px;" /><span class="paypal_info help_info">?</span>
                <?php //requerido="FRMPROFILE_PAYPAL" ?>
				<div><div class="messageHelp arrowLeft"><span><?=$paypalMsg?></span></div></div>
			</div>
            <div><?php //tax id ?>
				<label><strong>(*)&nbsp;<?=USERPROFILE_TAXID?>:</strong></label>
				<div><input type="text" name="frmProfile_taxId" id="frmProfile_taxId" value="<?=$_SESSION['ws-tags']['ws-user'][taxId]?>" onkeyup="mascara(this,'-',patron,true)" maxlength="11" /></div>
			</div>
			<?php else: ?>
			<input type="hidden" name="frmProfile_paypal" id="frmProfile_paypal" value="test@paypal.com">
			<input type="hidden" name="frmProfile_taxId" id="frmProfile_taxId" value="100">
			<?php endif ?>
		<?php } ?>
		<div class="color-a font-size3" id="frmProfileRequiredMessaje"><?=REQUIRED?></div>
		<div>
			<div id="frmProfileBackground"><?php //personal page color and background image ?>
				<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
				<div style="width:500px;" class="left">
					<label><strong><?=USERPROFILE_SELCUSTOMBACKGROUND?></strong></label>
					<div id="profileChangeBgButtonDiv" class="left" style="width:225px"><?php // background image chooser?>
						<input type="button" value="<?=USERPROFILE_UPLOADBGTITTLE?>" />
						<input id="user_background_url" name="user_background_url" style="display:none" type="text"/>
					</div>
					<div id="setDefaultBgDiv" name="setDefaultBgDiv" class="left">
						<input id="setDefaultBgButton" type="button" value="<?=USERPROFILE_USEDEFAULTBG?>"/>
					</div>
					<div id="profileChangeBgDiv" class="invisible left">
						<input id="profile_background_file" name="profile_background_file" type="file" class="invisible"/>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="left">
					<label><strong><?=USERPROFILE_SELCOLORBACKGROUND?></strong></label>
						<input type="text" id="profileHiddenColor" class="colorBG" readonly="readonly" name="profileHiddenColor" value="<?=($_SESSION['ws-tags']['ws-user'][user_background] ? ($_SESSION['ws-tags']['ws-user'][user_background][0]=="#" ? $_SESSION['ws-tags']['ws-user'][user_background] : '#fff') : '#fff')?>"/>
					<div id="profileHiddenColorDiv"></div>
				</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
		<div>
			<div id="facebook-dialog" style="display:none;"><?=FACEBOOK_NOTMATCHEMAIL?></div>
			<div class="frmProfileBotones">
				<input name="frmProfile_btnSend" type="button" id="frmProfile_btnSend" onclick="disableButtons('<?=$all?>');" value="<?=USERPROFILE_SAVE?>" />
				<input type="button" class="fb-buttom" name="btnFacebook" id="btnFacebook" value="<?=USERPROFILE_ASSOCFB?>">
				<div id="fb-root"></div>
			</div>
		</div>
	</div><?php // fin contenedor ?>
	<div class="clearfix"></div>
	</form>
</div>
<script>
	$('[title]').tipsy({html:true,gravity:'n'});
	var band=false, typeUser=<?=$_SESSION['ws-tags']['ws-user']['type']?>;
	function disableButtons(id) {
		id = id.split(',');
		for(var i=0;i<id.length;i++){
//			$('#'+id[i]).button('disable');
		}
	}
	function enableButtons(id) {
		id = id.split(',');
		for(i=0; i<id.length; i++) {
//			$('#'+id[i]).button('enable');
		}
	}

	//Para login con facebook
	window.fbAsyncInit = function() {
		FB.init({
			appId: '141402139297347',
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
				console.log(data);
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
					console.log(response);
					callFbApi();
				});
			} else {
				// console.log('No has logueado correcatmente con fbb.');
			}
		}, {scope: 'email'});
	});

	$('#frmProfile_').ajaxForm({
		success:function(data){
			//alert(data);
			console.log(data);
			if(data){
				if(data.indexOf('UUNN')>=0){
					data=data.substr(4);
					if(data){
						$("#showedUserName_<?=$_SESSION['ws-tags']['ws-user']['code']?>").html("<strong> "+data+" </strong>");
					}
					frmProfileSuccess();
				}
				if(data.indexOf('ERROR_USERNAME_FORMAT')>=0){//invalid username
					showAndHide('divErrorUsernameF','divErrorUsernameF',1500,true);
					showAndHide('divErrorUsernameFf','divErrorUsernameFf',1500,true);
					enableButtons('<?=$all?>');
				}else if(data.indexOf('ERROR_USERNAME_DUPLICATE')>=0){//duplicated username
					showAndHide('divErrorUsernameD','divErrorUsernameD',1500,true);
					showAndHide('divErrorUsernameDd','divErrorUsernameDd',1500,true);
					enableButtons('<?=$all?>');
				}else if(data.indexOf('WRONG_ZIP')>=0){//invalid zipcode
					showAndHide('divErroZip','divErroZip',1500,true);
					showAndHide('divErroZipp','divErroZipp',1500,true);
					enableButtons('<?=$all?>');
				}else if(data.indexOf('CROP')>=0){// going crop before changing profile picture
					$('loader.page',PAGE).hide();
					redir('profile?sc=5');
				}else if(data.indexOf('ERROR_UPLOADING_PROFILE_PICTURE')>=0){//el error
					showAndHide('divErroImagen','divErroImagen',2500,true);
					enableButtons('<?=$all?>');
					$('loader.page',PAGE).hide();
				}else if(data.indexOf('SIGNUP_CTRERRORBIRTHDATE')>=0){
					showAndHide('divErroBirthDate','divErroBirthDate',2500,true);
					enableButtons('<?=$all?>');
					$('loader.page',PAGE).hide();
				}else if(data.indexOf('BBGG#')>=0){//changing BG color
					data=data.substr(4);
					$('body').css('background-image','url(<?=md5(rand(0,100))?>)');
					$('body').css('background-color',data);
					frmProfileSuccess();
				}else if( data.indexOf('BBGG')>=0 ){//changing BG picture
					console.log('asdasd');
					data=data.substr(4);
					$('body').css('background', '');
					$('#profileHiddenColor').val('#fff');
					servidor=data!='bg.png'?'<?=FILESERVER?>':'';
					if(data!='bg.png')
						$('body').css('background-image', 'url('+servidor+'img/users_backgrounds/'+data+')');
					if(data!='bg.png'){
						$('body').css('background-repeat','repeat');
					}
					frmProfileSuccess();
				}else if(data.indexOf('updateLanguage')>=0){//changing languaje -> refresh page
					document.location.reload();
				}
			}else{
				frmProfileSuccess();
			}
		}
	});

	function frmProfileSuccess() {
		$('loader.page',PAGE).hide();
		showAndHide('setDefaultBgDiv,profileChangeBgButtonDiv', 'profileChangeBgDiv', 600);
		showAndHide('divSuccess',	'divSuccess',	1500, true);
		showAndHide('divSuccesss',	'divSuccesss',	1500, true);
		enableButtons('<?=$all?>');
		var getStore='<?=isset($_GET['store'])?'store':''?>',idUser='<?=$_SESSION['ws-tags']['ws-user']['id']?>',here='<?=$wid?>';
		if (band && getStore!='' && (typeUser=='1' || idUser==here)){
			redir('newproduct?');
		}
	}
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
					if ($('#frmProfile_mobile').val()!='' || $('#frmProfile_work').val()!='' || (typeUser=='0' && $('#frmProfile_home').val()!='')){   band=true;
						if ($('#frmProfile_mobile').val()!='' && !validateForm('frmProfile_mobile'))	stri+='<?=USERPROFILE_LBLMOBILEPHONE?>';
						if ($('#frmProfile_work').val()!='' && !validateForm('frmProfile_work')){	stri+=stri!=''?', <?=USERPROFILE_LBLWORKPHONE?>':'<?=USERPROFILE_LBLWORKPHONE?>';}
						if (typeUser=='0' && $('#frmProfile_home').val()!='' && !validateForm('frmProfile_home')){	stri+=stri!=''?' <?=ANDLABEL?> <?=USERPROFILE_LBLHOMEPHONE?>':'<?=USERPROFILE_LBLHOMEPHONE?>';}
						if ($('#frmProfile_work').val()!='' && $('#work_code_search').val()==''){ select+='<?=USERPROFILE_LBLWORKPHONE?>'; }
						if (typeUser=='0' && ($('#frmProfile_home').val()!='' && $('#home_code_search').val()=='')){ select+=select!=''?', <?=USERPROFILE_LBLHOMEPHONE?>':'<?=USERPROFILE_LBLHOMEPHONE?>'; }
						if ($('#frmProfile_mobile').val()!='' && $('#mobile_code_search').val()==''){ select+=select!=''?' <?=ANDLABEL?> <?=USERPROFILE_LBLMOBILEPHONE?>':'<?=USERPROFILE_LBLMOBILEPHONE?>'; }
					}
					if (stri=='' && select==''){
						$('loader.page',PAGE).show();console.log('is in there');
						console.log($('#validaActionAjax').val());
						$("#validaActionAjax").val('save');
						console.log($('#validaActionAjax').val());
						$('#frmProfile_').submit();
					}else{
						band=false;
						if(select!=''){
							console.log(select);
							$('div#divErroPhoneCode span').html(select);
							showAndHide('divErroPhoneCode','divErroPhoneCode',1500,true);
						}else{
							$('div#divErroPhone span').prepend(stri);
							showAndHide('divErroPhone',	'divErroPhone',	1500, true);
						}
						enableButtons('<?=$all?>');
					}	
				}
				enableButtons('<?=$all?>');
				$.loader('hide');
		});
		console.log($("#validaActionAjax").val());
		//FIN control de los botones send y back
		//control del formulario perfil
		//calendario
		$('select').each(function(){
			var w=$(this).attr('w'),opc={};
			if(w) opc['menuWidth']=opc['width']=w;
			if(!this.id.match('_search')) opc['disableSearch']=true;
			$(this).chosen(opc);
		});
		<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
			$('#frmProfile_filePhoto').bind('change',function(){
				disableButtons('<?=$all?>');
				$("#actionAjax").val("UPLOADING-PROFILE-PICTURE");
				$("#validaActionAjax").val("filePhoto");
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
			});
			$('#profile_background_file').bind('change',function(){
				disableButtons('<?=$all?>');
				$("#actionAjax").val("UPLOADING-BG");
				$("#validaActionAjax").val("backgroundFile");
				$('#user_background_url').val("---");
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
			});
			//this is for showing and hiding the file chooser
			$("#frmProfile_changePhotoButton").click(function() {
//				$('#frmProfile_changePhotoButton').fadeOut('slow');
//				$('#frmProfile_businessCardDiv').fadeOut('slow');
				$('#frmProfile_filePhoto').click();
//				$('#frmProfile_businessCardDiv').fadeOut('slow', function() {
//					$('#frmProfile_changePhotoDiv').fadeIn('slow');
//				});
			});
			$("#profileHiddenColor").click(function() {
				$("#profile_background_file").val('');
			});
			$("#profile_background_file, #profileChangeBgButtonDiv").click(function() {
				$("#profileHiddenColor").val('');
			});
			$("#profileChangeBgButtonDiv").click(function() {
				$('#profile_background_file').click();
				//showAndHide('profileChangeBgDiv', 'setDefaultBgDiv,profileChangeBgButtonDiv', 500);
			});
			$("#setDefaultBgDiv").click(function() {
				$("#actionAjax").val("DEFAULT-BG");
				$('#user_background_url').val("setDefault");
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
			});
			//Paypal INFO
			// $('.paypal_info').click(function(){
			// 	message('msgPaypal','<?=JS_PAYPALTITLE?>', "<?=$paypalMsg?>");
			// 	return false;
			// });
			//background color selector
			colorSelector('profileHiddenColorDiv','profileHiddenColor');
			$('#profileHiddenColor').blur(function() {
				disableButtons('<?=$all?>');
				$("#actionAjax").val("COLOR-BG");
				$("#validaActionAjax").val("HiddenColor");
				$('#user_background_url').val('---');
				$('loader.page',PAGE).show();
				console.log($("#validaActionAjax").val());
				$("#frmProfile_").submit();
			});
			/*
			VALIDANDO EL USERNAME
			$('#frmProfile_userName').blur(function() {
				disableButtons('< ?=$all?>');
				$('#divCheckingUsername').fadeIn(2000, function() {
					$('#divCheckingUsername').fadeOut(2000, function() {
						showAndHide('divValidUsername', 'divValidUsername', 2000, true)
					});
				});
				alert('chekear si el username es valido');
				enableButtons('< ?=$all?>');
			});*/
		<?php } ?>
		});
</script>

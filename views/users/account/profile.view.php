<?php
	$paypalMsg=DIALOG_PAYPAL;
	$wid=CON::getVal('SELECT users.id FROM users JOIN store_raffle_users ON users.email=store_raffle_users.email WHERE store_raffle_users.email = "'.$_SESSION['ws-tags']['ws-user']['email'].'";');
	$frmProfile=new forms();
	//opciones de muestra de la fecha de nacimiento
	$shows_birthday=$GLOBALS['cn']->query("SELECT * FROM users_profile_showbirthday ORDER BY id ASC");
	//codigos de area por pais
	$countries = CON::getArray("SELECT id,code,code_area,name FROM countries ORDER BY name ASC");
	//codigos de area por pais
	if(isset($_GET['showUploadError'])){
		mensajes(UPLOAD_IMAGE_ERROR,PUBLICITY_TITLEMSGSUCCfrmProfileBackgroundESS." ..!","");
	}
	//to fill language list
	$languages = CON::query("SELECT cod,id, name FROM languages");
	$sex=$_SESSION['ws-tags']['ws-user']['sex']!=''?$_SESSION['ws-tags']['ws-user']['sex']:1;
?>
<div id="frmProfile_View" class="ui-single-box clearfix">
	<?php //user messages (top) ?>
		<?=generateDivMessaje('divSuccess','250',NEWTAG_CTRMSGDATASAVE)?>
		<?=generateDivMessaje('divError','300',USERPROFILE_ERROR_SAVING,false)?>
	<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
	<h3 class="ui-single-box-title">
		&nbsp;<?=USERPROFILE_TITLEFIELDSET?>
	</h3>
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
				<a href="javascript:void(0);" class="color-pro" <?php if(RESETPASS_BTN1_TITLE!=""){?> title="<?=RESETPASS_BTN1_TITLE?>"<?php }?>><?=RESETPASS_BTN1?></a><br><br>
			</div>
			<div id="frmProfile_changePhotoDiv">
				<input name="frmProfile_filePhoto" type="file" id="frmProfile_filePhoto"/>
			</div>
			<div id="frmProfile_businessCardDiv">
				<?php if(!strpos($foto,"default.png")){ ?>
				<a href="<?=base_url('user/mini')?>" class="color-pro" <?php if(USER_CROPPROFILE_TITLE!=""){?> title="<?=USER_CROPPROFILE_TITLE?>"<?php } ?>>
					<?=USER_CROPPROFILE?>
				</a><br><br>
				<?php } ?>
				<a href="<?=base_url('user/preferences')?>" class="color-pro"><?=USERPROFILE_PREFERENCES?></a><br><br>
				<a href="<?=base_url('user/password')?>" class="color-pro"><?=MAINSMNU_PASSWORD?></a><br><br>
				<a href="<?=base_url('user/cards')?>" class="color-pro"><?=USERPROFILE_BUSINESSCARD?></a><br><br>
				<a href="<?=base_url('setting?sc=1')?>" class="color-pro"><?=NOTIFICATIONS_CONFIGURATIONSECTION?></a>
			</div>
		<?php } ?>
	</div>
	<div id="frmProfileFormContainer">
		<div>
			<div class="left">
				<?php //first name OR Company Name ?>
				<label><strong>(*)&nbsp;<?=(($_SESSION['ws-tags']['ws-user']['type']=='1')?SIGNUP_LBLADVERTISERNAME_FIELD:SIGNUP_LBLFIRSTNAME_FIELD)?>:</strong></label>
				<?=$frmProfile->imput(
					'frmProfile_firstName',
					$_SESSION['ws-tags']['ws-user']['name'],
					$anchoImput,'text','','',
					(($_SESSION['ws-tags']['ws-user']['type']==1)?SIGNUP_LBLADVERTISERNAME:SIGNUP_LBLFIRSTNAME).'|string|3')
				?>
			</div>
			<?php if( $_SESSION['ws-tags']['ws-user']['type']==0 ) { ?>
			<div class="left"><?php //last name ?>
				<label ><strong>(*)&nbsp;<?=SIGNUP_LBLLASTNAME_FIELD?>:</strong></label>
				<?=$frmProfile->imput('frmProfile_lastName', $_SESSION['ws-tags']['ws-user']['last_name'],$anchoImput,'text','','imputs_wrap_register',SIGNUP_LBLLASTNAME.'|string|3')?>
			</div>
			<?php } ?>
			<div class="left"><?php //nick name ?>
				<label><strong>(*)&nbsp;<?=SIGNUP_LBLSCREENNAME_FIELD?>:</strong></label>
				<?=$frmProfile->imput("frmProfile_screenName", $_SESSION['ws-tags']['ws-user']['screen_name'],$anchoImput, "text", "", "imputs_wrap_register", SIGNUP_LBLSCREENNAME."|string")?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div>
			<label><strong><?=USERPROFILE_LBLPROFILEUSERNAME?>:</strong></label>
			<div><?php //username ?>
				<input type="text" tipo="string" value="<?=$_SESSION['ws-tags']['ws-user'][username]?>" id="frmProfile_userName" name="frmProfile_userName"/>
				<?=generateDivMessaje('divCheckingUsername','250', 'revisando el username', 'left')?>
				<?=generateDivMessaje('divValidUsername',	'250', 'username disponible', 'left')?>
				<em class="font-size3 color-d">(<?=USERPROFILE_LBLHELPUSERNAME1?>)</em>
			</div>
			<em class="font-size3 color-d "><?=(($_SESSION['ws-tags']['ws-user'][username]!='') ? str_replace('*', $_SESSION['ws-tags']['ws-user'][username], USERPROFILE_LBLHELPUSERNAME2) : str_replace('*', USER_PROFILE, USERPROFILE_LBLHELPUSERNAME2))?></em>
			<label style="margin-top: 10px;"><strong><?=BIOMESSAGE?>:</strong></label>
			<div style="font-size: 10px"><?php //message personal ?>
				<input type="text" tipo="string" size="100" value="<?=$_SESSION['ws-tags']['ws-user']['personal_messages']?>" id="frmProfile_messagePersonal" name="frmProfile_messagePersonal"/>
				<span id="theCounter" ></span>&nbsp;max
			</div>
		</div>
		<div><?php //birth day ?>
			<label>
				<strong>(*)&nbsp;<?=($_SESSION['ws-tags']['ws-user'][type]=='1')?SIGNUP_LBLBUSINESSSINCE:SIGNUP_LBLBIRTHDATE?>:</strong>
			</label>
			<div>
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
					$rango=($_SESSION['ws-tags']['ws-user']['type']=='1'?0:13);
					for($i=date('Y')-$rango; $i>1930; $i--){ ?>
							<option <?=($year==$i ? "selected='selected'" : '')?>> <?=$i?> </option>";
					<?php } ?>
				</select>
				<?php if($_SESSION['ws-tags']['ws-user']['type']=='0'){ ?>
				<select name="frmProfile_showbirthday" id="frmProfile_showbirthday">
					<?php while ($show_birthday=mysql_fetch_assoc($shows_birthday)){ ?>
						<option value="<?=$show_birthday['id']?>" <?php if($_SESSION['ws-tags']['ws-user']['show_birthday']==$show_birthday[id]) echo "selected"; ?> ><?=lan($show_birthday['label'])?></option>
					<?php } ?>
				</select>
				<?php } ?>
			</div>
			<?php if($_SESSION['ws-tags']['ws-user']['type']=='0'){ ?>
			<a class="font-size3 color-d" href="javascript:void(0);" onclick="message('messages','<?=WHYDOIPROVIDEMYBIRTHDAY?>','<?=SIGNUP_MSJBIRTHDATEWARNING?>','',400,200);" onFocus="this.blur();"><?=WHYDOIPROVIDEMYBIRTHDAY?></a>
			<?php } ?>
		</div>
		<div class="clearfix">
			<div class="left"><?php //language ?>
				<label><strong><?=USERPROFILE_LBLLANGUAGE?>:</strong></label>
				<select name="frmProfile_cboLanguageUsr" id="frmProfile_cboLanguageUsr" w="150">
					<?php while($language=CON::fetchObject($languages)){ ?>
						<option value="<?=$language->cod?>" <?=($_SESSION['ws-tags']['ws-user']['language']!=$language->cod?'':'selected')?>><?=$language->name?></option>
					<?php } ?>
				</select>
			</div>
			<div class="left"><?php //country ?>
				<label><strong><?=BUSINESSCARD_LBLCOUNTRY?>:</strong></label>
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
				<label ><strong><?=SIGNUP_ZIPCODE?></strong></label>
				<input name="frmProfile_zipCode" type="text" id="frmProfile_zipCode" value="<?=$_SESSION['ws-tags']['ws-user']['zip_code']?>"/>
			</div>
		</div>
		<div class="clearfix">
			<div id="setCitys">
				<label ><strong>(*)&nbsp;<?=BUSINESSCARD_LBLCITY?>:</strong></label>
				<select name="city" id="city" requerido="<?=BUSINESSCARD_LBLCITY?>"></select>
			</div>
		</div>
		<?php if($_SESSION['ws-tags']['ws-user']['type']==0){ ?>
		<div><?php //home phone ?>
			<label><strong><?=USERPROFILE_LBLHOMEPHONE?>:</strong></label>
			<select id="home_code_search" name="frmProfile_home_code" w="150">
				<option value=""><?=USERPROFILE_LBLCBOAREASCODE?></option>
				<?php $number=explode('-',$_SESSION['ws-tags']['ws-user']['home_phone']);
				foreach ($countries as $row) { ?>
					<option value="<?=$row['id']?>" <?=($number[0]==$row['code_area']?'selected="1"':'')?>>
						<?=$row['name'].'&nbsp;('.$row['code_area'].')'?>
					</option>
				<?php } ?>
			</select>
			<input name="frmProfile_home" type="text" id="frmProfile_home" value="<?=$number[1]?>" tipo="integer"/>
			<em class="font-size3 color-d"><?=PROFILE_PHONELEYEND?></em>
		</div>
		<?php } ?>
		<div><?php // work phone ?>
			<label><strong><?=USERPROFILE_LBLWORKPHONE?>:</strong></label>
			<select name="frmProfile_work_code" id="work_code_search" w="150">
				<option value=""><?=USERPROFILE_LBLCBOAREASCODE?></option>
				<?php $number=explode('-',$_SESSION['ws-tags']['ws-user']['work_phone']);
				foreach ($countries as $row) { ?>
					<option value="<?=$row['id']?>" <?=($number[0]==$row['code_area']?'selected="1"':'')?>>
						<?=$row['name'].'&nbsp;('.$row['code_area'].')'?>
					</option>
				<?php } ?>
			</select>
			<input name="frmProfile_work" type="text" id="frmProfile_work" value="<?=$number[1]?>" tipo="integer"/>
			<em class="font-size3 color-d "><?=PROFILE_PHONELEYEND?></em>
		</div>
		<div><?php //mobile phone ?>
			<label><strong><?=USERPROFILE_LBLMOBILEPHONE?>:</strong></label>
			<select name="frmProfile_mobile_code" id="mobile_code_search" w="150">
				<option value=""><?=USERPROFILE_LBLCBOAREASCODE?></option>
				<?php $number=explode('-',$_SESSION['ws-tags']['ws-user']['mobile_phone']);
				foreach ($countries as $row) { ?>
					<option value="<?=$row['id']?>" <?=($number[0]==$row['code_area'] ? 'selected="1"' : '') ?> >
						<?=$row['name'].'&nbsp;('.$row['code_area'].')'?>
					</option>
				<?php } ?>
			</select>
			<input name="frmProfile_mobile" type="text" id="frmProfile_mobile" value="<?=$number[1]?>" tipo="integer" />
			<em class="font-size3 color-d"><?=PROFILE_PHONELEYEND?></em>
		</div>
		<?php if( $_SESSION['ws-tags']['ws-user']['type']!='1' ){ ?>
		<div><?php //sexo ?>
			<label><strong><?=SEX_TITLE?>:</strong></label>
			<select name="frmProfile_sex" id="frmProfile_sex" w="150">
				<option value="" >...</option>
				<option value="1" <?=($sex==1?"selected":'')?>><?=lan('SEX_MALE')?></option>
				<option value="2" <?=($sex==2?"selected":'')?>><?=lan('SEX_FEMALE')?></option>
			</select>
		</div>
		<div><?php //interes ?>
			<label><strong><?=lan('INTERESTED_IN')?>:</strong></label>
			<select name="frmProfile_interest" id="frmProfile_interest" w="150">
				<option value="" >...</option>
				<option value="1" <?=($_SESSION['ws-tags']['ws-user']['interest']==1?"selected":'')?>><?=lan('men')?></option>
				<option value="2" <?=($_SESSION['ws-tags']['ws-user']['interest']==2?"selected":'')?>><?=lan('women')?></option>
				<option value="2" <?=($_SESSION['ws-tags']['ws-user']['interest']===0?"selected":'')?>><?=lan('both')?></option>
			</select>
		</div>
		<div><?php //interes 
		//LOVING_RELATIONSHIP relacion amorosa
		//OPEN_RELATIONSHIP relacion abierta
		?>
			<label><strong><?=lan('Relationship')?>:</strong></label>
			<select name="frmProfile_relationship" id="frmProfile_relationship" w="150">
				<option value="" >...</option>
				<option value="1" >0</option>
			</select>
		</div>
		<?php }
		if($_SESSION['ws-tags']['ws-user']['type']=='1'){ ?>
			<?php if(PAYPAL_PAYMENTS): ?>
			<div class="frmProfilePaypalAccount" style="height: 45px">
				<label><strong><?=PROFILE_PAYINFO?> <a href="https://www.paypal.com/ve/cgi-bin/webscr?cmd=_registration-run&from=PayPal" title="" target="_blank">paypal</a> (Paypal ID <?=PROFILE_OREMAILPAY?>):</strong></label>
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
						<input type="button" value="<?=USERPROFILE_UPLOADBGTITTLE?>"/>
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
				<input name="frmProfile_btnSend" type="button" id="frmProfile_btnSend" value="<?=USERPROFILE_SAVE?>" />
				<input type="button" class="fb-buttom" name="btnFacebook" id="btnFacebook" value="<?=USERPROFILE_ASSOCFB?>">
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
	$('#frmProfile_').ajaxForm({
		dataType:'json',
		beforeSend:function(){
			pub=false;
		},
		success:function(data){
			console.log(data);
			$('loader.page',PAGE).hide();
			if (!data['error']){
				switch(data['success']){
					case 'updateLanguage': location.reload(); break;
					case 'filePhoto': redir('user/mini?ep'); break;
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
						if (typeUser=='0' && $('#frmProfile_home').val()!='' && !validateForm('frmProfile_home')){	stri+=stri!=''?' <?=ANDLABEL?> <?=USERPROFILE_LBLHOMEPHONE?>':'<?=USERPROFILE_LBLHOMEPHONE?>';}
						if ($('#frmProfile_work').val()!='' && $('#work_code_search').val()==''){ select+='<?=USERPROFILE_LBLWORKPHONE?>'; }
						if (typeUser=='0' && ($('#frmProfile_home').val()!='' && $('#home_code_search').val()=='')){ select+=select!=''?', <?=USERPROFILE_LBLHOMEPHONE?>':'<?=USERPROFILE_LBLHOMEPHONE?>'; }
						if ($('#frmProfile_mobile').val()!='' && $('#mobile_code_search').val()==''){ select+=select!=''?' <?=ANDLABEL?> <?=USERPROFILE_LBLMOBILEPHONE?>':'<?=USERPROFILE_LBLMOBILEPHONE?>'; }
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
							$('div#divErroPhoneCode span').html(select);
							showAndHide('divErroPhoneCode','divErroPhoneCode',1500,true);
						}else{
							$('div#divErroPhone span').prepend(stri);
							showAndHide('divErroPhone',	'divErroPhone',	1500, true);
						}
					}
				}
				$.loader('hide');
		});
		//FIN control de los botones send y back
		//control del formulario perfil
		//calendario
		$('select').each(function(){
			if (this.id!="city"){
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

		<?php if( $_SESSION['ws-tags']['ws-user']['fullversion']!=1 ) { ?>
			$("#frmProfile_changePhotoButton").click(function() {
				$('#frmProfile_filePhoto').click();
			});
			$('#frmProfile_filePhoto').bind('change',function(){
				console.log($('#frmProfile_filePhoto').val());
				$("#validaActionAjax").val("filePhoto");
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
			});
			$("#profileHiddenColor").click(function() {
				$("#profile_background_file").val('');
			});
			$("#profileChangeBgButtonDiv").click(function() {
				$('#profile_background_file').click();
				$("#profileHiddenColor").val('');
			});
			$('#profile_background_file').bind('change',function(){
				$("#validaActionAjax").val("backgroundFile");
				$('loader.page',PAGE).show();
				$("#frmProfile_").submit();
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
</script>

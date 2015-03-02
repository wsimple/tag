<?php
	if ($_GET['o'] == 'fb') {
		require 'controls/facebook/facebook.php';
		$user = $facebook->getUser();

		if ($user) {
			try {
				$user_profile = $facebook->api('/me/?fields=id,first_name,last_name,email,birthday,location,gender');
				// $user_profile = $facebook->api('/me'); //Consulto todos los datos
			} catch (FacebookApiException $e) {
				$user = null;
			}
		}
	}
	$fbFirstName = ($user_profile['first_name'] != '') ? $user_profile['first_name'] : '';
	$fbLastName = ($user_profile['last_name'] != '') ? $user_profile['last_name'] : ''; 
	$fbBirthday = ($user_profile['birthday'] != '') ? $user_profile['birthday'] : ''; 
	$fbEmail = ($user_profile['email'] != '') ? $user_profile['email'] : ''; 
	$fbId = ($user_profile['id'] != '') ? $user_profile['id'] : '0'; 
?>
<container id="signup" class="bg cache">
	<content id="select">
	<div id="contentBoxes">
		<div class="contentBordeSignup">
			<div id="box-register" style="float: left;">
				<div style="display: table-cell; vertical-align: middle; text-align: center">
					<div id="personal">
						<div class="ui-box personal">
							<div class="imgPersonal"></div>
							<div class="tituloRegister"><?=SMT_PERSONALPROFILE?></div>
							<div class="textOrange UpPersonal"><?=SMT_PERSONALPROFILEINFO?>&nbsp;<span><?=SMT_PERSONALPROFILEINFO1?></span></div><br>
							<div class="textRegister" align="center">
								<div class="medidas"><img src="css/tbum/point.png"><?=SMT_PERSONALPROFILEPREFERENCES?><span>&nbsp;<?=SMT_PERSONALPROFILEPOINTS?></span></div>
								<div class="medidas"><img src="css/tbum/point.png"><?=SMT_PERSONALPROFILEPREFERENCES2?>&nbsp;<span class="textOrange"><?=SMT_PERSONALPROFILEPREFERENCES3?></span>:<br><span><?=SMT_PERSONALPROFILEPERSONALIZED?></span></div>
								<div class="medidas"><img src="css/tbum/point.png"><?=SMT_PERSONALPROFILETRADE?>&nbsp;<span><?=SMT_PERSONALPROFILESAVE?>&nbsp;</span><span class="color_dolar"><?=SMT_PERSONALPROFILEDOLARS?></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="box-register" style="float: right;">
				<div style="display: table-cell; vertical-align: middle; text-align: center">
					<div id="business">
						<div class="ui-box business">
							<div class="imgBusiness"></div>
							<div class="tituloRegister"><?=SMT_BUSINESSPROFILE?></div><br>
							<div class="textRegister" align="center"><br>
								<div class="medidas"><?=SMT_BUSINESSPROFILEBEST?></div>
								<div class="medidas"><span><?=SMT_BUSINESSPROFILEBASE?></span></div>
								<div class="medidas"><span class="textOrange"><?=SMT_BUSINESSPROFILESENCE?></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</content>

	<content class="personal" style="display: none">
	<form action="controls/users/register.json.php" id="frmRegister" name="frmRegister" method="post" >
		<div id="PersonalRegisterContent">
			<div class="ui-box-outline">
				<div class="ui-box RegisterSignUp">
					<div class="ui-single-box-title" style="margin-bottom: 0px"><?=MNU_REGISTER?></div>
					<div class="singUpInfo">
						<div class="imgPersonal"></div>
						<div class="tituloRegister"><?=SMT_PERSONALPROFILE?></div>
						<div class="textOrange UpPersonal"><?=SMT_PERSONALPROFILEINFO?>&nbsp;<span><?=SMT_PERSONALPROFILEINFO1?></span></div><br>
						<div class="textRegister" align="center">
							<div class="medidas"><img src="css/tbum/point.png"><?=SMT_PERSONALPROFILEPREFERENCES?><span>&nbsp;<?=SMT_PERSONALPROFILEPOINTS?></span></div>
							<div class="medidas"><img src="css/tbum/point.png"><?=SMT_PERSONALPROFILEPREFERENCES2?>&nbsp;<span class="textOrange"><?=SMT_PERSONALPROFILEPREFERENCES3?></span></div>
							<div class="medidas"><img src="css/tbum/point.png"><?=SMT_PERSONALPROFILETRADE2?></div>
							<div class="medidas"><?=SMT_PERSONALPROFILETRADE3?></div>
							<div class="medidas"><span><?=SMT_PERSONALPROFILESAVE?>&nbsp;</span><span class="color_dolar"><?=SMT_PERSONALPROFILEDOLARS?></span></div>
						</div>
						<div class="messageGoTo"><?=MESSAGERETURNBUSINESS?></div>
						<input type="button" name="btnReturnBusiness" class="float-left" id="btnReturnBusiness" value="<?=BTNGOTOBUSINESSPROFILE?>"/>
					</div>
					<div class="signUpInput">
						<p><input value="<?=$fbFirstName?>" type="text" name="name" id="name" placeholder="* <?=SIGNUP_LBLFIRSTNAME_FIELD?>" requerido="<?=SIGNUP_LBLFIRSTNAME?>" tipo="words" /></p>
						<p><input value="<?=$fbLastName?>" type="text" name="lastName" id="lastName" placeholder="* <?=SIGNUP_LBLLASTNAME_FIELD?>" requerido="<?=SIGNUP_LBLLASTNAME?>" tipo="words" /></p>
						<p>
							<label><?=USER_LBLBIRTHDATE?></label>
							<input  value="<?=$fbBirthday?>" type="text" name="date" id="date" placeholder="mm/dd/yyyy" requerido="<?=SIGNUP_LBLBIRTHDATE?>" />
							<br/>
							<a href="<?=HREF_DEFAULT?>" id="whydontseebirth">
								<span>*<?=WHYDOIPROVIDEMYBIRTHDAY?></span>
							</a>
						</p>
						<p><input value="<?=$fbEmail?>" type="email" name="email" id="email" placeholder="* <?=SIGNUP_LBLEMAIL_FIELD?>" requerido="<?=SIGNUP_LBLEMAIL?>" tipo="email"  /></p>
						<p><input type="password" name="password" id="password" class="text_box size_box" placeholder="* <?=LBL_PASS_FIELD?>" requerido="<?=LBL_PASS?>" tamanio="6"/></p>
						<p>
							<input type="password" name="repassword" id="repassword" class="text_box size_box" placeholder="* <?=LBL_CONFIRPASS_FIELD?>" requerido="<?=LBL_CONFIRPASS?>" tamanio="6"/>
							<br/>
							<span><?=USERPROFILE_PASSWORD?></span><br><br/><br/>
							<span><?=REQUIRED?></span><br>
							<span><?=TEXT_TERMS?></span><br>
							<span class="color-a"><a href="<?=base_url('terms?sign')?>"><?=TEXT_LINKTERMS?></a></span>
						</p>
						<input  value="<?=$fbId?>" type="hidden" name="fbid" id="fbid" />
						<input type="button" name="btnSignUp" class="float-right" id="btnSignUp" value="<?=SIGNUP_BTNNEXT?>"/>
					</div>
					<div class="close-ui-box" id="closePersonal"> X </div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</form>
	</content>

	<content class="business" style="display: none">
	<form action="controls/users/register.json.php" id="frmRegisterCompany" name="frmRegisterCompany" method="post" >
		<div id="BusinessRegisterContent">
			<div class="ui-box-outline">
				<div class="ui-box RegisterSignUp">
					<div class="ui-single-box-title" style="margin-bottom: 0px"><?=MNU_REGISTER?></div>
					<div class="singUpInfo">
						<div class="imgBusiness"></div>
						<div class="tituloRegister"><?=SMT_BUSINESSPROFILE?></div><br/>
						<div class="textRegister" align="center">
							<?=SMT_BUSINESSPROFILEBEST?><br/>
							<span><?=SMT_BUSINESSPROFILEBASE?></span><br/>
							<span class="textOrange"><?=SMT_BUSINESSPROFILESENCE?></span>
						</div>
						<div class="messageGoTo downTop"><?=MESSAGERETURNPERSONAL?></div>
						<input type="button" name="btnReturnPersonal" class="float-left" id="btnReturnPersonal" value="<?=BTNGOTOPERSONALPROFILE?>"/>
					</div>
					<div class="signUpInput">
						<p><input value="<?=$fbFirstName.''.$fbLastName?>" type="text" name="name" id="nameB" placeholder="* <?=SIGNUP_LBLADVERTISERNAME_FIELD?>" requerido="<?=SIGNUP_LBLADVERTISERNAME?>"  /></p>
						<p>
							<label><?=SMT_SIGNUP_LBLBUSINESSSINCE?></label>
							<input value="<?=$fbBirthday?>" type="text" name="date" id="dateB" placeholder="mm/dd/yyyy" requerido="<?=SIGNUP_LBLBUSINESSSINCE_FIELD?>"/>
							<br/>
							<a href="<?=HREF_DEFAULT?>" id="whydontprovibusi">
								<span>* <?=WHYDOIPROVIDEMYBUSINESSSINCE?></span>
							</a>
						</p>
						<p><input value="<?=$fbEmail?>" type="email" name="email" id="email" placeholder="* <?=SIGNUP_LBLEMAIL_FIELD?>" requerido="<?=SIGNUP_LBLEMAIL?>" tipo="email"  /></p>
						<p><input type="password" name="password" id="password" class="text_box size_box" placeholder="* <?=LBL_PASS_FIELD?>" requerido="<?=LBL_PASS?>" tamanio="6"/></p>
						<p>
							<input type="password" name="repassword" id="repassword" class="text_box size_box" placeholder="* <?=LBL_CONFIRPASS_FIELD?>" requerido="<?=LBL_CONFIRPASS?>" tamanio="6"/>
							<br/>
							<span><?=USERPROFILE_PASSWORD?></span><br><br><br>
							<span><?=REQUIRED?></span><br>
							<span><?=TEXT_TERMS?></span><br>
							<span class="color-a"><a href="<?=base_url('terms?sign')?>"><?=TEXT_LINKTERMS?></a></span>
						</p>
						<input  value="<?=$fbId?>" type="hidden" name="fbid" id="fbid" />
						<input type="button" name="btnSignUpCompany" class="float-right" id="btnSignUpCompany" value="<?=SIGNUP_BTNNEXT?>"/>
					</div>
					<div class="close-ui-box" id="closeBusiness"> X </div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<input type="hidden" name="company" value="1">
	</form>
	</content>
	<script type="text/javascript">
		$(function() {
			$.on({
				open:function(){
					$('footer').hide();
				}
			});
			
			$('#whydontseebirth').click(function(){
				message('messages', '<?=WHYDOIPROVIDEMYBIRTHDAY?>', '<?=SIGNUP_MSJBIRTHDATEWARNING?>', '', 500, 300);
			});

			$('#whydontprovibusi').click(function(){
				message('messages', '<?=WHYDOIPROVIDEMYBUSINESSSINCE?>', '<?=SIGNUP_MSJBIRTHDATEWARNING?>', '', 500, 300);
			});

			$('#termUseSignUp').click(function(){
				message('messages', '<?=TERMSOFUSE?>', '', '', 500, 300, DOMINIO+'views/main/data.view.php?xs=terms');
			});

			$('#termUseSignUpBu').click(function(){
				message('messages', '<?=TERMSOFUSE?>', '', '', 500, 300, DOMINIO+'views/main/data.view.php?xs=terms');
			});

			$('div#personal,div#business').click(function(){
				var that=this;
				$('content#select').fadeOut('slow',function(){
					$('content.'+that.id).fadeIn('slow');
				});
			});
			$('#closePersonal,#closeBusiness').click(function(){
				$(this).parents('content').fadeOut('slow',function(){
					$('content#select').fadeIn('slow');
				});
			});

			$('#btnReturnPersonal').click(function(){
				$(this).parents('content').fadeOut('slow',function(){
					$('content.personal').fadeIn('slow');
				});
			});

			$('#btnReturnBusiness').click(function(){
				$(this).parents('content').fadeOut('slow',function(){
					$('content.business').fadeIn('slow');
				});
			});

			$('#btnSignUp, #btnSignUpCompany').click(function() {
				if( valida($(this).parents('form'))) $(this).parents('form').submit();
			});

			var options = {
					dataType: 'json',
					success: function(data){

						if(data['msg']=="5"){
							console.log("correo duplicado"+data['msg']+data['email']);
							message('respuesta','<?=MNU_REGISTER?>','<?=SIGNUP_CTRERROREMAIL2?>','','','','','');
						}else if(data['msg']=="6"){
							console.log("contrasena no cioncide"+data['msg']+data['email']);
							message('respuesta','<?=MNU_REGISTER?>','<?=SIGNUP_CTRERRORBIRTHDATE?>','','','','','');
						}else if(data['msg']=="9"){
							console.log("contrasena no cioncide"+data['msg']+data['email']);
							message('respuesta','<?=MNU_REGISTER?>','<?=SMT_SIGNUP_PASSWORDNOTMATCH?>','','','','','');
						}else if(data['msg']=="10"){
							console.log("fecha invalida"+data['msg']+data['email']);
							message('respuesta','<?=MNU_REGISTER?>','<?=SIGNUP_CTRERRORBIRTHDATE?>','','','','','');
						}else{
							// post-submit callback   alert(data);
							console.log("paso"+data['msg']+data['email']);
							//message('respuesta','<logo style="width: 130px;height: 50px;"></logo>','<div style="text-align:center;"><strong><?=SMT_SIGNUP_SUCCESS_TRUE?></strong></div>','',300,300,'','#home');
                            $.dialog({
								title	: '<logo style="width: 130px;height: 50px;"></logo>',
								content	: '<div style="text-align:center;"><strong><?=SMT_SIGNUP_SUCCESS_TRUE?></strong></div>',
								height	: 300,
                                width	: 300,
								close	: function(){
									redir('');
								}
							});
						}
					}//success
				};//options

			$('#frmRegister, #frmRegisterCompany').ajaxForm(options);

			$('#date').datepicker({
				changeMonth: true,
				changeYear: true,
				defaultDate: '-18Y',
				maxDate: '0Y',
				minDate: '-100Y',
				yearRange: 'c-100,c'
			});
			
			$('#dateB').datepicker({
				changeMonth: true,
				changeYear: true,
				defaultDate: '-18Y',
				maxDate: '0Y',
				minDate: '-100Y',
				yearRange: 'c-100,c'
			});
			
		});
	</script>
</container>
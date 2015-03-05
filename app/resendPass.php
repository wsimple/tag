<?php include 'inc/header.php'; ?>
<div id="page-resend" data-role="page" data-cache="false">
	<div id="sub-menu" style="position:absolute;top:0px;left:0;padding:0px;" data-position="fixed"  >
		<div style="float: left; margin-left: 10px; margin-top: 20px">
		<a id="bntBack" data-icon="arrow-l" href="#"> </a>
		<div class="titleRP" ></div>
		<br/>
		</div>
		<div style="float: right; margin-right: 20px; margin-top: 20px">
		<a id="btnResendPas" data-icon="arrow-r" href="#" data-iconpos="right"></a>
		<br/>
		</div>	</div>

	<div data-role="content" class="list-content">

		<div class="fs-wrapper">
			<form id="frmResend" name="frmResend" method="post">
				<div>
					<input type="email" name="email" id="email" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset" onfocus="inputFocus(this)">
				</div>
				<div id="resendP_info"></div>
			</form>
			<form id="frmReset" name="frmReset" method="post">
				<div>
				<div id="respuesta"></div>
					<strong><label id="passwordLabel" class="needed"></label></strong>
					<input id="password" name="password" type="password" class="password-field" onkeypress="return enterTab(event,this)" onfocus="inputFocus(this)"/>
					<strong><label id="repasswordLabel" class="needed"></label></strong>
					<input id="repassword" name="confiPassword" type="password"  class="password-field" onkeypress="return enterSubmit(event,this)" onfocus="inputFocus(this)"/>
					<div id="msgPassword" style="font-size:12px;"></div>
				</div>
			</form>
		</div>

	</div>

<script>
	pageShow({
		id: '#page-resend',
		title:function(){
			return $_GET['usr']?lang.RESET_TITLERESETPASS:lang.MAINSMNU_PASSWORD;
		},
		before:function(){
			$('.fs-wrapper').css('position','initial');
			$('#btnResendPas').html(lang.send);
			$('#bntBack').html(lan('Back'));
			if ($_GET['usr']){
				$('#frmResend').hide();
				$('#passwordLabel').html(lang.SIGNUP_PASSWORD);
				$('#repasswordLabel').html(lang.SIGNUP_PASSWORD2);
				$('#msgPassword').html(lang.USERPROFILE_PASSWORD);
			}else{
				$('#frmReset').hide();
				$('#email').attr('placeholder',lan('Email'));
				$('#resendP_info').html(lang.RESET_MESSAGEPRINCIPAL);
			}
			if(is['android']) $('#password,#repassword').attr('type','text').addClass('password-field');
		},
		login:function(logged){
			if(logged) redir(PAGE['home']);
		},
		after:function(){
			$('#bntBack').click(function(){
				if($_GET['usr'])
					redir(PAGE.ini);
				else
					goBack();
			});
			var $form;
			if ($_GET['usr']){
				$form=$('#frmReset').submit(function(){
					var strin='';
					if($('#password').val()=='') strin=strin+lang.SIGNUP_CTRERRORPASS;
					if($('#repassword').val()=='') strin=(strin==''?strin:strin+' and ')+lang.SIGNUP_CONFIRMPASSWORD;
					if (strin==''){
						if($('#password').val().length>=6){
							// alert($('#password').val()+'---'+$('#repassword').val());
							if ($('#password').val()==$('#repassword').val()){
								// alert($('#password').val()+'---'+$('#repassword').val()+'---'+$_GET['usr']);
								myAjax({
									url: DOMINIO+'controls/users/resetPassword.json.php',
									type	: 'POST',
									dataType: 'json',
									data	:{
										clave1	: $('#password').val(),
										clave2	: $('#repassword').val(),
										id		: $_GET['usr'],
										action  :1,
                                        out     :'out'
									},
									success	:function(data){
										// $('#respuesta').html('<div>error: '+data['error']+'</div><div>mensaje: '+data['mensaje']+'</div>');
    										if (data['exit']){
                                                myDialog({
    												id:'confi-resetPass',
    												content:'<div style="font-weight: bold;text-align:center;">'+lang.RESET_MSGNRESETPASS+'</div>',
    												style:{'max-height':30,'height':30,'padding':'10px 10px'},
    												buttons:{
    													'Ok':function(){
    														redir(PAGE.ini);
    													}
    												}
    											});
                                            }else if(data['error']){
                                                var cont=lang.PASS_MESSAGEERROR;
                                                switch(data['error']){
                                                    case 'noPasCoin': cont=lang.RESETPASS_ERROR1; break;
                                                    case 'pasMenorleng': cont=lang.USERPROFILE_PASSWORD; break;
                                                }
                                                showMsgError(cont,'#password|#repassword'); 
                                            }
										}
									});
							}else showMsgError(lang.PASS_MESSAGEERROR,'#password|#repassword');
						}else showMsgError(lang.USERPROFILE_PASSWORD,'#password|#repassword');
					}else showMsgError(strin,'#password|#repassword');
					return false;
				});
			}else{
				$form=$('#frmResend').submit(function(){
					if ($('#frmResend input').val()!=''){
						if(validateForm('frmResend input')){
							myAjax({
								url: DOMINIO+'controls/users/resetPassword.json.php',
								type	: 'POST',
								dataType: 'json',
								data	:{
									email	: $('#frmResend input').val(),
									action	:0
								},
								success	:function(data){
									if (data['exit']){ showMsgEmail(data['exit']); }
                                    else if(data['error']){
                                        var cont=lang.SIGNUP_CTRERROREMAIL;
                                        switch(data['error']){
                                            case 'emailInvalid': cont=lang.EMAIL_ERROR; break;
                                            case 'emailNotExist': cont=lang.EMAIL_ERROR_NE; break;
                                            case 'notEmail': cont=lang.FORGOT_CTRMSGERROR; break;
                                        }
                                        showMsgError(cont,'#frmResend input'); 
                                    }										
								}
							});
						}else showMsgError(lang.SIGNUP_CTRERROREMAIL,'#frmResend input');
					}else showMsgError(lang.SIGNUP_CTRERROREMAIL,'#frmResend input');
					return false;
				});
			}
			$('#btnResendPas').click(function(){
				$form.submit();
			});
			function validateForm(Input){
				if(typeof Input==='string') Input=$('#'+Input)[0];
				var regex;
				regex = /^[a-zA-Z]([\.-]?\w+)*@[a-zA-Z]([\.-]?\w+)*(\.\w{2,3}){1,2}$/;
				return Input.value.match(regex);
			}
			function showMsgEmail(email){
				myDialog({
					id:'confi-email',
					content:'<div style="text-align:center;">'
							+'<h3>'+lang.RESET_PLEASECHECKEMAIL+'</h3>'
							+'<span>'+lang.RESET_WESENTMESSAGE
							+' '+email+' '
							+lang.RESET_LINKNISHSIGNUP+'</span>'
							+'</div>',
					style:{'max-height':100,'height':100,'padding':'10px 10px'},
					buttons:{
						'Ok':function(){
							goBack();
						}
					}
				});
			}
			function showMsgError(label,input){
				var inputs=input.split('|');
				myDialog({
					id:'MsgError',
					content: '<div style="text-align:center;">'+label+'</div>',
					buttons:{
						'Ok':function(){
							$(inputs[0]).removeAttr('disabled');
							if(inputs[1]) $(inputs[1]).removeAttr('disabled');
							this.close();
						}
					}
				});
			}
		}
	});
</script>
</div>
<?php include 'inc/footer.php'; ?>

<container id="resendPassword" class="bg">
	<content class="resendPassword" id="verifyCheckEmail">
		<div class="ui-box-outline">
			<div class="ui-box">
				<div class="ui-single-box-title"><h3><?=MAINSMNU_PASSWORD?></h3></div>
					<div class="resend-image"></div>
					<div class="color-c resendPassword_div_form">
						<form id="frmResend" method="post" action="controls/users/resetPassword.json.php">
							<div>
								<input type="email" name="email" id="email" class="text_box" value="" placeholder="<?=RESET_ENTERYOUREMAIL?>" requerido="<?=LBL_LOGIN?>" tipo="email"/>
							</div>
							<div class="legend"><?=RESET_MESSAGEPRINCIPAL?></div>
							<input type="button" name="btnResendPas" id="btnResendPas" value="<?=RESET_BTNRESETPASS?>"/>
						</form>
					</div>
                    <div class="close-ui-box" id="resend_close">X</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</content>

	<content class="resendPassword" style="display: none" id="exito_verifyCheckEmail">
		<div class="ui-box-outline">
			<div class="ui-box">
				<div class="ui-single-box-title"><h3><?=RESET_EMAILNOTIFICATION?></h3></div>
				<div class="reset-image" style=""></div>

					<div class="color-c resetPassword_div_form" style="">

							<div class="legend_reset">
								<span><?=RESET_PLEASECHECKEMAIL?></span><br><br>
								<?=RESET_WESENTMESSAGE?><br>
								<div id="email_check_password"></div>
								<?=RESET_LINKNISHSIGNUP?>
							</div>
						<input type="button" style="width:70px" name="btnResendPas" id="btnResetDone" value="<?=RESET_BTNDONE?>" />
					</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</content>
</container>
<script type="text/javascript">

$(function() {
	$('#resend_close,#btnResetDone').click(function(){
		redir('');
	});
	$('#btnResendPas').click(function(){
	   var formulario=$(this).parents('form');
	   if( valida($(formulario))){
	       $(formulario).append('<input type="hidden" name="action" value="0"/>').submit();
	   }  
    });
	
	var options = {
			dataType: 'json',
			success: function(data){ 
                if (data['exit']){
                    $('#verifyCheckEmail').fadeOut('slow',function(){$('#exito_verifyCheckEmail').fadeIn('slow');});
					$('#email_check_password').html(data['exit']);
                }else if(data['error']){
                    var cont='<?=PASS_MESSAGEERROR?>';
                    switch(data['error']){
                        case 'emailInvalid': cont='<?=EMAIL_ERROR?>'; break;
                        case 'emailNotExist': cont='<?=EMAIL_ERROR_NE?>'; break;
                        case 'notEmail': cont='<?=FORGOT_CTRMSGERROR?>';
                    }
                    message('Message','<?=MAINSMNU_PASSWORD?>',cont,'','','','',''); 
                }
			}//success
	};//options
	$('#frmResend').ajaxForm(options);
});
</script>
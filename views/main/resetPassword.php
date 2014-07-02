<?php
$query = $GLOBALS['cn']->query("
			 SELECT id,name
			 FROM users
			 WHERE md5(CONCAT(id, '+', id, '+', id)) = '".$_GET['usr']."'
	");
$array = mysql_fetch_assoc($query);
if($array['id']!=''){ ?>
<container id="resetPassword" class="bg">
	<content class="resendEmailPassword" style="display: none">
		<div class="ui-box-outline">
			<div class="ui-box">
				<div class="ui-single-box-title"><h3><?=RESET_TITLERESETPASS?></h3></div>
				<div class="resetEmail-image"></div>
					<div class="color-c resetEmailPassword_div_form">
						<form id="frmResetEmail" name="frmResend" method="post" action="controls/users/resetPassword.json.php">
							<div>
								<label for="clave1"><?=RESETPASS_LABEL1?></label><br>
								<input type="password" name="clave1" id="clave1" class="text_box" value="" style="width: 200px" requerido="<?=RESETPASS_LABEL1?>" tamanio="6" /><br>
								<span class="legend"> <?=RESET_MSGCHANGEONLYSIXCHAR?> </span>
							</div>
							<div>
								<label for="clave2"><?=RESETPASS_LABEL2?></label><br>
								<input type="password" name="clave2" id="clave2" class="text_box" value="" style="width: 200px" requerido="<?=RESETPASS_LABEL2?>" tamanio="6" />
							</div>
							<input type="button" name="btnResetEmail" id="btnResetEmail" value="<?=RESET_BTNRESETPASS?>" />
						</form>
					</div>
				<div class="close-ui-box" id="resend_close">X</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</content>
</container>
<script type="text/javascript">
$(function() {
	$('#resend_close').click(function(){
		document.location.hash = '#home';
	});
	$('.resendEmailPassword').fadeIn('fast');
	$('#btnResetEmail').click(function(){
	   var formulario=$(this).parents('form');
		if( valida(formulario)) $(formulario).append('<input type="hidden" name="id" value="<?=$array['id']?>" />'+
                                                        '<input type="hidden" name="out" value="out"/>'+
                                                        '<input type="hidden" name="action" value="1"/>').submit();
	});
	var options = {
			dataType: 'json',
			success: function(data){ // post-submit callback
				if (data['exit']){
                    message('Message','<?=RESET_TITLERESETPASS?>','<?=RESET_MSGNRESETPASS?>','','','','','#home');
                }else if(data['error']){
                    var cont='<?=PASS_MESSAGEERROR?>';
                    switch(data['error']){
                        case 'noPasCoin': cont='<?=RESETPASS_ERROR1?>'; break;
                        case 'pasMenorleng': cont='<?=RESET_MSGCHANGEONLYSIXCHAR?>'; break;
                    }
                    message('Message','<?=MAINSMNU_PASSWORD?>',cont,'','','','',''); 
                }
			}
	};
	$('#frmResetEmail').ajaxForm(options);
});
</script>
<?php }else{ ?>
<script type="text/javascript">
	$(function() {
		message('Message','<?=RESET_TITLEALERTEMAILPASSWORD?>','<?=RESET_ALERTEMAILPASSWORD?>','','','','','#resendPassword');
	});
</script>
<?php }?>

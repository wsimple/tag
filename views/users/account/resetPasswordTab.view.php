<?php $frmChangePassword = new forms(); ?>
<div class="ui-single-box">
	<div style="margin-left: 20px;">
		<h3 class="ui-single-box-title" style="margin-bottom: 0px;">&nbsp;<?=MAINSMNU_PASSWORD?></h3>
		<form action="controls/users/resetPassword.json.php" id="frmChangePassword"  method="post" >
			<div style="padding-bottom: 10px;">
				<span style="font-size: 12px;"><?=RESETPASS_TITLE2?></span><br>
				<span style="font-size: 11px; color: #ff8a28;"><?=REQUIRED?></span>
			</div>
			<div class="ui-box-outline" style="width: 600px;">
				<div id="imagenBackgroundPassword" class="ui-box">
					<div class="this"></div>
					<div id="optionInputPassword">
							<div>
									<span>*<?=SIGNUP_PASSWORD?>:</span>
									<?=$frmChangePassword->imput("clave0", "", 220, "password", "", "", SIGNUP_PASSWORD."||6")?>
									<span><span><?=USERPROFILE_PASSWORD?></span></span>
							</div>
							<div>
									<span>*<?=RESETPASS_LABEL1?>:</span>
									<?=$frmChangePassword->imput("clave1", "", 220, "password", "", "", RESETPASS_LABEL1."||6")?>
							</div>
							<div>
									<span>*<?=RESETPASS_LABEL2?>:</span>
									<?=$frmChangePassword->imput("clave2", "", 220, "password", "", "", RESETPASS_LABEL2."||6")?>
							</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div id="botonPreferences" style="margin-top:20px;" align="right" data-type="horizontal" >
				<input name="frmChangePassword_btnChange" type="button" id="frmChangePassword_btnChange" value="<?=MAINSMNU_PASSWORD?>" style="margin-right: 200px;"/>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    	$$("[title]").tipsy({html: true,gravity: 'n'});
    		$("#frmChangePassword_btnChange").click(function() {
                if( valida('frmChangePassword')){
                    if($("#clave1").val() == $("#clave2").val()) {
                        $('#frmChangePassword').append('<input type="hidden" name="id" value="<?=$_SESSION['ws-tags']['ws-user']['id']?>" />'+
                                                            '<input type="hidden" name="action" value="1"/>').submit();  
                    }else{ message('messages', 'Error', "<?=RESETPASS_ERROR1?>", '', 300, 220); }
                }
    
    		});			
    
    	var options = {
    	    dataType: 'json',
    		success	: function(data) {
    		    if (data['exit']){
                    message('Message','<?=RESET_TITLERESETPASS?>','<?=RESET_MSGNRESETPASS?>','','','','');
                    $("#clave0,#clave1,#clave2").val("");
                }else if(data['error']){
                    var cont='<?=PASS_MESSAGEERROR?>';
                    switch(data['error']){
                        case 'noPasCoin': cont='<?=RESETPASS_ERROR1?>'; break;
                        case 'pasMenorleng': cont='<?=RESET_MSGCHANGEONLYSIXCHAR?>'; break;
                        case 'pasInvalid': cont='<?=RESETPASS_ERROR4?>'; break;
                    }
                    message('Message','<?=MAINSMNU_PASSWORD?>',cont,'','','',''); 
                }
    		}
    	};
    	$('#frmChangePassword').ajaxForm(options);
    });
</script>

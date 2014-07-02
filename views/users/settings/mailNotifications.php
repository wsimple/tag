<script type="text/javascript">
	$(document).ready(function() {
		$("#frmConfigmail_btnChange").click(function() {

				$('#frmConfigmail').submit();
		});
		$("#frmConfigmail_btnHome").click(function() {
			document.location.hash='home';
		});
		
		$('[title]').tipsy({html: true,gravity: 'n'});

	});

	function mail(id){
		$('.tipsy').remove();
		$('#box'+id).html('<img src="img/loader.gif" width="17" height="17" />');
		$.ajax({
			url: 'controls/users/settings/mail.php?id_noti='+id,
			success	: function(responseText) {
				//alert(responseText);
				datos = responseText.split('|');
				switch(datos[0]){
					case '0':
					case '1':
						$('#box'+id).html(datos[1]);
						$('[title]').tipsy({html: true,gravity: 'n'});
					break;
				}
			}
		});
	}

</script>

<div class="ui-single-box mailSettings font_size1">
	<h3 class="ui-single-box-title">
		&nbsp;<?=USERPROFILE_TITLEMAILSETTINGS?>
	</h3>
	<div class="legend">
		<div class="text"><?=PRIVACY_DESCRIPTIONSECTION?></div>
		<div class="icons">
			<div>
				<span><?=PRIVACY_ACTIVESECTION?></span>
				<img src="imgs/config_noti_email.png" width="16" height="16"/>
			</div>
			<div>
				<span><?=PRIVACY_INACTIVESECTION?></span>
				<img src="imgs/config_noti_unselect.png" width="16" height="16"/>
			</div>
		</div>
	</div>
	<div class="list">
			<?php
				$notifiTypes = $GLOBALS['cn']->query("
					SELECT 
						id,
						name,
						icon,
						message_description 
					FROM type_notifications 
					WHERE status = 1 
					ORDER BY id ASC
				");
				
				while ($notifiType = mysql_fetch_assoc($notifiTypes)){
					$notifiUsers = $GLOBALS['cn']->query('
						SELECT * 
						FROM users_config_notifications 
						WHERE id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'" AND 
							  id_notification="'.$notifiType['id'].'"
					');
					$notifiUser = mysql_fetch_assoc($notifiUsers);
					//icon
					if ($notifiUser['id_notification']==$notifiType['id']){
						$icons['icon']['photo'] = 'imgs/config_noti_unselect.png';
						$icons['icon']['title'] = PRIVACY_ACTIVESECTION;
						$icons['icon']['id'] = 'btn_unmail';
					}else{
						$icons['icon']['photo'] = 'imgs/config_noti_email.png';
						$icons['icon']['title'] = PRIVACY_INACTIVESECTION;
						$icons['icon']['id'] = 'btn_mail';
					}
			?>	
					<div class="row">
						<img id="btn_mail_unmail" src="<?=$notifiType['icon']?>" class="type" />
						<div class="name"><?=constant($notifiType[name])?></div>
						<div class="desc"><?=constant($notifiType['message_description'])?></div>
						<div class="acti" id="box<?=$notifiType['id']?>">
							<img id="<?=$icons['icon']['id']?>" src="<?=$icons['icon']['photo']?>" onclick="mail('<?=$notifiType['id']?>');" title="<?=$icons['icon']['title']?>" />
						</div>
					</div>
			<?php 
				}//while 
			?>
	</div>
	<div class="clearfix"></div>
</div>
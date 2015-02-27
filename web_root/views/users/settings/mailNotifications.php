<div id="mailSettings" class="ui-single-box font_size1">
	<h3 class="ui-single-box-title"><?=$lang['USERPROFILE_TITLEMAILSETTINGS']?></h3>
	<div class="menuProfileBack">
		<a href="<?=base_url('profile')?>"><?=USER_PROFILE?></a> > <?=NOTIFICATIONS_CONFIGURATIONSECTION?>
	</div>
	<div class="legend">
		<div class="text"><?=$lang['PRIVACY_DESCRIPTIONSECTION']?></div>
		<div class="icons">
			<div>
				<span><?=$lang['PRIVACY_ACTIVESECTION']?></span>
				<img src="imgs/config_noti_email.png" width="16" height="16"/>
			</div>
			<div>
				<span><?=$lang['PRIVACY_INACTIVESECTION']?></span>
				<img src="imgs/config_noti_unselect.png" width="16" height="16"/>
			</div>
		</div>
	</div>
	<div class="list">
			<?php
				$SQLIN='3';
				if ($_SESSION['ws-tags']['ws-user']['type']==1){

				}else{
					$SQLIN.=',15,29';
				}
				$notifiTypes = CON::query("	SELECT t.id,t.label_name,t.label_desc,
											(SELECT u.id FROM users_config_notifications u WHERE u.id_user=? AND u.id_notification=t.id) AS active 
											FROM type_actions t
											WHERE t.status = 1 AND t.id NOT IN ($SQLIN)
											ORDER BY t.id ASC",array($_SESSION['ws-tags']['ws-user']['id']));
				while ($row=CON::fetchAssoc($notifiTypes)){
			?>	
					<div class="row">
						<div tipo="<?=$row['id']?>"></div>
						<div class="name"><?=$lang[$row['label_name']]?></div>
						<div class="desc"><?=$lang[$row['label_desc']]?></div>
						<div class="acti <?=$row['active']?'inactive':'active'?>" title="<?=$row['active']?$lang['PRIVACY_INACTIVESECTION']:$lang['PRIVACY_ACTIVESECTION']?>"></div>
					</div>
			<?php } ?>
	</div>
	<div class="clearfix"></div>
</div>
<script >
	$(document).ready(function() {
		$('[title]').tipsy({html: true,gravity: 'n'});
		$('#mailSettings div.list div.acti').click(function(){
			if ($(this).hasClass('loader')) return;
			var obje=this;
			var action=$(obje).hasClass('active')?1:0,type=$(obje).parents('.row').find('div[tipo]').attr('tipo');
			$(obje).addClass('loader').removeAttr('original-title');
			$.ajax({
				type:'POST',
				data:{action:action,type:type},
				url: 'controls/settings/mail.json.php',
				dataType:'json',
				success	: function(data) {
					if (data['suc']){
						switch(data['action']){
							case '0': $(obje).removeClass('loader').removeClass('inactive')
									.addClass('active').attr('title',"<?=$lang['PRIVACY_ACTIVESECTION']?>");
							break;
							case '1': $(obje).removeClass('loader').removeClass('active')
									.addClass('inactive').attr('title',"<?=$lang['PRIVACY_ACTIVESECTION']?>");
							break;
						}
					}else{ $(obje).removeClass('loader'); }
					$('[title]').tipsy({html: true,gravity: 'n'});
				}
			});
		});
	});
</script>
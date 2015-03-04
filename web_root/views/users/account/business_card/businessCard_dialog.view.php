<?php
		if( !@$exclude ) {
			include '../../../../includes/session.php';
			include ("../../../../includes/config.php");
			include ("../../../../includes/functions.php");
			include ("../../../../class/wconecta.class.php");
			include ("../../../../includes/languages.config.php");

		} elseif($noMenu) { $exclude = false; }
		
		if((isset($_GET['uid']) && (!@$noMenu))) {
			include '../../../../class/validation.class.php';
		}elseif ($noMenu) {
			include 'class/validation.class.php';
		}

		// $noMenu --> is used to hide the menu on business card when the user has not paid
		// $exclude -> need to start session and include files when called from

			$fields = "	address,				 company,		specialty,		email,				middle_text,
						home_phone,				 work_phone,	mobile_phone,	company_logo_url,	background_url,
						md5(id_user) AS id_user, text_color";

			if( isset($_GET['uid']) || $userInfo['id'] ) {// WHEN CALLED FROM userProfile.view OR account.view OR externalProfile.view

								$result	= $GLOBALS['cn']->query("	SELECT ".$fields."
																	FROM business_card
																	WHERE md5(id_user) = '".($_GET['uid'] ? $_GET['uid'] : md5($userInfo['id']))."'
																	AND type='0'");

								if( mysql_num_rows( $result )>0 ) {

									$user		= $GLOBALS['cn']->query("SELECT	CONCAT(u.name, ' ', u.last_name) AS full_name,
																				u.screen_name,
																				u.email
																		FROM users u
																		WHERE md5(id) = '".($_GET['uid'] ? $_GET['uid'] : md5($userInfo['id']))."';");

									$bc		= mysql_fetch_assoc($result);
									$user	= mysql_fetch_assoc($user);

									fillBusinessCardData($theUserName,		$theUserSpecialty,	$theUserCompany,
														$theUserAddress,	$theUserPhone,		$theUserEmail,
														$theUserLogo,		$theUserMiddleText,	$bc,
														$user);
								}


			} elseif( isset($_GET['bc']) ) {//WHEN CALLED FROM businessCard.view OR from the button on the BC

							$result = $GLOBALS['cn']->query("SELECT	".$fields.",
																	(SELECT concat(u.name, ' ', u.last_name) FROM users u WHERE id = id_user) AS nameUsr
															FROM business_card
															WHERE md5(id) ='".$_GET['bc']."'");


							if( mysql_num_rows( $result )>0 ) {

									$bc = mysql_fetch_assoc($result);
									fillBusinessCardData($theUserName,		$theUserSpecialty,	$theUserCompany,
														$theUserAddress,	$theUserPhone,		$theUserEmail,
														$theUserLogo,		$theUserMiddleText,	$bc, '');
							}

			} else {//WHEN CALLED FROM businessCardPicker.view

					fillBusinessCardData($theUserName,		$theUserSpecialty,	$theUserCompany,
										$theUserAddress,	$theUserPhone,		$theUserEmail,
										$theUserLogo,		$theUserMiddleText,	$bc, '');
			}
	?>



			<?php
			//THIS IS THE MENU LOCATED OVER THE BUSINESS CARD
			if( !isset ($_GET['bc']) && @$exclude ) {
				include('menuBusinessCard.php');
			}
			?>

			<table id="bc_principal" width="350" border="0" align="center" class="bussiness_card" style="background-image:url(<?=FILESERVER.'img/bc_templates/'.$bc['background_url']?>);">
				<tr>
					<?php // logo ?>
					<td width="171" style="border-right:1px solid #FFC800; padding-right:3px">
						<div id="bc_embedded_logo"
							 style="width:150px; height:50px;
									background-image:<?=$theUserLogo ? 'url('.FILESERVER.'img/bc_logos/'.($userInfo['code'] ? $userInfo['code'] : $_SESSION['ws-tags']['ws-user']['code']).'/'.$theUserLogo.')' : 'url(css/tbum/logo-white-orange.png)'?>;
									background-repeat:no-repeat;
									background-position:center;background-size: 145px 45px;">
						</div>
					</td>

					<?php // username ?>
					<td width="172" style="padding-left:3px; text-align:center; border-left:1px solid #FFC800;">
						<label id="bc_embedded_username" style="text-align: center; font-size:14px; color: <?=$bc['text_color']?>">
							<strong style="text-shadow:0.1em 0.1em #FFFFFF;"><?=$theUserName?></strong>
						</label>
						<br/>
						<label id="bc_embedded_specialty" style="text-align: center; font-size:12px; text-shadow:0.1em 0.1em #FFFFFF; color: <?=$bc['text_color']?>">
							<?=$theUserSpecialty?>
						</label>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="font-size:11px;">
						<label id="bc_embedded_company" style="float: left; text-shadow:0.1em 0.1em #FFFFFF; color: <?=$bc['text_color']?>">
							<strong><?=$theUserCompany?></strong>
						</label>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="text-align:center">
						<label id="bc_embedded_middleText" style="font-size:20px; font-weight:bold; text-shadow:0.1em 0.1em #FFFFFF; color: <?=$bc['text_color']?>">
						<?php if($theUserMiddleText) {
							if( isValidURL($theUserMiddleText) ) { ?>

								<a target="_blank" onfocus="this.blur()" style="text-decoration: none"
								   href="<?=(preg_match('/https?:\/\//', $theUserMiddleText) ? '' : 'http://' ).$theUserMiddleText?>">
									<font style="color: <?=$bc['text_color']?>; cursor: pointer"> <?=$theUserMiddleText?></font>
								</a>

							<?php } else {
								echo $theUserMiddleText;
							}
						} else { ?>

							<a target='_blank' onfocus='this.blur()' style='text-decoration: none' href='http://tagbum.com'>
								<font style="color: <?=$bc['text_color']?>; cursor: pointer">Tagbum.com</font>
							</a>
						<?php } ?>
						</label>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="padding:5px;">
						<?php //if( $theUserAddress ) { ?>
							<table style="font-size: 100%">
								<tr>

									<td id="addressLabel" style="vertical-align:top; <?=($theUserAddress ? '' : 'display: none; ')?> color: <?=$bc['text_color']?>">
										<strong	style="text-shadow:0.1em 0.1em #FFFFFF;"><?=ADDRESS_BC_USERPROFILE?>:</strong>
									</td>

									<td style="vertical-align: top">
										<label id="bc_embedded_address" style="text-shadow:0.1em 0.1em #FFFFFF; font-size: 9px; color: <?=$bc['text_color']?>">
											<?=$theUserAddress?>
										</label>
									</td>

								</tr>
							</table>
						<?php //} ?>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="border-top:1px solid #FFC800; text-align:center;padding-left:5px">
						<label id="bc_embedded_phones"
							   style="text-shadow:0.1em 0.1em #FFFFFF; font-size:9px; color: <?=$bc['text_color']?>">
									<?=$theUserPhone?>
						</label>
						<label id="bc_embedded_email"
							   style="text-shadow:0.1em 0.1em #FFFFFF; font-size:9px; color: <?=$bc['text_color']?>">

							<?php if( isValidEmail($theUserEmail) ) { ?>

								<a onfocus="this.blur()" href="mailto:<?=$theUserEmail?>" style="text-decoration:none;">
									<font style="color: <?=$bc['text_color']?>; cursor: pointer"><?=$theUserEmail?></font>
								</a>
							<?php } else {
								echo $theUserEmail;
							} ?>

						</label>
					</td>
				</tr>
			</table>
<script>
	$$(document).ready(function() {
		$('li[id^="liDefaultBc"]').click(function(){
			console.log('has hecho click en un default');
			$('li[id^="liDefaultBc"]').each(function(){
				$(this).next('li').show();
			});
			$(this).next('li').hide();
		});
	});
</script>

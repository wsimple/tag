<?php
	addJs('js/funciones_bc.js');

/*if($_SESSION['ws-tags']['ws-user']['fullversion']!=1) {*/ ?>


		<script type="text/javascript">
			$(function(){
				//$('#listOfBusinessCards').jScrollPane();
			});
			function disableButton(id) {
				//$('#'+id).button("disable");
			}
		</script>

<?php
//refrescar el businessCards por defecto
$BCD = $GLOBALS['cn']->query("
					UPDATE business_card
					SET
						id_user=0,
						address='',
						company='',
						specialty='',
						email='',
						middle_text='',
						home_phone='',
						work_phone='',
						mobile_phone='',
						company_logo_url='',
						background_url='',
						text_color=''
					WHERE type=2;");

$businessCards = $GLOBALS['cn']->query("SELECT	id,
												id_user,
												type,
												address,
												company,
												specialty,
												email,
												middle_text,
												home_phone,
												work_phone,
												mobile_phone,
												company_logo_url,
												background_url,
												text_color,
												(SELECT concat(u.name,' ',u.last_name) FROM users u WHERE id=id_user) AS nameUsr
										FROM business_card
										WHERE id_user ='".$_SESSION['ws-tags']['ws-user'][id]."'");


	//NEW BUSINESS CARD ?>
<div class="ui-single-box">
	<h3 class="ui-single-box-title"><?=USERPROFILE_BUSINESSCARD?></h3>
			<div style="margin-bottom: 10px;width: 100%;">
					<?php if( $_SESSION['ws-tags']['ws-user'][super_user]=='0' && $_SESSION['ws-tags']['ws-user'][type]=='1' ) { ?>
						<div>
							<img src="img/menu_users/paypal.png" border="0" style="float:right"/>
						</div>
						<div>
							<input	type="button"
									value="<?=BC_TO_ADD_BUTTON?>"
									onclick="paymentBusinessCard('<?=BUSINESSCARDPAYMENT_TITLEMSGBOX?>', '<?=EXPIREDACCOUNT_MSGBOXWINDOWSWARNING?>');"
									style="float:right"/>
						</div>
					<?php } else { ?>
							<input	id="addBusinessCardButton"
									name="addBusinessCardButton"
									type="button"
									value="<?=BC_TO_ADD_BUTTON?>"
									onfocus="this.blur()"
									onclick="disableButton('addBusinessCardButton');actionsBusinessCard(2, '<?=md5($bc['id'])?>');"
									style="float:right"/>
					<?php } ?>
					<div class="clearfix"></div>
			</div>
		<div style="<?=($_SESSION['ws-tags']['ws-user']['fullversion']==1 ? 'overflow:auto; width: 845px;' : '')?>">
			<div id="listOfBusinessCards" onfocus="this.blur();">
				<ul>
						<?php while( $bc = mysql_fetch_assoc($businessCards) ) {?>

							<li id="<?=md5($bc[id])?>" style="list-style: none; padding: 25px; <?=($_SESSION['ws-tags']['ws-user']['fullversion']!=1 ?	"width: 330px; height: 210px; float: left;" : "width: 370px; height: 250px;")?>">
								<?php
									$exclude = true;
									include("businessCard_dialog.view.php");
								?>
							</li>

						<?php } ?>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
</div>
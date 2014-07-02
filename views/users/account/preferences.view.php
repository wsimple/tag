

<?php $all = 'frmProfile_btnSend'; ?>

<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
		$('#frmPreferences').ajaxForm({
			success : function(responseText) {
				responseText= responseText.split('_');

				if( responseText.length==3 ) {
					showAndHide('divSuccessPref', 'divSuccessPref', 1800, true);
				} else {
					showAndHide('divErrorPref', 'divErrorPref', 1800, true);
				}
			}
		});
		
			function disableButtons(id) {
				id = id.split(',');
				for(i=0; i<id.length; i++) {
//					$('#'+id[i]).button("disable");
				}
			}

			function enableButtons(id) {
				id = id.split(',');
				for(i=0; i<id.length; i++) {
//					$('#'+id[i]).button("enable");
				}
			}
		
		$$("[title]").tipsy({html: true,gravity: 'n'});
		/*efecto click*/
		$('#div_preference_1').slideUp();
		$('#div_preference_2').slideUp();
		$('#div_preference_3').slideUp();
		$('#like').click(function(){
			$('#div_preference_1').slideDown();
			$('#div_preference_2').slideUp();
			$('#div_preference_3').slideUp();
		});
		$('#need').click(function(){
			$('#div_preference_1').slideUp();
			$('#div_preference_2').slideDown();
			$('#div_preference_3').slideUp();
		});
		$('#want').click(function(){
			$('#div_preference_1').slideUp();
			$('#div_preference_2').slideUp();
			$('#div_preference_3').slideDown();
		});
		/*control de los botones send y back*/
			$("#frmPreferences_btnSend").click(function() {
				$('#frmPreferences').submit();
				$('#div_preference_1').slideUp();
				$('#div_preference_2').slideUp();
				$('#div_preference_3').slideUp();
			});
			$("#frmPreferences_btnHome").click(function() {
				document.location.hash='home';
			});
		/*FIN control de los botones send y back*/
		


	});
</script>
<div class="ui-single-box" style="height: 780px;">

	<form action="controls/users/preferences.control.php" id="frmPreferences" name="frmPreferences" method="post" style="padding:0;  margin:0;" enctype="multipart/form-data">
			

			<div id="frmProfile_View" style="margin-left: 20px; padding-top: 8px; max-width: 690px;">
				<h3 class="ui-single-box-title">&nbsp;<?=PREFERENCES_SETTINGS?></h3>


						
						<div style="font-size: 12px; margin-bottom: 10px;margin-left: 20px;">
							<!--span>It's all about <img src="css/preferences/exclamation_y.png align" align="middle">ou...<br-->
							<span><?=PREFERENCESTEXT1?><br>
							<!--br>Tell Us Your <strong style="color: #ff8a28;">Likes, Wants & Needs</strong>: Start Receiving Insider - Only Information just For <img src="css/preferences/exclamation_y.png" align="middle">ou.</span><br-->
							<?=PREFERENCESTEXT2?>&nbsp;<strong style="color: #ff8a28;"><?=PREFERENCESTEXT3?>&nbsp;</strong><?=PREFERENCESTEXT4?></span><br>
						</div>
					
						<div id="imageOptionPreferences" class="ui-box-outline">
							<div class="ui-box" style="padding: 8px 10px;">
									<div class="separatorPreferences" style="float: left">
										<div>
											<strong><?=PREFERENCES_WHATILIKE?></strong>
										</div>
										<div class="backgroundImagenPreferences">
											<a id="like" href="<?=HREF_DEFAULT?>">
													<div class="shadowImagenPreferencesLike">
													</div>
											</a>
										</div>
									</div>
									<div class="separatorPreferences" style="float: left">
										<div>
											<strong><?=PREFERENCES_WHATIWANT?></strong>
										</div>
										<div class="backgroundImagenPreferences">
											<a id="need" href="<?=HREF_DEFAULT?>" >
													<div class="shadowImagenPreferencesWant">
													</div>
											</a>
										</div>
									</div>
									<div style="float: left">
										<div>
											<strong><?=PREFERENCES_WHATINEED?></strong>
										</div>
										<div class="backgroundImagenPreferences">
											<a id="want" href="<?=HREF_DEFAULT?>" >
													<div class="shadowImagenPreferencesNeed" style="border-right: 0px;">
													</div>
											</a>
										</div>
									</div>
							<div class="clearfix"></div>
								<div style="height: 30px;">
									<?=generateDivMessaje('divErrorPref',	'450', PREFERENCES_ERROR, false) ?>
									<?=generateDivMessaje('divSuccessPref',	'300', NEWTAG_CTRMSGDATASAVE) ?>
								</div>
							<div id="listOptionPreferences">
							</div>
							<div class="clearfix"></div>
						
							<?php $query = $GLOBALS['cn']->query("SELECT id, name FROM preferences LIMIT 0 , 30"); ?>
							<?php while($preference = mysql_fetch_assoc($query)) { ?>
								<script type="text/javascript">
									$(document).ready(function() {
										$("#preference_<?=$preference[id]?>").fcbkcomplete({
											json_url: "includes/preferencesHelp.php?id=<?=$preference[id]?>",
											newel:true,
											filter_selected:true,
											addontab : true,
											filter_hide: true
										});
										<?php
										$detalles = $GLOBALS['cn']->query("	SELECT preference FROM users_preferences
																			WHERE	id_user = '".$_SESSION['ws-tags']['ws-user'][id]."' AND
																					id_preference = '$preference[id]'");
										$detalles = mysql_fetch_assoc($detalles);
										$detalles = $detalles[preference];
										$detalles = explode(',', $detalles);
										if( count($detalles) )
										{
											foreach($detalles as $preferencia)
											{
												if( trim($preferencia) )
												{
													$detalle = $GLOBALS['cn']->query("SELECT detail FROM preference_details WHERE id = '".$preferencia."'");
													if( mysql_num_rows($detalle)!=0 ) {
														$detalle = mysql_fetch_assoc($detalle);
														$detalle = $detalle[detail];
													} else {
														$detalle = $preferencia;
													} ?>
													$("#preference_<?=$preference[id]?>").trigger("addItem", [{"title": "<?=$detalle?>", "value": "<?=$preferencia?>"}]);

												<?php }
											}
										} /*END if(count($detalles))*/?>
									});
								</script>
								<div id="div_preference_<?=$preference[id]?>">
									<strong style="padding: 0px;"><?=constant($preference[name])?>:</strong>
									<select id="preference_<?=$preference[id]?>" name="preference_<?=$preference[id]?>"></select>
								</div>
							<?php } ?>
						
						</div>
					</div>
				<div id="botonPreferences" style="padding-top: 10px;">
					<!--input name="frmPreferences_btnHome" type="button" id="frmPreferences_btnHome" value="<?=SIGNUP_BTNBACK?>" /-->
					<input name="frmPreferences_btnSend" type="button" id="frmPreferences_btnSend" value="<?=USERPROFILE_SAVE?>" />
					<br><br>
					<!--a href="<?=HREF_DEFAULT?>" name="frmPreferences_btnSend" id="frmPreferences_btnSend">
						<strong><?=USERPROFILE_SAVE?></strong>
					</a-->
					<br><br>
				</div>
			</div>
			<div class="clearfix"></div>
			
	</form>
	<div class="clearfix"></div>
</div>

<div class="ui-single-box" style="height: 780px;">
	<form action="controls/users/preferences.json.php?action=up" id="frmPreferences" name="frmPreferences" method="post" >
			<div id="frmProfile_View" style="margin-left: 20px; padding-top: 8px; max-width: 690px;">
				<h3 class="ui-single-box-title">&nbsp;<?=PREFERENCES_SETTINGS?></h3>
					<div class="menuProfileBack">
						<a href="<?=base_url('profile')?>"><?=USER_PROFILE?></a> > <?=USERPROFILE_PREFERENCES?>
					</div>
						<div style="font-size: 12px; margin-bottom: 10px;margin-left: 20px;">
							<span><?=PREFERENCESTEXT1?><br>
							<?=PREFERENCESTEXT2?>&nbsp;<strong style="color: #ff8a28;"><?=PREFERENCESTEXT3?>&nbsp;</strong><?=PREFERENCESTEXT4?></span><br>
						</div>
						<div id="imageOptionPreferences" class="ui-box-outline">
							<div class="ui-box" style="padding: 8px 10px;">
									<div class="separatorPreferences" style="float: left">
										<div><strong><?=$lang['PREFERENCES_WHATILIKE']?></strong></div>
										<div class="backgroundImagenPreferences">
											<a id="like" href="<?=HREF_DEFAULT?>">
												<div class="shadowImagenPreferencesLike"></div>
											</a>
										</div>
									</div>
									<div class="separatorPreferences" style="float: left">
										<div><strong><?=$lang['PREFERENCES_WHATIWANT']?></strong></div>
										<div class="backgroundImagenPreferences">
											<a id="need" href="<?=HREF_DEFAULT?>" >
												<div class="shadowImagenPreferencesWant"></div>
											</a>
										</div>
									</div>
									<div style="float: left">
										<div><strong><?=$lang['PREFERENCES_WHATINEED']?></strong></div>
										<div class="backgroundImagenPreferences">
											<a id="want" href="<?=HREF_DEFAULT?>" >
												<div class="shadowImagenPreferencesNeed" ></div>
											</a>
										</div>
									</div>
							<div class="clearfix"></div>
								<div style="height: 30px;">
									<?=generateDivMessaje('divErrorPref',	'450', PREFERENCES_ERROR, false) ?>
									<?=generateDivMessaje('divSuccessPref',	'300', NEWTAG_CTRMSGDATASAVE) ?>
								</div>
							<div class="clearfix"></div>
							<div id="div_preference_1">
								<strong style="padding: 0px;"><?=$lang['PREFERENCES_WHATILIKE']?>:</strong>
								<input id="preference_1" name="preference_1[]">
								<!--<select id="preference_1" name="preference_1[]"></select> -->
							</div>
							<div id="div_preference_2">
								<strong style="padding: 0px;"><?=$lang['PREFERENCES_WHATIWANT']?>:</strong>
								<input id="preference_2" name="preference_2[]">
								<!--<select id="preference_2" name="preference_2[]"></select> -->
							</div>
							<div id="div_preference_3">
								<strong style="padding: 0px;"><?=$lang['PREFERENCES_WHATINEED']?>:</strong>
								<input id="preference_3" name="preference_3[]">
								<!--<select id="preference_3" name="preference_3[]"></select> -->
							</div>
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
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#frmPreferences').ajaxForm({
			success : function(data) {
				if(data['insert']) showAndHide('divSuccessPref', 'divSuccessPref', 1800, true);
				else showAndHide('divErrorPref', 'divErrorPref', 1800, true);
			}
		});
			
		$$("[title]").tipsy({html: true,gravity: 'n'});
		/*efecto click*/
		$('#div_preference_1,#div_preference_2,#div_preference_3').slideUp();
		$('#like').click(function(){
			$('#div_preference_1').slideDown();
			$('#div_preference_2,#div_preference_3').slideUp();
		});
		$('#need').click(function(){
			$('#div_preference_2').slideDown();
			$('#div_preference_1,#div_preference_3').slideUp();
		});
		$('#want').click(function(){
			$('#div_preference_1,#div_preference_2').slideUp();
			$('#div_preference_3').slideDown();
		});
		/*control de los botones send y back*/
		$("#frmPreferences_btnSend").click(function() {
			$('#div_preference_1,#div_preference_2,#div_preference_3').slideUp();
			$('#frmPreferences').submit();
		});
		$("#frmPreferences_btnHome").click(function() {
			redir('');
		});
		/*FIN control de los botones send y back*/
		$('#preference_1,#preference_2,#preference_3').select2({
			placeholder:'<?=$lang["USERPROFILE_PREFERENCES"]?>',
			minimumInputLength:1,
			multiple:true,
			width:'100%',
			formatInputTooShort:"<?=$lang['MINIMOCARACTERESSELECT2']?>",
			createSearchChoice:function(term, data) { 
				if ($(data).filter(function() { 
					return this.text.localeCompare(term)===0; 
				}).length===0) {return {id:term, text:term};} 
			},
			openOnEnter:true,
			ajax:{
				url:'controls/users/preferences.json.php?action=sr',
				data:function(term,page){ return { term: term }; },
				results:function(data,page){ return { results: data };}
			}
		});
		$.ajax({
			type	:	"GET",
			url		:	"controls/users/preferences.json.php?action",
			dataType:	"json",
			success	:	function (data) {
				if (data['dato']){
					$('#preference_1').select2("data", data['dato']['1']);
					$('#preference_2').select2("data", data['dato']['2']);
					$('#preference_3').select2("data", data['dato']['3']);
				}
			}
		});
	});
</script>
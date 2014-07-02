<?php include 'inc/header.php'; ?>
<div id="page-preferences" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<a id="buttonBack_preferences" href="#" data-icon="arrow-l" onclick="redir(PAGE['profile']+'?id='+$.local('code'));"></a>
		<h1>&nbsp;</h1>
		<a id="btnPreferences_update" href="#" onClick="savePreferences($('#typePre').val(), $('#txtPrefe').val());" data-icon="check"></a>
	</div>
	<div data-role="content" class="list-content">
		<img class="bg" src="img/bg.png" />
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<div class="smt-tag-content" style="text-align: left">
					<fieldset data-role="controlgroup">
						<legend id="titleOptionPrefe" style="font-weight: bold">&nbsp;</legend>
						<input type="radio" name="radio-choice-1" id="radio-choice-1" value="choice-1" onclick="$('#typePre').val(1);putBoxPreference(1);" />
						<label for="radio-choice-1" id="labelTypePrefe1">What I like</label>
						<input type="radio" name="radio-choice-1" id="radio-choice-2" value="choice-2" onclick="$('#typePre').val(2);putBoxPreference(2);"  />
						<label for="radio-choice-2" id="labelTypePrefe2">What I need</label>
						<input type="radio" name="radio-choice-1" id="radio-choice-3" value="choice-3" onclick="$('#typePre').val(3);putBoxPreference(3);"  />
						<label for="radio-choice-3" id="labelTypePrefe3">What I want</label>
					</fieldset>
					<label id="labelTxtPrefe" for="txtPreFe"></label>
					<textarea id="txtPrefe" name="txtPrefe" style="resize: none;"></textarea>
					<span id="prefere_legend" style="font-size: 10px;display:block;"></span>
					<input id="typePre" name="typePre" type="hidden" value="" />
				</div>
			</div>
		</div>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul>
				<li><a id="labelChoosePre" class="ui-btn-active" onclick="redir(PAGE['preferences']);" >&nbsp;</a></li>
				<li><a id="labelSeekPre" onclick="redir(PAGE['seekpreferences']);">&nbsp;</a></li>
				<li><a id="labelMyPrefe" onclick="preferencesUsers(4,'',$('#typePre').val());"></a></li>
			</ul>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-preferences',
			title:lang.USERPROFILE_PREFERENCES,
			before:function(){
				//languaje
				$('#buttonBack_preferences').html(lan('Back'));
				$('#labelTypePrefe1').html(lang.PREFERENCES_WHATILIKE);
				$('#labelTypePrefe2').html(lang.PREFERENCES_WHATINEED);
				$('#labelTypePrefe3').html(lang.PREFERENCES_WHATIWANT);
				$('#titleOptionPrefe').html('<strong>'+lang.PREFERENCES_LBLCHOOSEOP+':</strong>');
				$('#labelTxtPrefe').html('<strong>'+lang.USERPROFILE_PREFERENCES_TITLE+':</strong>');
				$('#prefere_legend').html(lang.PREFERENCES_HOLDERSEARCH);
				$('#labelSeekPre').html(lang.seek);
				$('#labelChoosePre').html(lang.PREFERENCES_LBLCHOOSEOPFOOTER);
				$('#labelMyPrefe').html(lang.PREFERENCES_BTNMINE);
				$('#btnPreferences_update').html(lang.PREFERENCES_BTNUPDATE);
				$('#txtPrefe').attr('placeholder', lang.PREFERENCES_HOLDERSEARCH);
				$('.list-wrapper').jScroll({hScroll:false});
			},
			after:function(){
				var typePrefe = ($_GET['typePrefe']!=''&&$_GET['typePrefe']!=undefined) ? $_GET['typePrefe'] : ($('#typePre').val()!=''?$('#typePre').val():1);
				$('.fs-wrapper').jScroll({hScroll:false});
				$('#radio-choice-'+typePrefe).attr('checked', true).checkboxradio('refresh');
				putBoxPreference(typePrefe);
				$('#typePre').val(typePrefe);
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

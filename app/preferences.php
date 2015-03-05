<?php include 'inc/header.php'; ?>
<script> var opc={type:1,dato:[]}; </script>
<div id="page-preferences" data-role="page" data-cache="false">
	<div id="sub-menu" style="position:absolute;top:0px;left:0;padding:0px;" data-position="fixed"  >
		<ul class="ui-grid-d"></ul>
	</div>

	<div data-role="content" class="list-content">
		<img class="bg" src="css/smt/bg.png" />
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<div class="smt-tag-content" style="text-align: left">
					<fieldset data-role="controlgroup">
						<legend id="titleOptionPrefe" style="font-weight: bold" data-theme="m" >&nbsp;</legend>
						<input type="radio" name="radio-choice-1" id="radio-choice-1" value="choice-1" onclick="changePrefe(opc,1);" data-theme="m"  />
						<label for="radio-choice-1" id="labelTypePrefe1" data-theme="m" ></label>
						<input type="radio" name="radio-choice-1" id="radio-choice-2" value="choice-2" onclick="changePrefe(opc,2);"  data-theme="m" />
						<label for="radio-choice-2" id="labelTypePrefe2" data-theme="m" ></label>
						<input type="radio" name="radio-choice-1" id="radio-choice-3" value="choice-3" onclick="changePrefe(opc,3);"  data-theme="m" />
						<label for="radio-choice-3" id="labelTypePrefe3"  data-theme="m" ></label>
					</fieldset>
					<label id="labelTxtPrefe" for="txtPreFe"></label>
					<textarea id="txtPrefe" name="txtPrefe" style="resize: none;" ></textarea>
					<span id="prefere_legend" style="font-size: 10px;display:block;"></span>
					<input id="typePre" name="typePre" type="hidden" value="" />

					<div style="margin-top: 20px;">
						<div style="float: left;">
							<a id="buttonBack_preferences" href="#" data-icon="arrow-l" onclick="goBack();" style="color: #505F6D"></a>
						</div>
						<div style="float: right">
							<a id="btnPreferences_update" style="display:none" href="#" onClick="savePreferences(opc);" data-icon="check" style="color: #505F6D"></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div id="footer" data-role="footer" data-position="fixed" data-theme="f" style="background-color: #E1E6E7 !important;">
		<div data-role="navbar">
			<ul>
				<li><a id="labelChoosePre" class="ui-btn-active" onclick="redir(PAGE['preferences']);" >&nbsp;</a></li>
				<li><a id="labelSeekPre" onclick="redir(PAGE['seekpreferences']+'?type='+$('#typePre').val());">&nbsp;</a></li>
				<li><a id="labelMyPrefe" onclick="preferencesUsers();"></a></li>
			</ul>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-preferences',
			title:lang.USERPROFILE_PREFERENCES,
			before:function(){
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="store.html">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-c points"></li>'+
					'<li class="ui-block-d newtag"><a href="newtag.html">'+lan('newtag','ucw')+'</a></li>'
				);				
				//languaje
				$('#buttonBack_preferences').html(lan('Back'));
				$('#labelTypePrefe1').html(lang.PREFERENCES_WHATILIKE);
				$('#labelTypePrefe2').html(lang.PREFERENCES_WHATIWANT);
				$('#labelTypePrefe3').html(lang.PREFERENCES_WHATINEED);
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
				opc.type = ($_GET['typePrefe']!=''&&$_GET['typePrefe']!=undefined) ? $_GET['typePrefe'] : ($('#typePre').val()!=''?$('#typePre').val():1);

				$('.fs-wrapper').jScroll({hScroll:false});
				$('#radio-choice-'+opc.type).attr('checked', true).checkboxradio('refresh');
				putBoxPreference(opc);
				$('#typePre').val(opc.type);
			}
		});

		function putBoxPreference(opc){
			myAjax({
				type	:'GET',
				url		:DOMINIO+'controls/users/preferences.json.php?code='+$.local('code')+'&action=1',
				dataType:'json',
				error	:function(/*resp,status,error*/){
					myDialog('#singleDialog',lang.conectionFail);
				},
				success	:function(data){
					if (data['dato']){
						opc.dato[1]=configArray(data['dato'][1],true);
						opc.dato[2]=configArray(data['dato'][2],true);
						opc.dato[3]=configArray(data['dato'][3],true);						
					}else opc.dato=new Array("","","","");
					$('#txtPrefe').val(opc.dato[opc.type]);
					$("#btnPreferences_update").show();
				}
			});
		}
		function configArray(array,toString){
			var out='';
			if (toString)
				for(i in array)
					out+=(out!=''?', ':'')+array[i]['text'];
			return out;
		}
		function changePrefe(opc,type){
			opc.dato[opc.type]=$('#txtPrefe').val();
			if (type) opc.type=type;
			$('#txtPrefe').val(opc.dato[opc.type]);
			$('#typePre').val(opc.type);
		}
		function savePreferences(opc){
			changePrefe(opc);
			myAjax({
				type:'POST',
				url:DOMINIO+'controls/users/preferences.json.php?code='+$.local('code')+'&action=up',
				dataType:'json',
				data:{preference_1:opc.dato[1].replace(/, /g,','),preference_2:opc.dato[2].replace(/, /g,','),preference_3:opc.dato[3].replace(/, /g,',')},
				error:function(/*resp,status,error*/){
					myDialog('#singleDialog',lang.conectionFail);
				},
				success:function(data){
					if (data['insert'])
						myDialog({
							id:'#prefeExitoDialog',
							content:'<br/>'+lang.PREFERENCES_MSJSUCESSFULLY+'<br/>',
							buttons:{
								'Close':function(){ this.close();	}
							}
						});
					else 
						myDialog({
							id:'#prefeExitoDialog',
							content:'<br/>'+lang.TAG_DELETEDERROR+'<br/>',
							buttons:{
								'Close':function(){ location.reload();	}
							}
						});
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
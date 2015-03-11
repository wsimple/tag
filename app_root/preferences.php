<?php include 'inc/header.php'; ?>
<script> var opc={type:1,dato:[]}; </script>
<div id="page-preferences" data-role="page" data-cache="false">
	<div data-role="header" data-theme="f" data-position="fixed">
		<div id="profile" style="position:absolute;top:0px;left:0;padding:5px;">
			<span class="photo"></span> 
			<span class="info">
				<span class="name"></span>
				<span class="points"></span>
			</span>
		</div>
		<div class="notificacion-area" id="notifications">
			<span class="notification-num"><a href="notifications.html">0</a></span>
		</div>
		<div id="sub-menu"><ul class="ui-grid-d"></ul></div>
		<div id="rowTitleMove"><ul class="ui-grid-b"></ul></div>
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
					<div class="save">
						<a id="btnPreferences_update" style="display:none" href="#" onClick="savePreferences(opc);"><img src="css/newdesign/newtag/publish.png"><br/></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-preferences',
			title:lang.USERPROFILE_PREFERENCES,
			before:function(){
				createSearchPopUp('#page-preferences');
				newMenu();
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="store.html">'+lan('store','ucw')+'</a></li>'+
                    '<li class="ui-block-c" >&nbsp;</li>'+
                    '<li class="ui-block-d srcico"><a href="#searchPopUp" data-rel="popup" data-position-to="window">'+lan('search','ucw')+'</a></li>'+
					'<li class="ui-block-e newtag"><a href="newtag.html">'+lan('newTag','ucw')+'</a></li>'
				);
				$('#rowTitleMove ul').html(
					'<li class="ui-block-a ui-btn-active" ><a href="preferences.html">'+lang.PREFERENCES_LBLCHOOSEOPFOOTER+'</a></li>'+
					'<li class="ui-block-b" ><a href="seekPreferences.html?type='+$('#typePre').val()+'">'+lang.seek+'</a></li>'+
					'<li class="ui-block-c" onclick="preferencesUsers();" >'+lang.PREFERENCES_BTNMINE+'</li>'
				);
				//languaje
				$('#buttonBack_preferences').html(lan('Back'));
				$('#labelTypePrefe1').html(lang.PREFERENCES_WHATILIKE);
				$('#labelTypePrefe2').html(lang.PREFERENCES_WHATIWANT);
				$('#labelTypePrefe3').html(lang.PREFERENCES_WHATINEED);
				$('#titleOptionPrefe').html('<strong>'+lang.PREFERENCES_LBLCHOOSEOP+':</strong>');
				$('#labelTxtPrefe').html('<strong>'+lang.USERPROFILE_PREFERENCES_TITLE+':</strong>');
				$('#prefere_legend').html(lang.PREFERENCES_HOLDERSEARCH);
				$('#btnPreferences_update').append(lang.PREFERENCES_BTNUPDATE);
				$('#txtPrefe').attr('placeholder', lang.PREFERENCES_HOLDERSEARCH);
				$('#profile span.info .name').html($.local('full_name'));
				$('#profile .photo').html('<a href="profile.html"><img src="'+$.local('display_photo')+'"></a>');
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
					$('.fs-wrapper').jScroll('refresh');
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
							style:{height:'60px'},
							content:'<br/>'+lang.PREFERENCES_MSJSUCESSFULLY+'<br/>',
							backgroundClose: true,
							buttons:[]
						});
					else 
						myDialog({
							id:'#prefeExitoDialog',
							content:'<br/>'+lang.TAG_DELETEDERROR+'<br/>',
							close:function(){ location.reload(); },
							backgroundClose: true,
							buttons:[]
							// buttons:{
							// 	'Close':function(){ location.reload();	}
							// }
						});
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>
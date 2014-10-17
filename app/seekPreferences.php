<?php include 'inc/header.php'; ?>
<div id="page-seekPreferences" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div class="ui-listview-filter ui-bar-c">
			<input id="searchPreferences" type="search" name="searchPreferences" value="" />
		</div>
		<input id="hiddenArrayPre" name="hiddenArrayPre" type="hidden" value="" />
		<input id="typePre" name="typePre" type="hidden" value="1" />
		<div class="list-wrapper">
			<div id="scroller">
				<ul data-role="listview" id="group_preferences"></ul>
			</div>
		</div>
	</div><!-- content -->
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul>
				<li><a id="labelTypePrefe1" href="#" onclick="$('#typePre').val(1)" class="ui-btn-active"></a></li>
				<li><a id="labelTypePrefe2" href="#" onclick="$('#typePre').val(2)" ></a></li>
				<li><a id="labelTypePrefe3" href="#" onclick="$('#typePre').val(3)" ></a></li>
			</ul>
		</div>
	</div><!-- footer -->
	<script type="text/javascript">
		pageShow({
			id:'#page-seekPreferences',
			title:lang.PREFERENCES_TITLESEEK,
			backButton:true,
			before:function(){
				//languaje
				$('#labelTypePrefe1').html(lang.PREFERENCES_WHATILIKE);
				$('#labelTypePrefe2').html(lang.PREFERENCES_WHATINEED);
				$('#labelTypePrefe3').html(lang.PREFERENCES_WHATIWANT);
				$("#searchPreferences").attr('placeholder',lang.seek);
				$('.list-wrapper').jScroll({hScroll:false});
			},
			after:function(){
				getPreferences(1,'');//call
				$('#group_preferences').on('click','li',function(){
					touchPreferences(this);
				});
				var timeO;
				$('#searchPreferences').keyup(function(e){
					var text=this.value;
					if(e.which!=13){
						if (timeO) clearTimeout(timeO);
						timeO=setTimeout(function(){
							getPreferences($.trim(text));
						},700);
					}
				});
			}
		});
	function getPreferences(text){
		myAjax({
			type	:'GET',
			url		:DOMINIO+'controls/users/preferences.json.php?action=sr&term='+$.trim(text),
			dataType:'json',
			error	:function(/*resp,status,error*/){
				myDialog('#singleDialog',lang.conectionFail);
			},
			success	:function(data){
				var i,pref,out='';
				for(i in data){
					pref=data[i];
					out+=	'<li data-icon="plus" pref="'+pref['id']+'">'+
								'<a href="#">'+pref['text']+'</a>'+
							'</li>';
				}
				$('#group_preferences').html(out).listview('refresh');
				$('.list-wrapper').jScroll('refresh');
			}
		});
	}
	function touchPreferences(object){
		myDialog({
			id:'#prefDialog',
			content:'<div style="text-align:center"><div style="width:50%;margin:0 auto;"><strong>'
					+$('#footer li a.ui-btn-active').text()+'</strong></div>'
					+lang.PREFERENCES_MSJCONFIRMADDPREFE+' (<strong>'+$('a',object).text()+'</strong>)'+'</div>',
			buttons:[{
				name:lang.yes,
				action:function(){
					var dia=this;
					myAjax({
						type:'GET',
						url:DOMINIO+'controls/users/preferences.json.php?type='+$('#typePre').val()+'&code='+$.local('code')+'&p='+$(object).attr('pref')+'&action=add',
						dataType:'json',
						error:function(/*resp,status,error*/){
							myDialog('#singleDialog',lang.conectionFail);
						},
						success:function(){
							$(object).fadeOut('slow');
							dia.close();
						}
					});
				}
			},{
				name:'No',
				action:'close'
			}]
		});
	}
	</script>
</div><!-- page -->
<?php include 'inc/footer.php'; ?>

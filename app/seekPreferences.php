<?php include 'inc/header.php'; ?>
<div id="page-seekPreferences" data-role="page" data-cache="false">
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
<!-- 		<div class="ui-listview-filter ui-bar-c">
			<input id="searchPreferences" type="search" name="searchPreferences" value="" />
		</div> -->
		<input id="hiddenArrayPre" name="hiddenArrayPre" type="hidden" value="" />
		<input id="typePre" name="typePre" type="hidden" value="1" />
		<div class="list-wrapper">
			<div id="scroller">
				<ul data-role="listview" id="group_preferences"></ul>
			</div>
		</div>
	</div><!-- content -->
	<!-- <div id="footer" data-role="footer" data-position="fixed" data-theme="f">
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
			// title:lang.PREFERENCES_TITLESEEK,
			// backButton:true,
			before:function(){
				newMenu();
				createSearchPopUp('#page-preferences');
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="store.html">'+lan('store','ucw')+'</a></li>'+
                    '<li class="ui-block-c" >&nbsp;</li>'+
                    '<li class="ui-block-d srcico"><a href="#searchPopUp" data-rel="popup" data-position-to="window">'+lan('search','ucw')+'</a></li>'+
					'<li class="ui-block-e newtag"><a href="newtag.html">'+lan('newTag','ucw')+'</a></li>'
				);
				$('#rowTitleMove ul').html(
					'<li class="ui-block-a b" ><a href="preferences.html">'+lang.PREFERENCES_LBLCHOOSEOPFOOTER+'</a></li>'+
					'<li class="ui-block-b b ui-btn-active" ><a href="seekPreferences.html?type='+$('#typePre').val()+'">'+lang.seek+'</a></li>'+
					'<li class="ui-block-c b" >'+lan('options')+'</li>'+
					'<li class="ui-block-a" opc="1"><a href="seekPreferences.html?type=1">'+lang.PREFERENCES_WHATILIKE+'</a></li>'+
					'<li class="ui-block-b" opc="2"><a href="seekPreferences.html?type=2">'+lang.PREFERENCES_WHATIWANT+'</a></li>'+
					'<li class="ui-block-c" opc="3"><a href="seekPreferences.html?type=3">'+lang.PREFERENCES_WHATINEED+'</a></li>'
				);
				$('.list-wrapper').jScroll({hScroll:false});
				$('#profile span.info .name').html($.local('full_name'));
				$('#profile .photo').html('<a href="profile.html"><img src="'+$.local('display_photo')+'"></a>');
			},
			after:function(){
				if ($_GET['type'] && (($_GET['type']*1)>=1 && ($_GET['type']*1)<=3)){
					$('#typePre').val($_GET['type'])
					$('#rowTitleMove ul li[opc="'+$_GET['type']+'"]').addClass('ui-btn-active');
				}else{
					$('#typePre').val(1);
					$('#rowTitleMove ul li[opc="1"]').addClass('ui-btn-active');
				}
				getPreferences(1);//call
				$('#group_preferences').on('click','li',function(){
					touchPreferences(this);
				});
				// var timeO;
				// $('#searchPreferences').keyup(function(e){
				// 	var text=this.value;
				// 	if(e.which!=13){
				// 		if (timeO) clearTimeout(timeO);
				// 		timeO=setTimeout(function(){
				// 			getPreferences($.trim(text));
				// 		},700);
				// 	}
				// });
				var scroller,v=true,y=-50;
				$('.list-wrapper').jScroll(function(){
					scroller=this;
				});
				$('#rowTitleMove ul').on('click','li[opc]',function(){
					console.log('heeeee');
				}).on('click','li.ui-block-c.b',function(){
					console.log('hoooooooo');
					$('#rowTitleMove ul .b').slideUp('fast',function(){
						$('#rowTitleMove ul li[opc]').slideDown('fast');
					});
				});
				$('.list-wrapper').bind('touchmove',function(){
					if (scroller.y>-100){
						$('#rowTitleMove').removeClass('no-v');
						$('#page-seekPreferences .list-wrapper').css('top','82px');
					}else{
						$('#page-seekPreferences .list-wrapper').css('top','46px');
						if (scroller.y<y){
							if (v){
								v=false;
								$('#rowTitleMove').addClass('no-v');
							}
						}else{
							if (!v){
								v=true;
								$('#rowTitleMove').removeClass('no-v');													
							}
						}
						y=scroller.y;
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

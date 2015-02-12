<?php include 'inc/header.php'; ?>
<div id="page-topTags" data-role="page" data-cache="false">
	<div  data-role="header" data-theme="f" data-position="fixed">
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
		<!-- div id="userPoints" class="ui-btn-right" data-iconshadow="true" data-wrapperels="span">
			<span class="loader"></span>
		</div> -->
		<fieldset id="private-select" data-role="controlgroup" data-type="horizontal" data-mini="true" style="position:absolute;top:7px;right:5px;display:none;">
			<input id="radio-inbox" type="radio" name="radio-in-out" data-theme="a" value="in" checked="checked"/>
			<input id="radio-outbox" type="radio" name="radio-in-out" data-theme="a" value="out"/>
		</fieldset>
	</div>
	<div data-role="content" style="background-color:#fff;">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><div class="smt-tag-content"><span class="pullDownIcon"></span><span class="pullDownLabel"></span></div></div>
				<div id="tagsList" class="cursor tags-list" style="min-height:300px;background:#fff;"></div>
				<div id="pullUp"><div class="smt-tag-content"><span class="pullUpIcon"></span><span class="pullUpLabel"></span></div></div>
			</div>
		</div>
	</div>
	<?php include 'inc/mainmenu.php'; ?>
	<div data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar"><ul id="footer-icons"></ul></div>
	</div>
	<script>
		//if(navigator.app) navigator.app.clearHistory();
		pageShow({
			id:'page-topTags',
			title:lang.TOPTAGS_TITLE,
			buttons:{showmenu:false,creation:false},
			before:function(){
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lang.TOPTAGS_TITLE+'</a></li>'+
					'<li class="ui-block-b store"><a href="#">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-c points"></li>'+
					'<li class="ui-block-d newtag"><a href="newtag.html">'+lan('newtag','ucw')+'</a></li>'
				);
				$('.pullDownLabel').html(lang.SCROLL_PULLDOWN);
				$('.pullUpLabel').html(lang.SCROLL_PULLUP);
				$('#footer-icons').html(//llenado de footer
					'<li><a opc="1" class="ui-btn-active">'+lang.TOPTAGS_DAILY+'</a></li>'+
					'<li><a opc="2">'+lang.TOPTAGS_WEEKLY+'</a></li>'+
					'<li><a opc="3">'+lang.TOPTAGS_MONTHLY+'</a></li>'+
					'<li><a opc="4">'+lang.TOPTAGS_YEARLY+'</a></li>'+
					'<li><a opc="0" >'+lang.TOPTAGS_ALWAYS+'</a></li>'
				);
			},
			after:function(){
				$('#page-topTags .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
				//myAjax({url:DOMINIO+'controls/users/test.json.php',dataType:'json',data:{test:true}});
				//if($.session('debug')) alert('cordova='+CORDOVA+', app='+$.session('app')+', debug='+$.session('debug'));
				function noTagsTxt(val){
					var txt;
					switch(parseInt(val)){
						case 1: txt=lang.TOPTAGS_DAILY;break;
						case 2: txt=lang.TOPTAGS_WEEKLY;break;
						case 3: txt=lang.TOPTAGS_MONTHLY;break;
						case 4: txt=lang.TOPTAGS_YEARLY;break;
						default:txt=lang.TOPTAGS_ALWAYS;
					}
					return lang.TOPTAGS_NOTAGS+txt.toLowerCase()+'.';
				}
				var opc={
						current:'hits',
						layer: $('#tagsList')[0],
						notag:noTagsTxt($_GET['range']||1),
						get:$_GET['range']?'&range='+$_GET['range']:''
					},
					$wrapper=$('#pd-wrapper',this.id);
				// $(opc.layer).on('click','[tag]',function(){
				// 	redir(PAGE['tag']+'?id='+$(this).attr('tag'));
				// });
				$wrapper.ptrScroll({
					onPullDown:function(){
						updateTags('reload',opc);
					},
					onPullUp:function(){
						updateTags('more',opc);
					},
					onReload:function(data){
						if(data){
							opc.notag=noTagsTxt(data);
							opc.get='&range='+data;
						}else opc.get='&range=1';
						updateTags('reload',opc,true);
					}
				});
				/*action menu tag*/
				actionsTags(opc.layer);
				/*and action menu tag*/
				$('#footer-icons').on('click','a',function(){
					$wrapper.ptrScroll('reload',$(this).attr('opc'));
				});
				//V2
				$(opc.layer).on('click', 'menu #other-options', function(){
					$('.sub-menu-tag').find('ul').hide();
					$(this).find('ul').show();
				});
				get_profile($.local('code'), function(data){
					$('#profile span.info .name').html($.local('full_name'));
					$('#profile .photo').html('<a href="profile.html"><img src="'+data.datos[0].photo_friend+'"></a>');
				});
				//END V2
				$('#userPoints').click(function(){
					myDialog({
						id:'msg-points',
						open:true,
						content:
							'<p>'+lang.MAINMENU_POINTS_2+'</p>'+
							'<p>'+lang.MAINMENU_POINTS_1+'</p>',
						style:{
							'margin':10,
							'font-size':14
						}
					});
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

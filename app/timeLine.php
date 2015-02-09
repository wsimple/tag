<?php include 'inc/header.php'; ?>
<script>
	//$.session('countpage',0);
	if($.session('_post_')){
		$.session('_post_',null);
		window.location.reload();
	}
</script>
<div id="singleRedirDialog" class="myDialog" style="display: none;"><div class="table"><div class="cell"><div class="window" style="max-height: 272px; display: block;"><div class="container" style="max-height: 272px;"><div id="scroller" class="content"></div></div><div class="buttons"><a action="0" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f ui-btn-up-undefined"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">Sí</span></span></a><a action="1" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f ui-btn-up-undefined"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">No</span></span></a></div></div></div></div><div class="closedialog" style="display:none"></div></div>
<div id="page-timeLine" data-role="page" data-cache="false">
	<div  data-role="header" data-theme="f" data-position="fixed">
		<div id="profile" style="position:absolute;top:0px;left:0;padding:0 5px;">
			<span class="photo"></span> 
			<span class="full-name"></span>
		</div>
		<div class="notificacion-area" id="notifications">
			<span class="notification-num">0</span>
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
	<div data-role="content">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><div class="smt-tag-content"><span class="pullDownIcon"></span><span class="pullDownLabel"></span></div></div>
				<div id="tagsList" class="cursor tags-list" style="min-height:300px;background:#fff;"></div>
				<div id="pullUp"><div class="smt-tag-content"><span class="pullUpIcon"></span><span class="pullUpLabel"></span></div></div>
			</div>
		</div>
	</div>
	<?php include 'inc/mainmenu.php'; ?>
	<div id="tl-footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar"><ul></ul></div>
	</div>
	<script>
		var page = $.local('timeLine');
		var active_tab = 'timeLine';
		if (page) active_tab = page.last_tab;
		//if(navigator.app) navigator.app.clearHistory();
		function get_profile(code, callback){
			myAjax({
				url:DOMINIO+'controls/users/people.json.php?action=specific&code',
				data:{uid:code},
				success:function(response){
					if (!response['error']){
						if (typeof callback == 'function') {
							callback(response);
						}
					}
				},
				error:function(){
					console.log('error');
				}
			});
		}

		pageShow({
			id:'page-timeLine',
			title:'Time Line',
			before:function(){
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b newtag"><a href="newtag.html">'+lan('newtag','ucw')+'</a></li>'+
					'<li class="ui-block-c store"><a href="#">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-d points"><span></span><a href="#">'+lan('rewards','ucw')+'</a></li>'
				);

				$('#singleRedirDialog #scroller').html(lan('JS_DELETETAG'));
				$('.pullDownLabel').html(lan('SCROLL_PULLDOWN'));
				$('.pullUpLabel').html(lan('SCROLL_PULLUP'));
				$('#singleRedirDialog #scroller.content').html(lan('JS_DELETETAG'));
				// $('#userPoints').html(lan('POINTS_USERS')+' <b><loader/></b>');
				$('#tl-footer ul').html(//llenado de footer
					'<li><a opc="timeLine" data-icon="tag-tl" data-iconpos="top" class="ui-btn-active">'+lang.JS_TIMELINE+'</a></li>'+
					'<li><a opc="myTags" data-icon="tag-mt" data-iconpos="top">'+lang.JS_MYTAGS+'</a></li>'+
					'<li><a opc="favorites" data-icon="tag-ft" data-iconpos="top">'+lang.JS_FAVORITETAGS+'</a></li>'+
					'<li><a opc="privateTags" data-icon="tag-pt" data-iconpos="top">'+lang.JS_PRIVATETAGS+'</a></li>'
				);
				$('#private-select').append(
					'<label for="radio-inbox">'+lan('inbox','ucw')+'</label>'+
					'<label for="radio-outbox">'+lan('outbox','ucw')+'</label>'
				);
			},
			after:function(){
				//V2
				$("#bottom-menu").swipe( {
			        swipeUp:function(event, direction, distance, duration, fingerCount, fingerData) {
			        	$(this).animate({bottom: -0},500);
			        },threshold:0,
			        swipeDown:function(event, direction, distance, duration, fingerCount, fingerData) {
			        	$(this).animate({bottom: -114},500);
			        },threshold:0
		        });
				get_profile($.local('code'), function(data){
					$('#profile span.full-name').html($.local('full_name'));
					$('#profile .photo').html('<img src="'+data.datos[0].photo_friend+'">');
				});
				//END V2
				
				$('#creationTag').click(function(){
					redir(PAGE['newtag']);
				});
				// alert(active_tab);
				if (active_tab != 'timeLine') {
					$('#tl-footer ul li a').removeClass('ui-btn-active');
					$('#tl-footer ul li a[opc='+active_tab+']').addClass('ui-btn-active');
					if(active_tab=='privateTags'){
						$('#private-select').show();
						$('.creation').hide();
					}else{
						$('#private-select').hide();
						$('.creation').show();
					}
				}
				var opc={ 
						current: active_tab,
						layer:$('#tagsList')[0]
					},
					$wrapper=$('#pd-wrapper',this.id);
				$('.ui-page-active .ui-title').html(lang.TIMELINE_TITLE);

				actionsTags(opc.layer);
				$(opc.layer)
                $wrapper.ptrScroll({
					onPullDown:function(){
						updateTags('reload',opc);
					},
					onPullUp:function(){
						var response = updateTags('more',opc);
						if (!response) {
							$wrapper.jScroll('refresh');
						};
					},
					onReload:function(){
						updateTags('reload',opc,true);
					}
				});
				var priv='',val='in';
				$('#private-select input').click(function(){
					opc.type = '';
					if(val!=this.value){
						val=this.value;
						priv=val=='out'?'&type=outbox':'';
						opc.get=priv;
						opc.type=val;
						$wrapper.ptrScroll('reload');
					}
				});
				$('#tl-footer ul').on('click','a',function(){
					var c=$(this).attr('opc');
					// alert(c);
					$.local('timeLine', {'last_tab':c});
					if(opc.current!=c){
						opc.current=c;
						if(opc.current=='privateTags'){
							opc.get=priv;
							$('.ui-loader').css('right','130px'); // Fix Temporal Loader
							$('#private-select').show();
							$('#creationTag').hide();
						}else{
							$('.ui-loader').css('right','50px');
//							opc.get='';
							$('#private-select').hide();
							$('#creationTag').show();
						}
						delete opc.on;
						$wrapper.ptrScroll('reload');
					}
				});
				// $('#userPoints').click(function(){
				// 	myDialog({
				// 		id:'msg-points',
				// 		open:true,
				// 		content:
				// 			'<p>'+lang.MAINMENU_POINTS_2+'</p>'+
				// 			'<p>'+lang.MAINMENU_POINTS_1+'</p>',
				// 		style:{
				// 			'margin':10,
				// 			'font-size':14
				// 		}
				// 	});
				// });
				//Get User Points
				// $.ajax({
				// 	type	:'GET',
				// 	url		:DOMINIO+'controls/users/getUserPoints.json.php',
				// 	dataType:'json',
				// 	success	:function(data){
				// 		var datos='',pts='';
				// 		pts=data.split(' ');
				// 		//alert(pts[1]);
				// 		if(pts[1]=='CONST_UNITMIL')
				// 			datos=pts[0]+' K';
				// 		else if(pts[1]=='CONST_UNITMILLON')
				// 			datos=pts[0]+' M';
				// 		else
				// 			datos=data;
				// 		$('#userPoints b').html(datos);
				// 	}
				// });
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

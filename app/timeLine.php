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
		<div id="rowTitleMove">
			<ul class="ui-grid-c"></ul>
			<fieldset id="private-select" data-role="controlgroup" data-type="horizontal" data-mini="true">
				<input id="radio-inbox" type="radio" name="radio-in-out" data-theme="a" value="in" checked="checked"/>
				<input id="radio-outbox" type="radio" name="radio-in-out" data-theme="a" value="out"/>
			</fieldset>
		</div>
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
<!-- 	<div id="tl-footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar"><ul></ul></div>
	</div> -->
	<script>
		var page = $.local('timeLine');
		var active_tab = 'timeLine';
		if (page) active_tab = page.last_tab;
		//if(navigator.app) navigator.app.clearHistory();
		pageShow({
			id:'page-timeLine',
			title:'Time Line',
			before:function(){
				newMenu();
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="#">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-c points"></li>'+
					'<li class="ui-block-d newtag"><a href="newtag.html">'+lan('newtag','ucw')+'</a></li>'
				);

				$('#singleRedirDialog #scroller').html(lan('JS_DELETETAG'));
				$('.pullDownLabel').html(lan('SCROLL_PULLDOWN'));
				$('.pullUpLabel').html(lan('SCROLL_PULLUP'));
				$('#singleRedirDialog #scroller.content').html(lan('JS_DELETETAG'));
				$('#rowTitleMove ul').html(
					'<li class="ui-block-a" opc="timeLine" >'+lang.JS_TIMELINE+'</li>'+
					'<li class="ui-block-b" opc="myTags" >'+lang.JS_MYTAGS+'</li>'+
					'<li class="ui-block-c" opc="favorites" >'+lang.JS_FAVORITETAGS+'</li>'+
					'<li class="ui-block-d" opc="privateTags" >'+lang.JS_PRIVATETAGS+'</li>'+
					'<li class="ui-block-e" style="width:100%;"><a><img src="css/newdesign/menu.png"></a><span></span></li>'
				);
				var t=$('#rowTitleMove ul li[opc="'+active_tab+'"]').addClass('ui-btn-active').text();
				$('#rowTitleMove ul li.ui-block-e').addClass('ui-btn-active').find('span').html(t);
				if(active_tab=='privateTags'){
					$('#private-select').show();
					$('#rowTitleMove ul li.ui-block-e span').append('<br><span>('+lan('inbox','ucw')+')</span>');
				}else{
					$('#private-select').hide();
				}
				$('#private-select').append(
					'<label for="radio-inbox"></label>'+
					'<label for="radio-outbox"></label>'
				);

			},
			after:function(){
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
				var scroller,v=true,y=-50;
				$wrapper.jScroll(function(){
					scroller=this;
				});
				$wrapper.bind('touchmove',function(){
					if (scroller.y>-100){
						$('#rowTitleMove').removeClass('no-v');
						$('#page-timeLine #pd-wrapper').css('top','100px');
					}else{
						$('#page-timeLine #pd-wrapper').css('top','60px');
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
				})		
			// var donde = $('#pd-wrapper #scroller').attr('style').split(';');
			// donde = donde[donde.lenght];
			// console.log(donde);
				var priv='',val='in';
				$('#private-select input').click(function(){
					opc.type = '';
					if(val!=this.value){
						val=this.value;
						if (val=='out'){
							priv='&type=outbox';
							$('#rowTitleMove ul li.ui-block-e span span').html('('+lan('outbox','ucw')+')');
						}else{
							$('#rowTitleMove ul li.ui-block-e span span').html('('+lan('inbox','ucw')+')');
						}
						opc.get=priv;
						opc.type=val;
						$wrapper.ptrScroll('reload');
					}
				});
				$('#rowTitleMove ul').on('click','li[opc]',function(){
					var c=$(this).attr('opc');
					$.local('timeLine', {'last_tab':c});
					$('#rowTitleMove ul li[opc]').slideUp('fast',function(){
						$('#rowTitleMove ul li.ui-block-e').slideDown('fast');
					});
					if(opc.current!=c){
						opc.current=c;
						$('#rowTitleMove ul li').removeClass('ui-btn-active');
						var t=$('#rowTitleMove ul li[opc="'+c+'"]').addClass('ui-btn-active').text();
						$('#rowTitleMove ul li.ui-block-e').addClass('ui-btn-active').find('span').html(t);
						if(opc.current=='privateTags'){
							opc.get=priv;
							$('#private-select').show();
							$('#rowTitleMove ul li.ui-block-e span').append('<br><span>('+lan('inbox','ucw')+')</span>');
						}else{
							$('#private-select').hide();
						}
						delete opc.on;
						$wrapper.ptrScroll('reload');
					}
				}).on('click','a',function(){
					$('#private-select').hide();
					$(this).parents('li').slideUp('fast',function(){
						$('#rowTitleMove ul li').slideDown('fast');
					});
				});
				
				if ($_GET['nonpublic']=='1'){ // gives knowing if the tag is either private or public checked="checked"
					priv='&type=outbox';
					$('#tl-footer ul a[opc="privateTags"]').click();
					$("#radio-inbox").removeAttr("checked").checkboxradio("refresh");
					$("#radio-outbox").attr("checked", "checked").checkboxradio("refresh");
				}

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
				//V2
				$(opc.layer).on('click', 'menu #other-options', function(){
					$('.sub-menu-tag').find('ul').hide();
					$(this).find('ul').show();
				});
				$('#profile span.info .name').html($.local('full_name'));
				$('#profile .photo').html('<a href="profile.html"><img src="'+$.local('display_photo')||''+'"></a>');
				//END V2
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

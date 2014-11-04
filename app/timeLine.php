<?php include 'inc/header.php'; ?>
<script>
	//$.session('countpage',0);
	if($.session('_post_')){
		$.session('_post_',null);
		window.location.reload();
	}
</script>
<div id="page-timeLine" data-role="page" data-cache="false">
	<div  data-role="header" data-theme="f" data-position="fixed">
		<div style="position:absolute;top:0px;left:0;padding:0 5px;">
			<!--<a href="<?=base_url('myMenu')?>" style="position:relative;"><span class="btn-menu"></span><span class="push-notifications button" style="display:none;">0</span></a>-->
			<a href="#" class="showMenu" style="position:relative;"><span class="btn-menu showMenu"></span><span class="push-notifications button" style="display:none;">0</span></a>
			<a href="#" onclick="redir(PAGE['newtag'])"><img src="img/creation.png" /></a>
		</div>
		<h1><span class="loader"></span></h1>
		<div id="userPoints" class="ui-btn-right" data-iconshadow="true" data-wrapperels="span">
			<span class="loader"></span>
		</div>
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
	<div id="tl-footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar"><ul></ul></div>
	</div>
	<script>
		var page = $.local('timeLine');
		var active_tab = 'timeLine';
		if (page) active_tab = page.last_tab;
		//if(navigator.app) navigator.app.clearHistory();

		pageShow({
			id:'page-timeLine',
			title:'Time Line',
			before:function(){
				$('.pullDownLabel').html(lan('SCROLL_PULLDOWN'));
				$('.pullUpLabel').html(lan('SCROLL_PULLUP'));
				$('#userPoints').html(lan('POINTS_USERS')+' <b><loader/></b>');
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
				if (active_tab != 'timeLine') {
					$('#tl-footer ul li a').removeClass('ui-btn-active');
					$('#tl-footer ul li a[opc='+active_tab+']').addClass('ui-btn-active');
					if(active_tab=='privateTags'){
						$('#private-select').show();
						$('#userPoints').hide();
					}else{
						$('#private-select').hide();
						$('#userPoints').show();
					}
				}
				var opc={ 
						current: active_tab,
						layer:$('#tagsList')[0]
					},
					$wrapper=$('#pd-wrapper',this.id);
				$('.ui-page-active .ui-title').html(lang.TIMELINE_TITLE);
                $(opc.layer).on('click','.smt-tag',function(){
					redir(PAGE['tag']+'?id='+$(this).attr('tag'));
				});

				$(opc.layer).doubletap('[tag]', function(e){
					var tagId = $(e.currentTarget).attr('tag')
					myAjax({
						type:'GET',
						url:DOMINIO+'controls/tags/actionsTags.controls.php?action=4&tag='+tagId,
						dataType:'html',
						success:function( data ){

							$(e.currentTarget).find('#likeIcon').fadeIn();							
						}
					});
				});

				// $(opc.layer).on('dblclick','[tag]',function(){
				// 	var object = this;
				// 	myAjax({
				// 		type:'GET',
				// 		url:DOMINIO+'controls/tags/actionsTags.controls.php?action=4&tag='+$(object).attr('tag'),
				// 		dataType:'html',
				// 		success:function( data ){
				// 			$('.tag-icons #likeIcon',object).fadeIn(); 									
				// 		}
				// 	});
				// });

				// $(opc.layer).on('click','[tag]',function(){
				// 	redir(PAGE['tag']+'?id='+$(this).attr('tag'));
				// });

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
					if(val!=this.value){
						val=this.value;
						priv=val=='out'?'&type=outbox':'';
						opc.get=priv;
						$wrapper.ptrScroll('reload');
					}
				});
				$('#tl-footer ul').on('click','a',function(){
					var c=$(this).attr('opc');
					$.local('timeLine', {'last_tab':c});
					if(opc.current!=c){
						opc.current=c;
						if(opc.current=='privateTags'){
							opc.get=priv;
							$('#private-select').show();
							$('#userPoints').hide();
						}else{
//							opc.get='';
							$('#private-select').hide();
							$('#userPoints').show();
						}
						delete opc.on;
						$wrapper.ptrScroll('reload');
					}
				});
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
				//Get User Points
				$.ajax({
					type	:'GET',
					url		:DOMINIO+'controls/users/getUserPoints.json.php',
					dataType:'json',
					success	:function(data){
						var datos='',pts='';
						pts=data.split(' ');
						//alert(pts[1]);
						if(pts[1]=='CONST_UNITMIL')
							datos=pts[0]+' K';
						else if(pts[1]=='CONST_UNITMILLON')
							datos=pts[0]+' M';
						else
							datos=data;
						$('#userPoints b').html(datos);
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

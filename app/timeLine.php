<?php include 'inc/header.php'; ?>
<script>
	//$.session('countpage',0);
	if($.session('_post_')){
		$.session('_post_',null);
		window.location.reload();
	}
</script>
<div id="singleRedirDialog" class="myDialog" style="display: none;"><div class="table"><div class="cell"><div class="window" style="max-height: 272px; display: block;"><div class="container" style="max-height: 272px;"><div id="scroller" class="content">Está seguro que quiere eliminar esta tag?</div></div><div class="buttons"><a action="0" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f ui-btn-up-undefined"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">Sí</span></span></a><a action="1" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f ui-btn-up-undefined"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">No</span></span></a></div></div></div></div><div class="closedialog" style="display:none"></div></div>
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
						loader: false,
						success:function( data ){
                            $(e.currentTarget).find('#dislikeIcon').fadeOut('slow',function(){
                                $(e.currentTarget).find('#likeIcon').fadeIn('slow');
                            });
						}
					});
				});

				// $(opc.layer).on('click','[tag]',function(){
				// 	redir(PAGE['tag']+'?id='+$(this).attr('tag'));
				// });
				function afterAjax(data, tagId, toHide,toShow){
					console.log('tagID:'+tagId+'--'+toHide+'--'+toShow);
					if(data.indexOf('ERROR')<0){
						$('[tag='+tagId+']').find(toHide).fadeOut('slow',function(){
							$('[tag='+tagId+']').find(toShow).fadeIn('slow');
						});
					}
				}
				$(opc.layer).on('click', 'menu li', function(e){
					var tagtId = $(e.target).parents('[tag]').attr('tag');
					var btnPresed = e.target.id;
					switch(e.target.id){
						case 'report':redir(PAGE['reporttag']+'?id='+tagtId);break;
						case 'share':redir(PAGE['sharetag']+'?id_tag='+tagtId);break;
						case 'comment':
							var opc = {
								layer:'#comments',
								scroller:'.fs-wrapper',
								data:{
									type:4,
									source:tagtId,
									limit:10,
									mobile:1
								}
							};
							if ($('[tag='+tagtId+']').find('#comments').length > 0) {
								$('#comments').fadeOut('fast', function() {
									$(this).remove();
								});
							}else{
								$('#comments').remove();
								$('[tag='+tagtId+']').append(
										'<ul id="comments" style="display:none;" data-role="listview" data-inset="true" class="tag-comments ui-listview list" data-divider-theme="e"></ul>'
								);
								$('#comments').listview();
								getComments('reload',opc);

								$('#pd-wrapper').on('keydown', '#commenting', function(e) {
									if (e.which == 13) {
										var comment=$.trim($(this).val());
										if(comment!=''){
											$(this).val('');
											insertComment(comment,opc);
										}
										return false;
									}
								});
							}
							// var interval=setInterval(function(){
							// 	getComments('refresh',opc);
							// },20000);
						break;
						case 'like':case 'dislike':
							var that=e.target.id+'Icon',
								show=e.target.id!='like'?'likeIcon':'dislikeIcon';
							myAjax({
								type:'POST',
								url:DOMINIO+'controls/tags/actionsTags.controls.php?action='+(that=='likeIcon'?4:11)+'&tag='+tagtId,
								dataType:'html',
								loader: false,
								success:function( data ){
									afterAjax(data,tagtId,'.tag-icons #'+show,'.tag-icons #'+that);
									myAjax({
										type:'POST',
										url:DOMINIO+'controls/tags/actionsTags.controls.php?action=12&tag='+tagtId,
										dataType:'html',
										loader: false,
										success:function( data ){
											data= data.split('|');
											// opc.likes=data[0];
											// opc.dislikes=data[1];
											if(data[2]>0){afterAjax(data, tagtId, 'menu #like', 'menu #dislike');};
											if(data[2]<0){afterAjax(data, tagtId,'menu #dislike', 'menu #like');};
											if (e.target.id=='like') {
												$('#numLikes').html(parseInt($('#numLikes').text())+1);
											}else{
												$('#numDislikes').html(parseInt($('#numDislikes').text())+1);
											}
										}
									});
								}
							});
						break;
						case 'redistr':
							myAjax({
								type:'POST',
								url:DOMINIO+'controls/tags/actionsTags.controls.php?action=3&tag='+tagtId,
								dataType:'html',
								loader: false,
								success:function( data ){
									afterAjax(data, tagtId,'menu #redistr', '.tag-icons #redist');
								}
							});
						break;
						case 'trash':
							myDialog({
								id:'#singleRedirDialog',
								content:lang.JS_DELETETAG,
								loader: false,
								buttons:[{
									name:lang.yes,
									action:function(){
										var dialog = this;
										myAjax({
											type: 'POST',
											url: DOMINIO+'controls/tags/actionsTags.controls.php?action=6&tag='+tagtId,
											dataType: 'html',
											success: function( data ) {
												$('[tag='+tagtId+']').fadeOut('fast',function(){
													$(this).remove();
													dialog.close();
												});
											}
										});
									}
								},{
									name:'No',
									action:'close'
								}]
							});
						break;
					}
				});

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

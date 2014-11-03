<?php include 'inc/header.php'; ?>
<div id="page-tag" data-role="page" data-cache="false">
	<div data-role="header" data-theme="f" data-position="fixed">
		<a href="#" id="buttonBack" data-icon="arrow-l"></a>
		<h1 class="tag-title is-logged"></h1>
		<a href="#" id="goProfile" data-icon="arrow-r" class="is-logged" style="display:none;"></a>
	</div><!-- /header -->
	<div data-role="content">
		<img class="bg" src="img/bg.png"/>
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<div id="noLoggedEmail" class="logoBackEmail" style="display:none;"></div>
				<div class="tag-solo"><div id="tag" class="tag-container"></div></div>
				<div class="tag-solo-hash smt-tag-content"></div>
				<div class="is-logged tag-comments-window smt-tag-content dnone">
					<ul id="comments" data-role="listview" data-inset="true" class="tag-comments ui-listview list" data-divider-theme="e"></ul>
				</div>
			</div>
		</div>
	</div>
	<div id="tag-footer" class="tag-buttons" data-role="footer" data-theme="f" data-position="fixed" data-tap-toggle="false" style="text-align:center;">
		<a id="redist"	style="display:none;"></a>
		<a id="like"	style="display:none;" class="is-logged"></a>
		<a id="dislike"	style="display:none;" class="is-logged"></a>
		<a id="share"	style="display:none;"></a>
		<a id="sponsor"	style="display:none;"></a>
		<a id="report"	style="display:none;"></a>
		<a id="delete"	style="display:none;"></a>
		<a id="youtube"	style="display:none;" class="video" data-ajax="false"></a>
		<a id="vimeo"	style="display:none;" class="video" data-ajax="false"></a>
		<a id="local"	style="display:none;" class="video" data-ajax="false"></a>
		<a id="comment"	style="display:none;" class="is-logged"></a>
		<a id="qrcode"	style="display:none;"></a>
	</div>
	<div id="popupVideo" data-role="popup" data-overlay-theme="a" data-theme="c" style="padding:7px;"></div>
	<script>
		var Change=isLogged();
		pageShow({
			id:'#page-tag',
			before:function(){
				$('#buttonBack').html(isLogged()?lan('Back'):lang.home).click(function(){ if(isLogged()) goBack(); else redir(PAGE['ini']); });
				$('#goProfile').html(lang.profile);
				$('#tagNoExits').html(lang.TAGS_WHENTAGNOEXIST);
			},
			login:function(logged){
				if(logged!==Change) window.location.reload();
			},
			after:function(){
				var opc={//comment data
						layer:'#comments',
						scroller:'.fs-wrapper',
						data:{
							type:4,
							source:$_GET['id'],
							limit:10,
							mobile:1
						},
						likes:0,
						dislikes:0
					};
				if(isLogged()){
					$('.is-logged').fadeIn('slow');
				}else{
					$('#noLoggedEmail').show();
					$('.not-logged').fadeIn('slow');
				}
				$('.fs-wrapper').jScroll({hScroll:false});
				$('#comments').on('click','.header',function(){//seemore
					getComments('more',opc);
				}).on('click','[comment].more',function(){
					$(this).removeClass('more').addClass('less');
					$('.fs-wrapper').jScroll('refresh');
				}).on('click','.less',function(){
					$(this).removeClass('less').addClass('more');
					$('.fs-wrapper').jScroll('refresh');
				});
				$('div.tag-solo-hash').on('click',function(){
					$(this).addClass('tag-solo-hash-complete');
					//$('a[hashT]',this).attr('hash',$('a[hashT]',this).attr('hashT')).removeAttr('hashT');
					var vector=$('a[hashT]',this);
					$.each(vector,function(key,value){
						$(this).attr('hash',$(this).attr('hashT')).removeAttr('hashT');
					});
				}).on('click','a[hash]',function(){//tag-solo-hash-complete
					redir(PAGE['search']+'?srh='+$(this).attr('hash').replace('#','%23').replace('<br>',' '));
				});
				function dialogComment(id){
					console.log('dialogComment. id='+id);
					myDialog({
						id:'#commentDialog',
						style:{'margin-right':10},
						content:
							'<div style="padding:10px;"><textarea name="txtComment" id="txtComment" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset"'+
								'style="resize:none;width:100%" rows="5" placeholder="'+lang.COMMENTS_LBLHELPIMPUTNEWCOMMENT+'"></textarea></div>',
						buttons:[{
							name:lang.send,
							action:function(){
								var comment=$.trim($('#txtComment').val());
								if(comment!=''&&comment!=lang.COMMENTS_LBLHELPIMPUTNEWCOMMENT){
									//comment = limpiaTextComentarios(comment);
									var $this=$(this);
									opc.complete=function(){$this.close();};
									insertComment(comment,opc);
								}
								$('#commentDialog .closedialog').click();
								$('.fs-wrapper').jScroll('refresh');
							}
						},{
							name:lang.close,
							action:'close'
						}]
					});
				}
				var test='';
				myAjax({
					type	:'POST',
					dataType:'json',
					url		:DOMINIO+'controls/tags/tagsList.json.php?id='+$_GET['id']+(is['iOS']?'&embed':''),
					error	:function(/*resp,status,error*/){
						myDialog({
							id:'#singleRedirDialog',
							content:lang.TAG_CONTENTUNAVAILABLE,
							buttons:{
								Ok:function(){
									redir(PAGE['timeline']);
								}
							}
						});
					},
					success:function(data){
						//alert(data['num_likes']);
						//(tag['status']=='')?alert('vacio'):alert(tag['status']);
						var tag=data&&data['tags']&&data['tags'][0];
						if(tag['product']){
							$('#qrcode').show();
//							console.log(tag['product']);
							test = tag['product']['app'];	
						}
						if(tag&&(tag['status']!='2')){
							if(tag['hashTag']){
								var jj,hashS='';
								for(jj=0;jj<tag['hashTag'].length;jj++){
									hashS+='<a href="#" hashT="'+tag['hashTag'][jj]+'">'+tag['hashTag'][jj]+'</a>&nbsp;&nbsp;';
								}
//								console.log($('div.tag-solo-hash'));
								$('div.tag-solo-hash').html(hashS);
							}
							$('.tag-title').html(tag['rid']?tag['rname']+lang.TXT_REDIST:tag['uname']);
							delete tag['uname'];
							$('#tag').html(showTag(tag));
							$('#goProfile').click(function(){
								redir(PAGE['profile']+'?id='+tag['code']);
							});
							opc.likes=tag['num_likes'];
							opc.dislikes=tag['num_disLikes'];
							if(tag['redist']) $('.tag-icons #redist').fadeIn('slow');
							var buttons=[],btn=tag['btn']||{};
							if(btn['redist'])	buttons.push('#redist');
							if(btn['share'])	buttons.push('#share');
							if(btn['trash'])	buttons.push('#delete');
							if(btn['report'])	buttons.push('#report');
							if(buttons.length>0) $(buttons.join(),'.tag-buttons').fadeIn('slow');
							if(tag['typeVideo']){
								var $video=$('.tag-buttons #'+tag['typeVideo']).fadeIn('slow');
								if(openVideo){
									$video.click(function(){
										if (tag['typeVideo']=='local'){
											var wi=$('#page-tag .tag-solo').css('font-size');
											if (wi.indexOf('px')!=-1){
												wi=(wi.replace('px','')*1)-1;
												wi=wi+'px';
											}else{
												wi=(wi.replace('em','')*1)-0.20;
												wi=wi+'em';
											}
											myDialog({
												id:'#singleVideoDialog',
												content:'<div class"tag-solo" style="font-size:'+wi+'"><div class="tag-container" style="margin:0 auto;"><div tag><div class="video"><div class="placa"></div>'+
															'<video id="v'+Math.random()+'" controls autoplay preload="metadata"><source src="'+tag['video']+'" type="video/mp4"/></video>'+
															'</div></div></div><div class="clearfix"></div></div>',
												buttons:[{
													name:'Ok',
													action:function(){
														var di=this;
														$('#singleVideoDialog video').each(function(index, el) {
															this.pause();
															this.src="";
														});
														di.close();
													}
												}]
											});
										}else openVideo(tag['video'],'#popupVideo');
									});
								}else $video.attr({'href':tag['video'],'target':'_blank'});
							}
							myAjax({
								type:'GET',
								url:DOMINIO+'controls/tags/actionsTags.controls.php?action=12&tag='+$_GET['id'],
								dataType:'html',
								success:function(data){
									data=data.split('|');
									if(isLogged()){
										if(data[2]==0) $('.tag-buttons #like, .tag-buttons #dislike').show();
										if(data[2]>0){afterAjax(data, '.tag-buttons #like', '.tag-buttons #dislike');};
										if(data[2]<0){afterAjax(data, '.tag-buttons #dislike', '.tag-buttons #like');};
									}
								}
							});
						}else{
							$('#tag').html('<div id="tagNoExits" class="tagNoExits">'+lang.TAGS_WHENTAGNOEXIST+'.</div>'
								+'<div class="smt-tag" style="max-height: 300px; height: 300px;"><img src="../img/templates/defaults/346f3ee097c010b4ed71ce0fb08bbaf2.jpg" class="tag-img"></div>');
							$('.tag-buttons #like, .tag-buttons #dislike, .tag-buttons #comment, #goProfile').hide();


						}
						getComments('reload',opc);
						var interval=setInterval(function(){
							getComments('refresh',opc);
						},7000);
						windowFix();
					}
				});
				function afterAjax(data,toHide,toShow){
					//console.log(toHide+'--'+toShow);
					if(data.indexOf('ERROR')<0)
						$(toHide).fadeOut('slow',function(){
							$(toShow).fadeIn('slow');
						});
					else
						$('#error').html(data);
				}
				$('.tag-buttons a').not('.video').click(function(){
					switch(this.id){
						case 'report':redir(PAGE['reporttag']+'?id='+$_GET['id']);break;
						case 'share':redir(PAGE['sharetag']+'?id_tag='+$_GET['id']);break;
						case 'comment':dialogComment($_GET['id']);break;
						case 'like':case 'dislike':
							var that=this.id+'Icon',
								show=that!='likeIcon'?'likeIcon':'dislikeIcon';
							myAjax({
								type:'GET',
								url:DOMINIO+'controls/tags/actionsTags.controls.php?action='+(that=='likeIcon'?4:11)+'&tag='+$_GET['id'],
								dataType:'html',
								success:function( data ){
									afterAjax(data,'.tag-icons #'+show,'.tag-icons #'+that);
									myAjax({
										type:'GET',
										url:DOMINIO+'controls/tags/actionsTags.controls.php?action=12&tag='+$_GET['id'],
										dataType:'html',
										success:function( data ){
											data= data.split('|');
											opc.likes=data[0];
											opc.dislikes=data[1];
											if(data[2]>0){afterAjax(data, '.tag-buttons #like', '.tag-buttons #dislike');};
											if(data[2]<0){afterAjax(data, '.tag-buttons #dislike', '.tag-buttons #like');};
											$('#numLikes').html(opc.likes);
											$('#numDislikes').html(opc.dislikes);
										}
									});
								}
							});
						break;
						case 'qrcode':
							redir(test);
							
//							myDialog({
//								id:'#qrCodeDialog',
//								content:test,
//								buttons:[{
//									name:lang.close,
//									action:'close'
//								}]
//							});
						break;
						case 'redist':
							myAjax({
								type:'GET',
								url:DOMINIO+'controls/tags/actionsTags.controls.php?action=3&tag='+$_GET['id'],
								dataType:'html',
								success:function( data ){
									afterAjax(data, '.tag-buttons #redist', '.tag-icons #redist');
								}
							});
						break;
						case 'delete':
							var url=$_GET['idGroup']?(PAGE['tagslist']+'?current=group&id='+$_GET['idGroup']):PAGE['timeline'];
							myDialog({
								id:'#singleRedirDialog',
								content:lang.JS_DELETETAG,
								buttons:[{
									name:lang.yes,
									action:function(){
										myAjax({
											type: 'GET',
											url: DOMINIO+'controls/tags/actionsTags.controls.php?action=6&tag='+$_GET['id'],
											dataType: 'html',
											success: function( data ) {
												redir(url);
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
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

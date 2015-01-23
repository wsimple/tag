<?php include 'inc/header.php'; ?>
<div id="page-tag" data-role="page" data-cache="false">
	<div data-role="header" data-theme="f" data-position="fixed">
		<a href="#" id="buttonBack" data-icon="arrow-l"></a>
		<h1 class="tag-title is-logged"></h1>
	</div><!-- /header -->
	<div data-role="content">
		<img class="bg" src="css/smt/bg.png"/>
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<div id="noLoggedEmail" class="logoBackEmail" style="display:none;"></div>
				<div class="tag-solo"><div id="tag" class="tag-container"></div></div>
				<!-- <div class="tag-solo-hash smt-tag-content"></div> -->
				<div class="is-logged tag-comments-window smt-tag-content dnone">
					<ul id="comments" data-role="listview" data-inset="true" class="tag-comments ui-listview list" data-divider-theme="e"></ul>
				</div>
			</div>
		</div>
	</div>
	<div id="tag-footer" class="tag-buttons" data-role="footer" data-theme="f" data-position="fixed" data-tap-toggle="false" style="text-align:center;">
		<!--a id="redist"	style="display:none;"></a>
		<a id="like"	style="display:none;" class="is-logged"></a>
		<a id="dislike"	style="display:none;" class="is-logged"></a>
		<a id="share"	style="display:none;"></a>
		<a id="sponsor"	style="display:none;"></a>
		<a id="report"	style="display:none;"></a>
		<a id="delete"	style="display:none;"></a>
		<a id="youtube"	style="display:none;" class="video" data-ajax="false"></a>
		<a id="vimeo"	style="display:none;" class="video" data-ajax="false"></a>
		<a id="local"	style="display:none;" class="video" data-ajax="false"></a>
		<a id="comment"	style="display:none;" class="is-logged"></a-->
		<!-- <a id="qrcode"	style="display:none;"></a> -->
	</div>
	<div id="popupVideo" data-role="popup" data-overlay-theme="a" data-theme="c" style="padding:7px;"></div>
	<script>
		var Change=isLogged();
		pageShow({
			id:'#page-tag',
			before:function(){
				$('#buttonBack').html(isLogged()?lan('Back'):lang.home).click(function(){ if(isLogged()) goBack(); else redir(PAGE.ini); });
				$('#tagNoExits').html(lang.TAGS_WHENTAGNOEXIST);
			},
			login:function(logged){
				if(logged!==Change) window.location.reload();
			},
			after:function(){
				if(isLogged()){
					$('.is-logged').fadeIn('slow');
				}else{
					$('#noLoggedEmail').show();
					$('.not-logged').fadeIn('slow');
				}
				$('.fs-wrapper').jScroll({hScroll:false});
				var test='';
				// actionsTags(layer);
				myAjax({
					type	:'POST',
					dataType:'json',
					url		:DOMINIO+'controls/tags/tagsList.json.php?this_is_app&id='+$_GET['id']+(is['iOS']?'&embed':''),
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
						if(tag&&(tag['status']!='2')){
							// if(tag['hashTag']){
							// 	var jj,hashS='';
							// 	for(jj=0;jj<tag['hashTag'].length;jj++){
							// 		hashS+='<a href="#" hashT="'+tag['hashTag'][jj]+'">'+tag['hashTag'][jj]+'</a>&nbsp;&nbsp;';
							// 	}
							// 	$('div.tag-solo-hash').html(hashS);
							// }
							$('.tag-title').html(tag['rid']?tag['rname']+lang.TXT_REDIST:tag['uname']);
							delete tag['uname'];
							$('#tag').html(showTag(tag));
							actionsTags('#tag', true);
							$('#tag menu li#comment').click().hide();
						}else{
							$('#tag').html('<div id="tagNoExits" class="tagNoExits">'+lang.TAGS_WHENTAGNOEXIST+'.</div>'
								+'<div class="smt-tag" style="max-height: 300px; height: 300px;"><img src="../img/templates/defaults/346f3ee097c010b4ed71ce0fb08bbaf2.jpg" class="tag-img"></div>');
						}
						windowFix();
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

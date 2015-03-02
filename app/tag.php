<?php include 'inc/header.php'; ?>
<div id="page-tag" data-role="page" data-cache="false">


	<div id="sub-menu" style="position:absolute;top:0px;left:0;padding:0px;" data-position="fixed"  >
		<div style="float: left; margin-left: 10px; margin-top: 20px">
			<a id="buttonBack" href="#" data-icon="arrow-l" onclick="goBack();"></a>
		</div>
	</div>


	<div data-role="content">
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

	<div id="popupVideo" data-role="popup" data-overlay-theme="a" data-theme="c" style="padding:7px;"></div>
	<script>
		var Change=isLogged();
		pageShow({
			id:'#page-tag',
			before:function(){
				newMenu();
				//$('#buttonBack').html(lan('Back'));
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

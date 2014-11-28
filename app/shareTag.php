<?php include 'inc/header.php'; ?>
<div id="page-shareTag" data-role="page" data-cache="false" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="publish_newTag"></a>
	</div>
	<div data-role="content" data-theme="d">
		<img class="bg" src="css/smt/bg.png" />
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<input id="id_tag" type="hidden"/>
				<input id="email" type="hidden"/>
				<input id="full_name" type="hidden"/>
				<div id="sharetag_div" style="display:none;" class="smt-tag-content">
					<div data-role="fieldcontain" style="border:none;">
						<fieldset data-role="controlgroup" data-mini="true">
							<label for="userName_shareTag" id="fromEmail"></label>
							<input id="userName_shareTag" disabled="disabled" />
						</fieldset>
						<label id="title_pictures_shareTag" style="font-size:10px;display:none;"></label>
						<div id="pictures_shareTag" style="min-height:40px;text-align:center;margin:10px auto 5px;width: 69%;">
							<span onclick="selectFriendsDialog($.local('code'))">
								<img src="css/smt/plus.png" width="40" style="margin-left: 5px; border-radius: 5px;" class="userBR"/>
							</span>
						</div>
						<fieldset data-role="controlgroup" data-mini="true">
							<label for="emails_shareTag" id="fromEmails"></label>
							<textarea id="emails_shareTag" style="resize:none;border-radius:5px;height:50px;"></textarea>
							<span id="emails_legend" style="font-size:10px;display:block;"></span>
						</fieldset>
						<fieldset data-role="controlgroup" data-mini="true">
							<label for="message" id="fromMessage"></label>
							<textarea id="message" style="resize:none;border-radius:5px;height:50px;"></textarea>
						</fieldset>
					</div>
					<div id="tag_shareTag" class="smt-tag-content"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="shareTagDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="container">
				<div style="display:inline-block;margin-right:10px;width:65%;">
					<input id="like_friend" name="like_friend" type="text" placeholder="Search" value="" data-inline="true" class="no-disable" />
				</div>
				<div style="display:inline-block;margin-right:10px;width:30%;">
					<input type="button" id="all" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(true,'#shareTagDialog')" class="no-disable" data-mini="true" />
					<input type="button" id="none" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(false,'#shareTagDialog')" class="no-disable" data-mini="true" />
				</div>
				<div class="list-wrapper" style="margin-top:5px;height:150px;"><div id="scroller"><ul data-role="listview" data-inset="true"></ul><div class="clearfix"></div></div></div>
			</div>
			<div class="buttons">
				<a href="#" data-role="button" onclick="getDialogCheckedUsers('#shareTagDialog')" data-theme="f">Ok</a>
			</div>
		</div>
	</div></div></div>
	<script>
		pageShow({
			id:'#page-shareTag',
			title:lang.TITLESHARETAG,
			backButton:true,
			before:function(){
				//language constants
				$('#publish_newTag').html(lang.share);
				$('#all').val(lan('All'));
				$('#none').val(lang.none);
				$('#fromEmail').html(lang.deFrom);
				$('#fromMessage').html(lang.message);
				$('#fromEmails').html('<strong>'+lan('Email')+'</strong>');
				$('#friends').html(lan('friends','ucw'));
				$('#title_pictures_shareTag').html(lang.SHARETAG_TOUCHPICTURE);
				$('#like_friend').attr('placeholder',lang.inputPlaceHolder);
				$('#emails_legend').html(lang.SHARETAG_EMAILSLEGEND);
				$('#email').val($.local('email'));
				$('#full_name').val($.local('full_name'));
				$('#userName_shareTag').val($.local('full_name')+' ('+$.local('email')+')');
			},
			after:function(){
				var idTag=$_GET['id_tag'];
				//$('#tag_shareTag').html(showTag({'id':idTag,'tag':md5(idTag).substr(17)}));
				$('#sharetag_div').fadeIn('slow');
				$('#fs-wrapper,.list-wrapper').jScroll({hScroll:false});
				function shareTag() {
					var device = (is['android'] ? 'Android' : (is['iOS'] ? (is['tablet'] ? 'iPad' : 'iPhone') : false));
					var emailsText = $('#emails_shareTag').val()!=''? $('#emails_shareTag').val():'';
					var friends = [];
					$('#pictures_shareTag input').each(function(){
						friends.push($(this).val());
					});
					emailsText+=(emailsText!=''?',':'')+friends.join();
					myAjax({
						type	:'POST',
						url		:DOMINIO+'controls/tags/actionsTags.controls.php?action=5&tag='+idTag+(device ? '&device='+device : ''),
						data:{mails:emailsText,msj:$('#message').val()},
						dataType:'text',
						success	:function(data){
							myDialog({
								id:'#tagUploadDialog',
								content:data,
								scroll:true,
								style:{'min-height':115},
								buttons:{
									Ok:function(){
										$('#tagUploadDialog .closedialog').click();
										if(data.indexOf('successfully')!=-1)
											redir(PAGE['tag']+'?id='+idTag);
										else
											$('#publish_newTag').one('click',shareTag);
									}
								}
							});
						}
					});
				}
				$('#publish_newTag').one('click',shareTag);
				myAjax({
					type	:'GET',
					dataType:'json',
					url		:DOMINIO+'controls/tags/tagsList.json.php?this_is_app&id='+$_GET['id_tag'],
					error	:function(/*resp,status,error*/) {
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
					success	: function( data ){
						var tag=data['tags'][0];
						//$('#tag_shareTag').html(showTag(tag));
						windowFix();
						setTimeout(function(){$('#fs-wrapper').jScroll('refresh'),300});
					}
				});
				$('#tag_shareTag').html('<div id="tagShare_facebook">'+
											'<iframe src="'+DOMINIO+'views/tags/share/facebook.php?tag='+idTag+'" width="170px" frameborder="0" scrolling="no" height="30px" allowtransparency="true" style="float:left;"></iframe>'+
											'<iframe src="'+DOMINIO+'views/tags/share/twitter.php?tag='+idTag+'" width="130px" frameborder="0" scrolling="no" height="30px" allowtransparency="true" style="float:right;"></iframe>'+
										'</div>');
				//facebook button AND //twitter button
				// $('#tag_shareTag').html('<div id="tagShare_facebook">'+
				// 							'<div id="fb-root"></div>'+
				// 							'<script>(function(d,s,id){'+
				// 								'var js, fjs=d.getElementsByTagName(s)[0];'+
				// 								'if(d.getElementById(id)) return;'+
				// 								'js=d.createElement(s);'+
				// 								'js.id=id;'+
				// 								'js.src="//connect.facebook.net/en_US/all.js#xfbml=1";'+
				// 								'fjs.parentNode.insertBefore(js,fjs);'+
				// 							'}(document,"script","facebook-jssdk"));<\/script>'+
				// 							'<div class="fb-like" data-href="http://tagbum.com/?tag='+idTag.substr(-16)+'" data-layout="button_count" data-show-faces="false"></div>'+
				// 						'</div>'+
				// 						'<div id="tagShare_twitter">'+
				// 							'<a href="https://twitter.com/share" class="twitter-share-button"'+
				// 								'data-url="'+DOMINIO+'?tag='+md5(idTag).substr(-16)+'"'+
				// 								'data-via="tagbum" data-text="Disfruten cha lala" data-lang="en"></a>'+
				// 							'<script type="text/javascript" src="http://platform.twitter.com/widgets.js"><\/script>'+
				// 						'</div>');
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

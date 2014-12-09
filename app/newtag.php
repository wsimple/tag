<?php include 'inc/header.php'; ?>
<div id="page-newTag" data-role="page" data-cache="false">
	<style>
		.smt-tag-bg-mini div{
			background-position:0 50%;
			-webkit-background-size:100% auto;
			-o-background-size:100% auto;
			background-size:100% auto;
			height:100px;
		}
	</style>
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="publish_newTag" data-icon="check" data-theme="f"></a>
	</div>
	<div data-role="content">
		<img class="bg" src="css/smt/bg.png" />
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<input id="imgBase64" value="" type="hidden" />
				<input id="imgTemplate" value="" type="hidden" />
				<div id="master" style="padding:10px 0">
					<div id="div_topText" class="smt-div-profile-color dnone">
						<div style="width:5px;right:30px;position:absolute;">
							<div id="divColorPickerTop">
								<select name="colourPicker1"></select>
							</div>
							<div id="topCounter" style="width:35px;"></div>
						</div>
						<textarea id="topText" name="topText" style="resize:none;"></textarea>
						<input type="hidden" name="topColor" id="topColor" value="#000000" />
					</div>
					<div id="div_middleText" class="smt-div-profile-color" style="margin-bottom:20px;">
						<div style="width:5px;right:30px;position:absolute;">
							<div id="divColorPickerMiddle">
								<select name="colourPicker2"></select>
							</div>
							<div id="middleCounter" style="width:35px;"></div>
						</div>
						<input id="middleText" name="middleText" value="" type="text" />
						<input type="hidden" name="middleColor" id="middleColor" value="#000000" />
					</div>
					<div id="div_bottomText" class="smt-div-profile-color">
						<div style="width:5px;right:30px;position:absolute;">
							<div id="divColorPickerBottom">
								<select name="selectColourPicker3"></select>
							</div>
							<div id="bottomCounter" style="width:35px;"></div>
						</div>
						<textarea id="bottomText" name="bottomText" style="resize:none;"></textarea>
						<input type="hidden" name="bottomColor" id="bottomColor" value="#000000" />
					</div>
					<div id="div_changeMode" class="smt-div-profile">
						<input id="button_changeMode" type="button"/>
					</div>
					<div id="div_publicTag" data-role="fieldcontain" class="smt-tag-content dnone">
						<fieldset data-role="controlgroup">
							<input id="div_publicTag_checkbox" name="div_publicTag_checkbox" type="checkbox" class="custom" checked="checked" />
							<label for="div_publicTag_checkbox" id="publicPrivateTagsApp"></label>
							<div style="font-size:11px;color:#999999;float:left" id="div_leyend_btn_public"></div>
						</fieldset>
					</div>
					<div id="div_Private" style="display:none;">
						<div id="div_shareMails" class="smt-div-profile dnone">
							<label id="EmailsPublicPrivateTagsApp"></label>
							<textarea id="emails_shareTag" name="shareMails" style="resize:none;"></textarea>
							<label id="emails_legend_newtag" style="font-size:10px;"></label>
						</div>
						<div id="div_shareFriends" class="smt-div-profile dnone">
							<input id="button_shareFriends" type="button" onclick="selectFriendsDialog($.local('code'))"/>
							<div id="title_pictures_shareTag" style="font-size:10px;text-align:center;height:15px;display:none;"></div>
							<div id="pictures_shareTag" style="height:40px;margin-bottom:10px;text-align:center;overflow:hidden;"></div>
						</div>
					</div>
					<div class="tag-solo">
						<div class="tag-container">
							<div tag>
								<div id="backgroundPreview" class="tag"></div>
							</div>
						</div>
					</div>
<!-- 					<div class="smt-tag-content ui-shadow-inset">
						<div id="backgroundPreview" class="smt-tag-bg">
						</div>
							<img id="backgroundPreview" style="width:100%;" src="css/smt/bg_pop.png"/>
					</div>
 -->				</div>
			</div>
		</div>
		<div style="display:none;"><img id="checkBackground" src=""></div>
	</div>
	<div data-role="footer" data-position="fixed" data-theme="f" data-tap-toggle="false">
		<div data-role="navbar"><ul id="footerPicture"></ul></div>
	</div>
	<!-- dialogs -->
	<div id="shareTagDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="container" style="font-size: 50%;height:300px;">
				<div style="display:inline-block;margin-right:5px;width:37%;">
					<input id="like_friend" name="like_friend" type="text" placeholder="Search" value="" data-inline="true" class="no-disable" />
				</div>
				<div style="display:inline-block;width:60%;">
					<input type="button" id="all" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(true,'#shareTagDialog')" class="no-disable" data-mini="true" style="padding: 0;"/>
					<input type="button" id="none" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(false,'#shareTagDialog')" class="no-disable" data-mini="true" style="padding: 0;"/>
				</div>
				<div class="list-wrapper" style="margin-top:5px;"><div id="scroller"><ul data-role="listview" data-inset="true"></ul><div class="clearfix"></div></div></div>
			</div>
			<div class="buttons">
				<a href="#" data-role="button" onclick="getDialogCheckedUsers('#shareTagDialog')" data-theme="f">Ok</a>
			</div>
		</div>
	</div></div></div>
	<script>
		pageShow({
			id:'#page-newTag',
			title:function(){
				if($_GET['group']){
					nameMenuGroups($_GET['group'],1,function(data){
						$('.ui-page-active .ui-header h1').html(lang['newGroupTag']+'&nbsp;('+data['name']+')');
					});
					//return lang['newTag']+'&nbsp;<span class="loader s16"></span>';
					return lang['newGroupTag'];
					
				}else if($_GET['product']){
					return lang['STORE_PRODUCT_TAG'];
				}else{
					return lang['newTag'];
				}
			},
			showmenuButton:true,
			before:function(){
				//language constants
				$('#topText'					).attr('placeholder',lang.NEWTAG_MESSAGE);
				$('#middleText'					).attr('placeholder',lang.NEWTAG_MIDDLEMESSAGE);
				$('#bottomText'					).attr('placeholder',lang.NEWTAG_BOTTOMMESSAGE);
				$('#emails_shareTag'			).attr('placeholder',lang.NEWTAG_PLACEHOLDER_EMAIL);
				$('#like_friend'				).attr('placeholder',lang.inputPlaceHolder);
				$('#button_shareFriends'		).attr('value',lang.NEWTAG_BUTTON_SHARE);
				$('#publish_newTag'				).html(lang.publish);
				$('#emails_legend_newtag'		).html(lang.SHARETAG_EMAILSLEGEND);
				$('#div_leyend_btn_public'		).html(lang.NEWTAG_LEYENDBTNPUBLIC);
				$('#publicPrivateTagsApp'		).html(lang.NEWTAG_PRIVATEPUBLICTAG);
				$('#EmailsPublicPrivateTagsApp'	).html(lang.NEWTAG_EMAILSPRIVATEPUBLICTAG);

				$('#title_pictures_shareTag').html(lang.SHARETAG_TOUCHPICTURE);
				$('#all').val(lan('All'));
				$('#none').val(lang.none);
				//hide controls provate tag if isset group
				if($_GET['group']||$_GET['product']){
					$('#div_shareMails, #div_shareFriends, #div_publicTag').hide();
				}
//				console.log($_GET['product']);
//				if ($_GET['product']){
//					$('#div_publicTag').css('display','none');
//				}
				
				//setting footers buttons
				$('#footerPicture').html(
					(CORDOVA?
						'<li><a opc="cam">'+lan('camera','ucw')+'</a></li>'+
						(is['android']&&version.match(/^2\./)?'':'<li><a opc="lib">'+lan('gallery','ucw')+'</a></li>')
					:'')+
					'<li><a id="template">'+lang.NEWTAG_BACKGROUNDAPP+'</a></li>'
				);
				//main scroll
				if(is['limited']){
					$('#page-newTag').addClass('default');
				}else{
					$('.fs-wrapper').jScroll({hScroll:false});
				}
				//mobile keyboard options
				$('#middleText').attr({'autocapitalize':'characters'});
				$('#emails_shareTag').attr({
					'autocapitalize':'none',
					'autocorrect':'off'
				});
				$('#button_changeMode').attr('value',lang.NEWTAG_BUTTON_ADVANCED);
			},
			after:function(){
				$('.ui-loader').css('right','94px'); // Fix Temporal Loader
				$('#page-newTag').removeClass('default'); //Fix Vista Android
				var status=1,aStatus=1,single=true;
				var $bgCheck=$('#checkBackground');
				// management of private/public
				$("#div_publicTag_checkbox").change(function() {
					if(this.checked){
						status=1;
						$('#div_Private').fadeOut('slow');
					}else{
						status=4;
						$('#div_Private').fadeIn('slow');
					}
//					alert(status);
				});
				$('#div_changeMode').click(function(){
					if(single){//cambiar a modo avanzado
						if(aStatus) status=aStatus;
						$('#div_changeMode').fadeOut(function(){
							$('#div_changeMode .ui-btn-text').html(lang.NEWTAG_BUTTON_QUICK);
							$('#div_changeMode,#div_topText,#div_shareMails,#div_shareFriends,#div_publicTag').fadeIn(function(){
								//hide controls provate tag if isset group
								if($_GET['group']||$_GET['product']){
									$('#div_shareMails, #div_shareFriends, #div_publicTag').hide();
								}
								if(!is['limited']) $('.fs-wrapper').jScroll('refresh');
							});
						});
					}else{//cambiar a modo simple
						aStatus=status;
						status=1;
						$('#div_changeMode,#div_topText,#div_shareMails,#div_shareFriends,#div_publicTag').fadeOut(function(){
							$('#div_changeMode .ui-btn-text').html(lang.NEWTAG_BUTTON_ADVANCED);
							$('#div_changeMode').fadeIn(function(){
								if(!is['limited']) $('.fs-wrapper').jScroll('refresh');
							});
							$('#topText,#emails_shareTag').val('');
							$('#pictures_shareTag').html('');
						});
					}
					single=!single;
				})
				// colour picker
				//fill palletes
				paletteColorPicker('#divColorPickerTop,#divColorPickerMiddle,#divColorPickerBottom');
				//general options
				var enableInputs,cpOpc={
					title:false,
					css:{right:45,left:''},
					open:function(){
						if(enableInputs) enableInputs();
						enableInputs=disableInputs();
					},
					close:function(){
						if(enableInputs){
							enableInputs();
							enableInputs=false;
						}
					}
				};
				//top message
				$('#divColorPickerTop').colourPicker($.extend({},cpOpc,{
					color:'#F82',
					colorChange:function(color){
						$('#topText').css('color',color);
						$('#topColor').val(color);
					}
				}));
				//middle message
				$('#divColorPickerMiddle').colourPicker($.extend({},cpOpc,{
					color:'#461',
					colorChange:function(color){
						$('#middleText').css('color',color);
						$('#middleColor').val(color);
					}
				}));
				//bottom message
				$('#divColorPickerBottom').colourPicker($.extend({},cpOpc,{
					color:'#5A5A5D',
					colorChange:function(color){
						$('#bottomText').css('color',color);
						$('#bottomColor').val(color);
					}
				}));
				// END - colour picker
				// counters
				$('#topCounter').textCounter({
					target		:'#topText',	// required: string
					count		:50,			// optional: integer [defaults 140]
					alertAt		:20,			// optional: integer [defaults 20]
					warnAt		:10,			// optional: integer [defaults 0]
					stopAtLimit	:true			// optional: defaults to false
				});
				$('#middleCounter').textCounter({
					target		:'#middleText',
					count		:12,
					alertAt		:5,
					warnAt		:2,
					stopAtLimit	:true
				});
				$('#bottomCounter').textCounter({
					target		:'#bottomText',
					count		:200,
					alertAt		:20,
					warnAt		:10,
					stopAtLimit	:true
				});
				// END - counters
				$('.list-wrapper').jScroll({hScroll:false});
				$('#footerPicture #template').click(function(){
					$.ajax({
						url:SERVERS.img,
						type:'get',
						data:{folder:'templates'},
						xhrFields:{withCredentials:true},
						headers:{},
						success:function(data){
							if(!data||!data['files']) return;
							var list='';
							data['files'].forEach(function(el){
								list+=
								'<div style="background-image:url('+el.url+');" '+
									'data-url="'+el.url+'" data-template="'+el.code+'/'+el.name+'"></div>';
							});
							myDialog({
								id:'#backgroundsDialog',
								content:'<div class="smt-tag-bg-mini">'+list+'</div>',
								style:{'padding-right':5,height:300},
								scroll:true,
								after:function(){
									$('#backgroundsDialog div[data-template]').click(function(){
										$bgCheck[0].dataset.template=this.dataset.template;
										$bgCheck[0].dataset.url=this.dataset.url;
										$bgCheck.attr('src',this.dataset.url);
										$('#backgroundsDialog .closedialog').click();
									});
									windowFix();
								}
							});
						}
					});
				});
				var img64;
				$('#checkBackground').load(function(){
					var bg;
					if(this.dataset.template){
						console.log('template');
						$('#imgTemplate').val(this.dataset.template);
						img64='';
						bg=this.dataset.url;
					}
					if(this.dataset.img64){
						console.log('img64');
						$('#imgTemplate').val('');
						img64=this.dataset.img64;
						bg=img64;
					}
					if(bg){
						var bgsize=this.naturalWidth>650?100:100*this.naturalWidth/650;
						bgsize=bgsize+'% auto';
						$('#backgroundPreview').css({
							'background-image':'url('+bg+')',
							'-webkit-background-size':bgsize,
							'-o-background-size':bgsize,
							'background-size':bgsize,
							'background-position':'50%'
						});
						$(this).attr('src','');
						this.dataset.template='';
						this.dataset.img64='';
					}
				});
				if(CORDOVA){
					document.addEventListener('deviceready',function(){
						var cam=Camera,
							photoData={
								targetWidth:650,
								quality:60,
								destinationType:cam.DestinationType.DATA_URL
							},
							onPhotoSuccess=function(data){
								if(!data.match(/^https?:\/\//i)){//no url = base64
									data='data:image/jpg;base64,'+data;
									$bgCheck[0].dataset.img64=data;
									img64=data;
									$bgCheck.attr('src',data);
								}
							},
							onPhotoFail=function(message){
								//if(message!='no image selected') myDialog(message);
							},
							getPhoto=function(type){
								var data=$.extend({},photoData);
								switch(type){
									case 'editcam'://camara (editable)
										data.allowEdit=true;
									break;
									case 'lib':
										data.sourceType=cam.PictureSourceType.PHOTOLIBRARY;
									break;
									case 'album':
										data.sourceType=cam.PictureSourceType.SAVEDPHOTOALBUM;
									break;
									case 'cam':break;//camara - default
								}
								try{
									navigator.camera.getPicture(onPhotoSuccess,onPhotoFail,data);
								}catch(e){
									myDialog('Error: '+e);
								}
							};
						$('#footerPicture').on('click','a[opc]',function(){
							getPhoto($(this).attr('opc'));
						});
					},false);
				}
				function publish(){
					var i,emails=[];
					if($('#emails_shareTag').length>0){
						var tmp = $('#emails_shareTag').val().replace(/\s+/g, '');
						if( tmp!='' ) {
							tmp=tmp.split(',');
							for(i in tmp)
								if( isMail(tmp[i]) ) emails.push(tmp[i]);
						}
					}
					$('#pictures_shareTag input').each(function(){
						emails.push($(this).val());
					});
					//alert(emails.join());
					myAjax({
						type:'POST',
						url:DOMINIO+'controls/tags/newTag.json.php',
						dataType:'json',
						data:{
							type		:'newtag',
							img64		:img64,
							imgTemplate	:$('#imgTemplate').val(),
							topText		:$('#topText').val().substring(0,50),
							middleText	:$('#middleText').val().substring(0,12),
							bottomText	:$('#bottomText').val().substring(0,200),
							topColor	:$('#topColor').val(),
							middleColor	:$('#middleColor').val(),
							bottomColor	:$('#bottomColor').val(),
							status		:$_GET['group']?7:status,
							people		:emails,
							group		:$_GET['group']||'',
							product		:$_GET['product']||''
						},
						error:function() {
							myDialog(lang.conectionFail);
						},
						success:function(data) {
							if(data['done']){
								localStorage.removeItem('timeLine');
								if(false&&$.local('enableLogs')){
									myDialog({
										id:'#tagUploadDialog',
										content:'Tag Successfully Created',
										buttons:{
											Ok:function(){
												//console.log( $_GET['group']);
												if($_GET['group'] && $_GET['group'] != '' ) {
													redir(PAGE['tagslist']+'?current=group&id='+$_GET['group']);
												}else{
													redir(PAGE['timeline']);
												}
											}
										}
									});
								}else{
									if($_GET['group'] && $_GET['group'] !== '' ) {
										redir(PAGE['tagslist']+'?current=group&id='+$_GET['group']);
									}else if($_GET['product'] && $_GET['product'] !== ''){
										redir(PAGE['storeMypubli']);
									}else{
										localStorage.removeItem('timeLine');
										redir(PAGE['timeline']);
									}
								}
							}
						},
						complete:function(){
							$('#publish_newTag').one('click',publish);
						}
					});
				}
				$('#publish_newTag').one('click',publish);
				function shareByMail() {
					myAjax({
						type	:'GET',
						url		:DOMINIO+'controls/tags/actionsTags.controls.php?action=5&tag='+$('#id_tag').val()+'&mails='+friends.join()+'&msj='+$('#message').val(),
						dataType:'text',
						success	:function(data){
							myDialog({
								id:'#tagUploadDialog',
								content:data,
								buttons:{
									Ok:function(){
										redir(PAGE['timeline']);
									}
								}
							});
						}
					});
				}
			}//end after
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

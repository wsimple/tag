<?php include 'inc/header.php'; ?>
<script src="js/core/jquery.panzoom.js"></script>
<div id="page-newTag" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<!-- <h1></h1>
		<a id="publish_newTag" data-icon="check" data-theme="f"></a> -->
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;"></div>
	</div>
	<div data-role="content">
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<input id="imgBase64" value="" type="hidden" />
				<input id="imgTemplate" value="" type="hidden" />
				<div id="master" style="padding:10px 0">
					<div class="tag-solo">
						<div class="tag-container">
							<div tag>
								<div id="backgroundPreview" class="tag"></div>
							</div>
						</div>
						<div class="inputs-tag">
							<div id="div_topText" class="smt-div-profile-color">
								<div class="counter-container">
									<div id="divColorPickerTop">
										<select name="colourPicker1"></select>
									</div>
									<div id="topCounter" style="width:35px;"></div>
								</div>
								<input type="text" name="topText" style="resize:none;" id="topText">
								<input type="hidden" name="topColor" id="topColor" value="#000" />
							</div>
							<div id="div_middleText" class="smt-div-profile-color">
								<div class="counter-container">
									<div id="divColorPickerMiddle">
										<select name="colourPicker2"></select>
									</div>
									<div id="middleCounter" style="width:35px;"></div>
								</div>
								<input id="middleText" name="middleText" value="" type="text" />
								<input type="hidden" name="middleColor" id="middleColor" value="#000" />
							</div>
							<div id="div_bottomText" class="smt-div-profile-color">
								<div class="counter-container">
									<div id="divColorPickerBottom">
										<select name="selectColourPicker3"></select>
									</div>
									<div id="bottomCounter" style="width:35px;"></div>
								</div>
								<input type="text" id="bottomText" name="bottomText" style="resize:none;">
								<input type="hidden" name="bottomColor" id="bottomColor" value="#000" />
							</div>
						</div>
					</div>
					<div id="hashTags" class="dnone"></div>
					<div id="privacy-options">
						<ul class="ui-grid-c">
							<li class="ui-block-a"></li>
							<li class=" ui-block-b">
								<div class="privacy-private">
									<input id="div_privateTag_checkbox" name="privacyOption" type="radio" />
									<label for="div_privateTag_checkbox" id="privateTagsApp"></label>
								</div>
							</li>
							<li class="ui-block-c">
								<div class="privacy-public">
									<input id="div_publicTag_checkbox" name="privacyOption" type="radio" checked="checked"/>
									<label for="div_publicTag_checkbox" id="publicTagsApp"></label>
								</div>
							</li>
							<li class="ui-block-c">
								<div class="video-icon"></div>
							</li>
							<li class="ui-block-d"></li>
						</ul>
					</div>
					<div id="div_Private" style="display:none;">
						<div id="div_shareMails" class="smt-div-profile">
							<label id="EmailsPublicPrivateTagsApp"></label>
							<textarea id="emails_shareTag" name="shareMails" style="resize:none;margin-bottom:0px;"></textarea>
							<label id="emails_legend_newtag" style="font-size:10px;"></label>
						</div>
						<div id="div_shareFriends" class="smt-div-profile">
							<input id="button_shareFriends" type="button" onclick="selectFriendsDialog($.local('code'))"/>
							<div id="title_pictures_shareTag" style="font-size:10px;text-align:center;height:15px;display:none;"></div>
							<div id="pictures_shareTag" style="height:40px;margin-bottom:10px;text-align:center;overflow:hidden;"></div>
						</div>
						<div>
							<input type="hidden" name="htxtVideo" id="htxtVideo" value=""> 
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div style="display:none;"><img id="checkBackground" src=""></div>
	</div>
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
			before:function(){
				newMenu();
				//language constants
				$('#menu').html(
					'<span class="ui-block-a menu-button hover"><a href="#"><img src="css/newdesign/submenu/create_tag.png"><br>'+lan('newTag','ucw')+'</a></span>'+
					(CORDOVA? // opc="cam"
						'<span class="ui-block-b menu-button"><a href="#" opc="camop"><img src="css/newdesign/newtag/camera.png"><br>'+lan('camera','ucw')+'</a></span>'+
						(is['android']&&version.match(/^2\./)?'':'<span class="ui-block-b menu-button"><a href="#" opc="lib"><img src="css/newdesign/newtag/gallery.png"><br>'+lan('gallery','ucw')+'</a></span>')
					:'<span class="ui-block-b"></span>')+
					'<span id="footerPicture" class="ui-block-c menu-button"><a href="#" id="template"><img src="css/newdesign/newtag/images.png"><br>'+lang.NEWTAG_BACKGROUNDAPP+'</a></span>'+
					'<span class="ui-block-d menu-button"><a href="timeLine.html"><img src="css/newdesign/newtag/cancel.png"><br>'+lan('cancel','ucw')+'</a></span>'+
					'<span class="ui-block-e menu-button"><a id="publish_newTag" href="#" title="newtag"><img src="css/newdesign/newtag/publish.png"><br>'+lang.publish+'</a></span>'
				);
				if(CORDOVA){
					$('#menu span').addClass('fix-grid');
				};
				$('#topText'					).attr('placeholder',lang.NEWTAG_MESSAGE);
				$('#middleText'					).attr('placeholder',lang.NEWTAG_MIDDLEMESSAGE);
				$('#bottomText'					).attr('placeholder',lang.NEWTAG_BOTTOMMESSAGE);
				$('#emails_shareTag'			).attr('placeholder',lang.NEWTAG_PLACEHOLDER_EMAIL);
				$('#like_friend'				).attr('placeholder',lang.inputPlaceHolder);
				$('#button_shareFriends'		).attr('value',lang.NEWTAG_BUTTON_SHARE);
				//$('#publish_newTag'				).html(lang.publish);
				$('#emails_legend_newtag'		).html(lang.SHARETAG_EMAILSLEGEND);
				$('#div_leyend_btn_public'		).html(lang.NEWTAG_LEYENDBTNPUBLIC);
				$('#privateTagsApp'		).html(lang.private);
				$('#publicTagsApp'		).html(lang.NEWTAG_PRIVATEPUBLICTAG);
				$('#EmailsPublicPrivateTagsApp'	).html(lang.NEWTAG_EMAILSPRIVATEPUBLICTAG);

				$('#title_pictures_shareTag').html(lang.SHARETAG_TOUCHPICTURE);
				$('#all').val(lan('All'));
				$('#none').val(lang.none);
				//hide controls provate tag if isset group
				if($_GET['group']||$_GET['product']){
					$('#div_shareMails, #div_shareFriends, #div_publicTag').hide();
				}
				if($_GET['group']){
					$('#publish_newTag').addClass('publish_newTag_group');
				}
//				console.log($_GET['product']);
//				if ($_GET['product']){
//					$('#div_publicTag').css('display','none');
//				}
				
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
				var status=1,bgMatrix = ['0','0','0','0','0','0'];
				var $bgCheck=$('#checkBackground');
				// management of private/public
				$("#div_privateTag_checkbox,#div_publicTag_checkbox").change(function() {
					if(this.checked){
						if (this.id=='div_privateTag_checkbox') {
							status=4;
							$('#div_Private').fadeIn('slow');
							if($_GET['group']||$_GET['product']){
								$('#div_shareMails, #div_shareFriends, #div_publicTag').hide();
							}
							if(!is['limited']) $('.fs-wrapper').jScroll('refresh');
						}else{
							status=1;
							$('#div_Private').fadeOut('slow');
							if(!is['limited']) $('.fs-wrapper').jScroll('refresh');
							$('#topText,#emails_shareTag').val('');
							$('#pictures_shareTag').html('');
						}
					}
				});
				catchHashtags('#topText,#middleText,#bottomText', '#hashTags');
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
					color:'#F57133',
					colorChange:function(color){
						// $('#topText').css('color',color);
						$('#topColor').val(color);
					}
				}));
				//middle message
				$('#divColorPickerMiddle').colourPicker($.extend({},cpOpc,{
					color:'#461',
					colorChange:function(color){
						// $('#middleText').css('color',color);
						$('#middleColor').val(color);
					}
				}));
				//bottom message
				$('#divColorPickerBottom').colourPicker($.extend({},cpOpc,{
					color:'#5A5A5D',
					colorChange:function(color){
						// $('#bottomText').css('color',color);
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
						url:SERVERS.img+'?code='+$.local('code')+'&folder=templates',
						type:'get',
						xhrFields:{withCredentials:true},
						headers:{},
						success:function(data){
							var list='';
							if(data['files'].length === 0){list="<div class='tcAlert'>"+lang.NEWTAG_NO_BACKGROUNDS+"</div>";} 
							data['files'].forEach(function(el){
								list+=
								'<div style="background-image:url('+el.url+');" '+
									'data-url="'+el.url+'" data-template="'+$.local('code')+'/'+el.name+'"></div>';
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
					var imagePrev = new Image();
					console.log('cargare bg');
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
					imagePrev.src = bg;
					var img = this;
					if(bg){
						var bgsize=this.naturalWidth>1200?100:100*this.naturalWidth/1200;
						bgsize=bgsize+'% auto';
						// bg = 'http://www.scorezero.com/wp-content/uploads/2014/10/gtaV.jpg'; // solo Pruebas
						$('#backgroundPreview').html('<img id="backgroundImage" src="'+bg+'" alt="">');
						$('.tag-solo').prepend('<div class="touch-leyend"></div>');
						var panzoomOpt = { maxScale: img.naturalWidth / img.clientWidth, minScale: 1,contain:'invert'};
						window.panzoom = $("#backgroundImage").panzoom(panzoomOpt).off('.panz')
						.on('panzoomstart.panz',function(){
							$('.fs-wrapper').jScroll('remove');
							$('.inputs-tag').css('opacity','0.4');
						}).on('panzoomend.panz',function(e, panzoom){
							$('.inputs-tag').css('opacity','1');
							$('.fs-wrapper').jScroll();
						});
						$('.tag-container').on('mousewheel.panz',function(e){
							console.log('event:',e);
							e.preventDefault();
							var delta = e.delta || e.originalEvent.wheelDelta;
							var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
							panzoom.panzoom('zoom',zoomOut,{
								increment: 0.1,
								animate: false,
								focal: e
							});
						});

						$(this).attr('src','');
						this.dataset.template='';
						this.dataset.img64='';
						var imgWidth=panzoom.width();
						$(window).off('resize.panzoom,orientationchange.panzoom')
						.on('resize.panzoom,orientationchange.panzoom',function(){
							var bgMatrix=panzoom.panzoom('getMatrix');
							bgMatrix[4]=Math.floor(bgMatrix[4]*panzoom.width()/imgWidth);
							bgMatrix[5]=Math.floor(bgMatrix[5]*panzoom.width()/imgWidth);
							imgWidth=panzoom.width();
							panzoom.panzoom('resetDimensions')
								.panzoom('setMatrix',JSON.parse('['+bgMatrix.toString()+']'));
						});
					}
					$('#middleText, #topText, #bottomText').attr('disabled', '');
					$('#middleText, #topText, #bottomText').removeAttr('disabled');
				});

				if(CORDOVA){
					$('.video-icon').click(function(event) {
							  contentLoading='<div><h4>'+lan('Video discard')+'</h4><p>'+
											   lan('Do you want to discard this video?')+'</br></p></div>'+
											   '<div>&nbsp;</div>';
								myDialog({
						            id:'#deleteVideoDialog',
						            content :contentLoading,
						            buttons:[{  name:lan('Yes'), 
						            			action:function(){
						            			$('#htxtVideo').val('');
						            			$('.video-icon').hide();
						            			this.close();	

						            		}},{name:lan('No'),
						            			action:function(){ 
						            				this.close(); 
						            			}
						            		}]
						        });
						
					});
				 	function selectBackground(convertResult){
										var list='';

										response=jQuery.parseJSON(convertResult.response);

										$('#htxtVideo').val(response.video);
										$('.video-icon').show();
										console.log('selectBackground: '+JSON.stringify(response));
										
										captures=response.captures;
										if(captures.length > 1){ 
											for (var i in captures) {	
												_url=SERVERS.video+'/videos/'+captures[i];
												console.log(_url+' - '+captures[i]);
												list+='<div style="background-image:url('+_url+'); height:150px;" '+
													  'data-url="'+_url+'" data-template="'+captures[i]+'"></div>';
											}
											myDialog({
												id:'#backgroundsVideoDialog',
												content:'<div class="smt-tag-bg-mini">'+list+'</div>',
												style:{'padding-right':5,height:450},
												scroll:true,
												after:function(){

													$('.ui-loader').hide();
													$('#backgroundsVideoDialog div[data-template]').click(function(){
														$bgCheck[0].dataset.template=this.dataset.template;
														$bgCheck[0].dataset.url=this.dataset.url;
														$bgCheck.attr('src',this.dataset.url);
														$('#backgroundsVideoDialog .closedialog').click();
													});
													windowFix();
												}
											});
										}
										$('#LoadingVideo').hide();
										$bgCheck[0].dataset.template=captures[0];
										$bgCheck[0].dataset.url=SERVERS.video+'/videos/'+captures[0];
										$bgCheck.attr('src',SERVERS.video+'/videos/'+captures[0]);
									
					}//convertVideo
					function uploadFile(dataUpload){

								var fileURL=dataUpload.fullPath,
								params=dataUpload.data||{},
								ft = new FileTransfer();
								params = { code:$.local('code')};
								var options = new FileUploadOptions();
								options.fileName = dataUpload.name;
								options.mimeType = dataUpload.type;
								options.params = params;
								options.chunkedMode=true;
								$('#shootType').hide();
								$('.ui-loader').show();
								contentLoading='<div><h4>'+lan('Video upload')+'</h4><p>'+
											   lan('Your video is uploading, this can take few minutes...')+'</br></p></div>'+
											   '<div>&nbsp;</div>';
								myDialog({
						            id:'#LoadingVideo',
						            content :contentLoading,
						            buttons:[]
						        });	
								ft.upload(fileURL,
								encodeURI(SERVERS.video+"/upload.php?convert"),
								selectBackground,
								function(error){
									console.log('Error uploading file, Error Code:: ' + error.code + ', Source: ' + error.source +', '+ error.target);
									$('#LoadingVideo').hide();
								},
								options
								);

					}

					function removefile(file){
					    fileSystem.root.getFile(file, {create: false, exclusive: false}, gotRemoveFileEntry, fail);
					}

					function gotRemoveFileEntry(fileEntry){
					    console.log(fileEntry);
					    fileEntry.remove(success, fail);
					}

					function success(entry) {
					    console.log("Removal succeeded");
					}

					function fail(error) {
					    console.log("Error removing file: " + error.code);
					}

					var extToMimes = {
								       'mp4':'video/mp4',
								       'm4v':'video/mp4',
								       'mov':'video/quicktime',
								       'ogv':'video/ogg',
								       'ogg':'video/ogg',
								       '3gp':'video/3gpp',
								       'avi':'video/x-msvideo',
								       'mkv':'video/x-matroska',
								       'flv':'video/x-flv',
								       'mpeg':'video/mpeg',
								       'mpg':'video/mpeg',
								       'vob':'video/dvd'
								    }
					function getMimeByExt(file) {
					    var ext = file.substr( (file.lastIndexOf('.') +1));
					    if (extToMimes.hasOwnProperty(ext)) {
				           return extToMimes[ext];
				        }
				        return false;
					    
					}
					function videoTranscodeSuccess(result) {

						if($.isArray(result)) result=result.fullPath;

					    console.log('videoTranscodeSuccess, result: ' + result);
					    uploadFile({fullPath:result,name:result.substr( (result.lastIndexOf('/') +1)),type:getMimeByExt(result)});
					    
					}

					function videoTranscodeError(err) {
					    console.log('videoTranscodeError, err: ' + err);
					}


					document.addEventListener('deviceready',function(){
						var cam=Camera,
							photoConfig={
								targetWidth:1200,
								targetHeight: 554,
								quality:90,
								destinationType:cam.DestinationType.DATA_URL,
								//allowEdit:true,
								correctOrientation:true
							},
							onPhotoSuccess=function(data){
								
								$('#shootType').hide();
								
								if(!data.match(/^https?:\/\//i)){//no url = base64
									data='data:image/jpg;base64,'+data;
									$bgCheck[0].dataset.img64=data;
									img64=data;
									$bgCheck.attr('src',data);
								}

								if(data.match(/(\.|\/)(mp4|m4v|mov|ogv|ogg|3gp|avi|mkv|flv|mpe?g|vob)$/i)){// es video

									data=data.replace('data:image/jpg;base64,','');

									name_=data.substr( (data.lastIndexOf('/') +1));
									var dataOut='';
									VideoEditor.transcodeVideo(
								        videoTranscodeSuccess,
								        videoTranscodeError,
								        {
								            fileUri: data, 
								            outputFileName: Math.random()+'_'+name_, 
								            quality: VideoEditorOptions.Quality.HIGH_QUALITY,
								            outputFileType: VideoEditorOptions.OutputFileType.MPEG4,
								            optimizeForNetworkUse: VideoEditorOptions.OptimizeForNetworkUse.YES,
								            duration: 60
								        }
								    );									
								}
							},
							onPhotoFail=function(message){
								//if(message!='no image selected') myDialog(message);
							},
							getPhoto=function(type){
								var photoData=$.extend({},photoConfig);
								switch(type){

									case 'lib':
										photoData.mediaType=cam.MediaType.ALLMEDIA;
										photoData.sourceType=cam.PictureSourceType.PHOTOLIBRARY;
									break;

									case 'camop': 
										
											var html_ =  '<div id="shootMenu">'
															+ '<p>'+lan('Take either a Photo or Video')+'</p>'
															+ '<hr>'
															+ '<div opc="shoot_p">'
																+ '<img src="css/newdesign/newtag/camera.png" width="80px" >'
															+ '</div>'
															+ '<div opc="shoot_v">'
																+ '<img src="css/newdesign/newtag/video_camera.png" width="80px" >'
															+ '</div>'
														+ '</div>';

											myDialog({
												id:'#shootType',
												content: html_,
												style:{'padding':5,height:180},
												scroll:false,
												after:function(){
													
													$('#shootMenu').on('click', 'div[opc]', function(e){
														if ($(this).attr('opc')=='shoot_p'){
															navigator.camera.getPicture(onPhotoSuccess,onPhotoFail,photoData);
														}else{
															var cam=Camera,
															captureSuccess=function(mediaFiles){
																var i,len;
																for (i = 0, len = mediaFiles.length; i < len; i += 1) {
																	
																	name_=mediaFiles[i].fullPath.substr( (mediaFiles[i].fullPath.lastIndexOf('/') +1));
																	VideoEditor.transcodeVideo(
																        videoTranscodeSuccess,
																        videoTranscodeError,
																        {
																            fileUri: mediaFiles[i].fullPath, 
																            outputFileName: Math.random()+'_'+name_, 
																            quality: VideoEditorOptions.Quality.HIGH_QUALITY,
																            outputFileType: VideoEditorOptions.OutputFileType.MPEG4,
																            optimizeForNetworkUse: VideoEditorOptions.OptimizeForNetworkUse.YES,
																            duration: 60
																        }
																    );	
																}
															},
															captureError=function(error){
																console.log('Error code: '+error.code,null,'Capture Error');
															};

															navigator.device.capture.captureVideo(captureSuccess,captureError,{limit:1,duration: 60});
														}//else
													});
													windowFix();	
												}
											});



									break;

									case 'cam':
									break;//camara - default
								}
	
								if (type!='camop'){
									navigator.camera.getPicture(onPhotoSuccess,onPhotoFail,photoData);
								}		

							
							};

							$('#menu').on('click','a[opc]',function(e){
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
					var bgMatrix=[];
					if(window.panzoom){
						var realWidth=1200,scaledWidth=panzoom.width();
						bgMatrix=panzoom.panzoom('getMatrix');
						bgMatrix[4]=Math.floor(bgMatrix[4]*realWidth/scaledWidth);
						bgMatrix[5]=Math.floor(bgMatrix[5]*realWidth/scaledWidth);
						console.log('bgmatrix',bgMatrix);
					}
					myAjax({
						type:'POST',
						url:DOMINIO+'controls/tags/newTag.json.php',
						dataType:'json',
						data:{
							type		:'newtag',
							img64		:img64,
							htxtVideo   :$('#htxtVideo').val(),
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
							product		:$_GET['product']||'',
							matrix		:'['+bgMatrix.toString()+']'
						},
						error:function(){
							myDialog(lang.conectionFail);
						},
						success:function(data){
							var nonpublic = (data['nonpublic']) ? '?nonpublic=1' : '';
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
													redir(PAGE['timeline']+nonpublic);
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
										if(data['status']==4){ 
											
											$.local('timeLine', {'last_tab':'privateTags'}); 
										}else{
											localStorage.removeItem('timeLine');
										}
										redir(PAGE['timeline']+nonpublic);
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
	$('#hashTags').on('click','.hash span', function(){
		if ($('#hashTags .hash').length == 1) {$('#hashTags').slideUp('slow');}; //Oculta menu de hastags si es el ultimo
		var tag = $(this).parent();
		var text = $('#'+tag[0].dataset.input).val();
		text = text.replace($(tag[0]).find('p').text(),'');
		$('#'+tag[0].dataset.input).val(text.trim());
		$(tag[0]).remove();
	});
	function catchHashtags(inputs,container){
		var hashing=false,finalHash='',startIn=false, finishIn=false;
		$(inputs).keypress(function(event) {
			if (event.charCode == 35) {	//es un sharp (#)
				if (hashing) {			//Rompe el hash si pone otro
					finishIn=$(this).val().length;
					finalHash = $(this).val().substr(startIn,finishIn);
				}
				hashing = true;
				startIn=$(this).val().length;
			}else if(event.charCode == 32){ //Es un espacio
				if (hashing) {
					hashing = false;
					finishIn=$(this).val().length;
					finalHash = $(this).val().substr(startIn,finishIn);
				};
			}
			if (finalHash!='' && finalHash.charAt(0) == '#'){
				$(container).append('<div class="hash" data-input="'+this.id+'"><p>'+finalHash+'</p><span>X</span></div>');
				$(container).slideDown('slow');
				finalHash = '';
			}
		}).focusout(function(event) {
			if (hashing) {
				hashing = false;
				finishIn=$(this).val().length;
				finalHash = $(this).val().substr(startIn,finishIn);
				if (finalHash.charAt(0) == '#'){ 
					$(container).append('<div class="hash" data-input="'+this.id+'"><p>'+finalHash+'</p><span>X</span></div>');
				}
				$(container).slideDown('slow');
				finalHash = '';
			}
		});
	}
	</script>
</div>
<?php include 'inc/footer.php'; ?>

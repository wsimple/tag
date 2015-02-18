<?php include 'inc/header.php'; ?>
<div id="page-videoUpload" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="send" data-icon="check" data-theme="f" style="display:none;"></a>
	</div>
	<div data-role="content">
		<button id="galeryVideo" class="video" style="display:none;">Galery</button>
		<button id="uploadVideo" class="video" style="display:none;">Upload</button>
		<div id="video">
		</div>
	</div>
<!-- 	<div data-role="footer" data-position="fixed" data-theme="f" data-tap-toggle="false">
		<div data-role="navbar"><ul id="footerPicture"></ul></div>
	</div> -->
	<script>
		pageShow({
			id:'#page-videoUpload',
			title:lan('video upload','ucw'),
			buttons:{showmenu:true},
			before:function(){
			},
			after:function(){
				$.cordova(function(){
					$(".video").fadeIn(300);
					var cam=Camera,
						Log=function(text,clear){
							if(clear) $('#video').html('');
							$('#video').append(text+'<br/>');
						},
						galerySuccess=function(path_file){
							var file={
								fullPath:path_file,
								name:path_file.replace(/([^\/]*\/)*/g,'')
							};
							Log('galery success',true);
							console.log('galery success:',file);
							uploadFile({file:file});
						},
						captureSuccess=function(mediaFiles){
							var i,path,len;
							Log('capture success',true);
							// Log(JSON.stringify(mediaFiles));
							for (i = 0, len = mediaFiles.length; i < len; i += 1) {
								path = mediaFiles[i].fullPath;
								// do something interesting with the file
								console.log(path);
								uploadFile({file:mediaFiles[i]});
							}
						},
						uploadFile=function(data){
							var path=data.file.fullPath,
								params=data.data||{},
								ft=new FileTransfer();
							params.fileName=data.file.name;
							Log('uploading...');
							ft.upload(path,
								"http://v.tagbum.com/upload.php",
								function(result){
									var data=JSON.parse(result.response);
									Log('Upload success: ' + result.responseCode);
									Log(result.bytesSent + ' bytes sent');
									Log('data:'+JSON.stringify(data));
									console.log('data:',data);
									if(data.urls[0])
										Log('First Link: <a href="http://v.tagbum.com/'+data.urls[0]+'">'+data.urls[0]+'</a>');
								},
								function(error){
									Log('Error uploading file ' + path + ': ' + error.code);
								},
								params
							);
						},
						galeryError=function(){
							Log('galery error',true);
							console.log('galery error');
						},
						captureError=function(error){
							navigator.notification.alert('Error code: '+error.code,null,'Capture Error');
							Log('capture error',true);
							console.log('capture error');
						};
					$('#galeryVideo').click(function(){
						try{
							navigator.camera.getPicture(galerySuccess,galeryError,{
								quality:50,
								destinationType:cam.DestinationType.FILE_URI,
								sourceType:cam.PictureSourceType.PHOTOLIBRARY,
								mediaType:cam.MediaType.VIDEO
							});
						}catch(e){
							myDialog('Error: '+e);
						}
					});
					$('#uploadVideo').click(function(){
						try{
							navigator.device.capture.captureVideo(captureSuccess,captureError,{limit:1});
						}catch(e){
							myDialog('Error: '+e);
						}
					});
				});
			}//end after
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

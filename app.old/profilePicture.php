<?php include 'inc/header.php'; ?>
<div id="page-profilePic" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="send" data-icon="check" data-theme="f" style="display:none;"></a>
	</div>
	<div data-role="content">
		<input id="imgBase64" value="" type="hidden"/>
		<img id="tmp" src style="display:none;"/>
		<div id="picture-box" style="position:relative;margin:10px auto;overflow:hidden;background:#ccc;width:200px;height:200px;">
			<div class="pic-wrapper" style="position:relative;width:100%;height:100%;">
				<div style="position:relative;width:100%;height:100%;">
					<img id="img" src style="width:100%;height:auto;"/>
					<div id="divimg" style="position:absolute;top:0;width:100%;height:100%;"></div>
				</div>
			</div>
		</div>
	</div>
	<div data-role="footer" data-position="fixed" data-theme="f" data-tap-toggle="false">
		<div data-role="navbar"><ul id="footerPicture"></ul></div>
	</div>
	<script>
		pageShow({
			id:'#page-profilePic',
			title:lan(CORDOVA?'change picture':'edit thumbnail','ucw'),
			backButton:true,
			before:function(){
				//language constants
				$('#send').html(lan('save','ucw'));
				if(CORDOVA){
					$('#footerPicture').html(
						'<li><a opc="editcam">'+lan('camera','ucw')+'</a></li>'+
						(is['android']&&version.match(/^2\./)?'':'<li><a opc="lib">'+lan('gallery','ucw')+'</a></li>')
					);
				}else{
					$('[data-role="footer"]').remove();
					$('[data-role="content"]').addClass('no-footer');
				}
			},
			after:function(){
				var DATA={},
					$img=$('img#img'),
					$pic=$('img#tmp'),
					$wrapper=$('.pic-wrapper'),
					$send=$('#send'),
					p,//proporsion
					actual,//imagen actual
					img64;//imagen en base64
				//picture box scroller
				var pb=new iScroll('picture-box',{zoom:true,zoomMim:1,zoomMax:5,hScroll:true,vScroll:true,scrollbarClass:'dnone'});
				$(window).bind('orientationchange resize',function(){//define box size
					var woffset=20,
						hoffset=30+$('.ui-page .ui-header').outerHeight()+$('.ui-page .ui-footer').outerHeight(),
						width=(document.width||$('body').width())-woffset,
						height=(document.height||$('body').height())-hoffset,
						size=(width<height)?width:height,
						scale;
					// console.log(document.width, document.height,$('body').width(),$('body').height());
					DATA['bsize']=size;
					scale=size/DATA['bsize'];
					$('#picture-box').width(size).height(size);
					if(DATA['swidth']||DATA['sheight']){
						DATA['swidth']*=scale;
						DATA['sheight']*=scale;
					}
					//console.log('bsize='+DATA['bsize']);
					pb.refresh();
				}).trigger('resize');
				$send.one('show',function(){
					$send.click(send);
				});
				window.scroll=pb;
				$pic.load(function(){
					var width=this.width,height=this.height,img=$(this).attr('src');
					p=width/height;
					if(img.match(/data:image\/\w+;base64,/i)) //window.img64= //for test
						img64=img;//.replace(/data:image\/\w+;base64,/i,'');
					if(typeof actual==='object'){
						actual=null;
					}
					if(actual==img64) img64=null;
					DATA['owidth']=width;
					DATA['oheight']=height;
					if(p>1){
						$img.css({width:'auto',height:'100%'});
					}else{
						$img.css({width:'100%',height:'auto'});
					}
					$img.attr('src',$(this).attr('src'));
					$(this).attr('src','');
					$send.show();
				});
				$img.load(function(){
					DATA['swidth']=this.width;
					DATA['sheight']=this.height;
					$wrapper.css({width:'100%',height:'100%',top:0,left:0});
					//$wrapper.css({width:$(this).width(),height:$(this).height()});
					pb.refresh();
				});
				(function(){//get profile picture
					myAjax({
						url:DOMINIO+'controls/users/people.json.php?action=specific&picture',
						success:function(data){
							if(data['datos'][0]['photo_friend']){
								actual=data['datos'][0]['picture'];
								$pic.attr('src',actual);
								img64=null;
							}
						}
					});
				})();

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
									img64=data;
								}
								$pic.attr('src',data);
								enableResize();
							},
			    			onPhotoFail=function(message){
								console.log(message);
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
				$('#footerPicture a[opc]').click(function(){
					getPhoto($(this).attr('opc'));
				});
				var send=(function(){
					var disabled;
					return function(){
						if(disabled) return;
						disabled=true;
						var pdata={
							action:'picture'
						};
						//extraemos las dimenciones, posicion y escala de la imagen
						DATA['scale']=pb.scale;
						DATA['sx']=pb.x;
						DATA['sy']=pb.y;
						DATA['x']=pb.x/pb.scale;
						DATA['y']=pb.y/pb.scale;
						DATA['oscale']=DATA['swidth']/DATA['owidth'];
						if(DATA['owidth']>600) DATA['oscale']*=DATA['owidth']/600;
						pdata['x']=-DATA['x']/DATA['oscale'];
						pdata['y']=-DATA['y']/DATA['oscale'];
						pdata['size']=DATA['bsize']/DATA['oscale']/pb.scale;
						if(img64) pdata['img64']=img64;
						myAjax({
							url:DOMINIO+'controls/users/profile.json.php',
							data:pdata,
							success:function(data){
								delete pdata.img64;
								// alert(data);
								if(data['upload']==='done'||data['resize']==='done'){
									actual=img64;
									img64=null;
									myDialog({
										// id:'#singleRedirDialog',
										content:lan('Profile picture updated.','ucf'),
										buttons:
										[{
											name: 'ok',
											action: function(){
												this.close();
												setTimeout(function(){redir(PAGE['profile']);},200);
											}
										}]
									});
								}
							},
							complete:function(){
								disabled=false;
							}
						});
					};
				})();
				$send.click(send);
			}//end after
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>

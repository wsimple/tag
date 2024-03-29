<style>
	.upload-panel.tag{
		min-width:500px;
		margin:auto;
	}
	.upload-panel .upload.container > *{
		min-height:50px;
	}
	.upload-menu{
		min-height: 50px;
		width: 100%;
		margin-bottom: 15px;
		padding-top: 10px;
		background-color: rgba(233,233,233,0.2);
		-webkit-box-shadow: inset 1px 1px 0 rgba(233,233,233,0.1),inset 0 -1px 0 rgba(233,233,233,0.07);
	}
	.upload-menu div{
		background: transparent;
		border: none;
		color: #222;
		float: left;
		height: 14px;
		margin: 0 18px;
		padding: 16px 4px 7px;
		cursor:pointer;
	}
	.upload-menu div:hover,
	.upload-menu div.active{
		background: transparent;
		border-bottom: 2px solid #4d90fe;
		border-left: 0;
		border-right: 0;
		border-top: 0;
		color: #262626;
		padding-bottom: 18px;
	}
	div#container-up #fileupload,
	div#container-up #videoList,
	div#container-up #imageList,
	div#container-up #urlUpload{ display: none; }
	.upload-menu div.active{ font-weight: bold; }
	div#container-up.up #fileupload,
	div#container-up.vid #videoList,
	div#container-up.alt #imageList,
	div#container-up.img #urlUpload{ display: block !important; }
	div.upload.container{
/*		width:750px;
		min-height:350px;*/
		margin: 0;
		padding: 0;
		max-height: 370px;
		min-height: 370px;
		overflow: auto;
		/*overflow-y:auto;*/
	}
	.template.download .preview img{
		width:650px;
	}
	.template.upload .video_format{
		position:absolute;
		background-image:url(css/tbum/video.png);
		background-position:center center;
		background-repeat:no-repeat;
		width:100%;
		height:100px;
		margin:auto;
		padding:25px 0;
		z-index:-1;
	}
	.template.upload .video_format span{
		position:relative;
		font-size:2.5em;
		color:#000;
		top:22px;
		left:-17px;
	}
	#loadPreview{	margin-top: 25px; }
	/*#loadPreview div.onPreview{
		border: 1px #e8e8e8 solid;
		height: 180px;
		padding: 2px;
		margin: 2px;
	}*/
	div[tag]:hover .video button{
		position: relative;
		z-index: 1002;
		display: block;
	}
/*	#videoList div.tag-container.video div[tag]:hover .video button,
	#fileupload div.tag-container.video div[tag]:hover .video button{
		position: relative;
		z-index: 1002;
		display: block;
	}
*/
	.upload-panel.tag [role="presentation"]>div{
		display:inline-block;
	}
	.upload-panel.tag [role="presentation"]>*>div{
		position:relative;
		margin:5px;
		text-align:center;
	}
	.upload-panel.tag [role="presentation"] .upload>div{
		float:left;
	}
	.upload-panel.tag [role="presentation"] .upload>div:first-child{ width:300px; }
	.upload-panel.tag [role="presentation"] .upload>div:last-child{	width:150px; }
	.upload-panel.tag [role="presentation"] .upload>div .btn,
	.upload-panel.tag [role="presentation"] .upload>div .progress{
		display:block;
		margin:5px auto;
		width:125px;
	}
	.upload-panel.tag [role="presentation"] .download>div:first-child{
		width:325px;
		height:150px;
		overflow:hidden;
	}
	.upload-panel.tag [role="presentation"] .download.img>div:first-child .tag-container{
		-ms-transform:scale(.5,.5) translate(-50%,-50%);
		-webkit-transform:scale(.5,.5) translate(-50%,-50%);
		transform:scale(.5,.5) translate(-50%,-50%);
	}
	/*.upload-panel.tag [role="presentation"] .download>div:last-child{ width:100px; }*/
	.upload-panel.tag .upload video{
		max-width:300px;
	}
	.displayUpload{
		margin: 50px 0;
		width: 100%;
		height: 200px;
		text-align: center;
	}
/*	.upload-panel.tag [role="presentation"] .download>div:first-child .tag-container.video{
		-moz-border-radius: 0.437em;
		border-radius: 0.437em;
		-webkit-border-radius: 0.437em;
		width: 10.1562em; height: 4.687em;
	}*/
	#loadPreview [tag], 
	.upload-panel .video .tag-container [tag],
	.upload-panel .tag-container [tag] .video{
		-moz-border-radius: 0.437em;
		border-radius: 0.437em;
		-webkit-border-radius: 0.437em;
		width: 10.1562em; height: 4.687em;
	}
	.upload-panel.tag [role="presentation"] .download.video .tag-container [tag] div.video .placa{
		background-size: 100% auto;
		background-position: 0 0;
	}
	.upload-panel.tag [role="presentation"] .download.loader{
		display: block;
		margin: 5px 300px;
	}
	.upload-panel.tag [role="presentation"] .download.loader:after{
		content: "<?=$lang->get('Loading')?>";
		margin: 4px 35px;
		display: inline-block;
	}
	.upload-panel.tag [role="presentation"] .download.img.empty,
	.upload-panel.tag [role="presentation"] .download.video.empty{
		display: block;
		text-align:center;
		margin: 5px auto;
	}
	.upload-panel.tag [role="presentation"] .download.video.empty:after{
		content:"<?=$lang->get('No videos uploaded')?>";
	}
	.upload-panel.tag [role="presentation"] .download.img.empty:after{
		content:"<?=$lang->get('No images uploaded')?>";
	}
	.upload-panel .tag-container [tag] button{ padding: 20px 25px; }
	.displayUpload div[image]{
		background-image: url('css/tbum/file.png');
		background-size: 100%;
		background-position: 50%;
		background-repeat: no-repeat;
		width: 48px;
		height: 60px;
		margin: 0 auto;
	}
	.displayUpload div[text],.displayUpload div[o]{
		color: #aaa;
		font-size: 20px;
		padding: 0 10px;
		margin-bottom: 10px;
	}
	.displayUpload div[text]{ font-size: 30px; }
	.actionButton{ display: none; }
	.tag-container:hover + .actionButton,.actionButton:hover{ display: block; }
	.actionButton button,.actionButton span{
		position: absolute;
		z-index: 1002;
	}
	.download .actionButton .start{
		left: 0;
		-moz-border-top-left-radius: 0.850em;
		border-top-left-radius: 0.850em;
		-webkit-border-top-left-radius: 0.850em;
	}
	.download .actionButton .delete{
		right: 0;
		-moz-border-top-right-radius: 0.850em;
		border-top-right-radius: 0.850em;
		-webkit-border-top-right-radius: 0.850em;
	}
	.upload-panel .download .actionButton{
		position:absolute;
		top:0;
		width:100%;
	}
	div[aria-valuenow]:before{
		font-family:'Lucida Grande',Tahoma,Verdana,Arial,Sans-Serif;
		content:attr(aria-valuenow) '%';
		position:absolute;
		text-align:center;
		font-weight:bold;
		font-size:12px;
		padding:2px;
		width:100%;
		left:0;
	}
</style>
<?php
	if (isset($_GET['video'])){
		$video=$_GET['video'];
		$tipovideo=$_GET['tipo'];
	}else{ $video=''; $tipovideo=''; }
?>
<div class="upload-panel tag">
<div class="upload-menu">
	<div data-container="#fileupload" class="active"><?=$lang->get('Upload file')?></div>
	<div data-container="#videoLink"><?=$lang->get('Youtube/Vimeo')?></div>
	<div data-container="#imageList"><?=$lang->get('My Backgrounds')?></div>
	<div data-container="#videoList"><?=$lang->get('My Videos')?></div>
	<!-- <div data-container="#pendingVideoList"><?=$lang->get('Pending Videos')?></div> -->
</div>
<div class="upload container">
	<form id="fileupload"  method="POST" enctype="multipart/form-data">
		<!-- Redirect browsers with JavaScript disabled to the origin page -->
		<noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<div class="row fileupload-buttonbar dnone">
			<div>
				<!-- The fileinput-button span is used to style the file input field as button -->
				<button class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>
					<span><?=$lang->get('Add files')?>...</span>
					<input type="file" name="files[]" multiple>
				</button>
				<button type="submit" class="btn btn-primary start">
					<i class="glyphicon glyphicon-upload"></i>
					<span><?=$lang->get('Start upload')?></span>
				</button>
				<button type="reset" class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span><?=$lang->get('Cancel upload')?></span>
				</button>
				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
			</div>
			<!-- The global progress state -->


			<div class="fileupload-progress fade dnone">
				<!-- The global progress bar -->
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					<div class="progress-bar progress-bar-success" style="width:0%;"></div>
				</div>
				<!-- The extended global progress state -->
				<div class="progress-extended">&nbsp;</div>
			</div>
		</div>
		<div class="displayUpload">
			<div image></div>
			<div text><?=$lang->get('Drag a file here')?></div>
			<div o>O</div>
			<span class="btn btn-success fileinput-button">
					<span><?=$lang->get('Select a file from your computer')?></span>
					<input type="file" name="files">
			</span>
		</div>
		<!-- The table listing the files available for upload/download -->
		<div role="presentation" class="files"></div>
	</form>
	<div id="videoLink" class="dnone" role="presentation">
		<label style="font-weight: bold;font-size: 13px;"><?=$lang->get('Video Link')?>:</label>&nbsp;&nbsp;
		<input type="text" style="width: 430px" id="txtVideo" placeholder="http://" value="<?=$tipovideo!='local'&&$tipovideo!=''?$video:''?>"/>
		<button class="btn btn-danger delete" style="display:none;"><i class="glyphicon glyphicon-trash"></i></button>
		<div id="loadPreview" class="tag-container" style="width: 100%;height: auto;"></div>
		<div class="dnone files"><div></div></div>
	</div>
	<form id="imageList" class="dnone"  method="POST" enctype="multipart/form-data">
		<!-- The table listing the files available for upload/download -->
		<div role="presentation" class="files">
			<div class="template-download template download tag loader tmp"></div>
		</div>
	</form>
	<form id="videoList" class="dnone"  method="POST" enctype="multipart/form-data">
		<!-- The table listing the files available for upload/download -->
		<div role="presentation" class="files">
			<div class="template-download template download tag loader tmp"></div>
		</div>
	</form>
	<!-- <form id="pendingVideoList" class="dnone" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data"> -->
		<!-- <h3><?=$lang->get('Pending Videos')?></h3> -->
		<!-- <p><?=$lang->get('PENDING_VIDEO_INFO')?><p> -->
		<!-- The table listing the files available for upload/download -->
		<!-- <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table> -->
	<!-- </form> -->
</div>
</div>
<script>
/*jslint unparam: true */
if (!window.players){ window.players=[]; }
/*global window, $ */
$(function(){
	'use strict';
	//menu
	$('.upload-menu>div').click(function(event){
		$(this).parent().children().removeClass('active');
		$(this).addClass('active');
		var $containers=$('.upload.container').children(),
			$container=$containers.filter(this.dataset.container);
		$('.upload.container').children().addClass('dnone');
		if($container.find('.files').children().length) $container.removeClass('dnone');
		else $containers.filter('#fileupload').removeClass('dnone');
		if(this.dataset.container=='#videoLink') $('#txtVideo').focus();
	});

	window.all_supported=/(\.|\/)(jpe?g|gif|png|mp4|m4v|mov|ogv|ogg|3gp|avi|mkv|flv|mpe?g|vob)$/i;
	window.vid_supported=/(\.|\/)(mp4|m4v|mov|ogv|ogg|3gp|avi|mkv|flv|mpe?g|vob)$/i;
	window.img_supported=/(\.|\/)(jpe?g|gif|png)$/i;
	var only_views={dropZone:null},
		video={
			url:'<?=$setting->video_server?>',
			data:{code:'<?=$client->code?>'},
			pending:{code:'<?=$client->code?>',folder:'pending'},
		},
		img={
			url:'<?=$setting->img_server?>',
			data:{code:'<?=$client->code?>',folder:'templates',maxwidth:<?=TAGWIDTHHD?>},
		};
	//File upload form
	$('#fileupload').fileupload({
		<?php //definimos la url antes de hacer submit, ya que manejamos varios servidores ?>
		autoUpload:true,
		beforeSubmit:function(file,options){
			if(file.type.match(img_supported)){
				//servidor de imagenes
				options.url=img.url;
				options.formData=img.data;
			}else{
				//servidor de videos
				options.url=video.url;
				options.formData=video.pending;
			}
			$('.displayUpload div').hide().parents('.displayUpload').css({ margin: '25px 0',height: 'auto' });
		},
		acceptFileTypes:all_supported,
		maxFileSize:150000000,//150MB
		//Uncomment the following to send cross-domain cookies:
		xhrFields: {withCredentials: true}
	}).bind('fileuploadadd',function(e,data){
		$('.error_message',this).remove();
		var $this=$(this),
			that =$this.data('blueimp-fileupload')||$this.data('fileupload');
		that.options.filesContainer.empty();
	}).bind('fileuploadsubmit',function(e,data){
		var $content=$(this).parents('.ui-dialog-content');
		if($content.length){
			$content.dialog('option','closeOnEscape',false).dialog('option','closeOnClickOutside',false);
		}
		$('.displayUpload').hide();
	}).bind('fileuploaddone',function(e,data){
		var json=JSON.parse(data.jqXHR.responseText);
		if(json.files[0].error)
			$('#fileupload').prepend('<div class="error_message" style="width: 455px; margin: 0px auto;display:block;text-align:center;"><img src="imgs/message_error.png" width="12" height="12"> <?=$lang->get("ERRORFILEINFO")?></div>');
		var that=this,$content=$(this).parents('.ui-dialog-content');
		setTimeout(function(){
			if($content.length) $content.dialog('option','closeOnEscape',true).dialog('option','closeOnClickOutside',true);
			$('.video .start,.img [tag]',that).click();
		},1000);
	}).bind('fileuploadalways',function(e,data){
		$('.displayUpload').fadeIn('slow');
	}).bind('fileuploadprocessfail',function(e,data){
		$('#fileupload').prepend('<div class="error_message" style="width: 455px; margin: 0px auto;display:block;text-align:center;"><img src="imgs/message_error.png" width="12" height="12"> <?=$lang->get("ERRORFILEINFO")?></div>');
		var $this=$(this),
			that =$this.data('blueimp-fileupload')||$this.data('fileupload');
		that.options.filesContainer.empty();
	});

	//lista de imagenes
	$.ajax({
		context:$('#imageList').last().fileupload(only_views),
		url:img.url,
		//Uncomment the following to send cross-domain cookies:
		xhrFields:{withCredentials:true},
		dataType:'json',
		data:img.data
	}).always(function(){
		$(this).removeClass('fileupload-processing');
		$('.files .tmp',this).remove();
		if($('.files',this).children().length==0)
			$('#preVideTags .option-cap').first().click();
	}).done(function(result){
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
	//lista de videos
	$.ajax({
		context:$('#videoList').last().fileupload(only_views),
		url:video.url,
		//Uncomment the following to send cross-domain cookies:
		xhrFields:{withCredentials:true},
		dataType:'json',
		data:video.data
	}).always(function(){
		$(this).removeClass('fileupload-processing');
		$('.files .tmp',this).remove();
		if($('.files',this).children().length==0)
			$('#preVideTags .option-cap').first().click();
	}).done(function(result){
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
	$(document).off('.fileupload').on('dragover.fileupload',function(){
		if($('#fileupload').length>0){
			$('[data-container="#fileupload"]').click();
		}else{
			$(document).off('.fileupload');
		}
	});

	var cv_running=false;
	var convert_video=function(obj){
		$.debug().log('convert_video:',obj);
		if(!window.video_convert_tmpl) window.video_convert_tmpl=tmpl('template-conversion');
		if(cv_running||!obj.content) return;
		$(obj.content).html(video_convert_tmpl({state:'waiting'}));
		cv_running=true;
		$.ajax({
			disablebuttons:true,
			url:"<?=$setting->local?'video/test/1':$setting->video_server.'?convert'?>",
			dataType:'json',
			type:'post',
			xhrFields:{withCredentials:true},
			data:{code:obj.code,file:obj.file},
			success:function(data){
				$.debug().log('convertion data:',data);
				if(!data.error){
					var video=htmlVideo(SERVERS.video+'videos/'+data.video,'local',null,true);
					if(video){
						$(obj.content).html(video_convert_tmpl({
							state:'done',
							path:'<?=$setting->video_server?>videos/',
							captures:data.captures
						})).find('[tag]').html(video);
						if($('#bckSelected')[0].style.backgroundImage=='')
							$('.option-cap',obj.content).first().click();
						if(obj.success)
							obj.success.call(obj.content,{video:data.video||'',captures:data.captures});
					}
				}else
					$(obj.content).html(video_convert_tmpl({state:'error',isupload:true})).find('.retry').one('click',function(){
						convert_video(obj);
					});
			},
			error:function(){
				$(obj.content).html(video_convert_tmpl({state:'error',isupload:true})).find('.retry').one('click',function(){
					convert_video(obj);
				});
			},
			complete:function(a,b){
				cv_running=false;
				if(obj.complete) obj.complete.call(this,a,b);
			}
		});
	}
	$('.upload-panel [role="presentation"]').off('.videostart').on('click.videostart','.video .start',function(){
		var video=$('#htxtVideo')[0],is_upload=$(this).parents('#fileupload').length,that=this,data,ajax=false,actionDialog=true;
		$(that).prop('disabled',true);
		setTimeout(function(){
			$(that).prop('disabled',false);
		},2000);
		$.debug().log(is_upload?'new video':'my videos');
		if(is_upload){
			ajax=true;
			convert_video({
				content:$('#preVideTags')[0],
				code:that.dataset.code,
				file:that.dataset.name,
				capture:function(data){
					if($('#bckSelected').css('background-image')=='')
						$('.option-cap',this).first().click();
				},
				success:function(data){
					video.value=data.video;
				},
				complete:function(){
					$(that).prop('disabled',false);
				}
			});
		}else{
			var pre=''; 
			if (that.dataset.type=='youtube' || that.dataset.type=='vimeo'){
				console.log('here');
				if(video) video.value=that.dataset.set;
				actionDialog=false;
				pre=that.dataset.pre;
			}else{
				pre=that.dataset.url;
				if(video) video.value=that.dataset.code+'/'+that.dataset.name;
				$(video).change();
			}
			var html=htmlVideo(pre,that.dataset.type,null,true);
			if (html!='') $('#preVideTags').html('<div class="tag-container" style="width:auto;font-size: 100%;"><div tag="pre">'+html+'</div></div>');
			iniallYoutube();
		}
		if (actionDialog){
			var $dialog=$('.ui-dialog-content');
			if($dialog.length){
				$('.upload-panel [role="presentation"]').off('.videostart');
				$dialog.dialog('close');
			}else if(!ajax){
				setTimeout(function(){
					$(that).prop('disabled',false);
				},2000);
			}
		}
	});
	/****** select background ******/
	$('#imageList').on('click','.bg-select',function(){
		if(window.setBG){
			setBG(this.dataset.code+'/'+this.dataset.name);
			var $dialog=$(this).parents('.ui-dialog-content');
			if($dialog.length) $dialog.dialog('close');
		}
	});
	$('#fileupload').on('click','.bg-select',function(){
		if(window.setBG){
			setBG(this.dataset.code+'/'+this.dataset.name);
			var $dialog=$(this).parents('.ui-dialog-content');
			if($dialog.length) $dialog.dialog('close');
		}
	});

	/*******************************        YOUTUBE AND VIMEO             *******************************/
	var videos=[];
	$('#txtVideo').click(function(){
		this.selectionStart=0;
	}).keypress(function(event){
		if (event.keyCode==13) $(this).blur();
	}).change(function(event){
		$(this).blur();
	}).on('blur',function(){
		var that=this,URL=that.value,htmlv='';
		if (URL!='' && URL!='http://'){
		// if (videos.length<1 && URL!='' && URL!='http://'){
			$.ajax({
				url:'video/validate/1',
				type:'POST',
				dataType:'json',
				data:{thisvideo:URL},
				success:function(data){
					if (data['success']){
						var vid=false,band=true,text1='<?=$lang->get("Upload a new background")?>',text2='<?=$lang->get("Use previous backgrounds")?>';
						for (var i=0; i<videos.length;i++) if (videos[i]==data['urlV']) band=false;
						if (band){
							htmlv=htmlVideo(data['urlV'],data['type'],URL)
							$('#loadPreview').html('<div tag="'+0+'" style="margin: 20px auto;">'+htmlv+'</div>');
							videos[0]=data['urlV'];
							// if (data['type']=='youtube') iniallYoutube();
							htmlv='<div><button id="uploadNewBackgrond" class="btn btn-success fleft">'+text1+'</button><button id="selectMyBackgrond" class="btn btn-success fright">'+text2+'</button></div>';
							$('#loadPreview').append(htmlv).find('div[tag] .video .start').click();
							$('#videoLink .delete').show().removeAttr('disabled');
						}
					}
				}
			});
		}
	});
	$('#videoLink .delete').click(function(){
		var id=$('#loadPreview').find('div[tag]').attr('tag')*1;
		videos.splice(id,1);
		$('#loadPreview').empty().html('');
		// $(this).parents('div[tag]').hide().remove()
		$(this).prev('input[type="text"]').val('');
		$(this).hide();
		var video=$('#htxtVideo')[0];
		if(video){
			video.value='';
			$('#preVideTags').empty().html('');
		}
	});
	$('#loadPreview').on('click','#uploadNewBackgrond',function(){
		$('.upload-menu [data-container="#fileupload"]').click();
	}).on('click','#selectMyBackgrond',function(){
		$('.upload-menu [data-container="#imageList"]').click();
	});
	var existvideo='<?=$video?>',tipovideo='<?=$tipovideo?>';
	if (existvideo!=''){
		if (tipovideo!='' && tipovideo!='local'){
			$('.upload-menu [data-container="#videoLink"]').click();
			$('#txtVideo').blur();
		}else if(tipovideo!='' && tipovideo=='local')
			$('.upload-menu [data-container="#videoList"]').click();
	}
	/*******************************      END YOUTUBE AND VIMEO             *******************************/
});
</script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for(var i=0,file;file=o.files[i];i++){ %}
	<div class="template-upload template upload fade">
		<div>
			{% if(!file.type.match(window.img_supported)){ %}
				<div class="video_format"><span>{%=file.name.split('.').pop()%}</span></div>
			{% } %}
			<span class="preview"></span>
			<strong class="error text-danger"></strong>
		</div>
		<div>
			{% if(!i&&o.options&&!o.options.autoUpload){ %}
				<button class="btn btn-primary start" disabled>
					<i class="glyphicon glyphicon-upload"></i>
					<span><?=$lang->get('Start')?></span>
				</button>
			{% } %}
			{% if(!i){ %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span><?=$lang->get('Cancel')?></span>
				</button>
			{% } %}
			<p class="size">Processing...</p>
			<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		</div>
	</div>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{%
o.get=function(name){
	if(name.match(window.img_supported)){
		return '&code=<?=$client->code?>&folder=templates';
	}else{
		return '&code=<?=$client->code?>';
	}
};
if(!o.files||!o.files.length){ %}
	<div class="template-download template download {%=file.type%} empty"></div>
{% }else for(var i=0,file;file=o.files[i];i++){
	file.type=file.name.match(window.img_supported)?'img':(
		file.name.match(window.vid_supported)?'video':''
	);
	if(file.type!=''){
%}
	<div class="template-download template download {%=file.type%} fade">
		<div>
			{% if(file.type=='img'){ %}
				<div class="tag-container img noMenu" style="height: auto;">
					<div class="template" style="background-image:url({%=file.url%})"></div>
					<div tag class="bg-select" data-url="{%=file.url%}" data-name="{%=file.name%}" data-code="<?=$client->code?>"></div>
				</div>
			{% }else if(file.type=='video'){ %}
				<div class="tag-container video noMenu" style="width: auto;height: auto;">
					<div tag>
						<div class="video" style="z-index: 1001;">
							<div class="placa"></div>
							<video controls="controls">
								<source src="{%=file.url%}" type="video/mp4" />
								<source src="{%=file.url.replace(/\.mp4$/i,'.ogg')%}" type="video/ogg" />
							</video>
						</div>
					</div>
				</div>
			{% } %}
			<div class="actionButton">
				{% if(file.type=='video'){ %}
				<button class="btn btn-primary start" data-type="local" data-url="{%=file.url%}" data-name="{%=file.name%}" data-code="<?=$client->code?>"><i class="glyphicon glyphicon-upload"></i></button>
				{% } if(file.deleteUrl){ %}
				<span class="btn btn-danger delete" data-type="{%=file.deleteType%}"
					{% if(file.deleteWithCredentials){ %}data-xhr-fields='{"withCredentials":true}'{% } %}
					data-url="{%=file.deleteUrl+o.get(file.name)%}">
					<i class="glyphicon glyphicon-trash"></i>
					<span><?=''//$lang->get('Delete')?></span>
				</span>
				{% } %}
			</div>
			<strong class="error text-danger"></strong>
			{% if(file.error){ %}
				<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
		</div>
	</div>
{%
	}
}
%}
</script>

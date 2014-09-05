<link rel="stylesheet" href="css/fileupload/style.css">
<link rel="stylesheet" href="css/fileupload/jquery.fileupload.css">
<link rel="stylesheet" href="css/fileupload/jquery.fileupload-ui.css">
<style>
	.upload-panel{
		width:750px;
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
		width:750px;
		height:350px;
		margin: 0; 
		padding: 0;
		/*overflow-y:auto;*/
	}
	.col-lg-7{
		width:100%;
	}
	.template-download .preview img{
		width:300px;
	}
	#loadPreview{
		border-color: #e9e9e9 #e9eaed #d1d1d1;
		width: 100%;
	}
	#loadPreview div.onPreview{
		border: 1px #e8e8e8 solid;
		height: 180px;
		padding: 2px;
		margin: 2px;
	}
	#loadPreview div.onPreview .video{
		float: left;
		height: 180px;
		overflow: hidden;
		width: 46%;
		background-color: black;
	}
</style>
<div class="upload-panel">
<div class="upload-menu">
	<div data-container="#fileupload" class="active"><?=$lang->get('Upload file')?></div>
	<div data-container="#videoLink"><?=$lang->get('Youtube/Vimeo Videos')?></div>
	<div data-container="#imageList"><?=$lang->get('Backgrounds')?></div>
	<div data-container="#videoList"><?=$lang->get('Videos')?></div>
	<div data-container="#pendingVideoList"><?=$lang->get('Pending Videos')?></div>
</div>
<div class="upload container">
	<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<!-- Redirect browsers with JavaScript disabled to the origin page -->
		<noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<div class="row fileupload-buttonbar">
			<div class="col-lg-7">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>
					<span><?=$lang->get('Add files')?>...</span>
					<input type="file" name="files[]" multiple>
				</span>
				<button type="submit" class="btn btn-primary start">
					<i class="glyphicon glyphicon-upload"></i>
					<span><?=$lang->get('Start upload')?></span>
				</button>
				<button type="reset" class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span><?=$lang->get('Cancel upload')?></span>
				</button>
				<button type="button" class="btn btn-danger delete">
					<i class="glyphicon glyphicon-trash"></i>
					<span><?=$lang->get('Delete')?></span>
				</button>
				<input type="checkbox" class="toggle">
				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
			</div>
			<!-- The global progress state -->
			<div class="col-lg-5 fileupload-progress fade">
				<!-- The global progress bar -->
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					<div class="progress-bar progress-bar-success" style="width:0%;"></div>
				</div>
				<!-- The extended global progress state -->
				<div class="progress-extended">&nbsp;</div>
			</div>
		</div>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<div id="videoLink" class="dnone">
		<div id="videosTag">
			<label><?=$lang->get('Video Link')?>:</label>&nbsp;&nbsp;
			<input type="text" name="txtVideo" style="width: 600px" id="txtVideo" class="tag-text" tipo="video" value="<?=$tag['video_url']?$tag['video_url']:'http://'?>" placeholder="http://"<?php if($lang->get('NEWTAG_LBLVIDEO_TITLE')!=""){?> title="<?=$lang->get('NEWTAG_LBLVIDEO_TITLE')?>" <?php }else{}?>/>
			<div id="loadPreview"></div>

			<!-- <div id="vimeo"> -->
				<!-- <div id="running" class="warning-box dnone"><?=$lang->get('VIMEO_PREMIUM_VERIFY')?><span class="loader"></span></div> -->
				<!-- <div id="success" class="warning-box dnone"><?=$lang->get('VIMEO_PREMIUM_SUCCESS')?></div> -->
				<!-- <div id="error" class="error-box dnone"><?=$lang->get('VIMEO_PREMIUM_DAMAGED')?></div> -->
			<!-- </div> -->
		</div>
	</div>
	<form id="imageList" class="dnone" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<h3>Images</h3>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<form id="videoList" class="dnone" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<h3>Videos</h3>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<form id="pendingVideoList" class="dnone" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<h3><?=$lang->get('Pending Videos')?></h3>
		<p><?=$lang->get('PENDING_VIDEO_INFO')?><p>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
</div>
</div>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/fileupload/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/fileupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/fileupload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/fileupload/jquery.fileupload-process.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/fileupload/jquery.fileupload-image.js"></script>
<script src="js/fileupload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/fileupload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/fileupload/jquery.fileupload-ui.js"></script>
<script>
/*jslint unparam: true */
/*global window, $ */
$(function(){
	'use strict';
	//menu
	$('.upload-menu>div').click(function(event){
		$(this).parent().children().removeClass('active');
		$(this).addClass('active');
		$('.upload.container').children().addClass('dnone')
		.filter(this.dataset.container).removeClass('dnone');
	});

	var all_supported=/(\.|\/)(jpe?g|gif|png|mp4|flv|3gp|mov|ogg)$/i,
		img_supported=/(\.|\/)(jpe?g|gif|png)$/i,
		video={
			url:'<?=$setting->video_server_path?>',
			data:{code:'<?=$client->code?>'},
			pending:{code:'<?=$client->code?>',folder:'pending'},
		},
		img={
			url:'<?=$setting->img_server_path?>',
			data:{code:'<?=$client->code?>',folder:'templates'},
		};
	//File upload form
	$('#fileupload').fileupload({
		<?php //definimos la url antes de hacer submit, ya que manejamos varios servidores ?>
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
		},
		acceptFileTypes:all_supported,
		maxFileSize:15000000,//15MB
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
	});
	$('#txtVideo').click(function(){
		this.selectionStart=0;
	});
	$('#txtVideo').on('blur',function(){
		var that=this,URL=that.value;
		console.log(URL);
		if (URL!='' && URL!='http://'){
			$.ajax({
				url:'video/validate/1',
				type:'POST',
				dataType:'json',
				data:{thisvideo:URL},
				success:function(data){
					if (data['success']){
						var vid=false;
						switch(data['type']){
							case 'youtube': 
								vid='v'+Math.random();
								video='<div id="'+vid+'" width="319" height="180" data-src="'+data['urlV']+'" class="ytplayer"></div>';
							break;
							case 'vimeo': video='<iframe src="'+data['urlV']+'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'; break;
						}					
						$('#loadPreview').append('<div class="onPreview"><div class="video">'+video+'</div></div>');
						if (vid) iniallYoutube();
					}
				},
				complete:function(){
				
				}
			});
		}
	});
	//lista de imagenes
	$.ajax({
		context:$('#imageList').first().fileupload(),
		url:img.url,
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		dataType:'json',
		data:img.data
	}).always(function(){
		$(this).removeClass('fileupload-processing');
	}).done(function(result){
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
	//lista de videos
	$.ajax({
		context:$('#videoList').first().fileupload(),
		url:video.url,
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		dataType:'json',
		data:video.data
	}).always(function(){
		$(this).removeClass('fileupload-processing');
	}).done(function(result){
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
	//lista de videos pendientes
	$.ajax({
		context:$('#pendingVideoList').first().fileupload(),
		url:video.url,
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		dataType:'json',
		data:video.pending
	}).always(function(){
		$(this).removeClass('fileupload-processing');
	}).done(function(result){
		console.log('pendig videos:',result);
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
});
</script>
<!-- Teplates -->
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% console.log(o.files); %}
{% for(var i=0,file;file=o.files[i];i++){ %}
	<tr class="template-upload fade">
		<td style="width:50%;">
			<span class="preview"></span>
			<strong class="error text-danger"></strong>
		</td>
		<td>
			<p class="size">Processing...</p>
			<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		</td>
		<td style="width:25%;">
			{% if (!i && !o.options.autoUpload) { %}
				<button class="btn btn-primary start" disabled>
					<i class="glyphicon glyphicon-upload"></i>
					<span><?=$lang->get('Start')?></span>
				</button>
			{% } %}
			{% if (!i) { %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span><?=$lang->get('Cancel')?></span>
				</button>
			{% } %}
		</td>
	</tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% o.get=function(name){
	if(name.match(/(\.|\/)(jpe?g|gif|png)$/i)){
		return '&code=<?=$client->code?>&folder=templates';
	}else{
		return '&code=<?=$client->code?>';
	}
}; %}
{% for(var i=0,file;file=o.files[i];i++){ %}
	<tr class="template-download fade">
		<td style="width:50%;">
			<span class="preview" action="tag-template" data-url="{%=file.url%}" data-thumb="{%=file.thumbnailUrl%}">
				{% if(file.thumbnailUrl){ %}
					<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.url%}"></a>
				{% }else if(file.url.match(/\.mp4$/i)){ %}
					<video src="{%=file.url%}" controls></video>
				{% } %}
			<strong class="error text-danger"></strong>
			</span>
			{% if(file.error){ %}
				<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
		</td>
		<td style="width:25%;">
			<span class="size"></span>
		</td>
		<td>
			{% if(file.deleteUrl){ %}
				<button class="btn btn-danger delete" data-type="{%=file.deleteType%}"
					{% if(file.deleteWithCredentials){ %} data-xhr-fields='{"withCredentials":true}'{% } %}
					data-url="{%=file.deleteUrl+o.get(file.name)%}">
					<i class="glyphicon glyphicon-trash"></i>
					<span><?=$lang->get('Delete')?></span>
				</button>
				<input type="checkbox" name="delete" value="1" class="toggle">
			{% }else{ %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span><?=$lang->get('Cancel')?></span>
				</button>
			{% } %}
		</td>
	</tr>
{% } %}
</script>

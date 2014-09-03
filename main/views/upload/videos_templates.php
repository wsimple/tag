<link rel="stylesheet" href="css/fileupload/style.css">
<link rel="stylesheet" href="css/fileupload/jquery.fileupload.css">
<link rel="stylesheet" href="css/fileupload/jquery.fileupload-ui.css">
<div class="container">
	<!-- The file upload form used as target for the file upload widget -->
	<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<!-- Redirect browsers with JavaScript disabled to the origin page -->
		<noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<div class="row fileupload-buttonbar">
			<div class="col-lg-7">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>
					<span>Add files...</span>
					<input type="file" name="files[]" multiple>
				</span>
				<button type="submit" class="btn btn-primary start">
					<i class="glyphicon glyphicon-upload"></i>
					<span>Start upload</span>
				</button>
				<button type="reset" class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel upload</span>
				</button>
				<button type="button" class="btn btn-danger delete">
					<i class="glyphicon glyphicon-trash"></i>
					<span>Delete</span>
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
	<!-- The file upload form used as target for the file upload widget -->
	<form id="videoList" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<h3>Videos</h3>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<form id="imageList" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
		<h3>Images</h3>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<br>
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

	var all_supported=/(\.|\/)(jpe?g|gif|png|mp4|flv|3gp|mov|ogg)$/i,
		img_supported=/(\.|\/)(jpe?g|gif|png)$/i,
		video={
			url:'<?=$setting->video_server_path?>',
			data:{code:'<?=$client->code?>'},
		},
		img={
			url:'<?=$setting->img_server_path?>',
			data:{code:'<?=$client->code?>',folder:'templates'},
		};
	//Initialize the jQuery File Upload widget:
	$('#fileupload').fileupload({
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		<?php //definimos la url antes de hacer submit, ya que manejamos varios servidores ?>
		beforeSubmit:function(file,options){
			if(file.type.match(img_supported)){
				//servidor de imagenes
				options.url=img.url;
				options.formData=img.data;
			}else{
				//servidor de videos
				options.url=video.url;
				options.formData=video.data;
			}
		},
		acceptFileTypes:all_supported,
		maxFileSize:15000000,//15MB
	});
	// $('#fileuploadVideos').fileupload('option','url',url);
	// console.log($('#fileuploadVideos').fileupload('option'));
	//Load existing files:
	// $('#fileupload').addClass('fileupload-processing');
	//lista de videos
	$('#videoList').fileupload();
	$.ajax({
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url:video.url,
		dataType:'json',
		data:video.data,
		context:$('#videoList')[0]
	}).always(function(){
		$(this).removeClass('fileupload-processing');
	}).done(function(result){
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
	//lista de videos
	$('#imageList').fileupload();
	$.ajax({
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url:img.url,
		dataType:'json',
		data:img.data,
		context:$('#imageList')[0]
	}).always(function(){
		$(this).removeClass('fileupload-processing');
	}).done(function(result){
		$(this).fileupload('option','done')
			.call(this,$.Event('done'),{result:result});
	});
});
</script>
<!-- Teplates -->
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-upload fade">
		<td>
			<span class="preview"></span>
		</td>
		<td>
			<p class="name">{%=file.name%}</p>
			<strong class="error text-danger"></strong>
		</td>
		<td>
			<p class="size">Processing...</p>
			<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		</td>
		<td>
			{% if (!i && !o.options.autoUpload) { %}
				<button class="btn btn-primary start" disabled>
					<i class="glyphicon glyphicon-upload"></i>
					<span>Start</span>
				</button>
			{% } %}
			{% if (!i) { %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel</span>
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
{% for(var i=0,file; file=o.files[i]; i++){ %}
	<tr class="template-download fade">
		<td>
			<span class="preview">
				{% if(file.thumbnailUrl){ %}
					<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
				{% } %}
			</span>
		</td>
		<td>
			<p class="name">
				{% if(file.url){ %}
					<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
				{% }else{ %}
					<span>{%=file.name%}</span>
				{% } %}
			</p>
			{% if(file.error){ %}
				<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
		</td>
		<td>
			<span class="size">{%=o.formatFileSize(file.size)%}</span>
		</td>
		<td>
			{% if(file.deleteUrl){ %}
				<button class="btn btn-danger delete" data-type="{%=file.deleteType%}"
					{% if(file.deleteWithCredentials){ %} data-xhr-fields='{"withCredentials":true}'{% } %}
					data-url="{%=file.deleteUrl+o.get(file.name)%}">
					<i class="glyphicon glyphicon-trash"></i>
					<span>Delete</span>
				</button>
				<input type="checkbox" name="delete" value="1" class="toggle">
			{% }else{ %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel</span>
				</button>
			{% } %}
		</td>
	</tr>
{% } %}
</script>

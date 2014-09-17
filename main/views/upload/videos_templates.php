<style>
	.upload-panel.tag{
		min-width:500px;
		margin:auto;
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
	.template-download .preview img{
		width:650px;
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
*/	.upload-panel.tag .table[role="presentation"] td.download>div,
	.upload-panel.tag .table[role="presentation"] td.upload>div{
		float:left;
		margin:5px;
		text-align:center;
	}
	.upload-panel.tag .table[role="presentation"] td.upload>div:first-child{ width:300px; }
	.upload-panel.tag .table[role="presentation"] td.upload>div:last-child{	width:150px; }
	.upload-panel.tag .table[role="presentation"] td.upload>div .btn,
	.upload-panel.tag .table[role="presentation"] td.upload>div .progress{
		display:block;
		margin:5px auto;
		width:125px;
	}
	.upload-panel.tag .table[role="presentation"] td.download>div:first-child{
		width:325px;
		height:150px;
		overflow:hidden;
	}
	.upload-panel.tag .table[role="presentation"] td.download>div:first-child .tag-container.img{
		-ms-transform:scale(.5,.5) translate(-50%,-50%);
		-webkit-transform:scale(.5,.5) translate(-50%,-50%);
		transform:scale(.5,.5) translate(-50%,-50%);
	}
	/*.upload-panel.tag .table[role="presentation"] td.download>div:last-child{ width:100px; }*/
	.upload-panel.tag td.upload video{
		max-width:300px;
	}
	.btn.btn-success{ background-color:#77c574; }
	.btn.btn-success:hover{ background-color:#55a352; }
	.btn.btn-primary{ background-color:#8286c2; }
	.btn.btn-primary:hover{ background-color:#6064a0; }
	.btn.btn-warning{ background-color:#f82; }
	.btn.btn-warning:hover{ background-color:#d60; }
	.btn.btn-danger{ background-color:#f32; }
	.btn.btn-danger:hover{ background-color:#d10; }
	.displayUpload{
		margin: 50px 0;
		width: 100%;
		height: 200px;
		text-align: center;
	}
/*	.upload-panel.tag .table[role="presentation"] td.download>div:first-child .tag-container.video{
		-moz-border-radius: 0.437em;
		border-radius: 0.437em;
		-webkit-border-radius: 0.437em;
		width: 10.1562em; height: 4.687em; 
	}*/
	#videoLink .tag-container [tag],
	#fileupload .tag-container.video [tag],
	#videoList .tag-container.video [tag],
	#videoLink .tag-container [tag] .video,
	#videoList .tag-container.video [tag] .video,
	#fileupload .tag-container.video [tag] .video{
		-moz-border-radius: 0.437em;
		border-radius: 0.437em;
		-webkit-border-radius: 0.437em;
		width: 10.1562em; height: 4.687em; 
	}
	#videoLink .tag-container [tag] button,
	#fileupload .tag-container [tag] button,
	#videoList .tag-container [tag] button{ padding: 20px 25px; }
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
	.actionButton button{
		position: relative;
		z-index: 1002;
	}
	.download.video .actionButton button{ top: -160px; }
	.download.img .actionButton button{ 
		top: -310px;
		left: 137px;
	 }
	.download.video .actionButton button.start{ left: -109px; }
	.download.video .actionButton button.delete{ left: 108px; }
	.actionButton button.start{
		-moz-border-top-left-radius: 0.850em;
		border-top-left-radius: 0.850em;
		-webkit-border-top-left-radius: 0.850em; 
	}
	.actionButton button.delete{
		-moz-border-top-right-radius: 0.850em;
		border-top-right-radius: 0.850em;
		-webkit-border-top-right-radius: 0.850em;
	}
	#imageList table.table tbody tr,
	#videoList table.table tbody tr{ float: left;}
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
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<div id="videoLink" class="dnone">
		<label style="font-weight: bold;font-size: 13px;"><?=$lang->get('Video Link')?>:</label>&nbsp;&nbsp;
		<input type="text" style="width: 430px" id="txtVideo" placeholder="http://" value="<?=$tipovideo!='local'&&$tipovideo!=''?$video:''?>"/>
		<button class="btn btn-danger delete" style="display:none;"><i class="glyphicon glyphicon-trash"></i></button>
		<div id="loadPreview" class="tag-container" style="width: auto;height: auto;"></div>
	</div>
	<form id="imageList" class="dnone"  method="POST" enctype="multipart/form-data">
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
	<form id="videoList" class="dnone"  method="POST" enctype="multipart/form-data">
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
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
function des(objet){
	if ($(objet).attr('raction')) $(objet).attr('action',$(objet).attr('raction')).removeAttr('raction');
	$(objet).removeProp('disabled').removeAttr('onclick').addClass('invisible');
	$('#videoLink').append(objet+'').find('button.start').click();
	$(objet).remove();
}
/*global window, $ */
$(function(){
	'use strict';
	//menu	
	$('.upload-menu>div').click(function(event){
		$(this).parent().children().removeClass('active');
		$(this).addClass('active');
		$('.upload.container').children().addClass('dnone')
		.filter(this.dataset.container).removeClass('dnone');
		if (this.dataset.container=='#videoLink') $('#txtVideo').focus();
	});

	var all_supported=/(\.|\/)(jpe?g|gif|png|mp4|flv|3gp|mov|ogg)$/i,
		img_supported=/(\.|\/)(jpe?g|gif|png)$/i,
		only_views={dropZone:null},
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
		maxFileSize:15000000,//15MB
		//Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
	}).bind('fileuploadadd',function(e,data){
		$('.error_message',this).remove();
		var $this=$(this),
			that =$this.data('blueimp-fileupload')||$this.data('fileupload');
		that.options.filesContainer.empty();
	}).bind('fileuploadsubmit',function(e,data){
		$('.displayUpload').hide();
	}).bind('fileuploaddone',function(e,data){
		var Utype=data.files[0].type.split('/');
		if (Utype[0]=='video'){ 
			setTimeout(function(){
				var v=$('form#fileupload table [action]')[0];
				if (v){ $(v).attr('raction',$(v).attr('action')+',1').removeAttr('action').click(); }
			}, 1000);
		}else if (Utype[0]=='image'){
			setTimeout(function(){
				$('form#fileupload [action]').click();
			}, 1000);
		}
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
		context:$('#imageList').first().fileupload(only_views),
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
		context:$('#videoList').first().fileupload(only_views),
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
	$(document).off('.fileupload').on('dragover.fileupload',function(){
		if($('#fileupload').length>0){
			$('[data-container="#fileupload"]').click();
		}else{
			$(this).off('.fileupload');
		}
	});


	/*******************************        YOUTUBE AND VIMEO             *******************************/
	var videos=[];
	$('#txtVideo').click(function(){
		this.selectionStart=0;
	}).keypress(function(event) {
		if (event.keyCode==13) $(this).blur();	
	}).change(function(event) {
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
							htmlv='<div><button id="uploadNewBackgrond" class="btn btn-success" style="float:left;">'+text1+'</button><button id="selectMyBackgrond" class="btn btn-success" style="float:right;">'+text2+'</button></div>';
							$('#loadPreview').append(htmlv).find('div[tag] .video button.start').click();
							$('#videoLink button.delete').show().removeAttr('disabled');
						}
					}
				}
			});
		}
	});
	$('#videoLink button.delete').click(function(){
		var id=$('#loadPreview').find('div[tag]').attr('tag')*1;
		videos.splice(id,1);
		$('#loadPreview').empty().html('');
		// $(this).parents('div[tag]').hide().remove()
		$(this).prev('input[type="text"]').val('');
		$(this).hide();
		var video=$('#htxtVideo')[0];
		if(video){
			video.value=''
			$('#preVideTags').empty().html('');
		}
	});
	$('#loadPreview').on('click','#uploadNewBackgrond',function(){
		$('div.upload-menu div[data-container="#fileupload"]').click();
	}).on('click','#selectMyBackgrond',function(){
		$('div.upload-menu div[data-container="#imageList"]').click();
	});
	var existvideo='<?=$video?>',tipovideo='<?=$tipovideo?>';
	if (existvideo!=''){
		if (tipovideo!='' && tipovideo!='local'){
			$('div.upload-menu div[data-container="#videoLink"]').click();
			$('#txtVideo').blur();
		}else if(tipovideo!='' && tipovideo=='local')
			$('div.upload-menu div[data-container="#videoList"]').click();
	}
	/*******************************      END YOUTUBE AND VIMEO             *******************************/
});
</script>
<!-- Teplates -->
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% console.log(o.files); %}
{% for(var i=0,file;file=o.files[i];i++){ %}
	<tr class="template-upload fade">
		<td class="upload">
			<div>
				<span class="preview"></span>
				<strong class="error text-danger"></strong>
			</div>
			<div>
				{% if(!i&&!o.options.autoUpload){ %}
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
{%
for(var i=0,file;file=o.files[i];i++){
	file.type=file.url.match(/(\.|\/)(jpe?g|gif|png)$/i)?'img':(file.url.match(/\.mp4$/i)?'video':'');
	if(file.type!=''){
%}
	<tr class="template-download fade">
		<td class="download {%=file.type%}">
			<div>
				<!--span class="preview" data-thumb="{%=file.thumbnailUrl%}"-->
					{% if(file.type=='img'){ %}
						<div class="tag-container img noMenu" style="height: auto;">
							<div class="template" style="background-image:url({%=file.url%})"></div>
							<div tag action="tag/bgselect" data-url="{%=file.url%}"></div>
						</div>
					{% }else if(file.type=='video'){ %}
						<div class="tag-container video noMenu" style="width: auto;height: auto;">
							<div tag>
								<div class="video" style="z-index: 1001;">
									<div class="placa"></div>
									<video controls="controls"><source src="{%=file.url%}" type="video/mp4" /></video>
								</div>
							</div>
						</div>
					{% } %}
				<div class="actionButton">
					{% if(file.type=='video'){ %}
					<button action="tag/videoSelect,1" class="btn btn-primary start" onclick="des(this);"  data-set="{%=file.url.split('<?=$setting->video_server_path?>videos/')[1]%}" data-type="local" data-pre="{%=file.url%}" ><i class="glyphicon glyphicon-upload" ></i></button>
					{% } if(file.deleteUrl){ %}
					<button class="btn btn-danger delete" data-type="{%=file.deleteType%}"
						{% if(file.deleteWithCredentials){ %} data-xhr-fields='{"withCredentials":true}'{% } %}
						data-url="{%=file.deleteUrl+o.get(file.name)%}">
						<i class="glyphicon glyphicon-trash"></i>
						<span><?=''//$lang->get('Delete')?></span>
					</button>
					{% } %}					
				</div>
				<strong class="error text-danger"></strong>
				<!--/span-->
				{% if(file.error){ %}
					<div><span class="label label-danger">Error</span> {%=file.error%}</div>
				{% } %}
			</div>
			<div>
				{% if(file.deleteUrl){ %}
					<!--button class="btn btn-danger delete" data-type="{%=file.deleteType%}"
						{% if(file.deleteWithCredentials){ %} data-xhr-fields='{"withCredentials":true}'{% } %}
						data-url="{%=file.deleteUrl+o.get(file.name)%}"-->
						<!--i class="glyphicon glyphicon-trash"></i-->
						<!--span><?=''//$lang->get('Delete')?></span-->
					<!--/button-->
				{% }else{ %}
					<button class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span><?=$lang->get('Cancel')?></span>
					</button>
				{% } %}
			</div>
		</td>
	</tr>
{%
	}
}
%}
</script>

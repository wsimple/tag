<link rel="stylesheet" href="css/fileupload/style.css">
<link rel="stylesheet" href="css/fileupload/jquery.fileupload.css">
<link rel="stylesheet" href="css/fileupload/jquery.fileupload-ui.css">
<?php
	if(isset($_GET['wpanel'])&&is_array($_SESSION['wpanel_user'])){
		if($_SESSION['ws-tags']['ws-user']['email']!='wpanel@tagbum.com'){
			$user=CON::getRow("SELECT * FROM users WHERE email='wpanel@tagbum.com'");
			createSession($user);
		}
	}
	$idTag=!isset($_GET['tag'])?'':$_GET['tag'];
	$idUser = isset($_GET['wpanel'])?'':'AND id_creator ="'.$_SESSION['ws-tags']['ws-user']['id'].'"';
	$tag = CON::getRow("SELECT * FROM tags WHERE md5(id) =? $idUser AND status NOT IN (2,4)",array(intToMd5($idTag)));
	if (!isset($tag['video_url'])) $tag['video_url']='';
	$group=isset($tag['id_group'])&&$tag['id_group']!='0'?md5($tag['id_group']):$_GET['group'];
	$bcard=isset($tag['id_business_card'])&&$tag['id_business_card']!='0'?$tag['id_business_card']:$_GET['bc'];
	$personal=$tag['status']==9||isset($_GET['personal']);
	$status=isset($tag['status'])?$tag['status']:(isset($_GET['wpanel'])?10:($group!=''?7:($personal||$bcard!=''?9:1)));
	if ($group!='' || isset($_GET['product'])){
        if ($group!='') $acceso=  existe('users_groups', 'id', 'WHERE md5(id_group)= "'.$group.'" AND id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND status="1"');
        elseif (isset($_GET['product'])) $acceso=  existe('store_products', 'id', 'WHERE id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'" AND md5(id)="'.$_GET['product'].'"');
    }else{ $acceso=true; }
    // echo $status.' Variable del wpanel';
if ($acceso){  ?>
<div id="editTag-box" class="ui-single-box">
	<form action="controls/tags/newTag.json.php" method="post" enctype="multipart/form-data" id="formTags" style="margin:0;padding:0;">
		<input type="hidden" name="type" id="type" value="" />
		<input type="hidden" name="status" id="status" value="<?=$status?>"/>
		<input type="hidden" name="bcard" value="<?=$bcard?>"/>
		<input type="hidden" name="tag" value="<?=$tag['id']?>"/>
		<?php if(isset($_GET['wpanel'])){ ?><input type="hidden" name="wpanel" value="1"/><?php } ?>
		<input type="hidden" name="product" value="<?=$_GET['product']?>" />
		<input type="hidden" name="group" value="<?=$group?>" />
		<input type="hidden" name="imgTemplate" id="imgTemplate" value=""/>
		<input type="hidden" name="htxtVideo" id="htxtVideo" data-tipo="" value="<?=$tag['video_url']?>" />
	<div class="ui-single-box-title">
		<div id="groupTitleStyle"><?php
			//echo $idTag.'---'.$tag['id'].'---'.$_GET['tag'];
			if(!$tag['id'])	echo $personal?NEWTAG_LBLTITLE_PERSONAL:NEWTAG_LBLTITLE;
			else			echo $personal?UPDATETAG_LBLTITLE_PERSONAL:UPDATETAG_LBLTITLE;
			if (isset($_GET['product'])) echo ' - '.NEWTAG_PRODUCT_TAG;
			if (isset($_GET['wpanel'])) echo ' - Wpanel';
			if ($group!=''){
				$_group = $GLOBALS['cn']->queryRow('SELECT name FROM groups WHERE md5(id) = "'.$group.'" LIMIT 1;');
				echo ' - '.MAINMNU_GROUPS.' ('.$_group['name'].')';
			}
		?></div>
	</div>
	<div id="dialogBck"></div>
	<div class="tag-container" style="height:auto;">
		<div id="html_tag_placa">
			<?=NEWTAG_DIMESIONS.': 650x300px'?>
		</div>
		<!-- mensaje superior -->
		<div id="inputShortMessage" style="position: absolute; top: 41px; left: 115px; z-index: 999999;">
			<div>
				<input name="txtMsg" id="txtMsg" type="text" class="tag-text" placeholder="<?=NEWTAG_LBLTEXT?>" value="<?=$tag['text']?>" style="border: dashed #222 1px; color:#F57133"/>
					<div class="colorpickerDiv" style="position: absolute;top: 6px;left: 410px;">
						<input style="width: 33px;border: none;height: 28px;" type="text" id="hiddenColor" tipo="excolor" requerido="<?=HEXADECIMAL_VALITACION?>" name="hiddenColor" value="<?=$tag['color_code']?$tag['color_code']:'#F57133'?>" class="colorBG" />
						<div id="hiddenColorDiv"></div>
					</div>
			</div>
			<div id="cont1" class="font-size3 bold">
				<span id="theCounter"></span>&nbsp;max
			</div>
		</div>
		<!-- end mensaje superior -->
		<!-- mensaje corto -->
		<div id="inputCode" style="position: absolute; top: 96px; left: 43px; z-index: 999989;">
			<div>
				<input name="txtCodeNumber" id="txtCodeNumber" type="text" class="tag-text" value="<?=$tag['code_number']?>" placeholder="<?=NEWTAG_LBLCODENUMBER?>" <?php if(NEWTAG_LBLCODENUMBER_TITLE!=""){?> title="<?=NEWTAG_LBLCODENUMBER_TITLE?>" <?php }?> style="border: dashed #222 1px;color:#03A993;font-size: 71px;height:71px;width: 524px;font-weight: normal;"/>
				<div class="colorpickerDiv" style="position: absolute;top: -4px;left: 485px;">
					<input style="border: none" type="text" id="hiddenColor2" tipo="excolor" requerido="<?=HEXADECIMAL_VALITACION?>" name="hiddenColor2" value="<?=$tag['color_code2']?$tag['color_code2']:'#03A993'?>" class="colorBG" />
					<div id="hiddenColorDiv2"></div>
				</div>
			</div>
			<div id="cont2" class="font-size3 bold">
				<span id="theCounter2"></span>&nbsp;max
			</div>
		</div>
		<!-- end mensaje corto -->
		<!-- mensaje inferior -->
		<div id="inputLongMessage" style="position: absolute; top: 200px; left: 40px; z-index: 999979;">
			<div>
				<input name="txtMsg2" id="txtMsg2" type="hidden" value="<?=$tag['text2']?>"/>
				<textarea id="textlarg" name="textlarg" class="tag-text textareaComment" rows="3" placeholder="<?=NEWTAG_LBLTEXT?> 2 <?=INVITEUSERS_HELPMSG?>" <?php if(NEWTAG_LBLCODENUMBER_TITLE!=""){?> title="<?=NEWTAG_LBLCODENUMBER_TITLE?>" <?php }?> style="color:#fff;border: dashed #222 1px;;width: 563px;background: transparent;"><?=$tag['text2']?></textarea>
				<div class="colorpickerDiv" style="position: absolute;top: -4px;left: 492px;">
					<input style="border: none" type="text" id="hiddenColor3" tipo="excolor" requerido="<?=HEXADECIMAL_VALITACION?>" name="hiddenColor3" value="<?=$tag['color_code3']?$tag['color_code3']:'#fff'?>"  class="colorBG" />
					<div id="hiddenColorDiv3"></div>
				</div>
			</div>
			<div id="cont3" class="font-size3 bold">
				<span id="theCounter3"></span>&nbsp;max
			</div>
		</div>
		<!-- end mensaje inferior -->

		<div id="bckSelected" class="tag-container"></div>
	</div>

	<div id="newTagImput">
		<div id="BackgroundAndVideo">
			<div id="backgroundsTag">
				<!-- <label><?=NEWTAG_LBLBACKGROUND?>:</label><br> -->
				<!-- <div id="bgSelect"></div> -->
				<input id="bgAndVideo" type="button" value="<?=lan('img_video')?>" ajax/>
			</div>
			<?php
				$privateTag=($group==''&&$_GET['product']==''&&$status!=9&&$idTag=='');
				if($privateTag){
			?>
			<div style="float: right;margin-top: 10px;margin-right: 10px;">
				<input id="showPrivacy" type="button" data-act="1" value="<?=lan('show_privacy')?>"/>
			</div>
			<div id="PublicPrivate" style="display:none;float:right;margin-top:10px;margin-right:10px;">
				<!-- <label style="font-weight: bold">Privacy:</label><br> -->
				<select title="<?=NEWTAG_SHARETAGONLY_TITLE?>" name="showPublicPrivate" id="showPublicPrivate">
					<option value="1"><?=NEWTAG_SELECTPUBLICTAG?></option>
					<option value="4"><?=NEWTAG_SELECTPRIVATETAG?></option>
				</select>
			</div>
			<?php } ?>
		</div>
		<div>
			<div id="preVideTags" class="mini" style="width:280px;float:left;"></div>
		<?php if($privateTag){ ?>
			<div id="divcboPeoples" style="display:none;float:right;">
				<label class="label_tags_views" for="cboPeoples"><?=NEWTAG_SHARETAGONLY?>:</label>
				<select name="cboPeoples" id="cboPeoples" ></select>
			</div>
		<?php } ?>
		</div>
		<div class="clearfix"></div>
		<div id="ButtonPrev_publish">
			<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){//NEXT LINE IS THE FILE-CHOOSER ?>
				<div id="bckArchive" class="float-left invisible">
					<input name="photo" type="file" id="photo" class="invisible"/>
				</div>
				<!-- <div id="fileUpload" class="invisible"><input name="picture" type="file" class="invisible"/></div> -->
				<!-- <div id="fileUploadText"></div> -->
			<?php } ?>
			<div id="btnPanel" class="float-right">
				<input id="cancel" type="button" value="<?=JS_CANCEL?>"/>
				<!-- <input id="preview" type="button" value="<?=NEWTAG_BTNPREVIEW?>"/> -->
				<?php if(!isset($_GET['wpanel'])){ ?>
				<input id="publi" type="button" value="<?=NEWTAG_BTNPUBLISH?>" ajax/>
				<?php } ?>
			</div>
		</div>
	</div>
  </form>
	<div class="clearfix"></div>
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
<script type="text/javascript">
$(function(){
	if (!window.players){ window.players=[]; }
	var pub=true,bgd="<?=$tag['background']?$tag['background']:''?>";

	$("#hiddenColorDiv").hover(function() {
		var value = $("#hiddenColor").val();
		 $("#txtMsg").css('color',value);
	});

	$("#hiddenColorDiv2").hover(function() {
		var value = $("#hiddenColor2").val();
		 $("#txtCodeNumber").css('color',value);
	});

	$("#hiddenColorDiv3").hover(function() {
		var value = $("#hiddenColor3").val();
		 $("#textlarg").css('color',value);
	});

	$('[title]').tipsy({html:true,gravity:'n'});
	$('.topBanner').remove();
	$('#radio').buttonset();
	function setType(type){$('#type').val(type||'<?=$idPage?>');}
	function setBG(img){
		$('#imgTemplate').val(img);
		var url=(img.match(/[0-9a-f]{8}_\d{14}_\d\.jpe?g$/i)?SERVERS.video+'videos/':SERVERS.img+'img/templates/')+img;
		$('#bckSelected').css('background-image','url('+url+')');
	}
	if ($('#showPublicPrivate').length>0){ //acciones privacidad
		$('#showPublicPrivate').chosen({disableSearch:true,width:120});
		$('#showPrivacy').click(function(event) {
			if(this.dataset.act==1){
				$('#PublicPrivate').show();
				this.dataset.act=2;
				this.value="<?=lan('hide_privacy')?>";
			}else{
				$('#PublicPrivate').hide();
				this.dataset.act=1;
				this.value="<?=lan('show_privacy')?>";
			}
		});
		$('#showPublicPrivate').change(function(){
			$('#status').val(this.value);
			if (this.value==1) $('#divcboPeoples').fadeOut(600);
			else $('#divcboPeoples').fadeIn(600).css({'display':'inline-block','margin-top':'15px'});
		});
	}
	//cambio de video
	var video=$('#htxtVideo')[0];
	$(video).change(function(){
		if(this.value.match(/^https?:\/\//i)) return;
		if(!window.video_convert_tmpl) window.video_convert_tmpl=tmpl('template-conversion');
		var obj={
			content:$('#preVideTags')[0]
		};
		$.ajax({
			disablebuttons:true,
			url:LOCAL?'video/test/1':SERVERS.video+'?captures',
			dataType:'json',
			type:'post',
			data:{code:"<?=$_SESSION['ws-tags']['ws-user']['code']?>",file:video.value},
			success:function(data){
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
					}
				}else
					$(obj.content).html(video_convert_tmpl({state:'notfound'}));
				// if (!data.error){
				// 	video.value=data.video;
				// 	var html=htmlVideo(SERVERS.video+'videos/'+data.video,'local',null,true),captures='';
				// 	for(var i=0,capture;capture=data.captures[i];i++){
				// 		captures=captures+'<div class="option-cap" data-src="videos/'+capture+'" style="background-image:url(\''+SERVERS.video+'videos/'+capture+'\');"></div>';
				// 	}
				// 	if(captures!=''){
				// 		captures='<div class="clearfix"></div><div class="select-capture">'+captures+'</div><div class="clearfix"></div>';
				// 	}
				// 	if(html!='')
				// 		$('#preVideTags').html('<div class="tag-container" style="width:auto;font-size: 100%;"><div tag="pre">'+html+'</div>'+captures+'</div>')
				// }
			}
		});
	});
	if(video.value!=''){
		$.debug().log('video change: ',video.value);
		if(video.value=='') return;
		$.ajax({
			url:'video/validate/1',
			type:'POST',
			dataType:'json',
			data:{thisvideo:video.value,nolocal:'1'},
			success:function(data){
				if (data['success']){
					var band=true;
					if (band){
						if (data['type']=='local'){
							$(video).change();
						}else{
							htmlv=htmlVideo(data['urlV'],data['type'],null,true);
							video.dataset.tipo=data['type'];
							if (htmlv!='') $('#preVideTags').html('<div class="tag-container" style="width:auto;font-size: 100%;"><div tag="pre">'+htmlv+'</div></div>');
							iniallYoutube();
						}
					}else video.value='';
				}else video.value='';
			}
		});
	}
	$('#bgAndVideo').click(function(event){
		var video=document.getElementById('htxtVideo');
		if(video.value!='') get='?video='+video.value+'&tipo='+video.dataset.tipo;
		else get='';
		$.dialog({
			title:'<?=lan('img_video')?>',
			resizable:false,
			width:750,
			height:500,
			modal:true,
			open:function(){ $(this).load('upload/videos_templates/dialog'+get); },
			buttons:[],
			close:function(){
				$('video',this).each(function(index, el) {
					this.pause();
					this.src="";
				});
			}
		});
	});
	$('#preVideTags').on('click','div[tag] .video button.delete',function(){
		$(this).parents('div[tag]').hide().parent('.tag-container').remove();
		$('#htxtVideo').val('');
	}).on('click','.tag-container .select-capture .option-cap',function(){
		var data=this.dataset.src.replace(/^videos\//,'');
		$('#bckSelected').css('background-image','url('+SERVERS.video+'videos/'+data+')');
		$('#imgTemplate')[0].value=data;
		$(this).parent().find('.option-cap').removeClass('selected');
		$(this).addClass('selected');
	});
	setType();//default
	if (bgd!=''){ setBG(bgd); }
	function redirTo(){
		<?php if($personal){//if personal tag ?>
			redir('timeline?current=personalTags');
		<?php }elseif(isset($_GET['product'])){//if product tag ?>
			redir('mypublications');
//			document.location.hash='#products?sc=2';
		<?php }elseif($group!=''){//if is group tag ?>
			redir('groupsDetails?grp=<?=$group?>');
		<?php }elseif(isset($_GET['wpanel'])){ ?>
			redir('wpanel/?url=vistas/viewTagWpanel.php');
		<?php }elseif($bcard!=''){ ?>
			redir('profile?sc=3');
		<?php }else{ ?>
			redir('timeline?current=timeLine');
		<?php } ?>
	}
	function tagPreview(data){
		$.dialog({
			title:'Preview',
			resizable:false,
			width:720,
			height:460,
			modal:true,
			open:function(){
				$(this).html(
					'<div style="margin-left: 20px">'+
						'<div class="tag-box">'+
							'<div id="layerTag" class="tag-container noMenu" style="height: auto" >'+
								showTag(data)+
							'</div>'+
						'</div>'+
						'<div class="clearfix"></div>'+
					'</div>'
				);
				iniallYoutube();
			},
			buttons:{
				'<?=JS_CANCEL?>':function(){
					if(pub){
						$(this).dialog('close');
						redirTo();
					}
				},
				'<?=JS_CHANGE?>':function(){
					if(pub){
						$(this).dialog('close');
					}
				},
				'<?=JS_PUBLISH?>':function(){
					if(pub){
						$(this).dialog('close');
						$('#formTags').submit();
					}
				}//click publish
			}
		});
	}
	$('#bckArchive').hide();
	colorSelector('hiddenColorDiv', 'hiddenColor');
	colorSelector('hiddenColorDiv2','hiddenColor2');
	colorSelector('hiddenColorDiv3','hiddenColor3');
	$('#theCounter').textCounter({
		target:'#txtMsg',//required: string
		count:50,//optional: integer [defaults 140]
		alertAt:20,//optional: integer [defaults 20]
		warnAt:10,//optional: integer [defaults 0]
		stopAtLimit:true //optional: defaults to false
	});
	$('#theCounter2').textCounter({
		target:'#txtCodeNumber', // required: string
		count:12,//optional: integer [defaults 140]
		alertAt:7,//optional: integer [defaults 20]
		warnAt:3,//optional: integer [defaults 0]
		stopAtLimit:true //optional: defaults to false
	});
	$('#theCounter3').textCounter({
		//target:'#txtMsg2',//required: string
		target:'#textlarg',//required: string
		count:200,//optional: integer [defaults 140]
		alertAt:20,//optional: integer [defaults 20]
		warnAt:10,//optional: integer [defaults 0]
		stopAtLimit:true //optional: defaults to false
	});
//	$('#showPublicPrivate').selectmenu({
//		menuWidth:200,
//			width:200
//	});
	$('#cboPeoples').fcbkcomplete({
			width : '250px',
			json_url:'includes/friendsHelp.php?value=1',
			newel:true,
			filter_selected:true,
			addontab:false,
			filter_hide:true
	});
	$('#textlarg').keyup(function(){
		$('#txtMsg2').val($('#textlarg').val());
	});
	<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
		//$('#photo').customFileInput();
	<?php } ?>
	// $('#fileUpload').on('change','input',function(){ // boton de preview
	// 	$('#fileUploadText').html('<span>Uploading file. Wait a moment...</span> <img src="css/smt/loader.gif" />').show();
	// 	setType('uploadfile');
	// 	$('#formTags').submit();
	// });
	$('#btnPanel input').click(function(){/*-- panel de botones de acciones - final de la pagina --*/
		if(pub){
			if(this.id=='cancel') redirTo();//cancela creacion/edicion
			else if(valida('formTags')){//validacion del formulario
				if(this.id=='preview') setType('preview');
				if(this.id=='publi') pub=true;
				//verificar si hay usuarios o correos para generar la tag privada
				verif=($('#showPublicPrivate').val()=='1')? 0 : ($('#showPublicPrivate').val()=='4'&&$('#cboPeoples').val()!=null)?0:1;
				if(verif==0){
					$('#formTags').submit();
				}else{
					if($('#PublicPrivate').is(':visible')){
							message('nouserprivate', '<?=PUBLICITY_LBLMESAGGE?>', '<?=NEWTAG_MSGERRORPRIVATETAG?>');
						}else{
							$('#formTags').submit();
						}
				}
			}
		}
	});
	var options={
		dataType:'json',
		beforeSend:function(){
			pub=false;
		},
		success:function(data){//post-submit callback
			$.c().log('newtag_ctrl',data);
			if(!data) return;
			if(data['bg']) setBG(data['bg']);
			switch(data['type']){
				// case 'uploadfile':
				// 	$('#fileUploadText').html(data['msg']);
				// 	setTimeout(function(){$('#fileUploadText').fadeOut('slow');},2000);
				// break;
				case 'preview':
					tagPreview({img:data['img'],typeVideo:data['typeVideo'],video:data['video']});
//					$('#loading').dialog('close');
				break;
				case 'new':case 'update':
					pub=false;
					redirTo();
				default:
			}
		},
		error:function(){
			$('#fileUploadText').html('');
		},
		complete:function(){
			pub=true;
//			$('loader.page',PAGE).hide();
			setType();
			// $('#fileUpload').empty().html('<input name="picture" type="file" />');
		}
	};
	$('#formTags').ajaxFormLog(options);
	$('#default-dialog').dialog('close');
	//tour
	tour(SECTION);
});
</script>
<!-- Teplates -->
<script id="template-conversion" type="text/x-tmpl">
{% if(o.state=='waiting'){ %}
	<div class="messageNoResultSearch more" style="text-align:center;">
		<img src="css/smt/loader.gif" width="32" height="32" class="loader"><br/>
		<?=lan("PROCESSINGYOURVIDEO")?>
	</div>
{% }else if(o.state=='notfound'){ %}
	<div class="messageNoResultSearch more" style="text-align:center;">
		<?=lan("VIDEONOTFOUND")?>
	</div>
{% }else if(o.state=='error'){ %}
	<div class="messageNoResultSearch more" style="text-align:center;">
		<?=lan("ERRORPROCESSINGYOURVIDEO")?>
		{% if(o.isupload){ %}
		<br/>
		<?=lan("RETRYVIDEOUPLOAD")?>
		{% } %}
		<br/><br/>
		<input type="button" class="retry" value="<?=lan('Retry')?>"/>
	</div>
{% }else if(o.state=='done'){ %}
	<div class="tag-container" style="width:auto;font-size:100%;">
		<div tag="pre"></div>
		{% if(o.captures&&o.captures.length>0){ %}
		<div class="select-capture clearfix">
		{% for(var i=0,capture;capture=o.captures[i];i++){ %}
			<div class="option-cap" data-src="{%=capture%}"
				style="background-image:url('{%=o.path+capture%}');"></div>
		{% } %}
		</div>
		{% } %}
	</div>
{% } %}
</script>
<?php }else{ ?>
<div id="editTag-box" class="ui-single-box">
	<div class="ui-single-box-title" ><h3><?=NEWTAG_LBLTITLE?></h3></div>
	<?php if($group!=''){ ?>
		<div class="messageAdver" ><?=TAGS_INCORRUPTUS_GROUPS?></div>
	<?php }elseif(isset($_GET['product'])){ ?>
		<div class="messageAdver" ><?=TAGS_INCORRUPTUS_PRODUCTS?></div>
	<?php } ?>
</div>
<?php } ?>

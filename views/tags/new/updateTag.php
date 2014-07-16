<?php

$_SESSION['ws-tags']['ws-user']['change_tag_id']=$_GET[tag];
$_SESSION['ws-tags']['ws-user']['wedit']=$_GET[wedit];

addJs('js/funciones_bc.js');

	//borrado de las tags temporales del usuario
	$delete = $GLOBALS['cn']->query("DELETE FROM tags WHERE id_creator = '".$_SESSION['ws-tags']['ws-user'][id]."' AND status = '0' AND id!='".$_SESSION['ws-tags']['ws-user']['change_tag_id']."' ");

	//borrado de las tags_privates temporales del usuario
	$delete = $GLOBALS['cn']->query("DELETE FROM tags_privates WHERE id_user = '".$_SESSION['ws-tags']['ws-user'][id]."' AND status_tag = '0' AND id_tag!='".$_SESSION['ws-tags']['ws-user']['change_tag_id']."' ");

	//datos de la tag a modificar
	$tag = $GLOBALS['cn']->query("	SELECT	id,
											background,
											code_number,
											color_code,
											color_code2,
											color_code3,
											text,
											text2,
											video_url,
											id_business_card,
											status,
											id_product,
											id_group

									FROM tags
									WHERE id ='".$_SESSION['ws-tags']['ws-user']['change_tag_id']."' AND id_creator ='".$_SESSION['ws-tags']['ws-user'][id]."'
								 ");

   //datos de los usuarios seleccionados
   $privatesTags = $GLOBALS['cn']->query("	SELECT id_user, id_friend, id_tag
											FROM tags_privates
											WHERE id_tag = '".$_SESSION['ws-tags']['ws-user']['change_tag_id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user'][id]."'");

if(mysql_num_rows($tag)!=0) {

$tag = mysql_fetch_assoc($tag);

if ($tag[id_group]!='0'){

	$_GET[group]=md5($tag[id_group]);
}

if ($tag[status]=='10'){

	$_GET[wpc]=1;
}

if ($tag[status]=='9'){

	$_GET[personal]=1;
}

if ($tag[id_product]!='0'){
	$_GET[product]=$tag[id_product];
}
if ($tag[id_product]!='0'){

	$_GET[product]=md5($tag[id_product]);
}
?>
<script>

	$$('.topBanner').remove();
	setTimeout(function(){

	<?php
	while ($privateTag = mysql_fetch_assoc($privatesTags)){
		$_users = $GLOBALS['cn']->query("SELECT id, CONCAT(name,' ',last_name) AS label FROM users WHERE id = '".$privateTag[id_friend]."'");
		$_user  = mysql_fetch_assoc($_users);
	?>
		console.log([{"title": "<?=$_user[label]?>", "value": "<?=$_user[id]?>"}]);

		$("#cboPeoples").trigger("addItem",[{"title": "<?=$_user[label]?>", "value": "<?=$_user[id]?>"}]);

	<?php
	}
	?>
	},400);
</script>

<div id="editTag-box">
  <form action="controls/tags/newTagAjax.controls.php" method="post" enctype="multipart/form-data" id="editTags" style="margin:0; padding:0">
	<input name="id_business_card" id="id_business_card" type="hidden" value="<?=$tag[id_business_card]?>"/>
	<input name="update" type="hidden" value="<?=$_SESSION['ws-tags']['ws-user']['change_tag_id']?>" />
	<?php if (isset($_GET[wpc])){ ?>
		<input type="hidden" id="wpc" name="wpc" value="1"/>
	<?php }
		if (isset($_GET[personal])){ ?>
		<input type="hidden" id="personal" name="personal" value="1"/>
	<?php }//if personal tag
		if (isset($_GET[product])){
	?>
		<input type="hidden" id="product" name="product" value="<?=$_GET[product]?>" />
	<?php }//if product tag
		if (isset($_GET[group])){
	?>
		<input type="hidden" id="group" name="group" value="<?=$_GET[group]?>" />
	<?php }//if is group tag ?>
	<div class="ui-single-box-title">
				<?php
					if (isset($_GET[personal]))
						echo UPDATETAG_LBLTITLE_PERSONAL;
					else
						echo UPDATETAG_LBLTITLE;

					if (isset($_GET[product]))
						echo ' - '.NEWTAG_PRODUCT_TAG;

					if (isset($_GET[wpc]))
						echo ' - Wpanel';

					if (isset($_GET[group])){

						$group = $GLOBALS['cn']->query('
							SELECT name
							FROM groups
							WHERE md5(id) = "'.$_GET[group].'"
							LIMIT 1
						');
						$group = mysql_fetch_assoc($group);

						echo ' - '.MAINMNU_GROUPS.' ('.$group[name].')';
					}
				?>
	</div>
	<div class="tag-container" style="height: auto">
		<div id="html_tag_placa"></div>
		<div id="bckSelected" style="background:url('<?=(strpos(' '.$tag[background],'default')?DOMINIO: FILESERVER)?>img/templates/<?=$tag[background]?>');"></div>
	</div>

	<div id="newTagImput">
		<div id="radio"  style="margin: 10px 0; height: 24px;">
			<input type="radio" id="radio1" name="radio" <?php if($_SESSION['ws-tags']['ws-user']['view_creation_tag']==0){?>checked="checked"<?php }?>  /><label class="radio_view" for="radio2" style="float:right"><?=NEWTAG_VIEW_ADVANCE?></label>
			<input type="radio" id="radio2" name="radio" <?php if($_SESSION['ws-tags']['ws-user']['view_creation_tag']!=0){?>checked="checked"<?php }?>/><label class="radio_view" for="radio1" style="float:right"><?=NEWTAG_VIEW_QUICK?></label>
		</div>
		<div id="inputShortMessage">
			<div>
				<input name="txtMsg" id="txtMsg" class="ui-single-box" size="50" value="<?=$tag[text]?>" placeholder="<?=NEWTAG_LBLTEXT?>" <?php if(NEWTAG_LBLTEXT_TITLE!=""){?> title="<?=NEWTAG_LBLTEXT_TITLE?>" <?php } else{}?>>
				<input type="text" id="hiddenColor" readonly="readonly" name="hiddenColor"value="<?=$tag[color_code]?>" class="colorBG" />
				<div class="text font-size3 color-d paddingTop"><?=NEWTAG_FONTCOLOR?></div>
				<div id="hiddenColorDiv"></div>
			</div>
			<div id="cont1">
				<span id="theCounter" class="font-size3 color-d"></span>&nbsp;<span class="font-size3 color-d">max</span>
			</div>
		</div>

		<div id="inputCode">
			<div>
				<input name="txtCodeNumber" id="txtCodeNumber" class="ui-single-box" size="50" value="<?=$tag[code_number]?>" placeholder="<?=NEWTAG_LBLCODENUMBER?>" <?php if(NEWTAG_LBLCODENUMBER_TITLE!=""){?> title="<?=NEWTAG_LBLCODENUMBER_TITLE?>" <?php } else{}?>>
				<input type="text" id="hiddenColor2" name="hiddenColor2" readonly="readonly" value="<?=$tag[color_code2]?>"  class="colorBG" />
				<div class="text font-size3 color-d paddingTop"><?=NEWTAG_FONTCOLOR?></div>
				<div id="hiddenColorDiv2"></div>
			</div>
			<div id="cont2">
				<span id="theCounter2" class="font-size3 color-d"></span>&nbsp;<span class="font-size3 color-d">max</span>
			</div>
		</div>
		<div id="inputLongMessage">
			<div>
				<input name="txtMsg2" id="txtMsg2" class="ui-single-box" size="70" value="<?=$tag[text2]?>" placeholder="<?=NEWTAG_LBLTEXT?> 2" <?php if(NEWTAG_LBLCODENUMBER_TITLE!=""){?> title="<?=NEWTAG_LBLCODENUMBER_TITLE?>" <?php } else{}?>>
				<input type="text" id="hiddenColor3" name="hiddenColor3" readonly="readonly" value="<?=$tag[color_code3]?>"  class="colorBG" />
				<div class="text font-size3 color-d paddingTop"><?=NEWTAG_FONTCOLOR?></div>
				<div id="hiddenColorDiv3"></div>
			</div>
			<div id="cont3">
				<span id="theCounter3" class="font-size3 color-d"></span>&nbsp;<span class="font-size3 color-d">max</span>
			</div>
		</div>
		<?php if ($tag[status]!='9'){
					$paso = 0;
				if (mysql_num_rows($privatesTags)>0)
						$paso = 1;
	    ?>
		<div id="PublicPrivate">
			<select title="<?=NEWTAG_SHARETAGONLY_TITLE?>" name="showPublicPrivate" id="showPublicPrivate" onchange="showOrHide(this.value, '#showOrHideCboPeople');" >
				<option value="0" <?php if ($paso==0) echo "selected"; ?>><?=NEWTAG_SELECTPUBLICTAG?></option>
				<?php if(($_GET[group]=="")&&($_GET[product]=="")){ ?><option value="1" <?php if ($paso==1) echo "selected"; ?>><?=NEWTAG_SELECTPRIVATETAG?></option><?php } else{ echo "";}?>
			</select>
			<?php $displayPeople = (mysql_num_rows($privatesTags)>0)? "display:block": "display:none";?>
			<div id="showOrHideCboPeople" style="<?=$displayPeople?>">
				<label class="label_tags_views" style="width:200px" for="cboPeoples" <?php if(NEWTAG_SHARETAGONLY_HELP!=""){?> title="<?=NEWTAG_SHARETAGONLY_HELP?>" <?php } else{}?>><?=NEWTAG_SHARETAGONLY?>:</label>
				<select name="cboPeoples" id="cboPeoples"></select>
			</div>

		</div>
		<?php } ?>
		<div id="BackgroundAndVideo">
			<div id="backgroundsTag">
				<label ><?=NEWTAG_LBLBACKGROUND?>:</label><br>
				<div id="returnSelect">
					<select id="bckSelect">
						<option value="...">...</option>
						<option value="file"><?=NEWTAG_UPLOADBACKGROUND?></option>
						<option value="archive"><?=NEWTAG_SELECTBACKGROUND?></option>
					</select>
				</div>
			</div>
			<div id="videosTag">
				<label><?=NEWTAG_LBLVIDEO?>:</label><br>
				<input type="text" name="txtVideo" id="txtVideo" class="ui-single-box" size="55" onfocus="this.select()" value="<?=$tag[video_url]?>" placeholder="http://" <?php if(NEWTAG_LBLVIDEO_TITLE!=""){?> title="<?=NEWTAG_LBLVIDEO_TITLE?>" <?php } else{}?>/>
			</div>
		</div>
		<div id="ButtonPrev_publish">
			<?php //NEXT LINE IS THE FILE-CHOOSER
				if($_SESSION['ws-tags']['ws-user']['fullversion']!=1)
				{
				?>
				<div id="bckArchive" class="float-left">
					<input name="photo" type="file" id="photo"/>
				</div>
				<?php
				}?>

			<div class="float-right" >
				<?php
				if (!isset($_GET[wpanel])){
				?>
				<input name="btnPubli" id="btnPubli" class="float-right" type="button" value="<?=NEWTAG_BTNPUBLISH?>" />
				<?php } ?>
				<input name="btnPubli" id="btnPreview" class="float-right" type="button" value="<?=NEWTAG_BTNPREVIEW?>" />
			</div>
		</div>

	</div>
	<?php if ($_SESSION['ws-tags']['ws-user']['wedit']=='1'){ ?>
		<input type="hidden" id="wedit" name="wedit" value="<?=$_SESSION['ws-tags']['ws-user']['wedit']?>"  />
	<?php } ?>
	<input name="imgTemplate" id="imgTemplate" type="hidden" value="<?=$tag[background]?>" />
	<input name="preview" id="preview" type="hidden" value="1" />
  </form>
</div>

<script type="text/javascript">
$(function(){

	$.on({
		open: function(){
			console.log(container);

			$("#radio",container).buttonset();

			$("#radio1",container).click(function(){ // esconder
			//	$("#bckArchive").removeClass("float-left").addClass("float-right");

				$("#inputShortMessage,#PublicPrivate,#videosTag label,#txtVideo",container).fadeOut();
				$.ajax({
					url: "controls/users/viewcreation.control.php?hide"
				});
			});

			$("#radio2",container).click(function(){ // mostrar
				$("#inputShortMessage,#PublicPrivate,#videosTag label,#txtVideo",container).fadeIn();
				$.ajax({
					url: "controls/users/viewcreation.control.php"
				});
			});

			<?php if($_SESSION['ws-tags']['ws-user'][view_creation_tag]==0){ ?>
				$("#inputShortMessage,#PublicPrivate,#videosTag label,#txtVideo",container).hide();
			<?php } ?>

			$('#bckArchive',container).hide();

			colorSelector('hiddenColorDiv','hiddenColor');
			colorSelector('hiddenColorDiv2','hiddenColor2');
			colorSelector('hiddenColorDiv3','hiddenColor3');

			$("#theCounter",container).textCounter({
				target: "#txtMsg", // required: string
				count: 50, // optional: integer [defaults 140]
				alertAt: 20, // optional: integer [defaults 20]
				warnAt: 10, // optional: integer [defaults 0]
				stopAtLimit: true // optional: defaults to false
			});

			$("#theCounter2",container).textCounter({
				target: "#txtCodeNumber", // required: string
				count: 12, // optional: integer [defaults 140]
				alertAt: 5, // optional: integer [defaults 20]
				warnAt: 2, // optional: integer [defaults 0]
				stopAtLimit: true // optional: defaults to false
			});

			$("#theCounter3",container).textCounter({
				target: "#txtMsg2", // required: string
				count: 200, // optional: integer [defaults 140]
				alertAt: 20, // optional: integer [defaults 20]
				warnAt: 10, // optional: integer [defaults 0]
				stopAtLimit: true // optional: defaults to false
			});

			$$("#showPublicPrivate, #bckSelect").selectmenu({
				menuWidth: 180,
					width: 180
			})

			$("#cboPeoples",container).fcbkcomplete({
					json_url: "includes/friendsHelp.php?value=u.id",
					newel:true,
					filter_selected:true,
					addontab : false,
					filter_hide: true
			});

			<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
				$('#photo',container).customFileInput();
			<?php } ?>

			$$("#returnSelect").on("change","#bckSelect",function(){

				if($$('#bckSelect').val()=='file'){

					$$('#bckArchive').fadeIn('fast');

				}else if($$('#bckSelect').val()=='archive'){

					$$('#bckArchive').fadeOut('fast');

					$.dialog({
						id:"#dialogBck",
						title: "<?=NEWTAG_SELECTEBCKTAG?>",
						resizable: false,
						width:584,
						height:500,
						modal: true,
						show: "fade",
						hide: "fade",
						open: function() {
							$("#dialogBck").load("views/tags/new/templates.view.php");
						},
						close: function(){
							//alert("siempre");
							$("#bckSelect").remove();

							$("#returnSelect").html('<select id="bckSelect">'
													+'<option value="...">...</option>'
													+'<option value="file"><?=NEWTAG_UPLOADBACKGROUND?></option>'
													+'<option value="archive"><?=NEWTAG_SELECTBACKGROUND?></option>'
													+'</select>');

												$("#bckSelect").selectmenu({
														menuWidth: 180,
															width: 180
													});

						}
					});
				}
			});

//			$$("#bckSelect").click(function(){
//				alert("ho");
//			});

			$$("#btnPreview").click(function(){ // boton de preview
				if (valida('editTags')){
					$("#preview").val("0");
					$("#editTags").submit();
				}
			});

			$$("#btnPubli").click(function(){ // publicar
				if (valida('editTags')) {
					//$("#wrapper").fadeOut('slow');
//					$("body",container).append('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
//					$("#loading",container).dialog({title: '<?=NEWTAG_LOADING?>',modal:true});
//					$.dialog({
//						id:'loading',
//						title: 'Crear tag',
//						modal: true,
//						show: 'fade',
//						hide: 'fade',
//						open: function() {
//							$('#loading').html('<?=NEWTAG_SUCCESS?>');
//						},
//						buttons: [{
//							text: lang.JS_CLOSE,
//							click: function() {
//								$(this).dialog('close');
//							}
//						}]
//					});
					$('loader.page',PAGE).show();
					$$("#editTags").submit();
				}
			});

			var options = {
				success: function(responseText){ // post-submit callback
					//alert(responseText);
					if(responseText.indexOf('|')>-1){
						var _get=responseText.split('|');
						previewTag('Preview','?asyn=1&tag='+_get[0], _get[2], _get[1]);
						$('loader.page',PAGE).hide();
						$("#loading").dialog("close");
					}else{
						//$('#loading',container).html(responseText);
						$("#loading").dialog("close");
						<?php if (isset($_GET[personal])){ //if personal tag ?>
							$('html, body').animate({scrollTop: 0},"slow");
							document.location.hash="timeline?current=personalTags";
						<?php }elseif (isset($_GET[product])){//if product tag ?>
							$('html, body').animate({scrollTop: 0},"slow");
							document.location.hash="#timeline?current=timeLine";
						<?php }elseif (isset($_GET[group])){//if is group tag ?>
							document.location.hash="#groupsDetails?grp=<?=$_GET[group]?>";
							$('html, body').animate({scrollTop: 0},"slow");
						<?php }elseif ($_GET[wpc]){?>
							redir('wpanel/?url=vistas/viewTagWpanel.php');
						<?php
						}else{?>
							$('loader.page',PAGE).hide();
							$("#loading").dialog('close');
							document.location.hash="timeline?current=timeLine";
							$('html, body').animate({scrollTop: 0},"slow");
						<?php } ?>
					}
				},
				complete : function (){
					$('loader.page',PAGE).hide();
				}
			};

			$$("#editTags").ajaxForm(options);
		   }
	  });
});
</script>
<?php
}
?>
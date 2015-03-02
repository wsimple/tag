<?php
include ("../../includes/session.php");
include ("../../includes/functions.php");
include ("../../includes/config.php");
include ("../../class/wconecta.class.php");
include ("../../includes/languages.config.php");

$imagesAllowed=array('jpg','jpeg','png','gif');
?>
<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>
<script type="text/javascript">
	//ScrollPane Favoroites
	$(document).ready(function() {
		//$('#list_templates_<?=str_replace('/','',$_GET[type])?>').jScrollPane();
	});
</script>
<?php }else{ ?>
		<script type="text/javascript" src="js/jscroll.js"></script>
        <script type="text/javascript">
			$(document).ready(function(){
//				var myScroll;
//				function loaded() {
//					setTimeout( function() {
//						 document.ontouchmove = function(e) { }
//								// document.ontouchmove = function(e)
//						myScroll = new iScroll( document.getElementById('list_templates_<?=str_replace('/','',$_GET[type])?>') );
//					}, 100);
//
//				}
//				loaded();
			});
			//window.addEventListener('load', loaded, true);
			</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$( "#tabs" ).tabs({
				select: function(event, ui) {
					var tabID = "#"+ui.panel.id;//"#ui-tabs-" + (ui.index);
					//alert(tabID);
					$(tabID).html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32"/></div>');
				}
		});
	});
</script>
<?php if($_GET[type]==''){?>
	<div id="tabs" style="font-size:11px">
		<ul>
			<li><a href="#tabs-1"><?=TAGSSTORE_LBLTITLETABMYSTUFF?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=defaults"><?=TAGSSTORE_LBLTITLETABDEFAULTS?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=tvAndMovies"><?=TAGSSTORE_LBLTITLETABFILMANDTV?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=Fashion"><?=TAGSSTORE_LBLTITLETABFASHION?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=Abstract"><?=TAGSSTORE_LBLTITLETABABSTRACT?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=Music"><?=TAGSSTORE_LBLTITLETABMUSIC?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=Politics"><?=TAGSSTORE_LBLTITLETABPOLITICS?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=Sports"><?=TAGSSTORE_LBLTITLETABSPORTS?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=holiday"><?=TAGSSTORE_LBLTITLETABHOLLIDAY?></a></li>
			<li><a href="views/tags/templatesAjax.view.php?type=thanksgiven"><?=TAGSSTORE_LBLTITLETABTHANKSGIVEN?></a></li>
		</ul>
		<div id="tabs-1">
  <?php } ?>
			<div style="width:690px;height:300px;<?php if($_SESSION['ws-tags']['ws-user']['fullversion']==1){?>overflow:auto;<?php }?>">
				<div id="list_templates_<?=str_replace('/','',$_GET[type])?>" style="width:690px; <?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){?> height:300px; <?php }?>">
					<ul class="moreTemplates">
					<?php if($_GET[type]==''){
						//users
						$folder=opendirFTP('templates/'.$_SESSION['ws-tags']['ws-user'][code].'/', '../../');
						$blocked=arrayBackgroundsBlocked();
						while($pic=readdirFTP($folder)){
							$args=explode('.',$pic);
							$extension=strtolower(end($args));
							if(in_array($extension,$imagesAllowed)&& !in_array($pic,$blocked)){?>
						<li onclick="$('#templates').dialog('close');$('#imgTemplate').val('<?=$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>'); $('#bckSelected').css('background-image', 'url(<?=FILESERVER.'img/templates/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>)');"  style="background-image:url(includes/imagen.php?ancho=650&tipo=3&img=<?=FILESERVER.'img/templates/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>);"></li>
					<?php	}
						}
					}else{
						if($_GET[type]=='defaults') $_GET[type]=''; else $_GET[type] = $_GET[type].'/';
						//defaults
						$folder=opendir('../../img/templates/defaults/'.$_GET[type]);
						while($pic=readdir($folder)){
							$args=explode('.',$pic);
							$extension=strtolower(end($args));
							if(in_array($extension,$imagesAllowed)){ ?>
						<li onclick="$('#templates').dialog('close'); $('#dialogBck').dialog('close'); $('#imgTemplate').val('defaults/<?=$_GET[type].$pic?>'); $('#html_tag_placa').css('background-image', 'url(<?='img/templates/defaults/'.$_GET[type].$pic?>)');" style="background-image:url(includes/imagen.php?ancho=650&tipo=3&img=<?='../img/templates/defaults/'.$_GET[type].$pic?>);"></li>
							<?php }//if
						}//while
					} ?>
					</ul>
				</div>
			</div>
<?php if($_GET[type]==''){?>
		</div><!--Tab1-->
	</div><!--Tabs-->
 <?php }?>

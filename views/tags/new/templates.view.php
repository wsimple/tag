<?php
	include ("../../../class/Mobile_Detect.php");
	include ("../../../includes/config.php");
	include ("../../../includes/session.php");
	include ("../../../includes/functions.php");
	include ("../../../class/wconecta.class.php");
	include ("../../../includes/languages.config.php");
//	include ("../../../class/validation.class.php");

	if($_SESSION['ws-tags']['ws-user']['fullversion']==1){
		$style1 = 'style="width:520px; height:457px; margin-left: 20px;overflow:auto;"';
	}else{
		$style1 = "";
	}

	if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){
		$style2 = 'style="width:520px; height:auto;"';
	}else{
		$style2 = "";
	}
?>
<div <?=$style1?>>
 <div id="suggest_templates" <?=$style2?>>
    <ul style=" margin:0; padding:0; list-style:none;">
		<?php
             //templates users
			 $imagesAllowed=array('jpg','jpeg','png','gif');
			 $folder = opendirFTP('templates/'.$_SESSION['ws-tags']['ws-user'][code].'/',RELPATH);
			 $contaDeleteTempalte =1;//enumera las templates del usuario
             $blocked=arrayBackgroundsBlocked();
			 while ($pic = readdirFTP($folder)){
				    $args = explode('.',$pic);
				    $extension = strtolower(end($args));
			        if (in_array($extension,$imagesAllowed) && !in_array($pic,$blocked)){
        ?>
						<li id="liTemplate_<?=$contaDeleteTempalte?>" onclick="
							$('#imgTemplate').val('<?=$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>');
							$('#bckSelected').css('background-image', 'url(<?=FILESERVER.'img/templates/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>)');
							$('#dialogBck').dialog('close');"
							style="background-image:url(includes/imagen.php?ancho=505&tipo=3&img=<?=FILESERVER.'img/templates/'.$_SESSION['ws-tags']['ws-user'][code].'/'.$pic?>);background-position:0 50%; height:70px; cursor:pointer; width:505px;">
                            <img id="photoTemplate_<?=$contaDeleteTempalte?>" onclick="if (actionConfirm('<?=INDEX_MSGCONFIRMATIONACTION?>', '<?=INDEX_TITLECONFIRMACIONES?>', '', 'controls/tags/deleteTemplate.php?template=<?=$pic?>|#photoTemplate_<?=$contaDeleteTempalte?>*#liTemplate_<?=$contaDeleteTempalte?>')){}" src="img/delete2.png" title="<?=NEWTAG_HELPDELETEBACKGROUNDTEMPLATE?>" style="float:right; margin-top:2px; margin:1px 20px ; margin-right:10px" width="12" height="12" border="0"  />
                        </li>
		<?php
		             $contaDeleteTempalte++;
					 }//if existe array
			  }//while

              //templates defaults
              $folder = opendir('../../../img/templates/defaults/');

			  while ($pic = readdir($folder)){
				     $args = explode('.',$pic);
					 $extension = strtolower(end($args));
			  if (in_array($extension,$imagesAllowed)){
			  ?>
					 <li onclick="$('#imgTemplate').val('defaults/<?=$pic?>');
								  $('#bckSelected').css('background-image', 'url(<?='img/templates/defaults/'.$pic?>)','background-repeat', 'repeat-x');
								  $('#dialogBck').dialog('close');"
						style="background-image:url(includes/imagen.php?ancho=505&tipo=3&img=<?='../img/templates/defaults/'.$pic?>);background-position:0 50%; height:70px; cursor:pointer;width:505px;">
                        <div class="clear"></div>
                    </li>
              <?php
		             } //if
			  }//while
		      ?>
	</ul>
  </div>
</div>

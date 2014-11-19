<?php 
     if ($_REQUEST['action']=="insert"){
		 if ($_FILES['photo']['error']==0){
			 $imagesAllowed = array('jpg','jpeg');
			 $parts         = explode('.', $_FILES['photo']['name']);
			 $ext           = strtolower(end($parts)); 
			 if (in_array($ext,$imagesAllowed)){
				 $path  = $_REQUEST['path'];       //ruta para crear dir
				 $photo = md5(str_replace(' ', '', $_FILES['photo']['name']).microtime()).'.jpg';
				 //$picture_bd = " ,picture = '".$photo."' ";
				 
				 //existencia de la folder
				 if (!is_dir ($path)){	
					 $old = umask(0);
					 mkdir($path,0777);
					 umask($old);
					 $fp=fopen($path.'index.html',"w");
					 fclose($fp);
				 }// is_dir	
				 if (copy($_FILES['photo']['tmp_name'], $path.$photo)){
					 redimensionar($path.$photo, $path.$photo, 650);
				 }else{  mensajes("file copy error", "?url=".$_REQUEST["url"], "error"); }//copy
			 }else{//extension
				 mensajes("file type error.<br>Extension allowed (jpg)", "?url=".$_REQUEST["url"], "error");
			 }
		 }else{ //$_FILES	
				 mensajes("file type error.<br>Extension allowed (jpg)", "?url=".$_REQUEST["url"], "error");
		 }	 
		 mensajes("Sucessfully Process", "?url=".$_REQUEST["url"], "info");
	 }elseif ($_REQUEST['action']=="delete"){ 
		 @unlink($_REQUEST['path'].$_REQUEST['photo']);
	     //mensajes("Sucessfully Process", "?url=".$_REQUEST["url"], "info");
	 }//action
     $r_url=$_REQUEST["url"];
?>

<form id="fondos" name="fondos" method="post" action="" class="formulario" enctype="multipart/form-data">
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
        <fieldset>
       	    <legend>Backgrounds Manger</legend>
            <table width="680" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr><td class="etiquetas" style="text-align:left">Type:</td></tr>
                <tr>
                    <td><select name="path" id="path" requerido="type">
                        <option value="../img/templates/defaults/Abstract/">Abstract</option>
                        <option value="../img/templates/defaults/Fashion/">Fashion</option>
                        <option value="../img/templates/defaults/Music/">Music</option>
                        <option value="../img/templates/defaults/Politics/">Politics</option>
                        <option value="../img/templates/defaults/tvAndMovies/">tvAndMovies</option>
                        <option value="../img/templates/defaults/Sports/">Sports</option>
                        <option value="../img/templates/defaults/holiday/">Holiday</option>
                        <option value="../img/templates/defaults/thanksgiven/">Thanks Given</option>
                        <option value="../img/templates/defaults/" selected>Defaults</option>
                    </select></td>
                </tr>
                <tr><td class="etiquetas" style="text-align:left">Picture:</td></tr>
                <tr><td><input type="file" name="photo" id="photo"></td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td style="text-align:center">
                    <input type='button' class='boton' name='atras' id='atras' value='Back' onclick='history.back();' />
                    <input type='button' class='boton' name='atras' id='atras' value='Send' onclick='this.form.submit();' />  
                </td></tr>
                <tr>
                    <td class="requeridos"><input name="action" type="hidden" id="action" value="insert">
                    <input type="hidden" name="url" id="url" value="<?=$_REQUEST['url']?>"></td>
                </tr>
                <tr><td class="requeridos">[ &deg; ]&nbsp;Required fields</td></tr>
            </table>
        </fieldset>
        </td>
    </tr>
    <tr>
        <td>
        <fieldset>
       	<legend>List Backgrounds</legend>
            <table width="680" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; font-weight:normal; text-align:left; border:1px solid #FBCBA4; border-bottom:none">
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php
                     $folder = @opendir('../img/templates/defaults/Abstract/');
                     if ($folder){
                        while ($pic = @readdir($folder)){
    					   if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store'){
				?>
                        <tr>
                            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4"><strong>Abstract</strong></td>
                            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">img/templates/defaults/Abstract/</td>
                            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/Abstract/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                            <td style="border-bottom:1px solid #FBCBA4; text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/Abstract/&photo=<?=$pic?>');" /></td>
                        </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                     $folder = @opendir('../img/templates/defaults/Fashion/');
                     if ($folder){
                         while ($pic = @readdir($folder)){
    			     		 if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store'){
				?>
                            <tr>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4"><strong>Fashion</strong></td>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">img/templates/defaults/Fashion/</td>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/Fashion/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                                <td style="border-bottom:1px solid #FBCBA4; text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/Fashion/&photo=<?=$pic?>');" /></td>
                            </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/Music/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
					       if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store'){
				?>
                            <tr>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4"><strong>Music</strong></td>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">img/templates/defaults/Music/</td>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/Music/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                                <td style="border-bottom:1px solid #FBCBA4; text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/Music/&photo=<?=$pic?>');" /></td>
                            </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/Politics/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
        					if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store'){
				?>
                            <tr>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4"><strong>Politics</strong></td>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">img/templates/defaults/Politics/</td>
                                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/Politics/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                                <td style="border-bottom:1px solid #FBCBA4; text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/Politics/&photo=<?=$pic?>');" /></td>
                            </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/tvAndMovies/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
        					if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store'){
				?>
                <tr>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4"><strong>tvAndMovies</strong></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">img/templates/defaults/tvAndMovies/</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/tvAndMovies/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                    <td style="border-bottom:1px solid #FBCBA4; text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/tvAndMovies/&photo=<?=$pic?>');" /></td>
                </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/Sports/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
        					if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store'){
				?>
                <tr>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4"><strong>Sports</strong></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4">img/templates/defaults/Sports/</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/Sports/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                    <td style="border-bottom:1px solid #FBCBA4; text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/Sports/&photo=<?=$pic?>');" /></td>
                </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
        					if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store' && $pic!='Abstract' && $pic!='Fashion' && $pic!='Music' && $pic!='Politics' && $pic!='tvAndMovies'){
				?>
                <tr>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4"><strong>Defaults</strong></td>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4">img/templates/defaults/</td>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                    <td style="border-bottom:1px solid #FBCBA4;text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/&photo=<?=$pic?>');" /></td>
                </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/holiday/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
        					if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store' && $pic!='Abstract' && $pic!='Fashion' && $pic!='Music' && $pic!='Politics' && $pic!='tvAndMovies'){
				?>
                <tr>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4"><strong>Holiday</strong></td>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4">img/templates/defaults/holiday/</td>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/holiday/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                    <td style="border-bottom:1px solid #FBCBA4;text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/holiday/&photo=<?=$pic?>');" /></td>
                </tr>
                <?php       }
                        }
                    } ?>
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="72">Type</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Path</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Picture</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="46">Actions</td>
                </tr>                
                <?php 
                    $folder = @opendir('../img/templates/defaults/thanksgiven/');
                    if ($folder){
                        while ($pic = @readdir($folder)){
        					if ($pic != "." && $pic != ".." && $pic != "Thumbs.db" && trim($pic, ' ') != '' && $pic!='index.html' && $pic!='' && $pic!='.DS_Store' && $pic!='Abstract' && $pic!='Fashion' && $pic!='Music' && $pic!='Politics' && $pic!='tvAndMovies'){
				?>
                <tr>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4"><strong>Thanks Given</strong></td>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4">img/templates/defaults/thanksgiven/</td>
                    <td style="border-bottom:1px solid #FBCBA4;border-right:1px solid #FBCBA4; background-image:url(../includes/imagen.php?ancho=360&tipo=3&img=<?='../img/templates/defaults/thanksgiven/'.$pic?>);background-position:0 50%; height:35px;">&nbsp;</td>
                    <td style="border-bottom:1px solid #FBCBA4;text-align:center"><img src="../img/delete.png" width="14" height="14" border="0" style="cursor:pointer" onClick="confirma('Delete Picture', 'Sure to delete this photo', '?action=delete&url=<?=$r_url?>&path=../img/templates/defaults/thanksgiven/&photo=<?=$pic?>');" /></td>
                </tr>
                <?php       }
                        }
                    } ?>
            </table>
        </fieldset>
        </td>
    </tr>
</table>
</form>



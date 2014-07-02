<?php
	    session_start();

	    include ("../../includes/functions.php");

		if (quitar_inyect()){
			include ("../../includes/config.php");
			include ("../../class/wconecta.class.php");
			include ("../../includes/languages.config.php");
			include ("../../class/class.phpmailer.php");
			include ("../../class/validation.class.php");

            
			$a  = '<a href = "javascript:void(0);" ';
			$a .= 'onfocus = "this.blur();" ';
			$a .= 'title="'.COMMENTS_FLOATHELPLINKLIKES.'" ';
			$a .= 'onclick="viewUserLikedTag(\''.COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG.'\',\'views/tags/viewUserLikedTag.view.php?t='.$_GET[tag].'\');" ';
			$a .= 'style="color:#F58220;font-weight:bold;" ';
			$a .= '>'.numRecord("likes", " WHERE id_source = '".$_GET[tag]."'");
			$a .= '</a>';
			
			echo $a;
			
			
			/*echo '<a href = "javascript:void(0);" 
			         onfocus = "this.blur();" 
							 title="'.COMMENTS_FLOATHELPLINKLIKES.'" 
							 onclick="viewUserLikedTag(\''.COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG.'\',\'views/tags/viewUserLikedTag.view.php?t='.$_GET[tag].'\');" 
							 style="color:#F58220;font-weight:bold;"
						     >'.numRecord("tags_favorites", " WHERE id_tag = '".$_GET[tag]."'").'
						  </a>';*/
			
			
			
			
			
			/*if (existe("tags_favorites", "id_tag", " WHERE  id_tag = '".$_GET[tag]."' AND id_user_fav = '".$_SESSION['ws-tags']['ws-user'][id]."'")){
			   
			   echo '+';
			   
			   $msgBox = '<a href="javascript:void(0);" 
			                 onfocus="this.blur();" 
							 title="'.COMMENTS_FLOATHELPLINKLIKES.'" 
							 onclick="viewUserLikedTag(\''.COMMENTS_TITLEWINDOWEXPLORERUSERLIKESTAG.'\',\'views/tags/viewUserLikedTag.view.php?t='.$_GET[tag].'\');" 
							 style="color:#F58220;font-weight:bold;"
						     >'.numRecord("tags_favorites", " WHERE id_tag = '".$_GET[tag]."'").'
						  </a>';
			
			}else{
			
			   echo '-';
			}*/
			
			
		}


?>
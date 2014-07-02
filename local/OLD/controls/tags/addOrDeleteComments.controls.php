<?php
    
	session_start();
	
	include ("../../includes/functions.php");

	if (quitar_inyect()){	
		
		include ("../../includes/config.php");
		include ("../../class/class.phpmailer.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php");
		include ("../../class/validation.class.php");
				
	    
		if ($_GET[comment]!=''){
			
			$GLOBALS['cn']->query("DELETE FROM tags_comments WHERE md5(id) = '".$_GET[comment]."' ");
			
		}else{
			
			if ($_SESSION['ws-tags']['ws-user'][id]!='' && $_GET['txt']!=''){	
				
				$users = $GLOBALS['cn']->query("SELECT id FROM users WHERE md5(md5(id)) = '".$_GET[from]."'");
				$from  = mysql_fetch_assoc($users);
				
				$users = $GLOBALS['cn']->query("SELECT id FROM users WHERE md5(md5(id)) = '".$_GET[to]."'");
				$to  = mysql_fetch_assoc($users);
			   
			    //cuantos comentarios
			    $cuantos = $GLOBALS['cn']->query("SELECT id_tag FROM tags_comments WHERE id_tag = '".$_GET[tag]."' ");
		
				//insert
				$GLOBALS['cn']->query(" INSERT INTO tags_comments SET 
												   
													id_tag       = '".$_GET[tag]."',
													id_user_from = '".$from[id]."',
													id_user_to   = '".$to[id]."',
													comment      = '".str_replace("|", " ", $_GET[txt])."'
									  ");
									  
			    $id = mysql_insert_id();
			   
			   //agregamos la notificación
			   $notifications = $GLOBALS['cn']->query("SELECT id_user 
			                                           
													   FROM users_notifications 
													   
													   WHERE id_source = '".$_GET[tag]."' AND id_user != '".$from[id]."'
													   
													   GROUP BY id_user 
													 ");

			   if (mysql_num_rows($notifications)>0){
				   
				   while ($notification = mysql_fetch_assoc($notifications)){
						  
						notifications($notification[id_user],$_GET[tag],4);
						  
						$array_froms[] = $notification[id_user];
				   }
				   
				   $dueno = campo("tags", "id", $_GET[tag], "id_user");
				   if (!in_array($dueno, $array_froms) && $to[id] != $from[id]){
				       
					   notifications($dueno,$_GET[tag],4);
						
			   	   }
			   }else{
			         
					 if ($to[id] != $from[id]){//validamos que el remitente sea diferente al destinatario
					 
					   notifications($to[id],$_GET[tag],4);
						
					}
			   
			   }
			   
			   //salida
			   $comments = $GLOBALS['cn']->query(" SELECT c.id_tag AS id_tag,
													   
														  c.id_user_from AS id_from,
													   
														  c.id_user_to AS id_to,
													   
														  c.comment AS comment,
													   
														  c.date AS comment_date,
													   
														  (SELECT concat(u.name,' ',u.last_name) FROM users u WHERE u.id = c.id_user_from)  AS user_from,
													   
														  (SELECT md5(CONCAT(u.id, '_', u.email, '_', u.id)) FROM users u WHERE u.id = c.id_user_from) AS codeUser,
													   
														  (SELECT u.profile_image_url FROM users u WHERE u.id = c.id_user_from) AS photoUser,
													   
														  c.id AS id
														
												
												   FROM tags_comments c 
												
												   WHERE c.id = '".$id."'
											  
												 ");
			   $comment = mysql_fetch_assoc($comments); 
			   $foto_usuario=FILESERVER.getUserPicture($comment['codeUser'].'/'.$comment['photoUser']);
			   $table = "";
			   if (mysql_num_rows($cuantos)==0){
				   $table = '
								<table width="665" border="0" align="center" cellpadding="1" cellspacing="1" id="tableComment" class="table_comments">
								<tr>
								<td colspan="2" height="5"></td>
								</tr>					
							';
			   }//if cuantos
			   
			   $table .=  '
							<tr id="comment_'.$comment[id].'">
							<td width="40" style="padding-left:5px">
							<img class="imgUser"  src="'.$foto_usuario.'" border="0" style="border:1px solid #999; cursor:pointer" title="'.COMMENTS_FLOATHELPVIEWPROFILEUSER.'" width="40" height="40" onclick="userProfile(\''.$comment[user_from].'\', \'Close\', \''.md5($comment[id_from]).'\');"   />
							</td>
							
							<td width="610" valign="top" style="border-bottom:1px solid #F4F4F4">
							<div>
							<img src="img/delete_comment.png" width="8" height="8" style="float:right; margin-right:5px; cursor:pointer" border="0" title="'.COMMENTS_FLOATHELPREMOVECOMMENT.'"  onclick="addOrDeleteComments(\'#comment_'.$comment[id].'\', \'controls/tags/addOrDeleteComments.controls.php?comment='.md5($comment[id]).'\', true);"   />
							<a href="javascript:void(0);" onclick="userProfile(\''.$comment[user_from].'\', \'Close\', \''.md5($comment[id_from]).'\');" onfocus="this.blur();" title="'.COMMENTS_FLOATHELPVIEWPROFILEUSER.'" style="color:#F58220; font-weight:bold; text-decoration:none">'.$comment[user_from].'</a><br />
							'.$comment[comment].'<br />
							<em style="font-size:9px; color:#CCC; float:right; margin-right:5px">'.$comment[comment_date].'</em>
							</div>
							</td>
							</tr>
						  ';
	
			   if (mysql_num_rows($cuantos)==0){
				   $table .= '
								<tr>
								<td colspan="2" height="5"></td>
								</tr>
								</table>							
							';
			   }//if cuantos
	
			   //mostramos el comentario
			   echo $table;
			
			}//if txt
			
		}//else llego comment (delete)
	
	}//if quitar inyect

	 
	 
	 
?>






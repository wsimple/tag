<?php
	    session_start();
		include ("../../includes/functions.php");
		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php"); 

		$comments = $GLOBALS['cn']->query(" SELECT c.id_source AS id_tag,
												   c.id_user_from AS id_from,
												   c.id_user_to AS id_to,
												   c.comment AS comment,
												   c.date AS comment_date,
												   (SELECT concat(u.name,' ',u.last_name) FROM users u WHERE u.id = c.id_user_from)  AS user_from,
												   (SELECT md5(CONCAT(u.id, '_', u.email, '_', u.id)) FROM users u WHERE u.id = c.id_user_from) AS codeUser,
												   (SELECT u.profile_image_url FROM users u WHERE u.id = c.id_user_from) AS photoUser,
												   c.id AS id
											FROM comments c
											WHERE c.id_source = '".$_GET['source']."' AND c.id_type = '".$_GET['type']."'
											ORDER BY c.date
										  ");
										  
	$num_comments = mysql_num_rows($comments);
	
	$role = true; //control para comentarios de tags de grupo
	
	$id_user_to = '';
	
	if (mysql_num_rows($comments)>0){
		
		switch ($id_type){
		        
				case '4' : 
                case '10': 
						//datos de la tag
						$tags = $GLOBALS['cn']->query(" SELECT  t.id_user AS idUser,
                                                                                        t.id_group
                                                                                FROM tags t 
                                                                                WHERE t.id = '".$_GET['source']."'");
						
						$time = @mysql_fetch_assoc($tags);
						
						$id_user_to = md5(md5($time['idUser']));
						
						if ($time[id_group]!=0){
							
							$_GET['current'] = 'groups';
							$role = isInTheGroup(md5($id_grupo));
						
						}
				break;//1
		
		}//switch
		
	}//if hay comments
										  
    while ($comment = mysql_fetch_assoc($comments)){
	$longitud=  strlen($comment['comment']);
    $foto_usuario  = FILESERVER.getUserPicture($comment['codeUser'].'/'.$comment['photoUser'],'img/users/default.png');
?>
    
<tr id="comment_<?=$comment['id']?>">
    <td width="40" style="padding-left:5px;" valign="top">
        <img class="imgUser"  src="<?=$foto_usuario?>" border="0" style="border:1px solid #999; cursor:pointer" title="<?=COMMENTS_FLOATHELPVIEWPROFILEUSER?>" width="40" height="40" onclick="userProfile('<?=$comment['user_from']?>', 'Close', '<?=md5($comment['id_from'])?>');"   />
    </td>

    <td width="610" valign="top" style="border-bottom:1px solid #F4F4F4">

            <?php if ($comment['id_from']==$_SESSION['ws-tags']['ws-user']['id'] || $id_user_to==$_SESSION['ws-tags']['ws-user']['id']){ ?>
            <img src="img/delete_comment.png" width="8" height="8" style="float:right; margin-right:5px; cursor:pointer" border="0" title="<?=COMMENTS_FLOATHELPREMOVECOMMENT?>" onclick="addOrDeleteComments('#comment_<?=$comment['id']?>', 'controls/comments/del.controls.php?c=<?=$comment[id]?>', true); _getNumComments('<?=$id_source?>', '<?=$id_type?>', '#spanViewAllComments'); "  />
            <?php }//validamos la eliminación del comentario ?>

            <a href="javascript:void(0);" onclick="userProfile('<?=$comment['user_from']?>', 'Close', '<?=md5($comment['id_from'])?>');" onfocus="this.blur();" title="<?=COMMENTS_FLOATHELPVIEWPROFILEUSER?>" style="color:#F58220; font-weight:bold; text-decoration:none"><?=$comment['user_from']?></a><br />
            <div style="<?=(($longitud>200)?'height:50px;overflow:hidden;':'height:auto;')?>word-wrap: break-word;float: left; width: 615px;"><?=strToLink($comment['comment'])?></div>
            <?php if($longitud>200){ ?><span style="color:#F58220; text-align: right;font-size: 11px; " action="commentsSeeMore,comment_<?=$comment['id']?>"><?=USER_BTNSEEMORE?></span> <?php } ?>
			<em style="font-size:9px; color:#CCC; float:right; margin-right:5px"><?=$comment['comment_date']?></em>

    </td>
</tr>

<?php }//while ?>